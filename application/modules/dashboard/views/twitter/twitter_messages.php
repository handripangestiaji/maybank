<?php
    $total_groups = ceil($countDirect[0]->count_post_id/$this->config->item('item_perpage'));
    $timezone=new DateTimeZone($this->config->item('timezone'));
    for($i=0;$i<count($directmessage);$i++){
    ?>
    <li>
        <input type="hidden" class="postId" value="<?php echo $directmessage[$i]->social_stream_post_id; ?>" />
        <div class="circleAvatar"><img src="<?php echo $directmessage[$i]->sender->profile_image_url; ?>" alt=""></div>
        <div class="read-mark <?php if($directmessage[$i]->is_read==0){echo 'redText';} else { echo 'greyText'; } ?>"><i class="icon-bookmark icon-large"></i></div>
        <br />
        <p class="headLine">
            <span class="author"><?php echo $directmessage[$i]->sender->screen_name; ?></span>
            <i class="icon-circle"></i>
            <span>Direct Messages</span>
            <i class="icon-circle"></i>
            <span>
            <?php
            
            $date=new DateTime($directmessage[$i]->social_stream_created_at.' Europe/London');
            $date->setTimezone($timezone);
            echo $date->format('l, M j, Y h:i A');
            
            ?>
            </span>
            
        </p>
        <p><?php echo $directmessage[$i]->dm_text;?>
        </p>
        <p class="indicator">
        <?php if($directmessage[$i]->case_id):?>
            <button type="button" class="btn btn-purple btn-mini" value="<?php echo $directmessage[$i]->case_id?>">CASE ID #<?php echo $directmessage[$i]->case_id?> </button>
        <?php endif?>
        <?php if($directmessage[$i]->response_post_id):?>
            <button type="button" class="btn btn-inverse btn-mini" value="<?php echo $directmessage[$i]->response_post_id?>">REPLIED</button>
        <?php endif?>
        <?php if(!$directmessage[$i]->response_post_id && !$directmessage[$i]->case_id):?>
            <button type="button" class="btn btn-warning btn-mini">OPEN</button>
        <?php endif?>
        </p>
        <h4 class="filled">
        <a role="button" href="#"><i class="icon-trash greyText"></i></a>
        <div class="pull-right">
            <button class="btn btn-dm btn-primary" data-toggle="modal"><i class="icon-envelope"></i></button>
            
            <button type="button" class="btn btn-inverse follow unfollow" name="action" value="<?php echo $directmessage[$i]->sender->twitter_user_id?>"><i class="icon-user"></i></button>
            <?php if($directmessage[$i]->case_id):?>
                <button type="button" class="btn btn-purple btn-resolve" name="action" value="<?php echo $directmessage[$i]->case_id?>"><i class="icon-check"></i> <span>RESOLVE</span></button>
            <?php else:?>
                <button type="button" class="btn btn-danger btn-case" name="action" value="case"><i class="icon-plus"></i> <span>CASE</span></button>
            <?php endif?>
            
            <input type="hidden" name="str_id" value="<?php //echo json$directmessage[$i]->id_str; ?>" />
            <input type="hidden" name="id" value="<?php //echo $directmessage[$i]->id; ?>" />
        </div>
        <br clear="all" />
        </h4>
        
        <!-- DM -->  
    <div class="dm-field hide">
             
        <?php
        $data['mentions'] = $directmessage;
        $data['i'] = $i;
        $data['type'] = 'direct_message';
        $this->load->view('dashboard/reply_field_twitter', $data);?>
    </div>
    <!-- END DM -->  
    
    <!-- CASE -->  
    <div class="case-field hide">
       <?php
       $data['posts'] = $directmessage;
       $data['i'] = $i;
       $this->load->view('dashboard/case_field', $data);?>
    </div>
    <!-- END CASE --> 
        
    </li>
    <?php 
    }
 ?>
<?php if((count($directmessage) > 0) && (!isset($is_search))): ?>
  <div class="filled" style="text-align: center;">
     <input type="hidden"  class="channel_id" value="<?php echo $directmessage[0]->channel_id?>"/>
    <button class="loadmore btn btn-info" value="direct"><i class="icon-chevron-down"></i> LOAD MORE</button></div>
<?php endif;?>