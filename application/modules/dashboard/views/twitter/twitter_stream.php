<div class="container-fluid">
<!-- ==================== ACTIVITIES MENU ==================== -->
<div class="floatingBoxMenu">
    <ul class="nav nav-tabs">
        <li class="active"><a href='#mentions'>Mentions</a></li>
        <li><a href='#feed'>Homefeed</a></li>
        <!-- <li><a href='#sendmessage'>menu1</a></li> -->
        <li><a href='#direct'>Direct Message</a></li>
    </ul>
</div>
<!-- ==================== END OF ACTIVITIES MENU ==================== -->

<div id="ctwitter" class="container-fluid">
    <!-- ==================== ALL ACTIVITIES CONTENT ==================== -->
    <ul class="floatingBoxContainers" id="mentions">
         <?php echo $this->load->view('dashboard/twitter/twitter_mentions', array('mentions' => $mentions))?> 
    </ul>
    
    <ul class="floatingBoxContainers" id="feed" style="display:none">
         <?php //$this->load->view('dashboard/twitter/twitter_homefeed', array('twitter' => $homefeed))?> 
    </ul>
    
    <!--
    <ul class="floatingBoxContainers" id="sendmessage" style="display:none">
         <?php /*$this->load->view('dashboard/twitter/twitter_sendmessage', array('twitter' => $twitter))*/ ?> 
    </ul>
    -->
    <ul class="floatingBoxContainers" id="direct" style="display:none">
         <?php //$this->load->view('dashboard/twitter/twitter_messages', array('directmessage' => $directmessage))?> 
    </ul>

    <!-- ==================== END OF RECENT TASKS CONTENT ==================== -->
     <div class="filled" style="text-align: center;"><button class="btn btn-info"><i class="icon-chevron-down"></i> LOAD MORE</button></div>
</div>
</div>