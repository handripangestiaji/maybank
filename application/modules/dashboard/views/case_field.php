<div class="row-fluid">
<?php if($posts){
    //echo $posts[$i]->post_id."-".$posts[$i]->type;
        ?>
           <span class="reply-field-btn-close btn-close pull-right"><i class="icon-remove"></i></span>
           
           <form method="post" class="assign-case" action="<?php echo base_url("case/mycase/CreateCase")?>">
           <input type="hidden" value="<?php echo ($posts[$i]->post_id ? $posts[$i]->post_id : $posts[$i]->social_stream_post_id)?>" name="post_id" />
           <div class="message"></div>
           <div class="pull-left">
               <select name="case_type">
                   <option value="Feedback">Feedback</option>
                   <option value="Enquiry">Enquiry</option>
                   <option value="Complaint">Complaint</option>
               </select>
               <select name="product_type">
                <?php foreach($product_list as $product):?>
                    <option value="<?php echo $product->id?>"><?php echo $product->product_name?></option>
                <?php endforeach?>
               </select>
           </div>
           <br clear="all" />
           <button href="#modalConfirm-<?php echo isset($posts[$i]->social_stream_post_id) ? $posts[$i]->social_stream_post_id : "" ?>" data-toggle="modal"
            class="btn btn-small btn-purple btn-add-related <?php echo $posts[$i]->social_stream_type?>">Add Related Conversation</button>
            
           <input type="hidden" id="relatedCoversation-<?php echo $posts[$i]->social_stream_post_id ?>" name="related_conversation" value="<?php echo $posts[$i]->post_id?>" />
           <br clear="all" />
           <div class="pull-left">
               Assign To:
           </div>
           <div class="pull-right">
               <select name="assign_to">
                <option value=""></option>
                   <?php foreach($user_list as $user):?>
                   <option value="<?php echo $user->user_id?>"><?php echo $user->full_name."($user->email)"?></option>
                   <?php endforeach;?>
               </select>
           </div>
           <br clear="all" />
           <div class="pull-left">
               Email:
           </div>
           <div class="pull-right">
               <input type="text" class="autocomplete email" name="email" id="emailAssign">
           </div>
           <br clear="all" />
           Message :
           <br>
           <textarea placeholder="Compose Message" id="content" name="message" ></textarea>
           <br clear="all" />
           <div class="pull-right">
               <button type="submit" class="btn-purple btn btn-small"><i class="icon-ok-circle icon-large"></i> Assign</button>    
           </div>
           </form>
    </div>

<!-- ==================== MODALS FLOATING BOX ==================== -->
<div id="modalConfirm-<?php echo isset($posts[$i]->social_stream_post_id) ? $posts[$i]->social_stream_post_id : "" ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
    <input type="hidden" value="<?php echo $posts[$i]->post_id?>" name="post_id" />
    
    <?php if($posts[$i]->social_stream_type=="twitter"):?>
        <input type="hidden" value="<?php echo $posts[$i]->twitter_user_id?>" name="twitter_user_id" />
        <input type="hidden" value="<?php echo $posts[$i]->type?>" name="type" />
    <?php else:?>
        <input type="hidden" value="<?php echo $posts[$i]->post_id?>" name="post_id" />
        <input type="hidden" value="<?php echo $posts[$i]->type?>" name="type" />
    <?php endif?>
    <div class="modal-header">
        <button type="button" class="close " data-dismiss="modal" aria-hidden="true"></button>
        <h3>Add Related Conversation</h3>
    </div>
    <div class="modal-body">
        <form class="form-horizontal contentForm">
            <img style="width:56px;margin:20px 0 0 45%;" src="<?php echo base_url()?>/media/img/loader.gif" alt="" class="loader-image">
        </form>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button class="btn btn-primary add-related-conversation" data-dismiss="modal" value="<?php echo $posts[$i]->post_id ?>">Add</button>
    </div>
<?php } ?>
</div>

<!-- ==================== END OF MODALS FLOATING BOX ==================== -->
