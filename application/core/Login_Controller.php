<?php
class Login_Controller extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function _output($content)
	{
		$data['content'] = &$content;
		
		echo($this->load->view('layout_login', $data, true));
	}
}