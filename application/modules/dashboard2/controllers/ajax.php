<?php
/*
    * New Scheme of Dashboard2
    * AJAX load for every 
*/

class ajax extends CI_Controller{
    
    function __construct(){
        parent::__construct();
	$this->load->model('facebook_model');
	$this->load->model('twitter_model');
	$this->load->model('campaign_model');
	$this->load->model('youtube_model');
	$this->user_role = $this->users_model->get_collection_detail(
		array('role_collection_id'=>$this->session->userdata('role_id')));
    }  
    
    
    /*
     * LOAD AJAX for Every engagement on Facebook Comment List
    */
    public function LoadFacebookComments(){
	$this->load->model('campaign_model');
	$post_id = $this->input->get('post_id');
	$comment_list = $this->facebook_model->RetriveCommentPostFb(array('a.post_id'=> $post_id,'b.comment_id' => 0), array());
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
	
	//get comments in comments
	$new_comment_list = array();
	foreach($comment_list as $r){
	    $case = $this->case_model->LoadCase(array('a.post_id' => $r->social_stream_post_id));
	    $r->case = null;
	    if($case){
		$r->case = $case;
	    }
	    $new_comment_list[] = $r;
	    
	    $filter = array('b.comment_id' => $r->comment_stream_id);
	    $comments = $this->facebook_model->GetCommentsInComment($filter);
	    if($comments){
		foreach($comments as $c){
		    $new_comment_list[] = $c;
		}
	    }
	}
	
	echo $this->load->view('dashboard2/facebook/facebook_comment', array('comment' => $new_comment_list,
									     'product_list' => $product_list));
    }
    
    
    /*
     * LOAD AJAX for Every engagement on Facebook Conversation Detail
    */
    public function LoadFacebookConversationDetail(){
	$this->load->model('campaign_model');
	$post_id = $this->input->get('post_id');
	$comment_list = $this->facebook_model->RetriveCommentPostFb(array('a.post_id'=> $post_id), array());
	$product_list = $this->campaign_model->GetProduct(array('parent_id' => null));
	$data['product_list'] = $this->campaign_model->GetProductTree($product_list);
	$data['comment'] = $this->facebook_model->RetrievePmDetailFB(array('a.conversation_id' => $post_id));
	echo $this->load->view('dashboard2/facebook/pm_engagement', $data);
    }
    /*
	* LOAD AJAX for Every engagement on Facebook Conversation Detail
	*
    */
    public function LoadFacebookReply(){
	$this->load->model('campaign_model');
	$this->load->model('case_model');
	
	$product_list = $this->campaign_model->GetProduct(array('parent_id' => null));
	if($this->input->get('reply_type') == 'replaycontent'){
	    $filter['b.post_id'] = $this->input->get('post_id');
	    $data['fb_feed'] = $this->facebook_model->RetrieveFeedFB($filter,1, true, false);
	}
	else if($this->input->get('reply_type') == 'reply_dm'){
	    $filter['c.post_id'] = $this->input->get('post_id');
	    $data['fb_feed']  = $this->facebook_model->RetrievePmFB($filter, 1);
	}
        $data['i'] = 0;
        $data['reply_type'] = $this->input->get('reply_type');
	$data['product_list'] = $this->campaign_model->GetProductTree($product_list);
        echo $this->load->view('dashboard2/reply_field_facebook', $data);
    }
    
    public function LoadTwitterReply(){
	$product_list = $this->campaign_model->GetProduct(array('parent_id' => null));
	
	$filter['a.post_id'] = $this->input->get('post_id');
	$data['mentions'] = $this->twitter_model->ReadTwitterData($filter,1);
	if(count($data['mentions']) == 0){
	    $data['mentions'] = $this->twitter_model->ReadDMFromDb($filter,1);
	}
	
        $data['type'] = $this->input->get('reply_type') == 'dm'? 'direct_message' : 'reply';
        $data['i'] = 0;
	$data['product_list'] =  $this->campaign_model->GetProductTree($product_list);
	
        echo $this->load->view('dashboard2/reply_field_twitter', $data);
    }
    
    public function LoadYoutubeReply(){
	$product_list = $this->campaign_model->GetProduct(array('parent_id' => null));
	
	$data['i'] = 0;
	$data['product_list'] =  $this->campaign_model->GetProductTree($product_list);
	
	$data['post_id'] = $this->input->get('post_id');
	$data['post'] =  $this->youtube_model->ReadYoutubePost(array('a.post_id' => $this->input->get('post_id')));
	//print_r($data);
        echo $this->load->view('dashboard2/reply_field_youtube', $data);
    }
    
    public function LoadCase(){
	$this->load->model('case_model');
	$this->load->model('campaign_model');
	$fb_feed = array();
	$product_list = $this->campaign_model->GetProduct(array('parent_id' => null));
	$filter_user['country_code'] = IsRoleFriendlyNameExist($this->user_role, 'Social Stream_Case_All_Country_AssignReassignResolved') ? NULL : $this->session->userdata('country');
	$data['user_list'] = $this->case_model->ReadAllUser($filter_user);
	if($this->input->get('reply_type') == 'reply_dm'){
	    $filter['c.post_id'] = $this->input->get('post_id');
	    $fb_feed = $this->facebook_model->RetrievePmFB($filter, 1);
	}
	else if($this->input->get('reply_type') == 'replaycontent'){
	    $filter['b.post_id'] = $this->input->get('post_id');
	    $fb_feed = $this->facebook_model->RetrieveFeedFB($filter,1, true, false);
	}
	else if($this->input->get('reply_type') == 'mentions' || $this->input->get('reply_type') == 'home_feed'){
	    $filter['a.post_id'] = $this->input->get('post_id');
	    $fb_feed = $this->twitter_model->ReadTwitterData($filter,1);
	}
	else if($this->input->get('reply_type') == 'direct_messages'){
	    $filter['a.post_id'] = $this->input->get('post_id');
	    $fb_feed = $this->twitter_model->ReadDMFromDb($filter,1);
	}
	else if($this->input->get('reply_type') == 'comment'){
	    $filter['b.id'] = $this->input->get('post_id');
	    $fb_feed = $this->facebook_model->RetriveCommentPostFb($filter, null);
	    $fb_feed[0]->post_id = $fb_feed[0]->social_stream_post_id;
	}
	else if($this->input->get('reply_type') == 'youtube'){
	    $fb_feed =  $this->youtube_model->ReadYoutubePost(array('a.post_id' => $this->input->get('post_id')));
	}
	
	//print_r($fb_feed);
	//die();
	$data['posts'] = $fb_feed;        
        $data['i'] = 0;
	$data['product_list'] = $this->campaign_model->GetProductTree($product_list);
	echo $this->load->view('dashboard2/case_field', $data);
	
    }

}