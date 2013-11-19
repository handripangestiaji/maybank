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
     
	  $access_token_fb = fb_dummy_accesstoken();
	  $this->load->model('facebook_model');
	  $filter = array(
	       '' => ''
	   );
	  $data['fb_feed'] = $this->facebook_model->RetrieveFeedFB($filter);
	  $data['own_post'] = $this->facebook_model->RetrievePostFB($filter);
	  
	  $data['mentions']=$this->connection->get('statuses/mentions_timeline');   
   	  $data['homefeed']=$this->connection->get('statuses/home_timeline');
	  $data['senttweets']=$this->connection->get('statuses/user_timeline');  
	  $data['directmessage']=$this->connection->get('direct_messages');
	
	   $this->load->view('dashboard/index',$data);
     }
    
	
	
}