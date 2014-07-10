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
	$this->user_role = $this->users_model->get_collection_detail(
		array('role_collection_id'=>$this->session->userdata('role_id')));
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
	$data['mentions'] = $this->twitter_model->ReadTwitterData($filter,1);;
        $data['type'] = 'reply';
        $data['i'] = 0;
	$data['product_list'] =  $this->campaign_model->GetProductTree($product_list);
        echo $this->load->view('dashboard/reply_field_twitter', $data);
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
	
	$data['posts'] = $fb_feed;        
        $data['i'] = 0;
	$data['product_list'] = $this->campaign_model->GetProductTree($product_list);
	echo $this->load->view('dashboard2/case_field', $data);
	
    }

}