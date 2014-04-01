<?php
$timezone = new DateTimeZone($this->session->userdata('timezone'));
?>
<div id="caseItem<?=$caseMsg->case_id; ?>" class="modal hide related-conversations" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
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
            <h4>Original Post</h4>
            <div class="related-conversation-view"></div>
            <h4>Related Conversation</h4>
            <?php $case_conversation = $this->case_model->TwitterRelatedConversation($caseMsg->case_id);
            ?>
            <ol style="margin: 0;padding: 0;">
                <?php foreach($case_conversation as $conversation): ?>
                <?php
                $html = $conversation->twitter_data[0]->text;
                
                $html =  linkify(html_entity_decode($html), true, true);
                
                ?>
                <li style="display: block;"><p style="padding: 9px 2px;margin: 2px 5px;">
                    <!--span class="author">@<?=$conversation->twitter_data[0]->screen_name?>: </span-->
                    <span class="text"><?=$html?></span> <span> at </span>
                    <span class="created-time" style="font-size:10px;color: #666;"><?php $created_at_twitter = new DateTime($conversation->twitter_data[0]->created_at.' Europe/London', $timezone);
                echo $created_at_twitter->format("d-F-y h:i A")
                ?></span>
                </p>     
                </li>
                <?php endforeach;?>
            </ol>
            
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary add-related-conversation" data-dismiss="modal" value="">Close</button>
        </div>
    </div>