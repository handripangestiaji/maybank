<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MY_Controller {

    private $connection;
    public $user_role, $country_list;
    public $country_code;
    function __construct()
    {
        parent::__construct();
	$this->load->model('users_model');
	$this->load->helper('security');
	$this->load->config('mail_config');
	$config = $this->config->item('mail_provider');
	$this->load->library('email',$config);
	$this->load->library('upload');
	$this->load->library('form_validation');
	$this->user_role = $this->users_model->get_collection_detail(
		array('role_collection_id'=>$this->session->userdata('role_id')));
	$this->country_list = $this->users_model->get_country_list();
	
	
    }
    
    //===============================USER=======================================
    function index()
    {
	$cek = $this->session->userdata('search_value');
	$cek1 = $this->session->userdata('roleId');
	$config['page_query_string'] = TRUE;
	$country_code = IsRoleFriendlyNameExist($this->user_role, 'User Management_User_All_Country_View') ? NULL : $this->session->userdata('country');
	  
	if($this->input->get('role_collection_id'))
	{
	     $config['base_url'] = base_url('users/index').'?role_collection_id='.$this->input->get('role_collection_id');
	     $this->session->unset_userdata('search_value');
	     
	     $config['total_rows'] = $this->users_model->count_record('role_id',$this->input->get('role_collection_id'), $country_code);
	     $config['per_page'] = 10;
	     $config["uri_segment"] = 1;
	     
	     $config['next_link'] = 'Next';
	     $config['prev_link'] = 'Prev';
	     
	     $config['first_link'] = 'First';
	     $config['last_link'] = 'Last';
	
	     $config['cur_tag_open'] = '<b style="margin:0px 5px;">';
	     $config['cur_tag_close'] = '</b>';
	     $this->pagination->initialize($config);
	     $page = $this->input->get('per_page');
	     
	     $data['show'] = $this->users_model->select_user1($config["per_page"], $page, $this->input->get('role_collection_id'), null, $country_code);
	     $data['links'] = $this->pagination->create_links();
	     $data['role'] = $this->users_model->select_role($this->session->userdata('role_id'));
	     $data['count'] = $this->users_model->count_record('role_id',$this->input->get('role_collection_id'), $country_code);
	     
	     $this->load->view('users/index',$data);
	}
	else
	{
	  
	     $search = $this->session->userdata('search_value') ? $this->session->userdata('search_value') : $this->input->get('q') ;
	     $config['base_url'] = base_url('users/index').'?q='.$search;
	     $config['per_page'] = 10;
	     $config["uri_segment"] = 3;
	     
	     $config['next_link'] = 'Next';
	     $config['prev_link'] = 'Prev';
	     
	     $config['first_link'] = 'First';
	     $config['last_link'] = 'Last';
	
	     $config['cur_tag_open'] = '<b style="margin:0px 5px;">';
	     $config['cur_tag_close'] = '</b>';
	     $config['total_rows'] = $this->users_model->count_record('teks',$search, $country_code);
	     $this->pagination->initialize($config);
	     $page =$this->input->get('per_page');
	     $data['show'] = $this->users_model->select_user1($config["per_page"], $page, null,$search, $country_code);

	     $data['links'] = $this->pagination->create_links();
	     $data['role'] = $this->users_model->select_role($this->session->userdata('role_id'));
	     $data['count'] = $this->users_model->count_record(null,null, $country_code);
	     
	     $this->load->view('users/index',$data);
	}
    }
    
    //view create user
    function create()
    {
	if(IsRoleFriendlyNameExist($this->user_role, array('User Management_User_All_Country_Create', 'User Management_User_Own_Country_Create')))
	{
	    $country_code = IsRoleFriendlyNameExist($this->user_role, 'User Management_User_All_Country_Create') ? NULL : $this->session->userdata('country');
	    
	    $data = array(
		      'role' => $this->users_model->select_role($this->session->userdata('role_id'), $country_code),
		      'group' => $this->users_model->select_group($country_code == null ? null : array('country_code' => $country_code)),
		      'double' => NULL,
		      'doubleUser' => NULL
		      );
	    //echo "<pre>".print_r($data['role'])."</pre>";
	    $this->load->view('users/create_user',$data);
	}
	else{
	    redirect('users');
	}
        
    }
    
    function insert_user()
    {
	  if(IsRoleFriendlyNameExist($this->user_role,
				     array('User Management_User_All_Country_Create',
					   'User Management_User_Own_Country_Create'))){
	  if(isset($_POST['Create']))
	  {
	       $this->form_validation->set_rules('username', 'User Name', 'required');
	       $this->form_validation->set_rules('fullName', 'Full Name', 'required');
	       $this->form_validation->set_rules('displayName', 'Display Name', 'required');
	       $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
	       $this->form_validation->set_rules('description');
	       $this->form_validation->set_rules('location');
	       $this->form_validation->set_rules('web_address');
	       //if (empty($_FILES['userfile']['name']))
	       //{
		//   $this->form_validation->set_rules('userfile', 'Image', 'required');
	       //}
	  
	       $checkMail = $this->users_model->check_email($this->input->post('email'));
	       $checkUser = $this->users_model->check_user($this->input->post('username'));
	       
	       if($this->form_validation->run() == FALSE)
	       {
		    $data = array(
		      'role' => $this->users_model->select_role($this->session->userdata('role_id')),
		      'group' => $this->users_model->select_group(),
		      'double' => NULL,
		      'doubleUser' => NULL
		      );
		    $this->load->view('users/create_user',$data);
	       }
	       
	       elseif($checkUser->num_rows() >= 1)
	       {
		    $data = array(
		      'role' => $this->users_model->select_role($this->session->userdata('role_id')),
		      'group' => $this->users_model->select_group(),
		      'doubleUser' => 1,
		      'double' => NULL
		      );
		    $this->load->view('users/create_user',$data);
	       }
	       
	       elseif($checkMail->num_rows() >= 1)
	       {
		    $data = array(
		      'role' => $this->users_model->select_role($this->session->userdata('role_id')),
		      'group' => $this->users_model->select_group(),
		      'double' => 1,
		      'doubleUser' => NULL
		      );
		    $this->load->view('users/create_user',$data);
	       }
	       
	       else
	       {
	       $config = array(
			      'upload_path'   => './media/dynamic/',
			      'allowed_types' => 'gif|jpg|png',
			      'max_size'      => '2048',
			      'max_width'     => '1024',
			      'max_height'    => '768'
			       );
	       
	       $this->upload->initialize($config);
	       /*if ( ! $this->upload->do_upload())
		{
		    //$this->upload->display_errors();
		    $this->session->set_flashdata('failed', $this->upload->display_errors());
		    redirect('users/create');
		}*/
		
		//else
		//{
		    $image = $this->upload->data();
		    if (empty($_FILES['userfile']['name']))
		    {
			 $dir = NULL;
		    }
		    else
		    {
			$dir = "media/dynamic/".$image['file_name']; 
		    }
		    
		    
		    $lower = 'abcdefghijklmnopqrstuvwxyz';
		    $upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		    $number = '0123456789';
		    $simbol = '!@~';
		    
		    $clower = mb_strlen($lower);
		    $cupper = mb_strlen($upper);
		    $cnumber = mb_strlen($number);
		    $csimbol = mb_strlen($simbol);
		    
		    for ($i = 0, $low = ''; $i < 3; $i++) {
			$index1 = rand(0, $clower - 1);
			$low  .= mb_substr($lower, $index1, 1);
		    }
		    
		    for ($i = 0, $up = ''; $i < 3; $i++) {
			$index2 = rand(0, $cupper - 1);
			$up  .= mb_substr($upper, $index2, 1);
		    }
		    
		    for ($i = 0, $num = ''; $i < 2; $i++) {
			$index3 = rand(0, $cnumber - 1);
			$num  .= mb_substr($number, $index3, 1);
		    }
		    
		    for ($i = 0, $sim = ''; $i < 2; $i++) {
			$index4 = rand(0, $csimbol - 1);
			$sim  .= mb_substr($simbol, $index4, 1);
		    }
		    
		    $pass = str_shuffle(mb_substr($low.$up.$num.$sim,0,10));
		    
		    $created_by = $this->session->userdata('user_id') == 0 ? NULL : $this->session->userdata('user_id');
		    $timezone = new DateTimeZone("Europe/London");
		    $time = new DateTime(date("Y-m-d H:i:s e"), $timezone);
		    $data=array(
				'username' => $this->input->post('username'),
				'full_name' => $this->input->post('fullName'),
				'display_name' => $this->input->post('displayName'),
				'email' => $this->input->post('email'),
				'password' => do_hash($pass.time(),'md5'),
				'salt' => time(),
				'role_id' => $this->input->post('optRole'),
				'group_id' => $this->input->post('optGroup'),
				'timezone' => $this->input->post('timezone'),
				'is_active' => 1,
				'image_url' => $dir,
				'description' => $this->input->post('description'),
				'location' => $this->input->post('location'),
				'web_address' => $this->input->post('web_address'),
				'created_at' => $time->format("Y-m-d H:i:s"),
				'country_code' => $this->input->post('country'),
				'created_by' => $created_by
			 );
		    
		    $this->users_model->insert_user($data);
		    $this->load->config('mail_config');
		    $this->email->set_newline("\r\n");
		    
		    $mail_config = $this->config->item('mail_provider');
		    $this->email->initialize($mail_config);
		    $mail_from = $this->config->item('mail_from');
		    $this->email->from($mail_from['address'], $mail_from['name']);
		    $this->email->to($this->input->post('email'));
		    $this->email->bcc($mail_from['cc']); 
		    $this->email->subject('New User Registration');
		    $template = curl_get_file_contents(base_url('mail_template/NewUser/'.$this->input->post('username').'/'.urlencode($pass)));
		    $this->email->message($template);
		    $this->email->send();
		    //print_r($template);
		    //echo $this->email->print_debugger();
		    $this->session->set_flashdata('succes', TRUE);
		    redirect('users');
		//}
	       }
	       
	  }
	  }
	  else
	  {
	       redirect('users');
	  }
    }
    
    function edit($id)
    {
	if(IsRoleFriendlyNameExist($this->user_role, array('User Management_User_Own_Country_Edit',
							'User Management_User_All_Country_Edit')))
	{
	    $country_code = IsRoleFriendlyNameExist($this->user_role, 'User Management_User_All_Country_Edit') ? NULL : $this->session->userdata('country');
	    $data = array(
			'id' => $this->users_model->get_byid($id),
			'role' => $this->users_model->select_role($this->session->userdata('role_id'), $country_code),
			'group' => $country_code != null ? $this->users_model->select_group(array('country_code' => $country_code)) :
				    $this->users_model->select_group(),
			'double' => NULL
			);
	  $this->load->view('users/edit_user',$data);
	}
	else{
	    redirect('users');
	}
    }
    
    function update_user()
    {
     if(IsRoleFriendlyNameExist($this->user_role, array('User Management_User_Own_Country_Edit',
							'User Management_User_All_Country_Edit')))
	{
	  $config = array(
			      'upload_path'   => 'media/dynamic/',
			      'allowed_types' => 'gif|jpg|png',
			      'max_size'      => '2048',
			      'max_width'     => '1024',
			      'max_height'    => '768'
			       );
	       
	  $this->upload->initialize($config);
	       
	  $this->form_validation->set_rules('fullName', 'Full Name', 'required');
	  $this->form_validation->set_rules('displayName', 'Display Name', 'required');
	  $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
	  $this->form_validation->set_rules('description');
	  $this->form_validation->set_rules('location');
	  $this->form_validation->set_rules('web_address');
	  
	  $checkMail = $this->users_model->check_email($this->input->post('email'));
	  $email = $this->input->post('email');
	  $email1 = $this->input->post('email1');
	  
	  if($this->form_validation->run() == FALSE)
	  {
	       $data = array(
		   'id' => $this->users_model->get_byid($this->input->post('userID')),
		   'role' => $this->users_model->select_role(),
		   'group' => $this->users_model->select_group(),
		   'double' => NULL
		   );
	       $this->load->view('users/edit_user',$data);
	  }
	  
	  elseif($checkMail->num_rows() >= 1)
	  {
	       if($email!=$email1)
	       {
		    $data = array(
			'id' => $this->users_model->get_byid($this->input->post('userID')),
			'role' => $this->users_model->select_role(),
			'group' => $this->users_model->select_group(),
			'double' => 1
			);
		    $this->load->view('users/edit_user',$data);
	       }
	       else
	       {
		    if(!empty($_FILES['userfile']['tmp_name']))
		    {
			 if ( ! $this->upload->do_upload())
			  {
			      //$this->upload->display_errors();
			      //$this->session->set_flashdata('failed', TRUE);
			      redirect('users');
			  }
			  else
			  {
			      $image = $this->upload->data();
			      $dir = "media/dynamic/".$image['file_name'];
			      
			      $id = $this->input->post('userID');
			      $data = array(
					  'full_name' => $this->input->post('fullName'),
					  'display_name' => $this->input->post('displayName'),
					  'email' => $this->input->post('email'),
					  'role_id' => $this->input->post('optRole'),
					  'group_id' => $this->input->post('optGroup'),
					  'image_url' => $dir,
					  'description' => $this->input->post('description'),
					  'location' => $this->input->post('location'),
					  'timezone' => $this->input->post('timezone'),
					  'web_address' =>$this->input->post('web_address'),
					  'is_active' => $this->input->post('is_active'),
					  'country_code' => $this->input->post('country')
					    );
			      
			      $this->users_model->update_user($id,$data);
			      
			      $username = $this->session->userdata('user_id');
			      $user_login = $this->users_model->select_user_login($username);
			      
			      $data1 = array(
					  'user_id' => $username,
					  'username' => $user_login->row()->username,
					  'full_name'=> $user_login->row()->full_name,
					  'display_name' => $user_login->row()->display_name,
					  'role_name' => $user_login->row()->role_name,
					  'web_address' => $user_login->row()->web_address,
					  'image_url' => $user_login->row()->image_url,
					  'timezone' => $user_login->row()->timezone,
					  'description' => $user_login->row()->description,
					  'is_login' => TRUE
				      );
			      $this->session->set_userdata($data1);
			      
			      $this->session->set_flashdata('info', TRUE);
			      redirect('users');
			  }
		    }
		    
		    elseif(empty($_FILES['userfile']['tmp_name']))
		    {
			      $id = $this->input->post('userID');
			      $data = array(
					  'full_name' => $this->input->post('fullName'),
					  'display_name' => $this->input->post('displayName'),
					  'email' => $this->input->post('email'),
					  'role_id' => $this->input->post('optRole'),
					  'group_id' => $this->input->post('optGroup'),
					  'description' => $this->input->post('description'),
					  'location' => $this->input->post('location'),
					  'timezone' => $this->input->post('timezone'),
					  'web_address' =>$this->input->post('web_address'),
					  'is_active' => $this->input->post('is_active'),
					  'country_code' => $this->input->post('country')
					    );
			      
			      $this->users_model->update_user($id,$data);
			      
			      $username = $this->session->userdata('user_id');
			      $user_login = $this->users_model->select_user_login($username);
			      
			      $data1 = array(
					  'user_id' => $username,
					  'username' => $user_login->row()->username,
					  'full_name'=> $user_login->row()->full_name,
					  'display_name' => $user_login->row()->display_name,
					  'role_name' => $user_login->row()->role_name,
					  'web_address' => $user_login->row()->web_address,
					  'timezone' => $user_login->row()->timezone,
					  'description' => $user_login->row()->description,
					  'country' => $user_login->row()->country_code,
					  'is_login' => TRUE
				      );
			      $this->session->set_userdata($data1);
			      
			      $this->session->set_flashdata('info', TRUE);
			      redirect('users');
		    }
	       }
	  }
	  
	  else
	  {    
	       if(!empty($_FILES['userfile']['tmp_name']))
	       {
		    if ( ! $this->upload->do_upload())
		     {
			 //$this->upload->display_errors();
			 //$this->session->set_flashdata('failed', TRUE);
			 redirect('users');
		     }
		     else
		     {
			 $image = $this->upload->data();
			 $dir = "media/dynamic/".$image['file_name'];
			 
			 $id = $this->input->post('userID');
			 $data = array(
				     'full_name' => $this->input->post('fullName'),
				     'display_name' => $this->input->post('displayName'),
				     'email' => $this->input->post('email'),
				     'role_id' => $this->input->post('optRole'),
				     'group_id' => $this->input->post('optGroup'),
				     'image_url' => $dir,
				     'description' => $this->input->post('description'),
				     'location' => $this->input->post('location'),
				     'timezone' => $this->input->post('timezone'),
				     'web_address' =>$this->input->post('web_address'),
				     'is_active' => $this->input->post('is_active')
				       );
			 
			 $this->users_model->update_user($id,$data);
			 
			 $username = $this->session->userdata('user_id');
			 $user_login = $this->users_model->select_user_login($username);
			 
			 $data1 = array(
				     'user_id' => $username,
				     'username' => $user_login->row()->username,
				     'full_name'=> $user_login->row()->full_name,
				     'display_name' => $user_login->row()->display_name,
				     'role_name' => $user_login->row()->role_name,
				     'web_address' => $user_login->row()->web_address,
				     'image_url' => $user_login->row()->image_url,
				     'timezone' => $user_login->row()->timezone,
				     'description' => $user_login->row()->description,
				     'is_login' => TRUE
				 );
			 $this->session->set_userdata($data1);
			 
			 $this->session->set_flashdata('info', TRUE);
			 redirect('users');
		     }
	       }
	       
	       elseif(empty($_FILES['userfile']['tmp_name']))
	       {
			 $id = $this->input->post('userID');
			 $data = array(
				     'full_name' => $this->input->post('fullName'),
				     'display_name' => $this->input->post('displayName'),
				     'email' => $this->input->post('email'),
				     'role_id' => $this->input->post('optRole'),
				     'group_id' => $this->input->post('optGroup'),
				     'description' => $this->input->post('description'),
				     'location' => $this->input->post('location'),
				     'timezone' => $this->input->post('timezone'),
				     'web_address' =>$this->input->post('web_address'),
				     'is_active' => $this->input->post('is_active')
				       );
			 
			 $this->users_model->update_user($id,$data);
			 
			 $username = $this->session->userdata('user_id');
			 $user_login = $this->users_model->select_user_login($username);
			 
			 $data1 = array(
				     'user_id' => $username,
				     'username' => $user_login->row()->username,
				     'full_name'=> $user_login->row()->full_name,
				     'display_name' => $user_login->row()->display_name,
				     'role_name' => $user_login->row()->role_name,
				     'web_address' => $user_login->row()->web_address,
				     'timezone' => $user_login->row()->timezone,
				     'description' => $user_login->row()->description,
				     'is_login' => TRUE
				 );
			 $this->session->set_userdata($data1);
			 
			 $this->session->set_flashdata('info', TRUE);
			 redirect('users');
	       }
	  }
	  }
	  else{
		  redirect('users');
	      }
    }
    
    function delete($id)
    {
        if(IsRoleFriendlyNameExist($this->user_role, array('User Management_Role_Own_Country_Delete', 'User Management_Role_All_Country_Delete')))
	{
	  $this->users_model->delete_user($id);
	  $this->session->set_flashdata('info_delete', TRUE);
	  redirect('users');
	}
	else
	{
	  redirect('users');
	}
    }
    //============================END USER=================================
    
    //============================ ROLE ===================================
    function menu_role()
    {
	if(IsRoleFriendlyNameExist($this->user_role, array('User Management_Role_Own_Country_View',
							'User Management_Role_All_Country_View'))){  
	  $select_role = $this->users_model->select_role();
	  $country_code = IsRoleFriendlyNameExist($this->user_role, 'User Management_Role_All_Country_View') ? NULL : $this->session->userdata('country');
	  foreach($select_role->result() as $v1)
	  {
	       $select_user = $this->users_model->count_role_user($v1->role_collection_id);
	       $count_role[] = $select_user->row()->count_role;
	  }
	  
	  $config['base_url'] = base_url().'users/menu_role';
	  $config['total_rows'] = $this->users_model->count_record_role();
	  $config['per_page'] = 10;
	  $config["uri_segment"] = 3;
	  
	  $config['next_link'] = 'Next';
	  $config['prev_link'] = 'Prev';
	  
	  $config['first_link'] = 'First';
	  $config['last_link'] = 'Last';
     
	  $config['cur_tag_open'] = '<b style="margin:0px 5px;">';
	  $config['cur_tag_close'] = '</b>';
	  
	  $this->pagination->initialize($config);
	  
	  $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
	  $data['show'] = $this->users_model->select_role1($config["per_page"], $page, $country_code);
	  $data['count_role'] = $count_role;
	  $data['links'] = $this->pagination->create_links();
	  $data['count'] = $this->users_model->count_record_role();
	  $data['msg_role'] = NULL;
	  $data['role_check'] = NULL;
	  $data['plus'] = $this->uri->segment(3);
	  
	  $roles = $this->users_model->select_appRole();
	  $arr = array();
	  $tree = array();
	  $i = 0;
	  
	  foreach($roles->result_array() as $v)
	  {
	       $arr[$v['app_role_id']] = array_merge(array("label" => $v['role_name'], "parent_id" => $v['parent_id'] , "value" => $v['app_role_id']), array('items' => array()));
	  }
	  
	  foreach($arr as $role_app_id => &$value)
	  {
	       if(!$value['parent_id'] || !array_key_exists($value['parent_id'], $arr))
	       {
		    $tree[] = &$value;
	       } else {
		    $arr[$value['parent_id']]['items'][] = &$value;
	       }
	  }
	  
	  $data['json'] = json_encode($tree);
	  
	  $this->load->view('users/role',$data);
	  }
	  else{
	  redirect('users');
	  }
     }
    
    function insert_role()
    {
	  $data['plus'] = $this->uri->segment(3);
	  if(IsRoleFriendlyNameExist($this->user_role, array('User Management_Role_Own_Country_Create',
							'User Management_Role_All_Country_Create'))){
	  $select_role = $this->users_model->select_role();
	  foreach($select_role->result() as $v1)
	  {
	       $select_user = $this->users_model->count_role_user($v1->role_collection_id);
	       $count_role[] = $select_user->row()->count_role;
	  }
	  $name_role = $this->input->post('new_role');
	  $check_role = $this->users_model->check_role($name_role);
	  $cek = $this->input->post('role');
     
	  $this->form_validation->set_rules('new_role', 'Role Name', 'required');
	  if($this->form_validation->run() == FALSE)
	    {
		 $config['base_url'] = base_url().'users/menu_role';
		 $config['total_rows'] = $this->users_model->count_record_role();
		 $config['per_page'] = 10;
		 $config["uri_segment"] = 3;
		 
		 $config['next_link'] = 'Next';
		 $config['prev_link'] = 'Prev';
		 
		 $config['first_link'] = 'First';
		 $config['last_link'] = 'Last';
	    
		 $config['cur_tag_open'] = '<b style="margin:0px 5px;">';
		 $config['cur_tag_close'] = '</b>';
		 
		 $this->pagination->initialize($config);
		 
		 $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		 $data['show'] = $this->users_model->select_role1($config["per_page"], $page);
		 $data['count_role'] = $count_role;
		 $data['msg_role'] = NULL;
		 $data['role_check'] = NULL;
	    
		 $data['links'] = $this->pagination->create_links();
		 $data['count'] = $this->users_model->count_record_role();
		 
		 $roles = $this->users_model->select_appRole();
		 $arr = array();
		 $tree = array();
		 $i = 0;
		 
		 foreach($roles->result_array() as $v)
		 {
		      $arr[$v['app_role_id']] = array_merge(array("label" => $v['role_name'], "parent_id" => $v['parent_id'] , "value" => $v['app_role_id']), array('items' => array()));
		 }
		 
		 foreach($arr as $role_app_id => &$value)
		 {
		      if(!$value['parent_id'] || !array_key_exists($value['parent_id'], $arr))
		      {
			   $tree[] = &$value;
		      } else {
			   $arr[$value['parent_id']]['items'][] = &$value;
		      }
		 }
		 
		 $data['json'] = json_encode($tree);
		 
		 $this->load->view('users/role',$data);
	    }
	  elseif($cek[0]=="")
	  {
	       $select_role = $this->users_model->select_role();
	       foreach($select_role->result() as $v1)
	       {
		    $select_user = $this->users_model->count_role_user($v1->role_collection_id);
		    $count_role[] = $select_user->row()->count_role;
	       }
	       
	       $config['base_url'] = base_url().'users/menu_role';
	       $config['total_rows'] = $this->users_model->count_record_role();
	       $config['per_page'] = 10;
	       $config["uri_segment"] = 3;
	       
	       $config['next_link'] = 'Next';
	       $config['prev_link'] = 'Prev';
	       
	       $config['first_link'] = 'First';
	       $config['last_link'] = 'Last';
	  
	       $config['cur_tag_open'] = '<b style="margin:0px 5px;">';
	       $config['cur_tag_close'] = '</b>';
	       
	       $this->pagination->initialize($config);
	       
	       $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
	       $data['show'] = $this->users_model->select_role1($config["per_page"], $page);
	       $data['count_role'] = $count_role;
	       $data['links'] = $this->pagination->create_links();
	       $data['count'] = $this->users_model->count_record_role();
	       $data['msg_role'] = NULL;
	       $data['role_check'] = 1;
	       
	       $roles = $this->users_model->select_appRole();
	       $arr = array();
	       $tree = array();
	       $i = 0;
	       
	       foreach($roles->result_array() as $v)
	       {
		    $arr[$v['app_role_id']] = array_merge(array("label" => $v['role_name'], "parent_id" => $v['parent_id'] , "value" => $v['app_role_id']), array('items' => array()));
	       }
	       
	       foreach($arr as $role_app_id => &$value)
	       {
		    if(!$value['parent_id'] || !array_key_exists($value['parent_id'], $arr))
		    {
			 $tree[] = &$value;
		    } else {
			 $arr[$value['parent_id']]['items'][] = &$value;
		    }
	       }
	       
	       $data['json'] = json_encode($tree);
	       
	       $this->load->view('users/role',$data);
	  }
	  elseif($check_role->num_rows()>=1)
	  {
	    $config['base_url'] = base_url().'users/menu_role';
	    $config['total_rows'] = $this->users_model->count_record_role();
	    $config['per_page'] = 10;
	    $config["uri_segment"] = 3;
	    
	    $config['next_link'] = 'Next';
	    $config['prev_link'] = 'Prev';
	    
	    $config['first_link'] = 'First';
	    $config['last_link'] = 'Last';
       
	    $config['cur_tag_open'] = '<b style="margin:0px 5px;">';
	    $config['cur_tag_close'] = '</b>';
	    
	    $this->pagination->initialize($config);
	    
	    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
	    $data['show'] = $this->users_model->select_role1($config["per_page"], $page);
	    $data['count_role'] = $count_role;
	    $data['msg_role'] = 1;
	    $data['role_check'] = NULL;
       
	    $data['links'] = $this->pagination->create_links();
	    $data['count'] = $this->users_model->count_record_role();
	    
	    $roles = $this->users_model->select_appRole();
	    $arr = array();
	    $tree = array();
	    $i = 0;
	    
	    foreach($roles->result_array() as $v)
	    {
		 $arr[$v['app_role_id']] = array_merge(array("label" => $v['role_name'], "parent_id" => $v['parent_id'] , "value" => $v['app_role_id']), array('items' => array()));
	    }
	    
	    foreach($arr as $role_app_id => &$value)
	    {
		 if(!$value['parent_id'] || !array_key_exists($value['parent_id'], $arr))
		 {
		      $tree[] = &$value;
		 } else {
		      $arr[$value['parent_id']]['items'][] = &$value;
		 }
	    }
	    
	    $data['json'] = json_encode($tree);
	    
	    $this->load->view('users/role',$data);
	  }
	  else{
	       $timezone = new DateTimeZone("Europe/London");
	       $time = new DateTime(date("Y-m-d H:i:s e"), $timezone);
	       $created_at = $time->format("Y-m-d H:i:s");
	       $created_by = $this->session->userdata('user_id');
	       
	       $role = $this->input->post('role');
	       $tampung = explode(",", $role[0]);
	       
	       $data = array(
			      'role_name' => $this->input->post('new_role'),
			      'created_by' => $created_by,
			      'created_at' => $created_at,
			      'country_code' => $this->input->post('country_code')
			     );
	       $this->users_model->insert_role($data);
	       
	       $last_id=$this->db->insert_id();
	       
	       for($i=0;$i<count($tampung);$i++)
	       {
		    $data1 = array(
				   'role_collection_id' => $last_id,
				   'app_role_id' => $tampung[$i]
				   );
		    $this->users_model->insert_role_detail($data1);
	       }
	       $this->session->set_flashdata('succes', TRUE);
	       redirect('users/menu_role');
	  }
	  }
	  else{
	       redirect('users');
	  }
    }
    
    function delete_role($id)
    {
     if(IsRoleFriendlyNameExist($this->user_role, array('User Management_Role_Own_Country_Delete',
							'User Management_Role_All_Country_Delete'))){
	  $cek_roleid = $this->users_model->cek_roleid($id);
	  if($cek_roleid->num_rows()==0)
	  {
	       $this->users_model->delete_role($id);
	       $this->session->set_flashdata('info_delete', TRUE);
	       redirect('users/menu_role');
	  }
	  else
	  {
	       $this->session->set_flashdata('info_delete_failed', TRUE);
	       redirect('users/menu_role');
	  }
     }
     else
     {
	  redirect('users');
     }
    }
    
    function edit_role($id)
    {
	$data = array(
		       'role' => $this->users_model->edit_role($id)
		      );
	
	$roles = $this->users_model->select_appRole();
	$role_detail = $this->users_model->edit_role_detail($id);
	$data['msg_role'] = NULL;
	$data['role_check'] = NULL;
	
	$arr = array();
	$tree = array();
	$i = 0;
	$c = array();
	foreach($role_detail->result_array() as $d){
	     $c[] = $d['app_role_id']; 
	}
	
	foreach($roles->result_array() as $v)
	{
	     if (in_array($v['app_role_id'], $c)) {
		  $checked = true;
	      }
	      else{
		  $checked = false;
	      }
	     
	    $arr[$v['app_role_id']] = array_merge(array("label" => $v['role_name'], "parent_id" => $v['parent_id'] , "value" => $v['app_role_id'], "checked" => $checked), array('items' => array()));
	}
	
	foreach($arr as $role_app_id => &$value)
	{
	     if(!$value['parent_id'] || !array_key_exists($value['parent_id'], $arr))
	     {
		  $tree[] = &$value;
	     } else {
		  $arr[$value['parent_id']]['items'][] = &$value;
	     }
	}
	
	$data['json'] = json_encode($tree);
	
	
	$this->load->view('users/role_edit',$data);
    }
    
    function update_role()
    {
     if(IsRoleFriendlyNameExist($this->user_role, array('User Management_Role_Own_Country_Edit',
							'User Management_Role_All_Country_Edit'))){
	  $this->form_validation->set_rules('role_name', 'Role Name', 'required');
	  $this->form_validation->set_rules('role','Role Permission', 'required');
	  $cek = $this->input->post('role');
	  
	  $role_name = $this->input->post('role_name');
	  $role_name1 = $this->input->post('role_name1');
	  
	  $check_role = $this->users_model->check_role($role_name);
	  
	  if($this->form_validation->run() == FALSE)
	  {
	       $id = $this->input->post('role_id');
	       $data = array(
			 'role' => $this->users_model->edit_role($id)
			);
	  
	       $roles = $this->users_model->select_appRole();
	       $role_detail = $this->users_model->edit_role_detail($id);
	       $data['msg_role'] = NULL;
	       $data['role_check'] = NULL;
	       
	       $arr = array();
	       $tree = array();
	       $i = 0;
	       
	       foreach($role_detail->result_array() as $d){
		    $c[] = $d['app_role_id']; 
	       }
	       
	       foreach($roles->result_array() as $v)
	       {
		    if (in_array($v['app_role_id'], $c)) {
			 $checked = true;
		     }
		     else{
			 $checked = false;
		     }
		    
		   $arr[$v['app_role_id']] = array_merge(array("label" => $v['role_name'], "parent_id" => $v['parent_id'] , "value" => $v['app_role_id'], "checked" => $checked), array('items' => array()));
	       }
	       
	       foreach($arr as $role_app_id => &$value)
	       {
		    if(!$value['parent_id'] || !array_key_exists($value['parent_id'], $arr))
		    {
			 $tree[] = &$value;
		    } else {
			 $arr[$value['parent_id']]['items'][] = &$value;
		    }
	       }
	       
	       $data['json'] = json_encode($tree);
	       
	       
	       $this->load->view('users/role_edit',$data);
	  }
	  
	  elseif ($cek[0]=="")
	  {
	       $id = $this->input->post('role_id');
	       $data = array(
			 'role' => $this->users_model->edit_role($id)
			);
	  
	       $roles = $this->users_model->select_appRole();
	       $role_detail = $this->users_model->edit_role_detail($id);
	       $data['msg_role'] = NULL;
	       $data['role_check'] = 1;
	       
	       $arr = array();
	       $tree = array();
	       $i = 0;
	       
	       foreach($role_detail->result_array() as $d){
		    $c[] = $d['app_role_id']; 
	       }
	       
	       foreach($roles->result_array() as $v)
	       {
		    if (in_array($v['app_role_id'], $c)) {
			 $checked = true;
		     }
		     else{
			 $checked = false;
		     }
		    
		   $arr[$v['app_role_id']] = array_merge(array("label" => $v['role_name'], "parent_id" => $v['parent_id'] , "value" => $v['app_role_id'], "checked" => $checked), array('items' => array()));
	       }
	       
	       foreach($arr as $role_app_id => &$value)
	       {
		    if(!$value['parent_id'] || !array_key_exists($value['parent_id'], $arr))
		    {
			 $tree[] = &$value;
		    } else {
			 $arr[$value['parent_id']]['items'][] = &$value;
		    }
	       }
	       
	       $data['json'] = json_encode($tree);
	       
	       
	       $this->load->view('users/role_edit',$data);
	  }
	  
	  elseif($check_role->num_rows()>=1)
	  {
	       if(strtolower($role_name)!=strtolower($role_name1))
	       {
		    $id = $this->input->post('role_id');
		    $data = array(
			      'role' => $this->users_model->edit_role($id)
			     );
	       
		    $roles = $this->users_model->select_appRole();
		    $role_detail = $this->users_model->edit_role_detail($id);
		    $data['msg_role'] = 1;
		    $data['role_check'] = NULL;
		    
		    $arr = array();
		    $tree = array();
		    $i = 0;
		    
		    foreach($role_detail->result_array() as $d){
			 $c[] = $d['app_role_id']; 
		    }
		    
		    foreach($roles->result_array() as $v)
		    {
			 if (in_array($v['app_role_id'], $c)) {
			      $checked = true;
			  }
			  else{
			      $checked = false;
			  }
			 
			$arr[$v['app_role_id']] = array_merge(array("label" => $v['role_name'], "parent_id" => $v['parent_id'] , "value" => $v['app_role_id'], "checked" => $checked), array('items' => array()));
		    }
		    
		    foreach($arr as $role_app_id => &$value)
		    {
			 if(!$value['parent_id'] || !array_key_exists($value['parent_id'], $arr))
			 {
			      $tree[] = &$value;
			 } else {
			      $arr[$value['parent_id']]['items'][] = &$value;
			 }
		    }
		    
		    $data['json'] = json_encode($tree);
		    
		    
		    $this->load->view('users/role_edit',$data);
	       }
	       elseif(strtolower($role_name)==strtolower($role_name1))
	       {
		    $data = array(
				   'role_name' => $this->input->post('role_name'),
				   'country_code' => $this->input->post('country_code')
				  );
		    $id = $this->input->post('role_id');
		    $this->users_model->update_role($id,$data);
		    
		    $role = $this->input->post('role');
		    
		    $tampung = explode(',',$role[0]);
		    $this->users_model->delete_role_detail($id);
		    for($i=0;$i<count($tampung);$i++)
		    {
			 $data1 = array(
					'role_collection_id' => $id,
					'app_role_id' => $tampung[$i]
					);
			 $this->users_model->insert_role_detail($data1);
		    }
		    $this->session->set_flashdata('info', TRUE);
		    redirect('users/menu_role');
	       }
	  }
	  
	  else
	  {
	       $data = array(
			      'role_name' => $this->input->post('role_name')
			     );
	       $id = $this->input->post('role_id');
	       $this->users_model->update_role($id,$data);
	       
	       $role = $this->input->post('role');
	       
	       $tampung = explode(',',$role[0]);
	       $this->users_model->delete_role_detail($id);
	       for($i=0;$i<count($tampung);$i++)
	       {
		    $data1 = array(
				   'role_collection_id' => $id,
				   'app_role_id' => $tampung[$i]
				   );
		    $this->users_model->insert_role_detail($data1);
	       }
	       $this->session->set_flashdata('info', TRUE);
	       redirect('users/menu_role');
	  }
    }
    else{
     redirect('users');
    }
    }
    //============================END ROLE=================================
    
    
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
	$country_code = IsRoleFriendlyNameExist($this->user_role, 'User Management_Group_All_Country_View') ? NULL : $this->session->userdata('country');
     if(IsRoleFriendlyNameExist($this->user_role, array('User Management_Group_All_Country_View', 'User Management_Group_Own_Country_View'))){
	  $select_group = $this->users_model->select_group();
	  foreach($select_group->result() as $v1)
	  {
	       $select_user = $this->users_model->count_group_user($v1->group_id);
	       $count_group[] = $select_user->row()->count_group; 
	  }
	  
	  $config['base_url'] = base_url().'users/menu_group';
	  $config['total_rows'] = $this->users_model->count_record_group($country_code);
	  $config['per_page'] = 10;
	  $config["uri_segment"] = 3;
	  
	  $config['next_link'] = 'Next';
	  $config['prev_link'] = 'Prev';
	  
	  $config['first_link'] = 'First';
	  $config['last_link'] = 'Last';
     
	  $config['cur_tag_open'] = '<b style="margin:0px 5px;">';
	  $config['cur_tag_close'] = '</b>';
	  
	  $this->pagination->initialize($config);
	  
	  $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
	  $data['group'] = $this->users_model->select_group1($config["per_page"], $page, $country_code);
	  $data['count_group'] = $count_group;
	  $data['plus'] = $this->uri->segment(3);
     
	  $data['links'] = $this->pagination->create_links();
	  $data['count'] = $this->users_model->count_record_group($country_code);
	  $data['channel'] = $this->users_model->select_channel($country_code);
	  $data['group_detail'] = $this->users_model->select_user_group_d();
	    $data['country_list'] = $this->users_model->get_country_list();
	  $this->load->view('users/group',$data);
     }
     else{
	  redirect('users');
     }
    }
    
    function insert_group()
    {
	$country_code = IsRoleFriendlyNameExist($this->user_role, 'User Management_Group_All_Country_Create') ? NULL : $this->session->userdata('country');
	if(IsRoleFriendlyNameExist($this->user_role, array('User Management_Group_All_Country_Create', 'User Management_Group_Own_Country_Create'))){
	    $select_group = $this->users_model->select_group();
	    foreach($select_group->result() as $v1)
	    {
		$select_user = $this->users_model->count_group_user($v1->group_id);
		$count_group[] = $select_user->row()->count_group; 
	    }
	  $data['plus'] = $this->uri->segment(3);
	  if ($this->input->post('channel')==NULL)
	  {
	      $this->form_validation->set_rules('channel', 'Channel', 'required');
	  }
	  $this->form_validation->set_rules('group_name', 'Group Name', 'required');
	  
	  $group = $this->input->post('group_name');
	  $cek = $this->users_model->select_byName($group);
	  if($cek->num_rows()>=1)
	  {
	       $this->session->set_flashdata('double', TRUE);
	       redirect('users/menu_group');
	  }
	  elseif($this->form_validation->run() == FALSE)
	  {
	       $config['base_url'] = base_url().'users/menu_group';
	       $config['total_rows'] = $this->users_model->count_record_group($country_code);
	       $config['per_page'] = 10;
	       $config["uri_segment"] = 3;
	       
	       $config['next_link'] = 'Next';
	       $config['prev_link'] = 'Prev';
	       
	       $config['first_link'] = 'First';
	       $config['last_link'] = 'Last';
	  
	       $config['cur_tag_open'] = '<b style="margin:0px 5px;">';
	       $config['cur_tag_close'] = '</b>';
	       
	       $this->pagination->initialize($config);
	       
	       $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
	       $data['group'] = $this->users_model->select_group1($config["per_page"], $page);
	       $data['count_group'] = $count_group;
	  
	       $data['links'] = $this->pagination->create_links();
	       $data['count'] = $this->users_model->count_record_group();
	       $data['channel'] = $this->users_model->select_channel();
	       $data['group_detail'] = $this->users_model->select_user_group_d();
			     
	       $this->load->view('users/group',$data);
	  }
	  else{
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
		    if(IsRoleFriendlyNameExist($this->user_role, 'Regional_User'))
			$data['country_code'] = $this->input->post('country');
		    else
			$data['country_code'] = $this->session->userdata('country');
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
		    $this->session->set_flashdata('succes', TRUE);
		    redirect('users/menu_group');
	  }
    }
    else
    {
     redirect('users');
    }
    }
    
    function delete_group($id)
    {
     if(IsRoleFriendlyNameExist($this->user_role, array('User Management_Group_All_Country_Delete', 'User Management_Group_Own_Country_Delete'))){
	  $check_groupid = $this->users_model->check_groupid($id);
	  if($check_groupid->num_rows()==0)
	  {
	       $data = $this->users_model->delete_group($id);
	       $this->session->set_flashdata('info_delete', TRUE);
	       redirect('users/menu_group?return='.$data);
	  }
	  else
	  {
	       $this->session->set_flashdata('info_delete_failed', TRUE);
	       redirect('users/menu_group');
	  }
     }
     else
     {
	  redirect('users');
     }
    }
    
    function edit_group($id)
    {
	$country_code = IsRoleFriendlyNameExist($this->user_role, 'User Management_Group_All_Country_Edit') ? NULL : $this->session->userdata('country');
     if(IsRoleFriendlyNameExist($this->user_role, array('User Management_Group_All_Country_Edit', 'User Management_Group_Own_Country_Edit'))){
	  $data = array(
			 'group' => $this->users_model->edit_group($id),
			 'group_detail' => $this->users_model->edit_group_detail($id),
			 'channel' => $this->users_model->select_channel($country_code),
			 'msge' => NULL
			);
	  $data['country_list'] = $this->users_model->get_country_list();
	  $this->load->view('users/group_edit',$data);
    }
    else
    {
	  redirect('users');
    }
    }
    
    function update_group()
    {
     if(IsRoleFriendlyNameExist($this->user_role, array('User Management_Group_Own_Country_Edit', 'User Management_Group_All_Country_Edit'))){
	  $this->form_validation->set_rules('group_name', 'Group Name', 'required');
	  $id = $this->input->post('group_id');
	  $group = $this->input->post('group_name');
	  $group1 = $this->input->post('g_name');
	  $cek = $this->users_model->select_byName($group);
	  
	  if($this->form_validation->run() == FALSE)
	  {
	       $data = array(
			 'group' => $this->users_model->edit_group($id),
			 'group_detail' => $this->users_model->edit_group_detail($id),
			 'channel' => $this->users_model->select_channel(),
			 'msge' => NULL
			);
	       
	       $this->load->view('users/group_edit',$data);
	  }
	  
	  elseif($cek->num_rows()>=1)
	  {
	       if(strtolower($group)!=strtolower($group1))
	       {
		    $id = $this->input->post('group_id');
		    $data = array(
			      'group' => $this->users_model->edit_group($id),
			      'group_detail' => $this->users_model->edit_group_detail($id),
			      'channel' => $this->users_model->select_channel(),
			      'msge' => 1
			     );
		    $this->load->view('users/group_edit',$data);
	       }
	       else
	       {
		    $channel = $this->input->post('channel');
	       
		    $group_id = $this->input->post('group_id');
		    $data = array(
				  'group_name' => $this->input->post('group_name'),
				  'country_code' => $this->input->post('country'),
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
		    //$this->session->set_flashdata('info', TRUE);
		    redirect('users/menu_group');
	       }
	  }
	  
	  else
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
	       $this->session->set_flashdata('info', TRUE);
	       redirect('users/menu_group');
	  }
    }
    else
    {
	  redirect('users');
    }
    }
    
    function country(){
	$data['countries'] = $this->users_model->get_country();
	$this->load->view('users/country',$data);
    }
    
    //=============================END GROUP===============================
    
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
    
    //============================ COUNTRY ===============================
    function create_country()
    {
	$this->load->view('users/create_country');
    }
    
    function insert_country()
    {
	$data = array(
		      'code' => $this->input->post('code'),
		      'name' => $this->input->post('name'),
		      'created_at' => date("Y-m-d H:i:s"),
		      );
	$this->users_model->insert_country($data);
	
	redirect('users/country');
    }
    
    function edit_country($id)
    {
	$data['country'] = $this->users_model->get_country($id);
	$this->load->view('users/edit_country',$data);
    }
    
    function update_country()
    {
	$data = array(
		      'code' => $this->input->post('code'),
		      'name' => $this->input->post('name'),
		      );
	$this->users_model->update_country($this->input->post('code'),$data);
	
	redirect('users/country');
    }
    
    function delete_country($id){
	$this->users_model->delete_country($id);
	
	redirect('users/country');
    }
}
