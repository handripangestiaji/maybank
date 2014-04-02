<?php
class mycase extends CI_Controller{
    
    function __construct(){
        parent::__construct();
        $this->load->model('case_model');
        $this->load->library('validation');
        header('Content-Type: application/x-json');
        $this->user_role = $this->users_model->get_collection_detail(
		array('role_collection_id'=>$this->session->userdata('role_id')));
        if(!$this->session->userdata('user_id')){
            die(json_encode(array(
                'success' => false,
                'message' => 'You don\'t have active session'
            )));
        }
    }
    
    /*Create case by post parameter */
    function CreateCase(){
        $user_id = $this->session->userdata('user_id');
        $allPost = $this->input->post();
        
        $chackCase=$this->case_model->chackCase(array('post_id' => $this->input->post('post_id')));
        //print_r($chackCase);
        if(isset($chackCase[0]->status)=='pending'){
             $reassign=$this->case_model->reassign($this->input->post('post_id'));
        }
        
        $validation[] = array('type' => 'required','name' => 'user_id','value' => $user_id, 'fine_name' => "User ID");
        $validation[] = array('type' => 'required','name' => 'case_type','value' => $this->input->post('case_type'), 'fine_name' => "Case Type");
        if($this->input->post('case_type') != 'Report_Abuse'){
            $validation[] = array('type' => 'required','name' => 'product_type','value' => $this->input->post('product_type'), 'fine_name' => "Product Type");
        }        
        $validation[] = array('type' => 'required','name' => 'message','value' => $this->input->post('message'), 'fine_name' => "Messages");

	if($allPost['assign_to'])
            $validation[] = array('type' => 'required','name' => 'assign_to','value' => $allPost['assign_to'], 'fine_name' => "Assign To");
        else
            $validation[] = array('type' => 'required','name' => 'email','value' => $this->input->post('email'), 'fine_name' => "Email");
            
        $is_valid = CheckValidation($validation, $this->validation);
        if($is_valid === true){
            $old_case = $this->case_model->LoadCase(array('a.post_id' => $this->input->post('post_id')));
            $case = array(
                "content_products_id" => $this->input->post('product_type'),
                "created_by" => $user_id,
                "messages" => $this->input->post('message'),
                "status" => "pending",
                "email" => $this->input->post('email'),
                "case_type" => $this->input->post('case_type'),
                "assign_to" => $this->input->post('assign_to') == '' ? NULL : $this->input->post('assign_to'),
                "related_conversation" => $this->input->post('related_conversation'),
                "related_conversation_type" => $this->input->post('related_conversation_type'),
                "post_id" => $this->input->post('post_id'),
                "created_at" => date("Y-m-d H:i:s")
            );
            if(!$this->input->post('product_type'))
                unset($case['content_products_id']);
            
            $solved_case = NULL;
            if(count($old_case) > 0){
                $case['old_case_id'] = $old_case[0]->case_id;
                $solved_case = $this->case_model->ResolveCase($old_case[0]->case_id, $this->session->userdata('user_id'), '', false);

            }
            
            $case['case_id'] = $this->case_model->CreateCase($case, $this->session->userdata('user_id'));
            if($this->input->post('popup') == 'true'){
                $this->db->where('case_id', $case['old_case_id']);
                $this->db->update('case_related_conversation', array('case_id' => $case['case_id']));    
            }
            echo json_encode(array(
                    "success" => true,
                    "message" => "Assigning case successfully done.",
                    "result" => $case,
                    "old_case" => $solved_case
                )
            );
        }
        else{
            echo json_encode(array(
                       "success" => false,
                       "message" => "Assigning case was failed.",
                       "errors" => $is_valid
                   )
               );
        }
    }
    
    function TwitterRelatedConversation($twitter_user_id, $type = "mentions"){
        $this->load->model('twitter_model');
        $filter["b.twitter_user_id"] = $twitter_user_id;
        //$filter["b.type"] = $type;
        $filter["a.post_id !="] = $this->input->get('post_id');
        $result = $this->twitter_model->ReadTwitterData($filter, 10);
        $post_stream_id = array();
        for($i = 0 ; $i< count($result) ; $i++){
            if(!in_array($result[$i]->post_stream_id, $post_stream_id)){
                $post_stream_id[] = $result[$i]->post_stream_id;    
            }
            else{
                unset($result[$i]);
            }
            
        }
        echo json_encode(array_values($result));
    }
    
    
    function FacebookRelatedConversation(){
        $this->load->model('facebook_model');
        $post_id = $this->input->get('post_id');
        $channel_id = $this->input->get('channel_id');
        $case_id=$this->input->get('case_id');

        $related_post_feed['all_case'] = $this->case_model->FindFacebookRelatedConversation($this->input->get('facebook_id'), $channel_id);
        $related_post_feed['assign'] = $this->case_model->FacebookRelatedConversation($case_id);
        
        echo json_encode($related_post_feed);
    }
    
    function GetCaseRelatedConversationItems(){
        $case_id=$this->input->get('post_id');
        echo json_encode($this->case_model->CaseRelatedConversationItems(array('case_id'=>$case_id)));
    }
    
    function ResolveCase(){
        if($this->input->is_ajax_request()){
            $solved_case = $this->case_model->ResolveCase($this->input->post('case_id'),$this->session->userdata('user_id'), $this->input->post('solved_message'));
            if($solved_case)
                    echo json_encode(array(
                        "success" => true,
                        "message" => "Resolving case successfully done.",
                        "result" => $solved_case
                    )
                );
            else
                echo json_encode(array(
                        "success" => false,
                        "message" => "Resolving case failed.",
                        "result" => $solved_case
                    )
                );
        }
    }
    
    
    function UpdateReadStatus(){
        if($this->input->is_ajax_request()){
            $case_id = $this->input->get('case_id');
            $read_case = $this->case_model->UpdateReadStatus($case_id,1);
            
            if($read_case)
                echo json_encode(array(
                        "success" => true,
                        "message" => "Case $case_id read."
                    )
                );
            else
                echo json_encode(array(
                   "success" => false,
                   "message" => "Case update failed."
                ));
        }
    }
    
    function SearchEmail(){
        $search_value = $this->input->get('term');
        $country_code = IsRoleFriendlyNameExist($this->user_role, 'Social Stream_Case_All_Country_AssignReassignResolved') ? NULL : $this->session->userdata('country');
        $result_user = $this->case_model->SearchUserByEmail($search_value, $country_code);
        for($x = 0; $x < count($result_user); $x++){
            if($country_code == null){
                if(!IsRoleFriendlyNameExist($result_user[$x]->role_detail, 'Social Stream_Case_All_Country_AssignReassignResolved'))
                    unset($result_user[$x]);
            }
            else{
                if(!IsRoleFriendlyNameExist($result_user[$x]->role_detail, 'Social Stream_Case_Own_Country_AssignReassignResolved'))
                    unset($result_user[$x]);
            }
        }
        echo json_encode($result_user);
    }
    
    
    function ReadCase(){
        $this->load->model('twitter_model');
        $this->load->model('facebook_model');
        $case_id = $this->input->get('case_id');
        $timezone = $this->session->userdata('timezone');
        $case = $this->case_model->LoadCase(array('case_id' => $case_id));
        if(count($case) > 0){
            $case = $case[0];
            $case->related_conversation = array();
            $created_at = new DateTime($case->created_at.' Europe/London');
            $created_at->setTimezone(new DateTimeZone($timezone));
            $case->created_at = $created_at->format('l, M j, Y h:i A');
            $case->main_post = new stdClass();
            $case->type = str_replace('_', ' ', $case->type);
            if($case->type == 'twitter' || $case->type == 'twitter dm'){
                $case->related_conversation = $this->case_model->TwitterRelatedConversation($case->case_id);
                if($case->type == 'twitter dm')
                    $case->main_post = $this->twitter_model->ReadDMFromDb(array('a.post_id' => $case->post_id), 1);
                else
                    $case->main_post = $this->twitter_model->ReadTwitterData(array('a.post_id' => $case->post_id), 1);
            }
            else{
                 if($case->type == 'facebook')
                    $case->main_post = $this->facebook_model->RetrieveFeedFB(array('c.post_id' => $case->post_id), 1);
                else
                    $case->main_post = $this->facebook_model->RetrievePmFB(array('c.post_id' => $case->post_id), 1);
                
                $case->related_conversation = $this->case_model->FacebookRelatedConversation($case->case_id);
            }
            $case->main_post  = isset($case->main_post[0]) ? $case->main_post[0] : $case->main_post;
            
            if(isset($case->main_post->attachment)){
                $case->main_post->attachment = json_decode($case->main_post->attachment);
            }
            if(isset($case->main_post->twitter_entities)){
                $case->main_post->twitter_entities = json_decode($case->main_post->twitter_entities);
            }
            echo json_encode($case);
        }
        else
            echo json_encode(NULL);
    }
}
