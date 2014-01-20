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
}