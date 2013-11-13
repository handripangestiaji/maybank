<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('facebook_model');
	}

	public function index()
	{
		$access_token = "CAACEdEose0cBADGyv9cLrxG0ycGrwyZBVrr4jPSG4NKHAZAZBwQS5MF1xrYdgwAiyCLZAnYvx1wBvr5I7MGxVsubO0xPMOIaYhVKsTTeVPvC05YLYfUttS0W3SzfC3wFltkY3Lo11zfH7LTVwF6zwADlv9HlAY7ZBinMshTHMM5dYxeY3ZA6bSY5zSNsDOFOsmE6bb5cbjiQZDZD";
		$data['fb_feed'] =  $this->facebook_model->RetrieveFeedFacebook('168151513217686', $access_token, "feed");
		$this->load->view('dashboard/index', $data);
	}
	
	public function load_facebook($type){
		$access_token = "CAACEdEose0cBAFGdZB2IH8VzRiPuoLAZC0vQ3u7Tc0PuZAyycV0cs5CCng8Xw3qnni9V6YxgeaQ0p9VCdGzfGGHTeUUsLL6exlGXBTAbWl6T7573l4DnKm3kTPh7dQrqqJNpcvMMWZA9K92p7NtS5eLwjmZCKxZCCEQ4jWk5DtccZBMZAEKS2Meqe1yzhetcUKMZD";
		
		print_r($this->facebook_model->RetrieveFeedFacebook('gizikudotcom', $access_token, $type));
	}
}