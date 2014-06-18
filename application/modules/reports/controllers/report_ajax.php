<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class report_ajax extends CI_Controller {
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('reports_model');
        header('Content-Type: application/json');
    }
    
    function ChannelList($country = null){
        $this->load->model('account_model');
        $filter = $country != null ? array('country_code' => $country) : array();
        
        echo json_encode($this->account_model->GetChannel($filter), JSON_PRETTY_PRINT);
    }
    
    function UserGroupList($country = null){
        $this->load->model('users_model');
        $filter = $country != null ? array('country_code' => $country) : array();
        echo json_encode($this->users_model->select_group($filter)->result(), JSON_PRETTY_PRINT);
    }
    
    function GenerateActivity(){
	//get the latest id from table report_activity
	$result = $this->reports_model->getReportActivity()->first_row();
        
        //if the date result = null, the date = 1 january 1970
	if($result != null){
            $latest_date = $result->time;
        }
        else{
            $latest_date = '1970-01-01 00:00:00'; 
        }
        
        //call reports_model->generate_report_activity(the date)
	$result = $this->reports_model->generate_report_activity($latest_date);
        
        //print the return
        print_r(json_encode($result));
    }
    
    function GetReportActivity(){
        //check post request
        if($this->input->post() != null){
            if($this->input->post('country_code') != ''){
                $filter['country_code'] = $this->input->post('country_code');
            }
            else{
                $filter = null;
            }
            
            $range = "time between '".$this->input->post('date_start')." 00:00:00' and '".$this->input->post('date_end')." 00:00:00'";
            $result['records'] = $this->reports_model->GetReportActivity($filter,
                                    $range,
                                    $this->input->post('limit'),
                                    $this->input->post('offset')
                                    )->result();
            
            $result['count_total'] = $this->reports_model->CountReportActivity($filter,$range);
        }
        else{
            $result['records'] = $this->reports_model->GetReportActivity()->result();
        }
        echo json_encode($result);
    }
    
    function CountReportActivity(){
        $result = $this->reports_model->getReportActivity();
        echo $result;
    }
}