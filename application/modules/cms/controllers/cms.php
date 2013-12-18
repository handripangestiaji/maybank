<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cms extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('Shorturl', 'ciqrcode'));
		$this->load->model(array('tag_model', 'product_model', 'campaign_model', 'shorturl_model', 'campaign_url_model'));
		$this->load->helper('form');
		$this->load->library('form_validation');
	}

    public function index()
    {
    	$data['campaigns'] = $this->campaign_model->getAllArray();
    	
    	$data['products'] = $this->product_model->get();
    	
    	$data['tags'] = $this->tag_model->get();
    	
    	$data['urls'] = '';
    	
        $data['cms_view'] = 'campaign_table';
        
        $this->load->view('cms/index',$data);
    }
     
    public function create_campaign()
    {
    	$data['campaigns'] = $this->campaign_model->getAllArray();
    	
    	$data['products'] = $this->product_model->get();
    	
    	$data['tags'] = $this->tag_model->get();
    	
		$data['urls'] = '';
    	
        $data['cms_view'] = 'create_campaign';
        
        $action = $this->input->get('action');
        
        if ($this->input->server('REQUEST_METHOD') === "POST")
        {
	        $campaigns = array();
	        
	        $campaigns = $this->input->post('campaign');
	        $campaigns['user_id'] = $this->session->userdata('user_id');
	        
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
    	
    	$data['campaigns'] = '';
    	
    	$data['products'] = '';
    	
    	$data['tags'] = $this->tag_model->get();
    	
    	$data['urls'] = '';
    	
    	$action = $this->input->get('action');
    	
        $data['cms_view'] = 'create_tag';
        
        if ($this->input->server('REQUEST_METHOD') === "POST")
        {
	        $arr = array();
	        $arr['tag_name'] = $this->input->post('tag_name');
	        $arr['user_id'] = $this->session->userdata('user_id');
	        
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
     
    public function create_short_url()
    {
    	$data['campaigns'] = $this->campaign_model->get();
    	
    	$data['products'] = '';
    	
    	$data['tags'] = '';
    	
    	$data['urls'] = $this->campaign_url_model->get();
    	
    	$action = $this->input->get('action');
    
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{
			$params = array();
			$params = $this->input->post('shorturl');
			$params['user_id'] = $this->session->userdata('user_id');
			
			$config = array(
						array(
							'field' => 'shorturl[long_url]',
							'label' => 'Full Url',
							'rules' => 'required'
						),
						array(
							'field' => 'shorturl[short_code]',
							'label' => 'Full Url',
							'rules' => 'required|max_length[6]'
						)
					);
			
			$this->form_validation->set_rules($config);
			
			if($this->form_validation->run() == TRUE)
			{
				$code = $this->shorturl->urlToShortCode($params);
				
				if(isset($code['message']))
				{
			        $this->session->set_userdata('message', $code['message']);
				}
				else
				{
					$this->session->unset_userdata('message');
				}
				
				$setparam = array(
								"campaign_id" => $params['campaign_id'], 
								"url_id" => $code['url_id'],
								"user_id" => $params['user_id']
							);
			 
				$id_campaign_url = $this->campaign_url_model->insert($setparam);
			}
			redirect('cms/create_short_url');			
		}
		else if ($action == "delete")
		{
			$id = $this->input->get("id");
			
			$this->campaign_url_model->delete($id);
			
			$this->session->unset_userdata('message');
			
			redirect('cms/create_short_url');
		}
		else {
			$this->session->unset_userdata('message');
		}
		
		$data['code'] = substr( md5( time().uniqid().rand() ), 0, 6 );
        $data['cms_view'] = 'create_short_url';
        $this->load->view('cms/index',$data);
    }
     
    public function create_product()
    {
    	$data['campaigns'] = '';
    	
    	$data['tags'] = '';
    	
    	$data['products'] = $this->product_model->get();
    	
    	$data['urls'] = '';
    	
    	$action = $this->input->get('action');
        
        $data['cms_view'] = 'create_product';
        
        if ($this->input->server('REQUEST_METHOD') === "POST")
        {
        	$params = array();
	        $params = $this->input->post('product');
	        $params['user_id'] = $this->session->userdata('user_id');
	        	        
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
    
    public function url()
    {
	    $c = $this->uri->segment(3);
	    
	    if($c)
	    {
		    try {
			    $url = $this->shorturl->shortCodeToUrl($c);
			    redirect($url);
			    exit;
		    } catch (Exception $e) {
			    redirect('cms/create_short_url');
		    }
	    }
	    
    }
}