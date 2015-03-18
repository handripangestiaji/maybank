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
	  $this->date_after = date("Y-m-d H:i:s",strtotime("-1 hours"));
	  $this->date_before = date("Y-m-d H:i:s");
	  
	  $this->user_role = $this->users_model->get_collection_detail(
		array('role_collection_id'=>$this->session->userdata('role_id')));
     }
     
     
     public function indexing(){
	  //create index
	  $this->elasticsearch_model->PutIndex($this->the_index);
	  
	  if($this->input->get('after') != null){
	       $this->date_after = $this->input->get('after');
	  }
	  
	  if($this->input->get('before') != null){
	       $this->date_before = $this->input->get('before');
	  }
	  
	  $channels = $this->account_model->GetChannel();
	  $data = array();
	  foreach($channels as $channel){
	       if($channel->connection_type == 'facebook'){
		    $data[$channel->name] = $this->facebook_indexing($channel->channel_id);
	       }
	       elseif($channel->connection_type == 'twitter'){
		    $data[$channel->name] = $this->twitter_indexing($channel->channel_id);
	       }
	       /*
	       elseif($channel->connection_type == 'youtube'){
		    $this->youtube_indexing($channel->channel_id);
	       }
	       */
	  }
	  
	  print_r($data);
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
	       'c.created_at >=' => $this->date_after,
	       'c.created_at <=' => $this->date_before
	    );
	  $fb_feed = $this->facebook_model->RetrieveFeedFB($filter,0,false);
	  
	  $filter = array(
	       'a.channel_id' => $channel_id,
	       'b.created_at >=' => $this->date_after,
	       'b.created_at <=' => $this->date_before
	    );
	  $comments = $this->facebook_model->GetCommentsGroupedByPostId($filter);
	  
	  if($comments){
	       foreach($comments as $c){
		    $filter = array(
			 'b.post_id' => $c->post_id,
		    );
		    $add_fb_feed = $this->facebook_model->RetrieveFeedFB($filter,0,false);
		    foreach($add_fb_feed as $add){
			$fb_feed[] = (object)$add;
		    }
		}
	  }
	  
	  if($fb_feed){
	       $bulkString = '';
	       foreach($fb_feed as $wp){
		    $action = array("index" => array('_id' => $wp->post_id));
		    $actionString = json_encode($action);
		    
		    $comments = array();
		    if($wp->comments){
			 foreach($wp->comments as $c){
			      $comments[] = array('comment_content' => $c->post_content,
						  'name' => $c->name
						 );  
			 }
		    }

		    $doc = array('name' => $wp->name,
				   'post_id' => $wp->post_id,
				   'post_content' => $wp->post_content,
				   'post_stream_id' => $wp->post_stream_id,
				   'comments' => $comments
				  );
		    $bulkString .= "$actionString\n";
		    $bulkString .= json_encode($doc) . "\n";
	       }
		    
	       $new_wp['index'] = $this->the_index;
	       $new_wp['type'] = 'facebook_feed';
	       $new_wp['body'] = $bulkString;
	       $ret = $this->elasticsearch_model->Bulk($new_wp);
	  }
	  
	  //indexing for fb private message
	  $fb_pm_map = array('messages' => array('type' => 'string'),
				   'name' => array('type' => 'string'),
				   'post_stream_id' => array('type' => 'string'),
				   'post_id' => array('type' => 'string'),
				);
	  $ret = $this->elasticsearch_model->TypeMapping($this->the_index,'facebook_pm',$fb_pm_map);
	  $filter = array(
	       'c.channel_id' => $channel_id,
	       'c.created_at >=' => $this->date_after,
	       'c.created_at <=' => $this->date_before
	    );
	  $fb_pm = $this->facebook_model->RetrievePmFB($filter);
	  
	  if($fb_pm){
	       $bulkString = '';
	       foreach($fb_pm as $pm){
		    $sender = $pm->participant->sender->facebook_id == $pm->social_id ? $pm->participant->to : $pm->participant->sender;
		    $action = array("index" => array('_id' => $pm->post_id));
		    $actionString = json_encode($action);
		    $doc = array('messages' => $pm->snippet,
				   'name' => $sender->name,
				   'post_stream_id' => $pm->post_stream_id,
				   'post_id' => $pm->post_id
				   );
		    $bulkString .= "$actionString\n";
		    $bulkString .= json_encode($doc) . "\n";
	       }
	       $new_pm['index'] = $this->the_index;
	       $new_pm['type'] = 'facebook_pm';
	       $new_pm['body'] = $bulkString;
	       $ret = $this->elasticsearch_model->Bulk($new_pm);
	  }
	  
	  $fb_index['fb_feed'] = count($fb_feed);
	  $fb_index['fb_pm'] = count($fb_pm);
	  
	  return $fb_index;
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
	  $filter = array(
	       'a.channel_id' => $channel_id,
	       'a.created_at >=' => $this->date_after,
	       'a.created_at <=' => $this->date_before
	       );
	  $filter['b.type'] = 'mentions';
	  $mentions = $this->twitter_model->ReadTwitterData($filter);
	  
	  if($mentions){
	       $bulkString = '';
	       foreach($mentions as $m){
		    $action = array("index" => array('_id' => $m->post_id));
		    $actionString = json_encode($action);
		    $doc = array('text' => $m->text,
				   'screen_name' => $m->screen_name,
				   'post_stream_id' => $m->post_stream_id,
				   'post_id' => $m->post_id,
				   'name' => $m->name
				   );
		    $bulkString .= "$actionString\n";
		    $bulkString .= json_encode($doc) . "\n";
	       }
	       $new_m['index'] = $this->the_index;
	       $new_m['type'] = 'twitter_mentions';
	       $new_m['body'] = $bulkString;
	       $ret = $this->elasticsearch_model->Bulk($new_m);
	  }
	  
	  //create twitter homefeed type
	  $ret = $this->elasticsearch_model->TypeMapping($this->the_index,'twitter_homefeed',$tw_mention_map);
	  $filter['b.type'] = 'home_feed';
	  $homefeeds = $this->twitter_model->ReadTwitterData($filter);
	  
	  if($homefeeds){
	       $bulkString = '';
	       foreach($homefeeds as $hf){
		    $action = array("index" => array('_id' => $hf->post_id));
		    $actionString = json_encode($action);
		    $doc = array('text' => $hf->text,
				   'screen_name' => $hf->screen_name,
				   'post_stream_id' => $hf->post_stream_id,
				   'post_id' => $hf->post_id,
				   'name' => $hf->name
				   );
		    $bulkString .= "$actionString\n";
		    $bulkString .= json_encode($doc) . "\n";
	       }
	       $new_hf['index'] = $this->the_index;
	       $new_hf['type'] = 'twitter_homefeed';
	       $new_hf['body'] = $bulkString;
	       $ret = $this->elasticsearch_model->Bulk($new_hf);
	  }
	  
	  //create twitter senttweets type
	  $ret = $this->elasticsearch_model->TypeMapping($this->the_index,'twitter_senttweets',$tw_mention_map);
	  $filter['b.type'] = 'user_timeline';
	  $timelines = $this->twitter_model->ReadTwitterData($filter);
	  
	  if($timelines){
	       $bulkString = '';
	       foreach($timelines as $tl){
		    $action = array("index" => array('_id' => $tl->post_id));
		    $actionString = json_encode($action);
		    $doc = array('text' => $tl->text,
				   'screen_name' => $tl->screen_name,
				   'post_stream_id' => $tl->post_stream_id,
				   'post_id' => $tl->post_id,
				   'name' => $tl->name
				   );
		    $bulkString .= "$actionString\n";
		    $bulkString .= json_encode($doc) . "\n";
	       }
	       $new_tl['index'] = $this->the_index;
	       $new_tl['type'] = 'twitter_senttweets';
	       $new_tl['body'] = $bulkString;
	       $ret = $this->elasticsearch_model->Bulk($new_tl);
	  }
	   
	  //create twitter direct_messages type
	  $ret = $this->elasticsearch_model->TypeMapping($this->the_index,'twitter_dms',$tw_mention_map);
	  unset($filter['b.type']);
	  $dms = $this->twitter_model->ReadDMFromDb($filter);
	  
	  if($dms){
	       $bulkString = '';
	       foreach($dms as $dm){
		    $action = array("index" => array('_id' => $dm->post_id));
		    $actionString = json_encode($action);
		    $doc = array('text' => $dm->dm_text,
				   'screen_name' => $dm->screen_name,
				   'post_stream_id' => $dm->post_stream_id,
				   'post_id' => $dm->post_id,
				   'name' => $dm->name
				   );
		    $bulkString .= "$actionString\n";
		    $bulkString .= json_encode($doc) . "\n";
	       }
	       $new_dm['index'] = $this->the_index;
	       $new_dm['type'] = 'twitter_dms';
	       $new_dm['body'] = $bulkString;
	       $ret = $this->elasticsearch_model->Bulk($new_dm);
	  }
	  
	  $tw_index['mentions'] = count($mentions);
	  $tw_index['homefeeds'] = count($homefeeds);
	  $tw_index['timelines'] = count($timelines);
	  $tw_index['dms'] = count($dms);
	  return $tw_index;
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

     public function DeleteIndex(){
	  $this->elasticsearch_model->DeleteIndex('live_dcms');
     }
     
     public function DeleteDoc(){
	  $monthsAgo = strtotime("-3 month", strtotime(date('Y-m-d H:i:s')));
	 
	  if($this->input->get('after') == null){
	       $this->date_after = date('Y-m-d H:i:s', $monthsAgo);
	  }
	  else {
	       $this->date_after = $this->input->get('after');
	  }
	  
	  if($this->input->get('before') == null){
	       $this->date_before = date('Y-m-d H:i:s', strtotime("+1 hours",$monthsAgo));
	  }
	  else {
	       $this->date_before = $this->input->get('before');
	  }

	  $channels = $this->account_model->GetChannel();
	  $data = array();
	  foreach($channels as $channel){
	       if($channel->connection_type == 'facebook'){
		    $data[$channel->name] = $this->facebook_unindexing($channel->channel_id);
	       }
	       elseif($channel->connection_type == 'twitter'){
		    $data[$channel->name] = $this->twitter_unindexing($channel->channel_id);  
	       }
	       /*
	       elseif($channel->connection_type == 'youtube'){
		    $this->youtube_indexing($channel->channel_id);
	       }
	       */
	  }
	  print_r($data);
     }
     
     public function facebook_unindexing($channel_id){
	  $filter = array(
	       'c.channel_id' => $channel_id,
	       'c.created_at >=' => $this->date_after,
	       'c.created_at <=' => $this->date_before
	    );
	  $fb_feed = $this->facebook_model->RetrieveFeedFB($filter,0,false);
	  
	  $filter = array(
	       'a.channel_id' => $channel_id,
	       'b.created_at >=' => $this->date_after,
	       'b.created_at <=' => $this->date_before
	    );
	  $comments = $this->facebook_model->GetCommentsGroupedByPostId($filter);
	  
	  if($comments){
	       foreach($comments as $c){
		    $filter = array(
			 'b.post_id' => $c->post_id,
		    );
		    $add_fb_feed = $this->facebook_model->RetrieveFeedFB($filter,0,false);
		    foreach($add_fb_feed as $add){
			$fb_feed[] = (object)$add;
		    }
		}
	  }
	  
	  if($fb_feed){
	       $bulkString = '';
	       foreach($fb_feed as $wp){
		    $this->elasticsearch_model->DeleteDoc($this->the_index, 'facebook_feed', $wp->post_id);
	       }
	  }
	  
	  $filter = array(
	       'c.channel_id' => $channel_id,
	       'c.created_at >=' => $this->date_after,
	       'c.created_at <=' => $this->date_before
	    );
	  $fb_pm = $this->facebook_model->RetrievePmFB($filter);
	  
	  if($fb_pm){
	       foreach($fb_pm as $pm){
		    $this->elasticsearch_model->DeleteDoc($this->the_index, 'facebook_pm', $pm->post_id);
	       }
	  }
	  $fb_index['fb_feed'] = count($fb_feed);
	  $fb_index['fb_pm'] = count($fb_pm);
	  
	  return $fb_index;
     }
     
     public function twitter_unindexing($channel_id){
	  $filter = array(
	       'a.channel_id' => $channel_id,
	       'a.created_at >=' => $this->date_after,
	       'a.created_at <=' => $this->date_before
	       );
	  
	  $filter['b.type'] = 'mentions';
	  $mentions = $this->twitter_model->ReadTwitterData($filter);
	  if($mentions){
	       foreach($mentions as $m){
		    $this->elasticsearch_model->DeleteDoc($this->the_index, 'twitter_mentions', $m->post_id);
	       }
	  }
	  
	  $filter['b.type'] = 'home_feed';
	  $homefeeds = $this->twitter_model->ReadTwitterData($filter);
	  if($homefeeds){
	       foreach($homefeeds as $hf){
		    $this->elasticsearch_model->DeleteDoc($this->the_index, 'twitter_homefeed', $hf->post_id);
	       }
	  }
	  
	  $filter['b.type'] = 'user_timeline';
	  $timelines = $this->twitter_model->ReadTwitterData($filter);
	  if($timelines){
	       foreach($timelines as $tl){
		    $this->elasticsearch_model->DeleteDoc($this->the_index, 'twitter_senttweets', $tl->post_id);
	       }
	  }
	   
	  unset($filter['b.type']);
	  $dms = $this->twitter_model->ReadDMFromDb($filter);
	  if($dms){
	       foreach($dms as $dm){
		    $this->elasticsearch_model->DeleteDoc($this->the_index, 'twitter_dms', $dm->post_id);
	       }
	  }
	  
	  $tw_index['mentions'] = count($mentions);
	  $tw_index['homefeeds'] = count($homefeeds);
	  $tw_index['timelines'] = count($timelines);
	  $tw_index['dms'] = count($dms);
	  return $tw_index;
     }
     
     public function youtube_unindexing($channel_id){
	  $filter = array(
	   'c.channel_id' => $channel_id,
	  );
	  $posts = $this->youtube_model->ReadYoutubePost($filter);
	  foreach($posts as $post){
	       $ret = $this->elasticsearch_model->DeleteDoc($this->the_index, 'youtube_post', $post->post_stream_id);
	  }
	  
	  $filter = array(
	   'channel_id' => $channel_id,
	  );
	  $comments = $this->youtube_model->ReadYoutubeComment($filter);
	  foreach($comments as $comment){
	       $ret = $this->elasticsearch_model->DeleteDoc($this->the_index, 'youtube_comment', $comment->post_stream_id);
	  }
      }
}