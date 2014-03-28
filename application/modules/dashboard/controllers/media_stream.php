<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Media_stream extends CI_Controller {

    private $connection;
    public $user_role;  
    function __construct()
    {
	parent::__construct();
	if(!$this->session->userdata('user_id'))
	    redirect("login");
	
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
	$this->load->model('youtube_model');
	$this->load->model('account_model');
	$this->load->model('case_model');
    $this->load->model('shorturl_model');
	$this->user_role = $this->users_model->get_collection_detail(
		array('role_collection_id'=>$this->session->userdata('role_id')));
    }
    
    
    public function facebook_stream($channel_id,$is_read = NULL){
	$this->load->model('case_model');
	$filter = array(
	   'channel_id' => $channel_id,
	);
	$channel_confg=$this->account_model->GetChannel($filter);
	if($is_read != NULL){
	    if($is_read != 2){
		$filter['is_read'] = $is_read;
	    }
	}
	$limit = 30;
	$filter_user['country_code'] = IsRoleFriendlyNameExist($this->user_role, 'Regional_User') ? NULL : $this->session->userdata('country');
	$data['user_list'] = $this->case_model->ReadAllUser($filter_user);
	$data['fb_feed'] = $this->facebook_model->RetrieveFeedFB($filter,$limit, true, $is_read == 2);
	$data['count_fb_feed']=$this->facebook_model->CountFeedFB($filter, true, $is_read == 2);
	//$data['own_post'] = $this->facebook_model->RetrievePostFB($filter);
	$filter['c.channel_id'] = $filter['channel_id'];
	unset($filter['channel_id']);
	$data['fb_pm'] = $this->facebook_model->RetrievePmFB($filter,$limit, $is_read == 2);
	$filter=array();
	$data['CountPmFB']=$this->facebook_model->CountPmFB($filter, $is_read == 2);
	$this->load->model('campaign_model');
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
	$data['product_list'] = $product_list;
	$data['channel_id'] = $channel_id;
        $filter=array('role_id <>'=>'5');
	
        //print_r($getUserCountry->country_code);
        
	$this->load->view('dashboard/facebook/facebook_stream',$data);
    }
    
    public function youtube_stream($channel_id, $is_read = null){
	$filter = array(
	   'channel_id' => $channel_id,
	);
	if($is_read)
	    $filter['is_read'] = $is_read;
	$page = $this->input->get('page');
	$page = $page ? $page : 1;
	$data['channel_id'] = $channel_id;
	$data['youtube_post'] = $this->youtube_model->ReadYoutubePost($filter, $page);
	$data['youtube_comment'] = $this->youtube_model->ReadYoutubeComment($filter, $page);
	$this->load->view('dashboard/youtube/youtube_stream', $data);
    }
    
    
    public function twitter_stream($channel_id,$is_read = null){
    	$limit = $this->config->item('item_perpage');
    	$filter = array(
    	   'a.channel_id' => $channel_id,
    	);
    	
    	if($is_read != NULL){
    	    if($is_read != 2){
    		$filter['is_read'] = $is_read;
    	    }else{
		    $filter['case'] = '';
	        }
    	}
    
    	$this->load->model('case_model');
	$filter_user['country_code'] = IsRoleFriendlyNameExist($this->user_role, 'Regional_User') ? NULL : $this->session->userdata('country');
    	$data['user_list'] = $this->case_model->ReadAllUser($filter_user);
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
	$data['product_list'] = $product_list;
    	$this->load->view('dashboard/twitter/twitter_stream',$data);
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
		    $action['action_type'] = 'twitter_favourite';
		    $this->account_model->CreateFavoriteAction($action, $result, $twitter_data, $channel);
		}
		else if($type == 'unfavorite'){
		    $result = $this->connection->post('favorites/destroy', array('id' => $twitter_data->post_stream_id));
		    $action['action_type'] = 'twitter_delete_favourite';
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
    function ActionTwitterDelete($status = 1){
    	header("Content-Type: application/x-json");
    	$action['channel_id'] = $this->input->post('channel_id');
    	$action['post_id'] = $this->input->post('post_id');
    	$action['created_by'] = $this->session->userdata('user_id');
	if($status == 1)
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
		$result = NULL;
		if($status == 1)
		    $result = $this->connection->post('statuses/destroy/'.$twitter_data->post_stream_id);
		else
		    $result = $this->connection->post('direct_messages/destroy',
						      array(
							     'id' => $twitter_data->post_stream_id
							   ));
    		if(!isset($result->error)){
		    if($status == 1)
			$row_affected = $this->twitter_model->DeletePost($twitter_data->post_stream_id, $channel->channel_id,
								    $this->session->userdata('user_id') == 0 ? NULL : $this->session->userdata('user_id'));
		    else
			$row_affected = $this->twitter_model->DeletePost($twitter_data->post_stream_id, $channel->channel_id,
								    $this->session->userdata('user_id') == 0 ? NULL : $this->session->userdata('user_id'), $status);
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
		//"stream_id" => $this->input->post('post_id'),
		"created_by" => $this->session->userdata('user_id'),
		"stream_id_response" => $return
	    );
	    $this->account_model->CreateFbLikeAction($action,$post_id, $this->input->post('like') === 'true' ? 1 : 0);
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
        $this->load->model('post_model');
        $comment = $this->input->post('comment');
        $post_id = $this->input->post('post_id');
        $title = $this->input->post('title');
        $url = $this->input->post('url');
        $descr = $this->input->post('desc');
        $img = $this->input->post('img');
        $reply_type=$this->input->post('reply_type');
        $product_type=$this->input->post('product_type');
        $tags=$this->input->post('tags');
             
        $filter = array(
            "connection_type" => "facebook"
        );
        $filter['channel_id'] = $this->input->post('channel_id');
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
    
        $short_url = $this->shorturl_model->find(array('short_code' => $url));
        if(isset($short_url->id)){
            $short_url_id = $short_url->id;
        }else{
            $short_url_id=null;
        }        
            
        if($tags != ''){
	    foreach($tags as $tag){
		$get_tag = $this->post_model->GetTagByTagName($tag);
                if($get_tag == NULL){
                    $tag_id = $this->post_model->InsertTag($tag);
                    $data = array('short_urls_id' => $short_url_id,
                                  'content_tag_id' => $tag_id
                                );
                    $this->db->insert('short_url_tag',$data);     
                }
                else{
                    $tag_id = $get_tag->id;
                    if(isset($tag_id)){
                        $data = array('short_urls_id' => $short_url_id ,
                                      'content_tag_id' => $tag_id
                                    );
                        $this->db->insert('short_url_tag',$data);
                    }
                }
                //tag increment
                $this->post_model->IncrementTag($tag_id);
	       }
	}
        
        $stream_id=$this->facebook_model->streamId($post_id);
        //print_r($stream_id);
        
        $newStd = new stdClass();
        $newStd->page_id =  $channel_loaded[0]->social_id;
        $newStd->token = $this->facebook_model->GetPageAccessToken( $channel_loaded[0]->oauth_token, $channel_loaded[0]->social_id);
        $config = array(
	       'appId' => $this->config->item('fb_appid'),
	       'secret' => $this->config->item('fb_secretkey')
	    );
	
    	$this->load->library('facebook',$config);
    	$this->facebook->setaccesstoken($newStd->token);
        $attachment = array(
            'message' => $comment,
            'name' => $title,
            'link' => '',
            'description' => $descr,
            'picture'=> $img,
        ); 
        
        if($img != ''){
            $this->load->helper('file');
            $image = $img;
            $image  = str_replace('data:image/png;base64,', '', $image);
            $image  = str_replace('data:image/jpeg;base64,', '', $image);
            $image  = str_replace(' ', '+', $image);
            $data = base64_decode($image);
            $file_name = uniqid().'.png';
            $pathToSave = $this->config->item('assets_folder').$file_name;
            if (write_file($pathToSave, $data)){    
                $this->facebook->setFileUploadSupport(true);
                $args = array('message' => $comment, 'attachment' => '@' . realpath($pathToSave));
                
                try{
                    $return = $this->facebook->api('/'.$stream_id->post_stream_id.'/comments', 'POST', $args);
                }
		catch(FacebookApiException $e){
                    echo json_encode(
            		    array(
                        'success' => false,
            			'message' => "reply was failed",
            		    )
                    );
                    $return='error';
                }
            }
        }else{
            try{
                $return=$this->facebook->api('/'.$stream_id->post_stream_id.'/comments', 'POST', array('message'=>$comment,'attachment'=>$attachment));
            }
	    catch(FacebookApiException $e){
                echo json_encode(
			array(
			    'success' => false,
			    'message' => "reply was failed",
			    )
		);
		$return='error';
            }
        }
        
        $pull_ronjob=curl_get_file_contents(base_url('/cronjob/FacebookStreamFeed'));
        
        if(!is_array($return) && $return!='error'){//send comment          
            $action = array(
		"action_type" => "reply_facebook",
        	"action_type" => "reply_facebook",
        	"channel_id" =>$channel,
        	"created_at" => date("Y-m-d H:i:s"),
        	"created_by" => $this->session->userdata('user_id'),
        	"stream_id_response" => $return
    	    );
            
           	    
            $this->account_model->CreateFbCommentAction($action,$post_id,$this->input->post('like') === 'true' ? 1 : 0);
            $this->account_model->CreateFbReplyAction($post_id,$stream_id->post_stream_id,$comment,$reply_type,$product_type,$url);
	    echo json_encode(
		array(
		    'success' => true,
		    'message' => "successfully done",
		    'result' => $return,
		    'action_log' => $action
		)
	    );	
                                      
        }
	elseif(is_array($return)){//replay in reply        
            if($return['id']){
            $return=$return['id'];
            $action = array(
                "post_id"=>$post_id,
        		"action_type" => "reply_facebook",
        		"channel_id" => $channel_loaded[0]->channel_id,
        		"created_at" => date("Y-m-d H:i:s"),
        		"created_by" => $this->session->userdata('user_id'),
        		"stream_id_response" => $return
        	);
            $this->account_model->CreateFbCommentAction($action,$post_id,$this->input->post('like') === 'true' ? 1 : 0);
            $this->account_model->CreateFbReplyAction($post_id,'',$comment,$reply_type,$product_type,$url);
	    $action['created_at'] = new DateTime($action['created_at']." Europe/London");
	    $action['created_at']->setTimezone(new DateTimeZone($this->session->userdata('timezone')));
	    $action['created_at'] = $action['created_at']->format("d-M-y h:i A");
	    echo json_encode(
    		    array(
			'success' => true,
    			'message' => "successfully done",
    			'result' => $return,
			'action_log' => $action
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
       }else{
                echo json_encode(
        		    array(
				'success' => false,
        			'message' => "reply was failed"   			
        		    )
    		    );
      }
    }
    
    public function FbReplyMsg(){
        header("Content-Type: application/x-json");
	   $this->load->model('account_model');
        $this->load->model('facebook_model');
        $comment = $this->input->post('comment');
        $post_id = $this->input->post('post_id');
        $title = $this->input->post('title');
        $url = $this->input->post('url');
        $descr = $this->input->post('desc');
        $img = $this->input->post('img');
        $case_id = $this->input->post('case_id');
             
             if($case_id=='null'){
                $case_id=null;
             }else{
                $case_id=$case_id;
             }
        $filter = array(
            "connection_type" => "facebook"
        );
        $filter['channel_id'] = $this->input->post('channel_id');
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
        $stream_id = $this->facebook_model->streamId($post_id);
        $newStd = new stdClass();
        $newStd->page_id =  $channel_loaded[0]->social_id;
        $newStd->token = $this->facebook_model->GetPageAccessToken( $channel_loaded[0]->oauth_token, $channel_loaded[0]->social_id);
        $config = array(
	    'appId' => $this->config->item('fb_appid'),
	    'secret' => $this->config->item('fb_secretkey')
	);
    	$this->load->library('facebook',$config);
    	$this->facebook->setaccesstoken($newStd->token);
        $attachment = array(
            'message' => $comment,
            'name' => $title,
            'link' => $url,
            'description' => $descr,
            'picture'=> $img,
        ); 
        $return = $this->facebook->api('/'.$stream_id->post_stream_id.'/messages', 'POST', array('message'=>$comment));
        $action = array(
	    "action_type" => "conversation_facebook",
	    "channel_id" => $channel_loaded[0]->channel_id,
	    "created_at" => date("Y-m-d H:i:s"),
	    "stream_id_response" => $return['id'],
	    "post_id" => $post_id,
	    "created_by" => $this->session->userdata('user_id'),
	    "log_text" => $comment,
	    "case_id"=> $case_id,
	);
	
        $this->account_model->CreateFbPMAction($action);
	$page_reply = array(
	    "case_id" => $this->input->post('case_id') == 'null' ? null : $this->input->post('case_id'),
	    "url" => null,
	    "message" => $comment,
	    "social_stream_post_id" => $post_id,
	    "conversation_detail_id" => null,
	    "post_at" => date("Y-m-d H:i:s"),
	    "created_at" => date("Y-m-d H:i:s"),
	    "product_id" => $this->input->post('product_id') == 0 ? NULL : $this->input->post('product_id'),
	    "user_id" => $this->session->userdata('user_id')
	);
	$this->account_model->CreateReplyAction($page_reply);
        $case = $this->account_model->isCaseIdExists($post_id);
	if(count($case)>0){
	    $post_at=$case[0]->created_at;  
	    $caseid=$case[0]->case_id;
	}else{
	    $caseid='';
	    $post_at='';       
	}
	$action['created_at'] = new DateTime($action['created_at']);
	$action['created_at']->setTimezone(new DateTimeZone($this->session->userdata('timezone')));
	$action['created_at'] = $action['created_at']->format("j-M-Y h:i A");
        echo json_encode(
	    array(
		'success' => true,
		'message' => "Successfully done",
		'result' => $return,
		'action_log' => $action
	    )
	);
    }
    
 
    public function fbDeleteStatus($status = 0){
        
    	header("Content-Type: application/x-json");
    	$action['channel_id'] = $this->input->post('channel_id');
    	$action['post_id'] = $this->input->post('post_id');
    	$action['created_by'] = $this->session->userdata('user_id');

    	if($status == 0){
            $facebook_data=$this->facebook_model->RetrieveFeedFB(array('b.post_id' => $this->input->post('post_id')));
    	}elseif($status == 1){
    	    $facebook_data = $this->facebook_model->RetrievePmFB(array('a.post_id' => $this->input->post('post_id')));
        }else{
            $facebook_data = $this->facebook_model->RetriveCommentPostFb(array('b.id' => $this->input->post('post_id')),array());
        }
    	if(count($facebook_data) > 0){        
    	    $facebook_data = $facebook_data[0];
            $channel = $this->account_model->GetChannel(array(
    		'channel_id' => $this->input->post('channel_id')
    	    ));
    	    
    	    if(count($channel) == 0){
        		echo json_encode(
        		    array(
        			'success' => false,
        			'message' => "Invalid Channel Id"
        		    )
        		);return;
    	    }else{
                $config = array(
		    'appId' => $this->config->item('fb_appid'),
		    'secret' => $this->config->item('fb_secretkey')
		 );
                $is_Post_id=$this->facebook_model->streamId($action['post_id']);
                if($is_Post_id){
                    $newStd = new stdClass();
                    $newStd->page_id =  $channel[0]->social_id;
                    $newStd->token = $this->facebook_model->GetPageAccessToken( $channel[0]->oauth_token, $channel[0]->social_id);
                    $this->load->library('facebook',$config);
                    $this->facebook->setaccesstoken($newStd->token);
                    $result = $this->facebook->api( "/".$is_Post_id->post_stream_id."","delete");
                   
                   
                    if(isset($result)){
            		if($status == 0){//wallpost
                          $row_affected = $this->facebook_model->DeletePostFb($is_Post_id->post_stream_id,$channel[0]->channel_id,
               			  $this->session->userdata('user_id') == 0 ? NULL : $this->session->userdata('user_id'),0);
            		}
			else if($status == 1)
                          $row_affected = $this->facebook_model->DeletePostFb($is_Post_id->post_stream_id,$channel[0]->channel_id,
               			  $this->session->userdata('user_id') == 0 ? NULL : $this->session->userdata('user_id'),1);
			else
                          $row_affected = $this->facebook_model->DeletePostFb($is_Post_id->post_stream_id,$channel[0]->channel_id,
               			  $this->session->userdata('user_id') == 0 ? NULL : $this->session->userdata('user_id'),2);
			  
			
                        echo json_encode(
                	 		array(
                			    'success' => true,
                			    'message' => "Facebook data was sucessfully deleted.",
                			    'result' => $result,
                			    'row_affected' => $row_affected
                			)
                        );                                
            	    }else{
            		     echo json_encode(
                		    array(
                			'success' => false,
                			'message' => "Delete Facebook was failed.",
                			'result' => 'ok'//$result
                			)
            		      );
            		}
            		return;
         	    }
            }   
        }else{	
            echo json_encode(
            array(
            		    'success' => false,
            		    'message' => "Invalid POST_ID"
            		)
            	);	    
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
	
	$image_to_post = '';
	if($this->input->post('image') != ''){
            $this->load->helper('file');
            $img = $this->input->post('image');
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace('data:image/jpeg;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            $file_name = uniqid().'.png';
            $pathToSave = $this->config->item('assets_folder').$file_name;
            if ( ! write_file($pathToSave, $data)){
                $image_to_post = '';
            }
	    else{
		$image_to_post = $pathToSave;
	    }
	}
	
	if($this->input->post('short_url') != ''){
	    $this->load->model('shorturl_model');
	    $short_url = $this->shorturl_model->find(array('short_code' => $this->input->post('short_url')));
	    $short_url_id = $short_url->id;
	}
	else{
	    $short_url_id = NULL;
	}
	
	$this->post_model->InsertPost($this->input->post('content'),
				      $this->input->post('channels'),
				      $this->input->post('tags'),
				      $image_to_post,
				      $short_url_id,
				      $this->input->post('title'),
				      $this->input->post('description'),
				      $this->input->post('email_me'),
				      $compose_date_hour);
	curl_get_file_contents(base_url("cronjob/TwitterUserTimeline"));
	curl_get_file_contents(base_url("cronjob/FacebookStreamFeed"));
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
    	   'a.channel_id' => $channel_id,
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
	$filter_user['country_code'] = IsRoleFriendlyNameExist($this->user_role, 'Regional_User') ? NULL : $this->session->userdata('country');
	$data['user_list'] = $this->case_model->ReadAllUser($filter_user);
        
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
        
        if($action=='user_timeline'){
        	$filter['b.type'] = 'user_timeline';
        	$data['senttweets']=$this->twitter_model->ReadTwitterData($filter,$limit);
            $data['countTweets']=$this->twitter_model->CountTwitterData($filter);
             $this->load->view('dashboard/twitter/twitter_senttweets.php',$data);

        }
        if($action=='direct'){
            $filter['a.channel_id']=$channel_ids;
            $data['directmessage']=$this->twitter_model->ReadDMFromDb($filter,$limit);
            $data['countDirect']=$this->twitter_model->CountTwitterData($filter);
            $data['channel_id'] = $channel_id;
            $this->load->view('dashboard/twitter/twitter_messages.php',$data);

        }
        if($action=='wallPosts'){
	    unset($filter['a.channel_id']);
	    $filter['channel_id']=$channel_ids;
             $data['fb_feed'] = $this->facebook_model->RetrieveFeedFB($filter,$limit);
             $data['count_fb_feed']=$this->facebook_model->CountFeedFB($filter);
             $this->load->view('dashboard/facebook/wall_post.php',$data);
        }
        
        if($action=='privateMessages'){
	    unset($filter['a.channel_id']);
            $filter['c.channel_id']=$channel_ids;
            $data['fb_pm'] = $this->facebook_model->RetrievePmFB($filter,$limit);
            $data['CountPmFB']=$this->facebook_model->CountPmFB($filter);
            $this->load->view('dashboard/facebook/private_message.php',$data);
        }
    }
    
    public function SinglePost($post_id){
	$post = $this->facebook_model->streamId($post_id);
	$this->load->model('case_model');
	$filter_user['country_code'] = IsRoleFriendlyNameExist($this->user_role, 'Regional_User') ? NULL : $this->session->userdata('country');
	$data['user_list'] = $this->case_model->ReadAllUser($filter_user);
        
        $this->load->model('campaign_model');
        $data['product_list'] = $this->campaign_model->GetProduct();
	$data['no_load_more'] = true;
	if($post->type == "twitter"){
	    $filter['a.post_id'] = $post->post_id;
            $data['mentions']=$this->twitter_model->ReadTwitterData($filter,1);
            $data['countMentions']=$this->twitter_model->CountTwitterData($filter);
	    $this->load->view('dashboard/twitter/twitter_mentions.php',$data);
	    
	}
	else if($post->type == "facebook"){
	    $filter['c.post_id'] = $post->post_id;
            $data['fb_feed'] = $this->facebook_model->RetrieveFeedFB($filter,1);
            $data['count_fb_feed']=$this->facebook_model->CountFeedFB($filter);
	    
            $this->load->view('dashboard/facebook/wall_post.php',$data);
	}
	
    }
    
    public function GetUrlPreview(){
	if (!isset($_GET['url'])) die();
	$url = urldecode($_GET['url']);
	$url = 'http://' . str_replace('http://', '', $url); // Avoid accessing the file system
	echo file_get_contents($url);
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
				    "description" => $this->input->post('description'),
				    'increment' => 0)));
    }
    
    public function GetAllTags(){
	$this->load->model('tag_model');
	echo json_encode($this->tag_model->get());
    }
    
    public function GetScheduleData(){
	$this->load->model('post_model');
	$filter = 'is_posted is NULL or is_posted=1';
	$posts = $this->post_model->GetPosts($filter);
	
	$encodeme = array();
	foreach($posts as $post){
	    if($post->time_to_post != NULL){
		$time_to_post = explode(' ',$post->time_to_post);
		$post_date = $time_to_post[0];
		$post_time = $time_to_post[1];
		
		$short_date = explode('-',$post_date);
		$new_short_date = $short_date[2].'/'.$short_date[1];
		
		$short_time = date('H:i A',strtotime($post_time));
		
		$time_tommorow = date('Y-m-d H:i:s',strtotime('+30 minute', strtotime($post->time_to_post)));
		if(IsRoleFriendlyNameExist($this->user_role, "Publisher_Current_Delete_Post") ||
		   IsRoleFriendlyNameExist($this->user_role, "Publisher_All_Delete_Post")){
		    $deleteable = true;
		}else{
		    $deleteable = false;
		}
		
		$encodeme[] = array('post_to_id' => $post->post_to_id,
				'real_time' => $post->time_to_post,
				'title' => $post->name,
				'start' => date('c',strtotime($post->time_to_post)),
				'end' => date('c',strtotime($time_tommorow)),
				'description' => $post->messages,
				'user_name' => $post->display_name,
				'post_date' => $new_short_date,
				'post_time' => $short_time,
				'is_posted' => $post->is_posted,
				'allDay' => false,
				'user_role' =>  $this->session->userdata('role_name'),
				'deleteable' => $deleteable
			       );
	    }
	}
        echo json_encode($encodeme);
    }

    public function DeleteSchedulePost(){
	$this->load->model('post_model');
	$value = array('is_posted' => 2);
	$this->post_model->UpdatePostTo($this->input->post('post_to_id'),$value);
    }
    
    public function SafePhoto(){
	$safe_photo = $this->input->cookie("safe_photo");
	if(!$safe_photo){
	    $cookie = array(
		'name'   => 'safe_photo',
		'value'  => time(),
		'expire' => '3600',
		//'domain' => $_SERVER['HTTP_HOST'],
		'path'   => '/',
		'secure' => FALSE
	    );
	    $this->input->set_cookie($cookie);
	}
	
	$md5_photo = md5($this->input->get('photo')).".jpg";
	
	if(!is_dir("./media/dynamic/tmp_photo/"))
	    mkdir(getcwd()."/media/dynamic/tmp_photo/");
	    
	if(file_exists("./media/dynamic/tmp_photo/".$md5_photo) && $safe_photo)
	    redirect("/media/dynamic/tmp_photo/".$md5_photo);
	else{
	    file_put_contents("./media/dynamic/tmp_photo/".$md5_photo, file_get_contents(urldecode($this->input->get('photo'))));
	    redirect("/media/dynamic/tmp_photo/".$md5_photo);    
	}
	
    }
}
