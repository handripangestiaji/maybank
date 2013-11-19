<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cms extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Shorturl');
		$this->load->model(array('tag_model'));
		$this->load->helper('form');
		$this->load->library('form_validation');
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
    	
    	$data['tags'] = $this->tag_model->get();
        $data['cms_view'] = 'create_tag';
        
        if ($this->input->server('REQUEST_METHOD') === "POST")
        {
	        $arr = array();
	        $arr['tag_name'] = $this->input->post('tag_name');
	        $arr['user_id'] = "1";
	        
	        $this->form_validation->set_rules('tag_name', 'Tag Name', 'required|xss_clean');
	        
	        if ($this->form_validation->run() == TRUE)
	        {
		        $this->tag_model->insert($arr);
	        }
	        else 
	        {
		        $this->session->set_flashdata('message_type', 'error');
		        $this->session->set_flashdata('message_body', 'Please insert Tag name');
	        }
	        redirect('cms/create_tag');
        }
        
        $this->load->view('cms/index',$data);
    }
     
    public function create_short_url(){
    	$code = "";
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