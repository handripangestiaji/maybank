<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Case_Provider extends CI_Controller {

    private $connection;
	   
    function __construct()
    {
        parent::__construct();
        $this->load->model('campaign_model');
    }
    
    function ReadUserList(){
        $this->load->model('case_model');
        
        $user_list = $this->case_model->ReadAllUser();
        echo json_encode($user_list);
    }
    
    function SaveCase(){
	$allParameter = $this->input->post();
	
	echo json_encode($allParameter);
    }
    
}