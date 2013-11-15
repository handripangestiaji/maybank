<!-- ==================== MIDDLE COL ==================== -->
<div id='ctwitter' class="span4">
    <!-- ==================== ACTIVITIES CONTAINER ==================== -->
    <div class="row-fluid">
        <div class="span12">
            <!-- ==================== ACTIVITIES HEADLINE ==================== -->
            <div class="containerHeadline" style="background-color:#4099FF;color: white; height: 30px;">
                <div class="pull-left" style="padding: 4px 0px; height: auto">
                    <i class="icon-twitter"></i><h2>Twitter</h2>
                </div>
                <div class="pull-right">
                    <select style="width: 130px;">
                        <option value="user">Read</option>
                        <option value="keyword">Unread</option>
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
                            <li class="active"><a href='#mentions'>Mentions</a></li>
                            <li><a href='#feed'>Homefeed</a></li>
                            <!--li><a href='#sendmessage'>menu1</a></li-->
                            <li><a href='#direct'>Direct Message</a></li>
                        </ul>
                    </div>
                    <!-- ==================== END OF ACTIVITIES MENU ==================== -->

                    <div id="ctwitter" class="container-fluid">
                        <!-- ==================== ALL ACTIVITIES CONTENT ==================== -->
                        <ul class="floatingBoxContainers" id="mentions">
                             <?php $this->load->view('dashboard/twitter/twitter_mentions', array('mentions' => $mentions))?> 
                        </ul>
                        <ul class="floatingBoxContainers" id="feed" style="display:none">
                             <?php $this->load->view('dashboard/twitter/twitter_homefeed', array('homefeed' => $homefeed))?> 
                        </ul>
                        <!--ul class="floatingBoxContainers" id="sendmessage" style="display:none"-->
                             <?php /*$this->load->view('dashboard/twitter/twitter_sendmessage', array('twitter' => $twitter))*/ ?> 
                        <!--/ul-->
                        <ul class="floatingBoxContainers" id="direct" style="display:none">
                             <?php $this->load->view('dashboard/twitter/twitter_messages', array('directmessage' => $directmessage))?> 
                        </ul>

                        <!-- ==================== END OF RECENT TASKS CONTENT ==================== -->
                         <div class="filled" style="text-align: center;"><button class="btn btn-info"><i class="icon-chevron-down"></i> LOAD MORE</button></div>
                    </div>
                </div>
            </div>
            <!-- ==================== END OF ACTIVITIES FLOATING BOX ==================== -->
        </div>
    </div>
    <!-- ==================== END OF ACTIVITIES CONTAINER ==================== -->
</div>
<!-- ==================== END OF MIDDLE COL ==================== -->
