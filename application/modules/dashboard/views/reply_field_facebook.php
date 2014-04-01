<div action="" method="post" class="facebook-tweet form">

<div class="row-fluid">
    <span class="fb-reply-field-btn-close btn-close pull-right"><i class="icon-remove"></i></span>
    <div class="option-type pull-left">
        <div class="message"></div>
        <select class="replyType" style="width: 130px;">
            <option value="">Please Select</option>
            <option value="Feedback">Feedback</option>
            <option value="Enquiry">Enquiry</option>
            <option value="Complaint">Complaint</option>
            <option value="Report_Abuse">Report Abuse</option>  
        </select>
            
        <select class="productType" style="width: 130px;">
         <option value="">Please Select</option>
            <?php foreach($product_list as $product):?>
                <?php
                    if(isset($product->child)){ ?>
                        <optgroup label="<?=$product->product_name?>"></optgroup>
                    <?php }
                    else{ ?>
                        <option value="<?=$product->id?>"><?=$product->product_name?></option>
                    <?php }
                
                    if(isset($product->child)){
                        foreach($product->child as $child){ ?>
                        <option value="<?=$child->id?>">-&nbsp;&nbsp;<?=$child->product_name?></option> 
                        <?php }
                    } ?>
            <?php endforeach?>
        </select>
    </div>
    <textarea class='replaycontent' placeholder="Compose Message"></textarea>
    <br clear="all" />
    <div class="link_url pull-left"  style="margin-bottom: 5px;">
        <i class="icon-link"></i>
        <input type="text" class="source_link reply-insert-link-text">
        <input type="hidden" class="short_code" />
        <button class="reply-insert-link-btn btn btn-primary btn-mini" style="margin-left: 5px;">SHORTEN</button>
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
     <?php if($reply_type!='reply_dm'){?> 
    <div class="pull-right reply-open-img">
        <a href="javascript:void(0);" id="reply-open-img">
            <i class="icon-camera"></i> 
        </a>
    </div>
    <?php } ?>
     <div class="left">
        <div class="left">
            <i class="icon-tag icon-large"></i>    
        </div>
        <div class="left">
            <select class="multipleSelect" multiple="multiple" name="tag_id[]">
            <?php 
                  $tags=$this->tag_model->get();
                  if($tags): ?>
                  
                          <?php 
                          $ids=uniqid();
                          foreach($tags as $v): ?>
                                  <option value="<?php echo $ids."|".$v->id; ?>"><?php echo $v->tag_name ?></option>
                          <?php endforeach; ?>
                  <?php else: ?>
                          <option>Please add Tag first</option>
                  <?php endif;?>
              </select>
        </div>
                        
        <br clear="all" />
    </div>    
    <br clear="all"/>
     <?php if($reply_type!='reply_dm'){?>
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
    <?php } ?>
   
    <br clear="all" />
    <br />
    <div class="pull-left reply-char-count">
            <i class="icon-facebook-sign"></i>&nbsp;<span class="reply-fb-char-count">2000</span>
    </div>
    <div class="pull-right">
      <?php if($reply_type=='replaycontent'){?>
        <button class="btn btn-primary btn-small btn-send-reply" value="<?php echo $fb_feed[$i]->post_id; ?>" >SEND</button>    
      <?php }elseif($reply_type=='reply_nested'){
       // print_r($fb_feed[$i]);
        ?>
        <button class="btn btn-primary btn-small btn-send-reply" value="<?php echo $fb_feed[$i]->comment_post_id; ?>">SEND</button> 
      <?php }elseif($reply_type=='reply_dm'){  ?> 
           <input type="hidden" class="case_id"  value="<?php if(isset($fb_feed[$i]->case_id)){echo $fb_feed[$i]->case_id;}else{echo 'null';} ?>" />   
          <button class="btn btn-primary btn-small btn-send-msg"  value="<?php echo $fb_feed[$i]->post_id; ?>" >SEND</button> 
      <?php } ?>           
    </div>
    <br clear="all" />
    <!--div class="reply-status hide">MESSAGE SENT</div-->
</div>
</div>

