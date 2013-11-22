<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class account_model extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->load->helper('basic');
    }
    
    
    /*
        * Retrieve Channel(s) which are restored from databases
	* $filter : filtering channel by parameter default empty array
	* @return array feed collection
        * @author Eko Purnomo
    */
    function GetChannel($filter = array()){
        $this->db->select('*');
        $this->db->from("channel");
        if(count($filter) > 0)
            $this->db->where($filter);
        return $this->db->get()->result();
    }
    
    
    function GetApplicationRole($parent_id){
	$this->db->select("*");
	$this->db->from("application_role");
	$this->db->where("parent_id", $parent_id);
	return $this->db->get()->result();
    }
    
    function GetRole(){
	$result = $this->GetApplicationRole(5);
	foreach($result as $row){
	    $row->children = $this->GetApplicationRole($row->app_role_id);
	    foreach($row->children as $child){
		$child->children = $this->GetApplicationRole($child->app_role_id);
	    }
	}
	
	return $result;
    }
    
}
