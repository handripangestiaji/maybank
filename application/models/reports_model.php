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
    
    function count_product()
    {
	$case = 'maybank.case';
	$cp = 'maybank.content_products';
	/*$sql = 'select * from (((select content_products_id,case_type,count(content_products_id) as Total_a,count(status)
	as Resolved_a, avg(unix_timestamp(ca.solved_at)-unix_timestamp(ca.created_at)) as total_time_a
	from '.$case.' as ca where case_type=\'Feedback\'
	group by content_products_id,case_type) as a
	
	left outer join (select content_products_id,count(content_products_id) as Total_a from '.$case.' where case_type=\'Feedback\' group by content_products_id) as d
	on a.content_products_id=d.content_products_id)
	
	left outer join
	
	((select content_products_id,case_type,count(content_products_id) as Total_b,count(status)
	as Resolved_b, avg(unix_timestamp(solved_at)-unix_timestamp(created_at)) as total_time_b
	from '.$case.' where case_type=\'Enquiry\'
	group by content_products_id,case_type) as b 
	
	left outer join (select content_products_id,count(content_products_id) as Total_b from '.$case.' where case_type=\'Enquiry\' group by content_products_id) as e
	on b.content_products_id=e.content_products_id) on a.content_products_id=b.content_products_id
	
	left outer join
	
	((select content_products_id,case_type,count(content_products_id) as Total_c,count(status)
	as Resolved_c, avg(unix_timestamp(solved_at)-unix_timestamp(created_at)) as total_time_c
	from '.$case.' where case_type=\'Complaint\'
	group by content_products_id,case_type) as c
	left outer join (select content_products_id,count(content_products_id) as Total_c from '.$case.' where case_type=\'Complaint\' group by content_products_id) as f
	on c.content_products_id=f.content_products_id) on a.content_products_id=c.content_products_id)
	
	right outer join (select product_name,id from maybank.content_products) as co on a.content_products_id=co.id';
        */
	/*$sql = 'SELECT co.product_name,count(*) as total, avg(unix_timestamp(ca.solved_at)-unix_timestamp(ca.created_at)) as average_response,
		(select count(status) from `case` inca where inca.status=\'solved\' and inca.case_type = ca.case_type
		and inca.content_products_id = ca.content_products_id) as solved_count, case_type, content_products_id
		FROM maybank.case as ca
		left join maybank.content_products as co on ca.content_products_id=co.id group by case_type, content_products_id';
	*/
	$sql = "select cp.product_name, 
		    count(case when case_type='enquiry' then 1 else null end) as enquiry,
		    count(case when case_type='feedback' then 1 else null end) as feedback,
		    count(case when case_type='complaint' then 1 else null end) as complaint,
			count(case when case_type='enquiry' and status='solved'  then 1 else null end) as enquiry_solv,
		    count(case when case_type='feedback' and status='solved' then 1 else null end) as feedback_solv,
		    count(case when case_type='complaint' and status='solved' then 1 else null end) as complaint_solv,
			avg(case when case_type='feedback' then (unix_timestamp(cs.solved_at)-unix_timestamp(cs.created_at)) else 0 end) as feedback_time,
			avg(case when case_type='enquiry' then (unix_timestamp(cs.solved_at)-unix_timestamp(cs.created_at)) else 0 end) as enquiry_time,
			avg(case when case_type='complaint' then (unix_timestamp(cs.solved_at)-unix_timestamp(cs.created_at)) else 0 end) as complaint_time
		from `case` cs left join content_products  cp on cs.content_products_id= cp.id
		group by cp.id";
        $query = $this->db->query($sql);
        
        return $query->result();
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
	
	$this->db->where($range);
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
	
	$this->db->where($range);
	$count =  $this->db->count_all_results();
	return $count;
    }
    
    function generate_report_activity($date){
	//read from all the table which contain created_at field must larger than the date
	$now = date('Y-m-d H:i:s');
	
	//read channel_action
	$this->db->select('username, role_name, action_type, role_collection.country_code, channel_action.created_at');
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
	$this->db->select('username, role_name, case_id, messages, role_collection.country_code, case.created_at');
	$this->db->from('case');
	$this->db->join('user','case.created_by = user.user_id');
	$this->db->join('role_collection','user.role_id = role_collection.role_collection_id');
	$this->db->where("case.created_at > '".$date."'");
	$this->db->order_by('case.created_at');
	$result = $this->db->get()->result();
	
	//store case
	foreach($result as $row){
	    $value[] = array('username' => $row->username,
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
	$this->db->select('username, role_name, name, role_collection.country_code, channel.token_created_at');
	$this->db->from('channel');
	$this->db->join('user','channel.created_by = user.user_id');
	$this->db->join('role_collection','user.role_id = role_collection.role_collection_id');
	$this->db->where("channel.token_created_at > '".$date."'");
	$this->db->order_by('channel.token_created_at');
	$result = $this->db->get()->result();
	
	//store channel
	foreach($result as $row){
	    $value[] = array('username' => $row->username,
			   'rolename' => $row->role_name,
			   'action' => 'Create New Channel',
			   'status' => $row->name,
			   'country_code' => $row->country_code,
			   'time' => $row->token_created_at,
			   'created_at' => $now
			   );
        }
        
	//read content_campaign
	$this->db->select('username, role_name, campaign_name, role_collection.country_code, content_campaign.created_at');
	$this->db->from('content_campaign');
	$this->db->join('user','content_campaign.user_id = user.user_id');
	$this->db->join('role_collection','user.role_id = role_collection.role_collection_id');
	$this->db->where("content_campaign.created_at > '".$date."'");
	$this->db->order_by('content_campaign.created_at');
	$result = $this->db->get()->result();
	
	//store content_campaign
	foreach($result as $row){
	    $value[] = array('username' => $row->username,
			   'rolename' => $row->role_name,
			   'action' => 'Create New Campaign',
			   'status' => $row->campaign_name,
			   'country_code' => $row->country_code,
			   'time' => $row->created_at,
			   'created_at' => $now
			   );
        }
	
	//read content_products
	$this->db->select('username, role_name, product_name, role_collection.country_code, content_products.created_at');
	$this->db->from('content_products');
	$this->db->join('user','content_products.user_id = user.user_id');
	$this->db->join('role_collection','user.role_id = role_collection.role_collection_id');
	$this->db->where("content_products.created_at > '".$date."'");
	$this->db->order_by('content_products.created_at');
	$result = $this->db->get()->result();
	
	//store content_products
	foreach($result as $row){
	    $value[] = array('username' => $row->username,
			   'rolename' => $row->role_name,
			   'action' => 'Create New Product',
			   'status' => $row->product_name,
			   'country_code' => $row->country_code,
			   'time' => $row->created_at,
			   'created_at' => $now
			   );
        }
	
	//read content_tag
	$this->db->select('username, role_name, tag_name, role_collection.country_code, content_tag.created_at');
	$this->db->from('content_tag');
	$this->db->join('user','content_tag.user_id = user.user_id');
	$this->db->join('role_collection','user.role_id = role_collection.role_collection_id');
	$this->db->where("content_tag.created_at > '".$date."'");
	$this->db->order_by('content_tag.created_at');
	$result = $this->db->get()->result();
	
	//store content_tag
	foreach($result as $row){
	    $value[] = array('username' => $row->username,
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
	$this->db->select('username, x.role_name as xrole_name, role_collection.role_name, x.country_code, role_collection.created_at');
	$this->db->from('role_collection');
	$this->db->join('user','role_collection.created_by = user.user_id');
	$this->db->join('role_collection x','user.role_id = x.role_collection_id');
	$this->db->where("role_collection.created_at > '".$date."'");
	$this->db->order_by('role_collection.created_at');
	$result = $this->db->get()->result();
	
	//store role_collection
	foreach($result as $row){
	    $value[] = array('username' => $row->username,
			   'rolename' => $row->xrole_name,
			   'action' => 'Create new role',
			   'status' => $row->role_name,
			   'country_code' => $row->country_code,
			   'time' => $row->created_at,
			   'created_at' => $now
			   );
        }
	
	//read short_urls
	$this->db->select('username, role_name, short_code, role_collection.country_code, short_urls.created_at');
	$this->db->from('short_urls');
	$this->db->join('user','short_urls.user_id = user.user_id');
	$this->db->join('role_collection','user.role_id = role_collection.role_collection_id');
	$this->db->where("short_urls.created_at > '".$date."'");
	$this->db->order_by('short_urls.created_at');
	$result = $this->db->get()->result();
	
	//store short_urls
	foreach($result as $row){
	    $value[] = array('username' => $row->username,
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
	$this->db->select('x.username as xusername, user.username, role_name, role_collection.country_code, user.created_at, user.created_by');
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
	$this->db->select('username, role_name, group_name, role_collection.country_code, user_group.created_at');
	$this->db->from('user_group');
	$this->db->join('user','user_group.created_by = user.user_id');
	$this->db->join('role_collection','user.role_id = role_collection.role_collection_id');
	$this->db->where("user_group.created_at > '".$date."'");
	$this->db->order_by('user_group.created_at');
	$result = $this->db->get()->result();
	
	//store user_group
	foreach($result as $row){
	    $value[] = array('username' => $row->username,
			   'rolename' => $row->role_name,
			   'action' => 'Create '.$row->group_name,
			   'status' => '',
			   'country_code' => $row->country_code,
			   'time' => $row->created_at,
			   'created_at' => $now
			   );
        }
	
	//read user_login
	$this->db->select('username, role_name, role_collection.country_code, login_time, logout_time');
	$this->db->from('user_login_activity');
	$this->db->join('user','user_login_activity.user_id = user.user_id');
	$this->db->join('role_collection','user.role_id = role_collection.role_collection_id');
	$this->db->where("user_login_activity.login_time > '".$date."'");
	$this->db->order_by('user_login_activity.login_time');
	$result = $this->db->get()->result();
	
	//store user_login
	foreach($result as $row){
	    $value[] = array('username' => $row->username,
			   'rolename' => $row->role_name,
			   'action' => 'Login',
			   'status' => '',
			   'country_code' => $row->country_code,
			   'time' => $row->login_time,
			   'created_at' => $now
			   );
	    
	    $value[] = array('username' => $row->username,
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
}