<?php 

/**
 * @author fitrazh
 * @copyright 2014
 */
 if($caseMsg){
 ?><?php //print_r($caseMsg); ?>
            <div id="caseItem-<?php echo $isMyCase[count($isMyCase)-1]->case_id; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                <input type="hidden" value="<?php //echo $isMyCase->case_id; ?>" name="post_id" />
                <div class="modal-header">
                    <button type="button" class="close " data-dismiss="modal" aria-hidden="true"></button>
                    <h3>Case #<?php echo $caseMsg->case_id ?>:</h3>
                </div>
                <div class="modal-body">
                    <b>Case From:</b><?php echo $caseMsg->send_by;?><br />
                    <b>Message :</b><?php echo $caseMsg->messages;?>
                    <form class="form-horizontal contentForm">
                    <b>Related Conversation:</b>
                        <img style="width:56px;margin:20px 0 0 45%;" src="<?php echo base_url()?>/media/img/loader.gif" alt="" class="loader-image">
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                    <button class="btn btn-primary add-related-conversation" data-dismiss="modal" value="">Add</button>
                </div>
            </div>
<?php } ?>