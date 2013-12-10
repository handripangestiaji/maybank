<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class post_model extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->load->helper('basic');
    }
    
    public function InsertPost($value,$tags=''){
        $this->db->insert('post',$value);
        $post_id = $this->db-insert_id();
        if($tags != ''){
            foreach($tags as $tag){
                $tag['schedule_post_id'] = $post_id;
                $this->db->insert('post_tag',$tag);
            }
        }
    }
}