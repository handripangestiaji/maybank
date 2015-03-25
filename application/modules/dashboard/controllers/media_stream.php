<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Media_stream extends CI_Controller {
    function __construct()
    {
	parent::__construct();
    }
    
    public function SafePhoto(){
	$safe_photo = $this->input->cookie("safe_photo");
	if(!$safe_photo){
	    $cookie = array(
		'name'   => 'safe_photo',
		'value'  => time(),
		'expire' => '3600',
		//'domain' => $_SERVER['HTTP_HOST'],
		'path'   => '/',
		'secure' => FALSE
	    );
	    $this->input->set_cookie($cookie);
	}
	
        $new_photo_param = '';
	foreach($this->input->get() as $key=>$value){
	    if($key!='photo'){
		$new_photo_param .= '&'.$key.'='.$value;
	    }
	    else{
		$new_photo_param = $value;
	    }
	}
	
	$md5_photo = md5($this->input->get('photo')).".jpg";
	
	if(!is_dir("./media/dynamic/tmp_photo/"))
	    mkdir(getcwd()."/media/dynamic/tmp_photo/");
	
	if(file_exists("./media/dynamic/tmp_photo/".$md5_photo) && $safe_photo && (filesize("./media/dynamic/tmp_photo/".$md5_photo) > 0)){	
	    echo $md5_photo;
	}
	else{
	    file_put_contents("./media/dynamic/tmp_photo/".$md5_photo, file_get_contents(urldecode($new_photo_param)));
	    echo $md5_photo;
	}
    }
}