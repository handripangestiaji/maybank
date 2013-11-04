<?php
class MY_Controller extends CI_Controller {
	
	public $_access_level = "";
	
	function __construct()
	{
		parent::__construct();
	}
	
	function _output($content)
	{
		$data['content'] = &$content;
		
		echo($this->load->view('layout', $data, true));
	}
}