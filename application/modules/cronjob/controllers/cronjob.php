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
        print_r($access_tokens);
        foreach($channel_loaded as $channel){
            $newStd = new stdClass();
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
        if($this->input->get('channel_id')){
            $filter['channel_id'] = $this->input->get('channel_id');
        }
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
        if($this->input->get('channel_id')){
            $filter['channel_id'] = $this->input->get('channel_id');
        }
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
    
    function SendScheduledPost(){
        $this->load->model('post_model');
        
        $time_now = date('Y-m-d H:i:s');
        $time_3_min_ago = date('Y-m-d H:i:s',strtotime('-3 min'));
        
        $where = "time_to_post Between '".$time_3_min_ago."' AND '".$time_now."' AND is_posted is NULL";
        $posts = $this->post_model->GetPosts($where);
        foreach($posts as $post){
            //handle if facebook
            if($post->connection_type == 'facebook'){
                $this->FbStatusUpdate($post);
            }
            //handle if twitter
            elseif($post->connection_type == 'twitter'){
                $this->TwitterStatusUpdate($post);
            }
            
            //write to database is_posted = true;
            $value = array('post_created_at' => date('Y-m-d H:i:s'),
                            'is_posted' => 1);
            $this->post_model->UpdatePostTo($post->post_to_id,$value);
        }
    }
    
    public function FbStatusUpdate($post = NULL){
        if($post == NULL){
            $messages = $this->input->post('content');
            $channel_id = $this->input->post('channel_id');
        }
        else{
            $messages = $post->messages;
            $channel_id = $post->channel_id;
        }
        
        $this->load->model('account_model');
        $this->load->model('facebook_model');
     
        $filter = array(
            "connection_type" => "facebook"
        );
        $filter['channel_id'] = $channel_id;
        $channel_loaded = $this->account_model->GetChannel($filter);
        $newStd = new stdClass();
        $newStd->page_id =  $channel_loaded[0]->social_id;
        $newStd->token = $this->facebook_model->GetPageAccessToken( $channel_loaded[0]->oauth_token, $channel_loaded[0]->social_id);
      
        $access_token_fb = fb_dummy_accesstoken();
        $config = array(
             'appId' => $this->config->item('fb_appid'),
             'secret' => $this->config->item('fb_secretkey')
        );
        $this->load->library('facebook',$config);
        $this->facebook->setaccesstoken($newStd->token);
        $result = $this->facebook->api('/me/feed','POST',array('message'=>$messages));
        echo json_encode($result);
    }
    
    public function TwitterStatusUpdate($post = NULL){
        if($post == NULL){
            $messages = $this->input->post('content');
            $channel_id = $this->input->post('channel_id');
        }
        else{
            $messages = $post->messages;
            $channel_id = $post->channel_id;
        }
        
        $this->load->helper('basic');
        $this->load->library('Twitteroauth');
        $this->config->load('twitter');
        
        $filter['channel_id'] = $channel_id;
        $channel_loaded = $this->account_model->GetChannel($filter);
        $newStd = new stdClass();
        $newStd->page_id =  $channel_loaded[0]->social_id;
        
        $this->connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'),
                                                        $this->config->item('twitter_consumer_secret'),
                                                        $channel_loaded[0]->oauth_token,
                                                        $channel_loaded[0]->oauth_secret);
        
        $parameters = array('status' => $messages);
        $result = $this->connection->post('statuses/update', $parameters);
        echo json_encode($result);
    }
}