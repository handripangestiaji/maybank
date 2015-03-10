<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class facebook_model extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->load->helper('basic');
       
        $config = array(
             'appId' => $this->config->item('fb_appid'),
             'secret' => $this->config->item('fb_appsecret'),
        );
        $this->load->library('facebook',$config);        
    }
    
    function SetAccessToken($access_token, $page_id){
	$accounts = json_decode(open_api_template('https://graph.facebook.com/me/accounts?access_token='.$access_token));
	if(isset($accounts->data)){
	    foreach($accounts->data as $account){
		if($account->id == $page_id)
		    $this->facebook->setAccessToken($account->access_token);
	    }
	}
    }
    
    function addFacebook($code = null){
	if(!$code) {
            $user = $this->facebook->getUser();
	    if ($user) {
		$logoutUrl = $this->facebook->getLogoutUrl();
	    }else {
		$params = array(
		    'scope' => 'read_stream, manage_pages, publish_stream, read_mailbox, export_stream, publish_checkins, read_insights, read_requests,
			    status_update, photo_upload, email, read_page_mailboxes',
		    'redirect_uri' => base_url('channels/channelmg/AddFacebook')
		);
		$loginUrl = $this->facebook->getLoginUrl($params);
		redirect($loginUrl);
	    }
	}
        else{
	    $access_token = $this->facebook->getAccessTokenFromCode($code, base_url().'channels/channelmg/AddFacebook');
	    $this->facebook->setAccessToken($access_token);
	    $this->session->set_userdata('fb_token', $access_token);
	    $pages = $this->facebook->api('/me/accounts');
	    return $pages;
	}
    }
    
    public function RetrievePost($page_id, $access_token, $isOwnPost = true){
	$this->SetAccessToken($access_token, $page_id);
	$result = $this->facebook->api('/me/posts');
	return $result;
    }
    
    public function RetrieveFeed($page_id, $access_token){
	$this->SetAccessToken($access_token, $page_id);
	$result = $this->facebook->api('/me/feed');
	return $result;
    }
    
    public function RetrieveConversation($page_id, $access_token){
	$this->SetAccessToken($access_token, $page_id);
	$result = $this->facebook->api('/me/conversations');
	return $result;
    }
    
    private function SearchUserFromList($uid, $list){
	for($i=0; $i<count($list); $i++){
	    if(isset($list[$i]->uid)){
		if($list[$i]->uid == $uid)
		    return $list[$i];
	    }
	    else{
		if($list[$i]->page_id == $uid)
		    return $list[$i];
	    }
	}
	return null;
    }
    
    /*
     * Transfer all feed from facebook based on post input
     * $post : post retrieved from facebook
    */
    public function TransferFeedToDb($post, $channel){
	print_r($post);
	for($i=0; $i < count($post); $i++){
	    //echo "<pre>";print_r($post[$i]);echo"</pre>";
	    $this->SavePost($post[$i], $channel);
	}
    }
    
    /*
    * Saving each post to database
    * $each_post : each post from facebook
    * $channel_id : retrieved from which channel stored on db
    */
    public function SavePost($each_post, $channel){
	$this->db->trans_start();
	$timezone = new DateTimeZone("UTC");
	$stream = $this->IsStreamIdExists($each_post->post_id);
	$this->SaveFacebookUser($each_post->users);
	$created_time = new DateTime(date("Y-m-d H:i:s e", $each_post->created_time), $timezone);
	$social_stream = array(
	    "post_stream_id" => $each_post->post_id,
	    "channel_id" => $channel->channel_id,
	    "type" => "facebook",
	    "retrieved_at" => date("Y-m-d H:i:s"),
	    "created_at" => $created_time->format("Y-m-d H:i:s")
	);
	$updated_time = new DateTime(date("Y-m-d H:i:s e", $each_post->updated_time), $timezone);
	
	$breakLine = explode("\n", $each_post->message);
	if(count($breakLine) > 0)
	{
	    $each_post->message = '';
	    foreach($breakLine as $line)
		$each_post->message .= $line.'<br />';
	}
	else{
	    $each_post->message = $each_post->message;
	}
	
	$social_stream_fb_post = array(
	    "post_content" => str_replace("\n", "<br />", $each_post->message),
	    "author_id" => $each_post->actor_id,
	    "attachment" => isset($each_post->attachment) ? json_encode($each_post->attachment) : "",
	    "enggagement_count" => 0,
	    "total_likes" => $each_post->like_info->like_count,
	    "user_likes" => $each_post->like_info->user_likes,
	    "total_shares" =>  $each_post->share_count,
	    "total_comments" => isset($each_post->comments) ? count($each_post->comments) : 0,
	    "updated_at" => $updated_time->format("Y-m-d H:i:s"),
	    "is_customer_post" => $channel->social_id == $each_post->actor_id ? 0 : 1
	);
	
	if($each_post->message != '' && $each_post->message != null){
	    if($stream == null){
		$this->db->insert("social_stream", $social_stream);
		$insert_id = $this->db->insert_id();
		$social_stream_fb_post['post_id'] = $insert_id;
		$this->db->insert("social_stream_fb_post", $social_stream_fb_post);
		$this->SocialStreamCountUpdate($insert_id);
		
		print_r($insert_id);
		
	    }
	    else{
		$insert_id = $stream->post_id;
		$this->db->where("post_id", $stream->post_id);
		$this->db->update("social_stream_fb_post", $social_stream_fb_post);
		
	    }
	}
	else
	    return;
	
	if(isset($each_post->comments)){
	    for($x=0; $x < count($each_post->comments); $x++){
		$updated_time = new DateTime(date("Y-m-d H:i:s e", $each_post->comments[$x]->time), $timezone);
		$this->SaveFacebookUser($each_post->comments[$x]->user);
		$social_stream_comment = array(
		    "post_stream_id" => $each_post->comments[$x]->id,
		    "channel_id" => $channel->channel_id,
		    "type" => "facebook_comment",
		    "retrieved_at" => date("Y-m-d H:i:s"),
		    "created_at" => $updated_time->format("Y-m-d H:i:s")
		);
		
		$breakLine = explode("\n", $each_post->comments[$x]->text);
		if(count($breakLine) > 1)
		{
		    $each_post->comments[$x]->text = '';
		    foreach($breakLine as $line)
			$each_post->comments[$x]->text .= $line.'<br />';
		}
		
		$social_stream_fb_comments = array(
		    "post_id" => $insert_id,
		    "attachment" => json_encode($each_post->comments[$x]->attachment), 
		    "from" => $each_post->comments[$x]->fromid,
		    "comment_stream_id" => $each_post->comments[$x]->id,
		    "comment_content" => $each_post->comments[$x]->text,
		    "comment_id" => $each_post->comments[$x]->parent_id,
		    "created_at" => $updated_time->format("Y-m-d H:i:s"),
		    "retrieved_at" => date("Y-m-d H:i:s")
		);
		
		if($this->IsCommentExists($each_post->comments[$x]->id) == null){
		    
		    $this->db->insert('social_stream', $social_stream_comment);
		    $insert_id_comment = $this->db->insert_id();
		    $social_stream_fb_comments['id'] = $insert_id_comment;
		    $this->db->insert("social_stream_fb_comments", $social_stream_fb_comments);
		    if($stream != null){
			$this->SocialStreamCountUpdate($stream->post_id);
			print "<pre>";
	
			print_r($stream);print "</pre>";
		    }
		}
		else{
		    $this->db->where('post_stream_id', $each_post->comments[$x]->id);
		    $this->db->update("social_stream", $social_stream_comment);
		    $this->db->where('comment_stream_id', $each_post->comments[$x]->id);
		    $this->db->update("social_stream_fb_comments", $social_stream_fb_comments);

		}
	    }
	}
	$this->db->trans_complete();
    }
    
    public function SaveUserFromFacebook($userid, $access_token){
	$timezone = new DateTimeZone("UTC");
	if(!$this->IsFbUserExists($userid)){
	    $fql = "select uid, name, sex from user where uid = $userid";
	    $requestResult = curl_get_file_contents('https://graph.facebook.com/fql?q='.urlencode($fql)."&access_token=".$access_token->token);
	    $requestResult = json_decode($requestResult);
	    if(count($requestResult->data) > 0)
	    {
		$fbuser = $requestResult->data[0];
		$currentTime = new DateTime(date('Y-m-d H:i:s e'), $timezone);
		$fb_user_to_save = array(
		    "facebook_id" => $fbuser->uid,
		    "name" => $fbuser->name,
		    "sex" => isset($fbuser->sex) ? substr($fbuser->sex, 0, 1) : NULL,
		    "created_at" => $currentTime->format("Y-m-d H:i:s"),
		    "retrieved_at" => $currentTime->format("Y-m-d H:i:s"),
		    "username" => NULL
		);
		print_r($fbuser);
		print_r($fb_user_to_save);
		$this->db->insert('fb_user_engaged', $fb_user_to_save);
		return $this->db->insert_id();
	    }
	}
	else{
	    return null;
	}
    }
    
    
    public function SaveNewConversation($conversation, $channel, $access_token){
	$timezone = new DateTimeZone("UTC");
	foreach($conversation as $each_conversation){
	    $this->db->trans_start();
	    
	    /*Save User*/
	    
	    foreach($each_conversation->participants->data as $user){
		$this->SaveUserFromFacebook($user->id, $access_token);
	    }
	    
	    $stream = $this->IsStreamIdExists($each_conversation->id, "facebook_conversation");
	    $updated_time = new DateTime($each_conversation->updated_time);
	    $social_stream = array(
		"post_stream_id" => $each_conversation->id,
		"channel_id" => $channel->channel_id,
		"type" => "facebook_conversation",
		"retrieved_at" => date("Y-m-d H:i:s"),
		"created_at" => $updated_time->format("Y-m-d H:i:s"),
	    );
	    
	    $social_stream_facebook_conversation = array(
		"message_count" => $each_conversation->message_count,
		"snippet" => $each_conversation->snippet,
		"unread_count" => 0,
		"status" => 1,
		"updated_time" => $updated_time->format("Y-m-d H:i:s")
	    );
	    
	    if($stream != null){
		$old_social_stream_facebook_conversation = $this->IsFacebookConversation($stream->post_id);
		if($old_social_stream_facebook_conversation->message_count <  $each_conversation->message_count)
		    $social_stream['is_read'] = 0 ;
		$this->db->where('post_id', $stream->post_id);
		$this->db->update('social_stream', $social_stream);
		$this->db->where('conversation_id', $stream->post_id);
		$this->db->update('social_stream_facebook_conversation', $social_stream_facebook_conversation);
	    }
	    else{
		$this->db->insert('social_stream', $social_stream);
		$stream = new stdClass();
		$stream->post_id = $this->db->insert_id();
		$social_stream_facebook_conversation['conversation_id'] = $stream->post_id;
		$this->db->insert('social_stream_facebook_conversation', $social_stream_facebook_conversation);
	    }
	    
	    foreach($each_conversation->messages->data as $conversation_detail){
		$detail = $this->IsConversationDetailExists($conversation_detail->id);
		$breakLine = explode("\n", $conversation_detail->message);
		if(count($breakLine) > 1)
		{
		    $conversation_detail->message = '';
		    foreach($breakLine as $line)
			$conversation_detail->message .= $line.'<br />';
		}
		$created_time = new DateTime($conversation_detail->created_time);
		$social_stream_facebook_conversation_detail = array(
		    "attachment" => isset($conversation_detail->attachments) ? json_encode($conversation_detail->attachments) : '',
		    "detail_id_from_facebook"  => $conversation_detail->id,
		    "messages" => $conversation_detail->message,
		    "sender" => $conversation_detail->from->id,
		    "to" => $conversation_detail->to->data[0]->id,
		    "created_at" =>$created_time->format('Y-m-d H:i:s'),
		    "conversation_id" => $stream->post_id
		);
		if($detail != null){
		    $this->db->where("detail_id", $detail->detail_id);
		    $this->db->update("social_stream_facebook_conversation_detail", $social_stream_facebook_conversation_detail);
		}
		else{
		    if($this->IsFbUserExists($social_stream_facebook_conversation_detail['sender']) && $this->IsFbUserExists($social_stream_facebook_conversation_detail['to'])){
			$this->db->insert("social_stream_facebook_conversation_detail", $social_stream_facebook_conversation_detail);
		    }
		}
		
	    }
	    $this->db->trans_complete();
	}
    }
    
    
    public function SaveConversation($conversation, $channel){
	$timezone = new DateTimeZone("UTC");
	foreach($conversation as $each_conversation){
	    $this->db->trans_start();
	    $stream = $this->IsStreamIdExists($each_conversation->thread_id, "facebook_conversation");
	    $social_stream = array(
		"post_stream_id" => $each_conversation->thread_id,
		"channel_id" => $channel->channel_id,
		"type" => "facebook_conversation",
		"retrieved_at" => date("Y-m-d H:i:s"),
		"created_at" => date("Y-m-d H:i:s", $each_conversation->updated_time)
	    );
	    
	    $social_stream_facebook_conversation = array(
		"message_count" => $each_conversation->message_count,
		"snippet" => $each_conversation->snippet,
		"unread_count" => $each_conversation->unread,
		"status" => 1,
		"updated_time" => date("Y-m-d H:i:s", $each_conversation->updated_time)
	    );
	    
	    if($stream != null){
		$this->db->where('post_id', $stream->post_id);
		$social_stream['is_read'] = 0;
		$this->db->update('social_stream', $social_stream);
		$this->db->where('conversation_id', $stream->post_id);
		$this->db->update('social_stream_facebook_conversation', $social_stream_facebook_conversation);
	    }
	    else{
		$this->db->insert('social_stream', $social_stream);
		$stream = new stdClass();
		$stream->post_id = $this->db->insert_id();
		$social_stream_facebook_conversation['conversation_id'] = $stream->post_id;
		$this->db->insert('social_stream_facebook_conversation', $social_stream_facebook_conversation);
	    }

	    foreach($each_conversation->detail as $conversation_detail){
		$detail = $this->IsConversationDetailExists($conversation_detail->message_id);
		$this->SaveFacebookUser($conversation_detail->viewer);
		$this->SaveFacebookUser($conversation_detail->author);
		$breakLine = explode("\n", $conversation_detail->body);
		if(count($breakLine) > 1)
		{
		    $conversation_detail->body = '';
		    foreach($breakLine as $line)
			$conversation_detail->body .= $line.'<br />';
		}
		$social_stream_facebook_conversation_detail = array(
		    "attachment" => json_encode($conversation_detail->attachment),
		    "detail_id_from_facebook"  => $conversation_detail->message_id,
		    "messages" => $conversation_detail->body,
		    "sender" => $conversation_detail->author_id,
		    "to" => $conversation_detail->viewer_id,
		    "created_at" =>date('Y-m-d H:i:s', $conversation_detail->created_time),
		    "conversation_id" => $stream->post_id
		);
		if($detail != null){
		    $this->db->where("detail_id", $detail->detail_id);
		    $this->db->update("social_stream_facebook_conversation_detail", $social_stream_facebook_conversation_detail);
		}
		else{
		    if($this->IsFbUserExists($social_stream_facebook_conversation_detail['sender']) && $this->IsFbUserExists($social_stream_facebook_conversation_detail['to'])){
			$this->db->insert("social_stream_facebook_conversation_detail", $social_stream_facebook_conversation_detail);
		    }
		}
	    }
	    $this->db->trans_complete();
	    
	}
    }
    
    
    
    /* Save facebook user to databases
     * $user : parsed user object from feeds
    */
    public function SaveFacebookUser($user){
	if($user != null){
	    if(isset($user->uid)){
		if(!$this->IsFbUserExists($user->uid)){
		    $timezone = new DateTimeZone("Asia/Kuala_Lumpur");
		    $currentTime = new DateTime(date('Y-m-d H:i:s e'), $timezone);
		    $this->db->insert('fb_user_engaged', array(
			"facebook_id" => $user->uid,
			"name" => $user->name,
			"sex" => isset($user->sex) ? $user->sex : "",
			"created_at" => $currentTime->format("Y-m-d H:i:s"),
			"retrieved_at" => $currentTime->format("Y-m-d H:i:s"),
			"username" => $user->username
		    ));
		}
	    }
	    else{
		if(!$this->IsFbUserExists($user->page_id)){
		    $timezone = new DateTimeZone("Asia/Kuala_Lumpur");
		    $currentTime = new DateTime(date('Y-m-d H:i:s e'), $timezone);
		    $this->db->insert('fb_user_engaged', array(
			"facebook_id" => $user->page_id,
			"name" => $user->name,
			"sex" => isset($user->sex) ? $user->sex : "",
			"created_at" => $currentTime->format("Y-m-d H:i:s"),
			"retrieved_at" => $currentTime->format("Y-m-d H:i:s"),
			"username" => $user->username
		    ));
		}
	    }
	}
    }
    
    
    /* Check facebook user whether he is exists on database
     * fb_id : facebook id of user comment or like to fanpage
    */
    public function IsCommentExists($comment_id){
	$this->db->select("*");
	$this->db->from("social_stream_fb_comments");
	$this->db->where("comment_stream_id",$comment_id);
	return $this->db->get()->row();
    }
    
    
    
    public function IsPmExists($pm_id){
	$this->db->select("*");
	$this->db->from("social_stream_facebook_conversation");
	$this->db->where("conversation_id",$pm_id);
	return $this->db->get()->row();
    }
        
    public function streamId($post_id){
        $this->db->select('*');
	    $this->db->from('social_stream');
	    $this->db->where('post_id',$post_id);
        return $this->db->get()->row();
    }
    
    public function IsFbUserExists($fb_id, $isRow = false){
	$this->db->select('*');
	$this->db->from('fb_user_engaged');
	$this->db->where('facebook_id',$fb_id);
	if(!$isRow)
	    return $this->db->get()->row() != null;
	else
	    return $this->db->get()->row();
    }
    
    public function IsStreamIdExists($stream_id){
	$this->db->select("post_id");
	$this->db->from("social_stream");
	$this->db->where(array(
	    "post_stream_id" => $stream_id
	));
	return $this->db->get()->row();
    }
    
    public function IsConversationDetailExists($detail_id_from_facebook){
	$this->db->select("detail_id");
	$this->db->where("detail_id_from_facebook", $detail_id_from_facebook);
	$this->db->from("social_stream_facebook_conversation_detail");
	return $this->db->get()->row();
    }
    
    
    
    function GetChannelAction($filter, $is_where_in = false){
	$this->db->select("a.*, b.username, b.display_name, c.message as page_reply_content, d.messages, d.assign_to, e.display_name as assign_name, f.display_name as solved_name, d.solved_message");
        $this->db->from("channel_action a INNER JOIN
			user b on b.user_id = a.created_by LEFT JOIN
			page_reply c on c.created_at = a.created_at AND
			c.social_stream_post_id = a.post_id LEFT JOIN
			`case` d on d.case_id = a.case_id LEFT JOIN
			user e on e.user_id = d.assign_to LEFT JOIN
			user f on f.user_id = d.solved_by");
	$this->db->order_by('a.id','desc');
	if(!$is_where_in)
	    $this->db->where($filter);
	else
	    $this->db->where_in('a.post_id',$filter);
	$result = $this->db->get()->result();
	return $result;
    }
    
    function GetChannelActionPM($filter, $is_where_in = false){

	$this->db->select("a.*, b.username, b.display_name, c.MESSAGES, d.messages, d.assign_to, 
			   e.display_name AS assign_name, f.display_name AS solved_name,d.solved_message");
	$this->db->from("channel_action a INNER JOIN
			`user` b ON b.user_id = a.created_by LEFT JOIN
			`social_stream_facebook_conversation_detail` c ON c.detail_id = a.post_id AND
			c.created_at = a.created_at LEFT JOIN
			`case` d ON d.case_id = a.case_id LEFT JOIN
			`user` e ON e.user_id = d.assign_to LEFT JOIN
			`user` f ON f.user_id = d.solved_by");
	$this->db->order_by('a.id','desc');
	if(!$is_where_in)
	    $this->db->where($filter);
	else
	    $this->db->where_in('a.post_id',$filter);
        return $this->db->get()->result();
    }
    
    
    public function RetrieveFeedFB($filter,$limit = 20,$is_limit = true, $only_assign_case = false){
        $this->db->distinct();
        $this->db->select('a.*, `b`.*, `c`.*,  c.type as social_stream_type, b.post_id as social_stream_post_id,b.post_id, c.created_at as post_date, e.country_code');
        $this->db->from("   fb_user_engaged a INNER JOIN 
                            social_stream_fb_post b  ON b.author_id = a.facebook_id inner join 
                            social_stream c on c.post_id = b.post_id inner join channel e on e.channel_id = c.channel_id");
	
	if($is_limit){
	    $this->db->limit($limit);
	}
	if(isset($filter['channel_id'])){
	    $filter['c.channel_id'] = $filter['channel_id'];
	    unset($filter['channel_id']);
	    $filter['c.is_deleted'] = 0;
	}
        $this->db->order_by('b.updated_at','desc');
        $this->db->order_by('c.created_at','desc');
        $this->db->order_by('c.replied_count','desc');
        if(count($filter) >= 1){
	    $filter['is_deleted'] = 0;
            $this->db->where($filter);
        }
	if($only_assign_case == TRUE )
	    $this->db->where('b.post_id IN (Select post_id from `case`)');
        $result = $this->db->get()->result();
        
        $my_user_id=$this->session->userdata('user_id');                                
        foreach($result as $row){
	    $row->case = $this->case_model->LoadCase(array('a.post_id' => $row->social_stream_post_id));
	    $row->page_reply = $this->PageReply(array('social_stream_post_id' => $row->social_stream_post_id));
	    $row->sender = $this->IsFbUserExists($row->facebook_id, true);
	    $row->comments = $this->RetriveCommentPostFb(array('a.post_id'=> $row->social_stream_post_id), array());
	    $where_in = array($row->social_stream_post_id);
	    foreach($row->comments as $comment)
		$where_in[] = $comment->comment_post_id;
	    $row->channel_action = $this->GetChannelAction($where_in, true);
        }
        
        return $result;
    }
    
    public function CountFeedFB($filter){
        $this->db->select('count(b.post_id) as count_post_id');
        $this->db->from("fb_user_engaged a INNER JOIN social_stream_fb_post b  
			 ON b.author_id = a.facebook_id inner join social_stream c on c.post_id = b.post_id LEFT JOIN
                         `case` d on d.post_id = c.post_id ");
        $this->db->order_by('c.created_at','desc');
        if(count($filter) >= 1)
            $this->db->where($filter);
            
        return $this->db->get()->result();
    }
    
    public function RetrievePostFB($filter){
        $this->db->select('*, c.type as social_stream_type, a.post_id as social_stream_post_id');
        $this->db->from("fb_user_engaged a INNER JOIN social_stream_fb_post b ON b.author_id=a.facebook_id
			inner join social_stream c on c.post_id = b.post_id LEFT JOIN
                        `case` d on d.post_id = c.post_id AND d.status='pending' ");
	$filter['is_deleted'] = 0;
        if(count($filter) > 0)
	    $this->db->where($filter);
           
        $this->db->limit(20);
        $this->db->order_by('c.replied_count','desc');
        $this->db->order_by('c.created_at','desc');
        return $this->db->get()->result();
    }
    
    public function RetriveCommentPostFb($filter,$in){
        $this->db->select("a.post_id,a.post_content,a.total_comments,b.comment_stream_id,b.attachment,b.from,c.name,b.comment_content,b.created_at, b.user_likes, d.post_stream_id,b.comment_id,e.post_id AS comment_post_id, b.id,e.type as type_stream, e.type as social_stream_type, e.post_id as social_stream_post_id, e.type");
        $this->db->from("social_stream_fb_post a INNER JOIN
                social_stream_fb_comments b ON b.post_id=a.post_id INNER JOIN
                fb_user_engaged  c ON c.facebook_id=b.from INNER JOIN social_stream d on d.post_id = b.id LEFT OUTER JOIN
                social_stream e ON e.post_stream_id=b.comment_stream_id");      
        if(count($filter) > 0){
	    $filter['e.is_deleted'] = 0;
	    $this->db->where($filter);
        }
        if(count($in) > 0){
	    $this->db->where_in('b.from',$in);
	    $filter['e.is_deleted'] = 0;
	    $this->db->where($filter);
        }
        
        $this->db->order_by('b.id','desc');
        return $this->db->get()->result();
    }
    
    public function RetrievePmFB($filter = array() ,$limit = null, $only_assign_case = false){
	$this->db->_protect_identifiers = false;
        $this->db->select("a.*, c.is_read, c.post_stream_id, c.type, c.type AS social_stream_type, d.country_code,
                          c.channel_id, c.post_id, c.created_at AS post_date, a.conversation_id AS social_stream_post_id, d.social_id");
        $this->db->from("social_stream_facebook_conversation a INNER JOIN
            	social_stream  c ON c.post_id=a.conversation_id inner join channel d on d.channel_id = c.channel_id");
	if(isset($filter['channel_id'])){
	    $filter['c.channel_id'] = $filter['channel_id'];
	    unset($filter['channel_id']);
	}
        if(count($filter) > 0){
	    $this->db->where($filter);
        }
    	if($limit != null){
    	    $this->db->limit($limit);
    	}
	if($only_assign_case == TRUE )
	    $this->db->where('c.post_id IN (Select post_id from `case`)');
	$this->db->order_by('a.updated_time','desc');
	$result= $this->db->get()->result();
	
	foreach($result as $row){
	    $row->conversation_detail = $this->RetrievePmDetailFB(array('a.conversation_id' => $row->conversation_id));
	    $row->case = $this->case_model->LoadCase(array('a.post_id' => $row->post_id));
	    $row->participant = $this->ParticipantConversation($row->conversation_id);
	    $row->page_reply = $this->PageReply(array('social_stream_post_id' => $row->post_id));
	    $row->channel_action = $this->GetChannelActionPM(array('a.post_id' => $row->post_id));
	}
        return $result;
    }
    
    public function CountPmFB($filter, $only_assign_case = false){
        $this->db->select('count(a.conversation_id) as count_post_id');
        $this->db->from("social_stream_facebook_conversation a LEFT OUTER JOIN 
                        social_stream d ON d.post_id = a.conversation_id inner join channel c
			on c.channel_id = d.channel_id");
	if(count($filter) > 0){
	    $this->db->where($filter);
	}
	if($only_assign_case == TRUE )
	    $this->db->where('d.post_id IN (Select post_id from `case`)');
        $this->db->order_by('created_at','desc');
        return $this->db->get()->result();
    }
    
    public function RetrievePmDetailFB($filter){
        $this->db->select("a.*,b.messages AS comment_content,b.*,c.name,c.username,d.channel_id,d.type,d.is_read, d.type as social_stream_type, d.post_id");
        $this->db->from("social_stream_facebook_conversation a LEFT OUTER JOIN 
                        social_stream_facebook_conversation_detail b ON b.conversation_id = a.conversation_id LEFT OUTER JOIN
                        fb_user_engaged c ON c.facebook_id=b.sender LEFT OUTER JOIN
                        social_stream d ON d.post_id=b.conversation_id inner join channel e on e.channel_id = d.channel_id");
         if(count($filter) > 0){
	    $this->db->where($filter);
        }
        $this->db->order_by('created_at','desc');
        return $this->db->get()->result();
    }
    
    public function ParticipantConversation($conversation_id){
	$query = "SELECT distinct sender, `to` FROM `social_stream_facebook_conversation_detail` where conversation_id = $conversation_id limit 1";
	$row = $this->db->query($query)->row();
	
	if($row != null){
	    $row->sender = $this->IsFbUserExists($row->sender, true);
	    $row->to = $this->IsFbUserExists($row->to, true);
	}
	return $row;
	
    }
    
    public function PageReply($filter = array()){
	$this->db->select("*");
	$this->db->from("page_reply");
	$this->db->where($filter);
	$this->db->order_by('created_at', 'desc');
	$result = $this->db->get()->result();
	foreach($result as $row)
	    $row->user = $this->case_model->ReadAllUser(array('user_id'=>$row->user_id));
	    
	return $result;
    }
    
    public function likePost($post_id, $access_token, $type = 'feed'){
        $requestResult = curl_get_file_contents('https://graph.facebook.com/32423425 453423/likes');
        $result  = json_decode($requestResult);
    }
    
    public function FbRelatedConversation($filter,$sender){

        $sql="SELECT * FROM ((SELECT `a`.`post_id`, `a`.`post_content`,`b`.`comment_stream_id`, 
                        	`b`.`from`,`c`.`name`,`b`.`comment_content`, 
                        	`b`.`created_at`,`b`.`user_likes`,`d`.`post_stream_id`, 
                        	`e`.`post_id` AS comment_post_id,e.channel_id,e.type
                        FROM (`social_stream_fb_post` a INNER JOIN
                         social_stream_fb_comments b ON b.post_id=a.post_id INNER JOIN
                         fb_user_engaged c ON c.facebook_id=b.from INNER JOIN social_stream d ON d.post_id = b.id LEFT OUTER JOIN
                         social_stream e ON e.post_stream_id=b.comment_stream_id)
                        WHERE ".$filter."
                        ORDER BY `a`.`post_id` DESC
                        LIMIT 20)
                        UNION
                        (SELECT	a.conversation_id AS post_id, a.snippet AS post_content, b.detail_id_from_facebook,
                        	b.sender, `c`.`name`, b.messages AS comment_post_content,
                        	`b`.`created_at` AS post_date, NULL AS user_likes,`d`.`post_stream_id`,
                        	`b`.`detail_id` AS comment_post_id, d.channel_id, d.type
                        FROM (`social_stream_facebook_conversation` a LEFT OUTER JOIN 
                         social_stream_facebook_conversation_detail b ON b.conversation_id = a.conversation_id LEFT OUTER JOIN
                         fb_user_engaged c ON c.facebook_id=b.sender INNER JOIN 
                         social_stream d ON d.post_id=b.conversation_id LEFT OUTER JOIN
                         `case` e ON e.post_id=d.post_id AND e.status='pending')
                        WHERE `detail_id_from_facebook` NOT LIKE '%_0' AND b.sender = ".$sender."
                        ORDER BY `b`.`created_at` DESC, `b`.`created_at` DESC, `d`.`replied_count` DESC)) AS related
                        ORDER BY related.created_at DESC ";
        $query = $this->db->query($sql);      
        
        return $query->result();
    }

    public function ReadUnread($post_id, $new_val = null){
	if($new_val == null || $new_val == 0){
	    $this->db->select('*');
	    $this->db->from('social_stream');
	    $this->db->where('post_id',$post_id);
	    $val = $this->db->get()->row();
	    if($val->is_read == 0){
		$new_val = 1;
	    }
	    else{
		$new_val = 0;
	    }
	}
	$data = array(
               'is_read' => $new_val,
            );
    
	$this->db->where('post_id', $post_id);
	$this->db->update('social_stream', $data);
	return $new_val;
    }
    
    public function ReadSocialStream($filter){
	$this->db->select("*");
	$this->db->from('social_stream');
	$this->db->where($filter);
	$result = $this->db->get()->result();
	foreach($result as $row){
	    $this->db->select("*");
	    $this->db->from('channel');
	    $this->db->where('channel_id', $row->channel_id);
	    $row->channel = $this->db->get()->row();
	}
	return $result;
    }
    
    public function SocialStreamCountUpdate($post_id){
	$max_reply = $this->db->query("Select max(replied_count) as replied_count from social_stream");
	$max_reply = $max_reply->row();
	$this->db->query("update social_stream set replied_count = ".$max_reply->replied_count." + 1 where post_id = $post_id");
    }
    
    
    function DeletePostFb($post_id, $channel_id, $user_id, $parent_post = NULL){
        $this->db->trans_start();
        $limit=1;
	
        $channel_action = array(
            'action_type' => "facebook_delete",
            'channel_id' => $channel_id,
            'created_at' => date("Y-m-d H:i:s"),
            'post_id' => $parent_post != NULL ? $parent_post->post_id : $post_id,
            'created_by' => $user_id,
            'log_text' => "Delete Post"
        );
      //  print_r($data);
        $this->db->insert('channel_action', $channel_action);
        $this->db->where(array(
            'post_id' => $post_id,
        ));        
        $return = $this->db->update('social_stream', array('is_deleted' => 1));
        $this->db->trans_complete();
        return $return;
    }
    
    public function GetFbCommentDetail($filter){
	$this->db->select("*");
	$this->db->from('social_stream_fb_comments');
	$this->db->where($filter);
	$result = $this->db->get()->result();
	return $result;
    }
    
    function IsFacebookConversation($stream_id){
	$this->db->select("*");
	$this->db->from("social_stream_facebook_conversation");
	$this->db->where('conversation_id', $stream_id);
	return $this->db->get()->row();
    }
    
    public function GetCommentsInComment($filter){
	$this->db->select("a.post_id,a.post_content,a.total_comments,b.comment_stream_id,b.attachment,b.from,c.name,b.comment_content,b.created_at, b.user_likes, d.post_stream_id,b.comment_id,e.post_id AS comment_post_id, b.id,e.type as type_stream, f.id as page_reply_id, g.display_name as page_reply_name");
	$this->db->from("social_stream_fb_post a INNER JOIN
	    social_stream_fb_comments b ON b.post_id=a.post_id INNER JOIN
	    fb_user_engaged  c ON c.facebook_id=b.from INNER JOIN social_stream d on d.post_id = b.id LEFT OUTER JOIN
	    social_stream e ON e.post_stream_id=b.comment_stream_id LEFT OUTER JOIN
	    page_reply f ON f.message=b.comment_content LEFT OUTER JOIN
	    user g ON f.user_id=g.user_id");
	$this->db->where($filter);
	$this->db->order_by('b.created_at');
	return $this->db->get()->result();
    }
    
    public function GetCommentsGroupedByPostId($filter){
	$this->db->select("a.post_id");
	$this->db->from("social_stream a INNER JOIN
	    social_stream_fb_comments b ON b.post_id=a.post_id INNER JOIN
	    social_stream_fb_post c ON c.post_id = a.post_id");
	$this->db->where($filter);
	$this->db->group_by('a.post_id');
	return $this->db->get()->result();
    }
}
