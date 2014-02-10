<?php
class MY_Controller extends CI_Controller {
	
	public $_access_level = "";
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('case_model');
		
	}
	
	function _output($content)
	{
		$this->load->model('users_model');
		$data['content'] = &$content;
		$data['case'] = $this->case_model->LoadCase(array(
			'assign_to' => $this->session->userdata('user_id'),
			'status' => 'pending'
		));
		$data['timezones'] = get_timezone_list();
		$data['assign'] = $this->case_model->LoadAssign();
		$data['count_assign'] = $this->case_model->LoadAssign()->num_rows();
		$data['assign1'] = $this->case_model->LoadCase(array(
			'created_by' => $this->session->userdata('user_id'),
			'status' => 'pending'
		));

		$data['reply_pending'] = $this->case_model->GetReplyNotification($this->session->userdata('user_id'));
		$data['groups'] = $this->users_model->select_group(array('group_id'=> $this->session->userdata('group_id')));
		echo($this->load->view('layout', $data, true));
	}
}