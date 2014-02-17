<?php
class mycase extends CI_Controller{
    
    function __construct(){
        parent::__construct();
        $this->load->model('case_model');
        $this->load->library('validation');
        header('Content-Type: application/x-json');
        
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
        $validation[] = array('type' => 'required','name' => 'product_type','value' => $this->input->post('product_type'), 'fine_name' => "Product Type");
        $validation[] = array('type' => 'required','name' => 'message','value' => $this->input->post('message'), 'fine_name' => "Messages");
        if($allPost['assign_to'])
            $validation[] = array('type' => 'required','name' => 'assign_to','value' => $allPost['assign_to'], 'fine_name' => "Assign To");
        else
            $validation[] = array('type' => 'required','name' => 'email','value' => $this->input->post('email'), 'fine_name' => "Email");
            
        $is_valid = CheckValidation($validation, $this->validation);
        if($is_valid === true){
            $case = array(
                "content_products_id" => $this->input->post('product_type'),
                "created_by" => $user_id,
                "messages" => $this->input->post('message'),
                "status" => "pending",
                "email" => $this->input->post('email'),
                "case_type" => $this->input->post('case_type'),
                "assign_to" => $this->input->post('assign_to') == '' ? NULL : $this->input->post('assign_to'),
                "related_conversation" => $this->input->post('related_conversation'),
                "post_id" => $this->input->post('post_id'),
                "created_at" => date("Y-m-d H:i:s")
            );
            
            $case['case_id'] = $this->case_model->CreateCase($case, $this->session->userdata('user_id'));
            echo json_encode(array(
                        "success" => true,
                        "message" => "Assigning case successfully done.",
                        "result" => $case
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
        
        echo json_encode($this->twitter_model->ReadTwitterData($filter, 10));
    }
    
    
    function FacebookRelatedConversation($user,$type){
        $this->load->model('facebook_model');
        $post_id=$this->input->get('post_id');
        $channel_id=$this->input->get('channel_id');
        $author_id=$this->input->get('author_id');
        $this->load->model('account_model');
        
        if($channel_id){
            $filter['channel_id'] = $channel_id;
        }
        
        $channel_loaded = $this->account_model->GetChannel($filter);
        if(count($channel_loaded) == 0){
    		echo json_encode(
    		    array(
    			'success' => false,
    			'message' => "Invalid Channel Id"
    		    )
    		);
		  return;
	    }
	    else{
	       
            $facebook_id=$channel_loaded[0]->social_id;
            //print_r($facebook_id);
            if($type=='facebook'){
                echo json_encode($this->facebook_model->RetriveCommentPostFb(array('b.from'=>$post_id),array()));
            }else{
                 echo json_encode($this->facebook_model->RetrievePmDetailFB(array("c.facebook_id <>"=>$user)));
           }
       }  
    }
    
    function ResolveCase(){
        if($this->input->is_ajax_request()){
            $solved_case = $this->case_model->ResolveCase($this->input->post('case_id'), $this->session->userdata('user_id'));
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
        echo json_encode($this->case_model->SearchUserByEmail($search_value));
    }
}