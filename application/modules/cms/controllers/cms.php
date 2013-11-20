<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cms extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Shorturl');
		$this->load->model(array('tag_model', 'product_model', 'campaign_model'));
		$this->load->helper('form');
		$this->load->library('form_validation');
	}

    public function index()
    {
        $data['cms_view'] = 'campaign_table';
        $this->load->view('cms/index',$data);
    }
     
    public function create_campaign()
    {
    	$data['campaigns'] = $this->campaign_model->getAllArray();
    	
    	$data['products'] = $this->product_model->get();
    	
    	$data['tags'] = $this->tag_model->get();
    	
        $data['cms_view'] = 'create_campaign';
        
        $action = $this->input->get('action');
        
        if ($this->input->server('REQUEST_METHOD') === "POST")
        {
	        $campaigns = array();
	        
	        $campaigns = $this->input->post('campaign');
	        $campaigns['user_id'] = "1";
	        
	        $products_id = $this->input->post('products_id');
	        $tags = $this->input->post('tag_id');
	        
/*
	        echo "<pre>";
	        die(print_r($tags));
*/
	        
	        $this->form_validation->set_rules('campaign[campaign_name]', 'Campaign Name', 'required|xss_clean');
	        
	        if ($this->form_validation->run() == TRUE)
	        {
		        $this->campaign_model->insert($campaigns, $products_id, $tags);
	        }
	        else 
	        {
		        $this->session->set_flashdata('message_type', 'error');
		        $this->session->set_flashdata('message_body', 'Please Insert Campaign Parameters');
	        }
	        
	        redirect('cms/create_campaign');
        }
        
        if($action == 'delete')
        {
	        $id = $this->input->get('id');
	        
	        if ($id)
	        {
		       $this->campaign_model->delete($id);
	        }
	        
	        redirect('cms/create_campaign');
        }
        
        $this->load->view('cms/index',$data);
    }
     
    public function create_tag(){
    	
    	$data['tags'] = $this->tag_model->get();
    	$action = $this->input->get('action');
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
        
        if ($action == 'delete')
        {
	        $id = $this->input->get('id');
	        
	        if ($id)
	        {
		       $this->tag_model->delete($id);
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
     
    public function create_product()
    {
    	$data['products'] = $this->product_model->get();
    	$action = $this->input->get('action');
        $data['cms_view'] = 'create_product';
        
        if ($this->input->server('REQUEST_METHOD') === "POST")
        {
        	$params = array();
	        $params = $this->input->post('product');
	        $params['user_id'] = "1";
	        	        
	        $this->form_validation->set_rules('product[product_name]', 'Product Name', 'required|xss_clean');
	        
	        if ($this->form_validation->run() == TRUE)
	        {
		        $this->product_model->insert($params);
	        }
	        else 
	        {
		        $this->session->set_flashdata('message_type', 'error');
		        $this->session->set_flashdata('message_body', 'Please insert Tag name');
	        }
	        redirect('cms/create_product');
        }
        
        if ($action == 'delete')
        {
	        $id = $this->input->get('id');
	        
	        if ($id)
	        {
		       $this->product_model->delete($id);
	        }
	        
	        redirect('cms/create_product');
        }
        
        $this->load->view('cms/index',$data);
    }
}