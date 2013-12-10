<?php
    $count_unread_wp = 0;
    foreach($fb_feed as $wp){
        if($wp->is_read == 0){        
            $count_unread_wp++;
        }
    }
    
    $count_unread_pm = 0;
    foreach($fb_pm as $pm){
        if($pm->is_read == 0){        
            $count_unread_pm++;
        }
    }
?>
<input type="hidden" class="channel-id" value="<?php if(count($fb_feed) > 0){echo $fb_feed[0]->channel_id;}  ?>">
<div class="container-fluid">
<!-- ==================== ACTIVITIES MENU ==================== -->
<div class="floatingBoxMenu">
    <ul class="nav stream_head">
        <li class="active"><a class="wallPosts">Wall Posts<?php if($count_unread_wp!=0){echo '<span class="notifyCircle red">'.$count_unread_wp.'</span>';}?></a></li>
        <!-- <li><a href="#maybankpost">Maybank Posts</a></li> -->
        <li><a class="privateMessages">Private Messages<?php if($count_unread_pm!=0){echo '<span class="notifyCircle red">'.$count_unread_pm.'</span>';}?></a></li>
    </ul>
</div>
<!-- ==================== END OF ACTIVITIES MENU ==================== -->

<div id='cfacebook'  class="container-fluid">
    <!-- ==================== ALL ACTIVITIES CONTENT ==================== -->
    <ul class="floatingBoxContainers" id="wallPosts">
        <input type="hidden" value="" name="channel_id" class="channel-id" />
        <?php $this->load->view('dashboard/facebook/wall_post', array('fb_feed' => $fb_feed))?> 
    </ul>
    <!-- ==================== END OF ALL ACTIVITIES CONTENT ==================== -->

    <!-- ==================== RECENT COMMENTS CONTENT ==================== -->
    <ul class="floatingBoxContainers" id="privateMessages" style="display:none">
        <input type="hidden" value="" name="channel_id" class="channel-id" />
        <?php $this->load->view('dashboard/facebook/private_message', array('fb_feed' => $fb_feed))?> 
    </ul>
    <ul class="floatingBoxContainers" id="maybankpost" style="display:none">
        <?php //$this->load->view('dashboard/facebook/own_post', array('own_post' => $own_post))?> 
    </ul>
    <!-- ==================== END OF RECENT COMMENTS CONTENT ==================== -->
</div>
</div>
