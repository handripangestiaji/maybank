<?php 
$total_groups = ceil($CountPmFB[0]->count_post_id/$this->config->item('item_perpage'));
$timezone=new DateTimeZone($this->session->userdata('timezone'));
for($i=0; $i<count($fb_pm);$i++):

$isMyCase = array();
$sender = $fb_pm[$i]->participant->sender->facebook_id == $fb_pm[$i]->social_id ? $fb_pm[$i]->participant->to : $fb_pm[$i]->participant->sender;
?>
<li id="post<?=$fb_pm[$i]->post_id?>" >
    <?php
        if(count($fb_pm[$i]->case) > 0)
            $this->load->view('dashboard/facebook/case_view', array(
                    "caseMsg" => $fb_pm[$i]->case[0],
                    "sender" => $sender
                ));
    ?>
    <input type="hidden" class="postId" value="<?php echo $fb_pm[$i]->post_id; ?>" />
    <input type="hidden" name="facebook_user" value="<?php echo $sender->facebook_id; ?>" />
    <div class="circleAvatar"><img src="<?=base_url('dashboard/media_stream/SafePhoto?photo=')."https://graph.facebook.com/".number_format($sender->facebook_id, 0,'.','')?>/picture?small" alt=""></div>
     <?php if (IsRoleFriendlyNameExist($this->user_role, 'Social Stream_Current_Take Action')):?>
        <div class="read-mark <?php echo $fb_pm[$i]->is_read==0 ? 'redText' : 'greyText'?>"><i class="icon-bookmark icon-large"></i></div>
    <?php endif ?>
    <br />
    <p class="headLine">
        <span class="author"><?php echo $sender->name; ?></span>
        <i class="icon-circle"></i>
        <span>Conversations</span>
        <i class="icon-circle"></i>
        <span>
        <?php 
            $date=new DateTime($fb_pm[$i]->post_date.' Europe/London');
            $date->setTimezone($timezone);
            echo $date->format('l, M j, Y h:i A');
        ?>
    
    </p>
    <p class="snippet"><?=$fb_pm[$i]->snippet?></p>
    <p class="indicator">
    <?php $this->load->view('facebook/facebook_indicator', array('post'=>$fb_pm[$i]))?>
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
            $comment = $fb_pm[$i]->conversation_detail;
            for($j=0;$j < count($comment) ;$j++){
                if($comment[$j]->messages != '' || $comment[$j]->attachment != '' ):
        ?>
        <div class="engagement-body">
            <span class="engagement-btn-hide-show btn-close pull-right"><i class="icon-caret-down"></i></span>    
            <p class="headLine">
                <span class="author"><?php echo $comment[$j]->name; ?></span>
                <i class="icon-circle"></i>
                <span>posted a <span class="cyanText">reply</span></span>
                <i class="icon-circle"></i>
                <span><?php
                $created_detail_pm = new DateTime($comment[$j]->created_at);
                $created_detail_pm->setTimezone($timezone);
                echo $created_detail_pm->format('l, M j, Y h:i A'); ?></span>
               
            </p>
            
            <div>
                  
                <?php
                $att_to_print = "";
                if($comment[$j]->attachment != ''):
                    $attachment = json_decode($comment[$j]->attachment);
                    $attachment = $attachment->data[0];
                    
                    if(isset($attachment->image_data)){
                        if(isset($attachment->image_data->url)){
                            $att_to_print = '<a href="#detail'.$comment[$j]->detail_id.'" data-toggle="modal" ><img src="'.base_url('dashboard/media_stream/SafePhoto?photo=').urlencode($attachment->image_data->url).'" style="width:60%;" /></a>';
                            $src = urlencode($attachment->image_data->url);
                        }
                        else{
                            $att_to_print = '<img src="'.base_url('dashboard/media_stream/SafePhoto?photo=').urlencode('https://www.facebook.com/ajax/messaging/attachment.php?attach_id='.$attachment->id.'&mid='.substr($comment[$j]->detail_id_from_facebook, 2).'&preview=1').'" style="width:60%;" />';
                            $src = urlencode('https://www.facebook.com/ajax/messaging/attachment.php?attach_id='.$attachment->id.'&mid='.substr($comment[$j]->detail_id_from_facebook, 2).'&preview=1');
                        }
                        
                        $att_to_print .= '<div id="detail'.$comment[$j]->detail_id.'" class="attachment-modal modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <img src="'.base_url('dashboard/media_stream/SafePhoto?photo=').$src.'" />
                            <button type="button" class="close " data-dismiss="modal"><i class="icon-remove"></i></button>
                        </div>';
                    }
                    else 
                        $att_to_print = '<a href="https://www.facebook.com/ajax/messaging/attachment.php?attach_id='.$attachment->id.'&mid='.substr($comment[$j]->detail_id_from_facebook, 2).'" target="_blank" style="font-size:16px;">ATTACHMENT</a>';
                
                    
                endif;?>
                <?php if($comment[$j]->messages != ""){?>
                    <p class="engagement-message"><?php echo CreateUrlFromText($comment[$j]->messages)?></p>
                <?php }?>
                <p><?=$att_to_print;?> </p>
              
            </div>
        </div>
       <?php endif;
       } ?>
       <!-- ==================== CONDENSED TABLE HEADLINE ==================== -->
        <div href='#modal-action-log-<?php echo $fb_pm[$i]->post_id ?>' data-toggle='modal' class="containerHeadline specialToggleTable">

            <i class="icon-table"></i><h2>Action Log</h2>
        </div>
        
           <?php
           if(IsRoleFriendlyNameExist($this->user_role, array('Social Stream_Channel_General_Function_Own_Country_View',
                                                              'Social Stream_Channel_General_Function_All_Country_View')))
                {
                    $data_loaded['post'] = $fb_pm[$i];
                    $data_loaded['action_type'] = "conversation_facebook";
                    $this->load->view('dashboard/action_taken', $data_loaded);
 
                }
            ?>
    </div>
    <!-- END ENGAGEMENT -->

    <h4 class="filled">
        <div class="pull-right">
            <?php $this->load->view('facebook_button', array('post'=> $fb_pm[$i]));?>
        </div>
        <br clear="all" />
    </h4>
    
    
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
