<?php
    
/*
    Created by Eko Purnomo (eko.purnomo@icloud.com) which are purposed to styling mail.
*/
class mail_template extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->model('case_model');
        $this->load->model('users_model');
    }
    
    
    public function AssignCase($view, $id){
        $data['case_object'] = $this->case_model->LoadCase(array(
                                'case_id' => $id));
        $this->load->view('AssignCase/'.$view, $data);
    }
    
    
    public function NewUser($user,$pass)
    {
        $data = array(
                      'user' => $this->users_model->get_byname($user),
                      'pass' => $pass
                      );
        $this->load->view('mail_template/User/new_user', $data);
    }
    
    public function ForgotPass($user,$pass)
    {
        $data = array(
                      'user' => $this->users_model->get_byid($user),
                      'pass' => $pass
                      );
        $this->load->view('mail_template/User/forgot_user',$data);
    }
}

?>