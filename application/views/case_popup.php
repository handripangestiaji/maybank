<div id="caseNotification" class="modal modalDialog hide fade" tabindex="1" role="dialog" aria-hidden="true" style="display: none;z-index: 10099" >
    <div class="modal-header" style="padding-bottom: 0px;">
        <h3 style=" float: left;width: 200px;">Case #<span class="case-id"></span></h3>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        
        <br clear="all" />
    </div>
    <div class="modal-body" style="padding: 10px 0px 10px 15px;">
        <h4 style="text-transform: capitalize;" class="type-post"></h4>
        
        <table>
            <tr><td style="width:20%">Assign By</td><td>:</td><td class="assign-by"></td></tr>
            <tr><td>Date</td><td>:</td><td class="assign-date"></td></tr>
            <tr><td colspan="3" class="assign-message">
                
            </td></tr>
        </table>
        
        <h4>Related Conversation</h4>
        <ol style="margin: 0;padding: 0;" class="related-conversation-list">
        </ol>
        <?php
        $this->load->model('campaign_model');
        $product_list = $this->campaign_model->GetProduct(array('parent_id' => null));
	foreach($product_list as $prod){    
	    $product_child = $this->campaign_model->GetProduct(array('parent_id' => $prod->id));
	    if($product_child){
		$chi = array();
		foreach($product_child as $child){
		    $chi[] = $child;
		}
	        $prod->child = $chi;
	    }
	}
        
        ?>
        <div class="action-reply">
            <div class="reply-field hide">
                <span class="reply-field-btn-close btn-close pull-right"><i class="icon-remove"></i></span>
                <form method="post" class="assign-case" action="<?php echo base_url("case/mycase/CreateCase")?>">
                <input type="hidden" value="" name="post_id" class="post_id" />
                <input type="hidden" value="new_case" name="type" />
                <div class="message"></div>
                <div class="pull-left">
                    <select name="case_type" class="case_type" style="width: 130px;">
                       <option value="">Please Select</option>
                       <option value="Feedback">Feedback</option>
                       <option value="Enquiry">Enquiry</option>
                       <option value="Complaint">Complaint</option>
                       <option value="Report_Abuse">Report Abuse</option>
                    </select>
                    <select name="product_type" class="product_type" style="width: 130px;">
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
                        <?php endforeach;?>
                    </select>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal-footer" style="">
        <?php if(IsRoleFriendlyNameExist($this->user_role, array('Social Stream_Channel_General_Function_All_Country_Reply',
                                                                 'Social Stream_Channel_General_Function_Own_Country_Reply'))):?>
        <button class="btn btn-purple btn-reply" >Reply</button>
        <?php endif;?>
        <?php if(IsRoleFriendlyNameExist($this->user_role, array('Social Stream_Case_Own_Country_AssignReassignResolved',
                                                                 'Social Stream_Case_All_Country_AssignReassignResolved'))):?>
            <button type="button" class="btn btn-orange btn-resolve popup" name="action" value=""><i class="icon-check"></i> <span>RESOLVE</span></button>
            <button type="button" class="btn btn-danger btn-case" name="action" value="reassign"><i class="icon-plus"></i>
                <span>ReAssign</span>
            </button>
        <?php endif;?>
    </div>
</div>