<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Campaign_url_model extends CI_Model
{
	protected $_table = "content_campaign_url";
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function get($limit = '', $offset = '')
	{
		$this->db->select('
						content_campaign_url.*, 
						content_campaign.id AS campaign_id, 
						content_campaign.campaign_name, 
						short_urls.id AS url_id,
						short_urls.long_url,
						short_urls.short_code,
						short_urls.description,
						short_urls.increment,
						user.user_id,
						user.display_name');
		$this->db->join('content_campaign', 'content_campaign.id = '.$this->_table.'.campaign_id', 'left');
		$this->db->join('short_urls', 'short_urls.id = '.$this->_table.'.url_id', 'left');
		$this->db->join('user', 'user.user_id = '.$this->_table.'.user_id', 'left');
		
		if($limit || $offset)
		{
			$this->db->limit($limit, $offset);
		}
		
		$query = $this->db->get($this->_table);
		
		return $query->result();
	}
	
	public function insert($params = array())
	{
		$this->db->trans_start();
		
		$this->db->set($params);
		
		$this->db->insert($this->_table);
		
		$this->db->trans_complete();
		
		$query = $this->db->query('SELECT LAST_INSERT_ID()');
		$row = $query->row_array();
		
		return $row['LAST_INSERT_ID()'];
	}
	
	public function GetByCampaignId($id){
		$this->db->select('*');
		$this->db->from('content_campaign_url');
		$this->db->join('short_urls', 'content_campaign_url.url_id = short_urls.id', 'inner');
		$this->db->where('content_campaign_url.campaign_id',$id);
		return $this->db->get()->result();
	}
	
	public function delete($id)
	{
		if ($id == null)
		{
			return false;
		}
		
		$this->db->where('id', $id);
		
		$this->db->delete($this->_table);
		
		return true;
	}
	
	function count_record()
    {
        return $this->db->count_all($this->_table);
    }
}