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
     if(IsRoleFriendlyNameExist($this->user_role,'Content Management_Campaign_All_Country_View')||
	IsRoleFriendlyNameExist($this->user_role,'Content Management_Campaign_Own_Country_View')||
	IsRoleFriendlyNameExist($this->user_role,'Content Management_Short_URL_All_Country_View')||
	IsRoleFriendlyNameExist($this->user_role,'Content Management_Short_URL_Own_Country_View')||
	IsRoleFriendlyNameExist($this->user_role,'Content Management_Product_All_Country_View')||
	IsRoleFriendlyNameExist($this->user_role,'Content Management_Product_Own_Country_View')||
	IsRoleFriendlyNameExist($this->user_role,'Content Management_TAG_All_Country_View') ||
        IsRoleFriendlyNameExist($this->user_role,'Content Management_TAG_Own_Country_View'))
     {
	  $country_code = $this->session->userdata('country');
	  if($country_code != 'All'){
	       $filter = array('country_code' => $country_code);
	  }
	  else{
	       $filter = null;
	  }
	  
          $config['base_url'] = site_url('cms/index');
	  $config['total_rows'] = $this->campaign_model->count_record($filter);
	  $config['per_page'] = 10;
	  $config["uri_segment"] = 3;
	  $config['next_link'] = 'Next';
	  $config['prev_link'] = 'Prev';
	  $config['first_link'] = 'First';
	  $config['last_link'] = 'Last';
          $config['cur_tag_open'] = '<b style="margin:0px 5px;">';
	  $config['cur_tag_close'] = '</b>';
	  $this->pagination->initialize($config);
	  if($this->uri->segment(4) != "secondTab"){
               $offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
          }
          else{
               $offset = 0;
          }
	  
	  if($country_code != 'All'){
	       $filter = array('content_campaign.country_code' => $country_code);
	  }
	  else{
	       $filter = null;
	  }
	  $data['campaigns'] = $this->campaign_model->getAllArray($config['per_page'], $offset, $filter);
          $data['pagination'] = $this->pagination->create_links();
          
	  if($country_code != 'All'){
	       $filter = array('content_products.country_code' => $country_code);
	  }
	  else{
	       $filter = null;
	  }
	  $data['products'] = $this->product_model->get($filter);
          $data['tags'] = $this->tag_model->get();
          $data['urls'] = '';
          $data['cms_view'] = 'campaign_table';
        
          // Second Tab ------------------------------------------
          
	  if($country_code != 'All'){
	       $filter = array('country_code' => $country_code);
	  }
	  else{
	       $filter = null;
	  }
	  $config['base_url'] = site_url('cms/index');
          $config['total_rows'] = $this->shorturl_model->count_record($filter);
	  $config['per_page'] = 10;
	  $config["uri_segment"] = 3;
	  $config['next_link'] = 'Next';
	  $config['prev_link'] = 'Prev';
	  $config['first_link'] = 'First';
	  $config['last_link'] = 'Last';
          $config['cur_tag_open'] = '<b style="margin:0px 5px;">';
	  $config['cur_tag_close'] = '</b>';
	  $config['suffix'] = '/secondTab';
	  $config['first_url'] = site_url('cms/index/0/secondTab');
          $this->pagination->initialize($config);
	  $offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
    	
	  if($country_code != 'All'){
	       $filter = array('short_urls.country_code' => $country_code);
	  }
	  else{
	       $filter = null;
	  }
          $data['shorturls'] = $this->shorturl_model->get($config['per_page'], $offset, $filter);
          $data['pagination2'] = $this->pagination->create_links();
    	
          $this->load->view('cms/index',$data);
     }
     else
     {
          redirect('dashboard');
     }
    }
     
    public function create_campaign()
    {
     if((IsRoleFriendlyNameExist($this->user_role,'Content Management_Campaign_Own_Country_Create')) ||
	(IsRoleFriendlyNameExist($this->user_role,'Content Management_Campaign_All_Country_Create')))
	  {
	       $country_code = $this->session->userdata('country');
	       
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
	       
	       $data['tags'] = $this->tag_model->get();
	       $data['cms_view'] = 'create_campaign';
        
	       $action = $this->input->get('action');
	       if ($this->input->server('REQUEST_METHOD') === "POST")
	       {
		    $campaigns = array();
		    $campaigns = $this->input->post('campaign');
		    $campaigns['user_id'] = $this->session->userdata('user_id');
		    $campaigns['country_code'] = $this->session->userdata('country');
		    $products_id = $this->input->post('products_id');
		    $tags = $this->input->post('tag_id');
		     
		    $this->form_validation->set_rules('campaign[campaign_name]', 'Campaign Name', 'required|xss_clean');
		    $this->form_validation->set_rules('products_id', 'Products', 'required');
		    $this->form_validation->set_rules('tag_id', 'Tags', 'required');
		     
		    if ($this->form_validation->run() == TRUE)
		    {
			 $this->campaign_model->insert($campaigns, $products_id, $tags);
			 $this->session->set_flashdata('message_type', 'success');
			 $this->session->set_flashdata('message_body', 'Create campaign success');
			 redirect('cms');
		    }
		    else 
		    {
			 $this->session->set_flashdata('message_type', 'error');
			 $this->session->set_flashdata('message_body', 'Please fill the required fields'); 
			 redirect('cms/create_campaign');
		    } 
	       }       
	       $this->load->view('cms/index',$data);
	  }
	  else
	  {
	       redirect('cms');
	  }
    }
     
    public function create_tag(){
     if(IsRoleFriendlyNameExist($this->user_role,'Content Management_TAG_All_Country_View'))
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
          if(IsRoleFriendlyNameExist($this->user_role,'Content Management_TAG_All_Country_Create')){
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
		        $this->session->set_flashdata('message_body', 'Please fill the required field.');
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
          if(IsRoleFriendlyNameExist($this->user_role,'Content Management_TAG_All_Country_Delete')){
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
	  if((IsRoleFriendlyNameExist($this->user_role,'Content Management_Short_URL_Own_Country_Create')) ||
	     (IsRoleFriendlyNameExist($this->user_role,'Content Management_Short_URL_All_Country_Create')) ||
	     (IsRoleFriendlyNameExist($this->user_role,'Content Management_Campaign_Own_Country_Create')) ||
	     (IsRoleFriendlyNameExist($this->user_role,'Content Management_Campaign_All_Country_Create')))
	  {
	       $country_code = $this->session->userdata('country');
	       
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
 	       
	       if($country_code != 'All'){
		    $filter = array('content_campaign.country_code' => $country_code);
	       }
	       else{
		    $filter = null;
	       }
	       $data['campaigns'] = $this->campaign_model->get($filter);
	       $data['tags'] = $this->tag_model->get();
	       $data['code'] = substr( md5( time().uniqid().rand() ), 0, 6 );
	       $data['cms_view'] = 'create_short_url';
	       $this->load->view('cms/index',$data);     
	  }
	  else {
	       redirect('cms');
	  }
     }
     
     public function new_create_short_url(){       
	  if ($this->input->server('REQUEST_METHOD') === 'POST'){
	       $params = array();
	       $params = $this->input->post('shorturl');
	       $params['user_id'] = $this->session->userdata('user_id');
	       $params['country_code'] = $this->session->userdata('country');
			 
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
			      ),
			      array(
				   'field' => 'shorturl[campaign_id]',
				   'label' => 'Product Id',
				   'rules' => 'required'
			      ),
			 );
	       
	       $this->form_validation->set_rules($config);
	       $tags = $this->input->post('tag_id');
	       if($this->form_validation->run() == TRUE && !empty($tags))
	       {
		       $code = $this->shorturl->urlToShortCode($params);
		       
		       if(isset($code['message'])){
			 $this->session->set_userdata('message', $code['message']);
		       }
		       else{
			 $this->session->unset_userdata('message');
		       }
		
		    if($code){
			 $last_id = $this->shorturl_model->getLastId();
		      
			 if ( is_array($tags) )
			 {
			      $x=0;
			      foreach($tags as $tag){
				   $data = array('short_urls_id' => $last_id,
						 'content_tag_id' => str_replace('-','',$tag)
						);
				   $x++;
				   $this->db->insert('short_url_tag',$data);     
			      }
			 }
		       
		       $setparam = array(
						       "campaign_id" => $params['campaign_id'], 
						       "url_id" => $code['url_id'],
						       "user_id" => $params['user_id']
					       );
		
		       $id_campaign_url = $this->campaign_url_model->insert($setparam);
			 $this->session->set_flashdata('message_type', 'success');
			 $this->session->set_flashdata('message_body', 'Create short url success');
			 redirect('cms/index/0/secondTab');
		    }
		    else{
			 $this->session->set_flashdata('message_type', 'error');
                         $this->session->set_flashdata('message_body', 'The URL is invalid.');
                         redirect('cms/create_short_url');
		    }
	       }
	       else{
		   $this->session->set_flashdata('message_type', 'error');
		    $this->session->set_flashdata('message_body', 'Please fill the required fields');
		    redirect('cms/create_short_url');
	       }
	  }
     }
     
     public function create_short_url_non_campaign()
    {
          if ($this->input->server('REQUEST_METHOD') === 'POST')
          {
	       $params = array();
	       $params = $this->input->post('shorturl');
	       $params['user_id'] = $this->session->userdata('user_id');
	       $params['country_code'] = $this->session->userdata('country');
	       
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
				       ),
				       array(
					     'field' => 'shorturl[product_id]',
					     'label' => 'Product Id',
					     'rules' => 'required'
				       ),
			       );
	       
	       $this->form_validation->set_rules($config);
	       $tags = $this->input->post('tag_id');
			 
	       if($this->form_validation->run() == TRUE && !empty($tags))
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
		       
		       if($code){
			 $tags = $this->input->post('tag_id');
			 
			 $last_id = $this->shorturl_model->getLastId();
		      
			 if ( is_array($tags) )
			 {
			      $x=0;
			      foreach($tags as $tag){
				   $data = array('short_urls_id' => $last_id,
						 'content_tag_id' => str_replace('-','',$tag)
						);
				   $x++;
				   $this->db->insert('short_url_tag',$data);     
			      }
			 }
		       
		       $setparam = array(
						       "campaign_id" => $params['campaign_id'], 
						       "url_id" => $code['url_id'],
						       "user_id" => $params['user_id']
					       );
		
		       $id_campaign_url = $this->campaign_url_model->insert($setparam);
			 $this->session->set_flashdata('message_type', 'success');
			 $this->session->set_flashdata('message_body', 'Create short url success');
			 redirect('cms/index/0/secondTab');
		       }
		       else{
			 $this->session->set_flashdata('message_type', 'error');
			 $this->session->set_flashdata('message_body', 'The URL is invalid');
			 redirect('cms/create_short_url'); 
		    }
	       }
	       else{
		    $this->session->set_flashdata('message_type', 'error');
		    $this->session->set_flashdata('message_body', 'Please fill the required fields');
		    redirect('cms/create_short_url');
	       }
	  }
     }
    
    public function create_product()
    {
     if(IsRoleFriendlyNameExist($this->user_role,'Content Management_Product_All_Country_View'))
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
    	
    	$products = $this->product_model->get($config['per_page'], $offset);
        foreach($products as $product){
          $product->children = $this->product_model->getChildren($product->id)->result();
        }
        $data['products'] = $products;
        
        $data['products_avail'] = $this->product_model->getParent();
          $data['countries'] = $this->users_model->get_country()->result();
        
        $data['pagination'] = $this->pagination->create_links();
    	
    	$action = $this->input->get('action');
        
        $data['cms_view'] = 'create_product';
        
        if ($this->input->server('REQUEST_METHOD') === "POST")
        {
          if(IsRoleFriendlyNameExist($this->user_role,'Content Management_Product_All_Country_Create'))
          {
        	$params = array();
	        $params = $this->input->post('product');
	        $params['user_id'] = $this->session->userdata('user_id');
	       if($params['parent_id'] == ''){
                    $params['parent_id'] = null;
               }
               
	        $this->form_validation->set_rules('product[product_name]', 'Product Name', 'required|xss_clean');
	        
	        if ($this->form_validation->run() == TRUE)
	        {
		        $this->product_model->insert($params);
			 $this->session->set_flashdata('message_type', 'success');
                         $this->session->set_flashdata('message_body', 'Create product success');
		
		}
	        else 
	        {
		        $this->session->set_flashdata('message_type', 'error');
		        $this->session->set_flashdata('message_body', 'Please fill the required fields');
	        }
			      
	        redirect('cms/create_product');
          }
        }
               if ($action == 'delete')
               {
                    if(IsRoleFriendlyNameExist($this->user_role,'Content Management_Product_All_Country_Delete'))
                    {
                       $id = $this->input->get('id');
                       
                       if ($id)
                       {
                              $this->product_model->delete($id);
			      $this->session->set_flashdata('message_type', 'success');
                              $this->session->set_flashdata('message_body', 'Product has been deleted.');
		       }
                       
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
    
    public function edit_product($id)
    {
	  if(IsRoleFriendlyNameExist($this->user_role,'Content Management_Product_All_Country_Edit'))
          {
	       $product = $this->product_model->getOneBy(array('id' => $id));
	       $data['data']['row'] = $product;
	       if($product->parent_id){
		    $data['data']['products_avail'] = $this->product_model->getParent();    
	       }
	       else{
		    $data['data']['products_avail'] = array();    
	       }
	       $data['data']['countries'] = $this->users_model->get_country()->result();
	       $data['cms_view'] = 'edit_product';
	       $this->load->view('cms/index',$data);
	  }
	  else{
	       redirect('cms/create_product');
	  }
    }
    
    public function edit_campaign($id)
    {
          $campaign = $this->campaign_model->getOneBy(array('id' => $id));
          $data['data']['row'] = $campaign;
	  
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
	  $data['data']['product_list'] = $product_list;
	       
	  $products_selected = $this->campaign_model->get_content_product_campaign_by_campaign_id($id)->result();
    	  if($products_selected){
	       foreach($products_selected as $select){
		    $prod_sel[] = $select->products_id;
	       }
	  }
	  $data['data']['product_selected'] = $prod_sel;
	  //$data['countries'] = $this->users_model->get_country()->result();
          $data['data']['tags'] = $this->tag_model->get();
          
    	  $data['data']['tags_selected'] = $this->campaign_model->get_content_tag_campaign_by_campaign_id($id)->result();
    	  $data['cms_view'] = 'edit_campaign';
          $this->load->view('cms/index',$data);
    }
    
    public function update_product(){
          $this->form_validation->set_rules('id','Id','required');
          $this->form_validation->set_rules('name','Product Name','required');
          $this->form_validation->set_rules('description','Description','required');
          $this->form_validation->set_rules('country_code','Country','required');
          $id = $this->input->post('id');
          
          if ($this->form_validation->run() == FALSE){
               $this->session->set_flashdata('message_type','error');
               $this->session->set_flashdata('message_body','Please fill the required field.');
               redirect('cms/edit_product/'.$id);
          }
          else{
	       if($this->input->post('parent_id') != ''){
		    $parent_id = $this->input->post('parent_id');
	       }
	       else{
		    $parent_id = null;
	       }
	       
               $value = array('product_name' => $this->input->post('name'),
                              'description' => $this->input->post('description'),
                              'parent_id' => $parent_id,
                              'country_code' => $this->input->post('country_code')
                             );
               $result = $this->product_model->update($id,$value);
               $this->session->set_flashdata('message_type','success');
               $this->session->set_flashdata('message_body','Product has been updated');
               redirect('cms/create_product');
          }
    }
    
    public function update_campaign(){
          $this->form_validation->set_rules('id','Id','required');
          $this->form_validation->set_rules('name','Campaign Name','required');
          $this->form_validation->set_rules('product[]','Product','required');
          $this->form_validation->set_rules('tag','Tags','required');
          $id = $this->input->post('id');
          
          if ($this->form_validation->run() == FALSE){
               $this->session->set_flashdata('message_type','error');
               $this->session->set_flashdata('message_body','Please fill the required field.');
               redirect('cms/edit_campaign/'.$id);
          }
          else{
               $value = array('campaign_name' => $this->input->post('name'),
                              'description' => $this->input->post('description')
                             );
               $result = $this->campaign_model->update($id,$value);
               
               $products = $this->input->post('product');
               $this->campaign_model->update_campaign_product($id,$products);
               
               $tags = $this->input->post('tag');
               $this->campaign_model->update_campaign_tag($id,$tags);
                
               $this->session->set_flashdata('message_type','success');
               $this->session->set_flashdata('message_body','Campaign has been updated');
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
    
    public function delete_campaign_url($id){
          if((IsRoleFriendlyNameExist($this->user_role,'Content Management_Short_URL_Own_Country_Delete')) ||
	      (IsRoleFriendlyNameExist($this->user_role,'Content Management_Short_URL_All_Country_Delete')))
	       {
              print_r($this->campaign_url_model->delete($id));
              $this->session->set_flashdata('message_type', 'success');
              $this->session->set_flashdata('message_body', 'Short URL has been remove from campaign.');
              redirect('cms');
          }
          else
          {
               redirect('cms');
          }
    }
    
     public function delete_campaign($id){
          if((IsRoleFriendlyNameExist($this->user_role,'Content Management_Campaign_Own_Country_Delete')) ||
              (IsRoleFriendlyNameExist($this->user_role,'Content Management_Campaign_All_Country_Delete'))) {
              print_r($this->campaign_model->delete($id));
              $this->session->set_flashdata('message_type', 'success');
              $this->session->set_flashdata('message_body', 'Campaign has been romoved.');
              redirect('cms');
          }
          else
          {
               redirect('cms');
          }
     }
     
     public function delete_short_url($id){
          if((IsRoleFriendlyNameExist($this->user_role,'Content Management_Short_URL_Own_Country_Delete')) ||
	      (IsRoleFriendlyNameExist($this->user_role,'Content Management_Short_URL_All_Country_Delete')))
	       {
              print_r($this->shorturl_model->delete($id));
              $this->session->set_flashdata('message_type', 'success');
              $this->session->set_flashdata('message_body', 'Short URL has been romoved.');
              redirect('cms');
          }
          else
          {
               redirect('cms');
          }
     }
}