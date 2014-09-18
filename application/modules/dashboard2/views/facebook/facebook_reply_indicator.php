<?php
    $timezone = new DateTimeZone($this->session->userdata('timezone'));
    $indicator = array();
    
    if(count($comment->case) > 0){
        $case_date = new DateTime($comment->case[0]->created_at.' UTC');
        $case_date->setTimezone($timezone);
        
        $indicator['case'] = ' <button href="#caseNotification" data-toggle="modal" type="button" style="text-align:left" class="btn btn-mini  indicator-case '.
                                ($comment->case[0]->status == 'pending' ? "btn-purple" : "btn-inverse").'">Case #'.$comment->case[0]->case_id. 
                                ($comment->case[0]->status == 'pending' ?  ' Assign To '.(isset($comment->case[0]->assign_to->display_name) ? $comment->case[0]->assign_to->display_name : " --Deleted User-- ")
                                 .'' : ' Solved by: '. (isset($comment->case[0]->solved_by->display_name) ? $comment->case[0]->solved_by->display_name : " --Deleted User-- "))." ".
                                $case_date->format("d-M-y h:i A").
                                '<input type="hidden" class="pointer-case" value="'.$comment->case[0]->case_id.'" />'.
                                '</button>' ;
    }
    
    if($last_reply && ($comment->comment_id == 0)){
        $reply_date = new DateTime($last_reply->created_at.' UTC');
        $reply_date->setTimezone($timezone);
        
        $indicator['reply'] = '<button type="button" class="btn btn-inverse btn-mini replied-btn" style="text-align:left"  value="'.$last_reply->comment_post_id.'"> Replied By: '.
                        (isset($last_reply->page_reply_name) ? $last_reply->page_reply_name : "--Deleted User--" )." ".$reply_date->format("d-M-y h:i A").
                        "</button>";
    }
    
    if(!$last_reply && ($comment->comment_id == 0) && (count($comment->case) == 0))
        $indicator['open'] = '<button type="button" class="btn btn-warning btn-mini no-cursor indicator open-thread" >OPEN</button>';
    
    foreach($indicator as $button)
        echo $button.' ';
?>

