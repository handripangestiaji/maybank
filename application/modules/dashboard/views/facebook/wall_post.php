<?php
for($i=0; $i<count($fb_feed);$i++):?>
<li <?php if($fb_feed[$i]->is_read==0){echo 'class="unread-post"';} ?>>
    <input type="hidden" class="postId" value="<?php echo $fb_feed[$i]->post_id; ?>" />
    <div class="circleAvatar"><img src="https://graph.facebook.com/<?=number_format($fb_feed[$i]->facebook_id, 0,'.','')?>/picture?small" alt=""></div>
    <div class="read-mark <?php if($fb_feed[$i]->is_read==0){echo 'redText';} else { echo 'greyText'; } ?>"><i class="icon-bookmark icon-large"></i></div>
    <br />
    <p class="headLine">
        <span class="author"><?php echo $fb_feed[$i]->name//."(".$fb_feed[$i][$i]->users->usename.")"?></span>
        <i class="icon-circle"></i>
        <span>posted a <span class="cyanText">new post</span></span>
        <i class="icon-circle"></i>
        <span><?php echo date('l, M j, Y H:i:s',strtotime($fb_feed[$i]->created_at));?></span>
        <i class="icon-play-circle moreOptions pull-right"></i>
    </p>
    <p><?=$fb_feed[$i]->post_content?></p>
    <p><button type="button" class="btn btn-warning btn-mini">OPEN</button><button class="fblike btn btn-primary btn-mini" style="margin-left: 5px;" value="<?php echo $fb_feed[$i]->post_stream_id;?>">LIKE</button> </p>
    <p>
        <span class="btn-engagement"><i class="icon-eye-open"></i> Engagement</span> |
        <span class="cyanText"><i class="icon-thumbs-up-alt"></i></i> <?php echo $fb_feed[$i]->total_likes; ?> likes</span> | 
        <span class="btn-mark-as-read cyanText" style="display: <?php if($fb_feed[$i]->is_read==1){echo 'none';} ?>"><i class="icon-bookmark"></i> Mark as Read</span>
        <span class="btn-mark-as-unread cyanText" style="display: <?php if($fb_feed[$i]->is_read==0){echo 'none';} ?>"><i class="icon-bookmark-empty"></i> Mark as Unread</span>
    </p>

    <!-- ENGAGEMENT -->    
    <div class="engagement hide">
        <div class="engagement-header">
            <span class="engagement-btn-close btn-close pull-right">Close <i class="icon-remove-sign"></i></span>
        </div>
        <br>
        <?php 
            $comment=$this->facebook_model->RetriveCommentPostFb($fb_feed[$i]->post_id);
            for($j=0;$j<count($comment);$j++){
        ?>
        <div class="engagement-body">
            <span class="engagement-btn-hide-show btn-close pull-right"><i class="icon-caret-down"></i></span>    
            <p class="headLine">
                <span class="author"><?php echo $comment[$j]->name; ?></span>
                <i class="icon-circle"></i>
                <span>posted a <span class="cyanText">comment</span></span>
                <i class="icon-circle"></i>
                <span><?php echo $comment[$j]->created_at; ?></span>
                <i class="icon-play-circle moreOptions pull-right"></i>
            </p>
            <div class="engagement-comment">
                <p>"<?php echo $comment[$j]->comment_content; ?>"</p>
                <p>
                    <button type="button" class="btn btn-warning btn-mini">OPEN</button>
                    <button class="btn btn-primary btn-mini">LIKE</button>
                    <button type="button" class="btn btn-primary btn-engagement-reply btn-mini"><i class="icon-mail-reply"></i></button>
                    <button type="button" class="btn btn-danger btn-engagement-case btn-mini"><i class="icon-plus"></i> CASE</button>
                </p>
                <div class="reply-engagement-field hide">
                    <div class="row-fluid">
                        <span class="reply-field-btn-close btn-close pull-right"><i class="icon-remove"></i></span>
                        <div class="pull-left">
                            <select style="width: 130px;">
                                <option value="keyword">Feedback</option>
                                <option value="user">Enquiry</option>
                                <option value="keyword">Complaint</option>
                            </select>
                            <select style="width: 130px;">
                                <option value="keyword">Accounts & Banking</option>
                                <option value="user">Cards</option>
                                <option value="keyword">Investment</option>
                                <option value="keyword">insurance</option>
                                <option value="user">Loans</option>
                                <option value="keyword">Maybank2u</option>
                                <option value="keyword">Others</option>
                            </select>
                        </div>
                        <textarea class="reply_comment placeholder="Compose Message"></textarea>
                        <br clear="all" />
                        <div class="pull-left">
                            <i class="icon-link"></i>
                            <input type="text" class="span8"><button class="btn btn-primary btn-mini" style="margin-left: 5px;">SHORTEN</button>
                        </div>
                        <div class="pull-right">
                            <a href="javascript:void(0);" id="reply-open-img">
                                <i class="icon-camera"></i> 
                            </a>
                        </div>
                        <br clear="all" />
                        <div id="reply-img-show">
                            <div class="reply-img-attached">
                                <!-- close button for image attached -->
                                <a id="reply-img-close" href="javascript:void(0);">
                                 <i class="icon-remove-sign"></i>
                                </a>
                            </div>
                        </div>
                        <br clear="all" />
                        <div class="pull-left reply-char-count">
                            <i class="icon-facebook-sign"></i>&nbsp;<span class="reply-fb-char-count">2000</span>
                        </div>
                        <div class="pull-right">
                            <button class="btn btn-primary btn-small btn-send-reply">SEND</button>    
                        </div>
                        <br clear="all" />
                        <div class="reply-status hide">MESSAGE SENT</div>
                    </div>
                </div>
                <div class="case-engagement-field hide">
                    <div class="row-fluid">
                        <span class="reply-field-btn-close btn-close pull-right"><i class="icon-remove"></i></span>
                        CASE ID      : #012345
                        <div class="pull-left">
                            <select style="width: 130px;">
                                <option value="keyword">Feedback</option>
                                <option value="user">Enquiry</option>
                                <option value="keyword">Complaint</option>
                            </select>
                            <select style="width: 130px;">
                                <option value="keyword">Accounts & Banking</option>
                                <option value="user">Cards</option>
                                <option value="keyword">Investment</option>
                                <option value="keyword">insurance</option>
                                <option value="user">Loans</option>
                                <option value="keyword">Maybank2u</option>
                                <option value="keyword">Others</option>
                            </select>
                        </div>
                        <br clear="all" />
                        <button class="btn btn-small btn-purple btn-add-related">Add Related Conversation</button>
                        <br clear="all" />
                        <div class="pull-left">
                            Assign To:
                        </div>
                        <div class="pull-right">
                            <select>
                                <option value="keyword">Nicole Lee</option>
                                <option value="user">Azahan Azad</option>
                                <option value="keyword">Azahamad Arif</option>
                            </select>
                        </div>
                        <br clear="all" />
                        <div class="pull-left">
                            Email:
                        </div>
                        <div class="pull-right">
                            <input type="text">
                        </div>
                        <br clear="all" />
                        Message :
                        <br>
                        <textarea placeholder="Compose Message"></textarea>
                        <br clear="all" />
                        <div class="pull-right">
                            <button class="btn-purple btn btn-small"><i class="icon-ok-circle icon-large"></i> Assign</button>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
       <?php } ?>
       <!-- ==================== CONDENSED TABLE HEADLINE ==================== -->
        <div class="containerHeadline">
            <i class="icon-table"></i><h2>Action Log</h2>
            <div class="controlButton pull-right"><i class="icon-caret-down toggleTable"></i></div>
        </div>
        <!-- ==================== END OF CONDENSED TABLE HEADLINE ==================== -->

        <!-- ==================== CONDENSED TABLE FLOATING BOX ==================== -->
        <div class="floatingBox table hide">
            <div class="container-fluid">
                <table class="table table-striped">
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
    <!-- END ENGAGEMENT -->

    <h4 class="filled">
        <a style="font-size: 20px;"><i class="icon-trash greyText"></i></a>
        <div class="pull-right">
            <button type="button" class="btn btn-primary btn-reply"><i class="icon-mail-reply"></i></button>
            <button type="button" class="btn btn-danger btn-case"><i class="icon-plus"></i> CASE</button>
        </div>
        <br clear="all" />
    </h4>
    
    <!-- REPLY -->  
    <div class="reply-field hide">
        <div class="row-fluid">
            <span class="reply-field-btn-close btn-close pull-right"><i class="icon-remove"></i></span>
            <div class="pull-left">
                <select style="width: 130px;">
                    <option value="keyword">Feedback</option>
                    <option value="user">Enquiry</option>
                    <option value="keyword">Complaint</option>
                </select>
                <select style="width: 130px;">
                    <option value="keyword">Accounts & Banking</option>
                    <option value="user">Cards</option>
                    <option value="keyword">Investment</option>
                    <option value="keyword">insurance</option>
                    <option value="user">Loans</option>
                    <option value="keyword">Maybank2u</option>
                    <option value="keyword">Others</option>
                </select>
            </div>
            <textarea class='reply_comment' placeholder="Compose Message"></textarea>
            <br clear="all" />
            <div class="pull-left">
                <i class="icon-link"></i>
                <input type="text" class="span8"><button class="btn btn-primary btn-mini" style="margin-left: 5px;">SHORTEN</button>
            </div>
            <div class="pull-right">
                <a href="javascript:void(0);" id="reply-open-img">
                    <i class="icon-camera"></i> 
                </a>
            </div>
            <br clear="all" />
            <div id="reply-img-show">
                <div class="reply-img-attached">
                    <!-- close button for image attached -->
                    <a id="reply-img-close" href="javascript:void(0);">
                     <i class="icon-remove-sign"></i>
                    </a>
                </div>
            </div>
            <br clear="all" />
            <div class="pull-left reply-char-count">
                <i class="icon-facebook-sign"></i>&nbsp;<span class="reply-fb-char-count">2000</span>
            </div>
            <div class="pull-right">
                <button class="send_reply btn btn-primary btn-small btn-send-reply" value="<?php echo $fb_feed[$i]->post_stream_id;?>">SEND</button>    
            </div>
            <br clear="all" />
            <div class="reply-status hide">MESSAGE SENT</div>
        </div>
    </div>
    <!-- END REPLY -->
    
    <!-- CASE -->
    <div class="case-field hide">
    <?php
        $data['posts'] = $fb_feed;
        $data['i'] = $i;
        $this->load->view('dashboard/case_field',$data);
    ?>
    </div>
    <!-- END CASE -->  
</li>
<?php endfor;?>