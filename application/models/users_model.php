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
    private $role_detail = 'role_collection_detail';
    
    function __construct()
    {
        parent::__construct();
    }
    
    //======================== USER ==========================
    //view user
    function select_user1($limit, $start, $role_id,$value, $country_code = null)
    {
        $this->db->distinct();
        $this->db->limit($limit, $start);
        $this->db->select('a.*, b.full_name as created_by_name,c.group_name,d.role_name');
        $this->db->from('user a left outer join user b on b.user_id = a.created_by left join user_group c on a.group_id = c.group_id left join role_collection d on a.role_id=d.role_collection_id');
        if($value != null)
        {
            $where = "a.email like '%".$value."%' OR a.display_name like '%".$value."%' OR a.username like '%".$value."%'";
            $this->db->where($where);
        }
        if($country_code != null){
            $this->db->where('a.country_code', $country_code);
        }
        $this->db->order_by('a.user_id','asc');
        if($role_id != null)
        $this->db->where("a.role_id", $role_id);
        $query = $this->db->get($this->user);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    function select_user()
    {
        $this->db->select('user.*,role_collection.role_name,user_group.group_name');
        $this->db->join('user_group','user.group_id = user_group.group_id','inner');
        $this->db->join('role_collection','user.role_id = role_collection.role_collection_id','left');
        return $this->db->get($this->user);
    }
    
    function check_user($user)
    {
        $this->db->where('username',$user);
        return $this->db->get($this->user);
    }
    
    function select_user_login($id)
    {
        $this->db->select('user.*,role_collection.role_name,user_group.group_name,user.full_name');
        $this->db->join('user_group','user.group_id = user_group.group_id','inner');
        $this->db->join('role_collection','user.role_id = role_collection.role_collection_id','left');
        $this->db->where('user_id',$id);
        return $this->db->get($this->user);
    }
    
    function count_record($var , $value, $country_code = NULL)
    {
            
        if($var=='role_id' && $value==0)
        {
            if($country_code != null)
                $this->db->where('country_code', $country_code);
            $tes = $this->db->get($this->user);
            return $tes->num_rows();
        }
        elseif($var == 'role_id')
        {
            $this->db->where('role_id',$value);
            if($country_code != null)
                $this->db->where('country_code', $country_code);
            $tes = $this->db->get($this->user);
            return $tes->num_rows();
        }
        elseif($var == 'teks' )
        {
            $where = "(email like '%".$value."%' OR display_name like '%".$value."%' OR username like '%".$value."%')";
            if($country_code != null)
                $where .= " AND country_code = '$country_code'";
            $this->db->where($where);
            $tes = $this->db->get($this->user);
            return $tes->num_rows();
        }
        else
        {
            if($country_code != null)
                $this->db->where('country_code', $country_code);
            return $this->db->count_all($this->user);
        }
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
    
    function get_byname($username)
    {
        $this->db->where('username',$username);
        return $this->db->get($this->user);
    }
    
    function update_user($id,$data)
    {
        if(isset($data['role_id'])){
            if($data['role_id'] == 0 )
                unset($data['role_id']);
        }
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
        $this->db->delete($this->activity);
        $this->db->where('user_id',$id);
        return $this->db->delete($this->user);
    }
    
    function check_email($email)
    {
        $this->db->where('email',$email);
        return $this->db->get($this->user);
    }
    
    function cek_roleid($id)
    {
        $this->db->where('role_id',$id);
        return $this->db->get($this->user);
    }
    
    function check_groupid($id)
    {
        $this->db->where('group_id',$id);
        return $this->db->get($this->user);
    }
    
    //============================= ROLE ================================
    function count_role_user($id_role)
    {
        $this->db->select('count(*) as count_role');
        $this->db->where('role_id',$id_role);
        return $this->db->get($this->user);
    }
    
    function count_record_role()
    {
        return $this->db->count_all($this->role);
    }
    
    function select_role($role_id = null, $country_code = null)
    {
        
        $regional_user_role_id = $this->get_role_id('Regional_User');
        $this->db->select('*, (select count(*) from role_collection_detail c where c.role_collection_id = b.role_collection_id) as count_role,
                          b.country_code as role_country_code' );
        $this->db->from('role_collection b');
        $this->db->join('user a','a.user_id=b.created_by','left');
        if($role_id != null){
            if($country_code != null){
                
                $this->db->where(array('b.country_code' => $country_code));
            }
        }
        return $this->db->get();
    }
    function get_role_id($friendly_name){
        $sql = "Select app_role_id from application_role where role_friendly_name = '$friendly_name'";
        $q = $this->db->query($sql);
        return $q->num_rows() > 0 ? $q->row() : null;
    }
    
    function select_role1($limit, $start, $country_code = null)
    {
        $this->db->limit($limit, $start);
        $this->db->select('*,  role_collection.country_code as role_country_code');
        $this->db->join('user','user.user_id=role_collection.created_by','left');
        if($country_code != null)
            $this->db->where('role_collection.country_code', $country_code);
        $query = $this->db->get($this->role);
        
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
    function insert_role($data)
    {
        return $this->db->insert($this->role,$data);
    }
    
    function delete_role($id)
    {
        $this->db->where('role_collection_id',$id);
        $this->db->delete($this->role_detail);
        
        $this->db->where('role_collection_id',$id);
        return $this->db->delete($this->role);
    }
    
    function edit_role($id)
    {
        $this->db->where('role_collection_id',$id);
        return $this->db->get($this->role);
    }
    
    function update_role($id,$data)
    {
        $this->db->where('role_collection_id',$id);
        return $this->db->update($this->role,$data);
    }
    
    function check_role($name)
    {
        $this->db->where('role_name',$name);
        return $this->db->get($this->role);
    }
    
    //============================ ROLE DETAIL =========================
    function insert_role_detail($data)
    {
        return $this->db->insert($this->role_detail,$data);
    }
    
    function edit_role_detail($id)
    {
        $this->db->where('role_collection_id',$id);
        return $this->db->get($this->role_detail);
    }
    
    function delete_role_detail($id)
    {
        $this->db->where('role_collection_id',$id);
        return $this->db->delete($this->role_detail);
    }
    
    //============================ GROUP ================================
    function count_group_user($id_group)
    {
        $this->db->select('count(*) as count_group');
        $this->db->where('group_id',$id_group);
        return $this->db->get($this->user);
    }
    
    function count_record_group($country_code = NULL)
    {
        $this->db->select('country_code');
        if($country_code != null)
            $this->db->where('country_code', $country_code);
        $count = $this->db->get($this->group);
        
        return $count->num_rows();
    }
    
    function select_group($filter = array())
    {
        $this->db->select('*');
        if(count($filter) > 0)
            $this->db->where($filter);
        return $this->db->get($this->group);
    }
    
    function select_byName($name)
    {
        $this->db->where('group_name',$name);
        return $this->db->get($this->group);
    }
    
    function select_group1($limit, $start, $country_code = NULL)
    {
        $this->db->select('*');
        $this->db->limit($limit, $start);
        $this->db->select('user_group.*,user.full_name as name');
        $this->db->join('user','user_group.created_by=user.user_id','left');
        if($country_code != null)
            $this->db->where('user_group.country_code', $country_code);
        $query = $this->db->get($this->group);
        
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
    function insert_group($data)
    {
        return $this->db->insert($this->group,$data);
    }
    
    function update_group($group_id,$data)
    {
        $this->db->where('group_id',$group_id);
        return $this->db->update($this->group,$data);
    }
    
    function delete_group($id)
    {
        try{
        $this->db->trans_start();
        $this->db->where('user_group_id', $id);
        $this->db->delete('user_group_detail');
        $this->db->where('group_id',$id);
        $this->db->delete($this->group);
        $this->db->trans_complete();
        return 1;
        }
        catch(Exception $ex)
        {
            $this->db->trans_rollback();
            return 0;
        }
    }
    
    function edit_group($id)
    {
        $this->db->where('group_id',$id);
        return $this->db->get($this->group);
    }
    
    //============================ CHANNEL ==============================
    function select_channel($country_code = null)
    {
        $this->db->select('*');
        $this->db->from('channel');
        if($country_code != null)
            $this->db->where('country_code', $country_code);
        return $this->db->get();
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
    
    function edit_group_detail($user_group_id)
    {
        $this->db->where('user_group_id',$user_group_id);
        //$this->db->join('channel','channel.id_channel=user_group_detail.allowed_channel','left');
        return $this->db->get($this->user_group_detail);
    }
    
    function delete_group_detail($id)
    {
        $this->db->where('user_group_id',$id);
        return $this->db->delete($this->user_group_detail);
    }
    
    //============================= APP_ROLE ============================
    function select_appRole()
    {
        return $this->db->get($this->app_role);
    }
    function insert_appRole($data)
    {
        return $this->db->insert($this->app_role,$data);
    }
    
    //============================== LOGIN ===============================
    function check($username,$password)
    {
        $this->db->where('username',$username);
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
    
    function get_group_detail($filter){
        $this->db->where($filter);
        return $this->db->get($this->user_group_detail);
    }
    
    function get_collection_detail($filter = array()){
        $this->db->select('b.role_friendly_name, role_name, b.role_group');
        $this->db->from('role_collection_detail a inner join application_role b on a.app_role_id = b.app_role_id');
        if(count($filter) > 0)
            $this->db->where($filter);
        return $this->db->get()->result();
    }
    
    //============================ COUNTRY =========================
    function insert_country($data)
    {
        return $this->db->insert('country',$data);
    }
    
    function get_country($id=null){
        $this->db->select('*');
        $this->db->from('country');
        if($id!=null){
            $this->db->where('code',$id);
        }
        return $this->db->get();
    }
    function edit_country($id)
    {
        $this->db->where('role_collection_id',$id);
        return $this->db->get($this->role_detail);
    }
    
    function update_country($id,$data)
    {
        $this->db->where('code',$id);
        return $this->db->update('country',$data);
    }
    
    function delete_country($id)
    {
        $this->db->where('code',$id);
        return $this->db->delete('country');
    }
    function get_country_list(){
        $this->db->select("*");
        $this->db->from('country');
        return $this->db->get()->result();
    }
}
