<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MY_Controller {

    private $connection;
	   
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

	
    }
    
    function index()
    {
     $config['base_url'] = base_url().'users/index';
     $config['total_rows'] = $this->users_model->count_record();
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
     
     if($this->input->get('role_collection_id'))
	  $data['show'] = $this->users_model->select_user1($config["per_page"], $page, $this->input->get('role_collection_id'));
     else
	  $data['show'] = $this->users_model->select_user1($config["per_page"], $page, null);
     $data['links'] = $this->pagination->create_links();
     $data['role'] = $this->users_model->select_role();
     $data['count'] = $this->users_model->count_record();
     //$data['show1'] = $this->users_model->select_user();
     
     $this->load->view('users/index',$data);
    }
    
    //view create user
    function create()
    {
        $data = array(
		      'role' => $this->users_model->select_role(),
		      'group' => $this->users_model->select_group(),
		      'double' => NULL,
		      'doubleUser' => NULL
		      );
        $this->load->view('users/create_user',$data);
    }
    
    function insert_user()
    {
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
		      'role' => $this->users_model->select_role(),
		      'group' => $this->users_model->select_group(),
		      'double' => NULL,
		      'doubleUser' => NULL
		      );
		    $this->load->view('users/create_user',$data);
	       }
	       
	       elseif($checkUser->num_rows() >= 1)
	       {
		    $data = array(
		      'role' => $this->users_model->select_role(),
		      'group' => $this->users_model->select_group(),
		      'doubleUser' => 1,
		      'double' => NULL
		      );
		    $this->load->view('users/create_user',$data);
	       }
	       
	       elseif($checkMail->num_rows() >= 1)
	       {
		    $data = array(
		      'role' => $this->users_model->select_role(),
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
		    
		    /*
		    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		    $count = mb_strlen($chars);
	      
		    for ($i = 0, $pass = ''; $i < 10; $i++) {
		    $index = rand(0, $count - 1);
		    $pass .= mb_substr($chars, $index, 1);
		    }*/
		    
		    $lower = 'abcdefghijklmnopqrstuvwxyz';
		    $upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		    $number = '0123456789';
		    $simbol = '!@#$%';
		    
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
				'is_active' => 1,
				'image_url' => $dir,
				'description' => $this->input->post('description'),
				'location' => $this->input->post('location'),
				'web_address' => $this->input->post('web_address'),
				'created_at' => $time->format("Y-m-d H:i:s"),
				'created_by' => $created_by
			 );
		    
		    $this->users_model->insert_user($data);
		  
				  $this->email->set_newline("\r\n");
				  $this->email->from('tes@gmail.com','maybank');
				  $this->email->to($this->input->post('email'));
				  $this->email->cc('monitoring@kalajeda.com'); 
				  
				  $this->email->subject('New Registration');
				  $template = curl_get_file_contents(base_url('mail_template/NewUser/'.$this->input->post('username').'/'.urlencode($pass)));
				  $this->email->message($template);
				  $this->email->send();
		    
		    $this->session->set_flashdata('succes', TRUE);
		    redirect('users');
		//}
	       }
	       
	  }
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
	  
	  if($this->form_validation->run() == FALSE)
	  {
	       $data = array(
		   'id' => $this->users_model->get_byid($this->input->post('userID')),
		   'role' => $this->users_model->select_role(),
		   'group' => $this->users_model->select_group()
		   );
	       $this->load->view('users/edit_user',$data);
	  }
	  
	  /*elseif($checkMail->num_rows() >= 1)
	       {
		    $this->session->set_flashdata('double', TRUE);
		    
		    redirect('users/create');
	       }
	  */
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
				     'description' => $user_login->row()->description,
				     'is_login' => TRUE
				 );
			 $this->session->set_userdata($data1);
			 
			 $this->session->set_flashdata('info', TRUE);
			 redirect('users');
	       }
	  }
    }
    
    /*function update_user_login()
    {
	  $id = $this->input->post('user_id');
	  
	  $data = array(
			 'description' => $this->input->post('about-me'),
			 'display_name' => $this->input->post('display-name')
			);

	  $this->users_model->update_user($id,$data);
	  
	  $user_login = $this->users_model->select_user_login($id);
		    $data1 = array(
                                'user_id' => $id,
				'username' => $user_login->row()->username,
				'display_name' => $user_login->row()->display_name,
				'description' => $user_login->row()->description,
                                'is_login' => TRUE
                            );
                    $this->session->set_userdata($data1);
	  
	  redirect('users');
    }*/
    
    function delete($id)
    {
	  $this->users_model->delete_user($id);
	  $this->session->set_flashdata('info_delete', TRUE);
	  redirect('users');
    }
    
    function search_user($value_user)
    {
	  $v = urldecode($value_user);
	  
	  $config['base_url'] = base_url().'users/index';
	  $config['total_rows'] = $this->users_model->count_record();
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
	  
	  if($this->input->get('role_collection_id'))
	       $data['show'] = $this->users_model->search_user($config["per_page"], $page, $this->input->get('role_collection_id'),$v);
	  else
	       $data['show'] = $this->users_model->search_user($config["per_page"], $page, null,$v);
	  $data['links'] = $this->pagination->create_links();
	  $data['role'] = $this->users_model->select_role();
	  $data['count'] = $this->users_model->count_record();
	  
	  $this->load->view('users/index',$data);
    }
    
    //============================ ROLE ===================================
    function menu_role()
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
    
    function insert_role()
    {
	  $select_role = $this->users_model->select_role();
	  foreach($select_role->result() as $v1)
	  {
	       $select_user = $this->users_model->count_role_user($v1->role_collection_id);
	       $count_role[] = $select_user->row()->count_role;
	  }
     
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
			      'created_at' => $created_at
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
    
    function delete_role($id)
    {
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
    
    function edit_role($id)
    {
	  $data = array(
			 'role' => $this->users_model->edit_role($id)
			);
	  
	  $roles = $this->users_model->select_appRole();
	  $role_detail = $this->users_model->edit_role_detail($id);
	  
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
	  
	  //echo "<pre>";
	  //print_r($arr);
	  //die();
	  
	  foreach($arr as $role_app_id => &$value)
	  {
	       if(!$value['parent_id'] || !array_key_exists($value['parent_id'], $arr))
	       {
		    $tree[] = &$value;
	       } else {
		    $arr[$value['parent_id']]['items'][] = &$value;
	       }
	  }
	  
	  //echo "<pre>";
	  //print_r($tree);
	  //die();
	  
	  $data['json'] = json_encode($tree);
	  
	  
	  $this->load->view('users/role_edit',$data);
    }
    
    function update_role()
    {
	  $this->form_validation->set_rules('role_name', 'Role Name', 'required');
	  if($this->form_validation->run() == FALSE)
	  {
	       $id = $this->input->post('role_id');
	       $data = array(
			 'role' => $this->users_model->edit_role($id)
			);
	  
	       $roles = $this->users_model->select_appRole();
	       $role_detail = $this->users_model->edit_role_detail($id);
	       
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
	       
	       //echo "<pre>";
	       //print_r($arr);
	       //die();
	       
	       foreach($arr as $role_app_id => &$value)
	       {
		    if(!$value['parent_id'] || !array_key_exists($value['parent_id'], $arr))
		    {
			 $tree[] = &$value;
		    } else {
			 $arr[$value['parent_id']]['items'][] = &$value;
		    }
	       }
	       
	       //echo "<pre>";
	       //print_r($tree);
	       //die();
	       
	       $data['json'] = json_encode($tree);
	       
	       
	       $this->load->view('users/role_edit',$data);
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
	  $select_group = $this->users_model->select_group();
	  foreach($select_group->result() as $v1)
	  {
	       $select_user = $this->users_model->count_group_user($v1->group_id);
	       $count_group[] = $select_user->row()->count_group; 
	  }
	  
	  $config['base_url'] = base_url().'users/menu_group';
	  $config['total_rows'] = $this->users_model->count_record_group();
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
    
    function insert_group()
    {	
	  $select_group = $this->users_model->select_group();
	  foreach($select_group->result() as $v1)
	  {
	       $select_user = $this->users_model->count_group_user($v1->group_id);
	       $count_group[] = $select_user->row()->count_group; 
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
		    $config['total_rows'] = $this->users_model->count_record_group();
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
    
    function delete_group($id)
    {
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
    
    function edit_group($id)
    {
	  $data = array(
			 'group' => $this->users_model->edit_group($id),
			 'group_detail' => $this->users_model->edit_group_detail($id),
			 'channel' => $this->users_model->select_channel(),
			 'msge' => NULL
			);
	  $this->load->view('users/group_edit',$data);
    }
    
    function update_group()
    {
	  $this->form_validation->set_rules('group_name', 'Group Name', 'required');
	  $id = $this->input->post('group_id');
	  $group = $this->input->post('group_name');
	  $cek = $this->users_model->select_byName($group);
	  /*if($group!=$this->input->post('g_name'))
	  {
	       if($cek->row()->group_name==$group)
	       {
		    $id = $this->input->post('group_id');
		    $data = array(
			      'group' => $this->users_model->edit_group($id),
			      'group_detail' => $this->users_model->edit_group_detail($id),
			      'channel' => $this->users_model->select_channel(),
			      'msge' => 1
			     );
		    //$this->session->set_flashdata('double', TRUE);
		    $this->load->view('users/group_edit',$data);
	       }
	  }
	  
	  elseif($group==$this->input->post('g_name'))
	  {
	       redirect('users/menu_group');
	  }*/
	  
	  if($this->form_validation->run() == FALSE)
	  {
	       $data = array(
			 'group' => $this->users_model->edit_group($id),
			 'group_detail' => $this->users_model->edit_group_detail($id),
			 'channel' => $this->users_model->select_channel()
			);
	       $this->load->view('users/group_edit',$data);
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