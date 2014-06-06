<div id="modal-case-detail-<?php echo $post->post_stream_id ?>" class="modal modalDialog hide fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h3>Case #<?php echo $my_case->case_id; ?></h3>
    </div>
    <div class="modal-body">
        <?php
            echo $my_case->full_name.'<br>'.$my_case->messages;
            ?>
        <h4>Related Conversation</h4>
        <?php
           $related_conversation = $this->case_model->getRelatedConversation(29);
            print_r($related_conversation)
        ?>
    </div>
</div>