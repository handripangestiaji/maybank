<?php


class case_model extends CI_Model{
        
    function __construct(){
        parent::__construct();
    }
        
        
    function LoadActiveCase(){
        
    }
    
    function CreateCase($case){
        $this->load->config('mail_config');
        $mail_provider = $this->config->item('mail_provider');
        
        $this->load->library('email', $mail_provider);
        
        
        $this->email->set_newline("\r\n");
        $this->email->from('noreply@giziku.com','Cloud Motion');
        $this->email->to("eko.purnomo@icloud.com");
        
        $this->email->subject('Your current Password');
        $this->email->message('Test mail');
        
        $this->email->send();
    }
    
    
    function ReadAllUser($filter = array()){
        $filter['is_active'] = 1;
        if(count($filter) > 0){
            $this->db->where($filter);
        }
        $this->db->select("user_id, email, full_name");
        $this->db->from("user");
        return $this->db->get()->result();
    }
    
}