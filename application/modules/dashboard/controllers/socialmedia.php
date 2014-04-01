<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Socialmedia extends MY_Controller {

     private $connection;
     public $user_role; 
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
	  $this->load->model('twitter_model');
	  $this->load->model('action_model');
	  if(!$this->session->userdata('user_id'))
	    redirect("login");
	  $this->user_role = $this->users_model->get_collection_detail(
		array('role_collection_id'=>$this->session->userdata('role_id')));
    }
    
    
     public function index()
     {
	  $this->load->model('facebook_model');
	  $this->load->model('twitter_model');
	  $this->load->model('account_model');
	  $this->load->model('campaign_model');
	  $this->load->model('tag_model');
	  $filter = array();
	  $data['tags'] = $tags=$this->tag_model->get();            
	  $data['campaign'] = $this->campaign_model->get();
	  $data['channels'] = $this->account_model->GetChannel();
	  $data['count_new_cases'] = 63;
	  $data['count_replies'] = 36;
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
        
        if($action=='sendTweet'){ //ok

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
            print_r($result);
            $this->twitter_log($_POST['log_action'],$result->in_reply_to_status_id_str,$result->id_str);
               
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

    public function FbStatusUpdate(){
      header("Content-Type: application/x-json");
	  $this->load->model('account_model');
	  $this->load->model('facebook_model');
      
      
      if($this->input->post('img')){
      $img= $this->input->post('img');
      }else{
        $img='';        
      }
       
	  $filter = array(
	      "connection_type" => "facebook"
	  );
      
	  if($this->input->post('channel_id')){
	      $filter['channel_id'] = $this->input->post('channel_id');
	  }
      
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
      
      if($this->input->post('link')!=''){
          $attachment = array(
                'message' => $this->input->post('content'),
                'name' => $this->input->post('title'),
                'link' => $this->input->post('link'),
                'description' => $this->input->post('desc'),
                'picture'=> $img, //'http://www.maybank.com/iwov-resources/corporate/img/my/en/m/Banners-home-PW.jpg',//$this->input->post('img')
          );  
        $this->facebook->api('/'.$this->facebook->getUser().'/feed', 'POST',$attachment);
      }else{
        $this->facebook->api('/'.$this->facebook->getUser().'/feed','POST',array('message'=>$this->input->post('content')));
	   }
    }
    
    public function twitter_log($log_action,$post_id,$result_post_id){
	  //print_r($log_action);
        $timezone = new DateTimeZone("Asia/Kuala_Lumpur");
        $currentTime = new DateTime(date('Y-m-d H:i:s e'), $timezone);
        
         $filter = array(
            "post_stream_id" => $post_id
        );
        $post_ids= $this->twitter_model->ReadTwitterData($filter,1);       
        print_r($post_ids);
        $db_log=$this->action_model->actionLog($log_action,$post_ids[0]->channel_id,$currentTime->format("Y-m-d H:i:s"),$post_ids[0]->post_stream_id,$result_post_id,$post_ids[0]->post_id,$this->session->userdata['user_id']);
    }
    
    public function ComposeMessage(){
	  $this->load->model('account_model');
	  $this->load->model('campaign_model');
	  $data['channels'] = $this->account_model->GetChannel();
	  $this->load->view('compose_message',$data);
    }
}
