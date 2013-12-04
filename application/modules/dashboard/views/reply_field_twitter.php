<div class="row-fluid">
    <span class="dm-field-btn-close btn-close pull-right"><i class="icon-remove"></i></span>
    <div class="pull-left">
        <select style="width: 130px;" name="case_type">
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
    <div class="pull-left">
        <i class="icon-link"></i>
        <input type="text" class="span8"><button class="btn btn-primary btn-mini" style="margin-left: 5px;">SHORTEN</button>
    </div>
    <div class="pull-right">
        <i class="icon-camera"></i>
    </div>
    <br clear="all" />
    <div class="pull-left">
        
        <i class="icon-twitter"></i> <span class="char-text-count">140</span>
    </div>
    <div class="pull-right">
        <button class="dm_send btn btn-primary btn-small btn-send-dm"  type="button" value="<?=$mentions[$i]->twitter_user_id;?>" >SEND</button>    
               <input type="hidden" class="screen_name" value="<?php echo $mentions[$i]->screen_name; ?>" />
    </div>
    <br clear="all" />
    <div class="dm-status hide">MESSAGE SENT</div>
</div>