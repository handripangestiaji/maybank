<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Media_stream extends CI_Controller {

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
	$this->load->model('facebook_model');
	$this->load->model('twitter_model');
	$this->load->model('account_model');
    }
    
    
    public function facebook_stream($channel_id,$is_read = NULL){
	$filter = array(
	   'channel_id' => $channel_id,
	);
	if($is_read != NULL){
	    if($is_read != 2){
		$filter['is_read'] = $is_read;
	    }
	}
	$limit=10;
	$data['fb_feed'] = $this->facebook_model->RetrieveFeedFB($filter,$limit);
	$data['count_fb_feed']=$this->facebook_model->CountFeedFB($filter);
	//$data['own_post'] = $this->facebook_model->RetrievePostFB($filter);
	$data['fb_pm'] = $this->facebook_model->RetrievePmFB($filter,$limit);
	$data['CountPmFB']=$this->facebook_model->CountPmFB($filter);
	$this->load->model('campaign_model');
	$data['product_list'] = $this->campaign_model->GetProduct();
	$data['channel_id'] = $channel_id;
	$this->load->model('case_model');
	$data['user_list'] = $this->case_model->ReadAllUser();
	$this->load->view('dashboard/facebook/facebook_stream',$data);
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
        
        if($this->input->post('action')=='sendTweet'){ //ok

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
            echo json_encode($result);
               
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
    
    public function ReplyTwitter($type = 'tweet'){
	header("Content-Type: application/x-json");
	$twitter_reply['image_to_post'] = $this->input->post('filename');
	$twitter_reply['reply_to_post_id'] = $this->input->post('post_id');
	$twitter_reply['content_products_id'] = $this->input->post('product_type');
	$twitter_reply['reply_type'] = $this->input->post('reply_type');
	$twitter_reply['text'] = $this->input->post('content');
	$twitter_reply['user_id'] = $this->session->userdata('user_id');
	if($this->input->post('type') == 'reply')
	    $twitter_data = $this->twitter_model->ReadTwitterData(
		array(
		    'a.post_id' => $this->input->post('post_id')
		),
		1
	    );
	else
	    $twitter_data = $this->twitter_model->ReadDMFromDb(
		array(
		    'a.post_id' => $this->input->post('post_id')
		),
		1
	    );
	if(count($twitter_data) > 0 || $this->input->post('type') == 'direct_message'){
	    
	    $channel = $this->account_model->GetChannel(array(
		'channel_id' => $this->input->post('channel_id')
	    ));
	    if(count($channel) == 0){
		echo json_encode(
		    array(
			'success' => false,
			'message' => "Invalid Channel Id"
		    )
		);
		return;
	    }
	    else{
		$channel = $channel[0];
	    }
	    
	    $this->load->library('Twitteroauth');
	    $this->connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'),$this->config->item('twitter_consumer_secret'), $channel->oauth_token,
							    $channel->oauth_secret);
	    if($this->input->post('type') == 'reply'){
		$twitter_data = $twitter_data[0];
		$parameters = array('status' => $this->input->post('content'),'in_reply_to_status_id'=>$twitter_data->post_stream_id);
		 if($twitter_reply['image_to_post']){
		    $this->load->helper('file');
		    $img = $twitter_reply['image_to_post'];
		    $img = str_replace('data:image/png;base64,', '', $img);
		    $img = str_replace('data:image/jpeg;base64,', '', $img);
		    $img = str_replace(' ', '+', $img);
		    $data = base64_decode($img);
		    $file_name = uniqid().'.png';
		    $pathToSave = $this->config->item('assets_folder').'/'.$file_name;
		    $twitter_reply['image_to_post'] = $pathToSave;
		    if ( ! write_file($pathToSave, $data)){
			$validation = array('result' => FALSE,'name' => 'image '.$pathToSave,'error_code' => 112);
			$result=$this->connection->post('statuses/update', $parameters);
		    }
		    else{
			require_once './application/libraries/codebird.php';
			$this->load->config('twitter');
			Codebird::setConsumerKey($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'));
			$cb = Codebird::getInstance();
			$cb->setToken($channel->oauth_token, $channel->oauth_secret);
			$parameters['media[]'] = $pathToSave;
			$result = $cb->statuses_updateWithMedia($parameters);
			$result->params = $parameters;
		    }
		}
		else{
		    $result=$this->connection->post('statuses/update', $parameters);
		}
		$return = $this->twitter_model->CreateReply($twitter_reply, $result, $channel, 'reply');
	    }
	    else{
		$parameters = array(
		    'user_id' => $this->input->post('twitter_user_id'),
		    'text' => $this->input->post('content')
		);
		$result = $this->connection->post('direct_messages/new', $parameters);
		$return = $this->twitter_model->CreateReply($twitter_reply, $result, $channel, 'direct_message');
	    }
	    if($return){
		echo json_encode(array(
		    'success' => true,
		    'message' => "Reply tweet successfully done.",
		    'result' => $result
		));
	    }
	    else{
		echo json_encode(array(
		    'success' => false,
		    'message' => "Reply tweet was failed.",
		    'result' => $result
		));
	    }
	    
	}
	else{
	    echo json_encode(
		array(
		    'success' => false,
		    'message' => "Invalid POST Id"
		)
	    );
	}
    }
    
    public function ActionTwitter($type = 'retweet'){
	header("Content-Type: application/x-json");
	$action['channel_id'] = $this->input->post('channel_id');
	$action['post_id'] = $this->input->post('post_id');
	$action['created_by'] = $this->session->userdata('user_id');
	$twitter_data = $this->twitter_model->ReadTwitterData(
	    array(
		'a.post_id' => $this->input->post('post_id')
	    ),
	    1
	);
	if(count($twitter_data) > 0){
	    $twitter_data = $twitter_data[0];
	    $channel = $this->account_model->GetChannel(array(
		'channel_id' => $this->input->post('channel_id')
	    ));
	    if(count($channel) == 0){
		echo json_encode(
		    array(
			'success' => false,
			'message' => "Invalid Channel Id"
		    )
		);
		return;
	    }
	    else{
		$channel = $channel[0];
		$this->connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'),$this->config->item('twitter_consumer_secret'), $channel->oauth_token,
							    $channel->oauth_secret);
		if($type == 'retweet'){
		    $result = $this->connection->post('statuses/retweet/'.$twitter_data->post_stream_id);
		    $this->account_model->CreateRetweetAction($action, $result, $twitter_data, $channel);
		}
		else if($type == 'favorite'){
		    $result = $this->connection->post('favorites/create', array('id' => $twitter_data->post_stream_id));
		    $this->account_model->CreateFavoriteAction($action, $result, $twitter_data, $channel);
		}
		echo json_encode(array(
		    'success' => true,
		    'message' => $type." successfully done.",
		    'result' => $result
		));
	    }
	    //$this->account_model->CreateRetweetAction($action);
	}
	else{
	    echo json_encode(
		array(
		    'success' => false,
		    'message' => "Invalid POST Id"
		)
	    );
	}
	
    }
    function ActionTwitterDelete(){
	header("Content-Type: application/x-json");
	$action['channel_id'] = $this->input->post('channel_id');
	$action['post_id'] = $this->input->post('post_id');
	$action['created_by'] = $this->session->userdata('user_id');
	$twitter_data = $this->twitter_model->ReadTwitterData(
	    array(
		'a.post_id' => $this->input->post('post_id')
	    ),
	    1
	);
	if(count($twitter_data) > 0){
	    $twitter_data = $twitter_data[0];
	    $channel = $this->account_model->GetChannel(array(
		'channel_id' => $this->input->post('channel_id')
	    ));
	    
	    if(count($channel) == 0){
		echo json_encode(
		    array(
			'success' => false,
			'message' => "Invalid Channel Id"
		    )
		);
		return;
	    }
	    else{
		$channel = $channel[0];
		$this->connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'),$this->config->item('twitter_consumer_secret'), $channel->oauth_token,
							    $channel->oauth_secret);
		$result = $this->connection->post('statuses/destroy/'.$twitter_data->post_stream_id);
		if(!isset($result->error)){
		    $row_affected = $this->twitter_model->DeletePost($twitter_data->post_stream_id);
		    echo json_encode(
			array(
			    'success' => true,
			    'message' => "Tweet was sucessfully deleted.",
			    'result' => $result,
			    'row_affected' => $row_affected
			)
		    );
		}
		else{
		     echo json_encode(
		    array(
			'success' => false,
			'message' => "Delete tweet was failed.",
			'result' => $result
			)
		    );
		}
		
		return;
	    }
	}
	echo json_encode(
		array(
		    'success' => false,
		    'message' => "Invalid POST_ID"
		)
	);
	    
    }
    
    function ActionFollow($type = 'follow'){
	header("Content-Type: application/x-json");
	$action['channel_id'] = $this->input->post('channel_id');
	$action['post_id'] = $this->input->post('post_id');
	$action['created_by'] = $this->session->userdata('user_id');
	$twitter_data = $this->twitter_model->ReadTwitterData(
	    array(
		'a.post_id' => $this->input->post('post_id')
	    ),
	    1
	);
	if(count($twitter_data) > 0){
	    $twitter_data = $twitter_data[0];
	    $channel = $this->account_model->GetChannel(array(
		'channel_id' => $this->input->post('channel_id')
	    ));
	    if(count($channel) == 0){
		echo json_encode(
		    array(
			'success' => false,
			'message' => "Invalid Channel Id"
		    )
		);
		return;
	    }
	    else{
		$channel = $channel[0];
		$this->twitter_model->InitConnection($channel->oauth_token, $channel->oauth_secret);
		$return_value = null;
		if($type == 'follow'){
		    $return_value = $this->twitter_model->CreateFriends($twitter_data, $this->session->userdata('user_id'));
		}
		else if($type == 'unfollow'){
		    $return_value = $this->twitter_model->RemoveFriends($twitter_data, $this->session->userdata('user_id'));
		}
		echo json_encode(
		    array(
			'success' => true,
			'message' => "Relation was sucessfully made.",
			'result' => $return_value
		    )
		);
	    }
	}
    }
    //=========================================facebook function=============================================
    public function fb_access_token(){
	$app_id = $this->config->item('fb_appid');
	$app_secret = $this->config->item('fb_appsecret');
	$my_url = site_url('dashboard/fb_access_token');  // redirect url
	$code = $this->input->get("code");
	if(empty($code)) {
	  // Redirect to Login Dialog
	    $this->session->set_userdata('state', md5(uniqid(rand(), TRUE))); // CSRF protection
	    $dialog_url = "https://www.facebook.com/dialog/oauth?client_id=" 
		. $app_id . "&redirect_uri=" . urlencode($my_url) . "&state="
		. $this->session->userdata('state') . "&scope=publish_stream,read_friendlists,email,manage_pages,export_stream,publish_actions,publish_checkins,read_stream";
	    redirect($dialog_url);
	}
	if($this->session->userdata('state') && ($this->session->userdata('state')=== $this->input->get('state'))) {
	    $token_url = "https://graph.facebook.com/oauth/access_token?"
	      . "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url)
	      . "&client_secret=" . $app_secret . "&code=" . $code;
	    $response = curl_get_file_contents($token_url);
	    $params = null;
	    parse_str($response, $params);
	    $longtoken=$params['access_token'];
	    print_r($params);
	}

    }
    
    public function FbLikeStatus(){
	$post_id = $this->input->post('post_id');
	$this->load->model('account_model');
	$channel = $this->account_model->GetChannel(array(
	    "channel_id" => $this->input->post("channel_id")
	));
	header('Content-Type: application/x-json');
	if(count($channel) == 1){
	    $access_token_fb = $this->facebook_model->GetPageAccessToken($channel[0]->oauth_token, $channel[0]->social_id);
	    $config = array(
		 'appId' => $this->config->item('fb_appid'),
		 'secret' => $this->config->item('fb_secretkey')
	    );
	    $this->load->library('facebook',$config);
	    $this->facebook->setAccessToken($access_token_fb);
	    if($this->input->post('like') === 'true')
		$return = $this->facebook->api('/'.$post_id.'/likes','POST');
	    else
		$return = $this->facebook->api('/'.$post_id.'/likes','DELETE');
	    $action = array(
		"action_type" => "like_facebook",
		"channel_id" => $channel[0]->channel_id,
		"created_at" => date("Y-m-d H:i:s"),
		"stream_id" => $this->input->post('post_id'),
		"created_by" => $this->session->userdata('user_id'),
		"stream_id_response" => $return
	    );
	    $this->account_model->CreateFbLikeAction($action, $this->input->post('like') === 'true' ? 1 : 0);
	    echo json_encode($return);
	}
	else{
	    echo false;
	}
    }
    
    public function FbReplyPost(){
        header("Content-Type: application/x-json");
	    $this->load->model('account_model');
        $this->load->model('facebook_model');
        $comment = $this->input->post('comment');
        $post_id = $this->input->post('post_id');
        $url = $this->input->post('url');
             
        $filter = array(
            "connection_type" => "facebook"
        );
        
        if($this->input->get('channel_id')){
            $filter['channel_id'] = $this->input->get('channel_id');
        }
        $channel_loaded = $this->account_model->GetChannel($filter);
        if(count($channel_loaded) == 0){
    		echo json_encode(
    		    array(
    			'success' => false,
    			'message' => "Invalid Channel Id"
    		    )
    		);
		return;
	    }
	    else{
		  $channel =  $channel_loaded[0]->channel_id;
	    }
        
        $newStd = new stdClass();
        $newStd->page_id =  $channel_loaded[0]->social_id;
        $newStd->token = $this->facebook_model->GetPageAccessToken( $channel_loaded[0]->oauth_token, $channel_loaded[0]->social_id);
        $config = array(
	       'appId' => $this->config->item('fb_appid'),
	       'secret' => $this->config->item('fb_secretkey')
	    );
    	$this->load->library('facebook',$config);
    	$this->facebook->setaccesstoken($newStd->token);
    	$return=$this->facebook->api('/'.$post_id.'/comments','post',array('message' => $comment));
        
        $case=$this->account_model->isCaseIdExists($post_id);
            if(count($case)>0){
                $post_at=$case[0]->created_at;  
                $caseid=$case[0]->case_id;
            }else{
                $caseid='';
                $post_at='';       
            }
        
        if(!is_array($return)){//send comment          
            $action = array(
        		"action_type" => "reply_facebook",
        		"channel_id" =>$channel,
        		"created_at" => date("Y-m-d H:i:s"),
        		"stream_id" => $this->input->post('post_id'),
        		"created_by" => $this->session->userdata('user_id'),
        		"stream_id_response" => $return
    	    );
            $this->account_model->CreateFbCommentAction($action, $this->input->post('like') === 'true' ? 1 : 0);
            echo json_encode(
    		    array(
                'success' => true,
    			'message' => "successfully done",
    			'result' => $return
    		    )
    		);
		                                        
        }elseif(is_array($return)){//replay in reply
        
        if($return['id']){
            $action = array(
        		"action_type" => "reply_facebook",
        		"channel_id" => $channel_loaded[0]->channel_id,
        		"created_at" => date("Y-m-d H:i:s"),
        		"stream_id" => $this->input->post('post_id'),
        		"created_by" => $this->session->userdata('user_id'),
        		"stream_id_response" => $return['id']
        	);
         
            $replyAction = array(
        		"case_id" => $caseid,
        		"channel" => $channel_loaded[0]->channel_id,
        		"url" => $url,
        		"message" =>$comment,
        		"stream_id" => $return['id'],
        		"comment_id" => $post_id,
        	    "conversation_detail_id" => '',
                "type" => "reply_facebook",
                "post_at" => $post_at,
                "created_at" => date("Y-m-d H:i:s")
            );
            $this->account_model->CreateFbCommentAction($action, $this->input->post('like') === 'true' ? 1 : 0);
            echo json_encode(
    		    array(
                'success' => true,
    			'message' => "successfully done",
    			'result' => $return
    		    )
    		);
            
            }else{
                echo json_encode(
        		    array(
                    'success' => false,
        			'message' => "reply was failed",
        			'result' => $return
        		    )
    		    );
            }
       }
    }
    
    public function SocmedPost(){
	$this->load->model('post_model');
	
	if($this->input->post('schedule') != ''){
	    /* schedule date convert */
	    $schedules = explode(' ',$this->input->post('schedule'));
	    $the_dates = explode('/',$schedules[0]);
	    $the_hours = date("H:i", strtotime($schedules[1].' '.$schedules[2]));
	    $compose_date = $the_dates[2].'-'.$the_dates[0].'-'.$the_dates[1];
	    $compose_hour = $the_hours.':00';
	    $compose_date_hour = $compose_date.' '.$compose_hour;
	}
	else{
	    $compose_date_hour = null;
	}
	
	$this->post_model->InsertPost($this->input->post('content'),$this->input->post('channels'),$this->input->post('tags'),$compose_date_hour);
    }
    
    public function load_facebook($type){
	    $access_token = "CAACEdEose0cBAFGdZB2IH8VzRiPuoLAZC0vQ3u7Tc0PuZAyycV0cs5CCng8Xw3qnni9V6YxgeaQ0p9VCdGzfGGHTeUUsLL6exlGXBTAbWl6T7573l4DnKm3kTPh7dQrqqJNpcvMMWZA9K92p7NtS5eLwjmZCKxZCCEQ4jWk5DtccZBMZAEKS2Meqe1yzhetcUKMZD";
	    
	    print_r($this->facebook_model->RetrieveFeedFacebook('gizikudotcom', $access_token, $type));
    }
    
    public function ReadUnread(){
	  $this->load->model('facebook_model');
	  if($this->input->post('post_id')){
	    $read = $this->input->post('read');
	    $new_val = $this->facebook_model->ReadUnread($this->input->post('post_id'), $read);
	    echo $new_val;  
	  }
	  else
	    echo 0;
	  
    }
    //=========================================END facebook function=============================================    


    //=========================================GENERAL function=============================================    
    public function publish(){
	    echo $this->input->post('compose_message');
    }
    
    /**
    * Get more content data for auto load paging
    * $group_no = jumlah item terakhir yg di load
    **/
    public function LoadMore($actions,$group_numbers,$channel_ids){
            
        $items_per_group = 10;
        $group_number=$group_numbers;
        $action=$actions;
        $channel_id=$channel_ids;
        $is_read=0;
        $filter = array(
    	   'channel_id' => $channel_id,
    	);
    	
	if($this->input->get('last_id')){
	    $filter['post_id >'] = $this->input->get('last_id');
	}
        if($is_read != NULL){
    	    if($is_read != 2){
    		$filter['is_read'] = $is_read;
    	    }
    	}

     	//throw HTTP error if group number is not valid
    	if(!is_numeric($group_number)){
    		header('HTTP/1.1 500 Invalid number!');
    		exit();
    	}
    	
    	//get current starting point of records
    	$limit = ($group_number * $items_per_group);

    	$this->load->model('case_model');
    	$data['user_list'] = $this->case_model->ReadAllUser();
        
        $this->load->model('campaign_model');
        $data['product_list'] = $this->campaign_model->GetProduct();

    
        if($action=='mentions'){
            $filter['b.type'] = 'mentions';
            $data['mentions']=$this->twitter_model->ReadTwitterData($filter,$limit);
            $data['countMentions']=$this->twitter_model->CountTwitterData($filter);
            $this->load->view('dashboard/twitter/twitter_mentions.php',$data);
        }
        
        if($action=='feed'){
            $filter['b.type'] = 'home_feed';
        	$data['homefeed']=$this->twitter_model->ReadTwitterData($filter,$limit); 
            $data['countFeed']=$this->twitter_model->CountTwitterData($filter);
             $this->load->view('dashboard/twitter/twitter_homefeed.php',$data);
        }
        
        if($action=='sendmessage'){
        	$filter['b.type'] = 'user_timeline';
        	$data['senttweets']=$this->twitter_model->ReadTwitterData($filter,$limit);
            $data['countTweets']=$this->twitter_model->CountTwitterData($filter);
             $this->load->view('dashboard/twitter/twitter_senttweets.php',$data);

        }
//        unset($filter['b.type']);
        if($action=='direct'){
            $filter['channel_id']=$channel_ids;
            $data['directmessage']=$this->twitter_model->ReadDMFromDb($filter,$limit);
            $data['countDirect']=$this->twitter_model->CountTwitterData($filter);
        	$data['channel_id'] = $channel_id;
            $this->load->view('dashboard/twitter/twitter_messages.php',$data);

        }
        
    //$data['own_post'] = $this->facebook_model->RetrievePostFB($filter);
        if($action=='wallPosts'){
	    $filter['channel_id']=$channel_ids;
             $data['fb_feed'] = $this->facebook_model->RetrieveFeedFB($filter,$limit);
             $data['count_fb_feed']=$this->facebook_model->CountFeedFB($filter);
             $this->load->view('dashboard/facebook/wall_post.php',$data);
        }
        
        if($action=='privateMessages'){
            $filter['channel_id']=$channel_ids;
            $data['fb_pm'] = $this->facebook_model->RetrievePmFB($filter,$limit);
            $data['CountPmFB']=$this->facebook_model->CountPmFB($filter);
            $this->load->view('dashboard/facebook/private_message.php',$data);
        }
        //print_r($data);
    }
    


    //=========================================END GENERAL function=============================================    
    
      
  
     public function GetUrlPreview(){
	if (!isset($_GET['url'])) die();
	$url = urldecode($_GET['url']);
	$url = 'http://' . str_replace('http://', '', $url); // Avoid accessing the file system
	echo file_get_contents($url);
     }
     
     
    function tester(){
	$this->load->model('case_model');
	print_r($this->case_model->GetReplyNotification($this->session->userdata('user_id')));
    }
    
     
    public function GetShortenUrlByCampaignId(){
	$this->load->model('campaign_url_model');
          $result = $this->campaign_url_model->GetByCampaignId($this->input->get('campaignId'));
          echo json_encode($result);
    }
    
    public function GenerateShortUrl(){
	$this->load->library('Shorturl');
	$this->load->model(array('tag_model', 'product_model', 'campaign_model', 'shorturl_model', 'campaign_url_model'));
	$this->load->helper('form');
	$this->load->library('form_validation');

	$short_code = substr( md5( time().uniqid().rand() ), 0, 6 );
	
	$params = array('long_url' => $this->input->post('long_url'),
			'campaign_id' => $this->input->post('campaign_id'),
			'short_code' => $short_code,
			'description' => 'not yet');
	$params['user_id'] = $this->session->userdata('user_id');
	
	$config = array(
				array(	
					'field' => 'long_url',
					'label' => 'Full Url',
					'rules' => 'required'
				),
				array(
					'field' => 'campaign_id',
					'label' => 'Full Url',
					'rules' => 'required'
				)
			);
	
	$this->form_validation->set_rules($config);
	
	if($this->form_validation->run() == TRUE)
	{
		$code = $this->shorturl->urlToShortCode($params);
		if($code != false){
		    $setparam = array(
					"campaign_id" => $params['campaign_id'], 
					"url_id" => $code['url_id'],
					"user_id" => $params['user_id']
					);
		    
		    $id_campaign_url = $this->campaign_url_model->insert($setparam);
		    $setparam['short_code'] = $short_code;
		    $setparam['is_success'] = $code;
		    echo json_encode($setparam);
		}
		else{		
	     	$setparam['is_success'] = $code;
		    $setparam['message'] = 'Something Error. Make sure url is valid';
		    echo json_encode($setparam);
		}
	}
	else{
	    echo json_encode(array('is_success' => FALSE,'message' => 'Something error. Make sure you have select a campaign and put the full url in the insert link box.'));
	}
    }
    
    public function GenerateShortUrlWithoutCampaign(){
	header("Content-Type: application/x-json");
	$this->load->model(array('tag_model', 'product_model', 'campaign_model', 'shorturl_model', 'campaign_url_model'));
	$this->load->library('Shorturl');
	$short_code = substr( md5( time().uniqid().rand() ), 0, 6 );
	echo json_encode($this->shorturl->urlToShortCode(array(
				    'long_url' => $this->input->post('url'),
				    "user_id" => $this->session->userdata('user_id'),
				    'short_code' => $short_code,
				    "description" => "quick_reply",
				    'increment' => 0)));
    }
    
    public function CreateImage(){
	
    }
    
    public function GetAllTags(){
	$this->load->model('tag_model');
	echo json_encode($this->tag_model->get());
    }
    
    public function GetScheduleData(){
	$this->load->model('post_model');
	$posts = $this->post_model->GetPosts();
	
	$encodeme = array();
	foreach($posts as $post){
	    if($post->time_to_post != NULL){
		$time_to_post = explode(' ',$post->time_to_post);
		$post_date = $time_to_post[0];
		$post_time = $time_to_post[1];
		
		$short_date = explode('-',$post_date);
		$new_short_date = $short_date[2].'/'.$short_date[1];
		
		$short_time = date('H:i A',strtotime($post_time));
		
		$encodeme[] = array('id' => $post->id,
				'title' => $post->name,
				'start' => date('c',strtotime($post->time_to_post)),
				'end' => date('c',strtotime($post->time_to_post)),
				'description' => $post->messages,
				'user_name' => $post->display_name,
				'post_date' => $new_short_date,
				'post_time' => $short_time
			       );
	    }
	}
        echo json_encode($encodeme);
    }

}
