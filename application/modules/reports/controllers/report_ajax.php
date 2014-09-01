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
            if($this->input->post('type') == 'case'){
                $code = $this->reports_model->create_report($this->input->post('channel_id'), $this->session->userdata('user_id'),
                                                            $this->input->post('date_start'), $this->input->post('date_finish'), $this->input->post('group_id'));
                $this->session->set_userdata('current_code', $code);
                $this->FilterReport();
            }
            else{
                $result = $this->reports_model->getCase($this->input->post());
                $product_list = $this->load->model('campaign_model')->GetProductBasedOnParent();
                
                if($result){
                    foreach($result as $res){
                        $case_id = $res->case_id;
                        $res->engagement = $this->reports_model->getEngagementByCaseId($case_id)->result();
                    }
                    
                    $parents = Array();
                    foreach($product_list as $prod_list){
                        $is_parent = false;
                        
                        if($prod_list->parent_id == null)
                            $is_parent = true;
                        
                        if($is_parent == false){
                            $prod_list->count_cases_total = 0;
                            $prod_list->count_cases_wall_post = 0;
                            $prod_list->count_cases_pm = 0;
                        
                            $prod_list->count_engagement_total = 0;
                            $prod_list->count_engagement_wall_post = 0;
                            $prod_list->count_engagement_pm = 0;
                            
                            foreach($result as $res){
                                if($res->product_name == $prod_list->product_name){
                                    if($res->type == 'facebook'){
                                        $prod_list->count_cases_wall_post += 1;
                                        $prod_list->count_engagement_wall_post += count($res->engagement);
                                    }
                                    elseif($res->type == 'facebook_conversation'){
                                        $prod_list->count_cases_pm += 1;
                                        $prod_list->count_engagement_pm += count($res->engagement);
                                    }
                                    $prod_list->count_cases_total += 1;
                                    $prod_list->count_engagement_total += count($res->engagement);
                                }
                            }
                        }
                        else{
                            $parents[] = $prod_list;
                        }
                    }
                    
                    foreach($parents as $parent){
                        $parent->count_cases_total = 0;
                        $parent->count_cases_wall_post = 0;
                        $parent->count_cases_pm = 0;
                        
                        $parent->count_engagement_total = 0;
                        $parent->count_engagement_wall_post = 0;
                        $parent->count_engagement_pm = 0;
                        
                        foreach($product_list as $prod_list){
                            if($prod_list->parent_id == $parent->id){
                                $parent->count_cases_total += $prod_list->count_cases_total;
                                $parent->count_cases_wall_post += $prod_list->count_cases_wall_post;
                                $parent->count_cases_pm += $prod_list->count_cases_pm;
                                
                                $parent->count_engagement_total += $prod_list->count_engagement_total;
                                $parent->count_engagement_wall_post += $prod_list->count_engagement_wall_post;
                                $parent->count_engagement_pm += $prod_list->count_engagement_pm;
                            }
                        }
                    }
                    
                    echo json_encode(array(
                        'type' => 'engagement',
                        'product_list' => $product_list,
                        'cases' => $result,
                        'parents' => $parents
                    ));
                    
                }
            }
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
    
    
    
    function GetReportActivity(){
        $this->load->library('validation');
        $validation[] = array('type' => 'required|valid_date','name' => 'Date Start','value' => $this->input->post('date_start'), 'fine_name' => "Date Start");
        $validation[] = array('type' => 'required|valid_date','name' => 'Date Finish','value' => $this->input->post('date_finish'), 'fine_name' => "Date Finish");
        
        $is_valid = CheckValidation($validation, $this->validation);
        if($is_valid === TRUE){
            //check post request
            if($this->input->post() != null){
                if(($this->input->post('user') != '') && ($this->input->post('user') != 'All')){
                    $filter['user_id'] = $this->input->post('user');
                }
                elseif(($this->input->post('group') != '') && ($this->input->post('group') != 'All')){
                    $filter['group_id'] = $this->input->post('group');
                }
                elseif($this->input->post('country') != ''){
                    $filter['country_code'] = $this->input->post('country');
                }
                else{
                    $filter = null;
                }
                
                $range = "time between '".$this->input->post('date_start')." 00:00:00' and '".$this->input->post('date_finish')." 23:59:59'";
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
        else{
            http_response_code(500);
            echo json_encode($is_valid, JSON_PRETTY_PRINT); 
        }
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
    
    function DownloadUserPerformance(){
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment;filename=\"filename.xlsx\"");
        header("Cache-Control: max-age=0");
        echo html_entity_decode($this->input->post('table_download'));
    }

    function PrintReportActivity(){
        $this->load->library('validation');
        $validation[] = array('type' => 'required|valid_date','name' => 'Date Start','value' => $this->input->post('date_start'), 'fine_name' => "Date Start");
        $validation[] = array('type' => 'required|valid_date','name' => 'Date Finish','value' => $this->input->post('date_finish'), 'fine_name' => "Date Finish");
        
        $is_valid = CheckValidation($validation, $this->validation);
        if($is_valid === TRUE){
            //check post request
            if($this->input->post() != null){
                if(($this->input->post('user') != '') && ($this->input->post('user') != 'All') && ($this->input->post('user') != 'null')){
                    $filter['user_id'] = $this->input->post('user');
                }
                elseif(($this->input->post('group') != '') && ($this->input->post('group') != 'All') && ($this->input->post('group') != 'null')){
                    $filter['group_id'] = $this->input->post('group');
                }
                elseif($this->input->post('country') != '' && ($this->input->post('country') != null)){
                    $filter['country_code'] = $this->input->post('country');
                }
                else{
                    $filter = null;
                }
                
                $range = "time between '".$this->input->post('date_start')." 00:00:00' and '".$this->input->post('date_finish')." 23:59:59'";
                $data['result'] = $this->reports_model->GetReportActivity($filter,
                                        $range
                                        )->result();
                
                $this->output->set_header("Content-Type: application/vnd.ms-excel; charset=" . 'UTF-8');
                $this->output->set_header("Content-Disposition: inline; filename=\"report-activity.xls\"");
                echo $this->load->view('reports/excel',$data);
            }
            else{
                $result['records'] = $this->reports_model->GetReportActivity()->result();
            }
        }
        else{    
            http_response_code(500);
            echo json_encode($is_valid, JSON_PRETTY_PRINT);
        }
    }
    
    public function EngagementReport($post){
        //get all case with the current filter
        //print_r($post);
        
        
        //count all the engagement for each case type
        
        //make json data with type of case
        //return json data
    }
}
