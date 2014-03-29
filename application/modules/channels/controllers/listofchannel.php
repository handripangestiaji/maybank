<?php

class listofchannel extends CI_Controller {

    public $user_role;

    function __construct()
    {
        parent::__construct();
        $this->load->model('facebook_model');
        $this->load->model('account_model');
        
        $this->load->model('users_model');
        
        $this->user_role = $this->users_model->get_collection_detail(
		array('role_collection_id'=>$this->session->userdata('role_id')));
    }
    
    function Facebook(){
        $isAllowedToView = false;
        $filter = array(
            'connection_type' => 'facebook'
        );
        if(IsRoleFriendlyNameExist($this->user_role, 'Social Channel Management_Own_Country_View')){
            $filter['country_code'] =  $this->session->userdata('country');
            $isAllowedToView = true;
        }
        
        if(IsRoleFriendlyNameExist($this->user_role, 'Social Channel Management_Other_Country_View')){
            if(isset($filter['country_code']))
                unset($filter['country_code']);
            $isAllowedToView = true;
        }
        if(!$isAllowedToView){
            echo "<h2>PERMISSION DENIED TO SEE CHANNEL</h2>";
            exit();
        }
        $data['title'] = "Facebook";
        $data['channel_list'] = $this->account_model->GetChannel($filter);
        $data['total_row'] = $this->account_model->GetTableTotalRow('channel', $filter);
        $this->session->set_userdata('channel_token_delete', md5(time()));
        $this->load->view("channels/channel_management_list", $data);
        
    }
    
    function Twitter(){
        $isAllowedToView = false;
        $filter = array(
            'connection_type' => 'twitter'
        );
        if(IsRoleFriendlyNameExist($this->user_role, 'Social Channel Management_Own_Country_View')){
            $filter['country_code'] =  $this->session->userdata('country');
            $isAllowedToView = true;
        }
        
        if(IsRoleFriendlyNameExist($this->user_role, 'Social Channel Management_Other_Country_View')){
            if(isset($filter['country_code']))
                unset($filter['country_code']);
            $isAllowedToView = true;
        }
        if(!$isAllowedToView){
            echo "<h2>PERMISSION DENIED TO SEE CHANNEL</h2>";
            exit();
        }
        $data['title'] = "Twitter";
        $data['channel_list'] = $this->account_model->GetChannel($filter);
        $data['total_row'] = $this->account_model->GetTableTotalRow('channel', $filter);
        $this->session->set_userdata('channel_token_delete', md5(time()));
        $this->load->view("channels/channel_management_list", $data);
        
    }
    
    function Youtube(){
        $filter = array(
            'connection_type' => 'youtube'
        );
        $isAllowedToView = false;
        if(IsRoleFriendlyNameExist($this->user_role, 'Social Channel Management_Own_Country_View')){
            $filter['country_code'] =  $this->session->userdata('country');
            $isAllowedToView = true;
        }
        
        if(IsRoleFriendlyNameExist($this->user_role, 'Social Channel Management_Other_Country_View')){
            if(isset($filter['country_code']))
                unset($filter['country_code']);
            $isAllowedToView = true;
        }
        if(!$isAllowedToView){
            echo "<h2>PERMISSION DENIED TO SEE CHANNEL</h2>";
            exit();
        }
        $data['channel_list'] = $this->account_model->GetChannel($filter);
        $data['total_row'] = $this->account_model->GetTableTotalRow('channel', $filter);
        $data['title'] = "Twitter";
        $this->session->set_userdata('channel_token_delete', md5(time()));
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
                if(IsRoleFriendlyNameExist($this->user_role, 'Regional_User'))
                    $channel['country_code'] = $this->input->post('country');
                else{
                    if($this->session->userdata('country'))
                        $channel['country_code'] = $this->session->userdata('country');        
                }
                
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
