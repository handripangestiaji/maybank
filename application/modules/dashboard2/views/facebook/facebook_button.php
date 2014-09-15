<?php
    $buttonItems = array();
    
    $buttonItems['reply'] = '<button type="button" class="btn btn-primary btn-reply" value="'.$reply_type.'"><i class="icon-mail-reply"></i></button>';
    if(count($post->case) == 0){
        $buttonItems['case'] = '<button type="button" item="'.$reply_type.'" class="btn btn-danger btn-case" name="action" value="case"><i class="icon-plus"></i> <span>CASE</span></button> ';
    }
    else{
        if($post->case[0]->status == 'pending'){
            $buttonItems['case'] = 
            '<button type="button"  item="'.$reply_type.'" class="btn btn-purple btn-resolve" name="action" value="'.$post->case[0]->case_id.'">
            <i class="icon-check"></i> <span>RESOLVE</span></button> <button type="button"  item="'.$reply_type.'" class="btn btn-danger btn-case" name="action" value="reassign">
            <i class="icon-plus"></i> <span>ReAssign</span></button>';
        }
        else{
            $buttonItems['case'] = '<button type="button" class="btn btn-danger btn-case" name="action" item="'.$reply_type.'" value="new_case">
                                    <i class="icon-plus"></i> <span>Case</span></button> ';
        }
    }
    if($this->session->userdata('country') == $post->country_code){
        $buttonItems['reply'] = IsRoleFriendlyNameExist($this->user_role, array ('Social Stream_Channel_General_Function_Own_Country_Reply',
                                                                                 'Social Stream_Channel_General_Function_All_Country_Reply')) ?
                                $buttonItems['reply'] : '';
        $buttonItems['case'] = IsRoleFriendlyNameExist($this->user_role, array ('Social Stream_Case_All_Country_AssignReassignResolved',
                                                                                'Social Stream_Case_Own_Country_AssignReassignResolved')) ?
                                $buttonItems['case'] : '';
    }
    else{
        $buttonItems['case'] = IsRoleFriendlyNameExist($this->user_role, 'Social Stream_Case_All_Country_AssignReassignResolved') ?
                                $buttonItems['case'] : '';
        $buttonItems['reply'] = IsRoleFriendlyNameExist($this->user_role, 'Social Stream_Channel_General_Function_All_Country_Reply') ?
                                $buttonItems['reply'] : '';
    }
    foreach($buttonItems as $item)
        echo $item.' ';
?>
