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
                $result = $this->reports_model->create_report($this->input->post());
                $product_list = $this->load->model('campaign_model')->GetProductBasedOnParent();
                if($result){
                    $parents = Array();
                    foreach($product_list as $prod_list){
                        $is_parent = false;
                        
                        if($prod_list->parent_id == null)
                            $is_parent = true;
                        
                        if($is_parent == false){
                            $prod_list->count_cases_total = 0;
                            $prod_list->count_cases_wall_post = 0;
                            $prod_list->count_cases_pm = 0;
                            
                            $prod_list->count_cases_total_resolved = 0;
                            $prod_list->count_cases_wall_post_resolved = 0;
                            $prod_list->count_cases_pm_resolved = 0;
                            
                            $count_time_wall_post = 0;
                            $count_time_pm = 0;
                            
                            foreach($result as $res){
                                if($res->id == $prod_list->id){
                                    $prod_list->count_cases_total += 1;
                                    if($res->solved_at != null)
                                        $prod_list->count_cases_total_resolved += 1;    
                                    
                                    if(($res->type == 'facebook') || ($res->type == 'facebook_comment') || ($res->type == 'twitter')){
                                        $prod_list->count_cases_wall_post += 1;
                                        if($res->solved_at != null)
                                            $prod_list->count_cases_wall_post_resolved += 1;
                                    }
                                    elseif(($res->type == 'facebook_conversation') || ($res->type == 'twitter_dm')){
                                        $prod_list->count_cases_pm += 1;
                                        if($res->solved_at != null)
                                            $prod_list->count_cases_pm_resolved += 1;
                                    }
                                    
                                    if(($res->type == 'facebook') || ($res->type == 'facebook_comment') || ($res->type == 'twitter')){
                                        if($res->solved_at != null)
                                            $count_time_wall_post += strtotime($res->solved_at) - strtotime($res->created_at);
                                    }
                                    elseif(($res->type == 'facebook_conversation') || ($res->type == 'twitter_dm')){
                                        if($res->solved_at != null)
                                            $count_time_pm += strtotime($res->solved_at) - strtotime($res->created_at);
                                    }
                                }
                            }
                            
                            if($count_time_wall_post > 0){
                                $prod_list->avg_respond_time_wall_post = $count_time_wall_post;
                                $prod_list->avg_respond_time_wall_post_string = $this->time_elapsed($count_time_wall_post / $prod_list->count_cases_wall_post_resolved);
                            }
                            else{
                                $prod_list->avg_respond_time_wall_post = $count_time_wall_post;
                                $prod_list->avg_respond_time_wall_post_string = $count_time_wall_post;
                            }
                            
                            if($count_time_pm > 0){
                                $prod_list->avg_respond_time_pm = $count_time_pm;
                                $prod_list->avg_respond_time_pm_string = $this->time_elapsed($count_time_pm / $prod_list->count_cases_pm_resolved);
                            }
                            else{
                                $prod_list->avg_respond_time_pm = $count_time_pm;
                                $prod_list->avg_respond_time_pm_string = $count_time_pm;
                            }
                        
                            if(($count_time_wall_post > 0) || ($count_time_pm > 0)){
                                $prod_list->avg_respond_time_total = $count_time_wall_post + $count_time_pm;
                                $prod_list->avg_respond_time_total_string = $this->time_elapsed(($count_time_wall_post + $count_time_pm) / $prod_list->count_cases_total_resolved);
                            }
                            else{
                                $prod_list->avg_respond_time_total = 0;
                                $prod_list->avg_respond_time_total_string = 0;
                            }
                        }
                        else{
                            $parents[] = $prod_list;
                        }
                    }

                    $x = array('cases_total' => 0,
                                 'cases_wall_post' => 0,
                                 'cases_pm' => 0,
                                 'cases_total_resolved' => 0,
                                 'cases_wall_post_resolved' => 0,
                                 'cases_pm_resolved' => 0,
                                 'avg_respond_time_total' => 0,
                                 'avg_respond_time_wall_post' => 0,
                                 'avg_respond_time_pm' => 0
                                 );
                    
                    $all = (object) $x;
                    
                    foreach($parents as $parent){
                        $parent->count_cases_total = 0;
                        $parent->count_cases_wall_post = 0;
                        $parent->count_cases_pm = 0;
                        
                        $parent->count_cases_total_resolved = 0;
                        $parent->count_cases_wall_post_resolved = 0;
                        $parent->count_cases_pm_resolved = 0;
                        
                        $parent_respond_time_total = 0;
                        $parent_respond_time_wall_post = 0;
                        $parent_respond_time_pm = 0;
                        
                        foreach($product_list as $prod_list){
                            if($prod_list->parent_id == $parent->id){
                                $parent->count_cases_total += $prod_list->count_cases_total;
                                $parent->count_cases_wall_post += $prod_list->count_cases_wall_post;
                                $parent->count_cases_pm += $prod_list->count_cases_pm;
                                
                                $parent->count_cases_total_resolved += $prod_list->count_cases_total_resolved;
                                $parent->count_cases_wall_post_resolved += $prod_list->count_cases_wall_post_resolved;
                                $parent->count_cases_pm_resolved += $prod_list->count_cases_pm_resolved;
                                
                                $parent_respond_time_total += $prod_list->avg_respond_time_total;
                                $parent_respond_time_wall_post += $prod_list->avg_respond_time_wall_post;
                                $parent_respond_time_pm += $prod_list->avg_respond_time_pm;
                            }
                        }
                        
                        if($parent_respond_time_wall_post > 0){
                            $parent->avg_respond_time_wall_post_string = $this->time_elapsed($parent_respond_time_wall_post / $parent->count_cases_wall_post_resolved);
                        }
                        else{
                            $parent->avg_respond_time_wall_post_string = 0;
                        }
                        
                        if($parent_respond_time_pm > 0){
                            $parent->avg_respond_time_pm_string = $this->time_elapsed($parent_respond_time_pm / $parent->count_cases_pm_resolved);
                        }
                        else{
                            $parent->avg_respond_time_pm_string = 0;
                        }
                    
                        if(($parent_respond_time_wall_post > 0) || ($parent_respond_time_pm > 0))
                            $parent->avg_respond_time_total_string = $this->time_elapsed(($parent_respond_time_wall_post + $parent_respond_time_pm) / $parent->count_cases_total_resolved);
                        else{
                            $parent->avg_respond_time_total_string = 0;
                        }
                        
                        $all->cases_total += $parent->count_cases_total;
                        $all->cases_wall_post += $parent->count_cases_wall_post;
                        $all->cases_pm += $parent->count_cases_pm;
                        
                        $all->cases_total_resolved += $parent->count_cases_total_resolved;
                        $all->cases_wall_post_resolved += $parent->count_cases_wall_post_resolved;
                        $all->cases_pm_resolved += $parent->count_cases_pm_resolved;
                        
                        $all->avg_respond_time_total += $parent_respond_time_wall_post + $parent_respond_time_pm;
                        $all->avg_respond_time_wall_post += $parent_respond_time_wall_post;
                        $all->avg_respond_time_pm += $parent_respond_time_pm;
                    }
                    
                    if($all->avg_respond_time_total > 0){
                        $all->avg_respond_time_total = $this->time_elapsed($all->avg_respond_time_total / $all->cases_total_resolved);
                    }
                    else{
                        $all->avg_respond_time_total = 0;
                    }
                    
                    if($all->avg_respond_time_wall_post > 0){
                        $all->avg_respond_time_wall_post = $this->time_elapsed($all->avg_respond_time_wall_post / $all->cases_wall_post_resolved);
                    }
                    else{
                        $all->avg_respond_time_wall_post = 0;
                    }
                    
                    if($all->avg_respond_time_pm > 0){
                        $all->avg_respond_time_pm = $this->time_elapsed($all->avg_respond_time_pm / $all->cases_pm_resolved);
                    }
                    else{
                         $all->avg_respond_time_pm = 0;
                    }
                
                    echo json_encode(array(
                        'status' => 'success',
                        'type' => 'case',
                        'product_list' => $product_list,
                        'cases' => $result,
                        'parents' => $parents,
                        'all' => $all
                    ));
                    
                }
                else{
                    echo json_encode(array(
                        'status' => 'error',
                        'message' => 'No Result'
                    ));
                }
            }
            else{
                $result = $this->reports_model->getEngagement($this->input->post());
                
                $product_list = $this->load->model('campaign_model')->GetProductBasedOnParent();
                
                if($result){
                    $parents = Array();
                    foreach($product_list as $prod_list){
                        $is_parent = false;
                        
                        if($prod_list->parent_id == null)
                            $is_parent = true;
                        
                        if($is_parent == false){
                            $prod_list->count_engagement_total = 0;
                            $prod_list->count_engagement_wall_post = 0;
                            $prod_list->count_engagement_pm = 0;
                            
                            $count_time_wall_post = 0;
                            $count_time_pm = 0;
                            
                            foreach($result as $res){
                                if($res->id == $prod_list->id){
                                    $prod_list->count_engagement_wall_post += 1;
                                    $prod_list->count_engagement_total += 1;
                                    
                                    if(($res->type == 'facebook') || ($res->type == 'facebook_comment') || ($res->type == 'twitter'))
                                        $count_time_wall_post += strtotime($res->reply_created_at) - strtotime($res->created_at);
                                    elseif(($res->type == 'facebook_conversation') || ($res->type == 'twitter_dm'))
                                        $count_time_pm += strtotime($res->reply_created_at) - strtotime($res->created_at);
                                }
                            }
                            
                            if($count_time_wall_post != 0){
                                $prod_list->avg_respond_time_wall_post = $count_time_wall_post;
                                $prod_list->avg_respond_time_wall_post_string = $this->time_elapsed($count_time_wall_post / $prod_list->count_engagement_wall_post);
                            }
                            else{
                                $prod_list->avg_respond_time_wall_post = $count_time_wall_post;
                                $prod_list->avg_respond_time_wall_post_string = $count_time_wall_post;
                            }
                            
                            if($count_time_pm != 0){
                                $prod_list->avg_respond_time_pm = $count_time_pm;
                                $prod_list->avg_respond_time_pm_string = $this->time_elapsed($count_time_pm / $prod_list->count_engagement_pm);
                            }
                            else{
                                $prod_list->avg_respond_time_pm = $count_time_pm;
                                $prod_list->avg_respond_time_pm_string = $count_time_pm;
                            }
                        
                            if(($count_time_wall_post != 0) || ($count_time_pm != 0)){
                                $prod_list->avg_respond_time_total = $count_time_wall_post + $count_time_pm;
                                $prod_list->avg_respond_time_total_string = $this->time_elapsed(($count_time_wall_post + $count_time_pm) / $prod_list->count_engagement_total);
                            }
                            else{
                                $prod_list->avg_respond_time_total = 0;
                                $prod_list->avg_respond_time_total_string = 0;
                            }
                        }
                        else{
                            $parents[] = $prod_list;
                        }
                    }
                    
                    $x = array('cases_total' => 0,
                                 'cases_wall_post' => 0,
                                 'cases_pm' => 0,
                                 'engagement_total' => 0,
                                 'engagement_wall_post' => 0,
                                 'engagement_pm' => 0,
                                 'avg_respond_time_total' => 0,
                                 'avg_respond_time_wall_post' => 0,
                                 'avg_respond_time_pm' => 0
                                 );
                    
                    $all = (object) $x;
                    
                    foreach($parents as $parent){
                        $parent->count_cases_total = 0;
                        $parent->count_cases_wall_post = 0;
                        $parent->count_cases_pm = 0;
                        
                        $parent->count_engagement_total = 0;
                        $parent->count_engagement_wall_post = 0;
                        $parent->count_engagement_pm = 0;
                        
                        $parent_respond_time_total = 0;
                        $parent_respond_time_wall_post = 0;
                        $parent_respond_time_pm = 0;
                        
                        foreach($product_list as $prod_list){
                            if($prod_list->parent_id == $parent->id){
                                $parent->count_engagement_total += $prod_list->count_engagement_total;
                                $parent->count_engagement_wall_post += $prod_list->count_engagement_wall_post;
                                $parent->count_engagement_pm += $prod_list->count_engagement_pm;
                                
                                $parent_respond_time_total += $prod_list->avg_respond_time_total;
                                $parent_respond_time_wall_post += $prod_list->avg_respond_time_wall_post;
                                $parent_respond_time_pm += $prod_list->avg_respond_time_pm;
                            }
                        }
                        
                        if($parent_respond_time_wall_post != 0){
                            $parent->avg_respond_time_wall_post_string = $this->time_elapsed($parent_respond_time_wall_post / $parent->count_engagement_wall_post);
                        }
                        else{
                            $parent->avg_respond_time_wall_post_string = 0;
                        }
                        
                        if($parent_respond_time_pm != 0){
                            $parent->avg_respond_time_pm_string = $this->time_elapsed($parent_respond_time_pm / $parent->count_engagement_pm);
                        }
                        else{
                            $parent->avg_respond_time_pm_string = 0;
                        }
                    
                        if(($parent_respond_time_wall_post != 0) || ($parent_respond_time_pm != 0))
                            $parent->avg_respond_time_total_string = $this->time_elapsed(($parent_respond_time_wall_post + $parent_respond_time_pm) / $parent->count_engagement_total);
                        else{
                            $parent->avg_respond_time_total_string = 0;
                        }
                        
                        $all->engagement_total += $parent->count_engagement_total;
                        $all->engagement_wall_post += $parent->count_engagement_wall_post;
                        $all->engagement_pm += $parent->count_engagement_pm;
                        
                        $all->avg_respond_time_total += $parent_respond_time_wall_post + $parent_respond_time_pm;
                        $all->avg_respond_time_wall_post += $parent_respond_time_wall_post;
                        $all->avg_respond_time_pm += $parent_respond_time_pm;
                    }
                    
                    if($all->avg_respond_time_total != 0){
                        $all->avg_respond_time_total = $this->time_elapsed($all->avg_respond_time_total / $all->engagement_total);
                    }
                    else{
                        $all->avg_respond_time_total = 0;
                    }
                    
                    if($all->avg_respond_time_wall_post != 0){
                        $all->avg_respond_time_wall_post = $this->time_elapsed($all->avg_respond_time_wall_post / $all->engagement_wall_post);
                    }
                    else{
                        $all->avg_respond_time_wall_post = 0;
                    }
                    
                    if($all->avg_respond_time_pm != 0){
                        $all->avg_respond_time_pm = $this->time_elapsed($all->avg_respond_time_pm / $all->engagement_pm);
                    }
                    else{
                         $all->avg_respond_time_pm = 0;
                    }
                    
                    echo json_encode(array(
                        'status' => 'success',
                        'type' => 'engagement',
                        'product_list' => $product_list,
                        'cases' => $result,
                        'parents' => $parents,
                        'all' => $all
                    ));
                    
                }
                else{
                    echo json_encode(array(
                        'status' => 'error',
                        'message' => 'No Result'
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
                $filter = null;    
                if(($this->input->post('user') != '') && ($this->input->post('user') != 'All')){
                    $filter['user_id'] = $this->input->post('user');
                }
                
                if(($this->input->post('group') != '') && ($this->input->post('group') != 'All')){
                    $filter['group_id'] = $this->input->post('group');
                }
                
                if($this->input->post('country') != ''){
                    $filter['country_code'] = $this->input->post('country');
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
    
    function DownloadUserPerformance($filename){
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment;filename=\"".$filename.".xls\"");
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
    
        
    function time_elapsed($secs){
	$bit = array(
	    'y' => $secs / 31556926 % 12,
	    'w' => $secs / 604800 % 52,
	    'd' => $secs / 86400 % 7,
	    'h' => $secs / 3600 % 24,
	    'm' => $secs / 60 % 60,
	    's' => $secs % 60
	    );
	    
	foreach($bit as $k => $v)
	    if($v > 0)$ret[] = $v . $k;
	    
	return join(' ', $ret);
    }
}
