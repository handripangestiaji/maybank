<?php

class listofchannel extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('facebook_model');
        $this->load->model('account_model');
    }
    
    
    function Facebook(){
        $data['title'] = "Facebook";
        $this->load->view("channels/channel_management_list", $data);
    }
    
    function Twitter(){
        $data['title'] = "twitter";
        $this->load->view("channels/channel_management_list", $data);
    }
    
    function AddFacebook(){
           
    }
    
    function AddTwitter(){
        
    }
    
    function test(){
        echo "<pre>".json_encode($this->account_model->GetRole())."</pre>";
    }
}
?>
