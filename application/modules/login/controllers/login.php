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
                redirect('dashboard');
            }
            $this->load->model('users_model');
            $this->load->helper('security');
	    $this->load->config('mail_config');
	    $config = $this->config->item('mail_provider');
	    $this->load->library('email',$config);
	    $this->load->library('form_validation');
        }
        
        function index()
        {
            $this->load->view('login/index');
        }
        
        function auth()
        {
            $username = $this->input->post('username');
            $salt = $this->users_model->get_byname($username);
            if($salt->num_rows()==1)
            {
                $password = do_hash($this->input->post('password').$salt->row()->salt,'md5');
                
                $valid = $this->users_model->check($username,$password);
                
                if($valid->num_rows() == 1)
                {
		    $user_login = $this->users_model->select_user_login($valid->row()->user_id);
		    
		    $data = array(
                                'user_id' => $valid->row()->user_id,
				'username' => $username,
				'full_name'=> $user_login->row()->full_name,
				'display_name' => $user_login->row()->display_name,
				'role_name' => $user_login->row()->role_name,
				'role_id' => $user_login->row()->role_id,
				'web_address' => $user_login->row()->web_address,
				'image_url' => $user_login->row()->image_url,
				'description' => $user_login->row()->description,
				'group_id' => $user_login->row()->group_id,
				'timezone' => $user_login->row()->timezone,
                                'is_login' => TRUE
                            );
                    $timezone = new DateTimeZone("Europe/London");
                    $time = new DateTime(date("Y-m-d H:i:s e"), $timezone);
                    $this->session->set_userdata($data);
		    
		    $login_activity = array(
						'user_id' => $valid->row()->user_id,
						'login_time' => $time->format("Y-m-d H:i:s")
					    );
		    $this->users_model->update_user($data['user_id'], array('timezone' => $this->input->post('timezone')));
                    $this->users_model->insert_activity($login_activity);
                    redirect('dashboard');
                }
                else
                {
		    $this->session->set_flashdata('message', TRUE);
                    redirect('login');
                }
            }
            else
            {
		$this->session->set_flashdata('message', TRUE);
                redirect('login');
            }
            
        }
	
	public function terms(){
		$this->load->view('terms');
	}
	
	public function forgot(){
		$data1['success']=NULL;
		$data1['failed']=NULL;
		$this->load->view('forgot',$data1);	
	}
	
	function reset_pass()
	{
	    $email = $this->input->post('username');
	    $check_mail = $this->users_model->check_email($email);
	    
	    $this->form_validation->set_rules('username', 'Email', 'required|valid_email');
	    if($this->form_validation->run() == FALSE)
	    {
		$data1['success']=NULL;
		$data1['failed']=NULL;
		$this->load->view('forgot',$data1);
	    }
	    
	    elseif($check_mail->num_rows() == 1)
	    {
		    $id = $check_mail->row()->user_id;
		    
		    /*$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		    $count = mb_strlen($chars);
	      
		    for ($i = 0, $pass = ''; $i < 10; $i++) {
		    $index = rand(0, $count - 1);
		    $pass .= mb_substr($chars, $index, 1);
		    }*/
		    $lower = 'abcdefghijklmnopqrstuvwxyz';
		    $upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		    $number = '0123456789';
		    $simbol = '!@#$%';
		    
		    $clower = mb_strlen($lower);
		    $cupper = mb_strlen($upper);
		    $cnumber = mb_strlen($number);
		    $csimbol = mb_strlen($simbol);
		    
		    for ($i = 0, $low = ''; $i < 3; $i++) {
			$index1 = rand(0, $clower - 1);
			$low  .= mb_substr($lower, $index1, 1);
		    }
		    
		    for ($i = 0, $up = ''; $i < 3; $i++) {
			$index2 = rand(0, $cupper - 1);
			$up  .= mb_substr($upper, $index2, 1);
		    }
		    
		    for ($i = 0, $num = ''; $i < 2; $i++) {
			$index3 = rand(0, $cnumber - 1);
			$num  .= mb_substr($number, $index3, 1);
		    }
		    
		    for ($i = 0, $sim = ''; $i < 2; $i++) {
			$index4 = rand(0, $csimbol - 1);
			$sim  .= mb_substr($simbol, $index4, 1);
		    }
		    
		    $pass = str_shuffle(mb_substr($low.$up.$num.$sim,0,10));
		    
		    
		    $data = array(
				  'password' => do_hash($pass.$check_mail->row()->salt,'md5')
				  );
		    
		    $this->users_model->update_pass($id,$data);
		    
		    $this->email->set_newline("\r\n");
		    $this->email->from('tes@gmail.com','maybank');
		    $this->email->to($email);
		    $this->email->cc('monitoring@kalajeda.com');
		    
		    $this->email->subject('Forgot Password');
		    $template = curl_get_file_contents(base_url('mail_template/ForgotPass/'.$id.'/'.urlencode($pass)));
		    $this->email->message($template);
		    
		    $this->email->send();
		    
		    $data1['success']=1;
		    $data1['failed']=NULL;
		    $this->load->view('forgot',$data1);
		    //redirect('login');
	    }
	    else
	    {
		    $data1['success']=NULL;
		    $data1['failed']=1;
		    $this->load->view('forgot',$data1);
	    }
	}
}