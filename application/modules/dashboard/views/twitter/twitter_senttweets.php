<?php
$total_groups = ceil($countTweets[0]->count_post_id/$this->config->item('item_perpage'));
$timezone=new DateTimeZone($this->config->item('timezone'));
for($i=0;$i<count($senttweets);$i++){
?>
    <li>
        <input type="hidden" class="postId" value="<?php echo $senttweets[$i]->post_id; ?>" />
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
            $entities = json_decode($senttweets[$i]->twitter_entities);
            //echo date('l, M j, Y H:i:s',strtotime($senttweets[$i]->created_at));?></span>
            
        </p>
    <p><?php
    
     $html = html_entity_decode($senttweets[$i]->text);
    foreach($entities->urls as $url){
        $html = substr($html, 0, $url->indices[0]);
        $html .= "<a href='$url->expanded_url' target='_blank'>$url->display_url</a>";
        $html .= substr($senttweets[$i]->text, $url->indices[1] );
        
    }
    $html =  linkify(html_entity_decode($html), true, false);
    echo $html;
    ?></p>
     <p class="indicator"><?php
    if(isset($entities->media[0])):    ?>
        <img src="<?php echo $entities->media[0]->media_url_https?>" alt="" />
    <?php endif;?>
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
        <div class="engagement-header">
            <span class="engagement-btn-close btn-close pull-right">Close <i class="icon-remove-sign"></i></span>
        </div>
        <br>
        <?php 
               // $filtera["b.twitter_user_id"] = $mentions[$i]->twitter_user_id;
                $filters["b.post_id = "] = $senttweets[$i]->in_reply_to.' ';     
                $comment=$this->twitter_model->ReadTwitterData($filters, 3);
               
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
        <div class="containerHeadline">
            <i class="icon-table"></i><h2>Action Log</h2>
            <div class="controlButton pull-right"><i class="icon-caret-down toggleTable"></i></div>
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
        <a role="button" class='destroy_status'><i class="icon-trash greyText"></i></a>
        <div class="pull-right">
                <!--form class="contentForm" action="<?php //echo base_url('index.php/dashboard/socialmedia/twitteraction');?>" method="post"-->
                <button type="button" class="retweet btn btn-primary"><i class="icon-retweet"></i></button>
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
    <div class="reply-field hide">
        <div class="row-fluid">
             <form class="contentForm" action="<?php echo base_url('index.php/dashboard/socialmedia/twitteraction');?>" method="post">
            <span class="reply-field-btn-close btn-close pull-right"><i class="icon-remove"></i></span>
            <div class="pull-left">
                <select style="width: 130px;">
                    <option value="keyword">Feedback</option>
                    <option value="user">Enquiry</option>
                    <option value="keyword">Complaint</option>
                </select>
                <select style="width: 130px;">
                    <option value="keyword">Accounts & Banking</option>
                    <option value="user">Cards</option>
                    <option value="keyword">Investment</option>
                    <option value="keyword">insurance</option>
                    <option value="user">Loans</option>
                    <option value="keyword">Maybank2u</option>
                    <option value="keyword">Others</option>
                </select>
            </div>
            <textarea placeholder="Compose Message" name="content"></textarea>
            <br clear="all" />
            <div class="pull-left">
                <i class="icon-link"></i>
                <input type="text" class="span8"><button class="btn btn-primary btn-mini" style="margin-left: 5px;">SHORTEN</button>
            </div>
            <div class="pull-right">
                <i class="icon-camera"></i>
            </div>
            <br clear="all" />
            <div class="pull-left reply-char-count">
                <i class="icon-twitter-sign"></i>&nbsp;<span class="reply-tw-char-count">140</span>
            </div>
            <div class="pull-right">
                <button class="btn btn-primary btn-small btn-send-reply" name="action"  type="submit" value="replay" >SEND</button>    
            </div>
            <br clear="all" />
            <div class="reply-status hide">MESSAGE SENT</div>
            </form>
        </div>
    </div>
    <!-- END REPLY -->
    
    <!-- CASE -->  
    <div class="case-field hide">
       <?php
            $data['posts'] = $senttweets;
            $data['i'] = $i;
            $this->load->view('dashboard/case_field',$data);
        ?>
    </div>
    <!-- END CASE -->  
    
    </li>
<?php } ?>
<?php if(count($senttweets) > 0):?>
 <div class="filled" style="text-align: center;"><button class="loadmore btn btn-info" value="sendmessage"><input type="hidden"  class="channel_id" value="<?php echo $senttweets[0]->channel_id?>"/><input type="hidden" class="channel_id" value="<?php echo $channel_id?>" /><i class="icon-chevron-down"></i> LOAD MORE</button></div>
<?php endif?>