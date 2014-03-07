<?php 
//print_r($fb_pm);    
$total_groups = ceil($CountPmFB[0]->count_post_id/$this->config->item('item_perpage'));
$timezone=new DateTimeZone($this->session->userdata('timezone'));
for($i=0; $i<count($fb_pm);$i++):

$isMyCase=$this->case_model->chackAssignCase(array('a.post_id' => $fb_pm[$i]->post_id, 'a.status <>'=>'reassign'));
//print_r($isMyCase);
//echo $fb_pm[$i]->post_id."{pm-feed}".$fb_pm[$i]->post_id;
//print_r($fb_pm[$i]);
?>
<li id="post<?=$fb_pm[$i]->post_id?>" class="<?php if(isset($isMyCase[0]->assign_to)){echo "case_".$isMyCase[0]->case_id;} ?>">
    <input type="hidden" class="postId" value="<?php echo $fb_pm[$i]->post_id; ?>" />
    <div class="circleAvatar"><img src="<?=base_url('dashboard/media_stream/SafePhoto?photo=')."https://graph.facebook.com/".number_format($fb_pm[$i]->sender, 0,'.','')?>/picture?small" alt=""></div>
     <?php if (IsRoleFriendlyNameExist($this->user_role, 'Social Stream_Current_Take Action')):?>
    <div class="read-mark <?php if($fb_pm[$i]->is_read==0){echo 'redText';} else { echo 'greyText'; } ?>"><i class="icon-bookmark icon-large"></i></div>
    <?php endif ?>
    <br />
    <p class="headLine">
        <span class="author"><?php echo $fb_pm[$i]->name; ?></span>
        <i class="icon-circle"></i>
        <span>posted a <span class="cyanText">message</span></span>
        <i class="icon-circle"></i>
        <span>
        <?php 
            $date=new DateTime($fb_pm[$i]->post_date.' Europe/London');
            $date->setTimezone($timezone);
            echo $date->format('l, M j, Y h:i A');
            
        ?>
        
    </p>
    <p><?=$fb_pm[$i]->snippet?></p>
    <p class="indicator">
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
    </p>
        <!--button class="btn btn-primary btn-mini" style="margin-left: 5px;">LIKE</button--> </p>
    <p>
        <span class="btn-engagement"><i class="icon-eye-open"></i> <?php echo $fb_pm[$i]->message_count-1;?> Engagements</span>
    </p>

    <!-- ENGAGEMENT -->    
    <div class="engagement hide">
        <div class="engagement-header">
            <span class="engagement-btn-close btn-close pull-right">Close <i class="icon-remove-sign"></i></span>
        </div>
        <br>
        <?php 
            $comment=$this->facebook_model->RetrievePmDetailFB(array('a.conversation_id'=>$fb_pm[$i]->conversation_id));
            for($j=0;$j<count($comment);$j++){
        ?>
        <div class="engagement-body">
            <span class="engagement-btn-hide-show btn-close pull-right"><i class="icon-caret-down"></i></span>    
            <p class="headLine">
                <span class="author"><?php echo $comment[$j]->name; ?></span>
                <i class="icon-circle"></i>
                <span>posted a <span class="cyanText">comment</span></span>
                <i class="icon-circle"></i>
                <span><?php
                $created_detail_pm = new DateTime($comment[$j]->created_at);
                $created_detail_pm->setTimezone($timezone);
                echo $created_detail_pm->format('l, M j, Y h:i A'); ?></span>
               
            </p>
            <div>
                <p>"<?php echo RemoveUrlWithin($comment[$j]->messages); ?>"</p>
            </div>
        </div>
       <?php } ?>
       <!-- ==================== CONDENSED TABLE HEADLINE ==================== -->
        <div href='#modal-action-log-<?php echo $fb_pm[$i]->post_id ?>' data-toggle='modal' class="containerHeadline specialToggleTable">

            <i class="icon-table"></i><h2>Action Log</h2>
        </div>
        <!-- ==================== END OF CONDENSED TABLE HEADLINE ==================== -->

        <!-- ==================== CONDENSED TABLE FLOATING BOX ==================== -->
           <?php
           if(IsRoleFriendlyNameExist($this->user_role, 'Social Stream_Current_Take Action'))
                {
                    $data_loaded['post'] = $fb_pm[$i];
                    $this->load->view('dashboard/action_taken', $data_loaded);
 
                }
            ?>
        <!-- ==================== END OF CONDENSED TABLE FLOATING BOX ==================== --> 
    </div>
    <!-- END ENGAGEMENT -->

    <h4 class="filled">
        <!--a style="font-size: 20px;"><i class="icon-trash greyText"></i></a-->
        <div class="pull-right">
             <?php  
//    print_r($isMyCase);
    if(isset($isMyCase[count($isMyCase)-1]->assign_to)){
        if(($isMyCase[count($isMyCase)-1]->assign_to==$this->session->userdata('user_id') &&
            IsRoleFriendlyNameExist($this->user_role, 'Social Stream_Current_Take Action'))){ ?> 
                <button type="button" class="btn btn-primary btn-reply"><i class="icon-mail-reply"></i></button>
           <?php if($isMyCase[count($isMyCase)-1]->status=='pending'){ ?>
                <button type="button" class="btn btn-purple  btn-resolve_fb" name="action" value="<?=$fb_pm[$i]->case_id?>"><i class="icon-check"></i> RESOLVE</button>
                <button type="button" class="btn btn-danger btn-case fb_reassign" name="action" value="case"><i class="icon-plus"></i> ReAssign</button>  
           <?php }else{ ?> 
              <button type="button" class="btn btn-danger btn-case" name="action" value="case"><i class="icon-plus"></i> CASE</button>
           <?php   } ?>
        </div>
        <br clear="all" />
    </h4>
    <?php }elseif((IsRoleFriendlyNameExist($this->user_role,'Social Stream_All_Resolve_Case'))){ ?>
        <button type="button" class="btn btn-primary btn-reply"><i class="icon-mail-reply"></i></button>
        <?php if($isMyCase[count($isMyCase)-1]->status=='pending'):?>
        <button type="button" class="btn btn-purple  btn-resolve_fb" name="action" value="<?=$fb_pm[$i]->case_id?>"><i class="icon-check"></i> RESOLVE</button>
        <button type="button" class="btn btn-danger btn-case" name="action" value="case"><i class="icon-plus"></i> ReAssign</button>   
        <?php else:?>
        <button type="button" class="btn btn-danger btn-case" name="action" value="case"><i class="icon-plus"></i> CASE</button>   
        <?php endif?>

        </div>
        <br clear="all" />
    </h4>
    <?php } 
    }else{ 
        ?>
            <?php if(!$fb_pm[$i]->case_id):
                if($isMyCase){ ?>                   
                 <?php }else{ ?>
                    <?php if(IsRoleFriendlyNameExist($this->user_role, 'Social Stream_Current_Take Action')):?>
                        <button type="button" class="btn btn-primary btn-reply"><i class="icon-mail-reply"></i></button>
                        <button type="button" class="btn btn-danger btn-case" name="action" value="case"><i class="icon-plus"></i> CASE</button>
                    <?php endif;?>
                <?php } 
                  else:?>
                
            <?php endif?>
        </div>
        <br clear="all" />
    </h4>        
    <?php 
    }
    ?>
        
    
    <!-- REPLY -->  
    <div class="reply-field hide">
        <?php
        $to_reply_field['fb_feed'] = $fb_pm;
        $to_reply_field['i'] = $i;
        $to_reply_field['reply_type']='reply_dm';
        $this->load->view('dashboard/reply_field_facebook', $to_reply_field)?>
     </div>
    <!-- END REPLY -->
    
    <!-- CASE -->  
    <div class="case-field hide">
        <?php 
        $data['posts'] = $fb_pm;
        $data['i'] = $i;
        $this->load->view('dashboard/case_field',$data);
        
        ?>
    </div>
    <!-- END CASE -->  
</li>
<?php endfor;?>
<?php if((count($fb_pm) > 0) && (!isset($is_search))): ?>
<div class="filled" style="text-align: center;"><input type="hidden" class="total_groups" value="<?=$total_groups?>" /><input type="hidden"  class="channel_id" value="<?=$fb_pm[0]->channel_id?>"/><input type="hidden"  class="looppage" value=""/><button class="loadmore btn btn-info" value="privateMessages"><i class="icon-chevron-down"></i><span>LOAD MORE</span></button></div>
<?php endif?>
