<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Media_stream extends CI_Controller {

    private $connection;
	   
    function __construct()
    {
	parent::__construct();
	// Loading TwitterOauth library. 
	$this->config->load('twitter');
	$this->config->load('facebook');
	$this->load->library('ion_auth');
	$this->load->library('Twitteroauth');
	$this->load->library('session');
	$this->load->helper('url');
	$this->load->helper('array');
	$this->load->helper('form');
	$this->load->model('facebook_model');
	$this->load->model('twitter_model');
	  
	$this->session->set_userdata('access_token', $this->config->item('twitter_access_token'));
	$this->session->set_userdata('access_token_secret', $this->config->item('twitter_access_secret'));
	  
	if($this->session->userdata('access_token') && $this->session->userdata('access_token_secret'))
	{
		// If user already logged in
		$this->connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'), $this->config->item('twitter_access_token'),  $this->config->item('twitter_access_secret'));
	}
	elseif($this->session->userdata('request_token') && $this->session->userdata('request_token_secret'))
	{
		// If user in process of authentication
		$this->connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'), $this->session->userdata('request_token'), $this->session->userdata('request_token_secret'));
	}
	else
	{
		// Unknown user
		$this->connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'));
	}
    }
    
    
    public function facebook_stream($channel_id,$is_read = NULL){
	$filter = array(
	   'channel_id' => $channel_id,
	);
	if($is_read != NULL){
	    if($is_read != 2){
		$filter['is_read'] = $is_read;
	    }
	}
    $limit=10;
	$data['fb_feed'] = $this->facebook_model->RetrieveFeedFB($filter,$limit);
	$data['count_fb_feed']=$this->facebook_model->CountFeedFB($filter);
    //$data['own_post'] = $this->facebook_model->RetrievePostFB($filter);
	$data['fb_pm'] = $this->facebook_model->RetrievePmFB($filter,$limit);
    $data['CountPmFB']=$this->facebook_model->CountPmFB($filter);
    
	$this->load->model('campaign_model');
	$data['product_list'] = $this->campaign_model->GetProduct();
	$data['channel_id'] = $channel_id;
	$this->load->model('case_model');
	$data['user_list'] = $this->case_model->ReadAllUser();
	$this->load->view('dashboard/facebook/facebook_stream',$data);
    }
    
    public function twitter_stream($channel_id,$is_read = null){
    	$limit = $this->config->item('item_perpage');
    	$filter = array(
    	   'a.channel_id' => $channel_id,
    	);
    	
    	if($is_read != NULL){
    	    if($is_read != 2){
    		$filter['is_read'] = $is_read;
    	    }
    	}
    
    	$this->load->model('case_model');
    	$data['user_list'] = $this->case_model->ReadAllUser();
    	$filter['b.type'] = 'mentions';
    	$data['mentions']=$this->twitter_model->ReadTwitterData($filter,$limit);
        $data['countMentions']=$this->twitter_model->CountTwitterData($filter);
    
    	$filter['b.type'] = 'home_feed';
    	$data['homefeed']=$this->twitter_model->ReadTwitterData($filter,$limit);
        $data['countFeed']=$this->twitter_model->CountTwitterData($filter);
             
    	$filter['b.type'] = 'user_timeline';
    	$data['senttweets']=$this->twitter_model->ReadTwitterData($filter,$limit);  
        $data['countTweets']=$this->twitter_model->CountTwitterData($filter);
        
    	unset($filter['b.type']);
    	$data['directmessage']=$this->twitter_model->ReadDMFromDb($filter,$limit);
        $data['countDirect']=$this->twitter_model->CountTwitterData($filter);
    	$data['channel_id'] = $channel_id;
    	
    	$this->load->model('campaign_model');
    	$data['product_list'] = $this->campaign_model->GetProduct();
    	$this->load->view('dashboard/twitter/twitter_stream',$data);
    }
	
    public function auth()
    {
	    
	    if($this->session->userdata('access_token') && $this->session->userdata('access_token_secret'))
	    {
		    // User is already authenticated.
		      $data['twiteerAction']=$this->connection->get('statuses/home_timeline');   
		     $this->load->view('dashboard/index',$data);
	    }
	    else
	    {
		    // Making a request for request_token
		    $request_token = $this->connection->getRequestToken(base_url('/index.php/dashboard/callback'));
		    $this->session->set_userdata('request_token', $request_token['oauth_token']);
		    $this->session->set_userdata('request_token_secret', $request_token['oauth_token_secret']);
		    if($this->connection->http_code == 200)
		    {
			    $url = $this->connection->getAuthorizeURL($request_token);
			    redirect($url);
		    }
		    else
		    {
			    // An error occured. Make sure to put your error notification code here.
			    redirect(base_url('/error_page_faild_auth'));
		    }
	    }
    }
    
    public function callback()
    {
	    if($this->input->get('oauth_token') && $this->session->userdata('request_token') !== $this->input->get('oauth_token'))
	    {
			    $this->reset_session();
			    redirect('/dashboard/auth');
	    }
	    else
	    {
		    $access_token = $this->connection->getAccessToken($this->input->get('oauth_verifier'));
    
		    if ($this->connection->http_code == 200)
		    {
			    $this->session->set_userdata('access_token', $access_token['oauth_token']);
			    $this->session->set_userdata('access_token_secret', $access_token['oauth_token_secret']);
			    $this->session->set_userdata('twitter_user_id', $access_token['user_id']);
			    $this->session->set_userdata('twitter_screen_name', $access_token['screen_name']);
			    $this->session->unset_userdata('request_token');
			    $this->session->unset_userdata('request_token_secret');
			    redirect('dashboard');
		    }
		    else
		    {
			    // An error occured. Add your notification code here.
			    redirect(base_url('/page_error_callback'));
		    }
	    }
    }
    //=========================================Twitter function=============================================
    public function mentions()
    {
	$access_token = "CAACEdEose0cBADGyv9cLrxG0ycGrwyZBVrr4jPSG4NKHAZAZBwQS5MF1xrYdgwAiyCLZAnYvx1wBvr5I7MGxVsubO0xPMOIaYhVKsTTeVPvC05YLYfUttS0W3SzfC3wFltkY3Lo11zfH7LTVwF6zwADlv9HlAY7ZBinMshTHMM5dYxeY3ZA6bSY5zSNsDOFOsmE6bb5cbjiQZDZD";
	    $data['fb_feed'] =  $this->facebook_model->RetrievePost('168151513217686', $access_token, false);
	    $this->load->view('dashboard/index', $data);
    }
    public function twitterAction(){
	  $data['twiteerAction']=$this->connection->get('statuses/mentions_timeline');   
	  $data['twiteerAction']=$this->connection->get('statuses/home_timeline');  
	  $data['twiteerAction']=$this->connection->get('direct_messages');  
	  $data['twiteerAction']=$this->connection->get('statuses/home_timeline');  
	  $this->load->view('dashboard/index',$data); 
    }
    //=========================================END Twitter function=============================================


    //=========================================facebook function=============================================
    public function fb_access_token(){
	    $app_id = $this->config->item('fb_appid');
	    $app_secret = $this->config->item('fb_appsecret');
	    $my_url = site_url('dashboard/fb_access_token');  // redirect url
	    $code = $this->input->get("code");
     
	    if(empty($code)) {
	      // Redirect to Login Dialog
	      $this->session->set_userdata('state', md5(uniqid(rand(), TRUE))); // CSRF protection
	      $dialog_url = "https://www.facebook.com/dialog/oauth?client_id=" 
		    . $app_id . "&redirect_uri=" . urlencode($my_url) . "&state="
		    . $this->session->userdata('state') . "&scope=publish_stream,read_friendlists,email,manage_pages,export_stream,publish_actions,publish_checkins,read_stream";
     
     
	      redirect($dialog_url);
	    }
	    if($this->session->userdata('state') && ($this->session->userdata('state')=== $this->input->get('state'))) {
		     $token_url = "https://graph.facebook.com/oauth/access_token?"
		       . "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url)
		       . "&client_secret=" . $app_secret . "&code=" . $code;
		     $response = curl_get_file_contents($token_url);
		     $params = null;
		     parse_str($response, $params);
		     $longtoken=$params['access_token'];
		     print_r($params);
	    }

    }
    
    public function FbLikeStatus(){
	  $post_id=$_POST['post_id'];
      $access_token_fb = fb_dummy_accesstoken();
	  $config = array(
	       'appId' => $this->config->item('fb_appid'),
	       'secret' => $this->config->item('fb_secretkey')
	  );
	  $this->load->library('facebook',$config);
	  $this->facebook->setaccesstoken($access_token_fb);
	  $this->facebook->api('/'.$post_id.'/likes','POST');
    }
    
    public function FbReplyPost(){
        $this->load->model('account_model');
        $this->load->model('facebook_model');
        $comment = $this->input->post('comment');
        $post_id = $this->input->post('post_id');
     
	$filter = array(
            "connection_type" => "facebook"
        );
        if($this->input->get('channel_id')){
            $filter['channel_id'] = $this->input->get('channel_id');
        }
        $channel_loaded = $this->account_model->GetChannel($filter);
        $newStd = new stdClass();
        $newStd->page_id =  $channel_loaded[0]->social_id;
        $newStd->token = $this->facebook_model->GetPageAccessToken( $channel_loaded[0]->oauth_token, $channel_loaded[0]->social_id);
        $config = array(
	       'appId' => $this->config->item('fb_appid'),
	       'secret' => $this->config->item('fb_secretkey')
	    );
	$this->load->library('facebook',$config);
	$this->facebook->setaccesstoken($newStd->token);
	$this->facebook->api('/'.$post_id.'/comments','post',array('message' => $comment));
    }
    
    public function SocmedPost(){
	  $this->load->model('post_model');
	  $value = array('channel_id' => $this->input->post('channel_id'),
			 'created_by' => 0,
			 'messages' => $this->input->post('message')
			);
	  if($this->input->post('tags') != ''){
	    $tags = explode(',',$this->input->post('tags'));
	    $new_tags = array();
	    foreach($tags as $tag){
		$new_tags[] = array('content_tag_id' => $tag);
	    }
	  }
	  else{
	    $tags = ''
	  }
	$this->post_model->InsertPost($value,$tags);      
    }
    
    public function load_facebook($type){
	    $access_token = "CAACEdEose0cBAFGdZB2IH8VzRiPuoLAZC0vQ3u7Tc0PuZAyycV0cs5CCng8Xw3qnni9V6YxgeaQ0p9VCdGzfGGHTeUUsLL6exlGXBTAbWl6T7573l4DnKm3kTPh7dQrqqJNpcvMMWZA9K92p7NtS5eLwjmZCKxZCCEQ4jWk5DtccZBMZAEKS2Meqe1yzhetcUKMZD";
	    
	    print_r($this->facebook_model->RetrieveFeedFacebook('gizikudotcom', $access_token, $type));
    }
    
    public function ReadUnread(){
	  $this->load->model('facebook_model');
	  if($this->input->post('post_id')){
	    $read = $this->input->post('read');
	    $new_val = $this->facebook_model->ReadUnread($this->input->post('post_id'), $read);
	    echo $new_val;  
	  }
	  else
	    echo 0;
	  
    }
    //=========================================END facebook function=============================================    


    //=========================================GENERAL function=============================================    
    public function publish(){
	    echo $this->input->post('compose_message');
    }
    
    /**
    * Get more content data for auto load paging
    * $group_no = jumlah item terakhir yg di load
    **/
    public function LoadMore($actions,$group_numbers,$channel_ids){
            
        $items_per_group=10;
        $group_number=$group_numbers;
        $action=$actions;
        $channel_id=$channel_ids;
        $is_read=0;
        $filter = array(
    	   'channel_id' => $channel_id,
    	);
    	
        if($is_read != NULL){
    	    if($is_read != 2){
    		$filter['is_read'] = $is_read;
    	    }
    	}

     	//throw HTTP error if group number is not valid
    	if(!is_numeric($group_number)){
    		header('HTTP/1.1 500 Invalid number!');
    		exit();
    	}
    	
    	//get current starting point of records
    	$limit = ($group_number * $items_per_group);
       
        
        
        
    	$this->load->model('case_model');
    	$data['user_list'] = $this->case_model->ReadAllUser();
        
        $this->load->model('campaign_model');
        $data['product_list'] = $this->campaign_model->GetProduct();

    
        if($action=='mentions'){
        	$filter['b.type'] = 'mentions';
        	$data['mentions']=$this->twitter_model->ReadTwitterData($filter,$limit);
            $data['countMentions']=$this->twitter_model->CountTwitterData($filter);
            $this->load->view('dashboard/twitter/twitter_mentions.php',$data);
        }
        
        if($action=='feed'){
            $filter['b.type'] = 'home_feed';
        	$data['homefeed']=$this->twitter_model->ReadTwitterData($filter,$limit); 
            $data['countFeed']=$this->twitter_model->CountTwitterData($filter);
             $this->load->view('dashboard/twitter/twitter_homefeed.php',$data);
        }
        
        if($action=='sendmessage'){
        	$filter['b.type'] = 'user_timeline';
        	$data['senttweets']=$this->twitter_model->ReadTwitterData($filter,$limit);
            $data['countTweets']=$this->twitter_model->CountTwitterData($filter);
             $this->load->view('dashboard/twitter/twitter_senttweets.php',$data);

        }
//        unset($filter['b.type']);
        if($action=='direct'){
            $filter=array();
            $data['directmessage']=$this->twitter_model->ReadDMFromDb($filter,$limit);
            $data['countDirect']=$this->twitter_model->CountTwitterData($filter);
        	$data['channel_id'] = $channel_id;
            $this->load->view('dashboard/twitter/twitter_messages.php',$data);

        }
        
    //$data['own_post'] = $this->facebook_model->RetrievePostFB($filter);
        if($action=='wallPosts'){
        $filter=array();
             $data['fb_feed'] = $this->facebook_model->RetrieveFeedFB($filter,$limit);
             $data['count_fb_feed']=$this->facebook_model->CountFeedFB($filter);
             $this->load->view('dashboard/facebook/wall_post.php',$data);
        }
        
        if($action=='privateMessages'){
            $filter=array();
        	$data['fb_pm'] = $this->facebook_model->RetrievePmFB($filter,$limit);
            $data['CountPmFB']=$this->facebook_model->CountPmFB($filter);
             $this->load->view('dashboard/facebook/private_message.php',$data);
        }
        //print_r($data);
    }
    


    /**
     * Reset session data
     * @access	private
     * @return	void
     */
 
    public function reset_session()
    {
	    $this->session->unset_userdata('access_token');
	    $this->session->unset_userdata('access_token_secret');
	    $this->session->unset_userdata('request_token');
	    $this->session->unset_userdata('request_token_secret');
	    $this->session->unset_userdata('twitter_user_id');
	    $this->session->unset_userdata('twitter_screen_name');
    }
    //=========================================END GENERAL function=============================================    
    
      
  
     public function GetUrlPreview(){
	if (!isset($_GET['url'])) die();
	$url = urldecode($_GET['url']);
	$url = 'http://' . str_replace('http://', '', $url); // Avoid accessing the file system
	echo file_get_contents($url);
     }
}
