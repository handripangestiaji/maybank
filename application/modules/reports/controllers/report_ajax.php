<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class report_ajax extends CI_Controller {
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('reports_model');
    }
    
    
     function filter(){
        
        $channel             = $this->input->get('channel');
        $dateFrom           = convert_date(urldecode($this->input->get('dateFrom')));
        $dateTo             = convert_date(urldecode($this->input->get('dateTo')));
        $count_all_case     = $this->reports_model->count_all_cases($channel,$dateFrom,$dateTo);
        $count_solved_case  = $this->reports_model->count_solved_cases($channel,$dateFrom,$dateTo);
        $case_list_by_date  = $this->reports_model->group_all_case_by_date($channel,$dateFrom,$dateTo);
        
        
        $data['count_all_case']     = $count_all_case;
        $data['count_solved_case']  = $count_solved_case;
        $count_all_case = $count_all_case == 0 ? 1 : $count_all_case;
        $data['percentage']         = round((($count_solved_case/$count_all_case)*100),2);
        $data['case_list_by_date']  = $case_list_by_date;
        
        
         $this->load->view('reports/summary',$data);
        
    }
    
    function filterResolution(){
        $product            = $this->input->get('product');
        $dateFrom           = convert_date(urldecode($this->input->get('dateFrom')));
        $dateTo             = convert_date(urldecode($this->input->get('dateTo')));
        $count_resolution   = $this->reports_model->count_resolution($product,$dateFrom,$dateTo);
        
        $data['count_resolution']     = $count_resolution;
        
        $this->load->view('reports/resolution',$data);
    }
    function filterResponse(){
        $product            = $this->input->get('product');
        $dateFrom           = convert_date(urldecode($this->input->get('dateFrom')));
        $dateTo             = convert_date(urldecode($this->input->get('dateTo')));
        $count_response     = $this->reports_model->count_response($product,$dateFrom,$dateTo);
        
        $data['count_response']     = $count_response;
        
        $this->load->view('reports/response',$data);
    }
}