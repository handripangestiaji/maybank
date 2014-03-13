


 <?php 
    if(isset($isMyCase[0]->assign_to)){
          // print_r($isMyCase[count($isMyCase)-1]);
          $case=new DateTime($isMyCase[count($isMyCase)-1]->solved_at.' Europe/London');
          $case->setTimezone($timezone);
            $sendDate=new DateTime($isMyCase[count($isMyCase)-1]->created_at.' Europe/London');
        if($isMyCase[count($isMyCase)-1]->assign_to==$this->session->userdata('user_id') or ($isMyCase[count($isMyCase)-1]->solved_by)){ ?>
            <button  href="#caseItem-<?php echo isset($isMyCase[count($isMyCase)-1]->case_id) ? $isMyCase[count($isMyCase)-1]->case_id : "" ?>" <?php if($isMyCase[count($isMyCase)-1]->status=="pending"){echo 'data-toggle="modal"';}?> type="button" value="<?php echo $isMyCase[count($isMyCase)-1]->case_id?>" class="btn <?php echo $fb_pm[$i]->case_id != null ? "btn-purple btn-mini case_related ".$fb_pm[$i]->social_stream_type : "btn-inverse btn-mini" ?>" style="text-align:left"><?php echo $fb_pm[$i]->case_id != null ? 'Case #'.$fb_pm[$i]->case_id.' Assign to You ' : 'Case #'.$isMyCase[count($isMyCase)-1]->case_id.' '.'Resolve By:'.$isMyCase[count($isMyCase)-1]->resolve_by.' '.$case->format('j-M-Y h:i A')?></button><?php
         }else{ ?>
            <button  href="#caseItem-<?php echo isset($isMyCase[count($isMyCase)-1]->case_id) ? $isMyCase[count($isMyCase)-1]->case_id : "" ?>" <?php if($isMyCase[count($isMyCase)-1]->status=="pending"){echo 'data-toggle="modal"';}?> type="button" value="<?php echo $isMyCase[count($isMyCase)-1]->case_id?>" class="btn <?php echo $fb_pm[$i]->case_id != null ? "btn-purple btn-mini case_related ".$fb_pm[$i]->social_stream_type : "btn-inverse btn-mini" ?>" style="text-align:left">
                <?php echo $fb_pm[$i]->case_id != null ? 'Case #'.$fb_pm[$i]->case_id.' Assign to: '.$isMyCase[count($isMyCase)-1]->display_name.' '.$sendDate->format('j-M-Y h:i A'): 'Replied'?>
            </button>  
        <?php }
            $assignCase=$this->case_model->CaseRelatedConversationItems(array('case_id'=>$isMyCase[count($isMyCase)-1]->case_id));
            $data['isMyCase'] = $assignCase;
            $data['caseMsg']=$isMyCase[count($isMyCase)-1];
            $data['assign_case_type']='facebook';
            $this->load->view('dashboard/case_item', $data);
            

    } ?>
    <p class="indicator">
        <?php //print_r($fb_pm[$i]->channel_action);
        
        if(isset($fb_pm[$i]->reply_post[0])){
            if(isset($fb_pm[$i]->channel_action[count($fb_pm[$i]->channel_action) - 1])){?>        
          <button type="button" class="btn btn-inverse btn-mini replied-btn" style="text-align:left"  value="<?php echo $fb_pm[$i]->reply_post[0]->post_id?>">
        <?php
        $reply_date = new DateTime($fb_pm[$i]->channel_action[count($fb_pm[$i]->channel_action) - 1]->created_at);
        $reply_date->setTimezone($timezone);
        echo "Replied by: ".$fb_pm[$i]->channel_action[count($fb_pm[$i]->channel_action) - 1]->display_name." ".$reply_date->format("d-M-y h:i A") ?>
        </button> <?php            
        }else{?>
        <button type="button" class="btn btn-warning btn-mini no-cursor indicator open-thread" >OPEN</button>       
         <?php }
        }
        ?>
        