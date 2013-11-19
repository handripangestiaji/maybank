<?php
for($i=0;$i<count($mentions);$i++){
?>
    <li>
        <div class="circleAvatar"><img src="<?php echo $mentions[$i]->user->profile_image_url;?>" alt=""></div>
        <p class="headLine">
            <span class="author"><?php echo $mentions[$i]->user->name; ?></span>
            <i class="icon-circle"></i>
            <span>mentions</span>
            <i class="icon-circle"></i>
            <span><?php echo str_replace('+0000','',$mentions[$i]->created_at);?></span>
            <i class="icon-play-circle moreOptions pull-right"></i>
        </p>
    <p><?php echo $mentions[$i]->text; ?></p>
    
    <p><button type="button" class="btn btn-warning btn-mini">OPEN</button>
    <?php if ($mentions[$i]->retweeted>0) { ?>
        <button type="button" class="btn btn-inverse btn-mini"><i class="icon-retweet">&nbsp;</i></button>
    <?php } ?>    
    <?php if ($mentions[$i]->favorited=='true') { ?>
        <button type="button" class="btn btn-inverse btn-mini"><i class="icon-star">&nbsp;</i></button>
    <?php } ?></p>
    
    <p><a data-toggle="modal" role="button" href="#modalDialogEngagement<?php echo $i; ?>"><i class="icon-eye-open"></i> Engagement</a> | <a data-toggle="modal" role="button" href="#modaltweet<?php echo $i; ?>" ><i class="icon-retweet greyText"></i><?php echo $mentions[$i]->retweeted; ?> re-tweets</a></p>
    
    <!-- MODAL DIALOG Engenagemnet-->    
    <div id="modalDialogEngagement<?php echo $i; ?>" class="modal modalDialog hide fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h3><?php echo $mentions[$i]->user->name; ?></h3>
        </div>
        <div class="modal-body">
                    <p class="headLine">
                        <span class="author"><?php echo $mentions[$i]->user->name; ?></span>
                        <i class="icon-circle"></i>
                        <span>posted a <span class="cyanText">comment</span></span>
                        <i class="icon-circle"></i>
                        <span><?php echo str_replace('+0000','',$mentions[$i]->created_at);?></span>
                        <i class="icon-play-circle moreOptions pull-right"></i>
                    </p>
                    <p>"<?php echo $mentions[$i]->text;?>"</p>
                    <p class="headLine">
                        <span class="author">Maybank</span>
                        <i class="icon-circle"></i>
                        <span>posted a <span class="cyanText">comment</span></span>
                        <i class="icon-circle"></i>
                        <span><?php echo str_replace('+0000','',$mentions[$i]->created_at);?></span>
                        <i class="icon-play-circle moreOptions pull-right"></i>
                    </p>
                    <!-- ==================== END OF CONDENSED TABLE FLOATING BOX ==================== --> 
        </div>
    </div>
    <!-- END MODAL DIALOG FOR ENGAGEMENT -->
    
    <!-- END MODAL DIALOG FOR TWEET -->
    <div id="modaltweet<?php echo $i; ?>" class="modal modalDialog hide fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h3>Re-tweets</h3>
        </div>
        <div class="modal-body">
                    <p class="headLine">
                        <span class="author"><?php echo $mentions[$i]->user->name; ?></span>
                        <i class="icon-circle"></i>
                        <span>posted a <span class="cyanText">comment</span></span>
                        <i class="icon-circle"></i>
                        <span>2 hours ago</span>
                        <i class="icon-play-circle moreOptions pull-right"></i>
                    </p>
        </div>
    </div>    
    <h4 class="filled">
        <a role="button" href="#"><i class="icon-trash greyText"></i></a>
        <div class="pull-right">
            <form class="contentForm" action="<?php echo base_url('/index.php/dashboard/twitteraction');?>" method="post">
                <a role="submit" href="#modalreplaytweet<?php echo $i; ?>" class="btn btn-primary" data-toggle="modal"><i class="icon-mail-reply"></i></a>
                <button type="submit" class="btn btn-primary" name="action" value="retweet"><i class="icon-retweet"></i></button>
                <a role="button" href="#modalsentdm<?php echo $i; ?>" class="btn btn-primary" data-toggle="modal"><i class="icon-envelope"></i></a>
                <button type="submit" class="btn btn-primary" name="action" value="favorit"><i class="icon-star"></i></button>
                <button type="submit" class="btn btn-primary" name="action" value="follow"><i class="icon-user"></i></button>
                <button type="submit" class="btn btn-danger" name="action" value="case"><i class="icon-plus"></i>CASE</button>
                <input type="hidden" name="str_id" value="<?php echo $mentions[$i]->id_str; ?>" />
                <input type="hidden" name="id" value="<?php echo $mentions[$i]->id; ?>" />
                <input type="hidden" name="userid" value="<?php echo $mentions[$i]->user->id_str; ?>" />
                <input type="hidden" name="followid" value="<?php echo $mentions[$i]->in_reply_to_user_id_str; ?>" />
            
               </form>    
        </div>
        <br clear="all" />
    </h4>
    
    <!-- MODAL DIALOG REPLAY TWEET-->    
    <div id="modalreplaytweet<?php echo $i; ?>" class="modal modalDialog hide fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h3><?php echo $mentions[$i]->user->name; ?></h3>
        </div>
        <div class="modal-body">
                    <p class="headLine">
                        <span class="author"><?php echo $mentions[$i]->user->name; ?></span>
                        <i class="icon-circle"></i>
                        <span>posted a <span class="cyanText">comment</span></span>
                        <i class="icon-circle"></i>
                        <span>2 hours ago</span>
                        <i class="icon-play-circle moreOptions pull-right"></i>
                    </p>
                    <p>"<?php echo $mentions[$i]->text;?>"</p>
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
                        <?php form_close(); ?>
                    </h4>
                    <div class="reply filled hide">
                        <form class="contentForm" action="<?php echo base_url('/index.php/dashboard/twitteraction');?>" method="post">
                            <div class="controlButton pull-right"><i class="icon-remove-sign hide-form"></i></div>
                            <textarea style="width: 95%;" rows="9" id="content" name="content"></textarea>
                            <button style="clear: both;" type="submit" class="btn btn-primary" value="sendTweet" id="action" name="action">Send</button>
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
    <!-- END MODAL DIALOG FOR REPLAY TWEET -->
    
    <!-- MODAL DIALOG SENT DIRECT MESSAGE-->    
    <div id="modalsentdm<?php echo $i; ?>" class="modal modalDialog hide fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h3><?php echo $mentions[$i]->user->name; ?></h3>
        </div>
        <div class="modal-body">
                    <p class="headLine">
                        <span class="author"><?php echo $mentions[$i]->user->name; ?></span>
                        <i class="icon-circle"></i>
                        <span>posted a <span class="cyanText">comment</span></span>
                        <i class="icon-circle"></i>
                        <span>2 hours ago</span>
                        <i class="icon-play-circle moreOptions pull-right"></i>
                    </p>
                    <p>"<?php echo $mentions[$i]->text;?>"</p>
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
                            <input type="hidden" name="friendid" value="<?php echo $mentions[$i]->user->id_str; ?>" />
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
<?php } ?>