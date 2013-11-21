<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MY_Controller {

    private $connection;
	   
    function __construct()
    {
        parent::__construct();
	$this->load->model('users_model');
    }
    
    function index()
    {
        $data = array(
		      'show' => $this->users_model->select_user()
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
	  $data=array(
		      'user_id' => $this->input->post('userID'),
		      'full_name' => $this->input->post('fullName'),
		      'display_name' => $this->input->post('displayName'),
		      'role_id' => $this->input->post('optRole'),
		      'group_id' => $this->input->post('optGroup')
	       );
	  
	  $this->users_model->insert_user($data);
	  
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
	  $this->load->view('users/role');
    }
}