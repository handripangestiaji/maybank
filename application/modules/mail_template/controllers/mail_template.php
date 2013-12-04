<?php
    
/*
    Created by Eko Purnomo (eko.purnomo@icloud.com) which are purposed to styling mail.
*/
class mail_template extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->model('case_model');
    }
    
    
    public function AssignCase($view, $id){
        $data['case_object'] = $this->case_model->LoadCase(array(
                                'case_id' => $id));
        $this->load->view('AssignCase/'.$view, $data);
    }
}

?>