<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set("display_error", 1);
class validation{
        
    function set($types, $name, $value, $fine_name)
    {
        $types = explode('|',$types);
        foreach($types as $type){
            switch($type){
                case 'required';
                    if(empty($value)){
                        return array('result' => FALSE,'name' => $name,'message' => $fine_name." is required."); 
                    }
                    else{
                        break;
                    }
                case 'is_email';
                     if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $value)){
                        break;
                     }
                     else{
                        return array('result' => FALSE,'name' => $name,'message' => "Email is not valid."); 
                     }
                case 'valid_email';
                    require_once BASEPATH.'database/DB'.EXT;
                    
                    if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $value)){
                        $db = DB('', false);
                        $db->select('*');
                        $db->where('email',$value);
                        $db->from('user');
                        $count = $db->count_all_results();
                      
                        if($count != 0){
                            return array('result' => FALSE,'name' => $name,'message' => "Email has been registered");
                        }
                        else{
                            break;
                        }
                    }
                    else{
                        return array('result' => FALSE,'name' => $name,'message' => "Email is not valid.");   
                    }
                case 'valid_captcha';
                    if ($value["recaptcha_response_field"]) {
                            $resp = recaptcha_check_answer ('6LeDjc8SAAAAAFRPgm2b8FJg-gVBtHbI7wJff8xt',
                                                            $_SERVER["REMOTE_ADDR"],
                                                            $value["recaptcha_challenge_field"],
                                                            $value["recaptcha_response_field"]);
                    
                            if ($resp->is_valid) {
                                    break;
                            } else {
                                    # set the error code so that we can display it
                                    $error = $resp->error;
                                    return array('result' => FALSE,'name' => $name,'message' => $error);
                                    
                            }
                    }
                    break;
                case 'valid_username';
                    require_once BASEPATH.'database/DB'.EXT;
                    if(preg_match("/^[a-zA-Z_0-9]{5,32}$/", $value)){
                        
                        
                        $db = DB('', false);
                        
                        $db->select('username');
                        $db->where('username',$value);
                        $db->from('reg_user');
                        $count = $db->count_all_results();
                      
                        if($count != 0){
                            return array('result' => FALSE,'name' => $name,'message' => "Username sudah teregistrasi, silakan ganti ke username lainnya.");
                        }
                        else{
                            break;
                        }
                    }
                    else{
                        return array('result' => FALSE,'name' => $name,'message' => "Username hanya boleh menggunakan kombinasi huruf(A-Z), angka atau underscore(_) dan harus lebih dari 6 karakter.");
                    }
                   
                case 'valid_date';
                    
                    $date = explode('/',$value);
                    if(isset($date[0],$date[1],$date[2]) == FALSE OR checkdate($date[1],$date[2],$date[0]) == FALSE){
                        return array('result' => FALSE,'name' => $name,'message' => "Tanggal tidak valid.");
                    }
                    else{
                        break;
                    }
                case 'valid_gender';
                    if($value == 'M' || $value == 'F')
                    {
                        break;
                    }
                    else{
                        return array('result' => FALSE,'name' => $name,'message' => "Gender tidak valid.");
                    }
                case 'valid_numeric';
                    if(is_numeric($value) == FALSE){
                        return array('result' => FALSE,'name' => $name,'message' => "Value yang bukan berupa angka.");    
                    }
                    else{
                        break;
                    }
                case 'valid_name';
                    if(!preg_match("/^[a-zA-Z. ]{2,}$/", $value))
                        return array('result' => FALSE,'name' => $name,'message' => "Nama tidak valid. ");
                    else
                        break;
                case 'valid_postal_code';
                    if(!preg_match("/^[0-9]{5}$/", $value))
                        return array('result' => FALSE,'name' => $name,'message' => "Kode pos tidak valid. ");
                    else
                        break;
                    
                 case 'valid_postal_code';
                    if(!preg_match("/^[0-9]{5}$/", $value))
                        return array('result' => FALSE,'name' => $name,'message' => "Kode pos tidak valid. ");
                    else
                        break;
                 case 'valid_password';
                    if(strlen($value) < 6){
                        return array('result' => FALSE,'name' => $name,'message' => "Kata Sandi/Password harus lebih panjang dari 6 karakter. ");
                    }
                    break;
                default :
                    break;
            }
        }
        return array('result' => TRUE);
    }
}

/* End of file validation.php */
/* Location: ./application/libraries/validation.php */