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
	    $this->load->config('mail_config');
	    $config = $this->config->item('mail_provider');
	    $this->load->library('email',$config);
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
                    redirect('dashboard');
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
	    $check_mail = $this->users_model->check_email($email);
	    
	    if($check_mail->num_rows() == 1)
	    {
		    $id = $check_mail->row()->user_id;
		    
		    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		    $count = mb_strlen($chars);
	      
		    for ($i = 0, $pass = ''; $i < 10; $i++) {
		    $index = rand(0, $count - 1);
		    $pass .= mb_substr($chars, $index, 1);
		    }
		    $data = array(
				  'password' => do_hash($pass.$check_mail->row()->salt,'md5')
				  );
		    
		    $this->users_model->update_pass($id,$data);
		    
		    $this->email->set_newline("\r\n");
		    $this->email->from('robay.robby@gmail.com','robay');
		    $this->email->to($email);
		    
		    $this->email->subject('Your current Password');
		    $this->email->message('Username '.$check_mail->row()->user_id.' and password '.$pass);
		    
		    $this->email->send();
		    
		    redirect('login');
	    }
	    else
	    {
		    echo '';
	    }
	}
}