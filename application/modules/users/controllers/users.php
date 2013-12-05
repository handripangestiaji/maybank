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
	  if(isset($_POST['Create']))
	  {
	       $config = array(
			      'upload_path'   => 'media/dynamic/',
			      'allowed_types' => 'gif|jpg|png',
			      'max_size'      => '2048',
			      'max_width'     => '1024',
			      'max_height'    => '768'
			       );
	       
	       $this->upload->initialize($config);
	       if ( ! $this->upload->do_upload())
		{
		    //$this->upload->display_errors();
		    $this->session->set_flashdata('failed', TRUE);
		    redirect('users/create');
		}
		else
		{
		    $image = $this->upload->data();
		    $dir = "media/dynamic/".$image['file_name'];
		    
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
				'image_url' => $dir,
				'description' => $this->input->post('description'),
				'location' => $this->input->post('location'),
				'web_address' => $this->input->post('web_addres'),
				'created_at' => $time->format("Y-m-d H:i:s"),
				'created_by' => $created_by
			 );
		   
		    
		    $this->users_model->insert_user($data);
		  
				  $this->email->set_newline("\r\n");
				  $this->email->from('eko.purnomo@icloud.com','eko_purnomo_(icloud)');
				  $this->email->to($this->input->post('email'));
				  
				  $this->email->subject('New Registration');
				  $this->email->message('Thank you for registering<br />Your username <b>'.$this->input->post('userID').'</b> and password <b>'.$pass.'</b> for login in application.');
				  
				  $this->email->send();
		    
		    $this->session->set_flashdata('succes', TRUE);
		    redirect('users');
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
	  $id = $this->input->post('userID');
	  $data = array(
		      'full_name' => $this->input->post('fullName'),
		      'display_name' => $this->input->post('displayName'),
		      'email' => $this->input->post('email'),
		      'role_id' => $this->input->post('optRole'),
		      'group_id' => $this->input->post('optGroup')
			);
	  
	  $this->users_model->update_user($id,$data);
	  
	  $this->session->set_flashdata('info', TRUE);
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
	  $this->session->set_flashdata('info_delete', TRUE);
	  redirect('users');
    }
    
    
    
    //============================ ROLE ===================================
    function menu_role()
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
    
    function delete_role($id)
    {
	  $this->users_model->delete_role($id);
	  $this->session->set_flashdata('info_delete', TRUE);
	  redirect('users/menu_role');
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
     
	  $data['links'] = $this->pagination->create_links();
	  $data['count'] = $this->users_model->count_record_group();
			 $data['channel'] = $this->users_model->select_channel();
			 $data['group_detail'] = $this->users_model->select_user_group_d();
			
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
	  $this->session->set_flashdata('succes', TRUE);
	  redirect('users/menu_group');
    }
    
    function delete_group($id)
    {
	  $data = $this->users_model->delete_group($id);
	  $this->session->set_flashdata('info_delete', TRUE);
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
	  $this->session->set_flashdata('info', TRUE);
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