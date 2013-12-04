<div class="row-fluid">
        <span class="reply-field-btn-close btn-close pull-right"><i class="icon-remove"></i></span>
        
        <form method="post" class="assign_case" action="<?=base_url("case/mycase/CreateCase")?>">
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
        <br clear="all" />
        <button class="btn btn-small btn-purple btn-add-related">Add Related Conversation</button>
        <input type="hidden" name="relatedConversation" />
        <br clear="all" />
        <div class="pull-left">
            Assign To:
        </div>
        <div class="pull-right">
            <select  name="assign_to">
             <option value=""></option>
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