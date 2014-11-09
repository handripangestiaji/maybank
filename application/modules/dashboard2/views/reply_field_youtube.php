<form action="" method="post" class="reply-youtube form">
<div class="row-fluid">
    <span class="dm-field-btn-close btn-close pull-right"><i class="icon-remove"></i></span>
    <div class="pull-left">
        <input type="hidden" value="<?php echo $post_id ?>" name="post_id" />
        <input type="hidden" value="<?php echo $post[0]->video_id ?>" name="video_id" />
        <div class="message"></div>
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
    </div>
    <br />
    <div class="textarea-container" onclick="$(this).siblings('textarea').focus()">
        <textarea class='replaycontent youtube-reply-field' placeholder="" name="content" style="float:left;"></textarea>
    </div>
    <br clear="all" />
     <div class="pull-left"  style="margin-bottom: 5px;">
        <i class="icon-link"></i>
        <input type="text" class="reply-insert-link-text">
        <a class="reply-insert-link-btn btn btn-primary btn-mini" style="margin-left: 5px;" href="#">SHORTEN</a>
    </div>
    <br clear="all" />
    <div class="left tags_p">
        <div class="left">
            <i class="icon-tag icon-large"></i>    
        </div>
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
    <br/>
        <div class="pull-left reply-char-count">
            <i class="icon-youtube-sign"></i>&nbsp;<span class="reply-yt-char-count">500</span>
        </div>
        <div class="pull-right">
                <button class="replyYoutube btn btn-primary btn-small" value="<?php echo $this->input->get('post_id');?>" type="submit" >SEND</button>    
        </div>
    <br clear="all" />
    <div class="dm-status hide">MESSAGE SENT</div>
</div>
</form>