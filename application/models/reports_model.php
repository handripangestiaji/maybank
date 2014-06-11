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
	WHERE a.code = '$current_code' ".($case_type == null ? "" : " AND a.case_type = '$case_type'").
	"GROUP By b.id";
	$q = $this->db->query($query.", a.type, a.type2");
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
	$q2 = $this->db->query($query);
	$result_array[2] = $q2->result();
	
	$result_array[3] = $this->load->model('campaign_model')->GetProductBasedOnParent();
	
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
}