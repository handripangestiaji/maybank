<?php


class case_model extends CI_Model{
        
    function __construct(){
        parent::__construct();
    }
        
        
    function LoadCase($filter = array()){
        $this->db->select("*");
        $this->db->from("case");
        $this->db->where($filter);
        $result = $this->db->get()->result();
        foreach($result as $eachrow){
            $user = $this->ReadAllUser(
                array("user_id" => $eachrow->created_by)
            );
            $eachrow->created_by = $user;
            $eachrow->content_products_id = $this->ReadAllProducts(
                array("id" => $eachrow->content_products_id)  
            );
        }
        return $result;
    }
    
    function CreateCase($case){
        $related_conversation = $case['related_conversation'];
        $conv = explode(',', $related_conversation);
        unset($case['related_conversation']);
        $case['related_conversation_count'] = count($conv);
        $this->db->trans_start();
        $this->db->insert('case', $case);
        $insert_id = $this->db->insert_id();
        if($related_conversation != ''){
            foreach($conv as $related){
                if($related != '')
                    $this->db->insert('case_related_conversation',
                                array(
                                    "social_stream_id" => $related,
                                    "created_at" => date("Y-m-d H:i:s"),
                                    "case_id" => $insert_id
                                ));
            }
        }
        $this->load->config('mail_config');
        $mail_provider = $this->config->item('mail_provider');
        $this->load->library('email', $mail_provider);        
        $this->email->from('noreply@giziku.com','Maybank');
        $user = $this->ReadAllUser(
            array(
                "user_id" => $case['assign_to']
            )
        );
        
        
        
        $user = is_array($user) && count($user) > 0 ? $user[0] : $user;
        if($user == null)
            $this->email->to($case['email']);
        else
            $this->email->to($user->email);
            
        $content_email = curl_get_file_contents(site_url('mail_template/AssignCase/newcase/'.$insert_id));
        $this->email->subject('One case has been Assigned to you');
        $this->email->message($content_email);
        
        $this->email->send();
        $this->db->trans_complete();
        //print_r($this->email->print_debugger());
        return $insert_id;
    }
    
    
    function ReadAllUser($filter = array()){
        $filter['is_active'] = 1;
        if(count($filter) > 0){
            $this->db->where($filter);
        }
        $this->db->select("*");
        $this->db->from("user");
        $query_result = $this->db->get();
        if($query_result->num_rows() > 1)
            return $query_result->result();
        else
            return $query_result->row();
    }
    
    function ReadAllProducts($filter = array()){
        if(count($filter) > 0){
            $this->db->where($filter);
        }
        $this->db->select("*");
        $this->db->from("content_products");
        $query_result = $this->db->get();
        if($query_result->num_rows() > 1)
            return $query_result->result();
        else
            return $query_result->row();
    }
    
    function GetReplyNotification($user_id){
        $this->db->select("*");
        $this->db->from("social_stream_notification a inner join social_stream b on a.social_stream_post_id = b.post_id");
        $this->db->where("a.user_id", $user_id);
        $this->db->where("a.is_read", 0);
        return $this->db->get()->result();
    }

}