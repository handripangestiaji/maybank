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
    
    public function PostSent($post_to_id){
        $this->load->model('post_model'); 
        $where = "post_to_id = '".$post_to_id."'";
        $post = $this->post_model->GetPosts($where);
        $data['post'] = array(
                        'messages' => $post[0]->messages,
                        'socmeds' => $post[0]->connection_type,
                        'posted_at' => $post[0]->post_created_at,
                        'result' => 'Success',
                        'user_timezone' => $post[0]->timezone,
                        'error_message' => '-'
                        );
        $this->load->view('mail_template/Post/post_sent.php',$data);
    }
    
    public  function TestMail(){
        $this->load->view("Test/form");
    }
    
    public function SendMail(){
        
        $this->load->config('mail_config');
        $config = $this->config->item('mail_provider');
        
        $config['protocol'] = $this->input->post("protocol");
        $this->load->library('email',$config);
        $mail_from = $this->config->item('mail_from');
        $this->email->set_newline("\r\n");

        $mail_from = $this->config->item('mail_from');
        
        $this->email->from($mail_from['address'],$mail_from['name']);

        $this->email->to($this->input->post("email_to"));
        $this->email->bcc($mail_from['cc']);
        
        $this->email->subject($this->input->post('subject'));
        $this->email->message($this->input->post("content"));
        
        $this->email->send();
        
        echo $this->email->print_debugger();
	
    }
    
}

?>