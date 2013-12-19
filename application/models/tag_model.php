<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tag_model extends CI_Model
{
	protected $_table = "content_tag";

	public function __construct()
	{
		parent::__construct();
	}
	
	public function insert($params = array())
	{
		$this->db->set($params);
		
		$this->db->insert($this->_table);
		
		$status = $this->db->affected_rows();
		
		return (empty($status)) ? FALSE : TRUE;
	}
	
	public function get($limit = '', $offset = '')
	{
		$this->db->select('content_tag.*, user.display_name');
		
		$this->db->join('user', $this->_table.'.user_id = user.user_id', 'left');
		
		if($limit || $offset)
		{
			$this->db->limit($limit, $offset);
		}
		
		$query = $this->db->get($this->_table);
		
		return $query->result();
	}
	
	public function getOneBy($params = array())
	{
		if (isset($params['id']))
		{
			$this->db->where('id', $params['id']);
		}
		
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
}