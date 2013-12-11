<form action="" method="post" class="reply-tweet">
<div class="row-fluid">
    <span class="dm-field-btn-close btn-close pull-right"><i class="icon-remove"></i></span>
    <div class="pull-left">
        <input type="hidden" value="<?=$mentions[$i]->post_id?>" name="post_id" />
        <div class="message"></div>
        <select style="width: 130px;" name="reply_type">
            <option value="Feedback">Feedback</option>
            <option value="Enquiry">Enquiry</option>
            <option value="Complaint">Complaint</option>
        </select>
        <select style="width: 130px;" name="product_type">
         <?php foreach($product_list as $product):?>
             <option value="<?=$product->id?>"><?=$product->product_name?></option>
         <?php endforeach?>
        </select>
    </div>
    <textarea class='replaycontent' placeholder="Compose Message" name="content">@<?php echo $mentions[$i]->screen_name; ?></textarea>
    <br clear="all" />
     <div class="pull-left"  style="margin-bottom: 5px;">
        <i class="icon-link"></i>
        <input type="text" class="reply-insert-link-text">
        <button class="reply-insert-link-btn btn btn-primary btn-mini" style="margin-left: 5px;">SHORTEN</button>
    </div>
    <div class="pull-right">
        <a href="javascript:void(0);" id="reply-open-img">
            <i class="icon-camera"></i> 
        </a>
    </div>
    <br clear="all" />
    <div id="reply-img-show" class="hide">
        <div class="compose-form img-attached">
            <!-- close button for image attached -->
            <a id="close-reply-img-show" href="javascript:void(0);">
                <i class="icon-remove-sign icon-large"></i>
            </a>
            <div class="dummyfile">
                <input type="file" id="replyInputImageFile" style="display: none;">
                <input id="replyfilename" type="text" class="input disabled" name="filename" readonly>
                <a id="replyfileselectbutton" class="btn btn-small btn-inverse">Upload Image</a>
            </div>
            <div class="reply-img-list-upload">
                <div class="img-place">
                    <a id="reply-remove-img" href="javascript:void(0); class="hide">
                        <i class="icon-remove icon-2x"></i>
                    </a>
                    <img id="reply-preview-img"/>
                </div>
                <!-- img-place end -->
            </div>
            <!-- img-list-upload end -->
        </div>
    </div>
    <div id="reply-url-show" class="hide">
        <div class="compose-form img-attached">
            <!-- close button for image attached -->
            <a id="close-reply-url-show" href="javascript:void(0);">
                <i class="icon-remove-sign icon-large"></i>
            </a>
            <div class="reply-url-show-content">
            </div>
        </div>
    </div>
    <br clear="all" />
    <br/>
        <div class="pull-left reply-char-count">
            <i class="icon-twitter-sign"></i>&nbsp;<span class="reply-tw-char-count">140</span>
        </div>
        <div class="pull-right">
                <button class="dm_send replayTweet btn btn-primary btn-small btn-send-dm"  type="submit" value="<?=$mentions[$i]->twitter_user_id;?>" >SEND</button>    
                <input type="hidden" class="screen_name" value="<?php echo $mentions[$i]->screen_name; ?>" />
        </div>
    <br clear="all" />
    <div class="dm-status hide">MESSAGE SENT</div>
</div>
</form>
