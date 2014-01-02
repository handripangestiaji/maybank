<!-- ==================== RIGHT COL ==================== -->
<div class="span4">
    <!-- ==================== ACTIVITIES CONTAINER ==================== -->
    <div class="row-fluid">
        <div class="span12">
            <!-- ==================== ACTIVITIES HEADLINE ==================== -->
            <div class="containerHeadline" style="background-color: #FF3333; color: white; height: 30px;">
                <div class="pull-left" style="padding: 4px 0px; height: auto">
                    <div class="btn-group">
                        <button class="btn trans dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-youtube"></i> <h2>Youtube </h2> 
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
                        <option value="keyword">Unread</option>
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
                            <li class="active"><a href="#allActivities">Videos Uploaded</a></li>
                            <li><a href="#recentOrders">Video Comments</a></li>
                        </ul>
                    </div>
                    <!-- ==================== END OF ACTIVITIES MENU ==================== -->

                    <div class="container-fluid">
                        <!-- ==================== ALL ACTIVITIES CONTENT ==================== -->
                        <ul class="floatingBoxContainers" id="allActivities">
                            <?php
                                for($i=0;$i<5;$i++){
                                echo
                                '<li>
                                    <div class="circleAvatar"><img src="" alt=""></div>
                                    <p class="headLine">
                                        <span class="author">John Doe</span>
                                        <i class="icon-circle"></i>
                                        <span>uploaded video</span>
                                        <i class="icon-circle"></i>
                                        <span>17 Agt 2013</span>
                                        <i class="icon-play-circle moreOptions pull-right"></i>
                                    </p>
                                    <p><iframe width="250" height="155" src="//www.youtube.com/embed/qzdTawyyO9k" frameborder="0" allowfullscreen></iframe></p>
                                    <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                                    <p><button type="button" class="btn btn-primary btn-mini">LIKE</button></p>
                                    <p><a data-toggle="modal" role="button" href="#modalDialog"><i class="icon-eye-open"></i> 5 Engagement</a> | <a data-toggle="modal" role="button" href="#modalDialog">1000 views</a> | <i class="icon-thumbs-up"></i> 10&nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-thumbs-down"></i> 2</p>
                                    <div class="reply filled hide">
                                        <form class="contentForm">
                                            <div class="controlButton pull-right"><i class="icon-remove-sign hide-form"></i></div>
                                            <textarea style="width: 95%;" rows="9" id="mailContent"></textarea>
                                            <button style="clear: both;" type="submit" class="btn btn-primary">Send</button>
                                        </form>
                                    </div>
                                    <div class="assign filled hide">
                                        <form class="contentForm">
                                             <div class="controlButton pull-right"><i class="icon-remove-sign hide-form"></i></div>
                                             <div class="control-group">
                                                <label class="control-label">Assign To</label>
                                                <div class="controls">
                                                    <select id="uniqueSelect">
                                                        <option id="opt1" value="opt1">John Doe</option>
                                                        <option id="opt2" value="opt2">May Bankette</option>
                                                        <option id="opt3" value="opt3">Jane Doyen</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="control-group last">
                                                <label class="control-label">Remarks <span class="label label-important">Not Public</span></label>
                                                <div class="controls">
                                                  <textarea class="span10"></textarea>
                                                </div>
                                            </div>
                                            <button style="clear: both;" type="submit" class="btn btn-primary">Send</button>
                                        </form>
                                    </div>
                                </li>';
                                }
                            ?>
                        </ul>
                        <div class="filled" style="text-align: center;"><button class="btn btn-info"><i class="icon-chevron-down"></i> LOAD MORE</button></div>
                        <!-- ==================== END OF ALL ACTIVITIES CONTENT ==================== -->

                        <!-- ==================== RECENT ORDERS CONTENT ==================== -->
                        <ul class="floatingBoxContainers" id="recentOrders" style="display:none">
                            <li>
                                <div class="circleAvatar"><img src="img/peter-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">Peter Kay</span>
                                    <i class="icon-circle"></i>
                                    <span>post a <span class="cyanText">comment</span></span>
                                    <i class="icon-circle"></i>
                                    <span>5 hours ago</span>
                                </p>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                                <p>
                                    <button type="button" class="btn btn-warning btn-mini">OPEN</button>
                                    <button type="button" class="btn btn-primary btn-mini">LIKE</button>
                                    <button type="button" class="btn btn-danger btn-mini">DISLIKE</button>
                                </p>
                                <p><a role="button" class="btn-engagement"><i class="icon-eye-open"></i> 5 Engagement</a> | <i class="icon-thumbs-up"></i> 10&nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-thumbs-down"></i> 2</p>

                                <div class="show-video filled hide">
                                    <p><strong>I am Lorem Ipsum</strong></p>
                                    <p><iframe width="250" height="155" src="//www.youtube.com/embed/qzdTawyyO9k" frameborder="0" allowfullscreen></iframe></p>
                                    <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>      
                                    <p>URL: <span class="cyanText">http://youtube.com/watch/blablabla</span></p>
                                </div>
                                <p><a role="button" class="btn-show-video"><img src="<?php echo base_url() ?>media/img/youtube-play.png" style="height:30px;"> <span class="desc">VIEW VIDEO</span></a></p>
                                <h4 class="filled">
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-primary btn-reply"><i class="icon-mail-reply"></i></button>
                                        <button type="button" class="btn btn-danger"><i class="icon-plus"></i> CASE</button>                                        
                                    </div>
                                    <br clear="all" />
                                </h4>
                                <div class="reply filled hide">
                                    <form class="contentForm">
                                        <div class="controlButton pull-right"><i class="icon-remove-sign hide-form"></i></div>
                                        <textarea style="width: 95%;" rows="9" id="mailContent"></textarea>
                                        <button style="clear: both;" type="submit" class="btn btn-primary">Send</button>
                                    </form>
                                </div>
                                <div class="reply-field hide">                           
                                    <?php
                                        $this->load->view('dashboard/reply_field_youtube');
                                    ?>
                                </div>
                            </li>
                        </ul>
                        <!-- ==================== END OF RECENT ORDERS CONTENT ==================== -->
                    </div>
                </div>
            </div>
            <!-- ==================== END OF ACTIVITIES FLOATING BOX ==================== -->
        </div>
    </div>
    <!-- ==================== END OF ACTIVITIES CONTAINER ==================== -->
</div>
<!-- ==================== END OF RIGHT COL ==================== -->