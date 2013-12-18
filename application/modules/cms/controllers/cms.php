<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cms extends MY_Controller {
     
     public $user_role;
	public function __construct()
	{
		parent::__construct();
                $this->load->model('users_model');
		$this->load->library(array('Shorturl', 'ciqrcode'));
		$this->load->model(array('tag_model', 'product_model', 'campaign_model', 'shorturl_model', 'campaign_url_model'));
		$this->load->helper('form');
		$this->load->library('form_validation');
                $this->user_role=$this->users_model->get_collection_detail(
                                        array('role_collection_id'=>$this->session->userdata('role_id')));
	}

    public function index()
    {
     if(IsRoleFriendlyNameExist($this->user_role,'Content Management_Campaign_View')||IsRoleFriendlyNameExist($this->user_role,'Content Management_Short_URL_View')
        ||IsRoleFriendlyNameExist($this->user_role,'Content Management_Product_View')||IsRoleFriendlyNameExist($this->user_role,'Content Management_TAG_View'))
     {
     	$config['base_url'] = site_url('cms/index');
		
		$config['total_rows'] = $this->tag_model->count_record();
		
		$config['per_page'] = 10;
		
		$config["uri_segment"] = 3;
	  
		$config['next_link'] = 'Next';
	  
		$config['prev_link'] = 'Prev';
	  
		$config['first_link'] = 'First';
	  
		$config['last_link'] = 'Last';
     
		$config['cur_tag_open'] = '<b style="margin:0px 5px;">';
	  
		$config['cur_tag_close'] = '</b>';
	  
		$this->pagination->initialize($config);
		
		$offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
    	$data['campaigns'] = $this->campaign_model->getAllArray($config['per_page'], $offset);
    	
    	$data['pagination'] = $this->pagination->create_links();
    	
    	$data['products'] = $this->product_model->get();
    	
    	$data['tags'] = $this->tag_model->get();
    	
    	$data['urls'] = '';
    	
        $data['cms_view'] = 'campaign_table';
        
        $this->load->view('cms/index',$data);
     }
     else
     {
          redirect('dashboard');
     }
    }
     
    public function create_campaign()
    {
     if(IsRoleFriendlyNameExist($this->user_role,'Content Management_Campaign_View'))
     {
     	$config['base_url'] = site_url('cms/create_campaign');
		
		$config['total_rows'] = $this->tag_model->count_record();
		
		$config['per_page'] = 10;
		
		$config["uri_segment"] = 3;
	  
		$config['next_link'] = 'Next';
	  
		$config['prev_link'] = 'Prev';
	  
		$config['first_link'] = 'First';
	  
		$config['last_link'] = 'Last';
     
		$config['cur_tag_open'] = '<b style="margin:0px 5px;">';
	  
		$config['cur_tag_close'] = '</b>';
	  
		$this->pagination->initialize($config);
		
		$offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
     	
    	$data['campaigns'] = $this->campaign_model->getAllArray($config['per_page'], $offset);
    	
    	$data['pagination'] = $this->pagination->create_links();
    	
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
     else
     {
          redirect('cms');
     }
    }
     
    public function create_tag(){
     if(IsRoleFriendlyNameExist($this->user_role,'Content Management_TAG_View'))
     {
    	$data['campaigns'] = '';
    	
    	$data['products'] = '';
    	
    	$data['urls'] = '';
    	
    	$config['base_url'] = site_url('cms/create_tag');
		
		$config['total_rows'] = $this->tag_model->count_record();
		
		$config['per_page'] = 10;
		
		$config["uri_segment"] = 3;
	  
		$config['next_link'] = 'Next';
	  
		$config['prev_link'] = 'Prev';
	  
		$config['first_link'] = 'First';
	  
		$config['last_link'] = 'Last';
     
		$config['cur_tag_open'] = '<b style="margin:0px 5px;">';
	  
		$config['cur_tag_close'] = '</b>';
	  
		$this->pagination->initialize($config);
		
		$offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
    	
    	$data['tags'] = $this->tag_model->get($config['per_page'], $offset);
    	
    	$data['pagination'] = $this->pagination->create_links();
    	
    	$action = $this->input->get('action');
    	
        $data['cms_view'] = 'create_tag';
        
        if ($this->input->server('REQUEST_METHOD') === "POST")
        {
          if(IsRoleFriendlyNameExist($this->user_role,'Content Management_TAG_Create')){
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
          else
          {
               redirect('cms/create_tag');
          }
        }
        
        if ($action == 'delete')
        {
          if(IsRoleFriendlyNameExist($this->user_role,'Content Management_TAG_Delete')){
	        $id = $this->input->get('id');
	        
	        if ($id)
	        {
		       $this->tag_model->delete($id);
	        }
	        
	        redirect('cms/create_tag');
          }
          else
          {
               redirect('cms/create_tag');
          }
        }
        
        $this->load->view('cms/index',$data);
     }
     else
     {
          redirect('cms');
     }
    }
     
    public function create_short_url()
    {
     if(IsRoleFriendlyNameExist($this->user_role,'Content Management_Short_URL_View'))
     {
    	$data['campaigns'] = $this->campaign_model->get();
    	
    	$data['products'] = '';
    	
    	$data['tags'] = '';
    	
    	
    	// First Tab -----------------------------------------
    	$cfg['base_url'] = site_url('cms/create_short_url');
		
		$cfg['total_rows'] = $this->campaign_url_model->count_record();
		
		$cfg['per_page'] = 10;
		
		$cfg["uri_segment"] = 3;
	  
		$cfg['next_link'] = 'Next';
	  
		$cfg['prev_link'] = 'Prev';
	  
		$cfg['first_link'] = 'First';
	  
		$cfg['last_link'] = 'Last';
     
		$cfg['cur_tag_open'] = '<b style="margin:0px 5px;">';
	  
		$cfg['cur_tag_close'] = '</b>';
		
		$cfg['suffix'] = '/firstTab';
		
		$cfg['first_url'] = site_url('cms/create_short_url/0/firstTab');
	  
		$this->pagination->initialize($cfg);
		
		$offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

    	$data['urls'] = $this->campaign_url_model->get($cfg['per_page'], $offset);
    		
    	$data['links'] = $this->pagination->create_links();
    	
    	// End of First Tab ------------------------------------
    	
    	// Second Tab ------------------------------------------
    	
    	$config['base_url'] = site_url('cms/create_short_url');
		
		$config['total_rows'] = $this->shorturl_model->count_record();
		
		$config['per_page'] = 10;
		
		$config["uri_segment"] = 3;
	  
		$config['next_link'] = 'Next';
	  
		$config['prev_link'] = 'Prev';
	  
		$config['first_link'] = 'First';
	  
		$config['last_link'] = 'Last';
     
		$config['cur_tag_open'] = '<b style="margin:0px 5px;">';
	  
		$config['cur_tag_close'] = '</b>';
		
		$config['suffix'] = '/secondTab';
		
		$config['first_url'] = site_url('cms/create_short_url/0/secondTab');
	  
		$this->pagination->initialize($config);
		
		$offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
    	
    	$data['shorturls'] = $this->shorturl_model->get($config['per_page'], $offset);
    	
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
        $data['pagination'] = $this->pagination->create_links();
        $this->load->view('cms/index',$data);
     }
     else
     {
          redirect('cms');
     }
    }
     
    public function create_product()
    {
     if(IsRoleFriendlyNameExist($this->user_role,'Content Management_Product_View'))
     {
    	$data['campaigns'] = '';
    	
    	$data['tags'] = '';
    	
    	$data['urls'] = '';
    	
    	$config['base_url'] = site_url('cms/create_product');
		
		$config['total_rows'] = $this->product_model->count_record();
		
		$config['per_page'] = 10;
		
		$config["uri_segment"] = 3;
	  
		$config['next_link'] = 'Next';
	  
		$config['prev_link'] = 'Prev';
	  
		$config['first_link'] = 'First';
	  
		$config['last_link'] = 'Last';
     
		$config['cur_tag_open'] = '<b style="margin:0px 5px;">';
	  
		$config['cur_tag_close'] = '</b>';
	  
		$this->pagination->initialize($config);
		
		$offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
    	
    	$data['products'] = $this->product_model->get($config['per_page'], $offset);
    	
    	$data['pagination'] = $this->pagination->create_links();
    	
    	$action = $this->input->get('action');
        
        $data['cms_view'] = 'create_product';
        
        if ($this->input->server('REQUEST_METHOD') === "POST")
        {
          if(IsRoleFriendlyNameExist($this->user_role,'Content Management_Product_Create'))
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
          else
          {
               redirect('cms');
          }
        }
               if ($action == 'delete')
               {
                    if(IsRoleFriendlyNameExist($this->user_role,'Content Management_Product_Delete'))
                    {
                       $id = $this->input->get('id');
                       
                       if ($id)
                       {
                              $this->product_model->delete($id);
                       }
                       
                       redirect('cms/create_product');
                    }
                    else
                    {
                        redirect('cms/create_product');
                    }
               }
               
          $this->load->view('cms/index',$data);
     }
     else
     {
          redirect('cms');
     }
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