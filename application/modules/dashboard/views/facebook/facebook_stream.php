<div class="container-fluid">
<!-- ==================== ACTIVITIES MENU ==================== -->
<div class="floatingBoxMenu">
    <ul class="nav nav-tabs">
        
        <li class="active"><a href="#allActivities">Wall Posts</a></li>
        <!-- <li><a href="#maybankpost">Maybank Posts</a></li> -->
        <li><a href="#recentComments">Private Messages</a></li>
    </ul>
</div>
<!-- ==================== END OF ACTIVITIES MENU ==================== -->

<div class="container-fluid">
    <!-- ==================== ALL ACTIVITIES CONTENT ==================== -->
    <ul class="floatingBoxContainers" id="allActivities">
        <?php $this->load->view('dashboard/facebook/wall_post', array('fb_feed' => $fb_feed))?> 
    </ul>
    <div class="filled" style="text-align: center;"><button class="btn btn-info"><i class="icon-chevron-down"></i> LOAD MORE</button></div>
    <!-- ==================== END OF ALL ACTIVITIES CONTENT ==================== -->

    <!-- ==================== RECENT COMMENTS CONTENT ==================== -->
    <ul class="floatingBoxContainers" id="recentComments" style="display:none">
        <?php $this->load->view('dashboard/facebook/private_message', array('fb_feed' => $fb_feed))?> 
    </ul>
    <ul class="floatingBoxContainers" id="maybankpost" style="display:none">
        <?php //$this->load->view('dashboard/facebook/own_post', array('own_post' => $own_post))?> 
    </ul>
    <!-- ==================== END OF RECENT COMMENTS CONTENT ==================== -->
</div>
</div>