<div class="row-fluid">
           <span class="reply-field-btn-close btn-close pull-right"><i class="icon-remove"></i></span>
           CASE ID      : #012345
           <form method="post" class="" action="<?=base_url("case/mycase/CreateCase")?>">
           <div class="pull-left">
               <select style="width: 130px;">
                   <option value="Feedback">Feedback</option>
                   <option value="Enquiry">Enquiry</option>
                   <option value="Complaint">Complaint</option>
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
           <br clear="all" />
           <button href="#modalConfirm-<?php echo $posts[$i]->post_id ?>" data-toggle="modal" class="btn btn-small btn-purple btn-add-related">Add Related Conversation</button>
                        
           <input type="hidden" name="relatedConversation" />
           <br clear="all" />
           <div class="pull-left">
               Assign To:
           </div>
           <div class="pull-right">
               <select name="assignTo">
                   <?php foreach($user_list as $user):?>
                   <option value="<?=$user->user_id?>"><?=$user->full_name."($user->email)"?></option>
                   <?php endforeach;?>
               </select>
           </div>
           <br clear="all" />
           <div class="pull-left">
               Email:
           </div>
           <div class="pull-right">
               <input type="text">
           </div>
           <br clear="all" />
           Message :
           <br>
           <textarea placeholder="Compose Message" id="content" name="content" ></textarea>
           <br clear="all" />
           <div class="pull-right">
               <button type="submit" class="btn-purple btn btn-small"><i class="icon-ok-circle icon-large"></i> Assign</button>    
           </div>
           </form>
    </div>

<!-- ==================== MODALS FLOATING BOX ==================== -->
<div id="modalConfirm-<?php echo $posts[$i]->post_id ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h3>Add Related Conversation</h3>
    </div>
    <div class="modal-body">
        <form class="form-horizontal contentForm">
            <div class="related-conversation-body">
                      <span class="related-conversation-btn-hide-show btn-close pull-right"><i class="icon-caret-down"></i></span>    
                      <p class="headLine">
                                 <input type="checkbox" class="related-conversation-check">
                          <span class="author">John Doe</span>
                          <i class="icon-circle"></i>
                          <span>posted a <span class="cyanText">comment</span></span>
                          <i class="icon-circle"></i>
                          <span>2 hours ago</span>
                          <i class="icon-play-circle moreOptions pull-right"></i>
                      </p>
                      <div>
                          <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                          <?php if($posts[$i]->type == 'facebook'){ ?>
                          <p><button type="button" class="btn btn-warning btn-mini">OPEN</button><button class="btn btn-primary btn-mini" style="margin-left: 5px;">LIKE</button></p>
                          <?php
                                 }
                                 else{?>
                                 <p><button type="button" class="btn btn-warning btn-mini">OPEN</button><button class="btn btn-primary btn-mini" style="margin-left: 5px;">RE-TWEET</button></p>
                      <?php
                                 }?>
                      </div>
                  </div>
           <div class="related-conversation-body">
                      <span class="related-conversation-btn-hide-show btn-close pull-right"><i class="icon-caret-down"></i></span>    
                      <p class="headLine">
                                 <input type="checkbox" class="related-conversation-check">
                          <span class="author">John Doe</span>
                          <i class="icon-circle"></i>
                          <span>posted a <span class="cyanText">comment</span></span>
                          <i class="icon-circle"></i>
                          <span>2 hours ago</span>
                          <i class="icon-play-circle moreOptions pull-right"></i>
                      </p>
                      <div>
                          <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                          <?php if($posts[$i]->type == 'facebook'){ ?>
                          <p><button type="button" class="btn btn-warning btn-mini">OPEN</button><button class="btn btn-primary btn-mini" style="margin-left: 5px;">LIKE</button></p>
                          <?php
                                 }
                                 else{?>
                                 <p><button type="button" class="btn btn-warning btn-mini">OPEN</button><button class="btn btn-primary btn-mini" style="margin-left: 5px;">RE-TWEET</button></p>
                      <?php
                                 }?>
                      </div>
                  </div>
        </form>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button class="btn btn-primary">Add</button>
    </div>
</div>
<!-- ==================== END OF MODALS FLOATING BOX ==================== -->