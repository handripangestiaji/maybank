<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends Login_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if($this->input->server('REQUEST_METHOD') === 'POST')
		{
			$params['username'] = $this->input->post('username');
			$params['password'] = $this->input->post('password');
			
			$result = $this->auth($params);
			if($result == TRUE) {
				redirect('dashboard');
			}
			else
			{
				redirect('login');
			}
		} 
		
		$this->load->view('login/index');
	}
	
	private function auth($params = array())
	{
		if($params['username'] == 'admin' && $params['password'] == 'admin')
		{
			$return = TRUE;
		}
		else {
			$return = FALSE;
		}
		
		return $return;
	}
	
	public function terms(){
		$this->load->view('terms');
	}
	
	public function forgot(){
		$this->load->view('forgot');	
	}
}