<?php
//print_r($youtube_post);
$timezone=new DateTimeZone($this->session->userdata('timezone'));
?>
<input type="hidden" class="channel-id" value="<?php if(count($youtube_post) > 0) {echo $youtube_post[0]->channel_id;} else {echo $channel_id;} ?>">
<div class="container-fluid" style="height: 95%">
    <!-- ==================== ACTIVITIES MENU ==================== -->
    <div class="floatingBoxMenu">
        <ul class="nav stream_head">
            <li class="active">
                <a href="#" class="youtubevideo">Video Post
                <?php if(isset($is_search) && count($youtube_post)!=0){echo '<span class="notifyCircle cyan">'.count($youtube_post).'</span>';}?>
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
                <input type="hidden" class="postId" value="<?php echo $post->social_stream_post_id; ?>" />
                <input type="hidden" name="videoId" class="videoId" value="<?php echo $post->video_id; ?>" />
                <input type="hidden" class="channelId" value="<?php echo $post->channel_id; ?>" />
                <div class="circleAvatar"><img src="<?=base_url('dashboard/media_stream/SafePhoto?photo=').$youtube_detail->youtube_image?>" alt=""></div>
                <div class="read-mark <?php echo $post->is_read==0 ? 'redText' : 'greyText'?>"><i class="icon-bookmark icon-large"></i></div>
                <br />
                <p class="headLine">
                    <span class="author"><?=$post->channel_name."($youtube_detail->youtube_username)"?></span>
                    <i class="icon-circle"></i>
                    <span>video post</span>
                    <i class="icon-circle"></i>
                    <span>
                    <?php
                        $created_at = new DateTime($post->created_at, new DateTimeZone($this->session->userdata('timezone')));
                        echo $created_at->format('l, M j, Y h:i A');
                    ?>
                    </span>
                </p>
                <p style="font-size:14px; font-weight: bold;"><?=$post->title?></p>
                <p class="videos pointer"><a href="http://www.youtube.com/watch?v=<?=$post->video_id?>" target="_blank"><img class='img_attachment' src="<?=base_url('dashboard/media_stream/SafePhoto?photo=').$post->thumbnail_high?>" alt="" /></a>
                <!--iframe title="YouTube video player" class="youtube-player" style="display: none" type="text/html" 
                    width="" height="" src="http://www.youtube.com/embed/<?=$post->video_id?>"
                    frameborder="0" allowFullScreen></iframe-->
                </p>
                <p><?php echo RemoveUrlWithin($post->description) ?></p>
                <!--p><button type="button" class="btn btn-primary btn-mini">LIKE</button></p-->
                <p style="background-color: red; color: white; padding: 4px;">
                    Share URL
                    <span style="background-color: white; color: black; padding: 2px;">   http://youtu.be/<?php echo $post->video_id; ?>   </span>
                </p>
                
                <p class="indicator">
                <?php if(count($post->case) > 0):?>
                    <button type="button" href="#caseNotification" data-toggle="modal"
                        class="indicator-case twitter-case-related btn <?=$post->case[0]->status == "pending" ? "btn-purple" : "btn-inverse"?> btn-mini "
                        value="<?php echo $post->case[0]->case_id?>">Case #<?php echo $post->case[0]->case_id?>
                        <?php
                        if($post->case[0]->status == "pending"){
                            echo isset($post->case[0]->assign_to->display_name) ? ' Assign to:'.$post->case[0]->assign_to->display_name : '';
                            $created_at = new DateTime($post->case[0]->created_at.' UTC', $timezone);
                            $created_at->setTimezone($timezone);
                            echo ' '.$created_at->format("d-M-y h:i A");
                        }
                        else{
                            echo isset($post->case[0]->solved_by->display_name) ? ' Resolved By:'.$post->case[0]->solved_by->display_name : '';
                            $solved_at = new DateTime($post->case[0]->solved_at.' UTC', $timezone);
                            $solved_at->setTimezone($timezone);
                            echo ' '.$solved_at->format("d-M-y h:i A");
                        }
                        ?>
                        <input type="hidden" class="pointer-case" value="<?=$post->case[0]->case_id?>" />
                    </button>
                    
                    
                <?php endif?>
                <?php if(count($post->reply_post) > 0):?>
                    <button type="button" class="btn btn-inverse btn-mini" value="<?php echo $post->reply_post[0]->response_post_id?>">
                    
                    <?php
                    
                    $reply_date = new DateTime($post->reply_post[count($post->reply_post) - 1]->created_at.' Europe/London');
                    $reply_date->setTimezone($timezone);
                    echo "Replied by: ".$post->reply_post[count($post->reply_post) - 1]->display_name." ".$reply_date->format("d-M-y h:i A") ?>
                    </button>
                <?php endif?>
                <?php if(count($post->reply_post) == 0 && count($post->case) == 0):?>
                    <button type="button" class="btn btn-warning btn-mini no-cursor">OPEN</button>
                <?php endif?>
               
                
                <?php /*if ($post->retweeted==1) { ?>
                    <button type="button" class="btn btn-success btn-mini"><i class="icon-retweet"></i></button>
                <?php } ?>    
                <?php if ($post->favorited=='1') { ?>
                    <button type="button" class="btn btn-inverse btn-mini"><i class="icon-star">&nbsp;</i></button>
                <?php }
                    $filterm["b.in_reply_to = "] = $post->social_stream_post_id.' ';
                    $filterm['b.type'] = "user_timeline";
                    $comment=$this->twitter_model->ReadTwitterData($filterm, 3);
                */?>
                </p>
                
                <p>
                    <a role="button" class="btn-engagement" item="youtube"><i class="icon-eye-open"></i> <?=$post->comment_count?> Engagements</a> |
                    <span class="cyanText"><?=$post->view_count?> views</span> | 
                    <i class="icon-thumbs-up"></i> <?=$post->like_count?>&nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-thumbs-down"></i> <?=$post->rating_count - $post->like_count?></p>
                </p>
                
                <!-- ENGAGEMENT -->    
                <div class="engagement hide">
                    <div class="engagement-header">
                        <span class="engagement-btn-close btn-close pull-right">Close <i class="icon-remove-sign"></i></span>
                    </div>
                    <br/>
                    <div class="engagement-list">
                    <?php
                    $timezone = new DateTimeZone($this->session->userdata('timezone'));
                    for($j=0; $j<count($post->comments); $j++):
                    ?>    
                    <div class="engagement-body" <?php if($post->comments[$j]->social_stream_post_id != '0'){ ?> style="padding-left: 0px;" <?php } ?>>
                        <span class="engagement-btn-hide-show btn-close pull-right"><i class="icon-caret-down"></i></span>    
                        <p class="headLine">
                            <span class="author"><?php echo $post->comments[$j]->name; ?></span>
                            <i class="icon-circle"></i>
                            <span>posted a <span class="cyanText">comment</span></span>
                            <i class="icon-circle"></i>
                            <span><?php 
                            $date=new DateTime($post->comments[$j]->created_at.' UTC');
                            $date->setTimezone($timezone);
                            echo $date->format('l, M j, Y h:i A');
                            ?>
                            </span></p>
                            
                            <div class="engagement-comment">
                                <p><?php echo CreateUrlFromText($post->comments[$j]->text); ?></p>
                                    <?php
                                        $loop = true;
                                            $last_reply = null;
                                            /*
                                            for($x=$j+1;$x<count($post->comments);$x++){
                                                    if($post->comments[$x]->social_stream_post_id == 0){
                                                            break;
                                                    }
                                                    if($post->comments[$x]->page_reply_id){
                                                            $last_reply = $comment[$x];
                                                    }
                                            }
                                            */
                                    ?>
                                    <p><?php //echo $this->load->view('facebook/facebook_reply_indicator', array('comment' => $comment[$j],'last_reply' => $last_reply)) ?></p>
                                <p>
                                </p></h4>
                                
                                <div class="fb-reply-engagement-field reply-field hide">
                                </div>
                                 <div class="case-field hide">
                                </div>                
                            </div>
                        </div>
                    <?php endfor?>
                    </div>
                    <!-- ==================== CONDENSED TABLE HEADLINE ==================== -->
                    <?php $unique_id = uniqid(); ?>
                    <div href='#modal-action-log-<?php echo $post->post_stream_id.$unique_id ?>' data-toggle='modal' class="containerHeadline specialToggleTable">
                        <i class="icon-table"></i><h2>Action Log</h2>
                    </div>
                    <!-- ==================== END OF CONDENSED TABLE HEADLINE ==================== -->
            
                    <!-- ==================== CONDENSED TABLE FLOATING BOX ==================== -->
                    <?php
                        if(IsRoleFriendlyNameExist($this->user_role, array('Social Stream_Channel_General_Function_Own_Country_View',
                                                                      'Social Stream_Channel_General_Function_All_Country_View')))
                        {
                            $data_loaded['post'] = $post;
                            $data_loaded['unique_id'] = $unique_id;
                            $this->load->view('dashboard/action_taken', $data_loaded);
                        }
                    ?>
                    <!-- ==================== END OF CONDENSED TABLE FLOATING BOX ==================== --> 
                </div>
                <!-- END ENGAGEMENT -->
                
                <h4 class="filled">
                    <div class="pull-right">
                        <button type="button" class="btn btn-primary btn-reply" value="reply_youtube"><i class="icon-mail-reply"></i></button>
                        <?php
                        if(count($post->case) == 0){
                            $case = '<button type="button" item="youtube" class="btn btn-danger btn-case" name="action"  value="youtube"><i class="icon-plus"></i> <span>CASE</span></button> ';
                        }
                        else{
                            if($post->case[0]->status == 'pending'){
                                $case = 
                                '<button type="button"  class="btn btn-purple btn-resolve" name="action" value="'.
                                $post->case[0]->case_id.'"><i class="icon-check"></i> <span>RESOLVE</span></button>
                                <button type="button" class="btn btn-danger btn-case" name="action" item="youtube" value="reassign"><i class="icon-plus"></i>
                                <span>ReAssign</span></button>';
                            }
                            else{
                                $case = '<button type="button" item="youtube" class="btn btn-danger btn-case" name="action" value="new_case"><i class="icon-plus"></i> <span>Case</span></button> ';
                            }
                        }
                        print_r($case);
                        ?>
                    </div>
                    <br clear="all" />
                </h4>
                
                <p>
                <div class="reply-field hide">
                </div>
    
                <!-- CASE -->
                <div class="case-field hide">
                    <?php //echo $this->load->view('dashboard2/case_field'); ?>
                </div>
                <!-- END CASE -->
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
    </div>
</div>
