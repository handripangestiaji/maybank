<?php
    $total_groups = ceil($countDirect[0]->count_post_id/$this->config->item('item_perpage'));
    $timezone=new DateTimeZone($this->session->userdata('timezone'));
    for($i=0;$i<count($directmessage);$i++){
    ?>
    <li id="post<?=$directmessage[$i]->social_stream_post_id?>">
        <input type="hidden" class="postId" value="<?php echo $directmessage[$i]->social_stream_post_id; ?>" />
        <div class="circleAvatar"><img src="<?php echo base_url('dashboard/media_stream/SafePhoto?photo=').$directmessage[$i]->sender->profile_image_url; ?>" alt=""></div>
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
        <p><?php echo RemoveUrlWithin($directmessage[$i]->dm_text);?>
        </p>
        <p class="indicator">
        <?php if(count($directmessage[$i]->case) > 0):?>
            <button type="button" data-toggle="modal" href="caseItem<?=$directmessage[$i]->case[0]->case_id?>"
                class="twitter-case-related btn <?=$directmessage[$i]->case[0]->status == "pending" ? "btn-purple" : "btn-inverse"?> btn-mini" value="<?php echo $directmessage[$i]->case[0]->case_id?>">Case #<?php echo $directmessage[$i]->case[0]->case_id?>
                <?php
                if($directmessage[$i]->case[0]->status == "pending"){
                    echo isset($directmessage[$i]->case[0]->assign_to->display_name) ? ' Assign to: '.$directmessage[$i]->case[0]->assign_to->display_name : '';
                    $created_at = new DateTime($directmessage[$i]->case[0]->created_at.' Europe/London', $timezone);
                    $created_at->setTimezone($timezone);
                    echo ' '.$created_at->format("d-M-y h:i A");
                }
                else{
                    echo isset($directmessage[$i]->case[0]->solved_by->display_name) ? ' Resolved by: '.$directmessage[$i]->case[0]->solved_by->display_name: '';
                    $solved_at = new DateTime($directmessage[$i]->case[0]->solved_at.' Europe/London', $timezone);
                    $solved_at->setTimezone($timezone);
                    echo ' '.$solved_at->format("d-M-y h:i A");
                }
                ?>
            </button>
        <?php
            $this->load->view('dashboard/twitter/case_view', array(
                    "caseMsg" => $directmessage[$i]->case[0]
                ));
        ?>
        <?php endif?>
        <?php if($directmessage[$i]->response_post_id):?>
        
            <button type="button" class="btn btn-inverse btn-mini"
                    value="<?php echo $directmessage[$i]->response_post_id?>">Replied By
                    <?php
                    
                    $date = new DateTime($directmessage[$i]->reply_post[0]->created_at.' Europe/London');
                    $date->setTimezone($timezone);
                    echo $directmessage[$i]->reply_post[0]->display_name.' at '.$date->format("d-M-y h:i A")?>
                    </button>
            
        <?php endif?>
        <?php if(!$directmessage[$i]->response_post_id && count($directmessage[$i]->case) == 0):?>
            <button type="button" class="btn btn-warning btn-mini">OPEN</button>
        <?php endif?>
        </p>
         <p>
        
            
        </p>
        <h4 class="filled">
        <?php if(IsRoleFriendlyNameExist($this->user_role, 'Social Stream_All_Take Action') ||
                 IsRoleFriendlyNameExist($this->user_role, 'Social Stream_Current_Take Action') ||
                 IsRoleFriendlyNameExist($this->user_role, 'Social Stream_All_Delete') ||
                 IsRoleFriendlyNameExist($this->user_role, 'Social Stream_Current_Delete')
                 ):?>
            <a role="button" href="#" class="destroy_status direct_message"><i class="icon-trash greyText"></i></a>
        <?php endif;?>
        <div class="pull-right">
            <?php
                $data = array(
                    'come_from' => "direct_messages",
                    'post' => $directmessage[$i]
                );
                $this->load->view('dashboard/twitter/twitter_button', $data);
            ?>
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
    <button class="loadmore btn btn-info" value="direct"><i class="icon-chevron-down"></i> <span>LOAD MORE</span></button></div>
<?php endif;?>