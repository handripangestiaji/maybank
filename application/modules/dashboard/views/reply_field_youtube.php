<form action="" method="post" class="reply-tweet">
<div class="row-fluid">
    <span class="dm-field-btn-close btn-close pull-right"><i class="icon-remove"></i></span>
    <div class="pull-left">
        <div class="message"></div>
        <select style="width: 130px;" name="reply_type">
            <option value="Feedback">Feedback</option>
            <option value="Enquiry">Enquiry</option>
            <option value="Complaint">Complaint</option>
        </select>
        <select style="width: 130px;" name="product_type">
         <?php foreach($product_list as $product):?>
             <option value="<?php echo $product->id?>"><?php echo $product->product_name?></option>
         <?php endforeach?>
        </select>
    </div>
    <textarea class='replaycontent' placeholder="Compose Message" name="content"></textarea>
    <br clear="all" />

    <br/>
        <div class="pull-left reply-char-count">
            <i class="icon-twitter-sign"></i>&nbsp;<span class="reply-tw-char-count">140</span>
        </div>
        <div class="pull-right">
                <button class="replayTweet btn btn-primary btn-small btn-send-dm"  value="" type="submit" >SEND</button>    
                <input type="hidden" class="screen_name" value="" />
        </div>
    <br clear="all" />
    <div class="dm-status hide">MESSAGE SENT</div>
</div>
</form>
