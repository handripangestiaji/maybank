<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {

     private $connection;
	   
    function __construct()
	{
		parent::__construct();
		// Loading TwitterOauth library. 
		$this->config->load('twitter');
		$this->load->library('ion_auth');
		$this->load->library('Twitteroauth');
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('array');
        
                if($this->session->userdata('access_token') && $this->session->userdata('access_token_secret'))
                {
                        // If user already logged in
                        $this->connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'), $this->session->userdata('access_token'),  $this->session->userdata('access_token_secret'));
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
		$data['mention_twitter']=$this->connection->get('statuses/mentions_timeline');   
		$data['user_twitter']=$this->connection->get('statuses/user_timeline');   
		$data['home_twitter']=$this->connection->get('statuses/home_timeline');   
		$data['retweets_twitter']=$this->connection->get('statuses/retweets_of_me');   
		$this->load->view('dashboard/index',$data);
		$this->load->model('facebook_model');
	}
    
      public function auth()
        {
                if($this->session->userdata('access_token') && $this->session->userdata('access_token_secret'))
                {
                        // User is already authenticated.
                         $data['mention_twitter']=$this->connection->get('statuses/mentions_timeline');   
                         $data['user_twitter']=$this->connection->get('statuses/user_timeline');   
                         $data['home_twitter']=$this->connection->get('statuses/home_timeline');   
                         $data['retweets_twitter']=$this->connection->get('statuses/retweets_of_me');   
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
                        redirect(base_url('/index.php/dashboard/auth'));
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
                                
                                
                                redirect(base_url('/index.php/dashboard/mentions'));
                        }
                        else
                        {
                                // An error occured. Add your notification code here.
                                redirect(base_url('/page_error_callback'));
                        }
                }
        }
    
	public function mentions()
	{
	    $data['mention_twitter']=$this->connection->get('statuses/mentions_timeline');   
        $data['user_twitter']=$this->connection->get('statuses/user_timeline');   
        $data['home_twitter']=$this->connection->get('statuses/home_timeline');   
        $data['retweets_twitter']=$this->connection->get('statuses/retweets_of_me');   

        $data['mention']=$this->connection->get('statuses/public_timeline');   
        $this->load->view('dashboard/mention',$data);
		$access_token = "CAACEdEose0cBADGyv9cLrxG0ycGrwyZBVrr4jPSG4NKHAZAZBwQS5MF1xrYdgwAiyCLZAnYvx1wBvr5I7MGxVsubO0xPMOIaYhVKsTTeVPvC05YLYfUttS0W3SzfC3wFltkY3Lo11zfH7LTVwF6zwADlv9HlAY7ZBinMshTHMM5dYxeY3ZA6bSY5zSNsDOFOsmE6bb5cbjiQZDZD";
		$data['fb_feed'] =  $this->facebook_model->RetrieveFeedFacebook('168151513217686', $access_token, "feed");
		$this->load->view('dashboard/index', $data);
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