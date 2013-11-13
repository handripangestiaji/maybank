<!-- ==================== RIGHT COL ==================== -->
<div class="span4">
    <!-- ==================== ACTIVITIES CONTAINER ==================== -->
    <div class="row-fluid">
        <div class="span12">
            <!-- ==================== ACTIVITIES HEADLINE ==================== -->
            <div class="containerHeadline" style="background-color: #FF3333; color: white; height: 30px;">
                <div class="pull-left" style="padding: 4px 0px; height: auto">
                    <i class="icon-youtube"></i><h2>Youtube</h2>
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

                        <!-- ==================== RECENT COMMENTS CONTENT ==================== -->
                        <ul class="floatingBoxContainers" id="recentComments" style="display:none">
                            <li>
                                <div class="circleAvatar"><img src="img/homer-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">John Doe</span>
                                    <i class="icon-circle"></i>
                                    <span>posted a <span class="cyanText">comment</span></span>
                                    <i class="icon-circle"></i>
                                    <span>2 hours ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                </p>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                            </li>
                            <li>
                                <div class="circleAvatar"><img src="img/rimmer-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">Arnold Karlsberg</span>
                                    <i class="icon-circle"></i>
                                    <span>posted a <span class="cyanText">comment</span></span>
                                    <i class="icon-circle"></i>
                                    <span>3 days ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                </p>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                            </li>
                            <li>
                                <div class="circleAvatar"><img src="img/peter-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">Peter Kay</span>
                                    <i class="icon-circle"></i>
                                    <span>posted a <span class="cyanText">comment</span></span>
                                    <i class="icon-circle"></i>
                                    <span>3 days ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                </p>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                            </li>
                            <li>
                                <div class="circleAvatar"><img src="img/zoidberg-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">George McCain</span>
                                    <i class="icon-circle"></i>
                                    <span>posted a <span class="cyanText">comment</span></span>
                                    <i class="icon-circle"></i>
                                    <span>5 days ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                </p>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                            </li>
                            <li>
                                <div class="circleAvatar"><img src="img/homer-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">John Doe</span>
                                    <i class="icon-circle"></i>
                                    <span>posted a <span class="cyanText">comment</span></span>
                                    <i class="icon-circle"></i>
                                    <span>10 days ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                </p>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                            </li>
                        </ul>
                        <!-- ==================== END OF RECENT COMMENTS CONTENT ==================== -->

                        <!-- ==================== RECENT ORDERS CONTENT ==================== -->
                        <ul class="floatingBoxContainers" id="recentOrders" style="display:none">
                            <li>
                                <div class="circleAvatar"><img src="img/peter-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">Peter Kay</span>
                                    <i class="icon-circle"></i>
                                    <span>created an <span class="greenText">order</span></span>
                                    <i class="icon-circle"></i>
                                    <span>5 hours ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                </p>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                            </li>
                            <li>
                                <div class="circleAvatar"><img src="img/zoidberg-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">George McCain</span>
                                    <i class="icon-circle"></i>
                                    <span>created an <span class="greenText">order</span></span>
                                    <i class="icon-circle"></i>
                                    <span>10 days ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                </p>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                            </li>
                            <li>
                                <div class="circleAvatar"><img src="img/homer-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">John Doe</span>
                                    <i class="icon-circle"></i>
                                    <span>created an <span class="greenText">order</span></span>
                                    <i class="icon-circle"></i>
                                    <span>11 days ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                </p>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                            </li>
                            <li>
                                <div class="circleAvatar"><img src="img/rimmer-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">Arnold Karlsberg</span>
                                    <i class="icon-circle"></i>
                                    <span>created an <span class="greenText">order</span></span>
                                    <i class="icon-circle"></i>
                                    <span>12 days ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                </p>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                            </li>
                            <li>
                                <div class="circleAvatar"><img src="img/rimmer-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">Arnold Karlsberg</span>
                                    <i class="icon-circle"></i>
                                    <span>created an <span class="greenText">order</span></span>
                                    <i class="icon-circle"></i>
                                    <span>15 days ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                </p>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                            </li>
                        </ul>
                        <!-- ==================== END OF RECENT ORDERS CONTENT ==================== -->

                        <!-- ==================== RECENT TASKS CONTENT ==================== -->
                        <ul class="floatingBoxContainers" id="recentTasks" style="display:none">
                            <li>
                                <div class="circleAvatar"><img src="img/zoidberg-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">George McCain</span>
                                    <i class="icon-circle"></i>
                                    <span>created a <span class="redText">new task</span></span>
                                    <i class="icon-circle"></i>
                                    <span>1 day ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                </p>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                            </li>
                            <li>
                                <div class="circleAvatar"><img src="img/rimmer-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">Arnold Karlsberg</span>
                                    <i class="icon-circle"></i>
                                    <span>created a <span class="redText">new task</span></span>
                                    <i class="icon-circle"></i>
                                    <span>3 days ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                </p>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                            </li>
                            <li>
                                <div class="circleAvatar"><img src="img/peter-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">Peter Kay</span>
                                    <i class="icon-circle"></i>
                                    <span>created a <span class="redText">new task</span></span>
                                    <i class="icon-circle"></i>
                                    <span>5 days ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                </p>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                            </li>
                            <li>
                                <div class="circleAvatar"><img src="img/homer-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">John Doe</span>
                                    <i class="icon-circle"></i>
                                    <span>created a <span class="redText">new task</span></span>
                                    <i class="icon-circle"></i>
                                    <span>5 days ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                </p>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                            </li>
                            <li>
                                <div class="circleAvatar"><img src="img/peter-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">Peter Kay</span>
                                    <i class="icon-circle"></i>
                                    <span>created a <span class="redText">new task</span></span>
                                    <i class="icon-circle"></i>
                                    <span>7 days ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                </p>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                            </li>
                        </ul>
                        <!-- ==================== END OF RECENT TASKS CONTENT ==================== -->
                    </div>
                </div>
            </div>
            <!-- ==================== END OF ACTIVITIES FLOATING BOX ==================== -->
        </div>
    </div>
    <!-- ==================== END OF ACTIVITIES CONTAINER ==================== -->
</div>
<!-- ==================== END OF RIGHT COL ==================== -->                                     <button style="clear: both;" type="submit" class="btn btn-primary">Send</button>
                                                    </form>
                                                </div>
                                                <!--====== MODAL REPLY AND ASSIGN BUTTONS ========-->
                                    </div>
                                </div>
                                <!-- END MODAL DIALOG FOR CONVERSATION -->

                                <h4 class="filled">
                                    <button type="button" class="reply-btn btn btn-primary"><i class="icon-mail-reply"></i> Reply</button>
                                    <button type="button" class="assign-btn btn btn-primary"><i class="icon-male"></i> Assign</button>
                                </h4>
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
                            </li>
                            <li>
                                <div class="circleAvatar"><img src="img/zoidberg-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">George McCain</span>
                                    <i class="icon-circle"></i>
                                    <span>posted a <span class="cyanText">comment</span></span>
                                    <i class="icon-circle"></i>
                                    <span class="icon-comments-alt"></span>
                                    <span>2 Messages in Thread</span>
                                    <i class="icon-circle"></i>
                                    <span>5 hours ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                    <span class="notifyCircle red">2</span></span>
                                </p>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                                <p></p>
                                <p><a data-toggle="modal" role="button" href="#modalDialog"><i class="icon-eye-open"></i> View Entire Thread</a></p>

                                <!-- MODAL DIALOG PER CONVERSATION -->    
                                <div id="modalDialog" class="modal modalDialog hide fade" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h3>John Doe</h3>
                                    </div>
                                    <div class="modal-body">
                                                <p class="headLine">
                                                    <span class="author">John Doe</span>
                                                    <i class="icon-circle"></i>
                                                    <span>posted a <span class="cyanText">comment</span></span>
                                                    <i class="icon-circle"></i>
                                                    <span>2 hours ago</span>
                                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                                </p>
                                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                                                <p class="headLine">
                                                    <span class="author">Maybank</span>
                                                    <i class="icon-circle"></i>
                                                    <span>posted a <span class="cyanText">comment</span></span>
                                                    <i class="icon-circle"></i>
                                                    <span>2 hours ago</span>
                                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                                </p>
                                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                                                
                                                <!--====== MODAL REPLY AND ASSIGN BUTTONS ========-->
                                                <h4 class="filled">
                                                    <button type="button" class="reply-btn btn btn-primary"><i class="icon-mail-reply"></i> Reply</button>
                                                    <button type="button" class="assign-btn btn btn-primary"><i class="icon-male"></i> Assign</button>
                                                </h4>
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
                                                <!--====== MODAL REPLY AND ASSIGN BUTTONS ========-->
                                    </div>
                                </div>
                                <!-- END MODAL DIALOG FOR CONVERSATION -->

                                <h4 class="filled">
                                    <button type="button" class="reply-btn btn btn-primary"><i class="icon-mail-reply"></i> Reply</button>
                                    <button type="button" class="assign-btn btn btn-primary"><i class="icon-male"></i> Assign</button>
                                </h4>
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
                            </li>
                            <li>
                                <div class="circleAvatar"><img src="img/zoidberg-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">George McCain</span>
                                    <i class="icon-circle"></i>
                                    <span>posted a <span class="cyanText">comment</span></span>
                                    <i class="icon-circle"></i>
                                    <span class="icon-comments-alt"></span>
                                    <span>2 Messages in Thread</span>
                                    <i class="icon-circle"></i>
                                    <span>5 hours ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                    <span class="notifyCircle red">2</span></span>
                                </p>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                                <p><a data-toggle="modal" role="button" href="#modalDialog"><i class="icon-eye-open"></i> View Entire Thread</a></p>

                                <!-- MODAL DIALOG PER CONVERSATION -->    
                                <div id="modalDialog" class="modal modalDialog hide fade" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h3>John Doe</h3>
                                    </div>
                                    <div class="modal-body">
                                                <p class="headLine">
                                                    <span class="author">John Doe</span>
                                                    <i class="icon-circle"></i>
                                                    <span>posted a <span class="cyanText">comment</span></span>
                                                    <i class="icon-circle"></i>
                                                    <span>2 hours ago</span>
                                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                                </p>
                                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                                                <p class="headLine">
                                                    <span class="author">Maybank</span>
                                                    <i class="icon-circle"></i>
                                                    <span>posted a <span class="cyanText">comment</span></span>
                                                    <i class="icon-circle"></i>
                                                    <span>2 hours ago</span>
                                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                                </p>
                                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                                                
                                                <!--====== MODAL REPLY AND ASSIGN BUTTONS ========-->
                                                <h4 class="filled">
                                                    <button type="button" class="reply-btn btn btn-primary"><i class="icon-mail-reply"></i> Reply</button>
                                                    <button type="button" class="assign-btn btn btn-primary"><i class="icon-male"></i> Assign</button>
                                                </h4>
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
                                                <!--====== MODAL REPLY AND ASSIGN BUTTONS ========-->
                                    </div>
                                </div>
                                <!-- END MODAL DIALOG FOR CONVERSATION -->

                                <h4 class="filled">
                                    <button type="button" class="reply-btn btn btn-primary"><i class="icon-mail-reply"></i> Reply</button>
                                    <button type="button" class="assign-btn btn btn-primary"><i class="icon-male"></i> Assign</button>
                                </h4>
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
                            </li>
                            <li>
                                <div class="circleAvatar"><img src="img/zoidberg-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">George McCain</span>
                                    <i class="icon-circle"></i>
                                    <span>posted a <span class="cyanText">comment</span></span>
                                    <i class="icon-circle"></i>
                                    <span class="icon-comments-alt"></span>
                                    <span>2 Messages in Thread</span>
                                    <i class="icon-circle"></i>
                                    <span>5 hours ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                    <span class="notifyCircle red">2</span></span>
                                </p>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                                <p><span class="label label-important">CASE</span> <span class="label label-success">RESOLVED</span> </p>
                                <p><a data-toggle="modal" role="button" href="#modalDialog"><i class="icon-eye-open"></i> View Entire Thread</a></p>

                                <!-- MODAL DIALOG PER CONVERSATION -->    
                                <div id="modalDialog" class="modal modalDialog hide fade" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h3>John Doe</h3>
                                    </div>
                                    <div class="modal-body">
                                                <p class="headLine">
                                                    <span class="author">John Doe</span>
                                                    <i class="icon-circle"></i>
                                                    <span>posted a <span class="cyanText">comment</span></span>
                                                    <i class="icon-circle"></i>
                                                    <span>2 hours ago</span>
                                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                                </p>
                                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                                                <p class="headLine">
                                                    <span class="author">Maybank</span>
                                                    <i class="icon-circle"></i>
                                                    <span>posted a <span class="cyanText">comment</span></span>
                                                    <i class="icon-circle"></i>
                                                    <span>2 hours ago</span>
                                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                                </p>
                                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                                                
                                                <!--====== MODAL REPLY AND ASSIGN BUTTONS ========-->
                                                <h4 class="filled">
                                                    <button type="button" class="reply-btn btn btn-primary"><i class="icon-mail-reply"></i> Reply</button>
                                                    <button type="button" class="assign-btn btn btn-primary"><i class="icon-male"></i> Assign</button>
                                                </h4>
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
                                                <!--====== MODAL REPLY AND ASSIGN BUTTONS ========-->
                                    </div>
                                </div>
                                <!-- END MODAL DIALOG FOR CONVERSATION -->

                                <h4 class="filled">
                                    <button type="button" class="reply-btn btn btn-primary"><i class="icon-mail-reply"></i> Reply</button>
                                    <button type="button" class="assign-btn btn btn-primary"><i class="icon-male"></i> Assign</button>
                                </h4>
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
                            </li>
                        </ul>
                        <div class="filled" style="text-align: center;"><button class="btn btn-info"><i class="icon-chevron-down"></i> LOAD MORE</button></div>
                        <!-- ==================== END OF ALL ACTIVITIES CONTENT ==================== -->

                        <!-- ==================== RECENT COMMENTS CONTENT ==================== -->
                        <ul class="floatingBoxContainers" id="recentComments" style="display:none">
                            <li>
                                <div class="circleAvatar"><img src="img/homer-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">John Doe</span>
                                    <i class="icon-circle"></i>
                                    <span>posted a <span class="cyanText">comment</span></span>
                                    <i class="icon-circle"></i>
                                    <span>2 hours ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                </p>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                            </li>
                            <li>
                                <div class="circleAvatar"><img src="img/rimmer-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">Arnold Karlsberg</span>
                                    <i class="icon-circle"></i>
                                    <span>posted a <span class="cyanText">comment</span></span>
                                    <i class="icon-circle"></i>
                                    <span>3 days ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                </p>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                            </li>
                            <li>
                                <div class="circleAvatar"><img src="img/peter-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">Peter Kay</span>
                                    <i class="icon-circle"></i>
                                    <span>posted a <span class="cyanText">comment</span></span>
                                    <i class="icon-circle"></i>
                                    <span>3 days ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                </p>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                            </li>
                            <li>
                                <div class="circleAvatar"><img src="img/zoidberg-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">George McCain</span>
                                    <i class="icon-circle"></i>
                                    <span>posted a <span class="cyanText">comment</span></span>
                                    <i class="icon-circle"></i>
                                    <span>5 days ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                </p>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                            </li>
                            <li>
                                <div class="circleAvatar"><img src="img/homer-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">John Doe</span>
                                    <i class="icon-circle"></i>
                                    <span>posted a <span class="cyanText">comment</span></span>
                                    <i class="icon-circle"></i>
                                    <span>10 days ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                </p>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                            </li>
                        </ul>
                        <!-- ==================== END OF RECENT COMMENTS CONTENT ==================== -->

                        <!-- ==================== RECENT ORDERS CONTENT ==================== -->
                        <ul class="floatingBoxContainers" id="recentOrders" style="display:none">
                            <li>
                                <div class="circleAvatar"><img src="img/peter-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">Peter Kay</span>
                                    <i class="icon-circle"></i>
                                    <span>created an <span class="greenText">order</span></span>
                                    <i class="icon-circle"></i>
                                    <span>5 hours ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                </p>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                            </li>
                            <li>
                                <div class="circleAvatar"><img src="img/zoidberg-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">George McCain</span>
                                    <i class="icon-circle"></i>
                                    <span>created an <span class="greenText">order</span></span>
                                    <i class="icon-circle"></i>
                                    <span>10 days ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                </p>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                            </li>
                            <li>
                                <div class="circleAvatar"><img src="img/homer-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">John Doe</span>
                                    <i class="icon-circle"></i>
                                    <span>created an <span class="greenText">order</span></span>
                                    <i class="icon-circle"></i>
                                    <span>11 days ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                </p>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                            </li>
                            <li>
                                <div class="circleAvatar"><img src="img/rimmer-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">Arnold Karlsberg</span>
                                    <i class="icon-circle"></i>
                                    <span>created an <span class="greenText">order</span></span>
                                    <i class="icon-circle"></i>
                                    <span>12 days ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                </p>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                            </li>
                            <li>
                                <div class="circleAvatar"><img src="img/rimmer-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">Arnold Karlsberg</span>
                                    <i class="icon-circle"></i>
                                    <span>created an <span class="greenText">order</span></span>
                                    <i class="icon-circle"></i>
                                    <span>15 days ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                </p>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                            </li>
                        </ul>
                        <!-- ==================== END OF RECENT ORDERS CONTENT ==================== -->

                        <!-- ==================== RECENT TASKS CONTENT ==================== -->
                        <ul class="floatingBoxContainers" id="recentTasks" style="display:none">
                            <li>
                                <div class="circleAvatar"><img src="img/zoidberg-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">George McCain</span>
                                    <i class="icon-circle"></i>
                                    <span>created a <span class="redText">new task</span></span>
                                    <i class="icon-circle"></i>
                                    <span>1 day ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                </p>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                            </li>
                            <li>
                                <div class="circleAvatar"><img src="img/rimmer-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">Arnold Karlsberg</span>
                                    <i class="icon-circle"></i>
                                    <span>created a <span class="redText">new task</span></span>
                                    <i class="icon-circle"></i>
                                    <span>3 days ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                </p>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                            </li>
                            <li>
                                <div class="circleAvatar"><img src="img/peter-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">Peter Kay</span>
                                    <i class="icon-circle"></i>
                                    <span>created a <span class="redText">new task</span></span>
                                    <i class="icon-circle"></i>
                                    <span>5 days ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                </p>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                            </li>
                            <li>
                                <div class="circleAvatar"><img src="img/homer-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">John Doe</span>
                                    <i class="icon-circle"></i>
                                    <span>created a <span class="redText">new task</span></span>
                                    <i class="icon-circle"></i>
                                    <span>5 days ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                </p>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                            </li>
                            <li>
                                <div class="circleAvatar"><img src="img/peter-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">Peter Kay</span>
                                    <i class="icon-circle"></i>
                                    <span>created a <span class="redText">new task</span></span>
                                    <i class="icon-circle"></i>
                                    <span>7 days ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                </p>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                            </li>
                        </ul>
                        <!-- ==================== END OF RECENT TASKS CONTENT ==================== -->
                    </div>
                </div>
            </div>
            <!-- ==================== END OF ACTIVITIES FLOATING BOX ==================== -->
        </div>
    </div>
    <!-- ==================== END OF ACTIVITIES CONTAINER ==================== -->
</div>
<!-- ==================== END OF RIGHT COL ==================== -->