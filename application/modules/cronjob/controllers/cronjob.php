<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cronjob extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('facebook_model');
        $this->load->model('account_model');
        $this->load->model('twitter_model');
        $this->load->config('mail_config');
	$config = $this->config->item('mail_provider');
	$this->load->library('email',$config);
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
        $time_few_min_ago = date('Y-m-d H:i:s',strtotime('-10 min'));
        
        $where = "time_to_post Between '".$time_few_min_ago."' AND '".$time_now."' AND is_posted is NULL";
        $posts = $this->post_model->GetPosts($where);
        foreach($posts as $post){
            //handle if facebook
            if($post->connection_type == 'facebook'){
                $post_to = json_decode($this->FbStatusUpdate($post));
            }
            //handle if twitter
            elseif($post->connection_type == 'twitter'){
                $post_to = json_decode($this->TwitterStatusUpdate($post));
            }
            
            //write to database is_posted = true;
            $value = array('post_created_at' => date('Y-m-d H:i:s'),
                            'is_posted' => 1);
            $this->post_model->UpdatePostTo($post->post_to_id,$value);
            
            //send email
            $this->email->set_newline("\r\n");
            $this->email->from('tes@gmail.com','maybank');
            $this->email->to('benawv@gmail.com');    
            $this->email->subject('Message Posted');
            $template = curl_get_file_contents(base_url().'mail_template/PostSent/'.$post->post_to_id);
            $this->email->message($template);
            $this->email->send();
        }	    
    }
    
    public function FbStatusUpdate($post = NULL){
        if($post == NULL){
            $messages = $this->input->post('content');
            $channel_id = $this->input->post('channel_id');
            $title = $this->input->post('title');
            $link = $this->input->post('link');
            $description = $this->input->post('description');
            $image_to_post = $this->input->post('image');
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
             'secret' => $this->config->item('fb_secretkey'),
        );
        $this->load->library('facebook',$config);
        $this->facebook->setaccesstoken($newStd->token);
        
        if($image_to_post != ''){
            $this->load->helper('file');
            $img = $image_to_post;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace('data:image/jpeg;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            $file_name = uniqid().'.png';
            $pathToSave = $this->config->item('assets_folder').$file_name;
            if (write_file($pathToSave, $data)){    
                $this->facebook->setFileUploadSupport(true);
                $args = array('message' => $messages);
                $args['image'] = '@' . realpath($pathToSave);
                $result = $this->facebook->api('/me/photos', 'post', $args);
            }
            else{
                $result = $this->facebook->api('/me/feed','POST',array('message'=>$messages));
            }
        }
        
        if($link != '')
        {
            $attachment = array(
                'message' => $messages,
                'name' => $title,
                'link' => $link,
                'description' => $description,
            );  
            $result = $this->facebook->api('/me/feed','POST',$attachment);
        }
        
        if(($link == '') && ($image_to_post == '')){
            $result = $this->facebook->api('/me/feed','POST',array('message' => $messages));    
        }
        
        echo json_encode($result);
    }
    
    public function TwitterStatusUpdate($post = NULL){
        if($post == NULL){
            $messages = $this->input->post('content');
            $channel_id = $this->input->post('channel_id');
            $image_to_post = $this->input->post('image');
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
        
        if($image_to_post != ''){
            $this->load->helper('file');
            $img = $image_to_post;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace('data:image/jpeg;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            $file_name = uniqid().'.png';
            $pathToSave = $this->config->item('assets_folder').$file_name;
            $image_to_post = $pathToSave;
            if ( ! write_file($pathToSave, $data)){
                $validation = array('result' => FALSE,'name' => 'image '.$pathToSave,'error_code' => 112);
                $result=$this->connection->post('statuses/update', $parameters);
            }
            else{
                require_once './application/libraries/codebird.php';
                $this->load->config('twitter');
                Codebird::setConsumerKey($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'));
                $cb = Codebird::getInstance();
                $cb->setToken($channel_loaded[0]->oauth_token, $channel_loaded[0]->oauth_secret);
                $parameters['media[]'] = $pathToSave;
                $result = $cb->statuses_updateWithMedia($parameters);
                $result->params = $parameters;
            }
        }
        else{
            $result = $this->connection->post('statuses/update', $parameters);        
        }
        echo json_encode($result);
    }
    
    
     public function Test(){
        $this->load->config('youtube');
        $youtube = $this->config->item('youtube');
        
        $this->load->library('google_libs/Google_Client');
        require_once './application/libraries/google_libs/contrib/Google_YouTubeService.php';
        
        $filter = array(
            "connection_type" => "youtube"
        );
        if($this->input->get('channel_id')){
            $filter['channel_id'] = $this->input->get('channel_id');
        }
        $youtube_channel= $this->account_model->GetChannel($filter);
        $this->google_client->setClientId($youtube['client_id']);
        $this->google_client->setClientSecret($youtube['client_secret']);
       
        foreach($youtube_channel as $each_channel){
            
            $token = json_decode($each_channel->oauth_token);
            
            if($token->created + 3600 < time()){
                $this->google_client->refreshToken($token->refresh_token);
                $current_access_token = json_decode($this->google_client->getAccessToken());
                $current_access_token->refresh_token = $token->refresh_token;
                $this->account_model->YoutubeRefreshToken(json_encode($current_access_token), $each_channel->channel_id, date("Y-m-d H:i:s", $current_access_token->created));    
            }
            else{
                $this->google_client->setAccessToken(json_encode($token));
            }
            $youtube_object = new Google_YoutubeService($this->google_client);          
            $playlistItemsResponse = $youtube_object->playlistItems->listPlaylistItems('snippet', array(
                'playlistId' => $each_channel->social_id,
                'maxResults' => 50
            ));
            
        }
        
        
    }

}