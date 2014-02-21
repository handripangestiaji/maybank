<?php 

/**
 * @author fitrazh
 * @copyright 2014
 */
 //print_r($isMyCase);
 ?>
            <div id="caseItem-<?php echo $isMyCase[count($isMyCase)-1]->case_id; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                <input type="hidden" value="<?php //echo $isMyCase->case_id; ?>" name="post_id" />
                <div class="modal-header">
                    <button type="button" class="close " data-dismiss="modal" aria-hidden="true"></button>
                    <h3>Related Conversation is Assign To You:</h3>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal contentForm">
                        <img style="width:56px;margin:20px 0 0 45%;" src="<?php echo base_url()?>/media/img/loader.gif" alt="" class="loader-image">
                    </form>
                </div>


<?php /*
    if(count($isMyCase[0]->case)!=0){
        for($i=0; $i<count($isMyCase[0]->case); $i++){
//            echo count($isMyCase);
//             echo "<pre>";
//            print_r($isMyCase[0]);
//            echo "</pre>";
        ?>
            <!--div class=""> 
            <span class="related-conversation-btn-hide-show btn-close pull-right"><i class="icon-caret-down"></i></span>
            <p class="headLine">
                <span class="author"><?php echo $isMyCase[0]->case[$i]->name;?></span>
                <i class="icon-circle"></i>
                <span>posted a <span class="cyanText"></span></span>
                <i class="icon-circle"></i>
                <span class="UTCTimestamp"><?php echo $isMyCase[0]->case[$i]->created_at;?></span>
                <i class="icon-play-circle moreOptions pull-right"></i>
            </p>
            <div>
                <p><?php echo $isMyCase[0]->case[$i]->comment_content; ?></p>
            </div>
            </div-->

        
        <?php
        } 
    }else{ ?>
                        <img style="width:56px;margin:20px 0 0 45%;" src="<?php echo base_url()?>/media/img/loader.gif" alt="" class="loader-image" accesskey="" />
<?php } */ ?>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                    <button class="btn btn-primary add-related-conversation" data-dismiss="modal" value="">Add</button>
                </div>
            </div>
