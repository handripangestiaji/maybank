<?php 
$page = isset($page) ? $page : 2;
$total_groups = ceil($CountPmFB[0]->count_post_id/$this->config->item('item_perpage'));
$timezone=new DateTimeZone($this->session->userdata('timezone'));
for($i=0; $i<count($fb_pm);$i++):

$isMyCase = array();
$sender = $fb_pm[$i]->participant->sender->facebook_id == $fb_pm[$i]->social_id ? $fb_pm[$i]->participant->to : $fb_pm[$i]->participant->sender;
?>
<li id="post<?=$fb_pm[$i]->post_id?>" >
    <input type="hidden" class="postId" value="<?php echo $fb_pm[$i]->post_id; ?>" />
    <input type="hidden" name="facebook_user" value="<?php echo $sender->facebook_id; ?>" />
    <div class="circleAvatar"><img src="<?=base_url('dashboard/media_stream/SafePhoto?photo=')."https://graph.facebook.com/".number_format($sender->facebook_id, 0,'.','')?>/picture?small" alt=""></div>
    <?php if (IsRoleFriendlyNameExist($this->user_role, array('Social Stream_Channel_General_Function_Own_Country_Reply',
                                                              'Social Stream_Channel_General_Function_All_Country_Reply'))):?>
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
            $date=new DateTime($fb_pm[$i]->post_date.' UTC');
            $date->setTimezone($timezone);
            echo $date->format('l, M j, Y h:i A');
        ?>
    
    </p>
    <p class="snippet"><?php echo count($fb_pm[$i]->conversation_detail) > 0 ? CreateUrlFromText($fb_pm[$i]->conversation_detail[0]->messages) : "";?></p>
    <p class="indicator">
    <?php $this->load->view('facebook/facebook_indicator', array('post'=>$fb_pm[$i]))?>
    <p>
        <span class="btn-engagement" title="conversations"><i class="icon-eye-open"></i> <?php echo $fb_pm[$i]->message_count;?> Engagements</span>
    </p>

    <!-- ENGAGEMENT -->    
    <div class="engagement hide">
        <div class="engagement-header">
            <span class="engagement-btn-close btn-close pull-right">Close <i class="icon-remove-sign"></i></span>
        </div>
        <div class="engagement-list">
            <img class="loading" src="<?=base_url()?>media/img/loader.gif" alt="loading..." style="margin:10px 0 10px 40%;width: 48px;" />
            
        </div>
        <br>
        <?php 
           
       $unique_id = uniqid();
       ?>
       <!-- ==================== CONDENSED TABLE HEADLINE ==================== -->
        <div href='#modal-action-log-<?php echo $fb_pm[$i]->post_id.$unique_id ?>' data-toggle='modal' class="containerHeadline specialToggleTable">

            <i class="icon-table"></i><h2>Action Log</h2>
        </div>
        
           <?php
           if(IsRoleFriendlyNameExist($this->user_role, array('Social Stream_Channel_General_Function_Own_Country_View',
                                                              'Social Stream_Channel_General_Function_All_Country_View')))
                {
                    $data_loaded['post'] = $fb_pm[$i];
                    $data_loaded['action_type'] = "conversation_facebook";
                    $data_loaded['unique_id'] = $unique_id;
                    $this->load->view('dashboard2/action_taken', $data_loaded);
 
                }
            ?>
    </div>
    <!-- END ENGAGEMENT -->

    <h4 class="filled">
        <div class="pull-right">
            <?php $this->load->view('facebook_button', array('post'=> $fb_pm[$i], 'reply_type'=>'reply_dm'));?>
        </div>
        <br clear="all" />
    </h4>
    
    
    <!-- REPLY -->  
    <div class="reply-field hide">
        <?php
        $to_reply_field['fb_feed'] = $fb_pm;
        $to_reply_field['i'] = $i;
        $to_reply_field['reply_type']='reply_dm';
        //$this->load->view('dashboard2/reply_field_facebook', $to_reply_field)?>
     </div>
    <!-- END REPLY -->
    
    <!-- CASE -->  
    <div class="case-field hide">
        <?php 
        $data['posts'] = $fb_pm;
        $data['i'] = $i;
        
        //$this->load->view('dashboard2/case_field',$data);
        
        ?>
    </div>
    <!-- END CASE -->  
</li>
<?php endfor;?>
<?php if((count($fb_pm) > 0) && (!isset($is_search))): ?>
<div class="filled" style="text-align: center;"><input type="hidden" class="total_groups" value="<?=$total_groups?>" /><input type="hidden"  class="channel_id" value="<?=$fb_pm[0]->channel_id?>"/><input type="hidden"  class="looppage" value=""/>
<button class="loadmore btn btn-info" item="<?php echo $page?>" value="privateMessages"><i class="icon-chevron-down"></i><span>LOAD MORE</span></button></div>
<?php endif?>
