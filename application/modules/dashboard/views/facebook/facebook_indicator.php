<?php
    $timezone = new DateTimeZone($this->session->userdata('timezone'));
    $indicator = array();
    if(count($post->case) > 0){
        $case_date = new DateTime($post->case[0]->created_at.' Europe/London');
        $case_date->setTimezone($timezone);
        
        $indicator['case'] = ' <button  href="#caseItem-'.$post->case[0]->case_id.'" data-toggle="modal" type="button" class="btn btn-mini  '.
                                ($post->case[0]->status == 'pending' ? "btn-purple" : "btn-inverse").'">Case #'.$post->case[0]->case_id. 
                                ($post->case[0]->status == 'pending' ?  ' Assign To '.$post->case[0]->assign_to->display_name : ' Solved by: '. $post->case[0]->solved_by->display_name)." ".
                                $case_date->format("d-M-y h:i A").
                                '</button>' ;
    }
    if(count($post->page_reply) > 0){
        $reply_date = new DateTime($post->page_reply[0]->created_at.' Europe/London');
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

