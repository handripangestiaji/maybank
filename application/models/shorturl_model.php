<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shorturl_model extends CI_Model
{

	protected $_table = "short_urls";

	public function __construct()
	{
		parent::__construct();
		$this->load->library('ciqrcode');
	}
	
	public function find($params = array())
	{
		if (isset($params['long_url']))
		{
			$this->db->where('long_url', $params['long_url']);
		}
		
		if (isset($params['short_code']))
		{
			$this->db->where('short_code', $params['short_code']);
		}
		
		$this->db->limit(1);
		
		$query = $this->db->get($this->_table);
		
		$result = $query->row();
		
		return $result;
	}
	
	public function get($limit = '', $offset = '', $filter)
	{
		$this->db->select('short_urls.*,user.display_name');
		$this->db->join("user", $this->_table.".user_id = user.user_id", "left");
		$this->db->limit($limit, $offset);
		$this->db->order_by('short_urls.id desc');
		if($filter)
			$this->db->where($filter);
		$query = $this->db->get($this->_table);
		return $query->result();
	}
	
	public function insert($params = array())
	{
		$qrcode_name = md5( time().uniqid().rand() ).".png";
		$params_url = array(
					"long_url" 		=> $params['long_url'],
					"short_code" 	=> $params['short_code'],
					"user_id" 		=> $params['user_id'],
					"description" 	=> isset($params['description']) ? $params['description'] : "",
					"qrcode_image"  => $qrcode_name,
					"country_code" => $params['country_code']
				);
		
		$this->db->trans_start();
		
		$this->db->set($params_url);
		
		$this->db->insert($this->_table);
		
		$this->db->trans_complete();
		
		$qrparams['data'] = $params['long_url'];
		
	    $qrparams['level'] = 'H';
	    
	    $qrparams['size'] = 4;
	    
	    $qrparams['savename'] = FCPATH.'media/dynamic/qrcode/'.$qrcode_name;
	    
	    $this->ciqrcode->generate($qrparams);
		
		$query = $this->db->query('SELECT LAST_INSERT_ID()');
		$row = $query->row_array();
		
		return $row['LAST_INSERT_ID()'];
	}
	
	public function update($id, $params = array())
	{	
		$status = 0;
		
        if (isset($params['increment']))
        {
        	$query = $this->db->query('UPDATE short_urls SET increment = increment + 1 WHERE id = '.$id);
        	
        	$query = $this->db->query('SELECT LAST_INSERT_ID()');
        	$row = $query->row_array();
        	
        	$count = count($row['LAST_INSERT_ID()']);
        	
        	$status = $count;
        }
        else
        {
	        $this->db->set($params);
		
			if ($id == null)
			{
				throw new Exception("Input parameter(s) invalid");
			}
			
			$this->db->where('id', $id);
			
			$this->db->update($this->_table);
			
			$status = $this->db->affected_rows();

        }
        
        return ($status == 0) ? FALSE : TRUE;
	}
	
	public function count_record($filter)
	{
		if($filter)
			$this->db->where($filter);
		return $this->db->count_all_results($this->_table);
	}
    
	public function getLastId(){
		$this->db->select('*');
		$this->db->order_by('id','desc');
		$this->db->from('short_urls');
		$short = $this->db->get()->row();
		return $short->id;
	}
	
	public function delete($id)
	{
		if ($id == null)
		{
			throw new \Exception("Invalid Id");
		}
		
		
		$this->db->where('url_id', $id);
		$this->db->delete('content_campaign_url');
		
		$this->db->where('short_urls_id', $id);
		$this->db->delete('short_url_tag');
		
		$this->db->where('id', $id);
		$this->db->delete($this->_table);
		
		return true;
	}
}