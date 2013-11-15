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
	' AND actor_id  <> '.$page_id.' order by updated_time DESC LIMIT 30",
        "query2" : "SELECT id,post_id, comment_count, text, time, fromid FROM comment WHERE post_id in (Select post_id from #query1 where comment_info.comment_count > 0) ",
        "query3" : "Select uid, name, username from user where uid in (select actor_id from #query1) or uid in (select fromid from #query2)",
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
    public function RetrieveOwnPost($page_id, $access_token){
	 $fql = '{"query1":"SELECT share_count, attachment, post_id, actor_id, share_count, updated_time, message,like_info, comment_info, message_tags FROM stream WHERE source_id = '.$page_id.
	' AND actor_id  = '.$page_id.' order by updated_time DESC LIMIT 15",
        "query2" : "SELECT id,post_id, comment_count, parent_id, text, time, fromid FROM comment WHERE post_id in (Select post_id from #query1 where comment_info.comment_count > 0) ",
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
		$user = $user == null ? $this->SearchUserFromList($comment[$x]->fromid, $user_list) : $user;
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
	    if($list[$i]->uid == $uid)
		return $list[$i];
	}
	return null;
    }
    
    
    public function TransferFeedToDb($post){
	for($i=0; $i < count($post); $i++){
	    echo "<pre>";print_r($post[$i]);echo"</pre>";
	    if(isset($post[$i]->comments)){
		for($x=0; $x < count($post[$i]->comments); $x++){
		    //$this->SaveFacebookUser($post[$i]->comments[$x]->user);
		}
	    }
	}
    }
    
    /* Save facebook user to databases
     * $user : parsed user object from feeds
    */
    public function SaveFacebookUser($user){
	if($user != null){
	    if(!$this->IsFbUserExists($user->uid)){
		$timezone = new DateTimeZone("Asia/Kuala_Lumpur");
		$currentTime = new DateTime(date('Y-m-d H:i:s e'), $timezone);
		$this->db->insert('fb_user_engaged', array(
		    "facebook_id" => number_format($user->uid,0,'.',''),
		    "name" => $user->name,
		    "sex" => $user->sex,
		    "created_at" => $currentTime->format("Y-m-d H:i:s"),
		    "retrieved_at" => $currentTime->format("Y-m-d H:i:s"),
		    "username" => $user->username
		));
	    }
	}
    }
    /* Check facebook user whether he is exists on database
     * fb_id : facebook id of user comment or like to fanpage
    */
    public function IsFbUserExists($fb_id){
	$this->db->select('facebook_id');
	$this->db->from('fb_user_engaged');
	$this->db->where('facebook_id',number_format($fb_id,0,'.',''));
	return $this->db->get()->row() != null;
    }
 
}