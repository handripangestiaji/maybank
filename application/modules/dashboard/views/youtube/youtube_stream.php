<?php //print_r($youtube_post); ?>
<input type="hidden" class="channel-id" value="<?php if(count($youtube_post) > 0) {echo $youtube_post[0]->channel_id;} else {echo $channel_id;} ?>">
<div class="container-fluid" style="height: 95%">
    <!-- ==================== ACTIVITIES MENU ==================== -->
    <div class="floatingBoxMenu">
        <ul class="nav stream_head">
            <li class="active">
                <a href="#" class="youtubevideo">Videos Uploaded
                <?php if(isset($is_search) && count($youtube_post)!=0){echo '<span class="notifyCircle cyan">'.count($youtube_post).'</span>';}?>
                </a>
            </li>
            <li>
                <a href="#" class="youtubecomment">Video Comments
                <?php if(isset($is_search) && count($youtube_comment)!=0){echo '<span class="notifyCircle cyan">'.count($youtube_comment).'</span>';}?>
                </a>
            </li>
        </ul>
    </div>
    <!-- ==================== END OF ACTIVITIES MENU ==================== -->

    <div class="container-fluid center subStream">
        <!-- ==================== ALL ACTIVITIES CONTENT ==================== -->
        <ul class="floatingBoxContainers" id="youtubevideo">
            <?php
            if($youtube_post){
            foreach($youtube_post as $post):
            $youtube_detail = json_decode($post->oauth_secret);
            ?>
            <li>
                    <div class="circleAvatar"><img src="<?=base_url('dashboard/media_stream/SafePhoto?photo=').$youtube_detail->youtube_image?>" alt=""></div>
                    <p class="headLine">
                        <span class="author"><?=$post->channel_name."($youtube_detail->youtube_username)"?></span>
                        <span><?php
                        $created_at = new DateTime($post->created_at, new DateTimeZone($this->session->userdata('timezone')));
                        echo $created_at->format('l, M j, Y h:i A');
                        ?></span>
                        <i class="icon-play-circle moreOptions pull-right"></i>
                    </p>
                    <p class="videos pointer"><a href="http://www.youtube.com/watch?v=<?=$post->video_id?>" target="_blank"><img class='img_attachment' src="<?=base_url('dashboard/media_stream/SafePhoto?photo=').$post->thumbnail_high?>" alt="" /></a>
                    <!--iframe title="YouTube video player" class="youtube-player" style="display: none" type="text/html" 
                        width="" height="" src="http://www.youtube.com/embed/<?=$post->video_id?>"
                        frameborder="0" allowFullScreen></iframe-->
                    </p>
                    <p style="font-size:20px"><?=$post->title?></p>
                    <p><?php echo RemoveUrlWithin($post->description) ?></p>
                    <!--p><button type="button" class="btn btn-primary btn-mini">LIKE</button></p-->
                    <p><a data-toggle="modal" role="button" href="#modalDialog"><i class="icon-eye-open"></i> <?=$post->comment_count?> Engagement</a> |
                    <a data-toggle="modal" role="button" href="#modalDialog"><?=$post->view_count?> views</a> |
                    <i class="icon-thumbs-up"></i> <?=$post->like_count?>&nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-thumbs-down"></i> <?=$post->rating_count - $post->like_count?></p>
                    <div class="reply filled hide">
                        <form class="contentForm">
                            <div class="controlButton pull-right"><i class="icon-remove-sign hide-form"></i></div>
                            <textarea style="width: 95%;" rows="9" id="mailContent"></textarea>
                            <button style="clear: both;" type="submit" class="btn btn-primary">Send</button>
                        </form>
                    </div>
                 </li>
            <?php endforeach;
            }
            else{
                $this->load->view('dashboard/no_display');
            }
            ?>
            <?php if((count($youtube_post) > 0) && (!isset($is_search))): ?>
                <div class="filled" style="text-align: center;">
                    <button class="btn btn-info"><i class="icon-chevron-down"></i> <span>LOAD MORE</span></button></div>
            <?php endif;?>
        </ul>
        
       
        <!-- ==================== END OF ALL ACTIVITIES CONTENT ==================== -->

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


    </div>
</div>
