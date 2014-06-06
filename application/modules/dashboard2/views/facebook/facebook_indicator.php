<?php
    $timezone = new DateTimeZone($this->session->userdata('timezone'));
    $indicator = array();
    if(count($post->case) > 0){
        $case_date = new DateTime($post->case[0]->created_at.' UTC');
        $case_date->setTimezone($timezone);
        
        $indicator['case'] = ' <button href="#caseNotification" data-toggle="modal" type="button" style="text-align:left" class="btn btn-mini  indicator-case '.
                                ($post->case[0]->status == 'pending' ? "btn-purple" : "btn-inverse").'">Case #'.$post->case[0]->case_id. 
                                ($post->case[0]->status == 'pending' ?  ' Assign To '.(isset($post->case[0]->assign_to->display_name) ? $post->case[0]->assign_to->display_name : " --Deleted User-- ")
                                 .'' : ' Solved by: '. (isset($post->case[0]->solved_by->display_name) ? $post->case[0]->solved_by->display_name : " --Deleted User-- "))." ".
                                $case_date->format("d-M-y h:i A").
                                '<input type="hidden" class="pointer-case" value="'.$post->case[0]->case_id.'" />'.
                                '</button>' ;
    }
    if(count($post->page_reply) > 0){
        $reply_date = new DateTime($post->page_reply[0]->created_at.' UTC');
        $reply_date->setTimezone($timezone);

        $indicator['reply'] = '<button type="button" class="btn btn-inverse btn-mini replied-btn" style="text-align:left"  value="'.$post->social_stream_post_id.'"> Replied By: '.
                        (isset($post->page_reply[0]->user->display_name) ? $post->page_reply[0]->user->display_name : "--Deleted User--" )." ".$reply_date->format("d-M-y h:i A").
                        "</button>";
        
        
    }
    if(count($post->page_reply) == 0 && count($post->case) == 0)
        $indicator['open'] = '<button type="button" class="btn btn-warning btn-mini no-cursor indicator open-thread" >OPEN</button>';

        
    
    foreach($indicator as $button)
        echo $button.' ';
?>

