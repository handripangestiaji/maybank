<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Socialmedia extends MY_Controller {

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
    
    
     public function index()
     {
	  
	  $this->load->model('facebook_model');
	  $this->load->model('twitter_model');
	  $this->load->model('account_model');
	  $filter = array();
	  $data['channels'] = $this->account_model->GetChannel();
	  $this->load->view('dashboard/index',$data);
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
        
        if(isset($_POST['followid'])){
            $followid=$_POST['followid'];
        }
        
        if(isset($_POST['id'])){//id user
            $id=$_POST['id'];
        }
        
        
        
        if($action=='sendTweet'){ //ok

            /* statuses/update */
            $parameters = array('status' => $content);
            $this->connection->post('statuses/update', $parameters);
    
        }elseif($action=='destroy_status'){
    
            /* statuses/destroy */
            $method = "statuses/destroy".$str_id;
            $this->connection->delete($method);    
    
        }elseif($action=='replay'){//replay tweet,Direct message
          //  echo $action."<br>";
          //  echo $content."<br>";
            
            /* statuses/update */
            $parameters = array('status' => $content);
            $this->connection->post('statuses/update', $parameters);
               
        }elseif($action=='retweet'){ //ok

            /* statuses/retweet */
            $method = 'statuses/retweet/'.$str_id;
            $this->connection->post($method);
    
        }elseif($action=='sent_dm'){//ok
            
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

    public function FbStatusUpdate(){
	  $access_token_fb = fb_dummy_accesstoken();
	  $config = array(
	       'appId' => $this->config->item('fb_appid'),
	       'secret' => $this->config->item('fb_secretkey')
	  );
	  $this->load->library('facebook',$config);
	  $this->facebook->setaccesstoken($access_token_fb);
	  $this->facebook->api('/me/feed','POST',array('message'=>$this->input->post('content')));
	  /*
	  $result = curl_get_file_contents('https://graph.facebook.com/me?
					  method=GET&
					  format=json&
					  suppress_http_code=1&
					  access_token='.$access_token_fb);
	  echo $result;
	  */
    }
}    
    public function likePost(){
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
    
    
    public function replyPost(){
        $this->load->model('account_model');
        $this->load->model('facebook_model');
        $comment=$_POST['comment'];
        $post_id=$_POST['post_id'];
     
       $filter = array(
            "connection_type" => "facebook"
        );
        if($this->input->get('channel_id')){
            $filter['channel_id'] = $this->input->get('channel_id');
        }
        $channel_loaded = $this->account_model->GetChannel($filter);
        echo "<br><br><br><br><br><br>";
        //print_r($channel_loaded);
       
        $newStd = new stdClass();
        $newStd->page_id =  $channel_loaded[0]->social_id;
        $newStd->token = $this->facebook_model->GetPageAccessToken( $channel_loaded[0]->oauth_token, $channel_loaded[0]->social_id);
        $config = array(
	       'appId' => $this->config->item('fb_appid'),
	       'secret' => $this->config->item('fb_secretkey')
	    );
	    $this->load->library('facebook',$config);
	    $this->facebook->setaccesstoken($newStd->token);
	    $this->facebook->api('/'.$post_id.'/comments','post',array('message' => $comment,));
    }
    
    
}
