<?php

class mycase extends CI_Controller{
    
    function __construct(){
        parent::__construct();
        $this->load->model('case_model');
        $this->load->library('validation');
        header('Content-Type: application/x-json');
    }
    
    
    
    /*Create case by post parameter */
    function CreateCase(){
        $user_id = $this->session->userdata('user_id');
        $allPost = $this->input->post();
        
        $validation[] = array('type' => 'required','name' => 'tanggal_bayar','value' => $user_id, 'fine_name' => "User ID");
        $validation[] = array('type' => 'required','name' => 'product_type','value' => $allPost['product_type'], 'fine_name' => "Product Type");
        $validation[] = array('type' => 'required','name' => 'message','value' => $allPost['message'], 'fine_name' => "Messages");
        if($allPost['assign_to'])
            $validation[] = array('type' => 'required','name' => 'assign_to','value' => $allPost['assign_to'], 'fine_name' => "Assign To");
        else
            $validation[] = array('type' => 'required','name' => 'email','value' => $allPost['email'], 'fine_name' => "Email");
            
        $is_valid = CheckValidation($validation, $this->validation);
        if($is_valid === true){
            $case = array(
            "content_products_id" => $allPost['product_type'],
            "created_by" => $user_id,
            "messages" => $allPost['message'],
            "status" => "pending",
            "email" => $allPost['email'],
            "case_type" => $allPost['case_type'],
            "assign_to" => $allPost['assign_to'] == '' ? NULL : $allPost['assign_to'],
            "related_conversation" => $allPost['related_conversation']
            );
            
            $this->case_model->CreateCase($case);
            echo json_encode(array(
                        "success" => true,
                        "message" => "Assign case successfully done."
                    )
                );
        }
        else{
             echo json_encode(array(
                        "success" => false,
                        "message" => "Assign case was failed.",
                        "errors" => $is_valid
                    )
                );
        }
        
    }
    
    function TwitterRelatedConversation($twitter_user_id, $type = "mentions"){
        $this->load->model('twitter_model');
        $filter["b.twitter_user_id"] = $twitter_user_id;
        $filter["b.type"] = $type;
        $filter["a.post_id !="] = $this->input->get('post_id');
        
        echo json_encode($this->twitter_model->ReadTwitterData($filter, 3));
    }
    
}