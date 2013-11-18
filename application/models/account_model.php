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

    
}
