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

  
     public function twitterAction(){
        
        if(isset($_POST['action'])){
            $action=$_POST['action'];   
        }
        
        if(isset($_POST['content'])){
            $content=$_POST['content'];
        }
        
        if(isset($_POST['str_id'])){
            $str_id=$_POST['str_id'];
        }
        
        if(isset($_GET['friendid'])){
            $friendid=$_GET['friendid'];
        }

        if(isset($_POST['friendid'])){
            $friendid=$_POST['friendid'];
        }
        
        if(isset($_POST['followid'])){
            $followid=$_POST['followid'];
        }
        
        if(isset($_POST['id'])){//id user
            $id=$_POST['id'];
        }
        
        if(isset($_POST['screen_name'])){//id user
            $screen_name=$_POST['screen_name'];
        }
        
        if($this->input->post('action')=='sendTweet'){ //ok

            /* statuses/update */
            $parameters = array('status' => $content);
            $this->connection->post('statuses/update', $parameters);
    
        }elseif($action=='destroy_status'){
    
            /* statuses/destroy */
            $method = "statuses/destroy".$str_id;
            $this->connection->delete($method);    
    
        }elseif($action=='replayTweet'){//replay tweet,Direct message        
            /* statuses/update */
            $parameters = array('status' => $content,'in_reply_to_status_id'=>$str_id);
                
            $result=$this->connection->post('statuses/update', $parameters);
            echo json_encode($result);
               
        }elseif($action=='retweet'){ //ok

            /* statuses/retweet */
            $method = 'statuses/retweet/'.$str_id;
            $this->connection->post($method);
    
        }elseif($action=='dm_send'){//ok
            
            /* direct_messages/new */
            $parameters = array('user_id' => $friendid, 'text' => $content);
            $method = 'direct_messages/new';
            $this->connection->post($method, $parameters);
            
        }elseif($action=='favorit'){
            
            /* direct_messages/new */
            $parameters = array('id' => $str_id);
            $method = 'favorites/create';
            $this->connection->post($method, $parameters);
            
        }elseif($action=='follow'){
            
            /* friendships/create */
            $method = 'friendships/create';
            $result=$this->connection->post($method,array('follow'=>true,'user_id'=>$followid));
       
        }elseif($action=='unfollow'){
            //echo "<br><br><br><br><br><br>";
            $method = 'friendships/destroy';
//            echo $method." ".$followid;
            $result=$this->connection->post($method,array('user_id'=>$followid));
            //print_r($result);
       
        }elseif($action=='unfriend'){
            
            /* friendships/destroy */
            $method = 'friendships/destroy/'.$followid;
            $this->connection->post($method);
       
        }
        //redirect(base_url('/index.php/dashboard'));    	
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
	$post_id = $this->input->post('post_id');
	$this->load->model('account_model');
	$channel = $this->account_model->GetChannel(array(
	    "channel_id" => $this->input->post("channel_id")
	));
	header('Content-Type: application/x-json');
	if(count($channel) == 1){
	    $access_token_fb = $this->facebook_model->GetPageAccessToken($channel[0]->oauth_token, $channel[0]->social_id);
	    $config = array(
		 'appId' => $this->config->item('fb_appid'),
		 'secret' => $this->config->item('fb_secretkey')
	    );
	    $this->load->library('facebook',$config);
	    $this->facebook->setAccessToken($access_token_fb);
	    if($this->input->post('like') === 'true')
		$return = $this->facebook->api('/'.$post_id.'/likes','POST');
	    else
		$return = $this->facebook->api('/'.$post_id.'/likes','DELETE');
	    $action = array(
		"action_type" => "like_facebook",
		"channel_id" => $channel[0]->channel_id,
		"created_at" => date("Y-m-d H:i:s"),
		"stream_id" => $this->input->post('post_id'),
		"created_by" => $this->session->userdata('user_id'),
		"stream_id_response" => $return
	    );
	    $this->account_model->CreateFbLikeAction($action, $this->input->post('like') === 'true' ? 1 : 0);
	    echo json_encode($return);
	}
	else{
	    echo false;
	}
	
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
            $filter['channel_id']=$channel_ids;
            $data['directmessage']=$this->twitter_model->ReadDMFromDb($filter,$limit);
            $data['countDirect']=$this->twitter_model->CountTwitterData($filter);
        	$data['channel_id'] = $channel_id;
            $this->load->view('dashboard/twitter/twitter_messages.php',$data);

        }
        
    //$data['own_post'] = $this->facebook_model->RetrievePostFB($filter);
        if($action=='wallPosts'){
	    $filter['channel_id']=$channel_ids;
             $data['fb_feed'] = $this->facebook_model->RetrieveFeedFB($filter,$limit);
             $data['count_fb_feed']=$this->facebook_model->CountFeedFB($filter);
             $this->load->view('dashboard/facebook/wall_post.php',$data);
        }
        
        if($action=='privateMessages'){
            $filter['channel_id']=$channel_ids;
            $data['fb_pm'] = $this->facebook_model->RetrievePmFB($filter,$limit);
            $data['CountPmFB']=$this->facebook_model->CountPmFB($filter);
            $this->load->view('dashboard/facebook/private_message.php',$data);
        }
        //print_r($data);
    }
    


    //=========================================END GENERAL function=============================================    
    
      
  
     public function GetUrlPreview(){
	if (!isset($_GET['url'])) die();
	$url = urldecode($_GET['url']);
	$url = 'http://' . str_replace('http://', '', $url); // Avoid accessing the file system
	echo file_get_contents($url);
     }
     
    
}
