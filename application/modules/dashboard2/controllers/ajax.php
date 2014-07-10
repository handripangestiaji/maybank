<?php
/*
    * New Scheme of Dashboard2
    * AJAX load for every 
*/

class ajax extends CI_Controller{
    
    function __construct(){
        parent::__construct();
	$this->load->model('facebook_model');
	$this->user_role = $this->users_model->get_collection_detail(
		array('role_collection_id'=>$this->session->userdata('role_id')));
    }
    
    public function LoadCaseField(){
	$type = $this->input->get('type');
	$post_id = $this->input->get('post_id');
	
	if($type == 'twitter'){
	    $data = $this->twitter_model->ReadTwitterData(array('a.post_id' => $post_id));
	    $this->load->view('dashboard/case_field', array('posts' =>$data, 'i' => 0 ));
	}
	else if($type == 'twitter_dm'){
	    
	}
    }
    
    
    
    /*
     * LOAD AJAX for Every engagement on Facebook Comment List
    */
    public function LoadFacebookComments(){
	$this->load->model('campaign_model');
	$post_id = $this->input->get('post_id');
	$comment_list = $this->facebook_model->RetriveCommentPostFb(array('a.post_id'=> $post_id), array());
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
	echo $this->load->view('dashboard2/facebook/facebook_comment', array('comment' => $comment_list,
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
	$filter['b.post_id'] = $this->input->get('post_id');
	$product_list = $this->campaign_model->GetProduct(array('parent_id' => null));
	$data['fb_feed'] = $this->facebook_model->RetrieveFeedFB($filter,1, true, false);
        $data['i'] = 0;
        $data['reply_type'] = $this->input->get('reply_type');
	$data['product_list'] = $this->campaign_model->GetProductTree($product_list);
        echo $this->load->view('dashboard/reply_field_facebook', $data);
    }
    
    
    
    public function LoadCase(){
	$this->load->mocel('case_model');
	$fb_feed = array();
	if($this->input->get('reply_type') == 'replaycontent'){
	    
	}
	else if($this->input->get('reply_type') == 'reply_dm'){
	    $filter['b.post_id'] = $this->input->get('post_id');
	    $fb_feed = $this->facebook_model->RetrieveFeedFB($filter,1, true, false);
	}
	
	$data['posts'] = $fb_feed;        
        $data['i'] = 0;
    }

}