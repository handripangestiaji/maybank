<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Campaign_url_model extends CI_Model
{
	protected $_table = "content_campaign_url";
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function get()
	{
		$this->db->join('content_campaign', 'content_campaign.id = '.$this->_table.'.campaign_id', 'left');
		$this->db->join('short_urls', 'short_urls.id = '.$this->_table.'.campaign_id', 'left');
		$this->db->join('user', 'user.user_id = '.$this->_table.'.user_id', 'left');
		
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
}