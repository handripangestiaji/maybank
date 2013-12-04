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