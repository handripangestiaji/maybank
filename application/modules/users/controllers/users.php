<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MY_Controller {

    private $connection;
	   
    function __construct()
    {
        parent::__construct();
	session_start();
	if(!$this->session->userdata('is_login'))
	  {
	       redirect('login');
	  }
	$this->load->model('users_model');
	$this->load->helper('security');
	
    }
    
    function index()
    {
        $data = array(
		      'show' => $this->users_model->select_user()
		      //'id' => $this->session->userdata('user_id')
		     );
        $this->load->view('users/index',$data);
    }
    
    //view create user
    function create()
    {
        $data = array(
		      'role' => $this->users_model->select_role(),
		      'group' => $this->users_model->select_group()
		      );
        $this->load->view('users/create_user',$data);
    }
    
    function insert_user()
    {
	  $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	  $count = mb_strlen($chars);
    
	  for ($i = 0, $pass = ''; $i < 10; $i++) {
	  $index = rand(0, $count - 1);
	  $pass .= mb_substr($chars, $index, 1);
	  }
	  
	  $timezone = new DateTimeZone("Europe/London");
	  $time = new DateTime(date("Y-m-d H:i:s e"), $timezone);
	  $data=array(
		      'user_id' => $this->input->post('userID'),
		      'full_name' => $this->input->post('fullName'),
		      'display_name' => $this->input->post('displayName'),
		      'email' => $this->input->post('email'),
		      'password' => do_hash($pass.time(),'md5'),
		      'salt' => time(),
		      'role_id' => $this->input->post('optRole'),
		      'group_id' => $this->input->post('optGroup'),
		      'is_active' => 1,
		      'created_at' => $time->format("Y-m-d H:i:s")
	       );
	  
	  $this->users_model->insert_user($data);
	  
	  
	  $config=array(
					'protocol'=>'smtp',
					'smtp_host'=>'ssl://smtp.googlemail.com',
					'smtp_port'=>465,
					'smtp_user'=>'bogcampbogcamp@gmail.com',
					'smtp_pass'=>'AB123456CD',
					'charset'=>'utf-8',
					'mailtype'=>'html',
					'wordwrap'=>TRUE
			);
				
			$this->load->library('email',$config);
			$this->email->set_newline("\r\n");
	
			$this->email->from('robay.robby@gmail.com','robay');
			$this->email->to($this->input->post('email'));
			
			$this->email->subject('User Name and Password');
			$this->email->message('Username '.$this->input->post('userID').' and password '.$pass);
			
			$this->email->send();
	  
	  
	  redirect('users');
    }
    
    function edit($id)
    {
	  $data = array(
			'id' => $this->users_model->get_byid($id),
			'role' => $this->users_model->select_role(),
			'group' => $this->users_model->select_group()
			);
	  $this->load->view('users/edit_user',$data);
    }
    
    function update_user()
    {
	  $id = $this->input->post('userID');
	  $data = array(
		      'full_name' => $this->input->post('fullName'),
		      'display_name' => $this->input->post('displayName'),
		      'email' => $this->input->post('email'),
		      'role_id' => $this->input->post('optRole'),
		      'group_id' => $this->input->post('optGroup')
			);
	  
	  $this->users_model->update_user($id,$data);
	  
	  redirect('users');
    }
    
    function delete($id)
    {
	  $this->users_model->delete_user($id);
	  
	  redirect('users');
    }
    
    
    
    //----------------------ROLE----------------------------
    function menu_role()
    {
	  $data = array(
			 'show' => $this->users_model->select_role(),
			 'app_show' =>$this->users_model->select_appRole()
		    );
	  $this->load->view('users/role',$data);
    }
    
    
    //-------------------APP_ROLE---------------------------
    function create_appRole()
    {
	  $this->load->view('users/create_appRole');
    }
    function insert_appRole()
    {
	  $timezone = new DateTimeZone("Europe/London");
	  $time = new DateTime(date("Y-m-d H:i:s e"), $timezone);
	  
	  $data = array(
			'role_group' => $this->input->post('role_group'),
			'role_name' => $this->input->post('role_name'),
			'role_friendly_name' => $this->input->post('role_friend'),
			'created_at' => $time->format("Y-m-d H:i:s"),
			'active' => 1
			);
	  $this->users_model->insert_appRole($data);
	  
	  redirect('users/menu_role');
    }
    
    function logout()
        {
	    $timezone = new DateTimeZone("Europe/London");
	    $time = new DateTime(date("Y-m-d H:i:s e"), $timezone);
	    $data = array(
			'logout_time' => $time->format("Y-m-d H:i:s")
			);
	    
	    $id = $this->session->userdata('user_id');
	    
	    $this->users_model->update_activity($id,$data);
            $this->session->sess_destroy();
            redirect('login');
        }
}