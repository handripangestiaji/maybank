
        <!-- ==================== RECENT COMMENTS CONTENT ==================== -->
        <ul class="floatingBoxContainers" id="youtubecomment" style="display:none">
            <?php
            if($youtube_comment){
            foreach($youtube_comment as $comment): ?>
            <li>
                <div class="circleAvatar"><img src="<?=base_url('dashboard/media_stream/SafePhoto?photo=')."https://plus.google.com/s2/photos/profile/".$comment->google_user_id?>?sz=100" alt=""></div>
                <p class="headLine">
                    <span class="author"><?=$comment->name?></span>
                    <i class="icon-circle"></i>
                    <span>posted a <span class="cyanText"><?=$comment->title?></span></span>
                    <i class="icon-circle"></i>
                    <span><?php
                    $created_at = new DateTime($comment->created_at, new DateTimeZone($this->config->item('timezone')));
                    echo $created_at->format("l, M j, Y h:i A");
                    ?></span>
                    <i class="icon-play-circle moreOptions pull-right"></i>
                </p>
                <p>"<?php echo RemoveUrlWithin($comment->text); ?>"</p>
            </li>
           <?php endforeach;
            }
            else{
                $this->load->view('dashboard/no_display');
            }
            ?>
            <?php if((count($youtube_comment) > 0) && (!isset($is_search))): ?>
                <div class="filled" style="text-align: center;"><button class="btn btn-info"><i class="icon-chevron-down"></i> <span>LOAD MORE</span></button></div>
            <?php endif;?>
        </ul>
        <!-- ==================== END OF RECENT COMMENTS CONTENT ==================== -->