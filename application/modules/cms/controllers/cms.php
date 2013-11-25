<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cms extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Shorturl');
	}

    public function index()
    {
        $data['cms_view'] = 'campaign_table';
        $this->load->view('cms/index',$data);
    }
     
    public function create_campaign(){
        $data['cms_view'] = 'create_campaign';
        $this->load->view('cms/index',$data);
    }
     
    public function create_tag(){
        $data['cms_view'] = 'create_tag';
        $this->load->view('cms/index',$data);
    }
     
    public function create_short_url(){
    
		try {
			$code = $this->shorturl->urlToShortCode("https://bitbucket.org/yolkatgrey/maybank/commits/2643205aec5b0079278a20a2b0bfdfdd04584b96?at=master");
		}
		catch (Exception $e)
		{
			print_r("Error create short url");
			die();
		}
		$data['code'] = $code;
        $data['cms_view'] = 'create_short_url';
        $this->load->view('cms/index',$data);
    }
     
    public function create_product(){
        $data['cms_view'] = 'create_product';
        $this->load->view('cms/index',$data);
    }
}