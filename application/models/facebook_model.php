<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class facebook_model extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->load->helper('basic');
    }
    
    /*
     * Get Access Token for page from user 'access_token'
     * page_id : page stream to be retrieved
     * access_token : user access token
     */
    function GetPageAccessToken($access_token, $page_id){
	$accounts = json_decode(open_api_template('https://graph.facebook.com/me/accounts?access_token='.$access_token));
	if(isset($accounts->data)){
	    foreach($accounts->data as $account){
		if($account->id == $page_id)
		    return $account->access_token;
	    }
	}
    }
    
    /**
	* Retrieve feed/private message from facebook based on page_id provided
	* $page_id:  id of pages which is retrieved
	* $access_token: current access_token to manage application
	* $type : feed or conversations others input will be denied.
	*
	* @return array feed collection
        * @author Eko Purnomo
    */
    public function RetrieveFeed($page_id, $access_token, $type = 'feed', $isOwnPost = false){
	
        $fql = '{"query1":"SELECT post_id, actor_id, share_count, attachment, share_count, updated_time, message,like_info, comment_info, message_tags FROM stream WHERE source_id = '.$page_id.
	' AND actor_id  <> '.$page_id.' order by updated_time desc LIMIT 50",'.
        '"query2" : "SELECT id,post_id, comment_count, text, time, fromid, attachment FROM comment WHERE post_id in (Select post_id from #query1 where comment_info.comment_count > 0) ",'.
        '"query3" : "Select uid, name, username from user where uid in (select actor_id from #query1) or uid in (select fromid from #query2)",'.
        '"query4" : "Select page_id, name, username from page where page_id in (select actor_id from #query1) or page_id in (select fromid from #query2)"'.
        '}';
        
        $requestResult = curl_get_file_contents('https://graph.facebook.com/fql?q='.urlencode($fql)."&access_token=".$access_token);
        $result  = json_decode($requestResult);
        
        $postList = $result->data[0]->fql_result_set;
        $comment = $result->data[1]->fql_result_set;
        $page_list = $result->data[3]->fql_result_set;
        $user_list = $result->data[2]->fql_result_set;
        for($i=0;$i<count($postList);$i++){
            for($x=0; $x < count($comment); $x++){
                if($comment[$x]->post_id == $postList[$i]->post_id)
                    $postList[$i]->comments[] = $comment[$x];
            }
            for($x=0; $x < count($user_list); $x++){
                if($user_list[$x]->uid == $postList[$i]->actor_id){
		    
                    $postList[$i]->users = $user_list[$x];
                }
            }
            
            for($x=0; $x < count($page_list); $x++){
                if($page_list[$x]->page_id == $postList[$i]->actor_id)
                    $postList[$i]->users = $page_list[$x];
            }
        }
        return $postList;
    }
    /**
	* Retrieve maybank post from facebook based on page_id provided
	* $page_id:  id of pages which is retrieved
	* $access_token: current access_token to manage application
	*
	* @return array feed collection
        * @author Eko Purnomo
    */
    public function RetrievePost($page_id, $access_token, $isOwnPost = true){
	 $fql = '{"query1":"SELECT share_count, attachment, post_id, actor_id, share_count, updated_time, message,like_info, comment_info, message_tags, created_time FROM stream WHERE source_id = '.$page_id.
	' AND actor_id '.($isOwnPost ? " = " : " <> " ).$page_id.' order by updated_time desc LIMIT 50",
        "query2" : "SELECT id,post_id, comment_count, parent_id, text, time, likes, attachment, fromid FROM comment WHERE post_id in (Select post_id from #query1 where comment_info.comment_count > 0) ",
        "query3" : "Select uid, name, username,sex from user where uid in (select actor_id from #query1) or uid in (select fromid from #query2)",
        "query4" : "Select page_id, name, username from page where page_id in (select actor_id from #query1) or page_id in (select fromid from #query2)"
        }';
	$requestResult = curl_get_file_contents('https://graph.facebook.com/fql?q='.urlencode($fql)."&access_token=".$access_token);
	$result  = json_decode($requestResult);
	if(is_array($result->data)){
	    
	    $postList = $result->data[0]->fql_result_set;
	    $comment = $result->data[1]->fql_result_set;
	    $page_list = $result->data[3]->fql_result_set;
	    $user_list = $result->data[2]->fql_result_set;
	    
	    for($i=0;$i<count($postList);$i++){
		
		for($x=0; $x < count($comment); $x++){
		    $user = $this->SearchUserFromList($comment[$x]->fromid, $user_list);
		    $user = $user == null ? $this->SearchUserFromList($comment[$x]->fromid, $page_list) : $user;
		    if($comment[$x]->post_id == $postList[$i]->post_id){
			$comment[$x]->user = $user;
			$postList[$i]->comments[] = $comment[$x];
		    }
		}
		for($x=0; $x < count($user_list); $x++){
		    if($user_list[$x]->uid == $postList[$i]->actor_id)
			$postList[$i]->users = $user_list[$x];
		}
		
		for($x=0; $x < count($page_list); $x++){
		    if($page_list[$x]->page_id == $postList[$i]->actor_id)
			$postList[$i]->users = $page_list[$x];
		}
	    }
	    return $postList;
	}
	else{
	    return null;
	}
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
	$timezone = new DateTimeZone("Europe/London");
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
	    "author_id" => number_format($each_post->actor_id,0,'.',''),
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
		
		$social_stream_fb_comments = array(
		    "post_id" => $insert_id,
		    "attachment" => json_encode($each_post->comments[$x]->attachment), 
		    "from" => number_format($each_post->comments[$x]->fromid,0,'.',''),
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
    
    public function RetrieveConversation($page_id, $access_token){
	$fql = '{"query1" : "SELECT message_count, unread, updated_time,snippet,  recent_authors,  recipients, subject, thread_id FROM thread WHERE folder_id = 0",
	"query2" : "SELECT created_time, body, author_id, attachment, viewer_id, thread_id, message_id  from message where thread_id in (SELECT thread_id from #query1)",
	"query3" : "Select uid, name, username from user where uid in (select recent_authors from #query1) or uid in (select recipients from #query1)",
	"query4" : "Select page_id, name, username from page where page_id in (select recent_authors from #query1) or page_id in (select recipients from #query1)"
	}';
	$requestResult = curl_get_file_contents('https://graph.facebook.com/fql?q='.urlencode($fql)."&access_token=".$access_token);
	$result  = json_decode($requestResult);
	
	$conversation = $result->data[0]->fql_result_set;
        $conversationDetail = $result->data[1]->fql_result_set;
        
        $user_list = $result->data[2]->fql_result_set;
	$page_list = $result->data[3]->fql_result_set;
	
        for($i=0;$i<count($conversation);$i++){
            for($x=0; $x < count($conversationDetail); $x++){
		$viewer = $this->SearchUserFromList($conversationDetail[$x]->viewer_id, $user_list);
		$viewer = $viewer == null ? $this->SearchUserFromList($conversationDetail[$x]->viewer_id, $page_list) : $viewer;
		$author = $this->SearchUserFromList($conversationDetail[$x]->author_id, $user_list);
		$author = $author == null ? $this->SearchUserFromList($conversationDetail[$x]->author_id, $page_list) : $author;
		$conversationDetail[$x]->viewer = $viewer;
		$conversationDetail[$x]->author = $author;
                if($conversationDetail[$x]->thread_id == $conversation[$i]->thread_id){
                    $conversation[$i]->detail[] =$conversationDetail[$x] ;
                }
            }
        }
	
        return $conversation;
    }
    
    public function RetrieveNewConversation($access_token, $url = 'https://graph.facebook.com/me/conversations?access_token='){
	$requestResult = curl_get_file_contents($url.$access_token);
	
	return $requestResult;
    }
    
    
    public function SaveUserFromFacebook($userid, $access_token){
	$timezone = new DateTimeZone("Europe/London");
	if(!$this->IsFbUserExists($userid)){
	    $fql = "select uid, name, username, sex from user where uid = $userid";
	    $requestResult = curl_get_file_contents('https://graph.facebook.com/fql?q='.urlencode($fql)."&access_token=".$access_token->token);
	    $requestResult = json_decode($requestResult);
	    if(count($requestResult->data) > 0)
	    {
		$fbuser = $requestResult->data[0];
		$currentTime = new DateTime(date('Y-m-d H:i:s e'), $timezone);
		$fb_user_to_save = array(
		    "facebook_id" => $fbuser->uid,
		    "name" => $fbuser->name,
		    "sex" => isset($fbuser->sex) ? substr($fbuser->sex, 0, 1) : "",
		    "created_at" => $currentTime->format("Y-m-d H:i:s"),
		    "retrieved_at" => $currentTime->format("Y-m-d H:i:s"),
		    "username" => $fbuser->username
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
	$timezone = new DateTimeZone("Europe/London");
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
			$conversation_detail->body .= $line.'<br />';
		}
		$created_time = new DateTime($conversation_detail->created_time);
		$social_stream_facebook_conversation_detail = array(
		    "attachment" => isset($conversation_detail->attachments) ? json_encode($conversation_detail->attachments) : '',
		    "detail_id_from_facebook"  => $conversation_detail->id,
		    "messages" => $conversation_detail->message,
		    "sender" => number_format($conversation_detail->from->id,0,'.',''),
		    "to" => number_format($conversation_detail->to->data[0]->id,0,'.',''),
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
	$timezone = new DateTimeZone("Europe/London");
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
		    "sender" => number_format($conversation_detail->author_id,0,'.',''),
		    "to" => number_format($conversation_detail->viewer_id,0,'.',''),
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
			"facebook_id" => number_format($user->uid,0,'.',''),
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
			"facebook_id" => number_format($user->page_id,0,'.',''),
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
    
    public function IsFbUserExists($fb_id){
	$this->db->select('*');
	$this->db->from('fb_user_engaged');
	$this->db->where('facebook_id',number_format($fb_id,0,'.',''));
	return $this->db->get()->row() != null;
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
        $this->db->select("a.*, b.username, b.display_name, c.comment_content, d.messages, d.assign_to, e.display_name as assign_name, f.display_name as solved_name, d.solved_message");
        $this->db->from("channel_action a INNER JOIN
			user b on b.user_id = a.created_by LEFT JOIN
			social_stream_fb_comments c on c.comment_stream_id = a.stream_id_response LEFT JOIN
			`case` d on d.case_id = a.case_id LEFT JOIN
			user e on e.user_id = d.assign_to LEFT JOIN
			user f on f.user_id = d.solved_by");
	$this->db->order_by('a.created_at','desc');
	if(!$is_where_in)
	    $this->db->where($filter);
	else
	    $this->db->where_in('a.post_id',$filter);
	$result = $this->db->get()->result();
        return $result;
    }
    
    function GetChannelActionPM($filter, $is_where_in = false){

    $this->db->select("a.*, b.username, b.display_name, c.MESSAGES as comment_content, d.messages, d.assign_to, 
    	               e.display_name AS assign_name, f.display_name AS solved_name,d.solved_message");
    $this->db->from("channel_action a INNER JOIN
                    `user` b ON b.user_id = a.created_by LEFT JOIN
        			`social_stream_facebook_conversation_detail` c ON c.detail_id_from_facebook = a.stream_id_response LEFT JOIN
        			`case` d ON d.case_id = a.case_id LEFT JOIN
        			`user` e ON e.user_id = d.assign_to LEFT JOIN
        			`user` f ON f.user_id = d.solved_by");
	if(!$is_where_in)
	    $this->db->where($filter);
	else
	    $this->db->where_in('a.post_id',$filter);

        return $this->db->get()->result();
    }
    
    
    public function RetrieveFeedFB($filter,$limit = 20,$is_limit = true){//retrive yang digunakan untuk feed facebook
        $this->db->distinct();
        $this->db->select('a.*, `b`.*, `c`.*, `d`.*, c.type as social_stream_type, b.post_id as social_stream_post_id,b.post_id, c.created_at as post_date,d.case_id');
        $this->db->from("   fb_user_engaged a INNER JOIN 
                            social_stream_fb_post b  ON b.author_id = a.facebook_id inner join 
                            social_stream c on c.post_id = b.post_id LEFT JOIN
                            `case` d on d.post_id = c.post_id and d.status='pending'");
	
	if($is_limit){
	    $this->db->limit($limit);
	}

        $this->db->order_by('b.updated_at','desc');
        $this->db->order_by('c.created_at','desc');
        $this->db->order_by('c.replied_count','desc');

        if(count($filter) >= 1){
            $this->db->where($filter);
        }
        $result = $this->db->get()->result();
        
        $my_user_id=$this->session->userdata('user_id');                                
        foreach($result as $row){
            
            $cek_reply=count($this->RetriveCommentPostFb(array('a.post_id'=>$row->social_stream_post_id),array()));
            $cek_action=count($this->GetChannelAction(array('a.post_id'=>$row->post_id), false));            

            if(($cek_reply>0) or ($cek_action==0 and $cek_reply==0)){
                $row->reply_post = $this->RetriveCommentPostFb(array('a.post_id'=>$row->social_stream_post_id,'comment_id'=>'0'),array());
        	    $comment_list = array();
        	    foreach($row->reply_post as $comment){
                    $comment_list[] = $comment->id;
                    $row->channel_action = $this->GetChannelAction(array_merge($comment_list, array($row->social_stream_post_id)), true);
                }
                foreach($row->reply_post as $comment){
                    $comment_list[] = $comment->id;
                    $row->is_my_reply= $this->GetChannelAction(array('a.created_by'=>$my_user_id,'a.post_id'=>$row->post_id), false);
                }                
            }elseif($cek_action>0 and $cek_reply==0 ){
                $row->reply_post = $this->RetriveCommentPostFb(array('a.post_id'=>$row->social_stream_post_id,'comment_id'=>'0'),array());
                $row->actions_post = $this->GetChannelAction(array('a.post_id'=>$row->post_id),array());
            	$comment_list = array();
                foreach($row->actions_post as $comment){
                    $comment_list[] = $comment->id;
                    $row->channel_action = $this->GetChannelAction(array_merge($comment_list, array($row->post_id)), true);
                }
                foreach($row->actions_post as $comment){
                    $comment_list[] = $comment->id;
                    $row->is_my_reply= $this->GetChannelAction(array('a.created_by'=>$my_user_id,'a.post_id'=>$row->post_id), false);
                }
                
            }                
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
    
//    public function userComment(){
//        $this->db->distinct('`from`'); 
//        $this->db->from('social_stream_fb_comments')
//                
//    }
//    
    public function RetrievePostFB($filter){
        $this->db->select('*, c.type as social_stream_type, a.post_id as social_stream_post_id');
        $this->db->from("fb_user_engaged a INNER JOIN social_stream_fb_post b ON b.author_id=a.facebook_id
			inner join social_stream c on c.post_id = b.post_id LEFT JOIN
                        `case` d on d.post_id = c.post_id AND d.status='pending'");
        if(count($filter) > 0)
	       $this->db->where($filter);
           
        $this->db->limit(20);
        $this->db->order_by('c.replied_count','desc');
        $this->db->order_by('c.created_at','desc');
        return $this->db->get()->result();
    }
    
    public function RetriveCommentPostFb($filter,$in){
        $this->db->select("a.post_id,a.post_content,a.total_comments,b.comment_stream_id,b.attachment,b.from,c.name,b.comment_content,b.created_at, b.user_likes, d.post_stream_id,b.comment_id,e.post_id AS comment_post_id, b.id,e.type as type_stream");
        $this->db->from("social_stream_fb_post a INNER JOIN
                social_stream_fb_comments b ON b.post_id=a.post_id INNER JOIN
                fb_user_engaged  c ON c.facebook_id=b.from INNER JOIN social_stream d on d.post_id = b.id LEFT OUTER JOIN
                social_stream e ON e.post_stream_id=b.comment_stream_id");               
        if(count($filter) > 0)
	       $this->db->where($filter);
           
        if(count($in) > 0)
	       $this->db->where_in('b.from',$in);
           
        $this->db->limit(20);
        $this->db->order_by('a.post_id','desc');
        return $this->db->get()->result();        
    }
    
      public function RetrievePmFB($filter,$limit = false){
        //WHERE detail_id_from_facebook LIKE '%_0'
       $this->db->_protect_identifiers = false;
        $this->db->select("a.*,b.*,d.name, d.username, c.is_read, c.post_stream_id, c.type, c.type AS social_stream_type, 
                          c.channel_id, c.post_id, b.created_at AS post_date, e.case_id, a.conversation_id AS social_stream_post_id");
        $this->db->from("social_stream_facebook_conversation a INNER JOIN
            	(SELECT *,REPLACE(post_stream_id,'t_','m_') AS new_post_id FROM social_stream WHERE type='facebook_conversation')  c ON c.post_id=a.conversation_id LEFT OUTER JOIN
            	social_stream_facebook_conversation_detail b ON b.detail_id_from_facebook = c.new_post_id INNER JOIN
            	fb_user_engaged d ON d.facebook_id=b.sender   LEFT OUTER JOIN
            	`case` e ON e.post_id=c.post_id AND e.status='pending'");	
        if(count($filter) > 0){
	    $this->db->where($filter);
        }
	
    	if($limit){
    	    $this->db->limit($limit);
    	}
	$this->db->order_by('a.updated_time','desc');
       
       $result= $this->db->get()->result();
       $my_user_id=$this->session->userdata('user_id');                                

        foreach($result as $row){
        
//            $row->reply_post = $this->RetrievePmDetailFB(array('d.post_id'=>$row->post_id));
           $row->reply_post = $this->IsCommentExists($row->post_stream_id);
            $row->channel_action = $this->GetChannelActionPM(array('d.post_id'=>$row->post_id));
          //  $row->reply_post = $this->IsCommentExists($row->post_stream_id);
          //  $row->channel_action = $this->GetChannelAction(array('a.post_id'=>$row->social_stream_post_id));
              
            $cek_reply=count($row->reply_post);
            $cek_action=count($row->channel_action);            

//            echo "count reply:".$cek_reply."|-|count action:".$cek_action."<br>";
            if(($cek_reply>0) or ($cek_action==0 and $cek_reply==0)){
                $row->reply_post = $this->RetrievePmDetailFB(array('d.post_id'=>$row->post_id));
        	    $comment_list = array();
        	    foreach($row->reply_post as $comment){
                    $comment_list[] = $comment->detail_id;
                    $row->channel_action = $this->GetChannelActionPM(array_merge($comment_list, array($row->post_id)), true);
                }
                foreach($row->reply_post as $comment){
                    $comment_list[] = $comment->detail_id;
                    $row->is_my_reply= $this->GetChannelActionPM(array('a.created_by'=>$my_user_id,'d.post_id'=>$row->post_id), false);
                }                
            }elseif($cek_action>0 and $cek_reply==0 ){
                $row->reply_post = $this->RetrievePmDetailFB(array('d.post_id'=>$row->post_id),array());
                $row->actions_post = $this->GetChannelActionPM(array('d.post_id'=>$row->post_id),array());
            	$comment_list = array();
                foreach($row->actions_post as $comment){
                    $comment_list[] = $comment->id;
                    $row->channel_action = $this->GetChannelActionPM(array_merge($comment_list, array($row->post_id)), true);
                }
                foreach($row->actions_post as $comment){
                    $comment_list[] = $comment->id;
                    $row->is_my_reply= $this->GetChannelActionPM(array('a.created_by'=>$my_user_id,'d.post_id'=>$row->post_id), false);
                }                
            } 
        }
        return $result;
    }
    
    public function CountPmFB($filter){
        $this->db->select('count(a.conversation_id) as count_post_id');
        $this->db->from("social_stream_facebook_conversation a LEFT OUTER JOIN 
                        social_stream d ON d.post_id = a.conversation_id");
	   if(count($filter) > 0){
	    $this->db->where($filter);
	   } 
        $this->db->order_by('created_at','desc');
        return $this->db->get()->result();
    }
    
    public function RetrievePmDetailFB($filter){
        //WHERE detail_id_from_facebook LIKE '%_0'
        $this->db->select("a.*,b.messages AS comment_content,b.*,c.name,c.username,d.channel_id,d.type,d.is_read, d.type as social_stream_type, d.post_id");
        $this->db->from("social_stream_facebook_conversation a LEFT OUTER JOIN 
                        social_stream_facebook_conversation_detail b ON b.conversation_id = a.conversation_id LEFT OUTER JOIN
                        fb_user_engaged c ON c.facebook_id=b.sender LEFT OUTER JOIN
                        social_stream d ON d.post_id=b.conversation_id");
         if(count($filter) > 0){
	       $this->db->where($filter);
        }
        $this->db->order_by('created_at','desc');
        return $this->db->get()->result();
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
	return $this->db->get()->result();
    }
    
    public function SocialStreamCountUpdate($post_id){
	$max_reply = $this->db->query("Select max(replied_count) as replied_count from social_stream");
	$max_reply = $max_reply->row();
	$this->db->query("update social_stream set replied_count = ".$max_reply->replied_count." + 1 where post_id = $post_id");
    }
    
    
    function DeletePostFb($post_stream_id, $channel_id, $user_id, $status = 0){
        $this->db->trans_start();
        $limit=1;
        if($status == 0){
            $data = $this->RetrieveFeedFB(
                array('post_stream_id' => $post_stream_id),$limit
            );
        }elseif($status==1){
            $data = $this->RetrievePmFB(
                array('post_stream_id' => $post_stream_id),$limit
            );
        }else{
            $data = $this->RetriveCommentPostFb(
                array('d.post_stream_id' => $post_stream_id),array()
            );   
        }

        $channel_action = array(
            'action_type' => "facebook_delete",
            'channel_id' => $channel_id,
            'created_at' => date("Y-m-d H:i:s"),
            'post_id' => NULL,
            'created_by' => $user_id,
            'log_text' => json_encode($data)
        );
      //  print_r($data);
        $this->db->insert('channel_action', $channel_action);
        $this->db->where(array(
            'post_stream_id' => $post_stream_id,
        ));        
        $return = $this->db->delete('social_stream');
        print_r($return);
        $this->db->trans_complete();
        return $return;
    }
    
    function IsFacebookConversation($stream_id){
	$this->db->select("*");
	$this->db->from("social_stream_facebook_conversation");
	$this->db->where('conversation_id', $stream_id);
	return $this->db->get()->row();
    }
}
