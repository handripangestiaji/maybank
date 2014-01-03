<?php 
//print_r($fb_pm);    
$total_groups = ceil($CountPmFB[0]->count_post_id/$this->config->item('item_perpage'));
$timezone=new DateTimeZone($this->config->item('timezone'));
for($i=0; $i<count($fb_pm);$i++):

$isMyCase=$this->case_model->chackAssignCase(array('a.post_id' => $fb_pm[$i]->post_id));
//print_r($isMyCase);
//echo $fb_pm[$i]->post_id."{pm-feed}".$fb_feed[$i]->post_id;
?>
<li>
    <input type="hidden" class="postId" value="<?php echo $fb_pm[$i]->post_id; ?>" />
    <div class="circleAvatar"><img src="https://graph.facebook.com/<?=number_format($fb_pm[$i]->sender, 0,'.','')?>/picture?small" alt=""></div>
    <div class="read-mark <?php if($fb_pm[$i]->is_read==0){echo 'redText';} else { echo 'greyText'; } ?>"><i class="icon-bookmark icon-large"></i></div>
    <br />
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
    <p>
    <?php 
    if(isset($isMyCase[0]->assign_to)){
        if($isMyCase[0]->assign_to==$this->session->userdata('user_id') or ($isMyCase[0]->solved_by)){ ?>
            <button type="button" class="btn <?php echo $isMyCase[$i]->case_id != null ? "btn-purple" : "btn-inverse btn-mini" ?>"><?php echo $isMyCase[0]->case_id != null ? 'CASE #'.$isMyCase[0]->case_id.' Assign to You ' : 'CASE #'.$isMyCase[0]->case_id.'-'.'RESOLVE BY '.$isMyCase[0]->full_name?></button>
        <?php }else{ ?>
                <button type="button" class="btn <?php echo $isMyCase[$i]->case_id != null ? "btn-purple" : "btn-inverse btn-mini" ?>"><?php echo $isMyCase[0]->case_id != null ? 'CASE #'.$isMyCase[0]->case_id.' Assign to: '.$isMyCase[0]->full_name : 'REPLIED'?></button>  
    <?php     }
    }
       ?>
        <!--button class="btn btn-primary btn-mini" style="margin-left: 5px;">LIKE</button--> </p>
    <p>
        <span class="btn-engagement"><i class="icon-eye-open"></i> <?php echo $fb_pm[$i]->message_count;?> Engagements</span>
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
        <div class="containerHeadline specialToggleTable">
            <i class="icon-table"></i><h2>Action Log</h2>
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
            <?php
            if(isset($isMyCase[0]->assign_to)){
                if($isMyCase[0]->assign_to==$this->session->userdata('user_id')){
                echo "<button type='button' class='btn btn-primary btn-reply'><i class='icon-mail-reply'></i></button>";
                echo " <button type='button' class='btn btn-purple  btn-resolve' name='action' value=".$fb_feed[$i]->case_id."><i class='icon-check'></i> RESOLVE</button>";
                }
            }else{
                echo "<button type='button' class='btn btn-primary btn-reply'><i class='icon-mail-reply'></i></button>";
                echo " <button type='button' class='btn btn-danger btn-case' name='action' value='case'><i class='icon-plus'></i> CASE</button>";
            }?>
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
<?php if(count($fb_pm) > 0):?>
<div class="filled" style="text-align: center;"><input type="hidden" class="total_groups" value="<?=$total_groups?>" /><input type="hidden"  class="channel_id" value="<?=$fb_pm[0]->channel_id?>"/><input type="hidden"  class="looppage" value=""/><button class="loadmore btn btn-info" value="privateMessages"><i class="icon-chevron-down"></i> LOAD MORE</button></div>
<?php endif?>
