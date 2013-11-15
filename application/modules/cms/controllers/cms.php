<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cms extends MY_Controller {
     public function index()
     {
          $data['cms_view'] = 'campaign_table';
          $this->load->view('cms/index',$data);
     }
     
     public function create_campaign(){
          $data['cms_view'] = 'create_campaign';
          $this->load->view('cms/index',$data);
     }
}