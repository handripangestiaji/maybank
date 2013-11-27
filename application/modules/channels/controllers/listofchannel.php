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
    
    public function FacebookPagePick(){
        $list = explode(",", $this->input->post('id'));
        $pageName = explode(",", $this->input->post('pageName'));
        $i = 0;
        foreach($list as $page){
            if($page != ''){
                $channel['oauth_token'] = $this->session->userdata('fb_token');
                $channel['oauth_secret'] = '';
                $channel['social_id']= $page;
                $channel['connection_type'] = "facebook";
                $channel['is_active'] = 1;
                $channel['name'] = $pageName[$i];
                $channel['token_created_at'] = date("Y-m-d H:i:s");
                $i++;
                $this->account_model->SaveChannel($channel);
                
            }
        }
        $this->session->unset_userdata('fb_token');
        echo json_encode(
            array(
                "message" => "Successfully update facebook channel."
            )
        );
    }
}
?>
