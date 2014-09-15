<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Routes extends CI_Controller {
    function __construct()
     {
	parent::__construct();
    }
    
    function ShortURL($code){
        $this->load->model('shorturl_model');
	$short_url = $this->shorturl_model->find(array('short_code' => $code));
        $this->output->set_header("Location: ".$short_url->long_url); 
    }
}