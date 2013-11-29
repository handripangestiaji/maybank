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
           <button class="btn btn-small btn-purple btn-add-related">Add Related Conversation</button>
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