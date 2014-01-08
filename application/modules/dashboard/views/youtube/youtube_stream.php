<div class="container-fluid">
    <!-- ==================== ACTIVITIES MENU ==================== -->
    <div class="floatingBoxMenu">
        <ul class="nav stream_head">
            <li class="active"><a href="#" class="youtubevideo">Videos Uploaded</a></li>
            <li><a href="#" class="youtubecomment">Video Comments</a></li>
        </ul>
    </div>
    <!-- ==================== END OF ACTIVITIES MENU ==================== -->

    <div class="container-fluid">
        <!-- ==================== ALL ACTIVITIES CONTENT ==================== -->
        <ul class="floatingBoxContainers" id="youtubevideo">
            <?php foreach($youtube_post as $post): ?>
            <li>
                    <div class="circleAvatar"><img src="https://plus.google.com/s2/photos/profile/<?=$post->channel_name?>?sz=100" alt=""></div>
                    <p class="headLine">
                        <span class="author">John Doe</span>
                        <i class="icon-circle"></i>
                        <span>Video</span>
                        <i class="icon-circle"></i>
                        <span><?php
                        $created_at = new DateTime($post->created_at, new DateTimeZone($this->config->item('timezone')));
                        echo $created_at->format('l, M j, Y h:i A');
                        ?></span>
                        <i class="icon-play-circle moreOptions pull-right"></i>
                    </p>
                    <p class="video pointer"><img src="<?=$post->thumbnail_high?>" alt="" />
                    <iframe title="YouTube video player" class="youtube-player" style="display: none" type="text/html" 
                        width="" height="" src="http://www.youtube.com/embed/<?=$post->video_id?>"
                        frameborder="0" allowFullScreen></iframe>
                    </p>
                    <p style="font-size:20px"><?=$post->title?></p>
                    <p><?=$post->description?></p>
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
                    <div class="assign filled hide">
                        <form class="contentForm">
                             <div class="controlButton pull-right"><i class="icon-remove-sign hide-form"></i></div>
                             <div class="control-group">
                                <label class="control-label">Assign To</label>
                                <div class="controls">
                                    <select id="uniqueSelect">
                                        <option id="opt1" value="opt1">John Doe</option>
                                        <option id="opt2" value="opt2">May Bankette</option>
                                        <option id="opt3" value="opt3">Jane Doyen</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group last">
                                <label class="control-label">Remarks <span class="label label-important">Not Public</span></label>
                                <div class="controls">
                                  <textarea class="span10"></textarea>
                                </div>
                            </div>
                            <button style="clear: both;" type="submit" class="btn btn-primary">Send</button>
                        </form>
                    </div>
                </li>
            <?php endforeach?>
             <div class="filled" style="text-align: center;"><button class="btn btn-info"><i class="icon-chevron-down"></i> LOAD MORE</button></div>
        </ul>
        
       
        <!-- ==================== END OF ALL ACTIVITIES CONTENT ==================== -->

        <!-- ==================== RECENT COMMENTS CONTENT ==================== -->
        <ul class="floatingBoxContainers" id="youtubecomment" style="display:none">
            <li>
                <div class="circleAvatar"><img src="img/zoidberg-avatar.jpg" alt=""></div>
                <p class="headLine">
                    <span class="author">George McCain</span>
                    <i class="icon-circle"></i>
                    <span>posted a <span class="cyanText">comment</span></span>
                    <i class="icon-circle"></i>
                    <span>5 days ago</span>
                    <i class="icon-play-circle moreOptions pull-right"></i>
                </p>
                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
            </li>
            <li>
                <div class="circleAvatar"><img src="img/homer-avatar.jpg" alt=""></div>
                <p class="headLine">
                    <span class="author">John Doe</span>
                    <i class="icon-circle"></i>
                    <span>posted a <span class="cyanText">comment</span></span>
                    <i class="icon-circle"></i>
                    <span>10 days ago</span>
                    <i class="icon-play-circle moreOptions pull-right"></i>
                </p>
                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
            </li>
        </ul>
        <!-- ==================== END OF RECENT COMMENTS CONTENT ==================== -->


    </div>
</div>
