<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {

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
		
		$this->session->set_userdata('access_token', $this->config->item('twitter_access_token'));
		$this->session->set_userdata('access_token_secret', $this->config->item('twitter_access_secret'));
        
		if($this->session->userdata('access_token') && $this->session->userdata('access_token_secret'))
		{
			// If user already logged in
			$this->connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'), $this->config->item('twitter_access_token'),  $this->config->item('twitter_access_secret'));
		}
		elseif($this->session->userdata('request_token') && $this->session->userdata('request_token_secret'))
		{
			// If user in process of authentication
			$this->connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'), $this->session->userdata('request_token'), $this->session->userdata('request_token_secret'));
		}
		else
		{
			// Unknown user
			$this->connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'));
		}
    }
    
    
	public function index()
	{
     	redirect('dashboard/socialmedia');   
	}
	
	public function auth()
	{
		
		if($this->session->userdata('access_token') && $this->session->userdata('access_token_secret'))
		{
			// User is already authenticated.
			  $data['twiteerAction']=$this->connection->get('statuses/home_timeline');   
			 $this->load->view('dashboard/index',$data);
		}
		else
		{
			// Making a request for request_token
			$request_token = $this->connection->getRequestToken(base_url('/index.php/dashboard/callback'));
			$this->session->set_userdata('request_token', $request_token['oauth_token']);
			$this->session->set_userdata('request_token_secret', $request_token['oauth_token_secret']);
			if($this->connection->http_code == 200)
			{
				$url = $this->connection->getAuthorizeURL($request_token);
				redirect($url);
			}
			else
			{
				// An error occured. Make sure to put your error notification code here.
				redirect(base_url('/error_page_faild_auth'));
			}
		}
	}
        
	public function callback()
	{
		if($this->input->get('oauth_token') && $this->session->userdata('request_token') !== $this->input->get('oauth_token'))
		{
				$this->reset_session();
				redirect('/dashboard/auth');
		}
		else
		{
			$access_token = $this->connection->getAccessToken($this->input->get('oauth_verifier'));
	
			if ($this->connection->http_code == 200)
			{
				$this->session->set_userdata('access_token', $access_token['oauth_token']);
				$this->session->set_userdata('access_token_secret', $access_token['oauth_token_secret']);
				$this->session->set_userdata('twitter_user_id', $access_token['user_id']);
				$this->session->set_userdata('twitter_screen_name', $access_token['screen_name']);
				$this->session->unset_userdata('request_token');
				$this->session->unset_userdata('request_token_secret');
				redirect('dashboard');
			}
			else
			{
				// An error occured. Add your notification code here.
				redirect(base_url('/page_error_callback'));
			}
		}
	}

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
	
	public function load_facebook($type){
		$access_token = "CAACEdEose0cBAFGdZB2IH8VzRiPuoLAZC0vQ3u7Tc0PuZAyycV0cs5CCng8Xw3qnni9V6YxgeaQ0p9VCdGzfGGHTeUUsLL6exlGXBTAbWl6T7573l4DnKm3kTPh7dQrqqJNpcvMMWZA9K92p7NtS5eLwjmZCKxZCCEQ4jWk5DtccZBMZAEKS2Meqe1yzhetcUKMZD";
		
		print_r($this->facebook_model->RetrieveFeedFacebook('gizikudotcom', $access_token, $type));
	}
    
	/**
	 * Reset session data
	 * @access	private
	 * @return	void
	 */
     
	public function reset_session()
	{
		$this->session->unset_userdata('access_token');
		$this->session->unset_userdata('access_token_secret');
		$this->session->unset_userdata('request_token');
		$this->session->unset_userdata('request_token_secret');
		$this->session->unset_userdata('twitter_user_id');
		$this->session->unset_userdata('twitter_screen_name');
	}
}