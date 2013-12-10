<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_Json extends CI_Controller {

    private $connection;
	   
    function __construct()
    {
        parent::__construct();
        $this->load->model('users_model');
    }
    
    function CheckPassword(){
        $currentPassword = $this->input->post('exist');
        $newPassword = $this->input->post('pass');
    
        
        $id = $this->session->userdata('user_id');
        $currentUser = $this->users_model->get_byid($id);
        $currentUser = $currentUser->row();
        if($currentUser){
            header("Content-type: application/x-json");
            if(md5($currentPassword.$currentUser->salt) == $currentUser->password){
                $pass_new = array(
				'password' => md5($newPassword.$currentUser->salt)
				);
		$this->users_model->update_user($id,$pass_new);
                echo json_encode(true);
            }
            else{
                echo json_encode(false);
            }
        
        }
        else{
            echo json_encode(false);
        }
    }
}