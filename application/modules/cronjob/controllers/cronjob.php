<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cronjob extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('facebook_model');
        $this->load->model('account_model');
        $this->load->model('twitter_model');
    }
    
    function index(){
        
    }
    
    
    // Purposed for save facebook stream to database.... 
    function FacebookStreamOwnPost(){
        $filter = array(
            "connection_type" => "facebook"
        );
        if($this->input->get('channel_id')){
            $filter['channel_id'] = $this->input->get('channel_id');
        }
        $channel_loaded = $this->account_model->GetChannel($filter);
        $conversation_list = array();
        $access_tokens = array();
        foreach($channel_loaded as $channel){
            $newStd = new stdClass();
            $newStd->token = $this->facebook_model->GetPageAccessToken($channel->oauth_token, $channel->social_id);
            $newStd->page_id = $channel->social_id;
            $newStd->channel = $channel;
            $access_tokens[] = $newStd;
        }
        
        foreach($access_tokens as $access_token){
            $post = $this->facebook_model->RetrievePost($access_token->page_id, $access_token->token);
            $this->facebook_model->TransferFeedToDb($post, $access_token->channel );
        }
    }
    
    function FacebookStreamFeed(){
        $filter = array(
            "connection_type" => "facebook"
        );
        if($this->input->get('channel_id')){
            $filter['channel_id'] = $this->input->get('channel_id');
        }
        $channel_loaded = $this->account_model->GetChannel($filter);
        $conversation_list = array();
        $access_tokens = array();
        foreach($channel_loaded as $channel){
            $newStd->page_id = $channel->social_id;
            $newStd->token = $this->facebook_model->GetPageAccessToken($channel->oauth_token, $channel->social_id);
            $newStd->channel = $channel;
            $access_tokens[] = $newStd;
        }
        
        foreach($access_tokens as $access_token){
            $post = $this->facebook_model->RetrievePost($access_token->page_id, $access_token->token, false);
            $this->facebook_model->TransferFeedToDb($post, $access_token->channel);
        }
    }
    
    
    function  FacebookConversation(){
        $filter = array(
            "connection_type" => "facebook"
        );
        if($this->input->get('channel_id')){
            $filter['channel_id'] = $this->input->get('channel_id');
        }
        $channel_loaded = $this->account_model->GetChannel($filter);
        $conversation_list = array();
        $access_tokens = array();
        foreach($channel_loaded as $channel){
            $newStd = new stdClass();
            $newStd->page_id = $channel->social_id;
            $newStd->token = $this->facebook_model->GetPageAccessToken($channel->oauth_token, $channel->social_id);
            $newStd->channel = $channel;
            $access_tokens[] = $newStd;
        }
        
        
        foreach($access_tokens as $access_token){
            $conversation = $this->facebook_model->RetrieveConversation($access_token->page_id, $access_token->token);
            $this->facebook_model->SaveConversation($conversation, $access_token->channel);
            echo "<pre>";
            print_r($conversation);
            echo "</pre>";
        }
        
    }
    
    
    
    
    
    function TwitterMentions(){
        $this->load->model("twitter_model");
        $filter = array(
            'connection_type' => "twitter"
        );
        $channel_loaded = $this->account_model->GetChannel($filter);
        
        foreach($channel_loaded as $channel){
            $this->twitter_model->InitConnection($channel->oauth_token, $channel->oauth_secret);
            $this->twitter_model->Mentions($channel);
        }
    }
    function TwitterHomeFeed(){
        $this->load->model("twitter_model");
        $filter = array(
            'connection_type' => "twitter"
        );
        $channel_loaded = $this->account_model->GetChannel($filter);
        
        foreach($channel_loaded as $channel){
            $this->twitter_model->InitConnection($channel->oauth_token, $channel->oauth_secret);
            $this->twitter_model->HomeFeed($channel);
        }
    }
    
    function TwitterUserTimeline(){
        $this->load->model("twitter_model");
        $filter = array(
            'connection_type' => "twitter"
        );
        $channel_loaded = $this->account_model->GetChannel($filter);
        
        foreach($channel_loaded as $channel){
            $this->twitter_model->InitConnection($channel->oauth_token, $channel->oauth_secret);
            $this->twitter_model->OwnPost($channel);
        }
    }
    
    
    function TwitterDirectMessage(){
        $this->load->model("twitter_model");
        $filter = array(
            'connection_type' => "twitter"
        );
        $channel_loaded = $this->account_model->GetChannel($filter);
        
        foreach($channel_loaded as $channel){
            $this->twitter_model->InitConnection($channel->oauth_token, $channel->oauth_secret);
            $this->twitter_model->DirectMessage($channel);
        }
    }
    
    
    
    
}