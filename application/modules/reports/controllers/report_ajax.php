<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class report_ajax extends CI_Controller {
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('reports_model');
        header('Content-Type: application/json');
        if(!$this->session->userdata('user_id')) redirect("/");
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
    
    function CreateReport(){
        $this->session->set_userdata('current_code', null);
        $this->load->library('validation');
        $validation[] = array('type' => 'required','name' => 'Channel','value' => $this->input->post('channel_id'), 'fine_name' => "Channel");
        $validation[] = array('type' => 'required','name' => 'User Group','value' => $this->input->post('group_id'), 'fine_name' => "Assign To");
        $validation[] = array('type' => 'required|valid_date','name' => 'Date Start','value' => $this->input->post('date_start'), 'fine_name' => "Date Start");
        $validation[] = array('type' => 'required|valid_date','name' => 'Date Start','value' => $this->input->post('date_finish'), 'fine_name' => "Date Finish");
        
        $is_valid = CheckValidation($validation, $this->validation);
        if($is_valid === TRUE){
            $code = $this->reports_model->create_report($this->input->post('channel_id'), $this->session->userdata('user_id'),
                                                        $this->input->post('date_start'), $this->input->post('date_finish'), $this->input->post('group_id'));
            $this->session->set_userdata('current_code', $code);
            $this->FilterReport();
        }
        else{
            http_response_code(500);
            echo json_encode($is_valid, JSON_PRETTY_PRINT); 
        }
        
    }
    
    function FilterReport(){
        if(!$this->session->userdata('current_code')) return;
        $case_type = $this->input->get('case_type');
        $case_type = $case_type == 'all' ? null : $case_type;
        echo json_encode($this->reports_model->filter_report($this->session->userdata('current_code'), $case_type), JSON_PRETTY_PRINT);
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
    
    function GetUserList(){
        $user_group = $this->input->get('group_id');
        if($user_group != ''){
            echo json_encode($this->users_model->select_user($user_group)->result());
        }
    }

}
