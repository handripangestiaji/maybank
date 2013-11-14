<!-- ==================== LEFT COL ==================== -->
<div class="span4">
    <!-- ==================== ACTIVITIES CONTAINER ==================== -->
    <div class="row-fluid">
        <div class="span12">
            <!-- ==================== ACTIVITIES HEADLINE ==================== -->
            <div class="containerHeadline" style="background-color:#3B5998; color: white; height: 30px;">
                <div class="pull-left" style="padding: 4px 0px; height: auto">
                     <div class="btn-group">
                            <button class="btn trans  dropdown-toggle" data-toggle="dropdown">
                                <i class="icon-facebook-sign"></i> <h2>Facebook </h2> 
                                &nbsp;&nbsp;<span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#">Facebook Maybank</a></li>
                                <li><a href="#">Facebook Maybankard</a></li>
                                <li><a href="#">Twitter Maybank</a></li>
                                <li><a href="#">YouTube Maybank</a></li>
                            </ul>
                    </div><!-- /btn-group -->
                </div>
                <div class="pull-right">
                    <select style="width: 130px;">
                        <option value="keyword" selected>Unread</option>
                        <option value="user">Read</option>
                        <option value="keyword">Assigned Cases</option>
                    </select>
                </div>
            </div>
            <!-- ==================== END OF ACTIVITIES HEADLINE ==================== -->

            <!-- ==================== ACTIVITIES FLOATING BOX ==================== -->
            <div class="floatingBox">
                <div class="container-fluid">
                    <!-- ==================== ACTIVITIES MENU ==================== -->
                    <div class="floatingBoxMenu">
                        <ul class="nav nav-tabs">
                            
                            <li class="active"><a href="#allActivities">Wall Posts</a></li>
                            <li><a href="#maybankpost">Maybank Posts</a></li>
                            <li><a href="#recentComments">Private Messages</a></li>
                        </ul>
                    </div>
                    <!-- ==================== END OF ACTIVITIES MENU ==================== -->

                    <div class="container-fluid">
                        <!-- ==================== ALL ACTIVITIES CONTENT ==================== -->
                        <ul class="floatingBoxContainers" id="allActivities">
                            <?php //$this->load->view('dashboard/facebook/wall_post', array('fb_feed' => $fb_feed))?> 
                        </ul>
                        <div class="filled" style="text-align: center;"><button class="btn btn-info"><i class="icon-chevron-down"></i> LOAD MORE</button></div>
                        <!-- ==================== END OF ALL ACTIVITIES CONTENT ==================== -->

                        <!-- ==================== RECENT COMMENTS CONTENT ==================== -->
                        <ul class="floatingBoxContainers" id="recentComments" style="display:none">
                            <?php //$this->load->view('dashboard/facebook/private_message', array('fb_feed' => $fb_feed))?> 
                        </ul>
                        <ul class="floatingBoxContainers" id="maybankpost" style="display:none">
                            <?php //$this->load->view('dashboard/facebook/own_post', array('own_post' => $own_post))?> 
                        </ul>
                        <!-- ==================== END OF RECENT COMMENTS CONTENT ==================== -->
                    </div>
                </div>
            </div>
            <!-- ==================== END OF ACTIVITIES FLOATING BOX ==================== -->
        </div>
    </div>
    <!-- ==================== END OF ACTIVITIES CONTAINER ==================== -->
</div>
<!-- ==================== END OF LEFT COL ==================== -->
