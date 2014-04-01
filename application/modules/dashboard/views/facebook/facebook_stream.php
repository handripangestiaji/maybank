<?php
    $count_unread_wp = 0;
    if($fb_feed != null){
        foreach($fb_feed as $wp){
            if($wp->is_read == 0){        
                $count_unread_wp++;
            }
        }
    }
    $count_unread_pm = 0;
    if($fb_pm != null){
        foreach($fb_pm as $pm){
            if($pm->is_read == 0){        
                $count_unread_pm++;
            }
        }
    }
?>
            <script type="text/javascript">
			    $(document).ready(function() {
			     
	      		
                });
			</script>
<input type="hidden" class="channel-id" value="<?php echo $channel_id?>">
<div id="cfacebook_<?=$channel_id?>" class="container-fluid" style="height: 95%">
<!-- ==================== ACTIVITIES MENU ==================== -->
<div class="floatingBoxMenu">
    <ul class="nav stream_head">
        <li class="active">
            <a class="wallPosts">
            Wall Posts
            <?php if($count_unread_wp!=0 || isset($is_search)){echo '<span class="notifyCircle red">'.$count_unread_wp.'</span>';}?>
            <?php if(isset($is_search) && count($fb_feed)!=0){echo '<span class="notifyCircle cyan">'.count($fb_feed).'</span>';}?>
            </a>
        </li>
        <!-- <li><a href="#maybankpost">Maybank Posts</a></li> -->
        <li>
            <a class="privateMessages">Private Messages
            <?php if($count_unread_pm!=0 || isset($is_search)){echo '<span class="notifyCircle red">'.$count_unread_pm.'</span>';}?>
            <?php if(isset($is_search) && count($fb_pm)!=0){echo '<span class="notifyCircle cyan">'.count($fb_pm).'</span>';}?>    
            </a>
        </li>
    </ul>
</div>
<!-- ==================== END OF ACTIVITIES MENU ==================== -->

<div id='cfacebook_<?=$channel_id?>'  class="container-fluid center subStream">
    <!-- ==================== ALL ACTIVITIES CONTENT ==================== -->
    <ul class="floatingBoxContainers" id="wallPosts">
        <input type="hidden" value="<?=$channel_id?>" name="channel_id" class="channel-id" />
        <?php
            if($fb_feed != NULL){
                $this->load->view('dashboard/facebook/wall_post', array('fb_feed' => $fb_feed));
            }
            else{
                $this->load->view('dashboard/no_display');
            }
        ?> 
    </ul>
    <!-- ==================== END OF ALL ACTIVITIES CONTENT ==================== -->

    <!-- ==================== RECENT COMMENTS CONTENT ==================== -->
    <ul class="floatingBoxContainers" id="privateMessages" style="display:none">
        <input type="hidden" value="" name="channel_id" class="channel-id" />
        <?php
            if($fb_pm != NULL){
                $this->load->view('dashboard/facebook/private_message', array('fb_feed' => $fb_feed));
            }
            else{
                $this->load->view('dashboard/no_display');
            }
        ?> 
    </ul>
    <ul class="floatingBoxContainers" id="maybankpost" style="display:none">
        <?php //$this->load->view('dashboard/facebook/own_post', array('own_post' => $own_post))?> 
    </ul>
    <!-- ==================== END OF RECENT COMMENTS CONTENT ==================== -->
</div>
</div>