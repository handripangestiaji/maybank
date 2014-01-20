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
        $data['product'] = $this->reports_model->view_product();
        $data['show'] = $this->reports_model->count_product();
        $data['count_percentage_product']  = $this->reports_model->count_percentage_product();
        $data[] = "";        
        $this->load->view('reports/index',$data);
    }
    
    function filter(){
        $chanel             = $this->input->post('chanel');
        $dateFrom           = $this->convert_date($_POST['dateFrom']);
        $dateTo             = $this->convert_date($_POST['dateTo']);
        $count_all_case     = $this->reports_model->count_all_cases($chanel,$dateFrom,$dateTo);
        $count_solved_case  = $this->reports_model->count_solved_cases($chanel,$dateFrom,$dateTo);
        $case_list_by_date  = $this->reports_model->group_all_case_by_date($chanel,$dateFrom,$dateTo);
        
        $count_all_case = $count_all_case == 0 ? 1 : $count_all_case;
        $data['count_all_case']     = $count_all_case;
        $data['count_solved_case']  = $count_solved_case;
        $data['percentage']         = round((($count_solved_case/$count_all_case)*100),2);
        $data['case_list_by_date']  = $case_list_by_date;
        
        $this->load->view('reports/summary',$data);
    }
    
    function filterResolution(){
        $product            = $_POST['product'];
        $dateFrom           = $this->convert_date($_POST['dateFrom']);
        $dateTo             = $this->convert_date($_POST['dateTo']);
        $count_resolution   = $this->reports_model->count_resolution($product,$dateFrom,$dateTo);
        
        $data['count_resolution']     = $count_resolution;
        
        $this->load->view('reports/resolution',$data);
    }
    
    function filterResponse(){
        $product            = $_POST['product'];
        $dateFrom           = $this->convert_date($_POST['dateFrom']);
        $dateTo             = $this->convert_date($_POST['dateTo']);
        $count_response     = $this->reports_model->count_response($product,$dateFrom,$dateTo);
        
        $data['count_response']     = $count_response;
        
        $this->load->view('reports/response',$data);
    }
    
    function convert_date($dateFormat){
        $date = substr($dateFormat,3,2);
        $month = substr($dateFormat,0,2);
        $year = substr($dateFormat,6,4);
        
        $dt = $year.'-'.$month.'-'.$date;
        return $dt;
    }
}