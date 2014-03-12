<?php
$timezone = new DateTimeZone($this->session->userdata('timezone'));
?>
<div id="caseItem-<?=$caseMsg->case_id; ?>" class="modal hide related-conversation" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <input type="hidden" value="<?php //echo $isMyCase->case_id; ?>" name="post_id" />
        <div class="modal-header">
            <button type="button" class="close " data-dismiss="modal" aria-hidden="true"></button>
            <h3>Case #<?php echo $caseMsg->case_id ?></h3>
        </div>
        <div class="modal-body">
            <table>
                <tr><td>Assigned By</td><td>:</td><td><?php echo $caseMsg->created_by->full_name."(".$caseMsg->created_by->email.")" ;?></td></tr>
                <tr><td>Message</td><td>:</td><td><?php echo $caseMsg->messages;?></td></tr>
                <tr><td>Status</td><td>:</td><td><?php echo $caseMsg->status;?></td></tr>
                <?php if($caseMsg->status == 'solved'):?>
                    <tr><td>Solved By</td><td>:</td><td><?php echo $caseMsg->solved_by->full_name."(".$caseMsg->created_by->email.")";?></td></tr>
                    <tr><td>Solved message</td><td>:</td><td><?php echo $caseMsg->solved_message;?></td></tr>
                <?php endif;?>
            </table>
            
            <h4>Related Conversation</h4>
            <?php
                $case_conversation = $this->case_model->FacebookRelatedConversation( $caseMsg->case_id);
            ?>
            <ol style="margin: 0;padding: 0;">
                <?php foreach($case_conversation as $conversation):
                    echo "<pre>";print_r($conversation);echo "</pre>";
                ?>
               
                <?php endforeach;?>
            </ol>
            
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary add-related-conversation" data-dismiss="modal" value="">Close</button>
        </div>
    </div>