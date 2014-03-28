<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Campaign_model extends CI_Model
{
	protected $_table = "content_campaign";

	public function __construct()
	{
		parent::__construct();
	}
	
	public function insert($params = array(), $products = null, $tags = null)
	{
		$this->db->trans_start();
		
		$this->db->set($params);
		
		$this->db->insert($this->_table);
		
		$this->db->trans_complete();
		
		$query = $this->db->query('SELECT LAST_INSERT_ID()');
		$row = $query->row_array();
		$campaign_id = $row['LAST_INSERT_ID()'];
		
		$status = $this->db->affected_rows();
		
		if ($campaign_id)
		{
			if ( is_array($products) )
			{
				$prod_params = array();
				foreach ($products as $key => $value)
				{
					$prod_params['campaign_id'] = $campaign_id;
					$prod_params['products_id'] = $value;
					
					$this->db->trans_start();
				
					$this->db->set($prod_params);
					
					$this->db->insert('content_products_campaign');
					
					$this->db->trans_complete();
				}				
			}
			
			if ( is_array($tags) )
			{	
				$tag_params = array();
				foreach ($tags as $key => $value)
				{
					$tag_params['campaign_id'] = $campaign_id;
					$tag_params['tag_id'] = $value;
				
					$this->db->trans_start();
				
					$this->db->set($tag_params);
					
					$this->db->insert('content_tag_campaign');
					
					$this->db->trans_complete();
				}
			}
		}
		
		return (empty($status)) ? FALSE : TRUE;
	}
	
	public function get()
	{
		$this->db->select($this->_table.'.*, user.display_name');
		
		$this->db->join('user', $this->_table.'.user_id = user.user_id', 'left');
		
		$query = $this->db->get($this->_table);
		
		return $query->result();
	}
	
	public function getAllArray($limit = '', $offset = '')
	{
		$this->db->select($this->_table.'.*, user.display_name');
		
		$this->db->join('user', $this->_table.'.user_id = user.user_id', 'left');
		
		if($limit || $offset)
		{
			$this->db->limit($limit, $offset);
		}
		$query = $this->db->get($this->_table);
		
		$campaigns = array();
		$i = 0;
		foreach ($query->result() as $v)
		{
			$this->db->select('content_products.product_name');
			
			$this->db->join('content_products_campaign', 'content_products.id = content_products_campaign.products_id', 'left');
			
			$this->db->where('content_products_campaign.campaign_id', $v->id);
			
			$result = $this->db->get('content_products');
			
			$campaigns[$i]['id'] = $v->id;
			$campaigns[$i]['campaign_name'] = $v->campaign_name;
			$campaigns[$i]['description'] = $v->description;
			$campaigns[$i]['display_name'] = $v->display_name;
			$campaigns[$i]['created_at'] = date('M d, Y', strtotime($v->created_at));
			
			foreach($result->result() as $value)
			{
				$campaigns[$i]['product_name'][] = $value->product_name;
			}
			
			$this->db->select('content_tag.tag_name');
			
			$this->db->join('content_tag_campaign', 'content_tag.id = content_tag_campaign.tag_id', 'left');
			
			$this->db->where('content_tag_campaign.campaign_id', $v->id);
			
			$query = $this->db->get('content_tag');
			
			foreach($query->result() as $value)
			{
				$campaigns[$i]['tag_name'][] = $value->tag_name;
			}
			
			$this->db->select('content_campaign_url.*, content_campaign_url.id as content_campaign_url_id, short_urls.*, user.user_id, user.display_name, user.username');
			
			$this->db->join('short_urls', 'content_campaign_url.url_id = short_urls.id', 'left');
			
			$this->db->join('user', 'content_campaign_url.user_id = user.user_id', 'left');
			
			$this->db->where('content_campaign_url.campaign_id', $v->id);
			
			$res = $this->db->get('content_campaign_url');
			
			$x = 0;
			$totalclicks = 0;
			foreach($res->result() as $v)
			{
				$campaigns[$i]['short_urls'][$x]['content_campaign_url_id'] = $v->content_campaign_url_id;
				$campaigns[$i]['short_urls'][$x]['long_url'] = $v->long_url;
				$campaigns[$i]['short_urls'][$x]['short_code'] = $v->short_code;
				$campaigns[$i]['short_urls'][$x]['description'] = $v->description;
				$campaigns[$i]['short_urls'][$x]['increment'] = $v->increment;
				$campaigns[$i]['short_urls'][$x]['created_at'] = date('M d, Y', strtotime($v->created_at));
				$campaigns[$i]['short_urls'][$x]['display_name'] = $v->display_name;
				$campaigns[$i]['short_urls'][$x]['qrcode_image'] = $v->qrcode_image;
				$totalclicks = $totalclicks + $v->increment;
				$x++;
			}
			
			$campaigns[$i]['total_clicks'] = $totalclicks;
			
			$i++;
		}
		
		/*
echo "<pre>";
		die(print_r($campaigns));
*/
		
		return $campaigns;
	}
	
	public function getCampaignWithUrl()
	{
		$this->db->select($this->_table.'.*, user.display_name');
		
		$this->db->join('user', $this->_table.'.user_id = user.user_id', 'left');
		
		$query = $this->db->get($this->_table);
		
		$campaigns = array();
		$i = 0;
		
		foreach ($query->result() as $v)
		{
			$this->db->select('content_products.product_name');
			
			$this->db->join('content_products_campaign', 'content_products.id = content_products_campaign.products_id', 'left');
			
			$this->db->where('content_products_campaign.campaign_id', $v->id);
			
			$result = $this->db->get('content_products');
			
			$campaigns[$i]['id'] = $v->id;
			$campaigns[$i]['campaign_name'] = $v->campaign_name;
			$campaigns[$i]['display_name'] = $v->display_name;
			$campaigns[$i]['created_at'] = date('M d, Y', strtotime($v->created_at));
			
			foreach($result->result() as $value)
			{
				$campaigns[$i]['product_name'][] = $value->product_name;
			}
			
			$this->db->select('content_campaign_url.*, short_urls.*');
			
			$this->db->join('content_campaign_url', 'content_campaign_url.url_id = short_urls.id', 'left');
			
			$this->db->where('content_campaign_url.campaign_id', $v->id);
			
			$res = $this->db->get('content_campaign_url');
			
			foreach($res->result() as $v)
			{
				$campaigns[$i]['short_urls'][] = $v->short_code;
			}
			
			$i++;
		}
		
		/*
echo "<pre>";
		die(print_r($campaigns));
*/
		
		return $campaigns;
	}
	
	public function GetProduct($filter = array()){
		$this->db->select("*");
		$this->db->from('content_products');
		if($filter){
			$this->db->where($filter);
		}
		return $this->db->get()->result();
	}
	
	public function getOneBy($params = array())
	{
		if (isset($params['id']))
		{
			$this->db->where('content_campaign.id', $params['id']);
		}
		
		//$this->db->join('content_products_campaign','content_campaign.id = content_products_campaign.campaign_id');
		$result = $this->db->get($this->_table);
		
		return $result->row();
	}
	
	public function delete($id)
	{
		if ($id == null)
		{
			throw new \Exception("Invalid Id");
		}
		
		$this->db->where('id', $id);
		
		$this->db->delete($this->_table);
		
		return true;
	}
	
	public function count_record()
	{
		return $this->db->count_all($this->_table);
	}
	
	public function get_content_product_campaign_by_campaign_id($id){
		$this->db->select('*');
		$this->db->where('campaign_id',$id);
		$this->db->from('content_products_campaign');
		$this->db->join('content_products','content_products_campaign.products_id = content_products.id');
		return $this->db->get();
	}
	
	public function get_content_tag_campaign_by_campaign_id($id){
		$this->db->select('*');
		$this->db->where('campaign_id',$id);
		$this->db->from('content_tag_campaign');
		$this->db->join('content_tag','content_tag_campaign.tag_id = content_tag.id');
		return $this->db->get();
	}
	
	public function update($id,$value){
		$this->db->where('id',$id);
		$this->db->update('content_campaign',$value);
	}
	
	public function update_campaign_product($id,$products){
		$this->db->delete('content_products_campaign',array('campaign_id' => $id));
		print_r($products);
		$prod_params = array();
		foreach ($products as $key => $value)
		{
			$prod_params['campaign_id'] = $id;
			$prod_params['products_id'] = $value;
			$prod_params['created_at'] = date('Y-m-d H:i:s');
			
			$this->db->trans_start();
			$this->db->set($prod_params);
			$this->db->insert('content_products_campaign');
			$this->db->trans_complete();
		}		
	}
	
	public function update_campaign_tag($id,$tags){
		$this->db->delete('content_tag_campaign',array('campaign_id' => $id));
		
		$tag_params = array();
		foreach ($tags as $key => $value)
		{
			$tag_params['campaign_id'] = $id;
			$tag_params['tag_id'] = $value;
			$tag_params['created_at'] = date('Y-m-d H:i:s');
		
			$this->db->trans_start();
			$this->db->set($tag_params);
			$this->db->insert('content_tag_campaign');
			$this->db->trans_complete();
		}
	}
	
	public function getForDownload($id){
		$this->db->select('qrcode_image,short_code,campaign_name,full_name,short_urls.increment as inc,short_urls.created_at as created_at');
		$this->db->from('content_campaign');
		$this->db->join('content_campaign_url','content_campaign.id = content_campaign_url.campaign_id');
		$this->db->join('short_urls','content_campaign_url.url_id = short_urls.id','left');
		$this->db->join('user','short_urls.user_id = user.user_id','left');
		$this->db->where('content_campaign.id',$id);
		return $this->db->get();
	}
	
	public function getProductsByCampaign($id){
		$this->db->select('*');
		$this->db->from('content_products_campaign');
		$this->db->join('content_products','content_products_campaign.products_id = content_products.id');
		$this->db->where('content_products_campaign.campaign_id',$id);
		return $this->db->get();
	}
}