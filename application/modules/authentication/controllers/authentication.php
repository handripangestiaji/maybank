<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Authentication extends CI_Controller
    {
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
            $this->load->view('authentication/index');
        }
        
        function check_user()
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
                    
                    //$check_activity = $this->users_model->check_login_time($username);
                    //if($check_activity->num_rows()==1)
                    //{
                        $login_activity = array(
                                                    'user_id' => $username,
                                                    'login_time' => $time->format("Y-m-d H:i:s")
                                                );
                        $this->users_model->insert_activity($login_activity);
                    //}
                    redirect('users');
                }
                else
                {
                    redirect('authentication/index');
                }
            }
            else
            {
                redirect('authentication/index');
            }
            
        }
    }