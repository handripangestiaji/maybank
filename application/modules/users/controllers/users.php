<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MY_Controller {

    private $connection;
	   
    function __construct()
    {
        parent::__construct();
	$this->load->model('users_model');
	$this->load->helper('security');
	
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
			
	
    }
    
    function index()
    {
        $data = array(
		      'show' => $this->users_model->select_user(),
		      'role' => $this->users_model->select_role(),
		      'count' => $this->db->affected_rows($this->users_model->select_user())
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
	  $created_by = $this->session->userdata('user_id') == 0 ? NULL : $this->session->userdata('user_id');
	  
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
		      'created_at' => $time->format("Y-m-d H:i:s"),
		      'created_by' => $created_by
	       );
	  
	  $this->users_model->insert_user($data);
	
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
    
    function update_password()
    {
	  $id = $this->session->userdata('user_id');
	  $check = $this->users_model->get_byid($id);
	  
	  $pass_old = $this->input->post('existing_password');
	  
	  if($check->row()->password == do_hash($pass_old.$check->row()->salt,'md5'))
	  {
	       $pass_new = array(
				 'password' => do_hash($this->input->post('new_password').$check->row()->salt,'md5')
				);
	       $this->users_model->update_user($id,$pass_new);
	       redirect('users');
	  }
	  else
	  {
	       echo 'GAGAL';
	  }
    }
    
    function delete($id)
    {
	  $this->users_model->delete_user($id);
	  
	  redirect('users');
    }
    
    
    
    //============================ ROLE ===================================
    function menu_role()
    {
	  $data = array(
			 'show' => $this->users_model->select_role(),
			 'app_show' =>$this->users_model->select_appRole()
		    );
	  $this->load->view('users/role',$data);
    }
    
    function insert_role()
    {
	  $timezone = new DateTimeZone("Europe/London");
	  $time = new DateTime(date("Y-m-d H:i:s e"), $timezone);
	  $created_at = $time->format("Y-m-d H:i:s");
	  $created_by = $this->session->userdata('user_id');
	  
	  $data = array(
			 'role_name' => $this->input->post('new_role'),
			 'created_by' => $created_by,
			 'created_at' => $created_at
			);
	  $this->users_model->insert_role($data);
	  $last_id=$this->db->insert_id();
	  
	  $role = $this->input->post('role');
	  
	  for($i=0;$i<count($role);$i++)
	  {
	       $data1 = array(
			      'role_collection_id' => $last_id,
			      'app_role_id' => $role[$i]
			      );
	       $this->users_model->insert_role_detail($data1);
	  }
	  redirect('users/menu_role');
    }
    
    function delete_role($id)
    {
	  $this->users_model->delete_role($id);
	  redirect('users/menu_role');
    }
    
    function edit_role($id)
    {
	  $data = array(
			 'role' => $this->users_model->edit_role($id),
			 'app_show' =>$this->users_model->select_appRole(),
			 'role_detail' => $this->users_model->edit_role_detail($id)
			);
	  $this->load->view('users/role_edit',$data);
    }
    
    
    //============================ APP_ROLE ===============================
    function create_appRole()
    {
	  $data = array(
			 'parent' =>$this->users_model->select_appRole()
		    );
	  $this->load->view('users/create_appRole',$data);
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
			'active' => 1,
			'parent_id' => $this->input->post('parent_id')
			);
	  $this->users_model->insert_appRole($data);
	  
	  redirect('users/menu_role');
    }
    
    //============================= GROUP =================================
    function menu_group()
    {
	  $data = array(
			 'group' => $this->users_model->select_group(),
			 'channel' => $this->users_model->select_channel(),
			 'group_detail' => $this->users_model->select_user_group_d(),
			 'count' => $this->db->affected_rows($this->users_model->select_group())
			);
	  $this->load->view('users/group',$data);
    }
    
    function insert_group()
    {	
	  $timezone = new DateTimeZone("Europe/London");
	  $time = new DateTime(date("Y-m-d H:i:s e"), $timezone);
	  $created_at = $time->format("Y-m-d H:i:s");
	  $created_by = $this->session->userdata('user_id');
	  
	  $channel = $this->input->post('channel');
	   
	  
	  $data = array(
			 'group_name' => $this->input->post('group_name'),
			 'created_at' => $created_at,
			 'is_active' => 1,
			 'created_by' => $created_by
			);
	  $this->users_model->insert_group($data);
	  $last_id=$this->db->insert_id();
	  
	  for($i=0;$i<count($channel);$i++)
	  {
	       $data_channel = array(
					'user_group_id' => $last_id,
					'allowed_channel' => $channel[$i],
					'created_at' => $created_at
				     );
	       $this->users_model->insert_group_detail($data_channel);
	  }
	  redirect('users/menu_group');
    }
    
    function delete_group($id)
    {
	  $data = $this->users_model->delete_group($id);
	  redirect('users/menu_group?return='.$data);
    }
    
    function edit_group($id)
    {
	  $data = array(
			 'group' => $this->users_model->edit_group($id),
			 'group_detail' => $this->users_model->edit_group_detail($id),
			 'channel' => $this->users_model->select_channel()
			);
	  $this->load->view('users/group_edit',$data);
    }
    
    function update_group()
    {
	  $channel = $this->input->post('channel');
	  
	  $group_id = $this->input->post('group_id');
	  $data = array(
			'group_name' => $this->input->post('group_name'),
		       );
	  $this->users_model->update_group($group_id,$data);
	  
	  $this->users_model->delete_group_detail($group_id);
	  
	  for($i=0;$i<count($channel);$i++)
	  {
	       $data_channel = array(
					'user_group_id' => $group_id,
					'allowed_channel' => $channel[$i]
				     );
	       $this->users_model->insert_group_detail($data_channel);
	  }
	  redirect('users/menu_group');
    }
    
    //============================= LOGOUT ================================
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