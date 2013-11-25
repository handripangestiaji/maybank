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
        $data['channel_list'] = $this->account_model->GetChannel(
            array(
                'connection_type' => 'facebook'
            )
        );
        $this->load->view("channels/channel_management_list", $data);
    }
    
    function Twitter(){
        $data['title'] = "Twitter";
        $data['channel_list'] = $this->account_model->GetChannel(
            array(
                'connection_type' => 'twitter'
            )
        );
        $this->load->view("channels/channel_management_list", $data);
    }
    
    
}
?>
