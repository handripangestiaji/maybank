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
	$sql = 'SELECT co.product_name,count(*) as total, avg(unix_timestamp(ca.solved_at)-unix_timestamp(ca.created_at)) as average_response,
		(select count(status) from `case` inca where inca.status=\'solved\' and inca.case_type = ca.case_type
		and inca.content_products_id = ca.content_products_id) as solved_count, case_type, content_products_id
		FROM maybank.case as ca
		left join maybank.content_products as co on ca.content_products_id=co.id group by case_type, content_products_id';
		
        $query = $this->db->query($sql);
        
        return $query->result();
    }
}