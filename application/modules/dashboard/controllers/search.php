<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {

     private $connection;
     public $user_role;
    
     function __construct()
     {
	  parent::__construct();
	  if(!$this->session->userdata('user_id'))
	    redirect("login");
	
	  $this->load->model('elasticsearch_model');
	  $this->load->library('ion_auth');
	  $this->load->library('Twitteroauth');
	  $this->load->library('session');
	  $this->load->helper('url');
	  $this->load->helper('array');  
	  $this->load->helper('form');
	  $this->load->model('facebook_model');
	  $this->load->model('twitter_model');
	  $this->load->model('youtube_model');
	  $this->load->model('account_model');
	  $this->user_role = $this->users_model->get_collection_detail(
		array('role_collection_id'=>$this->session->userdata('role_id')));
     }
    
    
     public function index()
     {
	  $q = $this->input->post('q');
	  $channel_id = $this->input->post('channel_id');
	  $the_channel = $this->account_model->GetChannel(array('channel_id' => $channel_id));
	  if($the_channel[0]->connection_type == 'facebook'){
	       $fb_feed = (object)$this->elasticsearch_model->GlobalSearch('media_stream','facebook_feed',$q);
	       if($fb_feed->hits['hits']){
		    foreach($fb_feed->hits['hits'] as $wp){
			 $new_fb_feed[] = (object)$wp['_source'];
		    }
	       }
	       else{
		    $new_fb_feed = null;
	       }
	       $data['fb_feed'] = $new_fb_feed;
	       
	       $fb_pm = (object)$this->elasticsearch_model->GlobalSearch('media_stream','facebook_pm',$q);
	       if($fb_pm->hits['hits']){
		    foreach($fb_pm->hits['hits'] as $pm){
			 $new_fb_pm[] = (object)$pm['_source'];
		    }
	       }
	       else{
		    $new_fb_pm = null;
	       }
	       $data['fb_pm'] = $new_fb_pm;
	       
		$filter = array(
		    'channel_id' => $channel_id,
		 );
	       $data['count_fb_feed']=$this->facebook_model->CountFeedFB($filter);
	       $data['CountPmFB']=$this->facebook_model->CountPmFB($filter);
	       $data['channel_id'] = $channel_id;
	       $this->load->model('campaign_model');
	       $data['product_list'] = $this->campaign_model->GetProduct();
	       $this->load->model('case_model');
	       $data['user_list'] = $this->case_model->ReadAllUser();
	       $data['is_search'] = TRUE;
	       $this->load->view('dashboard/facebook/facebook_stream',$data);
	  }
	  elseif($the_channel[0]->connection_type == 'twitter'){
	       $filter = array('a.channel_id' => $channel_id,);
	 
	       $tw_mentions = (object)$this->elasticsearch_model->GlobalSearch('media_stream','twitter_mentions',$q);
	       if($tw_mentions->hits['hits']){
		    foreach($tw_mentions->hits['hits'] as $tw){
			 $new_tw_mentions[] = (object)$tw['_source'];
		    }
	       }
	       else{
		    $new_tw_mentions = null;
	       }
	       $data['mentions'] = $new_tw_mentions;
	       $filter['b.type'] = 'mentions';
	       $data['countMentions']=$this->twitter_model->CountTwitterData($filter);
	       
	       $tw_homefeed = (object)$this->elasticsearch_model->GlobalSearch('media_stream','twitter_homefeed',$q);
	       if($tw_homefeed->hits['hits']){
		    foreach($tw_homefeed->hits['hits'] as $tw){
			 $new_tw_homefeed[] = (object)$tw['_source'];
		    }
	       }
	       else{
		    $new_tw_homefeed = null;
	       }
	       $data['homefeed'] = $new_tw_homefeed;
	       $filter['b.type'] = 'home_feed';     
	       $data['countFeed']=$this->twitter_model->CountTwitterData($filter);
	       
     	       $tw_senttweets = (object)$this->elasticsearch_model->GlobalSearch('media_stream','twitter_senttweets',$q);
	       if($tw_senttweets->hits['hits']){
		    foreach($tw_senttweets->hits['hits'] as $tw){
			 $new_tw_senttweets[] = (object)$tw['_source'];
		    }
	       }
	       else{
		    $new_tw_senttweets = null;
	       }
	       $data['senttweets'] = $new_tw_senttweets;
	       $filter['b.type'] = 'user_timeline';     
	       $data['countTweets']=$this->twitter_model->CountTwitterData($filter);
	       
	       $tw_dms = (object)$this->elasticsearch_model->GlobalSearch('media_stream','twitter_dms',$q);
	       if($tw_dms->hits['hits']){
		    $i = 0;
		    foreach($tw_dms->hits['hits'] as $tw){
			 $new_tw_dms[$i] = (object)$tw['_source'];
			 $new_tw_dms[$i]->sender = (object)$tw['_source']['sender'];
			 $i++;
		    }
	       }
	       else{
		    $new_tw_dms = null;
	       }
	       unset($filter['b.type']);
	       $data['directmessage']=$new_tw_dms;
	       $data['countDirect']=$this->twitter_model->CountTwitterData($filter);
	
	       $data['channel_id'] = $channel_id;
	       $this->load->model('campaign_model');
	       $data['product_list'] = $this->campaign_model->GetProduct();
	       $data['channel_id'] = $channel_id;
	       $data['user_list'] = $this->case_model->ReadAllUser();
	       $data['is_search'] = TRUE;
	       $this->load->view('dashboard/twitter/twitter_stream',$data);
	  }
     }
     
     public function indexing(){
	  //delete first
	  $this->elasticsearch_model->DeleteIndex('media_stream');
	  
	  //create index
	  $this->elasticsearch_model->PutIndex('media_stream');
	  
	  $channels = $this->account_model->GetChannel();
	  foreach($channels as $channel){
	       if($channel->connection_type == 'facebook'){
		    $this->facebook_indexing($channel->channel_id);
	       }
	       elseif($channel->connection_type == 'twitter'){
		    $this->twitter_indexing($channel->channel_id);
	       }
	  }
     }
     
     public function facebook_indexing($channel_id){
	  //create fb feed type
	  $fb_feed_map = array('facebook_id' => array('type' => 'long'),
				   'name' => array('type' => 'string'),
				   'username' => array('type' => 'string'),
				   'created_at' => array('type' => 'string'),
				   'retrieved_at' => array('type' => 'string'),
				   'sex' => array('type' => 'string'),
				   'post_id' => array('type' => 'long'),
				   'post_content' => array('type' => 'string'),
				   'author_id' => array('type' => 'long'),
				   'attachment' => array('type' => 'string'),
				   'enggagement_count' => array('type' => 'long'),
				   'total_like' => array('type' => 'long'),
				   'user_likes' => array('type' => 'long'),
				   'total_comments' => array('type' => 'long'),
				   'total_shares' => array('type' => 'long'),
				   'updated_at' => array('type' => 'string'),
				   'is_customer_post' => array('type' => 'long'),
				   'post_status' => array('type' => 'long'),
				   'post_stream_id' => array('type' => 'string'),
				   'channel_id' => array('type' => 'long'),
				   'type' => array('type' => 'string'),
				   'is_read' => array('type' => 'long'),
				   'case_id' => array('type' => 'long'),
				   'content_products_id' => array('type' => 'long'),
				   'created_by' => array('type' => 'string'),
				   'assign_to' => array('type' => 'string'),
				   'email' => array('type' => 'string'),
				   'messages' => array('type' => 'string'),
				   'status' => array('type' => 'string'),
				   'related_conversation_count' => array('type' => 'string'),
				   'case_type' => array('type' => 'string'),
				   'solved_by' => array('type' => 'long'),
				   'solved_at' => array('type' => 'string'),
				   'social_stream_type' => array('type' => 'string'),
				   'social_stream_post_id' => array('type' => 'long'),
				   'post_date' => array('type' => 'string'),
				   'reply_post' => array('type' => 'string'),
				   'channel_action' => array('type' => 'string')
			       );
	  $ret = $this->elasticsearch_model->TypeMapping('media_stream','facebook_feed',$fb_feed_map);
	  
	  $filter = array(
	       'channel_id' => $channel_id,
	    );
	  $fb_feed = $this->facebook_model->RetrieveFeedFB($filter);
	  foreach($fb_feed as $wp){
	       $fbs = (array)$wp;
	       //echo $wp->retrieved_at;
	       // Document will be indexed to my_index/my_type/my_id
	       $ret = $this->elasticsearch_model->InsertDoc('media_stream','facebook_feed',$fbs);
	  }
	  
	  //indexing for fb private message
	  $fb_pm_map = array('conversation_id' => array('type' => 'long'),
				   'snippet' => array('type' => 'string'),
				   'updated_time' => array('type' => 'string'),
				   'message_count' => array('type' => 'long'),
				   'unread_count' => array('type' => 'long'),
				   'status' => array('type' => 'long'),
				   'detail_id' => array('type' => 'long'),
				   'detail_id_from_facebook' => array('type' => 'string'),
				   'attachment' => array('type' => 'string'),
				   'messages' => array('type' => 'string'),
				   'sender' => array('type' => 'string'),
				   'to' => array('type' => 'string'),
				   'created_at' => array('type' => 'string'),
				   'name' => array('type' => 'string'),
				   'username' => array('type' => 'string'),
				   'is_read' => array('type' => 'long'),
				   'post_stream_id' => array('type' => 'string'),
				   'type' => array('type' => 'string'),
				   'social_stream_type' => array('type' => 'string'),
				   'channel_id' => array('type' => 'long'),
				   'post_id' => array('type' => 'long'),
				   'post_date' => array('type' => 'string'),
				   'case_id' => array('type' => 'long'),
				);
	  $ret = $this->elasticsearch_model->TypeMapping('media_stream','facebook_pm',$fb_pm_map);
	  $filter = array(
	       'channel_id' => $channel_id,
	    );
	  $fb_pm = $this->facebook_model->RetrievePmFB($filter,1000);
	  foreach($fb_pm as $pm){
	       $fbs = (array)$pm;
	       //echo $wp->retrieved_at;
	       // Document will be indexed to my_index/my_type/my_id
	       $ret = $this->elasticsearch_model->InsertDoc('media_stream','facebook_pm',$fbs);
	  }
     }
     
     public function twitter_indexing($channel_id){
	  //create twitter mention type
	  $tw_mention_map = array('social_id' => array('type' => 'string'),
				   'channel_id' => array('type' => 'long'),
				   'post_stream_id' => array('type' => 'string'),
				   'retrieved_at' => array('type' => 'string'),
				   'social_stream_created_at' => array('type' => 'string'),
				   'social_stream_type' => array('type' => 'string'),
				   'post_id' => array('type' => 'long'),
				   'type' => array('type' => 'string'),
				   'retweeted' => array('type' => 'long'),
				   'favorited' => array('type' => 'long'),
				   'in_reply_to' => array('type' => 'string'),
				   'twitter_entities' => array('type' => 'string'),
				   'text' => array('type' => 'string'),
				   'retweet_count' => array('type' => 'long'),
				   'geolocation' => array('type' => 'string'),
				   'is_following' => array('type' => 'long'),
				   'source' => array('type' => 'string'),
				   'twitter_user_id' => array('type' => 'string'),
				   'created_at' => array('type' => 'string'),
				   'screen_name' => array('type' => 'string'),
				   'profile_image_url' => array('type' => 'string'),
				   'name' => array('type' => 'string'),
				   'description' => array('type' => 'string'),
				   'following' => array('type' => 'long'),
				   'is_read' => array('type' => 'long'),
				   'case_id' => array('type' => 'long'),
				   'content_products_id' => array('type' => 'long'),
				   'created_by' => array('type' => 'string'),
				   'assign_to' => array('type' => 'string'),
				   'email' => array('type' => 'string'),
				   'messages' => array('type' => 'string'),
				   'status' => array('type' => 'string'),
				   'related_conversation_count' => array('type' => 'long'),
				   'case_type' => array('type' => 'string'),
				   'solved_by' => array('type' => 'string'),
				   'solved_at' => array('type' => 'string'),
				   'social_stream_post_id' => array('type' => 'long'),
				   'reply_post' => array('type' => 'string'),
				   'channel_action' => array('type' => 'string')
			       );
	  
	  $ret = $this->elasticsearch_model->TypeMapping('media_stream','twitter_mentions',$tw_mention_map);
	  $filter = array('a.channel_id' => $channel_id);
	  $filter['b.type'] = 'mentions';
	  $mentions = $this->twitter_model->ReadTwitterData($filter,1000);
	  foreach($mentions as $m){
	       $tws = (array)$m;
	       //echo $wp->retrieved_at;
	       // Document will be indexed to my_index/my_type/my_id
	       $ret = $this->elasticsearch_model->InsertDoc('media_stream','twitter_mentions',$tws);
	  }

	  //create twitter homefeed type
	  $ret = $this->elasticsearch_model->TypeMapping('media_stream','twitter_homefeed',$tw_mention_map);
	  $filter['b.type'] = 'home_feed';
	  $homefeeds = $this->twitter_model->ReadTwitterData($filter,1000);
	  foreach($homefeeds as $hf){
	       $tws = (array)$hf;
	       //echo $wp->retrieved_at;
	       // Document will be indexed to my_index/my_type/my_id
	       $ret = $this->elasticsearch_model->InsertDoc('media_stream','twitter_homefeed',$tws);
	  }
	  
	  //create twitter senttweets type
	  $ret = $this->elasticsearch_model->TypeMapping('media_stream','twitter_senttweets',$tw_mention_map);
	  $filter['b.type'] = 'user_timeline';
	  $timeines = $this->twitter_model->ReadTwitterData($filter,1000);
	  foreach($timeines as $tl){
	       $tws = (array)$tl;
	       //echo $wp->retrieved_at;
	       // Document will be indexed to my_index/my_type/my_id
	       $ret = $this->elasticsearch_model->InsertDoc('media_stream','twitter_senttweets',$tws);
	  }
	  
	  $tw_dm_map = array('social_stream_post_id' => array('type' => 'string'),
			      'channel_id' => array('type' => 'long'),
			      'is_read' => array('type' => 'long'),
			      'post_stream_id' => array('type' => 'string'),
			      'retrieved_at' => array('type' => 'string'),
			      'social_stream_created_at' => array('type' => 'string'),
			      'dm_text' => array('type' => 'string'),
			      'post_id' => array('type' => 'long'),
			      'entities' => array('type' => 'string'),
			      'text' => array('type' => 'string'),
			      'sender' => array('type' => 'string'),
			      'recipient' => array('type' => 'string'),
			      'type' => array('type' => 'string'),
			      'twitter_user_id' => array('type' => 'string'),
			      'profile_image_url' => array('type' => 'string'),
			      'name' => array('type' => 'string'),
			      'description' => array('type' => 'string'),
			      'url' => array('type' => 'string'),
			      'location' => array('type' => 'string'),
			      'statuses_count' => array('type' => 'long'),
			      'friends_count' => array('type' => 'long'),
			      'followers_count' => array('type' => 'long'),
			      'verified_account' => array('type' => 'long'),
			      'timezone' => array('type' => 'string'),
			      'following' => array('type' => 'long'),
			      'created_at' => array('type' => 'date'),
			      'case_id' => array('type' => 'long'),
			      'content_products_id' => array('type' => 'long'),
			      'created_by' => array('type' => 'string'),
			      'assign_to' => array('type' => 'string'),
			      'email' => array('type' => 'string'),
			      'messages' => array('type' => 'string'),
			      'status' => array('type' => 'string'),
			      'related_conversation_count' => array('type' => 'long'),
			      'case_type' => array('type' => 'string'),
			      'solved_by' => array('type' => 'string'),
			      'solved_at' => array('type' => 'string'),
			      'id' => array('type' => 'long'),
			      'reply_to_post_id' => array('type' => 'string'),
			      'image_to_post' => array('type' => 'string'),
			      'reply_type' => array('type' => 'string'),
			      'response_post_id' => array('type' => 'long'),
			      'user_id' => array('type' => 'long'),
			      'social_stream_type' => array('type' => 'string'),
			      'channel_action' => array('type' => 'string')
			  );
	  
	  //create twitter direct_messages type
	  $ret = $this->elasticsearch_model->PutMapping('media_stream','twitter_dms',$tw_dm_map);
	  //$ret = $this->elasticsearch_model->TypeMapping('media_stream','twitter_dm',$tw_dm_map);
	  unset($filter['b.type']);
	  $dms = $this->twitter_model->ReadDMFromDb($filter,1000);
	  foreach($dms as $dm){
	       $tws = (array)$dm;
	       //echo $wp->retrieved_at;
	       // Document will be indexed to my_index/my_type/my_id
	       $ret = $this->elasticsearch_model->InsertDoc('media_stream','twitter_dms',$tws);
	  }
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
	    else{
		$filter['case_id is NOT NULL'] = null;
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
    
     public function sandbox(){
	  //$ret = $this->elasticsearch_model->GlobalSearch('media_stream','twitter_senttweets','tes');
	  //$ret = $this->elasticsearch_model->GetMapping('media_stream');
	  //$ret = $this->elasticsearch_model->GetDoc('media_stream','facebook_feed','1');
	  $ret = $this->elasticsearch_model->DeleteIndex('media_stream');
	  //$ret = $this->elasticsearch_model->DeleteType('media_stream','twitter_dm');
	  print_r($ret);
	  die();
     }
}
