<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class post_model extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->load->helper('basic');
    }
    
    public function InsertPost($message,$channels,$tags=''){
        $post = array('created_by' => $this->session->userdata('user_id'),
			'messages' => $message,
			'created_at' => date('Y-m-d H:i;s')
			);
	$this->db->insert('post',$post);
        $post_id = $this->db->insert_id();
        
        for($i=0;$i<count($channels);$i++){
            $post_to = array('channel_id' => $channels[$i],
                             'post_id' => $post_id);
            $this->db->insert('post_to',$post_to);
        }
        
	if($tags != ''){
	    $tags = explode(',',$tags);
	    for($i=0;$i<count($tags);$i++){
                $get_tag = $this->GetTagByTagName($tags[$i]);
                if($get_tag == NULL){
                    $tag_id = $this->InsertTag($tags[$i]);
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
}