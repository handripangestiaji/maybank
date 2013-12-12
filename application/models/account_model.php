<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class account_model extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->load->helper('basic');
	$this->load->model('facebook_model');
    }
    
    
    /*
        * Retrieve Channel(s) which are restored from databases
	* $filter : filtering channel by parameter default empty array
	* @return array feed collection
        * @author Eko Purnomo
    */
    function GetChannel($filter = array(), $page = 1){
        $this->db->select('*');
        $this->db->from("channel");
        if(count($filter) > 0)
            $this->db->where($filter);
	$this->db->limit(15, ($page * 15) - 15);
        return $this->db->get()->result();
    }
    
    function GetTableTotalRow($table_name, $filter = array()){
	$this->db->select("count(*) as counted");
	$this->db->from($table_name);
	
	if(count($filter) > 0)
	    $this->db->where($filter);
	
	return $this->db->get()->row()->counted;
    }
    
    function GetApplicationRole($parent_id){
	$this->db->select("*");
	$this->db->from("application_role");
	$this->db->where("parent_id", $parent_id);
	return $this->db->get()->result();
    }
    
    function GetRole(){
	$result = $this->GetApplicationRole(5);
	foreach($result as $row){
	    $row->children = $this->GetApplicationRole($row->app_role_id);
	    foreach($row->children as $child){
		$child->children = $this->GetApplicationRole($child->app_role_id);
	    }
	}
	return $result;
    }
    
    function SaveChannel($channel){
	$currentChannel = $this->GetChannel(array(
	    "social_id" => $channel['social_id']
	));
	if(count($currentChannel) == 0){
	    $this->db->insert("channel", $channel);
	    return $this->db->insert_id();
	}
	else{
	    //print_r($currentChannel);
	    $channel['is_active'] = 1;
	    $this->db->where("channel_id", $currentChannel[0]->channel_id);
	    $this->db->update("channel", $channel);
	    return $currentChannel[0]->channel_id;
	}
    }
    
    function DeleteChannel($channel_id){
	$this->db->where('channel_id', $channel_id);
	$this->db->delete('channel');
    }
    
    
    function CreateChannelAction($action){
	$this->db->insert('channel_action',$action);
	return $this->db->insert_id();
    }
    
    function CreateRetweetAction($action){
	$action['action_type'] = 'twitter_retweet';
    }
    
    
    function CreateFbLikeAction($action, $like = 0){
	$this->db->trans_start();
	$post = $this->facebook_model->IsStreamIdExists($action['stream_id']);
	if($post != null){
	    $action['post_id'] = $post->post_id;
	    $this->db->where("post_id", $post->post_id);
	    $this->db->update("social_stream_fb_post", array(
		"user_likes" => $like
	    ));
	    $this->db->where("id", $post->post_id);
	    $this->db->update("social_stream_fb_comments", array(
		"user_likes" => $like
	    ));
	}
	$result = $this->CreateChannelAction($action);
	$this->db->trans_complete();
	return $result;
    }
    
    function CreateFbCommentAction($action, $like = 0){
	$this->db->trans_start();
	$post = $this->facebook_model->IsStreamIdExists($action['stream_id']);
	if($post != null){
	    $action['post_id'] = $post->post_id;
	    $this->db->where("post_id", $post->post_id);
	    $this->db->update("social_stream_fb_post", array(
		"user_likes" => $like
	    ));
	    $this->db->where("id", $post->post_id);
	    $this->db->update("social_stream_fb_comments", array(
		"user_likes" => $like
	    ));
	}
	$result = $this->CreateChannelAction($action);
	$this->db->trans_complete();
	return $result;
    }
}
