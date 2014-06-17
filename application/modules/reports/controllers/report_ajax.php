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
}