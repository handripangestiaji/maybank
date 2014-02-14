<?php
$total_groups = ceil($countFeed[0]->count_post_id/$this->config->item('item_perpage'));
$timezone=new DateTimeZone($this->session->userdata('timezone'));
for($i=0;$i<count($homefeed);$i++){
?>
    <li <?php if($homefeed[$i]->is_read==0){echo 'class="unread-post"';} ?> id="post<?=$homefeed[$i]->social_stream_post_id?>">
        <div class="message"></div>
        <input type="hidden" class="postId" value="<?php echo $homefeed[$i]->social_stream_post_id; ?>" />
        <div class="circleAvatar"><img src="<?php echo base_url('dashboard/media_stream/SafePhoto?photo=').$homefeed[$i]->profile_image_url;?>" alt=""></div>
        <div class="read-mark <?php if($homefeed[$i]->is_read==0){echo 'redText';} else { echo 'greyText'; } ?>"><i class="icon-bookmark icon-large"></i></div>
        <br />
        <p class="headLine">
            <span class="author"><?php echo $homefeed[$i]->screen_name; ?></span>
            <i class="icon-circle"></i>
            <span>Home Feed</span>
            <i class="icon-circle"></i>
            <span>
            <?php 
            $date=new DateTime($homefeed[$i]->social_stream_created_at.' Europe/London');
            $date->setTimezone($timezone);
            echo $date->format('l, M j, Y h:i A');
            
            $entities = json_decode($homefeed[$i]->twitter_entities);
            
            ?>
            </span>
          
        </p>
    <p>
    <?php
        $pattern = "/_(?=[^>]*<)/";
        $html = $homefeed[$i]->text;
        foreach($entities->urls as $url){
            $html = substr($html, 0, $url->indices[0]);
            $html .= "<a href='$url->expanded_url' target='_blank'>$url->display_url</a>";
            $html .= substr($homefeed[$i]->text, $url->indices[1] );
        }
        $html =  linkify(html_entity_decode($html), true, false);
        echo $html;
    ?></p>
    <p>
    <?php if(isset($entities->media[0])){
            echo "<a href='#modal-".$homefeed[$i]->social_stream_post_id."' data-toggle='modal' ><img class='img_attachment' src='".base_url('dashboard/media_stream/SafePhoto?photo=').$entities->media[0]->media_url_https."' /></a>";
            echo '<div id="modal-'.$homefeed[$i]->social_stream_post_id.'" class="attachment-modal modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <img src="'.base_url('dashboard/media_stream/SafePhoto?photo=').$entities->media[0]->media_url_https.'" />
                            <button type="button" class="close " data-dismiss="modal"><i class="icon-remove"></i></button>
                </div>';
            }
    ?>
    </p>
    <p>
    <?php if($homefeed[$i]->case_id):?>
        <button type="button" class="btn btn-purple btn-mini" value="<?php echo $homefeed[$i]->case_id?>">CASE ID #<?php echo $homefeed[$i]->case_id.' Assign to '.$homefeed[$i]->case[0]->assign_to->username?></button>
        
        
    <?php endif?>
    <?php if(count($homefeed[$i]->reply_post) > 0):?>
    
        <button type="button" class="btn btn-inverse btn-mini" value="<?php echo $homefeed[$i]->reply_post[0]->response_post_id?>">
            <?php
                 $reply_date = new DateTime($homefeed[$i]->reply_post[count($homefeed[$i]->reply_post) - 1]->created_at);
                $reply_date->setTimezone($timezone);
                echo "Replied by: ".$homefeed[$i]->reply_post[count($homefeed[$i]->reply_post) - 1]->display_name." ".$reply_date->format("d-M-y h:i A") ?>
        </button>
    <?php endif?>
    <?php if(count($homefeed[$i]->reply_post) == 0 && !$homefeed[$i]->case_id):?>
        <button type="button" class="btn btn-warning btn-mini">OPEN</button>
    <?php endif?>
    
    <?php if ($homefeed[$i]->retweeted==1): ?>
        <button type="button" class="btn btn-inverse btn-mini"><i class="icon-retweet"></i></button>
    <?php endif; ?>    
    <?php if ($homefeed[$i]->favorited=='1'): ?>
        <button type="button" class="btn btn-inverse btn-mini"><i class="icon-star">&nbsp;</i></button>
    <?php endif ?></p>
    
    <p>
        <a role="button" class="btn-engagement"><i class="icon-eye-open"></i> Engagement</a> <?php if($homefeed[$i]->retweet_count>0): ?>|
        <span><i class="icon-retweet greyText"></i><?php echo $homefeed[$i]->retweet_count; ?> re-tweet(s)</span><?php endif;?>
    </p>
    
    
    <!-- ENGAGEMENT -->    
    <div class="engagement hide">
        <div class="engagement-header">
            <span class="engagement-btn-close btn-close pull-right">Close <i class="icon-remove-sign"></i></span>
        </div>
        <br>
        <?php 
            //$filterh["b.twitter_user_id"] = $homefeed[$i]->twitter_user_id;
            //  $filterh["b.type"] = $mentions[$i]->type;
            $filterh["b.in_reply_to = "] = $homefeed[$i]->post_id.' ';     
            $comment=$this->twitter_model->ReadTwitterData($filterh, 3);    
            for($j=0;$j<count($comment);$j++){
        ?>
                <div class="engagement-body">
                    <span class="engagement-btn-hide-show btn-close pull-right"><i class="icon-caret-down"></i></span>    
                    <p class="headLine">
                        <span class="author">
                            <?php
                            $users=json_decode($comment[$j]->twitter_entities);
                            echo $users->user_mentions[0]->name;
                            ?>
                        </span>
                        <i class="icon-circle"></i>
                        <span>posted a <span class="cyanText">comment</span></span>
                        <i class="icon-circle"></i>
                        <span>2 hours ago</span>
                    </p>
                    <div>
                        <p><?php echo RemoveUrlWithin($comment[$j]->text) ?></p>
                        <!--p><input type="hidden" class="str_id" value="<?php echo $comment[$j]->post_stream_id; ?>" /><button type="button" class="btn btn-warning btn-mini">OPEN</button>
                        <button class="retweet btn btn-primary btn-mini" style="margin-left: 5px;">RE-TWEET</button></p-->
                    </div>
                </div>
        <?php } ?>
        <!-- ==================== CONDENSED TABLE HEADLINE ==================== -->
        <div href='#modal-action-log-<?php echo $homefeed[$i]->post_stream_id ?>' data-toggle='modal' class="containerHeadline specialToggleTable">
            <i class="icon-table"></i><h2>Action Log</h2>
        </div>
        <!-- ==================== END OF CONDENSED TABLE HEADLINE ==================== -->

        <!-- ==================== CONDENSED TABLE FLOATING BOX ==================== -->
            <?php
            $data_loaded['post'] = $homefeed[$i];
            $this->load->view('dashboard/action_taken', $data_loaded);?>
        <!-- ==================== END OF CONDENSED TABLE FLOATING BOX ==================== --> 
    </div>
    <!-- END ENGAGEMENT -->
    
    <h4 class="filled">
        <div class="pull-right">
         <?php
            $data = array(
                'come_from' => "home_feed",
                'post' => $homefeed[$i]
            );
            $this->load->view('dashboard/twitter/twitter_button', $data);
        ?>
        </div>
         
        <br clear="all" />
    </h4>
    
    <!-- REPLY -->  
    <div class="reply-field hide">
        <?php
        $data['mentions'] = $homefeed;
        $data['i'] = $i;
        $data['type'] = 'reply';
        $this->load->view('dashboard/reply_field_twitter', $data);?>
    </div>
    <!-- END REPLY -->
    
    <!-- DM -->  
    <div class="dm-field hide">
         <?php
        $data['mentions'] = $homefeed;
        $data['type'] = 'direct_message';
        $data['i'] = $i;
        $this->load->view('dashboard/reply_field_twitter', $data);?>
    </div>
    <!-- END DM -->
    
    <!-- CASE -->  
    <div class="case-field hide">
       <?php
            $data['posts'] = $homefeed;
            $data['i'] = $i;
            $this->load->view('dashboard/case_field',$data);
        ?>
    </div>
    <!-- END CASE -->  
    
    </li>
<?php } ?>
<?php if((count($homefeed) > 0) && (!isset($is_search))): ?>
<div class="filled" style="text-align: center;"><input type="hidden" class="channel_id" value="<?php echo $homefeed[0]->channel_id?>" /><input type="hidden"  class="channel_id" value="<?php echo $homefeed[0]->channel_id?>"/><input type="hidden" class="total_groups" value="<?php echo $total_groups?>" /><input type="hidden"  class="looppage" value=""/><button class="loadmore btn btn-info" value="feed"><i class="icon-chevron-down"></i> <span>LOAD MORE</span></button></div>
<?php endif;?>