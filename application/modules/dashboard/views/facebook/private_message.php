<?php 
//print_r($fb_pm);    
$total_groups = ceil($CountPmFB[0]->count_post_id/$this->config->item('item_perpage'));
$timezone=new DateTimeZone($this->config->item('timezone'));
for($i=0; $i<count($fb_pm);$i++):?>
<li <?php if($fb_pm[$i]->is_read==0){echo 'class="unread-post"';}?>>
    <input type="hidden" class="postId" value="<?php echo $fb_pm[$i]->detail_id_from_facebook; ?>" />
    <div class="circleAvatar"><img src="https://graph.facebook.com/<?=number_format($fb_pm[$i]->sender, 0,'.','')?>/picture?small" alt=""></div>
    <p class="headLine">
        <span class="author"><?php echo $fb_pm[$i]->name; ?></span>
        <i class="icon-circle"></i>
        <span>posted a <span class="cyanText">message</span></span>
        <i class="icon-circle"></i>
        <span>
        <?php 
            $date=new DateTime($fb_pm[$i]->created_at.' Europe/London');
            $date->setTimezone($timezone);
            echo $date->format('l, M j, Y H:i:s');
        ?>
        
    </p>
    <p><?=$fb_pm[$i]->messages?></p>
    <p><button type="button" class="btn btn-warning btn-mini">OPEN</button><!--button class="btn btn-primary btn-mini" style="margin-left: 5px;">LIKE</button--> </p>
    <p>
        <span class="btn-engagement"><i class="icon-eye-open"></i> <?php echo $fb_pm[$i]->message_count;?> Engagements</span> |
        <span class="btn-mark-as-read cyanText" style="display: <?php if($fb_pm[$i]->is_read==1){echo 'none';} ?>"><i class="icon-bookmark"></i> Mark as Read</span>
        <span class="btn-mark-as-unread cyanText" style="display: <?php if($fb_pm[$i]->is_read==0){echo 'none';} ?>"><i class="icon-bookmark-empty"></i> Mark as Unread</span>
    </p>

    <!-- ENGAGEMENT -->    
    <div class="engagement hide">
        <div class="engagement-header">
            <span class="engagement-btn-close btn-close pull-right">Close <i class="icon-remove-sign"></i></span>
        </div>
        <br>
        <?php 
            $comment=$this->facebook_model->RetrievePmDetailFB($fb_pm[$i]->conversation_id);
            for($j=0;$j<count($comment);$j++){
        ?>
        <div class="engagement-body">
            <span class="engagement-btn-hide-show btn-close pull-right"><i class="icon-caret-down"></i></span>    
            <p class="headLine">
                <span class="author"><?php echo $comment[$j]->name; ?></span>
                <i class="icon-circle"></i>
                <span>posted a <span class="cyanText">comment</span></span>
                <i class="icon-circle"></i>
                <span><?php echo $comment[$j]->created_at; ?></span>
               
            </p>
            <div>
                <p>"<?php echo $comment[$j]->messages; ?>"</p>
            </div>
        </div>
       <?php } ?>
       <!-- ==================== CONDENSED TABLE HEADLINE ==================== -->
        <div class="containerHeadline">
            <i class="icon-table"></i><h2>Action Log</h2>
            <div class="controlButton pull-right"><i class="icon-caret-down toggleTable"></i></div>
        </div>
        <!-- ==================== END OF CONDENSED TABLE HEADLINE ==================== -->

        <!-- ==================== CONDENSED TABLE FLOATING BOX ==================== -->
        <div class="floatingBox table hide">
            <div class="container-fluid">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Time Stamp</th>
                      <th>Username</th>
                      <th>Action Taken</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>2013-09-30 19:52:46</td>
                      <td>Teo Eu Gene</td>
                      <td>Resolved</td>
                      <td><button class="btn btn-primary icon-book"></button></td>
                    </tr>
                    <tr>
                      <td>2013-09-30 19:52:46</td>
                      <td>Teo Eu Gene</td>
                      <td>Resolved</td>
                      <td><button class="btn btn-primary icon-book"></button></td>
                    </tr>
                  </tbody>
                </table>  
            </div>
        </div>
        <!-- ==================== END OF CONDENSED TABLE FLOATING BOX ==================== --> 
    </div>
    <!-- END ENGAGEMENT -->

    <h4 class="filled">
        <a style="font-size: 20px;"><i class="icon-trash greyText"></i></a>
        <div class="pull-right">
            <button type="button" class="btn btn-primary btn-reply"><i class="icon-mail-reply"></i></button>
            <button type="button" class="btn btn-danger btn-case"><i class="icon-plus"></i> CASE</button>
        </div>
        <br clear="all" />
    </h4>
    
    <!-- REPLY -->  
    <div class="reply-field hide">
        <?php
        $to_reply_field['fb_feed'] = $fb_pm;
        $to_reply_field['i'] = $i;
        $this->load->view('dashboard/reply_field_facebook', $to_reply_field)?>
     </div>
    <!-- END REPLY -->
    
    <!-- CASE -->  
    <div class="case-field hide">
        <?php $this->load->view('dashboard/case_field')?>
    </div>
    <!-- END CASE -->  
</li>
<?php endfor;?>
<?php if(count($fb_pm) > 0):?>
<div class="filled" style="text-align: center;"><input type="hidden" class="total_groups" value="<?=$total_groups?>" /><input type="hidden"  class="channel_id" value="<?=$fb_pm[0]->channel_id?>"/><input type="hidden"  class="looppage" value=""/><button class="loadmore btn btn-info" value="privateMessages"><i class="icon-chevron-down"></i> LOAD MORE</button></div>
<?php endif?>