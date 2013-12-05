<?php
    $total_groups = ceil($countDirect[0]->count_post_id/$this->config->item('item_perpage'));
    $timezone=new DateTimeZone($this->config->item('timezone'));
    for($i=0;$i<count($directmessage);$i++){
    ?>
    <li <?php if($directmessage[$i]->is_read==0){echo 'class="unread-post"';} ?>>
        <div class="circleAvatar"><img src="<?php echo $directmessage[$i]->sender->profile_image_url; ?>" alt=""></div>
        <div class="read-mark <?php if($directmessage[$i]->is_read==0){echo 'redText';} else { echo 'greyText'; } ?>"><i class="icon-bookmark icon-large"></i></div>
        <br />
        <p class="headLine">
            <span class="author"><?php echo $directmessage[$i]->sender->screen_name; ?></span>
            <i class="icon-circle"></i>
            <span>mentions</span>
            <i class="icon-circle"></i>
            <span>
            <?php 
            $date=new DateTime($directmessage[$i]->created_at.' Europe/London');
            $date->setTimezone($timezone);
            echo $date->format('l, M j, Y H:i:s');
            ?>
            </span>
            <i class="icon-play-circle moreOptions pull-right"></i>
        </p>
        <p><?php echo $directmessage[$i]->text;?></p>
        <p><button type="button" class="btn btn-warning btn-mini">OPEN</button></p>
        <h4 class="filled">
        <a role="button" href="#"><i class="icon-trash greyText"></i></a>
        <div class="pull-right">
           <button class="btn btn-dm btn-primary" data-toggle="modal"><i class="icon-envelope"></i></button>
                <button type="button" class="btn btn-primary" name="action" value="follow"><i class="icon-user"></i></button>
                <button type="button" class="btn btn-danger" name="action" value="case"><i class="icon-plus"></i>CASE</button>
                <input type="hidden" name="str_id" value="<?php //echo json$directmessage[$i]->id_str; ?>" />
                <input type="hidden" name="id" value="<?php //echo $directmessage[$i]->id; ?>" />
        </div>
        <br clear="all" />
        </h4>
        
        <!-- DM -->  
   <!-- END DM -->
    
    <!-- CASE -->  
    <div class="case-field hide">
       <?php $this->load->view('dashboard/case_field');?>
    </div>
    <!-- END CASE --> 
        
    </li>
    <?php 
    }
 ?>
  <div class="filled" style="text-align: center;"><button class="loadmore btn btn-info" value="direct"><i class="icon-chevron-down"></i> LOAD MORE</button></div>