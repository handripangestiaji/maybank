<?php 
for($i=0; $i<count($fb_pm);$i++):?>
<li>
    <input type="hidden" class="postId" value="<?php echo $fb_pm[$i]->detail_id_from_facebook; ?>" />
    <div class="circleAvatar"><img src="https://graph.facebook.com/<?=number_format($fb_pm[$i]->sender, 0,'.','')?>/picture?small" alt=""></div>
    <p class="headLine">
        <span class="author"><?php echo $fb_pm[$i]->name; ?></span>
        <i class="icon-circle"></i>
        <span>posted a <span class="cyanText">comment</span></span>
        <i class="icon-circle"></i>
        <span><?php echo date('l, M j, Y H:i:s',strtotime($fb_pm[$i]->created_at));?></span>
        <i class="icon-play-circle moreOptions pull-right"></i>
    </p>
    <p><?=$fb_pm[$i]->messages?></p>
    <p><button type="button" class="btn btn-warning btn-mini">OPEN</button><!--button class="btn btn-primary btn-mini" style="margin-left: 5px;">LIKE</button--> </p>
    <p>
        <span class="btn-engagement"><i class="icon-eye-open"></i> Engagement</span> |
        <span class="btn-mark-as-read cyanText" style="display: <?php if($fb_pm[$i]->is_read==1){echo 'none';} ?>"><i class="icon-bookmark"></i> Mark as Read</span>
        <span class="btn-mark-as-unread cyanText" style="display: <?php if($fb_pm[$i]->is_read==0){echo 'none';} ?>"><i class="icon-bookmark-empty"></i> Mark as Unread</span>
    </p>

    <!-- ENGAGEMENT -->    
    <div class="engagement hide">
        <div class="engagement-header">
            <span class="engagement-btn-close btn-close pull-right">Close <i class="icon-remove-sign"></i></span>
        </div>
        <br>
        <?php 
            $comment=$this->facebook_model->RetrievePmDetailFB($fb_pm[$i]->conversation_id);
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
            <div>
                <p>"<?php echo $comment[$j]->messages; ?>"</p>
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
            <textarea placeholder="Compose Message"></textarea>
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
            <div class="pull-left">
                <i class="icon-facebook"></i> 2000     
            </div>
            <div class="pull-right">
                <button class="btn btn-primary btn-small btn-send-reply">SEND</button>    
            </div>
            <br clear="all" />
            <div class="reply-status hide">MESSAGE SENT</div>
        </div>
    </div>
    <!-- END REPLY -->
    
    <!-- CASE -->  
    <div class="case-field hide">
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
    <!-- END CASE -->  
</li>
<?php endfor;?>