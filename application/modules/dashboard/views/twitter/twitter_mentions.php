<?php
$total_groups = ceil($countMentions[0]->count_post_id/$this->config->item('item_perpage'));
$timezone=new DateTimeZone($this->config->item('timezone'));
for($i=0;$i<count($mentions);$i++){
?>
    <li <?php if($mentions[$i]->is_read==0){echo 'class="unread-post"';} ?>>
        <div class="message"></div>
        <input type="hidden" class="postId" value="<?php echo $mentions[$i]->social_stream_post_id; ?>" />
        <div class="circleAvatar"><img src="<?php echo $mentions[$i]->profile_image_url;?>" alt=""></div>
        <div class="read-mark <?php if($mentions[$i]->is_read==0){echo 'redText';} else { echo 'greyText'; } ?>"><i class="icon-bookmark icon-large"></i></div>
        <br />
        <p class="headLine">
            <span class="author"><?php echo $mentions[$i]->screen_name; ?></span>
            <i class="icon-circle"></i>
            <span>mentions</span>
            <i class="icon-circle"></i>
            <span><?php
            
            $date = new DateTime($mentions[$i]->social_stream_created_at.' Europe/London');
            $date->setTimezone($timezone);
            echo $date->format('l, M j, Y h:i A');
            $entities = json_decode($mentions[$i]->twitter_entities);
            ?></span>
        </p>
    <p><?php 
        $pattern = "/_(?=[^>]*<)/";
        $html = $mentions[$i]->text;
        foreach($entities->urls as $url){
            $html = substr($html, 0, $url->indices[0]);
            $html .= "<a href='$url->expanded_url' target='_blank'>$url->display_url</a>";
            $html .= substr($mentions[$i]->text, $url->indices[1] );
        }
        $html =  linkify(html_entity_decode($html), true, false);
        echo $html;
    ?></p>
    <p>
    <?php if(isset($entities->media[0])){
            echo "<a href='#modal-".$mentions[$i]->social_stream_post_id."' data-toggle='modal' ><img src='".$entities->media[0]->media_url_https."' /></a>";
            echo '<div id="modal-'.$mentions[$i]->social_stream_post_id.'" class="attachment-modal modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <button type="button" class="close " data-dismiss="modal"><i class="icon-remove"></i></button>
                            <img src="'.$entities->media[0]->media_url_https.'" />
                </div>';
            }
    ?>
    </p>
    <p class="indicator">
    <?php if($mentions[$i]->case_id):?>
        <button type="button" class="btn btn-purple btn-mini" value="<?php echo $mentions[$i]->case_id?>">CASE ID #<?php echo $mentions[$i]->case_id?></button>
    <?php endif?>
    <?php if(count($mentions[$i]->reply_post) > 0):?>
        <button type="button" class="btn btn-inverse btn-mini" value="<?php echo $mentions[$i]->reply_post[0]->response_post_id?>">
        
        <?php
        $reply_date = new DateTime($mentions[$i]->reply_post[0]->created_at, new DateTimeZone($mentions[$i]->reply_post[0]->timezone));
        echo "Replied by: ".$mentions[$i]->reply_post[0]->display_name." ".$reply_date->format("d-M-y h:i A") ?>
        </button>
    <?php endif?>
    <?php if(count($mentions[$i]->reply_post) == 0 && !$mentions[$i]->case_id):?>
        <button type="button" class="btn btn-warning btn-mini no-cursor">OPEN</button>
    <?php endif?>
   
    
    <?php if ($mentions[$i]->retweeted==1) { ?>
        <button type="button" class="btn btn-success btn-mini"><i class="icon-retweet"></i></button>
    <?php } ?>    
    <?php if ($mentions[$i]->favorited=='1') { ?>
        <button type="button" class="btn btn-inverse btn-mini"><i class="icon-star">&nbsp;</i></button>
    <?php }
        $filterm["b.in_reply_to = "] = $mentions[$i]->social_stream_post_id.' ';
        $filterm['b.type'] = "user_timeline";
        $comment=$this->twitter_model->ReadTwitterData($filterm, 3);
    ?></p>
    
    <p>
        <a role="button" class="btn-engagement"><i class="icon-eye-open"></i><?=count($comment)?> Engagement</a> 
        <?php if($mentions[$i]->retweet_count>0): ?>|
        <span><i class="icon-retweet greyText"></i><?php echo $mentions[$i]->retweet_count; ?> re-tweet(s)</span><?php endif;?>
    </p>
    <!-- ENGAGEMENT -->    
    <div class="engagement hide">
        <div class="engagement-header">
            <span class="engagement-btn-close btn-close pull-right">Close <i class="icon-remove-sign"></i></span>
        </div>
        <br/>
        <?php 
         $currComment = '';
         for($j=0;$j<count($comment);$j++):
            
            if($currComment != $comment[$j]->{'text'}):
            $currComment = $comment[$j]->text;
        ?>
                <div class="engagement-body">
                    <span class="engagement-btn-hide-show btn-close pull-right"><i class="icon-caret-down"></i></span>    
                    <p class="headLine">
                        <span class="author">
                            <?php echo $comment[$j]->name?>
                        </span>
                        <i class="icon-circle"></i>
                        <span>posted a <span class="cyanText">tweet</span></span>
                        <i class="icon-circle"></i>
                        <span><?php
                         $date = new DateTime($mentions[$i]->social_stream_created_at.' Europe/London');
                         $date_comment = new DateTime($comment[$j]->created_at, $timezone);
                        ?></span>
                    </p>
                    <div>
                        <p><?php echo $comment[$j]->text?></p>
                        <p><input type="hidden" class="str_id" value="<?php echo $comment[$j]->post_stream_id; ?>" /><button type="button" class="btn btn-warning btn-mini">OPEN</button><button class="retweet btn btn-primary btn-mini" style="margin-left: 5px;">RE-TWEET</button></p>
                    </div>
                </div>
                <?php endif;?>
            <?php endfor; ?>
        <!-- ==================== CONDENSED TABLE HEADLINE ==================== -->
        <div class="containerHeadline specialToggleTable">
            <i class="icon-table"></i><h2>Action Log</h2>
        </div>
        <!-- ==================== END OF CONDENSED TABLE HEADLINE ==================== -->

        <!-- ==================== CONDENSED TABLE FLOATING BOX ==================== -->
        <?php
            $data_loaded['post'] = $mentions[$i];
            $this->load->view('dashboard/action_taken', $data_loaded);?>
        <!-- ==================== END OF CONDENSED TABLE FLOATING BOX ==================== --> 
    </div>
    <!-- END ENGAGEMENT -->
    
    <h4 class="filled">
        <div class="pull-right">
            <?php
                $data = array(
                    'come_from' => "mentions",
                    'post' => $mentions[$i]
                );
                $this->load->view('dashboard/twitter/twitter_button', $data);
            ?>
        </div>
        <br clear="all" />
    </h4>
    <!-- DM -->  
    <div class="dm-field hide">
        <?php
        $data['mentions'] = $mentions;
        $data['type'] = 'direct_message';
        $data['i'] = $i;
        $this->load->view('dashboard/reply_field_twitter', $data);?>
    </div>
    <div class="reply-field hide">
        
        <?php
        $data['mentions'] = $mentions;
        $data['type'] = 'reply';
        $data['i'] = $i;
        $this->load->view('dashboard/reply_field_twitter', $data);?>
    </div>
    <!-- END DM -->    
    
    
    <!-- CASE -->
    <div class="case-field hide">
       <?php
            $data['posts'] = $mentions;
            $data['i'] = $i;
            $this->load->view('dashboard/case_field',$data);
        ?>
    </div>
    <!-- END CASE -->  
    
    </li>
<?php } 
?>
<?php if(count($mentions) > 0):?>
    <div class="filled" style="text-align: center;"><input type="hidden" class="total_groups" value="<?php echo $total_groups?>" />
    <input type="hidden"  class="channel_id" value="<?php echo $mentions[0]->channel_id?>"/>
    <input type="hidden"  class="looppage" value=""/>
    <button class="loadmore btn btn-info" value="mentions"><i class="icon-chevron-down"></i> <span>LOAD MORE</span></button></div>
<?php endif;?>