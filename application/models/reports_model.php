<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    function view_channel()
    {
	return $this->db->get('channel');
    }
    
    function view_product()
    {
        return $this->db->get('content_products');
    }
    
    function create_report($channel_id, $user_id, $date_start, $date_finish, $ug_id = null)
    {
	$ug_id = $ug_id == null || $ug_id == 'All'? 'null' : "'$ug_id'";
	$sql_report = "call sp_ReportPerformance('$channel_id', $ug_id, '$user_id', '$date_start', '$date_finish');";
	$q = $this->db->query($sql_report);
	$references_report = $q->row();
	return $references_report->my_code;
    }
    
    function filter_report($current_code, $case_type = null){
	$query = "SELECT b.product_name, b.id, a.type, a.type2, a.code,  sum(a.total_case) as total_case, sum(a.total_solved) as total_solved, sum(a.average_response) as average_response
	FROM report_performance a right join content_products b on a.product_id = b.id
	WHERE a.code = '$current_code' ".($case_type == null ? "" : " AND a.case_type = '$case_type'");
	$q = $this->db->query($query." GROUP By a.type, a.type2");
	$result = $q->result();
	$result_array = array();
	$result_array[0] = $result_array[1] = array();
	foreach($result as $row){
	    if($row->type2 == null){
		
		if($row->type == 'facebook' || $row->type == null)
		    $result_array[0][] = $row;
		if($row->type == 'facebook_conversation' || $row->type == null)
		    $result_array[1][] = $row;
	    }
	    else{
		if($row->type2 == "mentions" || $row->type == null || $row->type2 == "homefeed")
		    $result_array[0][] = $row;
		
		if($row->type == "twitter_dm" || $row->type == null)
		    $result_array[1][] = $row;
	    }
	}
	$q2 = $this->db->query($query." GROUP By b.id");
	$result_array[2] = $q2->result();
	
	$result_array[3] = $this->load->model('campaign_model')->GetProductBasedOnParent();
	$q4 = $this->db->query($query);
	$result_array[4] = $q4->result();
	return $result_array;
    }
    
    function count_all_cases($channel, $dateFrom, $dateTo){
	$this->db->select('count(*) as counted');
	$this->db->from('case');
	$this->db->where('case.created_at >=', $dateFrom);
	$this->db->where('case.created_at <=', $dateTo);
	$this->db->where('social_stream.channel_id = ',$channel);
	$this->db->join('social_stream','case.post_id = social_stream.post_id');
	
	return $this->db->get()->row()->counted;
    }
    
    function count_solved_cases($channel, $dateFrom, $dateTo){
	$this->db->select('count(*) as counted');
	$this->db->from('case');
	$this->db->where('case.created_at >=', $dateFrom);
	$this->db->where('case.created_at <=', $dateTo);
	$this->db->where('case.status =', 'solved');
	$this->db->where('social_stream.channel_id = ',$channel);
	$this->db->join('social_stream','case.post_id = social_stream.post_id');
	
	return $this->db->get()->row()->counted;
    }
    
    function group_all_case_by_date($channel, $dateFrom, $dateTo){
	$this->db->select('count(*) as counted, DATE(case.created_at) as created_at');
	$this->db->from('case');
	$this->db->where('case.created_at >=', $dateFrom);
	$this->db->where('case.created_at <=', $dateTo);
	$this->db->where('social_stream.channel_id = ',$channel);
	$this->db->join('social_stream','case.post_id = social_stream.post_id');
	$this->db->group_by('DATE(case.created_at)'); 
	
	return $this->db->get()->result();
    }
    
    function count_percentage_product(){
	$sql = "select t.content_products_id,stat_pending+stat_solved+stat_read+stat_not_solved as stat_all,
		stat_solved, (stat_solved/(stat_pending+stat_solved+stat_read+stat_not_solved)*100) as percentage,
		cp.product_name
		from
		(select content_products_id,
		    count(case when status='pending' then 1 else null end) as stat_pending,
		    count(case when status='solved' then 1 else null end) as stat_solved,
		    count(case when status='read' then 1 else null end) as stat_read,
		    count(case when status='not solved' then 1 else null end) as stat_not_solved
		from `case`
		group by content_products_id
		) as t left join content_products cp on t.content_products_id = cp.id";
		
        $query = $this->db->query($sql);
        
        return $query->result();
    }
    
    function count_resolution($product, $dateFrom, $dateTo){
	$sql = "select count(*) count, sum(interv) sum, sum(interv)/count(*) as average,
		DATE(created_at) created_at from
		(SELECT *, TIMESTAMPDIFF(MINUTE, created_at, solved_at) as interv from `case` 
		where content_products_id = '$product' and created_at between '$dateFrom' and '$dateTo'
		and status='solved' ) as t group by DATE(created_at)";
		
        $query = $this->db->query($sql);      
        return $query->result();
    }
    
    function count_response($product, $dateFrom, $dateTo){
	$sql = "select count(*) count, sum(interv) sum, sum(interv)/count(*) as average,
		DATE(created_at) created_at from
		(SELECT c.created_at, TIMESTAMPDIFF(MINUTE, c.created_at, pr.created_at)
		as interv from `case` c right join page_reply pr on c.case_id = pr.case_id
		where content_products_id = '$product' and c.created_at between '$dateFrom' and '$dateTo'
		) as t group by DATE(created_at)";
		
        $query = $this->db->query($sql);      
        return $query->result();
    }
    
    function GetReportActivity($filter = null, $range = null, $limit = null, $offset = null){
	//get from report_activity table sort by date descending
	$this->db->select('*');
	$this->db->from('report_activity');
	if($filter){
	    $this->db->where($filter);
	}
	
	if(($limit != null) && ($offset == null)){
	    $this->db->limit($limit);
	}
	elseif(($limit != null) && ($offset != null)){
	    $this->db->limit($limit,$offset);
	}
	
	if($range){
	    $this->db->where($range);
	}
	
	$this->db->order_by('time','desc');
	return $this->db->get();
    }
    
    function CountReportActivity($filter = null, $range = null){
	//get from report_activity table sort by date descending
	$this->db->select('*');
	$this->db->from('report_activity');
	if($filter){
	    $this->db->where($filter);
	}
	
	if($range){
	    $this->db->where($range);
	}
	
	$count =  $this->db->count_all_results();
	return $count;
    }
    
    function generate_report_activity($date){
	//read from all the table which contain created_at field must larger than the date
	$now = date('Y-m-d H:i:s');
	
	//read channel_action
	$this->db->select('username, user.user_id, user.group_id, role_name, action_type, user.country_code, channel_action.created_at');
	$this->db->from('channel_action');
	$this->db->join('user','channel_action.created_by = user.user_id');
	$this->db->join('role_collection','user.role_id = role_collection.role_collection_id');
	
	$this->db->where("channel_action.created_at > '".$date."'");
	$this->db->order_by('channel_action.created_at');
	$result = $this->db->get()->result();
	
	$value = array();
	//store channel_action
	if($result){
	    foreach($result as $row){
		$value[] = array('username' => $row->username,
				'user_id' => $row->user_id,
				'group_id' => $row->group_id,
			       'rolename' => $row->role_name,
			       'action' => $row->action_type,
			       'status' => '',
			       'country_code' => $row->country_code,
			       'time' => $row->created_at,
			       'created_at' => $now
			       );
	    }
	}
	
	
	//read case
	$this->db->select('username, user.user_id, user.group_id, role_name, case_id, messages, user.country_code, case.created_at');
	$this->db->from('case');
	$this->db->join('user','case.created_by = user.user_id');
	$this->db->join('role_collection','user.role_id = role_collection.role_collection_id');
	$this->db->where("case.created_at > '".$date."'");
	$this->db->order_by('case.created_at');
	$result = $this->db->get()->result();
	
	//store case
	foreach($result as $row){
	    $value[] = array('username' => $row->username,
			    'user_id' => $row->user_id,
			    'group_id' => $row->group_id,
			   'rolename' => $row->role_name,
			   'action' => 'Create New Case #'.$row->case_id,
			   'status' => $row->messages,
			   'country_code' => $row->country_code,
			   'time' => $row->created_at,
			   'created_at' => $now
			   );
        }
        
        /*
	//read case_assign_detail
	$this->db->select('username, role_name, messages, role_collection.country_code, case.created_at');
	$this->db->from('case_assign');
	$this->db->join('user','case.created_by = user.user_id');
	$this->db->join('role_collection','user.role_id = role_collection.role_collection_id');
	$this->db->where("case.created_at > '".$date."'");
	$this->db->order_by('case.created_at');
	$result = $this->db->get()->result();
	
	//store case_assign_detail
	foreach($result as $row){
	    $value[] = array('username' => $row->username,
			   'rolename' => $row->role_name,
			   'action' => $row->messages,
			   'status' => $row->messages,
			   'country_code' => $row->country_code,
			   'time' => $row->created_at,
			   'created_at' => $now
			   );
        }
        */
	
	//read channel
	$this->db->select('username, user.user_id, user.group_id, role_name, name, user.country_code, channel.token_created_at');
	$this->db->from('channel');
	$this->db->join('user','channel.created_by = user.user_id');
	$this->db->join('role_collection','user.role_id = role_collection.role_collection_id');
	$this->db->where("channel.token_created_at > '".$date."'");
	$this->db->order_by('channel.token_created_at');
	$result = $this->db->get()->result();
	
	//store channel
	foreach($result as $row){
	    $value[] = array('username' => $row->username,
			     'user_id' => $row->user_id,
			    'group_id' => $row->group_id,
			   'rolename' => $row->role_name,
			   'action' => 'Create New Channel',
			   'status' => $row->name,
			   'country_code' => $row->country_code,
			   'time' => $row->token_created_at,
			   'created_at' => $now
			   );
        }
        
	//read content_campaign
	$this->db->select('username, user.user_id, user.group_id, role_name, campaign_name, user.country_code, content_campaign.created_at');
	$this->db->from('content_campaign');
	$this->db->join('user','content_campaign.user_id = user.user_id');
	$this->db->join('role_collection','user.role_id = role_collection.role_collection_id');
	$this->db->where("content_campaign.created_at > '".$date."'");
	$this->db->order_by('content_campaign.created_at');
	$result = $this->db->get()->result();
	
	//store content_campaign
	foreach($result as $row){
	    $value[] = array('username' => $row->username,
			     'user_id' => $row->user_id,
			    'group_id' => $row->group_id,
			   'rolename' => $row->role_name,
			   'action' => 'Create New Campaign',
			   'status' => $row->campaign_name,
			   'country_code' => $row->country_code,
			   'time' => $row->created_at,
			   'created_at' => $now
			   );
        }
	
	//read content_products
	$this->db->select('username, user.user_id, user.group_id, role_name, product_name, user.country_code, content_products.created_at');
	$this->db->from('content_products');
	$this->db->join('user','content_products.user_id = user.user_id');
	$this->db->join('role_collection','user.role_id = role_collection.role_collection_id');
	$this->db->where("content_products.created_at > '".$date."'");
	$this->db->order_by('content_products.created_at');
	$result = $this->db->get()->result();
	
	//store content_products
	foreach($result as $row){
	    $value[] = array('username' => $row->username,
			     'user_id' => $row->user_id,
			    'group_id' => $row->group_id,
			   'rolename' => $row->role_name,
			   'action' => 'Create New Product',
			   'status' => $row->product_name,
			   'country_code' => $row->country_code,
			   'time' => $row->created_at,
			   'created_at' => $now
			   );
        }
	
	//read content_tag
	$this->db->select('username, user.user_id, user.group_id, role_name, tag_name, user.country_code, content_tag.created_at');
	$this->db->from('content_tag');
	$this->db->join('user','content_tag.user_id = user.user_id');
	$this->db->join('role_collection','user.role_id = role_collection.role_collection_id');
	$this->db->where("content_tag.created_at > '".$date."'");
	$this->db->order_by('content_tag.created_at');
	$result = $this->db->get()->result();
	
	//store content_tag
	foreach($result as $row){
	    $value[] = array('username' => $row->username,
			     'user_id' => $row->user_id,
			    'group_id' => $row->group_id,
			   'rolename' => $row->role_name,
			   'action' => 'Create New Tag',
			   'status' => $row->tag_name,
			   'country_code' => $row->country_code,
			   'time' => $row->created_at,
			   'created_at' => $now
			   );
        }
	
	/*
	//read page_reply
	$this->db->select('*');
	$this->db->from('case');
	$this->db->join('user');
	$where = "`created_at` > ".$date;
        $this->db->where($where);
	$result = $this->db->result();
	
	//store page_reply
	foreach($result as $row){
	    $value[] = array('username' => $row->username,
			   'rolename' => $row->rolename,
			   'action' => $row->action,
			   'status' => $row->status,
			   'country_code' => $row->country_code,
			   'time' => $row->created_at,
			   'created_at' => $now
			   );
        }
	*/
	
	//read role_collection
	$this->db->select('username, user.user_id, user.group_id, x.role_name as xrole_name, role_collection.role_name, user.country_code, role_collection.created_at');
	$this->db->from('role_collection');
	$this->db->join('user','role_collection.created_by = user.user_id');
	$this->db->join('role_collection x','user.role_id = x.role_collection_id');
	$this->db->where("role_collection.created_at > '".$date."'");
	$this->db->order_by('role_collection.created_at');
	$result = $this->db->get()->result();
	
	//store role_collection
	foreach($result as $row){
	    $value[] = array('username' => $row->username,
			     'user_id' => $row->user_id,
			    'group_id' => $row->group_id,
			   'rolename' => $row->xrole_name,
			   'action' => 'Create new role',
			   'status' => $row->role_name,
			   'country_code' => $row->country_code,
			   'time' => $row->created_at,
			   'created_at' => $now
			   );
        }
	
	//read short_urls
	$this->db->select('username, user.user_id, user.group_id, role_name, short_code, user.country_code, short_urls.created_at');
	$this->db->from('short_urls');
	$this->db->join('user','short_urls.user_id = user.user_id');
	$this->db->join('role_collection','user.role_id = role_collection.role_collection_id');
	$this->db->where("short_urls.created_at > '".$date."'");
	$this->db->order_by('short_urls.created_at');
	$result = $this->db->get()->result();
	
	//store short_urls
	foreach($result as $row){
	    $value[] = array('username' => $row->username,
			     'user_id' => $row->user_id,
			    'group_id' => $row->group_id,
			   'rolename' => $row->role_name,
			   'action' => 'Create short url',
			   'status' => $row->short_code,
			   'country_code' => $row->country_code,
			   'time' => $row->created_at,
			   'created_at' => $now
			   );
        }
	
	/*not solved
	//read twitter_reply
	$this->db->select('username, role_name, text, role_collection.country_code, twitter_reply.created_at');
	$this->db->from('twitter_reply');
	$this->db->join('user','twitter_reply.user_id = user.user_id');
	$this->db->join('role_collection','user.role_id = role_collection.role_collection_id');
	$this->db->where("twitter_reply.created_at > '".$date."'");
	$this->db->order_by('twitter_reply.created_at');
	$result = $this->db->get()->result();
	
	//store twitter_reply
	foreach($result as $row){
	    $value[] = array('username' => $row->username,
			   'rolename' => $row->role_name,
			   'action' => 'Reply to '.$row->username,
			   'status' => $row->text,
			   'country_code' => $row->country_code,
			   'time' => $row->created_at,
			   'created_at' => $now
			   );
        }
	*/
	
	//read user
	$this->db->select('x.username as xusername, x.user_id, x.group_id, user.username, role_name, user.country_code, user.created_at, user.created_by');
	$this->db->from('user');
	$this->db->join('user x','user.created_by = x.user_id');
	$this->db->join('role_collection','x.role_id = role_collection.role_collection_id');
	$this->db->where("user.created_at > '".$date."'");
	$this->db->order_by('user.created_at');
	$result = $this->db->get()->result();
	
	//store user
	foreach($result as $row){
	    if($row->created_by){
	    $value[] = array('username' => $row->xusername,
			     'user_id' => $row->user_id,
			    'group_id' => $row->group_id,
			   'rolename' => $row->role_name,
			   'action' => 'Create '.$row->username,
			   'status' => '',
			   'country_code' => $row->country_code,
			   'time' => $row->created_at,
			   'created_at' => $now
			   );
	    }
        }
	
	//read user_group
	$this->db->select('username, user.user_id, user.group_id, role_name, group_name, user.country_code, user_group.created_at');
	$this->db->from('user_group');
	$this->db->join('user','user_group.created_by = user.user_id');
	$this->db->join('role_collection','user.role_id = role_collection.role_collection_id');
	$this->db->where("user_group.created_at > '".$date."'");
	$this->db->order_by('user_group.created_at');
	$result = $this->db->get()->result();
	
	//store user_group
	foreach($result as $row){
	    $value[] = array('username' => $row->username,
			     'user_id' => $row->user_id,
			    'group_id' => $row->group_id,
			   'rolename' => $row->role_name,
			   'action' => 'Create '.$row->group_name,
			   'status' => '',
			   'country_code' => $row->country_code,
			   'time' => $row->created_at,
			   'created_at' => $now
			   );
        }
	
	//read user_login
	$this->db->select('username, user.user_id, user.group_id, role_name, user.country_code, login_time, logout_time');
	$this->db->from('user_login_activity');
	$this->db->join('user','user_login_activity.user_id = user.user_id');
	$this->db->join('role_collection','user.role_id = role_collection.role_collection_id');
	$this->db->where("user_login_activity.login_time > '".$date."'");
	$this->db->order_by('user_login_activity.login_time');
	$result = $this->db->get()->result();
	
	//store user_login
	foreach($result as $row){
	    $value[] = array('username' => $row->username,
			     'user_id' => $row->user_id,
			    'group_id' => $row->group_id,
			   'rolename' => $row->role_name,
			   'action' => 'Login',
			   'status' => '',
			   'country_code' => $row->country_code,
			   'time' => $row->login_time,
			   'created_at' => $now
			   );
	    
	    $value[] = array('username' => $row->username,
			     'user_id' => $row->user_id,
			    'group_id' => $row->group_id,
			   'rolename' => $row->role_name,
			   'action' => 'Logout',
			   'status' => '',
			   'country_code' => $row->country_code,
			   'time' => $row->logout_time,
			   'created_at' => $now
			   );
        }
	
	if(!empty($value)){
	    $this->db->insert_batch('report_activity',$value);
	}
	
	$filter = array('created_at' => $now);
	return $this->getReportActivity($filter)->result();
    }
    
    public function get_country(){
	$this->db->select('*');
	$this->db->from('country');
	return $this->db->get();
    }
    
    public function selectMaxDate(){
	$this->db->select_max('time');
	$this->db->from('report_activity');
	return $this->db->get();
    }
}