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
    
    
    /*
    * Generate Report for 
    */
    function create_report($channel_id, $user_id, $date_start, $date_finish, $ug_id = null)
    {
	$ug_id = $ug_id == null || $ug_id == 'All'? 'null' : "'$ug_id'";
	$sql_report = "call sp_ReportPerformance('$channel_id', $ug_id, '$user_id', '$date_start', '$date_finish');";
	$q = $this->db->query($sql_report);
	$references_report = $q->row();
	return $references_report->my_code;
    }
    
    /*
    * Filter_report
    * $current_code : Country Code to generate reports...
    * $case_type : Type of case, there is feedback, report abuse, enquiries, and complaints 
    */
    function filter_report($current_code, $case_type = null){
	$query = $this->filter_query_build(array(), "group by type, product_name", $current_code, $case_type);
	$main_val =$this->db->query($query)->result();
	
	$summary_per_parent = $this->filter_query_build(array('c.parent_id', 'type', 'type2',  'sum(total_case) as total_case', 'sum(total_solved) as total_solved',
	    'avg(average_response) as average_response'),
	    "group by type, type2, c.parent_id", $current_code, $case_type );
	
	$summary_all = $this->filter_query_build(array('type', 'type2',  'sum(total_case) as total_case', 'sum(total_solved) as total_solved',
	    'avg(average_response) as average_response'),
	    "group by type, type2", $current_code, $case_type);
	$return_value = array(
	    "main"  => $this->configure_time_lapse($main_val),
	    "main_per_parent" => $this->configure_time_lapse($this->db->query($summary_per_parent)->result()),
	    "main_summary" => $this->configure_time_lapse($this->db->query($summary_all)->result()),
	    "product_list" => $this->load->model('campaign_model')->GetProductBasedOnParent(),
	    "type" => 'case'
	);
	return $return_value;
    }
    
    function configure_time_lapse($collection){
	foreach($collection as $row){
	    $row->average_response_string = time_elapsed_A($row->average_response);
	}
	return $collection;
    }
    
    function filter_query_build($field = array(), $group_by, $current_code, $case_type = null){
	$field =  count($field) == 0  ? array('c.id', 'c.product_name', 'c.parent_id', 'type', 'type2', 'product_parent_id', 'sum(total_case) as total_case', 'sum(total_solved) as total_solved', 'avg(average_response) as average_response') :
		    $field;
	$field_array = join(',', $field);
	$query = "SELECT ".$field_array." FROM report_performance b
	    RIGHT JOIN content_products c on c.id = b.product_id 
    	WHERE b.code = '$current_code' ".($case_type == null ? "" : " AND b.case_type = '$case_type'"). " $group_by  ".
	"ORDER BY COALESCE(c.parent_id, c.`id`), c.`parent_id` is not null, c.id";
	return $query;
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
	    
	    $logout_time = $row->logout_time;
	    if($logout_time == null){
		$logout_time = date('Y-m-d H:i:s',strtotime('+2 hours', strtotime($row->login_time)));
	    }
	    
	    $value[] = array('username' => $row->username,
			     'user_id' => $row->user_id,
			    'group_id' => $row->group_id,
			   'rolename' => $row->role_name,
			   'action' => 'Logout',
			   'status' => '',
			   'country_code' => $row->country_code,
			   'time' => $logout_time,
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
    
    public function getCase($filter){
	if($filter['group_id'] == 'All' || $filter['group_id'] == null){
	    $where_group_id = '';
	}
	else{
	    $where_group_id = 'and ug.group_id = '.$filter['group_id'];
	}
	
	$date_start = str_replace('/', '-', $filter['date_start']);
	$date_end = str_replace('/', '-', $filter['date_finish']);
	
	$date_start = DateTime::createFromFormat('Y/m/d', $filter['date_start']);
	$date_finish = DateTime::createFromFormat('Y/m/d', $filter['date_finish']);

	$query = "SELECT c.case_id, c.created_at, ch.channel_id,  cp.id, cp.product_name,
	c.case_type , ug.group_id, ug.group_name as user_group, ss.`type`, sst.`type` as type2, 366653, NOW()
FROM `case` c inner join social_stream ss on c.post_id = ss.post_id
	inner join content_products cp on cp.id = c.content_products_id
	left join social_stream_twitter sst on sst.post_id = ss.post_id 
	inner join channel ch on ch.channel_id = ss.channel_id
	inner join (user u  inner join user_group ug on u.group_id = ug.group_id) on u.user_id = c.created_by 
WHERE ss.channel_id = ".$filter['channel_id']." ".$where_group_id." and c.created_at >= '".$date_start->format('Y-m-d')."' and c.created_at <= '".$date_finish->format('Y-m-d')."';";

	return $this->db->query($query)->result();
    }
    
    public function getEngagementByCaseId($case_id){
	$this->db->select('*');
	$this->db->from('page_reply');
	$this->db->where('case_id',$case_id);
	return $this->db->get();
    }
}