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
     
     public function indexing(){
	  //create index
	  $this->elasticsearch_model->PutIndex($this->the_index);
	  
	  $channels = $this->account_model->GetChannel();
	  foreach($channels as $channel){
	       if($channel->connection_type == 'facebook'){
		    $this->facebook_indexing($channel->channel_id);
	       }
	       
	       elseif($channel->connection_type == 'twitter'){
		    $this->twitter_indexing($channel->channel_id);
	       }
	       elseif($channel->connection_type == 'youtube'){
		    $this->youtube_indexing($channel->channel_id);
	       }
	  }
     }
     
     public function facebook_indexing($channel_id){
	  //create fb feed type
	  $fb_feed_map = array('name' => array('type' => 'string'),
				   'post_id' => array('type' => 'string'),
				   'post_content' => array('type' => 'string'),
				   'post_stream_id' => array('type' => 'string'),
				);
	  $ret = $this->elasticsearch_model->TypeMapping($this->the_index,'facebook_feed',$fb_feed_map);
	  
	  $filter = array(
	       'c.channel_id' => $channel_id,
	    );
	  $fb_feed = $this->facebook_model->RetrieveFeedFB($filter,0,false);
	  
	  $i=0;
	  echo count($fb_feed);
	  foreach($fb_feed as $wp){
	       $new_wp = array('name' => $wp->name,
			       'post_id' => $wp->post_id,
			       'post_content' => $wp->post_content,
			       'post_stream_id' => $wp->post_stream_id
			       );
	       $ret = $this->elasticsearch_model->InsertDoc($this->the_index,'facebook_feed',$wp->post_id,$new_wp);
	  }
	  
	  //indexing for fb private message
	  $fb_pm_map = array('messages' => array('type' => 'string'),
				   'name' => array('type' => 'string'),
				   'post_stream_id' => array('type' => 'string'),
				   'post_id' => array('type' => 'long'),
				);
	  $ret = $this->elasticsearch_model->TypeMapping($this->the_index,'facebook_pm',$fb_pm_map);
	  $filter = array(
	       'c.channel_id' => $channel_id,
	    );
	  $fb_pm = $this->facebook_model->RetrievePmFB($filter);
	  foreach($fb_pm as $pm){
	       $sender = $pm->participant->sender->facebook_id == $pm->social_id ? $pm->participant->to : $pm->participant->sender;
	       $new_pm = array('messages' => $pm->snippet,
			       'name' => $sender->name,
			       'post_stream_id' => $pm->post_stream_id,
			       'post_id' => $pm->post_id);
	       $ret = $this->elasticsearch_model->InsertDoc($this->the_index,'facebook_pm',$pm->post_id,$new_pm);
	  }
     }
     
     public function twitter_indexing($channel_id){
	  //create twitter mention type
	  $tw_mention_map = array('post_stream_id' => array('type' => 'string'),
				   'text' => array('type' => 'string'),
				   'screen_name' => array('type' => 'string'),
				   'post_id' => array('type' => 'string'),
				   'name' => array('type' => 'string')
				);
	  
	  $ret = $this->elasticsearch_model->TypeMapping($this->the_index,'twitter_mentions',$tw_mention_map);
	  $filter = array('a.channel_id' => $channel_id);
	  $filter['b.type'] = 'mentions';
	  $mentions = $this->twitter_model->ReadTwitterData($filter);
	  foreach($mentions as $m){
	       $tws = array('text' => $m->text,
				'post_stream_id' => $m->post_stream_id,
				'screen_name' => $m->screen_name,
				'post_id' => $m->post_id,
				'name' => $m->name
				);
	       $ret = $this->elasticsearch_model->InsertDoc($this->the_index,'twitter_mentions',$m->post_stream_id,$tws);
	  }

	  //create twitter homefeed type
	  $ret = $this->elasticsearch_model->TypeMapping($this->the_index,'twitter_homefeed',$tw_mention_map);
	  $filter['b.type'] = 'home_feed';
	  $homefeeds = $this->twitter_model->ReadTwitterData($filter);
	  foreach($homefeeds as $hf){
	       $tws = array('text' => $hf->text,
				'post_stream_id' => $hf->post_stream_id,
				'screen_name' => $hf->screen_name,
				'post_id' => $hf->post_id,
				'name' => $hf->name
				); 
	       $ret = $this->elasticsearch_model->InsertDoc($this->the_index,'twitter_homefeed',$hf->post_stream_id,$tws);
	  }
	  
	  //create twitter senttweets type
	  $ret = $this->elasticsearch_model->TypeMapping($this->the_index,'twitter_senttweets',$tw_mention_map);
	  $filter['b.type'] = 'user_timeline';
	  $timelines = $this->twitter_model->ReadTwitterData($filter);
	  foreach($timelines as $tl){
	       $tws = array('text' => $tl->text,
				'post_stream_id' => $tl->post_stream_id,
				'screen_name' => $tl->screen_name,
				'post_id' => $tl->post_id,
				'name' => $tl->name
				); 
	       $ret = $this->elasticsearch_model->InsertDoc($this->the_index,'twitter_senttweets',$tl->post_stream_id,$tws);
	  }
	   
	  //create twitter direct_messages type
	  $ret = $this->elasticsearch_model->TypeMapping($this->the_index,'twitter_dms',$tw_mention_map);
	  unset($filter['b.type']);
	  $dms = $this->twitter_model->ReadDMFromDb($filter);
	  foreach($dms as $dm){
	       $tws = array('text' => $dm->dm_text,
				'post_stream_id' => $dm->post_stream_id,
				'screen_name' => $dm->screen_name,
				'post_id' => $dm->post_id,
				'name' => $dm->name
				); 
	       $ret = $this->elasticsearch_model->InsertDoc($this->the_index,'twitter_dms',$dm->post_stream_id,$tws);
	  }
     }
     
      public function youtube_indexing($channel_id){
	  //create youtube post type
	  $yt_post_map = array('post_id' => array('type' => 'string'),
				   'post_stream_id' => array('type' => 'string'),
				   'title' => array('type' => 'string'),
				   'description' => array('type' => 'string'),
				   'channel_name' => array('type' => 'string'),
				);
	  $ret = $this->elasticsearch_model->TypeMapping($this->the_index,'youtube_post',$yt_post_map);
	  
	  $filter = array(
	   'c.channel_id' => $channel_id,
	  );
	  $posts = $this->youtube_model->ReadYoutubePost($filter);
	  foreach($posts as $post){
	       $yts = array('post_id' => $post->post_id,
			    'post_stream_id' => $post->post_stream_id,
			    'title' => $post->title,
			    'description' => $post->description,
			    'channel_name' => $post->channel_name
			    );
	       $ret = $this->elasticsearch_model->InsertDoc($this->the_index,'youtube_post',$post->post_stream_id,$yts);
	  }
	  
	  $yt_comment_map = array('post_id' => array('type' => 'string'),
				   'post_stream_id' => array('type' => 'string'),
				   'name' => array('type' => 'string'),
				   'title' => array('type' => 'string'),
				   'text' => array('type' => 'string'),
			       );
	  $ret = $this->elasticsearch_model->TypeMapping($this->the_index,'youtube_comment',$yt_comment_map);
	  
	  $filter = array(
	   'channel_id' => $channel_id,
	  );
	  $comments = $this->youtube_model->ReadYoutubeComment($filter);
	  foreach($comments as $comment){
	       $yts = array('post_id' => $comment->post_id,
			    'post_stream_id' => $comment->post_stream_id,
			    'name' => $comment->name,
			    'title' => $comment->title,
			    'text' => $comment->text
			    );
	       $ret = $this->elasticsearch_model->InsertDoc($this->the_index,'youtube_comment',$comment->post_stream_id,$yts);
	  }
      }
      
     public function youtube_stream($channel_id, $is_read = null){
	$filter = array(
	   'channel_id' => $channel_id,
	);
	if($is_read)
	    $filter['is_read'] = $is_read;
	$page = $this->input->get('page');
	$page = $page ? $page : 1;
	$data['youtube_post'] = $this->youtube_model->ReadYoutubePost($filter, $page);
	$data['youtube_comment'] = $this->youtube_model->ReadYoutubeComment($filter, $page);
	$this->load->view('dashboard2/youtube/youtube_stream', $data);
    }
    
    
     public function sandbox(){
	  //$ret = $this->elasticsearch_model->GlobalSearch('media_stream','twitter_senttweets','tes');
	  //$ret = $this->elasticsearch_model->GetMapping('media_stream');
	  //$ret = $this->elasticsearch_model->GetDoc('media_stream','facebook_feed','1');
	  $ret = $this->elasticsearch_model->DeleteIndex($this->the_index);
	  //$ret = $this->elasticsearch_model->DeleteType('media_stream','twitter_dm');
	  print_r($ret);
	  die();
     }
     
     public function DeleteIndex($name){
	  $this->elasticsearch_model->DeleteIndex('media_stream');
     }
}
