<?php
    for($i=0;$i<count($directmessage);$i++){
    ?>
    <li <?php if($directmessage[$i]->is_read==0){echo 'class="unread-post"';} ?>>
        <div class="circleAvatar"><img src="<?php echo $directmessage[$i]->sender->profile_image_url; ?>" alt=""></div>
        <div class="read-mark <?php if($directmessage[$i]->is_read==0){echo 'redText';} else { echo 'greyText'; } ?>"><i class="icon-bookmark icon-large"></i></div>
        <br />
        <p class="headLine">
            <span class="author">'<?php echo $directmessage[$i]->sender->screen_name; ?>'</span>
            <i class="icon-circle"></i>
            <span>mentions</span>
            <i class="icon-circle"></i>
            <span>'<?php echo str_replace('+0000','',$directmessage[$i]->created_at);?>'</span>
            <i class="icon-play-circle moreOptions pull-right"></i>
        </p>
        <p><?php echo $directmessage[$i]->text;?></p>
        <p><button type="button" class="btn btn-warning btn-mini">OPEN</button></p>
        <h4 class="filled">
        <a role="button" href="#"><i class="icon-trash greyText"></i></a>
        <div class="pull-right">
            <form class="contentForm" action="<?php echo base_url('/index.php/dashboard/twitteraction');?>" method="post">
                <a role="button" href="#modalsentdm<?php echo $i; ?>" class="btn btn-primary" data-toggle="modal"><i class="icon-envelope"></i></a>
                <button type="button" class="btn btn-primary" name="action" value="follow"><i class="icon-user"></i></button>
                <button type="button" class="btn btn-danger" name="action" value="case"><i class="icon-plus"></i>CASE</button>
                <input type="hidden" name="str_id" value="<?php //echo json$directmessage[$i]->id_str; ?>" />
                <input type="hidden" name="id" value="<?php //echo $directmessage[$i]->id; ?>" />
             </form>    
        </div>
        <br clear="all" />
        </h4>
    </li>
        <!-- MODAL DIALOG SENT DIRECT MESSAGE-->    
    <div id="modalsentdm<?php echo $i; ?>" class="modal modalDialog hide fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h3><?php //echo $directmessage[$i]->user->screen_name; ?></h3>
        </div>
        <div class="modal-body">
                    <p class="headLine">
                        <span class="author"><?php //echo $directmessage[$i]->user->screen_name; ?></span>
                        <i class="icon-circle"></i>
                        <span>posted a <span class="cyanText">comment</span></span>
                        <i class="icon-circle"></i>
                        <span>2 hours ago</span>
                        <i class="icon-play-circle moreOptions pull-right"></i>
                    </p>
                    <p>"<?php echo $directmessage[$i]->text;?>"</p>
                    <p class="headLine">
                        <span class="author">Maybank</span>
                        <i class="icon-circle"></i>
                        <span>posted a <span class="cyanText">comment</span></span>
                        <i class="icon-circle"></i>
                        <span>2 hours ago</span>
                        <i class="icon-play-circle moreOptions pull-right"></i>
                    </p>
                    <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>

                    <!--====== MODAL REPLY DIRECT MESSAGE AND ASSIGN BUTTONS ========-->
                    <h4 class="filled">
                        <button type="button" class="reply-btn btn btn-primary"><i class="icon-mail-reply"></i> Reply</button>
                        <button type="button" class="assign-btn btn btn-primary"><i class="icon-male"></i> Assign</button>
                        <?php form_close(); ?>
                    </h4>
                    <div class="reply filled hide">
                        <form class="contentForm" action="<?php echo base_url('/index.php/dashboard/twitterAction');?>" method="post">
                            <div class="controlButton pull-right"><i class="icon-remove-sign hide-form"></i></div>
                            <textarea style="width: 95%;" rows="9" id="content" name="content"></textarea>
                            <input type="hidden" name="friendid" value="<?php //echo $directmessage[$i]->user->id_str; ?>" />
                            <button style="clear: both;" type="submit" id="action" name="action" value="sent_dm" class="btn btn-primary">Send</button>
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
    <!-- END MODAL DIALOG FOR SENT DIRECT MESSAGE -->       
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
    <?php 
    }
 ?>