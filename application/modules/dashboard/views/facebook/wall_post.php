<?php 
for($i=0; $i<count($fb_feed);$i++):?>
<li>
    <div class="circleAvatar"><img src="https://graph.facebook.com/<?=number_format($fb_feed[$i]->facebook_id, 0,'.','')?>/picture?small" alt=""></div>
    <p class="headLine">
        <span class="author"><?php echo $fb_feed[$i]->name//."(".$fb_feed[$i][$i]->users->usename.")"?></span>
        <i class="icon-circle"></i>
        <span>posted a <span class="cyanText">comment</span></span>
        <i class="icon-circle"></i>
        <span><?php echo $fb_feed[$i]->created_at; ?></span>
        <i class="icon-play-circle moreOptions pull-right"></i>
    </p>
    <p><?=$fb_feed[$i]->post_content?></p>
    <p><button type="button" class="btn btn-warning btn-mini">OPEN</button><button class="btn btn-primary btn-mini" style="margin-left: 5px;">LIKE</button> </p>
    <p><a role="button" href="#showEngagement" class="btn-engagement"><i class="icon-eye-open"></i> Engagement</a> | <a  data-toggle="modal" role="button" href="#modalDialog"><i class="icon-thumbs-up-alt"></i></i> <?php echo $fb_feed[$i]->total_likes; ?> likes this</a></p>

    <!-- MODAL DIALOG PER CONVERSATION -->    
    <div class="engagement hide">
        <div class="engagement-header">
            <a role="button" class="engagement-btn-close pull-right" href="#closeEngagement">Close <i class="icon-remove-sign"></i></a>
        </div>
        <br>
        <div class="engagement-body">
            <a class="engagement-btn-hide-show pull-right" href="#hideEngagement"><i class="icon-chevron-sign-down"></i></a>    
            <p class="headLine">
                <span class="author">John Doe</span>
                <i class="icon-circle"></i>
                <span>posted a <span class="cyanText">comment</span></span>
                <i class="icon-circle"></i>
                <span>2 hours ago</span>
                <i class="icon-play-circle moreOptions pull-right"></i>
            </p>
            <div>
                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
            </div>
        </div>
        <div class="engagement-body">
            <a class="engagement-btn-hide-show pull-right" href="#hideEngagement"><i class="icon-chevron-sign-down"></i></a>    
            <p class="headLine">
                <span class="author">John Doe</span>
                <i class="icon-circle"></i>
                <span>posted a <span class="cyanText">comment</span></span>
                <i class="icon-circle"></i>
                <span>2 hours ago</span>
                <i class="icon-play-circle moreOptions pull-right"></i>
            </p>
            <div>
                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
            </div>
        </div>
    </div>
    <!-- END MODAL DIALOG FOR CONVERSATION -->

    <h4 class="filled">
        <a style="font-size: 20px;"><i class="icon-trash greyText"></i></a>
        <div class="pull-right">
            <button type="button" class="btn btn-primary btn-reply"><i class="icon-mail-reply"></i></button>
            <button type="button" class="btn btn-danger btn-case"><i class="icon-plus"></i> CASE</button>
        </div>
        <br clear="all" />
    </h4>
    <div class="reply-field hide">
        <div class="row-fluid">
            <a role="button" class="reply-field-btn-close pull-right" href="#closeReply"><i class="icon-remove"></i></a>
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
                <i class="icon-camera"></i>
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
    <div class="case-field hide">
        <div class="row-fluid">
            <a role="button" class="reply-field-btn-close pull-right" href="#closeReply"><i class="icon-remove"></i></a>
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
                <i class="icon-camera"></i>
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
</li>
<?php endfor;?>