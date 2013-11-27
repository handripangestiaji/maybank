<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
class Users_model extends CI_Model
{
    private $user = 'user';
    private $group = 'user_group';
    private $role = 'role_collection';
    private $app_role = 'application_role';
    private $activity = 'user_login_activity';
    private $channel = 'channel';
    private $user_group_detail = 'user_group_detail';
    
    function __construct()
    {
        parent::__construct();
    }
    
    //======================== USER ==========================
    //view user
    function select_user()
    {
        $this->db->join('user_group','user.group_id = user_group.group_id','inner');
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
    
    function update_pass($id,$data)
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
    
    function check_email($email)
    {
        $this->db->where('email',$email);
        return $this->db->get($this->user);
    }
    
    //============================= ROLE ================================
    function select_role()
    {
        return $this->db->get($this->role);
    }
    
    //============================ GROUP ================================
    function select_group()
    {
        return $this->db->get($this->group);
    }
    
    function insert_group($data)
    {
        return $this->db->insert($this->group,$data);
    }
    
    function delete_group($id)
    {
        $this->db->where('user_group_id', $id);
        $this->db->delete('user_group_detail');
        $this->db->where('group_id',$id);
        return $this->db->delete($this->group);
    }
    
    function edit_group($id)
    {
        $this->db->where('group_id',$id);
    }
    
    //============================ CHANNEL ==============================
    function select_channel()
    {
        return $this->db->get($this->channel);
    }
    
    //============================ USER GROUP DETAIL ====================
    function select_user_group_d()
    {
        return $this->db->get($this->user_group_detail);
    }
    
    function insert_group_detail($data_channel)
    {
        return $this->db->insert($this->user_group_detail,$data_channel);
    }
    
    //============================= APP_ROLE ============================
    function select_appRole()
    {
        $this->db->where('role_group','channel');
        return $this->db->get($this->app_role);
    }
    function insert_appRole($data)
    {
        return $this->db->insert($this->app_role,$data);
    }
    
    //============================== LOGIN ===============================
    function check($username,$password)
    {
        $this->db->where('user_id',$username);
        $this->db->where('password',$password);

        return $this->db->get($this->user);
    }
    
    function check_login_time($id)
    {
        $this->db->where('user_id',$id);
        $this->db->where('login_time',NULL);
        return $this->db->get($this->activity);
    }
    
    function insert_activity($data)
    {
        return $this->db->insert($this->activity,$data);
    }
    
    function update_activity($id,$data)
    {
        $this->db->where('user_id',$id);
        $this->db->where('logout_time',NULL);
        return $this->db->update($this->activity,$data);
    }
}