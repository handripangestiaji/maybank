<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MY_Controller {

     private $connection;
	   
    function __construct()
    {
        parent::__construct();
    }
    
    function index()
    {
        $this->load->view('users/index');
    }
    
    function create()
    {
        $this->load->view('users/create_view');
    }
    
    function edit()
    {
     $this->load->view('users/update_view');
    }
    
    function menu_role()
    {
	  $this->load->view('users/role_view');
    }
}