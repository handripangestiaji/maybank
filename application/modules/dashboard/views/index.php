<!-- 18:33  -->
<!-- COMPOSE --> 
<div class="row-fluid">
    <div style="width: 100%; height: 40px;">
        <div style="float:left;">
            <button type="button" style="float: left;"><i class="icon-rotate-right"></i></button>
            <input type="text" placeholder="Compose Message" style="width:400px; float: left; margin-left: 20px;">
            <button type="button" style="float: left;"><i class="icon-calendar"></i></button>
        </div>
        <div style="float:right;">
            <select style="width: 100px; float: left;">
                <option style="display:none">Type</option>
                <option value="user">User</option>
                <option value="keyword">Keyword</option>
            </select>
            <input type="text" placeholder="Search" style="width:200px; float: left; margin-left: 2px;">
            <a href="" style="float: left; height: 14px;">
                <span class="add-on" style="background-color: black;color: white;margin-left: -1px; display: inline-block; white-space: nowrap; padding: 5px 6px; font-size: 14px;"><i class="icon-search"></i></span></a>
        </div>
    </div>
</div>


<!--I'm testing this file commit    bla bla bla-->
<div class="row-fluid">
<!-- ==================== LEFT COL ==================== -->
<div class="span4">
    <!-- ==================== ACTIVITIES CONTAINER ==================== -->
    <div class="row-fluid">
        <div class="span12">
            <!-- ==================== ACTIVITIES HEADLINE ==================== -->
            <div class="containerHeadline" style="background-color:#3B5998; color: white; height: 30px;">
                <div class="pull-left" style="padding: 4px 0px; height: auto">
                    <i class="icon-facebook-sign"></i><h2>Facebook</h2>
                </div>
                <div class="pull-right">
                    <select style="width: 130px;">
                        <option value="all">All</option>
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
                            <li class="active"><a href="#allActivities">Wall Posts</a></li>
                            <li><a href="#recentComments">Private Messages</a></li>
                        </ul>
                    </div>
                    <!-- ==================== END OF ACTIVITIES MENU ==================== -->

                    <div class="container-fluid">
                        <!-- ==================== ALL ACTIVITIES CONTENT ==================== -->
                        <ul class="floatingBoxContainers" id="allActivities">
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
                                <p><button type="button" class="btn btn-warning btn-mini">OPEN</button><button class="btn btn-primary btn-mini" style="margin-left: 5px;">LIKE</button> </p>
                                <p><a data-toggle="modal" role="button" href="#modalDialog"><i class="icon-eye-open"></i> View Entire Thread</a> | <a  data-toggle="modal" role="button" href="#modalDialog"><i class="icon-thumbs-up-alt"></i></i> 24 like this</a></p>

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

                                                <!-- ==================== CONDENSED TABLE HEADLINE ==================== -->
                                                <div class="containerHeadline">
                                                    <i class="icon-table"></i><h2>Action Log</h2>
                                                    <div class="controlButton pull-right"><i class="icon-caret-down minimizeElement"></i></div>
                                                </div>
                                                <!-- ==================== END OF CONDENSED TABLE HEADLINE ==================== -->

                                                <!-- ==================== CONDENSED TABLE FLOATING BOX ==================== -->
                                                <div class="floatingBox table hide">
                                                    <div class="container-fluid">
                                                        <table class="table table-condensed">
                                                          <thead>
                                                            <tr>
                                                              <th>Time Stamp</th>
                                                              <th>Username</th>
                                                              <th>Action Taken</th>
                                                              <th></th>
                                                            </tr>
                                                          </thead>
                                                          <tbody>
                                                            <tr>
                                                              <td>2013-09-30 19:52:46</td>
                                                              <td>Teo Eu Gene</td>
                                                              <td>Resolved</td>
                                                              <td><button class="btn btn-primary icon-book"></button></td>
                                                            </tr>
                                                            <tr>
                                                              <td>2013-09-30 19:52:46</td>
                                                              <td>Teo Eu Gene</td>
                                                              <td>Resolved</td>
                                                              <td><button class="btn btn-primary icon-book"></button></td>
                                                            </tr>
                                                          </tbody>
                                                        </table>  
                                                    </div>
                                                </div>
                                                <!-- ==================== END OF CONDENSED TABLE FLOATING BOX ==================== --> 
                                    </div>
                                </div>
                                <!-- END MODAL DIALOG FOR CONVERSATION -->

                                <h4 class="filled">
                                    <a style="font-size: 20px;"><i class="icon-trash greyText"></i></a>
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-danger" style="margin-left: 10px;"><i class="icon-plus"></i> CASE</button>
                                        <button type="button" class="btn btn-primary" style="margin-left: 10px;"><i class="icon-mail-reply"></i></button>
                                    </div>
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
                                <div class="circleAvatar"><img src="img/peter-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">Peter Kay</span>
                                    <i class="icon-circle"></i>
                                    <span>posted a <span class="cyanText">comment</span></span>
                                    <i class="icon-circle"></i>
                                    <span class="icon-comments-alt"></span>
                                    <span>12 Messages in Thread</span>
                                    <i class="icon-circle"></i>
                                    <span>5 hours ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                    <span class="notifyCircle red">12</span></span>
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
                                <p><span class="label label-important">CASE</span> <span class="label label-warning">OPEN</span> </p>
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

                                                <!-- ==================== CONDENSED TABLE HEADLINE ==================== -->
                                                <div class="containerHeadline">
                                                    <i class="icon-table"></i><h2>Action Log</h2>
                                                    <div class="controlButton pull-right"><i class="icon-caret-down minimizeElement"></i></div>
                                                </div>
                                                <!-- ==================== END OF CONDENSED TABLE HEADLINE ==================== -->

                                                <!-- ==================== CONDENSED TABLE FLOATING BOX ==================== -->
                                                <div class="floatingBox table hide">
                                                    <div class="container-fluid">
                                                        <table class="table table-condensed">
                                                          <thead>
                                                            <tr>
                                                              <th>Time Stamp</th>
                                                              <th>Username</th>
                                                              <th>Action Taken</th>
                                                              <th></th>
                                                            </tr>
                                                          </thead>
                                                          <tbody>
                                                            <tr>
                                                              <td>2013-09-30 19:52:46</td>
                                                              <td>Teo Eu Gene</td>
                                                              <td>Resolved</td>
                                                              <td><button class="btn btn-primary icon-book"></button></td>
                                                            </tr>
                                                            <tr>
                                                              <td>2013-09-30 19:52:46</td>
                                                              <td>Teo Eu Gene</td>
                                                              <td>Resolved</td>
                                                              <td><button class="btn btn-primary icon-book"></button></td>
                                                            </tr>
                                                          </tbody>
                                                        </table>  
                                                    </div>
                                                </div>
                                                <!-- ==================== END OF CONDENSED TABLE FLOATING BOX ==================== --> 
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
                                <div class="circleAvatar"><img src="img/peter-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">Peter Kay</span>
                                    <i class="icon-circle"></i>
                                    <span>posted a <span class="cyanText">comment</span></span>
                                    <i class="icon-circle"></i>
                                    <span class="icon-comments-alt"></span>
                                    <span>12 Messages in Thread</span>
                                    <i class="icon-circle"></i>
                                    <span>5 hours ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                    <span class="notifyCircle red">12</span></span>
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


<!-- ==================== MIDDLE COL ==================== -->
<div class="span4">
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
                        <option value="all">All</option>
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
                            <li class="active"><a href="#mentions">Mentions</a></li>
                            <li><a href="#homefeed">Homefeed</a></li>
                            <li><a href="#sentTweets">Sent Tweets</a></li>
                            <li><a href="#dmInbox">DM Inbox</a></li>
                            <li><a href="#dmOutbox">DM Outbox</a></li>
                        </ul>
                    </div>
                    <!-- ==================== END OF ACTIVITIES MENU ==================== -->

                    <div class="container-fluid">
                        <!-- ==================== ALL ACTIVITIES CONTENT ==================== -->
                        <ul class="floatingBoxContainers" id="mentions">
                            <li>
                                <div class="circleAvatar"><img src="img/homer-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">Classie Lisette</span>
                                    <i class="icon-circle"></i>
                                    <span>posted a <span class="cyanText">mention</span></span>
                                    <i class="icon-circle"></i>
                                    <span>2 hours ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                </p>
                                <p>@akasuki911 http://t.co/o4E0ydWMBs</p>
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
                            <li>
                                <div class="circleAvatar"><img src="img/peter-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">Adrian Lee</span>
                                    <i class="icon-circle"></i>
                                    <span>posted a <span class="greenText">mention</span></span>
                                    <i class="icon-circle"></i>
                                    <span>5 hours ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                </p>
                                <p>At @akasuki911 the Curve, which is full of ppl as always. Why have 6 counters when 2 are permanently closed? twohourwait</p>
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
                            <li>
                                <div class="circleAvatar"><img src="img/peter-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">Adrian Lee</span>
                                    <i class="icon-circle"></i>
                                    <span>posted a <span class="greenText">mention</span></span>
                                    <i class="icon-circle"></i>
                                    <span>5 hours ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                </p>
                                <p>At @akasuki911 the Curve, which is full of ppl as always. Why have 6 counters when 2 are permanently closed? twohourwait</p>
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
                            <li>
                                <div class="circleAvatar"><img src="img/peter-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">Adrian Lee</span>
                                    <i class="icon-circle"></i>
                                    <span>posted a <span class="greenText">mention</span></span>
                                    <i class="icon-circle"></i>
                                    <span>5 hours ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                </p>
                                <p>At @akasuki911 the Curve, which is full of ppl as always. Why have 6 counters when 2 are permanently closed? twohourwait</p>
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
                            <li>
                                <div class="circleAvatar"><img src="img/peter-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">Adrian Lee</span>
                                    <i class="icon-circle"></i>
                                    <span>posted a <span class="greenText">mention</span></span>
                                    <i class="icon-circle"></i>
                                    <span>5 hours ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                </p>
                                <p>At @akasuki911 the Curve, which is full of ppl as always. Why have 6 counters when 2 are permanently closed? twohourwait</p>
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
<!-- ==================== END OF MIDDLE COL ==================== -->



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
                        <option value="all">All</option>
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
                            <li class="active"><a href="#allActivities">All activities</a></li>
                            <li><a href="#recentComments">Video Uploads</a></li>
                            <li><a href="#recentOrders">Video Comments</a></li>
                        </ul>
                    </div>
                    <!-- ==================== END OF ACTIVITIES MENU ==================== -->

                    <div class="container-fluid">
                        <!-- ==================== ALL ACTIVITIES CONTENT ==================== -->
                        <ul class="floatingBoxContainers" id="allActivities">
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
                                <p><span class="label label-important">CASE</span> <span class="label label-warning">OPEN</span> </p>
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

                                                <!-- ==================== CONDENSED TABLE HEADLINE ==================== -->
                                                <div class="containerHeadline">
                                                    <i class="icon-table"></i><h2>Action Log</h2>
                                                    <div class="controlButton pull-right"><i class="icon-caret-down minimizeElement"></i></div>
                                                </div>
                                                <!-- ==================== END OF CONDENSED TABLE HEADLINE ==================== -->

                                                <!-- ==================== CONDENSED TABLE FLOATING BOX ==================== -->
                                                <div class="floatingBox table hide">
                                                    <div class="container-fluid">
                                                        <table class="table table-condensed">
                                                          <thead>
                                                            <tr>
                                                              <th>Time Stamp</th>
                                                              <th>Username</th>
                                                              <th>Action Taken</th>
                                                              <th></th>
                                                            </tr>
                                                          </thead>
                                                          <tbody>
                                                            <tr>
                                                              <td>2013-09-30 19:52:46</td>
                                                              <td>Teo Eu Gene</td>
                                                              <td>Resolved</td>
                                                              <td><button class="btn btn-primary icon-book"></button></td>
                                                            </tr>
                                                            <tr>
                                                              <td>2013-09-30 19:52:46</td>
                                                              <td>Teo Eu Gene</td>
                                                              <td>Resolved</td>
                                                              <td><button class="btn btn-primary icon-book"></button></td>
                                                            </tr>
                                                          </tbody>
                                                        </table>  
                                                    </div>
                                                </div>
                                                <!-- ==================== END OF CONDENSED TABLE FLOATING BOX ==================== --> 
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
                                <div class="circleAvatar"><img src="img/peter-avatar.jpg" alt=""></div>
                                <p class="headLine">
                                    <span class="author">Peter Kay</span>
                                    <i class="icon-circle"></i>
                                    <span>posted a <span class="cyanText">comment</span></span>
                                    <i class="icon-circle"></i>
                                    <span class="icon-comments-alt"></span>
                                    <span>12 Messages in Thread</span>
                                    <i class="icon-circle"></i>
                                    <span>5 hours ago</span>
                                    <i class="icon-play-circle moreOptions pull-right"></i>
                                    <span class="notifyCircle red">12</span></span>
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
</div>