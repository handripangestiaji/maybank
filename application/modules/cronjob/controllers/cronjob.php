<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cronjob extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('facebook_model');
        $this->load->model('account_model');
    }
    
    function index(){
        
    }
    
    
    // Purposed for save facebook stream to database.... 
    function FacebookStream(){
        $filter = array(
            'channel_id' => 1
        );
        $channel_loaded = $this->account_model->GetChannel($filter);
        $conversation_list = array();
        $access_tokens = array();
        foreach($channel_loaded as $channel){
            $newStd->page_id = '168151513217686';
            $newStd->token = $this->facebook_model->GetPageAccessToken($channel->oauth_token, $channel->social_id);
            $newStd->channel = $channel->channel_id;
            $access_tokens[] = $newStd;
        }
        
        foreach($access_tokens as $access_token){
            $post = $this->facebook_model->RetrieveOwnPost($access_token->page_id, $access_token->token);
            $this->facebook_model->TransferFeedToDb($post, $access_token->channel );
        }
    }
    
    
    
    
}