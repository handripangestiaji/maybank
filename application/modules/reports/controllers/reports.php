<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends MY_Controller {
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('reports_model');
        $this->user_role = $this->users_model->get_collection_detail(
		array('role_collection_id'=>$this->session->userdata('role_id')));
	
	if(!$this->session->userdata('user_id'))
	    redirect('');
	
	if(!IsRoleFriendlyNameExist($this->user_role, array ('Reporting_View', 'Reporting_Download'))){
	    redirect('');
	}
    }
    
    function index()
    {
	$country_code = IsRoleFriendlyNameExist($this->user_role, 'Reporting_View_All_Country') ?
	    null : $this->session->userdata('country_code');
	$data['country_list'] = $this->users_model->get_country($country_code)->result();
	if(IsRoleFriendlyNameExist($this->user_role, array ('Reporting_User_Performance'))){
	    $this->load->view('reports/index',$data);
	}
	elseif(IsRoleFriendlyNameExist($this->user_role, array ('Reporting_User_Activity'))){
	    redirect('reports/activity');
	}
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
    
    function activity(){
	$this->load->model('users_model');
	$data['country_list'] = $this->users_model->get_country()->result();
	$this->load->view('reports/activity', $data);
    }
}