<?php

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
            <span><?php echo date('l, M j, Y H:i:s',strtotime($directmessage[$i]->created_at));?></span>
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