<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends MY_Controller {
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('case_model');
    }
    
    function index()
    {
        $this->load->view('reports/index');
    }
    
}