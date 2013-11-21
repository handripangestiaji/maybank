<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
class Users_model extends CI_Model
{
    private $user = 'user';
    private $group = 'user_group';
    private $role = 'role_collection';
    
    function __construct()
    {
        parent::__construct();
    }
    
    ////////////////////////////////--------------USER----------------
    //view user
    function select_user()
    {
        return $this->db->get($this->user);
    }
    
    //insert user
    function insert_user($data)
    {
        return $this->db->insert($this->user,$data);
    }
    
    //edit user
    function get_byid($id)
    {
        $this->db->where('user_id',$id);
        return $this->db->get($this->user);
    }
    
    function update_user($id,$data)
    {
        $this->db->where('user_id',$id);
        return $this->db->update($this->user,$data);
    }
    
    //delete
    function delete_user($id)
    {
        $this->db->where('user_id',$id);
        return $this->db->delete($this->user);
    }
    
    ///////////////////////////////////---------------ROLE----------------
    function select_role()
    {
        return $this->db->get($this->role);
    }
    
    /////////////////////////////////---------------GROUP---------------
    function select_group()
    {
        return $this->db->get($this->group);
    }
}