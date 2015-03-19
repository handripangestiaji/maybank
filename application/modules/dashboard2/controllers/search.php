<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {

     private $connection;
     public $user_role;
     private $the_index;
      
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
	  $this->load->config('search');
	  $this->the_index = $this->config->item('index_search');
	  $this->date_after = date("Y-m-d H:i:s",strtotime("-1 hours"));
	  
	  $this->user_role = $this->users_model->get_collection_detail(
		array('role_collection_id'=>$this->session->userdata('role_id')));
     }
     
     public function index()
     {
	  //$this->indexing();
	  $this->load->model('campaign_model');
	  $q = $this->input->post('q');
	  $channel_id = $this->input->post('channel_id');
	  $the_channel = $this->account_model->GetChannel(array('channel_id' => $channel_id));
	  $product_list = $this->campaign_model->GetProduct(array('parent_id' => null));
	  foreach($product_list as $prod){    
	       $product_child = $this->campaign_model->GetProduct(array('parent_id' => $prod->id));
	       
	       if($product_child){
		   $chi = array();
		   foreach($product_child as $child){
		       $chi[] = $child;
		   }
		   $prod->child = $chi;
	       }
	   }
	  if($the_channel[0]->connection_type == 'facebook'){
	       $fb_feed = (object)$this->elasticsearch_model->GlobalSearch($this->the_index,'facebook_feed',$q);
	       if($fb_feed->hits['hits']){
		    foreach($fb_feed->hits['hits'] as $wp){
			 $new_fb_feed[] = (object)$wp['_source'];
		    }
	       }
	       else{
		    $new_fb_feed = null;
	       }
	       
	       if($new_fb_feed){
		    $data_fb_feed = array();
		    foreach($new_fb_feed as $nff){
			 $filter_fb = array('b.post_id' => $nff->post_id,
					    'channel_id' => $channel_id);
			 $result = $this->facebook_model->RetrieveFeedFB($filter_fb);
			 $data_fb_feed = array_merge($data_fb_feed,$result);
		    }
		}
		else{
		    $data_fb_feed = $new_fb_feed;
		}
		$data['fb_feed'] = $data_fb_feed;
		
	       $fb_pm = (object)$this->elasticsearch_model->GlobalSearch($this->the_index,'facebook_pm',$q);
	       if($fb_pm->hits['hits']){
		    foreach($fb_pm->hits['hits'] as $pm){
			 $new_fb_pm[] = (object)$pm['_source'];
		    }
	       }
	       else{
		    $new_fb_pm = null;
	       }
	       
	       if($new_fb_pm){
		    $data_fb_pm = array();
		    foreach($new_fb_pm as $nfp){
			 $filter_fb = array('c.post_id' => $nfp->post_id,
					    'c.channel_id' => $channel_id);
			 $result = $this->facebook_model->RetrievePmFB($filter_fb);
			 $data_fb_pm = array_merge($data_fb_pm,$result);
		    }
	       }
	       else{
		   $data_fb_pm = $new_fb_pm;
	       }
	       $data['fb_pm'] = $data_fb_pm;
	       
		$filter = array(
		    'c.channel_id' => $channel_id,
		 );
		
	       $data['count_fb_feed']=$this->facebook_model->CountFeedFB($filter);
	       $data['CountPmFB']=$this->facebook_model->CountPmFB($filter);
	       $data['channel_id'] = $channel_id;
	       
	       
	       $data['product_list'] = $product_list;
	       $this->load->model('case_model');
	       $data['user_list'] = $this->case_model->ReadAllUser();
	       $data['is_search'] = TRUE;
	       $this->load->view('dashboard2/facebook/facebook_stream',$data);
	  }
	  elseif($the_channel[0]->connection_type == 'twitter'){
	       $filter = array('a.channel_id' => $channel_id);
	 
	       $tw_mentions = (object)$this->elasticsearch_model->GlobalSearch($this->the_index,'twitter_mentions',$q);
	       if($tw_mentions->hits['hits']){
		    foreach($tw_mentions->hits['hits'] as $tw){
			 $new_tw_mentions[] = (object)$tw['_source'];
		    }
	       }
	       else{
		    $new_tw_mentions = null;
	       }
	       if($new_tw_mentions){
		    $data_tw_mentions = array();
		    foreach($new_tw_mentions as $ntm){
			 $filter_tw = array('a.post_stream_id' => $ntm->post_stream_id,
					    'b.type' => 'mentions',
					    'a.channel_id' => $channel_id
					    );
			 $result = $this->twitter_model->ReadTwitterData($filter_tw);
			 $data_tw_mentions = array_merge($data_tw_mentions,$result);
		    }
		}
		else{
		    $data_tw_mentions = $new_tw_mentions;
		}
	       $data['mentions'] = $data_tw_mentions;
	       $filter['b.type'] = 'mentions';
	       $data['countMentions']=$this->twitter_model->CountTwitterData($filter);
	       
	       $tw_homefeed = (object)$this->elasticsearch_model->GlobalSearch($this->the_index,'twitter_homefeed',$q);
	       if($tw_homefeed->hits['hits']){
		    foreach($tw_homefeed->hits['hits'] as $tw){
			 $new_tw_homefeed[] = (object)$tw['_source'];
		    }
	       }
	       else{
		    $new_tw_homefeed = null;
	       }
	       if($new_tw_homefeed){
		    $data_tw_homefeed = array();
		    foreach($new_tw_homefeed as $nth){
			 $filter_tw = array('a.post_stream_id' => $nth->post_stream_id,
					    'b.type' => 'home_feed',
					    'a.channel_id' => $channel_id
					    );
			 $result = $this->twitter_model->ReadTwitterData($filter_tw);
			 $data_tw_homefeed = array_merge($data_tw_homefeed,$result);
		    }
		}
		else{
		    $data_tw_homefeed = $new_tw_homefeed;
		}
	       $data['homefeed'] = $data_tw_homefeed;
	       $filter['b.type'] = 'home_feed';     
	       $data['countFeed']=$this->twitter_model->CountTwitterData($filter);
	       
     	       $tw_senttweets = (object)$this->elasticsearch_model->GlobalSearch($this->the_index,'twitter_senttweets',$q);
	       if($tw_senttweets->hits['hits']){
		    foreach($tw_senttweets->hits['hits'] as $tw){
			 $new_tw_senttweets[] = (object)$tw['_source'];
		    }
	       }
	       else{
		    $new_tw_senttweets = null;
	       }
	       if($new_tw_senttweets){
		    $data_tw_senttweets = array();
		    foreach($new_tw_senttweets as $nts){
			 $filter_tw = array('a.post_stream_id' => $nts->post_stream_id,
					    'b.type' => 'user_timeline',
					    'a.channel_id' => $channel_id
					    );
			 $result = $this->twitter_model->ReadTwitterData($filter_tw);
			 $data_tw_senttweets = array_merge($data_tw_senttweets,$result);
		    }
		}
		else{
		    $data_tw_senttweets = $new_tw_senttweets;
		}
	       $data['senttweets'] = $data_tw_senttweets;
	       $filter['b.type'] = 'user_timeline';     
	       $data['countTweets']=$this->twitter_model->CountTwitterData($filter);
	       
	       $tw_dms = (object)$this->elasticsearch_model->GlobalSearch($this->the_index,'twitter_dms',$q);
	       if($tw_dms->hits['hits']){
		    $i = 0;
		    foreach($tw_dms->hits['hits'] as $tw){
			 $new_tw_dms[$i] = (object)$tw['_source'];
			 $i++;
		    }
	       }
	       else{
		    $new_tw_dms = null;
	       }
	       if($new_tw_dms){
		    $data_tw_dms = array();
		    foreach($new_tw_dms as $ntd){
			 $filter_tw = array('a.post_stream_id' => $ntd->post_stream_id,
					    'a.channel_id' => $channel_id
					    );
			 $result = $this->twitter_model->ReadDMFromDb($filter_tw);
			 $data_tw_dms = array_merge($data_tw_dms,$result);
		    }
		}
		else{
		    $data_tw_dms = $new_tw_dms;
		}
	       unset($filter['b.type']);
	       $data['directmessage']=$data_tw_dms;
	       $data['countDirect']=$this->twitter_model->CountTwitterData($filter);
	
	       $data['channel_id'] = $channel_id;
	       $this->load->model('campaign_model');
	       $data['product_list'] = $product_list;
	       $data['channel_id'] = $channel_id;
	       $data['user_list'] = $this->case_model->ReadAllUser();
	       $data['is_search'] = TRUE;
	       $this->load->view('dashboard2/twitter/twitter_stream',$data);
	  }
	  elseif($the_channel[0]->connection_type == 'youtube'){
	       $youtube_post = (object)$this->elasticsearch_model->GlobalSearch($this->the_index,'youtube_post',$q);
	       if($youtube_post->hits['hits']){
		    foreach($youtube_post->hits['hits'] as $yts){
			 $new_youtube_post[] = (object)$yts['_source'];
		    }
	       }
	       else{
		    $new_youtube_post = null;
	       }
	       if($new_youtube_post){
	       $data_youtube_post = array();
		    foreach($new_youtube_post as $nyp){
			 $filter_yt = array('a.post_stream_id' => $nyp->post_stream_id,
					    'a.channel_id' => $channel_id);
			 $result = $this->youtube_model->ReadYoutubePost($filter_yt);
			 $data_youtube_post = array_merge($data_youtube_post,$result);
		    }
		}
		else{
		    $data_youtube_post = $new_youtube_post;
		}
	       $data['youtube_post'] = $data_youtube_post;
	       
	       $youtube_comment = (object)$this->elasticsearch_model->GlobalSearch($this->the_index,'youtube_comment',$q);
	       if($youtube_comment->hits['hits']){
		    foreach($youtube_comment->hits['hits'] as $yts){
			 $new_youtube_comment[] = (object)$yts['_source'];
		    }
	       }
	       else{
		    $new_youtube_comment = null;
	       }
	       if($new_youtube_comment){
	       $data_youtube_comment = array();
		    foreach($new_youtube_comment as $nyc){
			 $filter_yt = array('a.post_stream_id' => $nyc->post_stream_id,
					    'a.channel_id' => $channel_id);
			 $result = $this->youtube_model->ReadYoutubeComment($filter_yt);
			 $data_youtube_comment = array_merge($data_youtube_comment,$result);
		    }
		}
		else{
		    $data_youtube_comment = $new_youtube_comment;
		}
	       $data['youtube_comment'] = $data_youtube_comment;
	       
	       $data['channel_id'] = $channel_id;
	       $data['is_search'] = TRUE;
	       $this->load->view('dashboard2/youtube/youtube_stream', $data);
	  }
     }
}
