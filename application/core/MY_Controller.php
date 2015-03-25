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
	
	}
}