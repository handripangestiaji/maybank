<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ChannelMg extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('facebook_model');
        $this->load->library("Twitteroauth");
        $this->load->model('account_model');
    }
    
    function index(){
        $data['result'] = array();
        $this->load->view("channels/index");
    }
    
    function AddFacebook(){
        
    }
    
    function AddTwitter(){
        // Making a request for request_token
        
        $connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'),
                                                  $this->config->item('twitter_consumer_secret'));
        
        $request_token = $connection->getRequestToken(site_url('channels/channelmg/TokenTwitter'));
        //print_r($connection);
        $this->session->set_userdata('request_token', $request_token['oauth_token']);
        $this->session->set_userdata('request_token_secret', $request_token['oauth_token_secret']);
        if($connection->http_code == 200)
        {
            $url = $connection->getAuthorizeURL($request_token);
            redirect($url);
        }
        else
        {
            // An error occured. Make sure to put your error notification code here.
            redirect(base_url('/error_page_faild_auth'));
        }
    }
    
    public function TokenTwitter()
    {
        $connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'),
                                                  $this->config->item('twitter_consumer_secret'),
                                                  $this->session->userdata('request_token'),
                                                  $this->session->userdata('request_token_secret'));
        $access_token = $connection->getAccessToken($this->input->get('oauth_verifier'));
        if ($connection->http_code == 200)
        {
            
            $this->session->unset_userdata('request_token');
            $this->session->unset_userdata('request_token_secret');
            print_r($access_token);
        }
    }
}