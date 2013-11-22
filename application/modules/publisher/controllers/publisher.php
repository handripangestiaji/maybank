<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Publisher extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('publisher/index');
    }
}