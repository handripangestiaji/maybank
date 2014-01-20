<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class post_model extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->load->helper('basic');
    }
    
    public function InsertPost($message,$channels,$tags='',$image='',$link='',$title='',$description='',$email_me='0',$scheduleTime=NULL){
        if($email_me == 'on'){
	    $email_me = 1;
	}
	else{
	    $email_me = 0;
	}
	
	$post = array('created_by' => $this->session->userdata('user_id'),
			'messages' => $message,
			'created_at' => date('Y-m-d H:i;s'),
			'time_to_post' => $scheduleTime,
			'image' => $image,
			'short_urls_id' => $link,
			'url_title' => $title,
			'url_description' => $description,
			'email_me_when_sent' => $email_me
			);
	$this->db->insert('post',$post);
        $post_id = $this->db->insert_id();
        
        for($i=0;$i<count($channels);$i++){
	    $post_to = array('channel_id' => $channels[$i],
                             'post_id' => $post_id);
            if($scheduleTime == NULL){
		$post_to['is_posted'] = 1;
		$post_to['post_created_at'] = date('Y-m-d H:i:s');
	    }
	    $this->db->insert('post_to',$post_to);
        }
	
	if($tags != ''){
	    foreach($tags as $tag){
		$get_tag = $this->GetTagByTagName($tag);
                if($get_tag == NULL){
                    $tag_id = $this->InsertTag($tag);
                }
                else{
                    $tag_id = $get_tag->id;
                }
                
                //tag increment
                $this->IncrementTag($tag_id);
                
                $new_tag = array('schedule_post_id' => $post_id,
                                 'content_tag_id' => $tag_id);
	        $this->db->insert('post_tag',$new_tag);
	    }
	}
    }
    
    public function GetTagByTagName($tag_name){
        $this->db->select('*');
        $this->db->from('content_tag');
        $this->db->where('tag_name',$tag_name);
        return $this->db->get()->row();
    }
    
    public function InsertTag($tag_name){
        $tag = array('tag_name' => $tag_name,
                     'created_at' => date('Y-m-d H:i:s'),
                     'user_id' => $this->session->userdata('user_id')
                    );
        $this->db->insert('content_tag',$tag);
        return $this->db->insert_id();
    }
    
    public function IncrementTag($tag_id){
        $this->db->select('increment');
        $this->db->from('content_tag');
        $this->db->where('id',$tag_id);
        $tag = $this->db->get()->row();
        
        $value = array('increment' => $tag->increment + 1);
        $this->UpdateTag($tag_id,$value);
    }
    
    public function UpdateTag($tag_id,$value){
        $this->db->where('id',$tag_id);
        $this->db->update('content_tag',$value);
    }
    
    public function GetPosts($filter = null){
	$this->db->select('*');
	$this->db->from('post');
	$this->db->join('post_to','post.id = post_to.post_id');
	$this->db->join('channel','channel.channel_id = post_to.channel_id');
	$this->db->join('user','post.created_by = user.user_id');
	$this->db->join('short_urls','post.short_urls_id = short_urls.id','left');
	if($filter != null){
	    $this->db->where($filter);
	}
	return $this->db->get()->result();
    }
    
    public function UpdatePostTo($id,$value){
	$this->db->where('post_to_id',$id);
    	$this->db->update('post_to',$value);
    }
}