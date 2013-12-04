<?php

class mycase extends CI_Controller{
    
    function __construct(){
        parent::__construct();
        $this->load->model('case_model');
    }
    
    
    
    /*Create case by post parameter */
    function CreateCase(){
        $user_id = $this->session->userdata('user_id');
        $allPost = $this->input->post();
        
        $case = array(
            "content_products_id" => $allPost['product_type'],
            "created_by" => $user_id,
            "messages" => $allPost['message'],
            "status" => "pending",
            "email" => $allPost['email'],
            "case_type" => $allPost['case_type'],
            "assign_to" => $allPost['assign_to'] == '' ? NULL : $allPost['assign_to']
        );
        
        $this->case_model->CreateCase($case);
    }
    
    
    function phpinfo(){
        phpinfo();
    }
    
}