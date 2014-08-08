<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {

     private $connection;
     public $user_role;
     private $the_index;
      
     function __construct()
     {
	  parent::__construct();
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

     public function DeleteIndex($name){
	  $this->elasticsearch_model->DeleteIndex('media_stream');
     }
}
