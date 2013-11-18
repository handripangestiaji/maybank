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
	foreach($accounts->data as $account){
	    if($account->id == $page_id)
		return $account->access_token;
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
	' AND actor_id  <> '.$page_id.' order by updated_time ASC LIMIT 50",'.
        '"query2" : "SELECT id,post_id, comment_count, text, time, fromid FROM comment WHERE post_id in (Select post_id from #query1 where comment_info.comment_count > 0) ",'.
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
	 $fql = '{"query1":"SELECT share_count, attachment, post_id, actor_id, share_count, updated_time, message,like_info, comment_info, message_tags FROM stream WHERE source_id = '.$page_id.
	' AND actor_id '.($isOwnPost ? " = " : " <> " ).$page_id.' order by updated_time ASC LIMIT 50",
        "query2" : "SELECT id,post_id, comment_count, parent_id, text, time, likes, fromid FROM comment WHERE post_id in (Select post_id from #query1 where comment_info.comment_count > 0) ",
        "query3" : "Select uid, name, username,sex from user where uid in (select actor_id from #query1) or uid in (select fromid from #query2)",
        "query4" : "Select page_id, name, username from page where page_id in (select actor_id from #query1) or page_id in (select fromid from #query2)"
        }';
	$requestResult = curl_get_file_contents('https://graph.facebook.com/fql?q='.urlencode($fql)."&access_token=".$access_token);

	
	$result  = json_decode($requestResult);
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
	$social_stream = array(
	    "post_stream_id" => $each_post->post_id,
	    "channel_id" => $channel->channel_id,
	    "type" => "facebook",
	    "retrieved_at" => date("Y-m-d H:i:s"),
	    "created_at" => date("Y-m-d H:i:s", $each_post->updated_time)
	);
	$updated_time = new DateTime(date("Y-m-d H:i:s e", $each_post->updated_time), $timezone);
	$social_stream_fb_post = array(
	    "post_content" => $each_post->message,
	    "author_id" => number_format($each_post->actor_id,0,'.',''),
	    "attachment" => isset($each_post->attachment->media) ? json_encode($each_post->attachment->media) : "",
	    "enggagement_count" => 0,
	    "total_likes" => $each_post->like_info->like_count,
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
		$social_stream_fb_comments = array(
		    "post_id" => $insert_id,
		    "from" => number_format($each_post->comments[$x]->fromid,0,'.',''),
		    "comment_stream_id" => $each_post->comments[$x]->id,
		    "comment_content" => $each_post->comments[$x]->text,
		    "comment_id" => $each_post->comments[$x]->parent_id,
		    "created_at" => $updated_time->format("Y-m-d H:i:s"),
		    "retrieved_at" => date("Y-m-d H:i:s")
		);
		if($this->IsCommentExists($each_post->comments[$x]->id) == null){
		    $this->db->insert("social_stream_fb_comments", $social_stream_fb_comments);    
		}
		else{
		    $this->db->where('comment_stream_id', $each_post->comments[$x]->id);
		    $this->db->update("social_stream_fb_comments", $social_stream_fb_comments);
		}
	    }
	}
	$this->db->trans_complete();
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
	$this->db->select("id");
	$this->db->from("social_stream_fb_comments");
	$this->db->where("comment_stream_id",$comment_id);
	return $this->db->get()->row();
    }
    
    public function IsFbUserExists($fb_id){
	$this->db->select('facebook_id');
	$this->db->from('fb_user_engaged');
	$this->db->where('facebook_id',number_format($fb_id,0,'.',''));
	return $this->db->get()->row() != null;
    }
    
    public function IsStreamIdExists($stream_id){
	$this->db->select("post_id");
	$this->db->from("social_stream");
	$this->db->where(array(
	    "type" => "facebook",
	    "post_stream_id" => $stream_id
	));
	return $this->db->get()->row();
    }
    
    
 
}