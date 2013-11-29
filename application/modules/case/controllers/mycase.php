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
        
        
    }
}