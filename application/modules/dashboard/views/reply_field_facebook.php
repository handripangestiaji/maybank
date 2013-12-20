<form action="" method="post" class="facebook-tweet">
<div class="row-fluid">
    <span class="reply-field-btn-close btn-close pull-right"><i class="icon-remove"></i></span>
    <div class="pull-left">
        <div class="message"></div>
        <select style="width: 130px;">
            <option value="keyword">Feedback</option>
            <option value="user">Enquiry</option>
            <option value="keyword">Complaint</option>
        </select>
        <select style="width: 130px;">
            <?php foreach($product_list as $product):?>
                <option value="<?=$product->id?>"><?=$product->product_name?></option>
            <?php endforeach?>
        </select>
    </div>
    <textarea class='replaycontent' placeholder="Compose Message"></textarea>
    <br clear="all" />
    <div class="link_url pull-left"  style="margin-bottom: 5px;">
        <i class="icon-link"></i>
        <input type="text" class="reply-insert-link-text">
        <button class="reply-insert-link-btn btn btn-primary btn-mini" style="margin-left: 5px;">SHORTEN</button>
    </div>    
    <div class="pull-right">
        <a href="javascript:void(0);" id="reply-open-img">
            <i class="icon-camera"></i> 
        </a>
    </div>
    <br clear="all"/>
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
            <div class="reply-img-list-upload">
                <input id="demo_box_1" class="css-checkbox" type="checkbox" checked/>
                <label for="demo_box_1" class="css-label">Hide URL</label>
            </div>
        </div>
    </div>
    <div id="reply-url-show" class="hide">
        <div class="compose-form img-attached">
            <!-- close button for image attached -->
            <a id="close-reply-url-show" href="javascript:void(0);">
                <i class="icon-remove-sign icon-large"></i>
            </a>
            <div class="reply-url-show-content">
            <input type="text" class="reply-shorturl-show-content" />
            </div>
        </div>
    </div>
    <div class="left">
        <div class="left">
            <i class="icon-tag icon-large"></i>    
        </div>
        <div class="left">
            <ul id="compose-tags-reply" style="width: 200px;"></ul>        
        </div>
        <br clear="all" />
    </div>    
    <br clear="all" />
    <br />
    <div class="pull-left reply-char-count">
            <i class="icon-facebook-sign"></i>&nbsp;<span class="reply-fb-char-count">2000</span>
    </div>
    <div class="pull-right">
      <?php if($reply_type=='replaycontent'){?>
        <button class="btn btn-primary btn-small btn-send-reply" value="<?php echo $fb_feed[$i]->post_stream_id; ?>">SEND</button>    
      <?php }elseif($reply_type=='reply_nested'){ ?>
        <button class="btn btn-primary btn-small btn-send-reply" value="<?php echo $fb_feed[$i]->comment_stream_id; ?>">SEND</button> 
      <?php }elseif($reply_type=='reply_dm'){  ?>
          <button class="dm_send btn btn-primary btn-small" value="<?php //echo $fb_feed[$i]->comment_stream_id; ?>">SEND</button> 
      <?php } ?>           
    </div>
    <br clear="all" />
    <!--div class="reply-status hide">MESSAGE SENT</div-->
</div>
</form>
