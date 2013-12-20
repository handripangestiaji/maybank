<?php
$total_groups = ceil($countTweets[0]->count_post_id/$this->config->item('item_perpage'));
$timezone=new DateTimeZone($this->config->item('timezone'));
for($i=0;$i<count($senttweets);$i++){
?>
    <li>
        <input type="hidden" class="postId" value="<?php echo $senttweets[$i]->social_stream_post_id; ?>" />
        <div class="circleAvatar"><img src="<?php echo $senttweets[$i]->profile_image_url;?>" alt=""></div>
        <div class="read-mark <?php if($senttweets[$i]->is_read==0){echo 'redText';} else { echo 'greyText'; } ?>"><i class="icon-bookmark icon-large"></i></div>
        <br />
        <p class="headLine">
            <span class="author"><?php echo $senttweets[$i]->screen_name; ?></span>
            <i class="icon-circle"></i>
            <span>Sent Tweets</span>
            <i class="icon-circle"></i>
            <span><?php 
            $date=new DateTime($senttweets[$i]->social_stream_created_at.' Europe/London');
            $date->setTimezone($timezone);
            echo $date->format('l, M j, Y h:i A');
            $entities = json_decode($senttweets[$i]->twitter_entities);?></span>
        </p>
        <p>
            <?php
                $html = html_entity_decode($senttweets[$i]->text);
                foreach($entities->urls as $url){
                    $html = substr($html, 0, $url->indices[0]);
                    $html .= "<a href='$url->expanded_url' target='_blank'>$url->display_url</a>";
                    $html .= substr($senttweets[$i]->text, $url->indices[1]);
                }
                $html =  linkify(html_entity_decode($html), true, false);
                echo $html;
            ?>
        </p>
        <p>
            <?php if(isset($entities->media[0])){
                    echo "<a href='#modal-".$senttweets[$i]->post_id."' data-toggle='modal' ><img src='".$entities->media[0]->media_url_https."' /></a>";
                    echo '<div id="modal-'.$senttweets[$i]->post_id.'" class="attachment-modal modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
                                    <button type="button" class="close " data-dismiss="modal"><i class="icon-remove"></i></button>
                                    <img src="'.$entities->media[0]->media_url_https.'" />
                        </div>';
                    }
            ?>
        </p>
        <p><button type="button" class="btn btn-warning btn-mini">OPEN</button>
        <?php if ($senttweets[$i]->retweeted==1) { ?>
            <button type="button" class="btn btn-inverse btn-mini"><i class="icon-retweet">&nbsp;</i></button>
        <?php } ?>    
        <?php if ($senttweets[$i]->favorited=='1') { ?>
            <button type="button" class="btn btn-inverse btn-mini"><i class="icon-star">&nbsp;</i></button>
        <?php } ?></p>
        
        <p>
            <a role="button" class="btn-engagement"><i class="icon-eye-open"></i> Engagement</a> |
            <a data-toggle="modal" role="button" href="#modaltweet<?php echo $i; ?>" ><i class="icon-retweet greyText"></i><?php if($senttweets[$i]->retweet_count>0)echo $senttweets[$i]->retweet_count; ?> re-tweets</a> 
        </p>
        
        
        <!-- ENGAGEMENT -->    
        <div class="engagement hide">
        </div>
        <!-- END ENGAGEMENT -->
        
        <h4 class="filled">
            <a role="button" class='destroy_status'><i class="icon-trash greyText"></i></a>
            <div class="pull-right">
                    <!--form class="contentForm" action="<?php //echo base_url('index.php/dashboard/socialmedia/twitteraction');?>" method="post">
                    <button type="button" class="retweet btn btn-primary"><i class="icon-retweet"></i></button-->
                    <button type="button" class="favorit btn btn-primary"><i class="icon-star"></i></button>
                    
                    <?php /*if($senttweets[$i]->following=='1'){ ?>
                            <button type="button" class="unfollow btn"><i class="icon-user"></i></button>
                    <?php }else{ ?>
                            <button type="button" class="follow btn btn-primary" value="follow"><i class="icon-user"></i></button>
                    <?php } */?>
                    <!--button type="button" class="btn btn-danger btn-case" name="action" value="case"><i class="icon-plus"></i>CASE</button-->
                    <input type="hidden" class="str_id" value="<?php echo $senttweets[$i]->post_stream_id; ?>" />
                    <input type="hidden" class="userid" value="<?php echo $senttweets[$i]->twitter_user_id; ?>" />
                    <input type="hidden" class="followid" value="<?php echo $senttweets[$i]->twitter_user_id; ?>" />
                   <!--/form-->    
            </div>
             <!--div class="actionreport compose-post-status green hide">Message Post</div-->
            <br clear="all" />
        </h4>
        
        <!-- REPLY -->  
        
    </li>
<?php } ?>
<?php if(count($senttweets) > 0):?>
 <div class="filled" style="text-align: center;"><button class="loadmore btn btn-info" value="sendmessage"><input type="hidden"  class="channel_id" value="<?php echo $senttweets[0]->channel_id?>"/><input type="hidden" class="channel_id" value="<?php echo $channel_id?>" /><i class="icon-chevron-down"></i> LOAD MORE</button></div>
<?php endif?>