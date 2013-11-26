<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends Login_Controller {

	/*public function __construct()
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
	}*/
	function __construct()
        {
            parent::__construct();
            
            if($this->session->userdata('is_login'))
            {
                redirect('users');
            }
            
            $this->load->model('users_model');
            $this->load->helper('security');
            
        }
        
        function index()
        {
            $this->load->view('login/index');
        }
        
        function auth()
        {
            $username = $this->input->post('username');
            
            $salt = $this->users_model->get_byid($username);
            if($salt->num_rows()==1)
            {
                $password = do_hash($this->input->post('password').$salt->row()->salt,'md5');
                
                $valid = $this->users_model->check($username,$password);
                
                if($valid->num_rows() == 1)
                {
                    $data = array(
                                'user_id' => $username,
                                'is_login' => TRUE
                            );
                    $timezone = new DateTimeZone("Europe/London");
                    $time = new DateTime(date("Y-m-d H:i:s e"), $timezone);
                    $this->session->set_userdata($data);
                        $login_activity = array(
                                                    'user_id' => $username,
                                                    'login_time' => $time->format("Y-m-d H:i:s")
                                                );
                        $this->users_model->insert_activity($login_activity);
                    redirect('users');
                }
                else
                {
                    redirect('login');
                }
            }
            else
            {
                redirect('login');
            }
            
        }
	
	public function terms(){
		$this->load->view('terms');
	}
	
	public function forgot(){
		$this->load->view('forgot');	
	}
	
	function reset_pass()
	{
		$email = $this->input->post('username');
		$check_mail = $this->users_model->check_mail($email);
		
		if($check_mail->rows() == 1)
		{
			
		}
	}
}