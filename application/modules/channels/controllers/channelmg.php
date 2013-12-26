<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ChannelMg extends MY_Controller {
    
    public $user_role;

    function __construct()
    {
        parent::__construct();
        $this->load->model('facebook_model');
        $this->load->library("Twitteroauth");
        $this->load->model('account_model');
        $this->load->model('users_model');
        
        $this->user_role = $this->users_model->get_collection_detail(
		array('role_collection_id'=>$this->session->userdata('role_id')));
    }
    
    function index(){
        
        $this->load->view("channels/index");
    }
    
    function AddFacebook(){
        if(IsRoleFriendlyNameExist($this->user_role,'Social Channel Management_Add')){
            $this->load->config('facebook');
            $this->load->library('Facebook', array(
                'appId' => $this->config->item('fb_appid'),
                'secret' => $this->config->item('fb_appsecret')
            ));
            
            $user = $this->facebook->getUser();
            if ($user) {
                $logoutUrl = $this->facebook->getLogoutUrl();
            }else {
    
                $params = array(
                    'scope' => 'read_stream, manage_pages, publish_stream, read_mailbox, export_stream, publish_checkins, read_insights, read_requests,
                            status_update, photo_upload, email, read_page_mailboxes',
                    'redirect_uri' => base_url('channels/channelmg/TokenFacebook')
                );
                $loginUrl = $this->facebook->getLoginUrl($params);
                redirect($loginUrl);
            }
        }
        else
        {
            redirect('channels/channelmg');
        }
    }
    
    function AddTwitter(){
        // Making a request for request_token
        if(IsRoleFriendlyNameExist($this->user_role,'Social Channel Management_Add')){
            $connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'),
                                                      $this->config->item('twitter_consumer_secret'));
            
            $request_token = $connection->getRequestToken(site_url('channels/channelmg/TokenTwitter'));
            //print_r($connection);
            $this->session->set_userdata('request_token', $request_token['oauth_token']);
            $this->session->set_userdata('request_token_secret', $request_token['oauth_token_secret']);
            if($connection->http_code == 200)
            {
                $url = $connection->getAuthorizeURL($request_token);
                redirect($url);
            }
            else
            {
                // An error occured. Make sure to put your error notification code here.
                redirect('/error_page_faild_auth');
            }
        }
        else
        {
            redirect('channels/channelmg');
        }
    }
    
    public function TokenTwitter()
    {
        if($this->session->userdata('request_token')){
            $connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'),
                                                      $this->config->item('twitter_consumer_secret'),
                                                      $this->session->userdata('request_token'),
                                                      $this->session->userdata('request_token_secret'));
            $access_token = $connection->getAccessToken($this->input->get('oauth_verifier'));
            if ($connection->http_code == 200)
            {
                $this->session->unset_userdata('request_token');
                $this->session->unset_userdata('request_token_secret');
                
                $channel['oauth_token'] = $access_token['oauth_token'];
                $channel['oauth_secret'] = $access_token['oauth_token_secret'];
                $channel['social_id']=$access_token['user_id'];
                $channel['connection_type'] = "twitter";
                $channel['is_active'] = 1;
                $channel['name'] = $access_token['screen_name'];
                $channel['token_created_at'] = date("Y-m-d H:i:s");
                $this->account_model->SaveChannel($channel);
                redirect('channels/channelmg');
            }
        }
    }
    
    public function TokenFacebook(){
        $this->load->config('facebook');
        $app_id = $this->config->item('fb_appid');
        $app_secret = $this->config->item('fb_appsecret');
        $my_url = base_url('channels/channelmg/TokenFacebook');  // redirect url
        $code = $this->input->get("code");
        if(empty($code)) {
            // Redirect to Login Dialog
            $this->session->set_userdata('state', md5(uniqid(rand(), TRUE))); // CSRF protection
            $dialog_url = "https://www.facebook.com/dialog/oauth?client_id=" 
                  . $app_id . "&redirect_uri=" . urlencode($my_url) . "&state="
                  . $this->session->userdata('state') . "&scope=publish_stream,read_friendlists,email,manage_pages,export_stream,publish_actions,publish_checkins,read_stream";
            redirect($dialog_url);
        }
        if($code){
            $token_url = "https://graph.facebook.com/oauth/access_token?"
              . "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url)
              . "&client_secret=" . $app_secret . "&code=" . $code;
            
            $response = curl_get_file_contents($token_url);
            $params = null;
            parse_str($response, $params);
            $longtoken=$params['access_token'];
            $this->session->set_userdata('fb_token', $longtoken);
            redirect('channels/channelmg/index?FacebookConfirm=yes');
        }
    }
    
    public function DeleteChannel(){
        if(IsRoleFriendlyNameExist($this->user_role,'Social Channel Management_Remove')){
            $channel_id = $this->input->get('channel_id');
            if($this->session->userdata('channel_token_delete') == $this->input->get('token')){
                //DELETE channel
                $this->account_model->DeleteChannel($channel_id);
                $this->session->unset_userdata('channel_token_delete');
                redirect('channels/channelmg');
            }
        //redirect('channels/channelmg');
        }
        else
        {
            redirect('channels/channelmg');
        }
    }
    
    public function AddYoutube(){
        $this->load->config('youtube');
        $youtube = $this->config->item('youtube');
        $this->load->library('google_libs/Google_Client');
        require_once './application/libraries/google_libs/contrib/Google_YouTubeService.php';
        
        $this->google_client->setClientId($youtube['client_id']);
        $this->google_client->setClientSecret($youtube['client_secret']);
        $redirect = filter_var(base_url('channels/channelmg/AddYoutube'), FILTER_SANITIZE_URL);
        $this->google_client->setRedirectUri($redirect);
        
        $youtubeObject = new Google_YoutubeService($this->google_client);
        
        if($this->input->get('code')){
            $this->google_client->authenticate();
            $this->session->set_userdata('youtube_at', $this->google_client->getAccessToken());
            $channel = array(
                
            );
            
        }else{
            $state = mt_rand();
            $this->google_client->setState($state);
            $this->session->set_userdata('youtube_state', $state);
          
            $authUrl = $this->google_client->createAuthUrl();
            redirect($authUrl);
        }
        
        
    }
    
    public function Test(){
        $this->load->config('youtube');
        $youtube = $this->config->item('youtube');
        $youtube_access_token = $this->session->userdata('youtube_at');
        $this->load->library('google_libs/Google_Client');
        require_once './application/libraries/google_libs/contrib/Google_YouTubeService.php';
        print_r($youtube_access_token);
        
        $this->google_client->setClientId($youtube['client_id']);
        $this->google_client->setClientSecret($youtube['client_secret']);
        $redirect = filter_var(base_url('channels/channelmg/AddYoutube'), FILTER_SANITIZE_URL);
        $this->google_client->setAccessToken($youtube_access_token);

        $youtube_object = new Google_YouTubeService($this->google_client);
        $channelsResponse = $youtube_object->channels->listChannels('contentDetails', array(
            'mine' => 'true',
          ));
        
        echo "<pre>";print_r($channelsResponse);
        print_r($youtube_access_token);
        foreach ($channelsResponse['items'] as $channel) {
            // Extract the unique playlist ID that identifies the list of videos
            // uploaded to the channel, and then call the playlistItems.list method
            // to retrieve that list.
            $uploadsListId = $channel['contentDetails']['relatedPlaylists']['uploads'];
      
            $playlistItemsResponse = $youtube_object->playlistItems->listPlaylistItems('snippet', array(
              'playlistId' => $uploadsListId,
              'maxResults' => 50
            ));
            
            $htmlBody = "<h3>Videos in list $uploadsListId</h3><ul>";
            foreach ($playlistItemsResponse['items'] as $playlistItem) {
                
                print_r($playlistItem);
                
            }
        }
        
        echo "</pre>";
    }

    
    
}