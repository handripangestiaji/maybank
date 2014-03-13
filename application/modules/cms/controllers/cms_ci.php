<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cms_Ci extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('campaign_model');
    }
    
    public function download_campaign($campaign_id){
        $data['shorturls'] = $this->campaign_model->getForDownload($campaign_id)->result();
        $data['products'] = $this->campaign_model->getProductsByCampaign($campaign_id)->result();
        $this->output->set_header("Content-Type: application/vnd.ms-excel; charset=" . 'UTF-8');
        $this->output->set_header("Content-Disposition: inline; filename=\"" . 'perumahan' . ".xls\"");
        $this->load->view('cms/excel',$data);
    }
}