<?php
//print_r($countMentions);
//print_r($mentions);
//
$total_groups = ceil($countMentions[0]->count_post_id/$this->config->item('item_perpage'));
$timezone=new DateTimeZone($this->config->item('timezone'));
for($i=0;$i<count($mentions);$i++){
?>
    <li <?php if($mentions[$i]->is_read==0){echo 'class="unread-post"';} ?>>
        <input type="hidden" class="postId" value="<?php echo $mentions[$i]->post_id; ?>" />
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
        echo linkify(html_entity_decode($mentions[$i]->text),true); 
        
    ?></p>
    <p>
    <?php if(isset($entities->media[0])){
            echo "<a href='#modal-".$mentions[$i]->post_id."' data-toggle='modal' ><img src='".$entities->media[0]->media_url_https."' /></a>";
            echo '<div id="modal-'.$mentions[$i]->post_id.'" class="attachment-modal modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
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
    <?php if($mentions[$i]->response_post_id):?>
        <button type="button" class="btn btn-inverse btn-mini" value="<?php echo $mentions[$i]->response_post_id?>">REPLIED</button>
    <?php endif?>
    <?php if(!$mentions[$i]->response_post_id && !$mentions[$i]->case_id):?>
        <button type="button" class="btn btn-warning btn-mini">OPEN</button>
    <?php endif?>
   
    
    <?php if ($mentions[$i]->retweeted==1) { ?>
        <button type="button" class="btn btn-success btn-mini"><i class="icon-retweet"></i></button>
    <?php } ?>    
    <?php if ($mentions[$i]->favorited=='1') { ?>
        <button type="button" class="btn btn-inverse btn-mini"><i class="icon-star">&nbsp;</i></button>
    <?php } ?></p>
    
    <p>
        <a role="button" class="btn-engagement"><i class="icon-eye-open"></i> Engagement</a> |
        <a data-toggle="modal" role="button" href="#modaltweet<?php echo $i; ?>" ><i class="icon-retweet greyText"></i><?php if($mentions[$i]->retweet_count>0)echo $mentions[$i]->retweet_count; ?> re-tweets</a>  
    </p>
    <!-- ENGAGEMENT -->    
    <div class="engagement hide">
        <div class="engagement-header">
            <span class="engagement-btn-close btn-close pull-right">Close <i class="icon-remove-sign"></i></span>
        </div>
        <br/>
        <?php 
               // $filtera["b.twitter_user_id"] = $mentions[$i]->twitter_user_id;
                $filterm["b.in_reply_to = "] = $mentions[$i]->post_id.' ';     
                $comment=$this->twitter_model->ReadTwitterData($filterm, 3);
               
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
                        <p>"<?php echo $comment[$j]->text?>"</p>
                        <p><input type="hidden" class="str_id" value="<?php echo $comment[$j]->post_stream_id; ?>" /><button type="button" class="btn btn-warning btn-mini">OPEN</button><button class="retweet btn btn-primary btn-mini" style="margin-left: 5px;">RE-TWEET</button></p>
                    </div>
                </div>
        <?php } ?>
        <!-- ==================== CONDENSED TABLE HEADLINE ==================== -->
        <div class="containerHeadline specialToggleTable">
            <i class="icon-table"></i><h2>Action Log</h2>
        </div>
        <!-- ==================== END OF CONDENSED TABLE HEADLINE ==================== -->

        <!-- ==================== CONDENSED TABLE FLOATING BOX ==================== -->
        <div class="floatingBox table hide">
            <div class="container-fluid">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Time Stamp</th>
                      <th>Username</th>
                      <th>Action Taken</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>2013-09-30 19:52:46</td>
                      <td>Teo Eu Gene</td>
                      <td>Resolved</td>
                      <td><button class="btn btn-primary icon-book"></button></td>
                    </tr>
                    <tr>
                      <td>2013-09-30 19:52:46</td>
                      <td>Teo Eu Gene</td>
                      <td>Resolved</td>
                      <td><button class="btn btn-primary icon-book"></button></td>
                    </tr>
                  </tbody>
                </table>  
            </div>
        </div>
        <!-- ==================== END OF CONDENSED TABLE FLOATING BOX ==================== --> 
    </div>
    <!-- END ENGAGEMENT -->
    
    <h4 class="filled">
        <!--a role="button" class='destroy_status'><i class="icon-trash greyText"></i></a-->
        <div class="pull-right">
            <!--form class="contentForm" action="<?php //echo base_url('index.php/dashboard/socialmedia/twitteraction');?>" method="post"-->
                <button class="btn btn-reply btn-primary" data-toggle="modal" value="<?php echo $mentions[$i]->post_id?>"><i class="icon-mail-reply"></i></button>
                <button type="button" class="retweet btn btn-primary" value="<?php echo $mentions[$i]->post_id?>"><i class="icon-retweet"><span></span></i></button>
                <button class="btn btn-dm btn-primary" data-toggle="modal"><i class="icon-envelope"></i></button>
                <button type="button" class="favorit btn btn-primary"><i class="icon-star"></i><span></span></button>
                
                <?php if($mentions[$i]->following=='1'){ ?>
                <button type="button" class="unfollow btn"><i class="icon-user"></i></button>
                <?php }else{ ?>
                <button type="button" class="follow btn btn-primary" value="follow"><i class="icon-user"></i></button>
                <?php } ?>
                <?php if(!$mentions[$i]->case_id):?>
                    <button type="button" class="btn btn-danger btn-case" name="action" value="case"><i class="icon-plus"></i> CASE</button>
                <?php else:?>
                    <button type="button" class="btn btn-purple btn-resolve" name="action" value="Resolved"><i class="icon-check"></i> RESOLVE</button>
                <?php endif?>
                <input type="hidden" class="str_id" value="<?php echo $mentions[$i]->post_stream_id; ?>" />
                <input type="hidden" class="id" value="<?php echo json_decode($mentions[$i]->twitter_entities)->user_mentions[0]->id; ?>" />
                <input type="hidden" class="userid" value="<?php echo $mentions[$i]->twitter_user_id; ?>" />
                <input type="hidden" class="followid" value="<?php echo $mentions[$i]->twitter_user_id; ?>" />
               <!--/form-->    
        </div>
         <!--div class="actionreport compose-post-status green hide">Message Post</div-->
        <br clear="all" />
    </h4>
    
   

    <!-- DM -->  
    <div class="dm-field hide">
        <div class="row-fluid">
            <span class="dm-field-btn-close btn-close pull-right"><i class="icon-remove"></i></span>
            <div class="pull-left">
                <select style="width: 40%;">
                    <option value="keyword">Feedback</option>
                    <option value="user">Enquiry</option>
                    <option value="keyword">Complaint</option>
                </select>
                <select style="width: 40%;">
                   <?php foreach($product_list as $product):?>
                        <option value="<?php echo $product->id?>"><?php echo $product->product_name?></option>
                    <?php endforeach?>
                </select>
            </div>
            <textarea class='replaycontent' placeholder="Compose Message" name="content"></textarea>
            <br clear="all" />
            <div class="pull-left">
                <i class="icon-link"></i>
                <input type="text" class="span8"><a href="#" class="btn btn-primary btn-mini" style="margin-left: 5px;">SHORTEN</a>
            </div>
            <div class="pull-right">
                <i class="icon-camera"></i>
            </div>
            <br clear="all" />
            <div class="pull-left reply-char-count">
                <i class="icon-twitter-sign"></i>&nbsp;<span class="reply-tw-char-count">140</span>
            </div>
            <div class="pull-right">
                <button class="dm_send btn btn-primary btn-small btn-send-dm"  type="button" value="<?php echo $mentions[$i]->twitter_user_id;?>" >SEND</button>    
                       <input type="hidden" class="screen_name" value="<?php echo $mentions[$i]->screen_name; ?>" />
            </div>
            <br clear="all" />
            <div class="dm-status hide">MESSAGE SENT</div>
        </div>
    </div>
    <div class="reply-field hide">
        
        <?php
        $data['mentions'] = $mentions;
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
 <div class="filled" style="text-align: center;"><input type="hidden" class="total_groups" value="<?php echo $total_groups?>" /><input type="hidden"  class="channel_id" value="<?php echo $mentions[0]->channel_id?>"/><input type="hidden"  class="looppage" value=""/><button class="loadmore btn btn-info" value="mentions"><i class="icon-chevron-down"></i> LOAD MORE</button></div>
<?php endif;?>