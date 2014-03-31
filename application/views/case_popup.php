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
        <br clear="all" />
        <div class="action-reply">
            <div class="reply-field hide" style="width: 90%;">
                <span class="reply-field-btn-close btn-close pull-right"><i class="icon-remove"></i></span>
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
                <textarea class='replaycontent' placeholder="Compose Message"></textarea>
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
                <div class="left">
                    <div class="left">
                        <i class="icon-tag icon-large"></i>    
                    </div>
                    <div class="left">
                        <ul id="compose-tags-reply" style="width: 200px;"></ul>        
                    </div>
                    <br clear="all" />
                </div>    
                <br clear="all" />
                <br />
                <div class="pull-left reply-char-count">
                        <i class="icon-facebook-sign"></i>&nbsp;<span class="reply-fb-char-count">2000</span>
                </div>
                <div class="image-upload">
                    <div class="pull-right reply-open-img">
                        <a href="javascript:void(0);" id="reply-open-img">
                            <i class="icon-camera"></i> 
                        </a>
                    </div>
                    <br clear="all"/>
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
                    <br clear="all" />
                </div>
                
                
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