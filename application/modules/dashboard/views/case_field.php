<div class="row-fluid">
<?php 
if($posts){
//print_r($posts_comment[$i]);
 if(isset($posts[$i]->post_id)){
    $post_id=$posts[$i]->post_id;   
 }
 if(isset($posts_comment[$i]->comment_post_id)){
    $post_id=$posts_comment[$i]->comment_post_id;
 }
 //print_r($post_id);
 
?>
           <span class="reply-field-btn-close btn-close pull-right"><i class="icon-remove"></i></span>
           <form method="post" class="assign-case" action="<?php echo base_url("case/mycase/CreateCase")?>">
           <input type="hidden" value="<?php echo $post_id; ?>" name="post_id" />
           <input type="hidden" value="new_case" name="type" />
           <div class="message"></div>
           <div class="pull-left">
               <select name="case_type" style="width: 130px;">
                   <option value="Feedback">Feedback</option>
                   <option value="Enquiry">Enquiry</option>
                   <option value="Complaint">Complaint</option>
               </select>
               <select name="product_type" style="width: 130px;">
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
           <br clear="all" />
           <button href="#modalConfirm-<?php echo isset($posts[$i]->social_stream_post_id) ? $posts[$i]->social_stream_post_id : "" ?>" data-toggle="modal"
            class="btn btn-small btn-purple btn-add-related <?php echo $posts[$i]->social_stream_type?>">Add Related Conversation</button>
            
           <input type="hidden" id="relatedCoversation-<?php echo $posts[$i]->social_stream_post_id ?>" name="related_conversation" value="<?php echo $posts[$i]->social_stream_post_id?>" />
           <br clear="all" />
           <div class="pull-left" style="width:30%;">
               Assign To:
           </div>
           <div class="pull-left" style="width:70%;">
               <select name="assign_to" <!--multiple="multiple"!-->>
                      <option value='' id="caseUser<?=$posts[$i]->social_stream_post_id?>">-- Select User --</option>
                      <?php
                      $group_name = null;
                      $userIncrement = 0;
                      if(is_array($user_list)){
                        for($userIncrement=0;$userIncrement<count($user_list);$userIncrement++){
                                   if(IsRoleFriendlyNameExist($user_list[$userIncrement]->role_detail, 'Social Stream_Current_Resolve_Case')){
                                              if($user_list[$userIncrement]->group_name!=$group_name){
                                                         echo '<optgroup label="'.$user_list[$userIncrement]->group_name.'"></optgroup>';           
                                              }
                                              if( $this->session->userdata('user_id') != $user_list[$userIncrement]->user_id){
                                                         echo '<option value="'.$user_list[$userIncrement]->user_id.'">&nbsp;&nbsp;&nbsp;&nbsp;'.$user_list[$userIncrement]->full_name.'</option>';                                 
                                              }
                                   }
                                   $group_name = $user_list[$userIncrement]->group_name;           
                        }
                      }
                      else{
                            echo '<optgroup label="'.$user_list->group_name.'"></optgroup>';           
                            echo '<option value="'.$user_list->user_id.'">'.$user_list->full_name.'</option>';                                 
                      }
                      ?>
               </select>
           </div>
           <br clear="all" />
           <div class="pull-left" style="width:30%;">
               Email:
           </div>
           <div class="pull-left" style="width:70%;">
               <input type="text" class="email" name="email" />
           </div>
           <br clear="all" />
           Message :
           <br>
           <textarea placeholder="Compose Message" id="content" name="message" ></textarea>
           <br clear="all" />
           <div class="pull-right">

               <button type="submit" class="btn-purple btn btn-small" value="<?php if(isset($case_type)){echo $case_type='reassign';}?>"><i class="icon-ok-circle icon-large"></i> Assign</button>    
           </div>
           </form>
    </div>

<!-- ==================== MODALS FLOATING BOX ==================== -->
<div id="modalConfirm-<?php echo isset($posts[$i]->social_stream_post_id) ? $posts[$i]->social_stream_post_id : "" ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
    <input type="hidden" value="<?php echo $posts[$i]->post_id?>" name="post_id" />
    <?php if($posts[$i]->social_stream_type=="twitter" || $posts[$i]->social_stream_type=="twitter_dm"):?>
        <input type="hidden" value="<?php echo $posts[$i]->twitter_user_id?>" name="twitter_user_id" />
        <input type="hidden" value="<?php echo $posts[$i]->type?>" name="type" />
    <?php else:?>
        <input type="hidden" value="<?php echo $posts[$i]->social_stream_post_id?>" name="post_id" />
        <input type="hidden" value="<?php echo $posts[$i]->type?>" name="type_facebook" />
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
