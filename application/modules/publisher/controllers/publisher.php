<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Publisher extends MY_Controller {

    public $user_role;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('users_model');
        $this->user_role = $this->users_model->get_collection_detail(
		array('role_collection_id'=>$this->session->userdata('role_id')));
    }

    public function index()
    {
        $this->load->view('publisher/index');
    }
}