<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shorturl_model extends CI_Model
{

	protected $_table = "short_urls";

	public function __construct()
	{
		parent::__construct();
	}
	
	public function getOneBy($params = array())
	{
		if (isset($params['long_url']))
		{
			$this->db->where('long_url', $params['long_url']);
		}
		
		$this->db->limit(1);
		
		$query = $this->db->get($this->_table);
		
		$result = $query->row();
		
		return $result;
	}
	
	public function insert($params = array())
	{
		$this->db->set($params);
		
		$this->db->insert($this->_table);
		
		$query = $this->db->query('SELECT LAST_INSERT_ID()');
		$row = $query->row_array();
		
		return $row['LAST_INSERT_ID()'];
	}
	
	public function update($id, $params = array())
	{
		$this->db->set($params);
		
		if ($id == null)
		{
			throw new Exception("Input parameter(s) invalid");
		}
		
		$this->db->where('id', $id);
		
		$this->db->update($this->_table);
		
		$status = $this->db->affected_rows();
        
        return ($status == 0) ? FALSE : TRUE;
	}

}