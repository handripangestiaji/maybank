<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cronjob extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('facebook_model');
        $this->load->model('account_model');
        $this->load->model('twitter_model');
        $this->load->config('search');
        if($this->input->get('key') != $this->config->item('cronjob_password')){
            header("HTTP/1.1 403 Forbidden");
            echo "403 Forbidden";
            exit();
        }
    }
    
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
            $post = $this->facebook_model->RetrievePost($channel->social_id, $channel->oauth_token);
            $this->facebook_model->TransferFeedToDb($post, $channel_loaded );   
        }
        //print_r($post);
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
            $post = $this->facebook_model->RetrieveFeed($channel->social_id, $channel->oauth_token, false);
            print_r($post);
            //$this->facebook_model->TransferFeedToDb($post,$channel_loaded);
        }
    }
    
    function FacebookConversation(){
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
            $post = $this->facebook_model->RetrieveConversation($channel->social_id, $channel->oauth_token);
            //$this->facebook_model->SaveNewConversation($conversation->data,$access_token->channel, $access_token);
            print_r($post);
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
        print_r($channel_loaded);
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
        $time_tomorrow = date('Y-m-d H:i:s',strtotime('+1 day'));
        $time_yesterday = date('Y-m-d H:i:s',strtotime('-1 day'));
        $where = "time_to_post Between '".$time_yesterday."' AND '".$time_tomorrow."' AND is_posted is NULL";
        $posts = $this->post_model->GetPosts($where);
                    
        foreach($posts as $post){
            //print_r($post);
            $dtz = new DateTimeZone($post->timezone);
            $local_time = new DateTime('now', $dtz);
            $offset = $dtz->getOffset( $local_time ) / 3600;
            $current_date = new DateTime(date("Y-m-d H:i:s").' UTC');
            $current_date->setTimezone($dtz);
            
            $local_time = $current_date->format("Y-m-d H:i");
            $post_time = date('Y-m-d H:i',strtotime($post->time_to_post));
            //print_r($local_time.' & '.$post_time);
            if($local_time >= $post_time){
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
                if($post->email_me_when_sent == 1){
                    $this->load->config('mail_config');
                    $mail_provider = $this->config->item('mail_provider');
                    $this->load->library('email', $mail_provider);
                    $mail_from = $this->config->item('mail_from');
                    
                
                    $this->email->set_newline("\r\n");
                    $this->email->from($mail_from['address'], $mail_from['name']);
                    $this->email->to($post->email);
                    $this->email->subject('Your scheduled post was published');
                    $this->email->bcc($mail_from['cc']);
                    $template = curl_get_file_contents(base_url().'mail_template/PostSent/'.$post->post_to_id);
                    $this->email->message($template);
                    $this->email->send();
                    echo $this->email->print_debugger();
                }
            }
        }
    }
    
    public function FbStatusUpdate($post = NULL){
        if($post == NULL){
            $messages = $this->input->post('content');
            $channel_id = $this->input->post('channel_id');
            $title = $this->input->post('title');
            $short_code = $this->input->post('short_url');
            $description = $this->input->post('description');
            $image_to_post = $this->input->post('image');
        }
        else{
            $messages = $post->messages;
            $channel_id = $post->channel_id;
            $title = $post->url_title;
            $short_code = $post->short_code;
            $description = $post->url_description;
            $image_to_post = $post->image;
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
      
        
        $config = array(
             'appId' => $this->config->item('fb_appid'),
             'secret' => $this->config->item('fb_secretkey'),
        );
        $this->load->library('facebook',$config);
        $this->facebook->setaccesstoken($newStd->token);
    
        if($post != NULL){    
            if($image_to_post != ''){
                $this->facebook->setFileUploadSupport(true);
                $args = array('message' => $messages);
                $args['image'] = '@' . realpath($image_to_post);
                $result = $this->facebook->api('/me/photos', 'post', $args);
            }
        }
        else{
            if($image_to_post != ''){
                $this->load->helper('file');
                $img = $this->input->post('image');
                $img = str_replace('data:image/png;base64,', '', $img);
                $img = str_replace('data:image/jpeg;base64,', '', $img);
                $img = str_replace(' ', '+', $img);
                $data = base64_decode($img);
                $file_name = uniqid().'.png';
                $pathToSave = $this->config->item('assets_folder').$file_name;
                
                if ( ! write_file($pathToSave, $data)){
                    $result = $this->facebook->api('/me/feed','POST',array('message' => $messages));
                }
                else{
                    $this->facebook->setFileUploadSupport(true);
                    $args = array('message' => $messages);
                    $args['image'] = '@' . realpath($pathToSave);
                    $result = $this->facebook->api('/me/photos', 'post', $args);
                }
            }
        }
        
        if($short_code != '')
        {
            $attachment = array(
                'message' => $messages,
                'name' => $title,
                'picture' => $this->input->post('linkImage'),
                'link' => 'http://maybk.co/'.$short_code,
                'description' => $description,
            );
            if(!$this->input->post('linkImage'))
                unset($attachment['picture']);
            $result = $this->facebook->api('/me/feed','POST',$attachment);
        }
        
        if(($short_code == '') && ($image_to_post == '')){
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
            $title = $post->url_title;
            //$link = $post,
            $description = $post->url_description;
            $image_to_post = $post->image;
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
        
        if($post != NULL){
            if($image_to_post != ''){
                require_once './application/libraries/codebird.php';
                $this->load->config('twitter');
                Codebird::setConsumerKey($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'));
                $cb = Codebird::getInstance();
                $cb->setToken($channel_loaded[0]->oauth_token, $channel_loaded[0]->oauth_secret);
                $parameters['media[]'] = $image_to_post;
                $result = $cb->statuses_updateWithMedia($parameters);
                $result->params = $parameters;
            }
            else{
                $result = $this->connection->post('statuses/update', $parameters);
            }
        }
        else{
            if($image_to_post != ''){
                $this->load->helper('file');
                $img = $this->input->post('image');
                $img = str_replace('data:image/png;base64,', '', $img);
                $img = str_replace('data:image/jpeg;base64,', '', $img);
                $img = str_replace(' ', '+', $img);
                $data = base64_decode($img);
                $file_name = uniqid().'.png';
                $pathToSave = $this->config->item('assets_folder').$file_name;
                if ( ! write_file($pathToSave, $data)){
                    $result = $this->connection->post('statuses/update', $parameters);
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
        }
        echo json_encode($result);
    }
    
    
     public function YoutubeVideo(){
        $this->load->config('youtube');
        $youtube = $this->config->item('youtube');
        
        $this->load->library('google_libs/Google_Client');
        require_once './application/libraries/google_libs/contrib/Google_YouTubeService.php';
        require_once './application/libraries/google_libs/contrib/Google_YouTubeAnalyticsService.php';
        $this->load->library('youtube_libs');
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
                $token = $current_access_token;
            }
            else{
                $this->google_client->setAccessToken(json_encode($token));
            }
            $youtube_object = new Google_YoutubeService($this->google_client);          
            $playlistItemsResponse = $youtube_object->playlistItems->listPlaylistItems('snippet', array(
                'playlistId' => $each_channel->social_id,
                'maxResults' => 50
            ));
            $this->load->model('youtube_model');
            
            $video = array();
            for($i=0; $i< count($playlistItemsResponse['items']); $i++){
                $detail_video = $this->youtube_libs->ReadVideoRatings($playlistItemsResponse['items'][$i]['snippet']['resourceId']['videoId']);
                $detail_video->data->etag = $playlistItemsResponse['items'][$i]['etag'];
                $detail_video->data->stream_id = $playlistItemsResponse['items'][$i]['id'];
                $this->youtube_model->SaveYouTubePost($detail_video, $each_channel->channel_id);
                $comment_list = $this->getAndPrintCommentFeed($playlistItemsResponse['items'][$i]['snippet']['resourceId']['videoId']);
                $this->youtube_model->SaveYoutubeComment($comment_list, $each_channel->channel_id);
                $video[] = $detail_video;
                print_r($detail_video);
            }
            
            
        }
        
        
    }
    
    function getAndPrintCommentFeed($video_id){
        
        $video_comment_feed = curl_get_file_contents("http://gdata.youtube.com/feeds/api/videos/$video_id/comments?v=2&alt=json");
        $video_comment_feed = json_decode($video_comment_feed);
        
        $comments = array();
        if(isset($video_comment_feed->feed->entry)){
            foreach($video_comment_feed->feed->entry as $entry){
                $comment_feed = new stdClass();
                $comment_feed->id = $entry->id->{'$t'};
                $comment_feed->created_at = $entry->published->{'$t'};
                $comment_feed->title = $entry->title->{'$t'};
                $comment_feed->content = $entry->content->{'$t'};
                $comment_feed->channel_id = $entry->{'yt$channelId'}->{'$t'};
                $comment_feed->google_plus_user_id = $entry->{'yt$googlePlusUserId'}->{'$t'};
                $comment_feed->reply_count = $entry->{'yt$replyCount'}->{'$t'};
                $comment_feed->author_name = $entry->author[0]->name->{'$t'};
                $comment_feed->author_uri = $entry->author[0]->uri->{'$t'};
                $comment_feed->user_id = $entry->author[0]->{'yt$userId'}->{'$t'};
                $comment_feed->video_id = $entry->{'yt$videoid'}->{'$t'};
                $comments[] = $comment_feed;
            }
            return $comments;
        }
        else{
            return null;
        }
    }
    
    
    public function LookUpUrl($short_url = ''){
        header("Content-Type:application/json");
        if($this->input->get('short_url')){
            $this->db->select("id, long_url");
            $this->db->from('short_urls');
            $this->db->where('short_code', $this->input->get('short_url'));
            $row = $this->db->get()->row();
            if($row != null){
                $this->load->model('shorturl_model');
                $params = array("increment" => "increment + 1");
                $this->shorturl_model->update($row->id, $params);
                echo json_encode(array(
                    'long_url' => $row->long_url,
                    'short_url' => $this->input->get('short_url')
                 ));
            }
            else{
                $staging = $this->load->database('staging', true);
                $staging->select("long_url");
                $staging->from('short_urls');
                $staging->where('short_code', $this->input->get('short_url'));
                $row = $staging->get()->row();
                echo json_encode(array(
                    'long_url' => isset($row->long_url) ? $row->long_url : NULL,
                    'short_url' => $this->input->get('short_url')
                 ));
                $staging->close();
            }
        }
        else
              echo json_encode(array(
                'long_url' => NULL,
                'short_url' => $this->input->get('short_url')
             ));       

    }
    
    function GenerateActivity(){
        $this->load->model('reports_model');
        
        //select date max
        $result = $this->reports_model->selectMaxDate()->row();
            
        //if the date result = null, the date = 1 january 1970
        if($result != null){
            $latest_date = $result->time;
        }
        else{
            $latest_date = '1970-01-01 00:00:00'; 
        }
            
        //call reports_model->generate_report_activity(the date)
        $result = $this->reports_model->generate_report_activity($latest_date);
        
        //print the return
        print_r(json_encode($result));
    }
    
    function DestroyReportActivity(){
        $this->load->model('reports_model');
        $this->reports_model->destroy_report_activity();
    }
    
    public function error_page(){
	$data['heading'] = $this->input->get('heading');
	$data['content'] = $this->input->get('content');
	    
	$this->load->view('login/error-page', $data);
    }
   
}
