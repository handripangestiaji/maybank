<form action="" method="post" class="reply-tweet form">
<div class="row-fluid">
    <span class="dm-field-btn-close btn-close pull-right"><i class="icon-remove"></i></span>
    <div class="pull-left">
        
        <input type="hidden" value="<?php echo $mentions[$i]->social_stream_post_id ?>" name="post_id" />
        <input type="hidden" value="<?php echo $mentions[$i]->twitter_user_id?>" name="twitter_user_id" />
        <input type="hidden" value="<?php echo $type?>" name="type" />
        <input type="hidden" value="<?php echo $mentions[$i]->screen_name?>" name="twitter_user" />
        <div class="message"></div>
        <?php
        if(!$mentions[$i]->case || ($mentions[$i]->case[0]->status == 'solved')){ ?>
        <select name="reply_type" class='reply_type' style="width: 130px;">
            <option value="">Please Select</option>
            <option value="Feedback">Feedback</option>
            <option value="Compliment">Compliment</option>
            <option value="Enquiry">Enquiry</option>
            <option value="Complaint">Complaint</option>
            <option value="Report_Abuse">Report Abuse</option>
        </select>
        <select name="product_type" class="product_type" style="width: 130px;">
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
        <?php } ?>
    </div>
    <?php if($mentions[$i]->case){ ?>
        <input type="hidden" value="<?php echo $mentions[$i]->case[0]->case_id?>" name="case_id" class="case_id" />
        <input type="hidden" value="<?php echo $mentions[$i]->case[0]->status?>" name="case_status" class="case_status" />
    <?php } ?>
    <br />
    <div class="textarea-container" onclick="$(this).siblings('textarea').focus()">
        <div class="left screen-name">@<?php echo $mentions[$i]->screen_name?></div>
        <textarea class='replaycontent twitter-reply-field' placeholder="" name="content" style="float:left;text-indent:<?=strlen($mentions[$i]->screen_name) * 9?>px"></textarea>
    </div>
    <br clear="all" />
     <?php  if($type == 'reply'):?>
     <div class="pull-left"  style="margin-bottom: 5px;">
        <i class="icon-link"></i>
        <input type="text" class="reply-insert-link-text">
        <a class="reply-insert-link-btn btn btn-primary btn-mini" style="margin-left: 5px;" href="#">SHORTEN</a>
    </div>
    <div class="btn-reply-open-img">
        <a href="javascript:void(0);" id="reply-open-img">
            <i class="icon-camera"></i> 
        </a>
    </div>
    <br clear="all" />
    <div class="left tags_p">
        <div class="left">
            <i class="icon-tag icon-large"></i>    
        </div>
        <!--div class="left">
            <ul id="compose-tags-reply" style="width: 200px;"></ul>        
        </div-->
        <div class="left tags_c">
            <select class="multipleSelect" multiple="multiple" name="tag_id[]">
            <?php
                $this->load->model('tag_model');
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
                    <img id="reply-preview-img" class="reply-preview-img"/>
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
    <?php endif?>
    <br/>
        <div class="pull-left reply-char-count">
            <i class="icon-twitter-sign"></i>&nbsp;<span class="reply-tw-char-count">140</span>
        </div>
        <div class="pull-right">
                <button class="replayTweet btn btn-primary btn-small btn-send-dm"  value="<?php echo $mentions[$i]->twitter_user_id;?>" type="submit" >SEND</button>    
                <input type="hidden" class="screen_name" value="<?php echo $mentions[$i]->screen_name; ?>" />
        </div>
    <br clear="all" />
    <div class="dm-status hide">MESSAGE SENT</div>
</div>
</form>
