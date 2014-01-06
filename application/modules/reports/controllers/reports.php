<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends MY_Controller {
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('reports_model');
    }
    
    function index()
    {
        $data['channel'] = $this->reports_model->view_channel();
        //$data['product'] = $this->reports_model->view_product();
        $data['show'] = $this->reports_model->count_product();
    $data[] = "";        
        $this->load->view('reports/index',$data);
    }
    
}