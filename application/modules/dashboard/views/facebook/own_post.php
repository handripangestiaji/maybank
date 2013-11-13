<?php for($i=0; $i<count($own_post);$i++):?>
  
<li>

    <div class="circleAvatar"><img src="https://graph.facebook.com/<?=number_format($fb_feed[$i]->actor_id, 0,'.','')?>/picture?small" alt=""></div>
    <p class="headLine">
        <span class="author"><?php echo $fb_feed[$i]->users->name//."(".$fb_feed[$i]->users->usename.")"?></span>
        <i class="icon-circle"></i>
        <span>posted a <span class="cyanText">comment</span></span>
        <i class="icon-circle"></i>
        <span><?php $date = date("d M y H:i",$fb_feed[$i]->updated_time);
        echo " at ".$date
        ?></span>
        <i class="icon-play-circle moreOptions pull-right"></i>
    </p>
    <p><?=$fb_feed[$i]->message?></p>
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
<?php endfor;?>