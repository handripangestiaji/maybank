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
		$data['content'] = &$content;
		$data['case'] = $this->case_model->LoadCase(array(
			'assign_to' => $this->session->userdata('user_id'),
			'status' => 'pending'
		));
		$data['reply_pending'] = $this->case_model->GetReplyNotification($this->session->userdata('user_id'));
		echo($this->load->view('layout', $data, true));
	}
}