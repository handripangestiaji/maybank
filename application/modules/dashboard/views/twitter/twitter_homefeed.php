<?php
$total_groups = ceil($countFeed[0]->count_post_id/$this->config->item('item_perpage'));
$timezone=new DateTimeZone($this->config->item('timezone'));
for($i=0;$i<count($homefeed);$i++){
?>
    <li <?php if($homefeed[$i]->is_read==0){echo 'class="unread-post"';} ?>>
        <div class="circleAvatar"><img src="<?php echo $homefeed[$i]->profile_image_url;?>" alt=""></div>
        <div class="read-mark <?php if($homefeed[$i]->is_read==0){echo 'redText';} else { echo 'greyText'; } ?>"><i class="icon-bookmark icon-large"></i></div>
        <br />
        <p class="headLine">
            <span class="author"><?php echo $homefeed[$i]->screen_name; ?></span>
            <i class="icon-circle"></i>
            <span>mentions</span>
            <i class="icon-circle"></i>
            <span>
            <?php 
            $date=new DateTime($homefeed[$i]->created_at.' Europe/London');
            $date->setTimezone($timezone);
            echo $date->format('l, M j, Y H:i:s');
            
            $entities = json_decode($homefeed[$i]->twitter_entities);
            
            ?>
            </span>
          
        </p>
    <p><?php  echo linkify(html_entity_decode($homefeed[$i]->text), true);  ?></p>
    <p><?php
    
    if(isset($entities->media[0])):    ?>
        <img src="<?=$entities->media[0]->media_url_https?>" alt="" />
    <?php endif;?>
    </p>
    <p><button type="button" class="btn btn-warning btn-mini">OPEN</button>
    <?php if ($homefeed[$i]->retweet_count>=1) { ?>
        <button type="button" class="btn btn-inverse btn-mini"><i class="icon-retweet"> <?=$homefeed[$i]->retweet_count?></i></button>
    <?php } ?>    
    <?php if ($homefeed[$i]->favorited=='1') { ?>
        <button type="button" class="btn btn-inverse btn-mini"><i class="icon-star">&nbsp;</i></button>
    <?php } ?></p>
    
    <p>
        <a role="button" class="btn-engagement"><i class="icon-eye-open"></i> Engagement</a> |
        <a data-toggle="modal" role="button" href="#modaltweet<?php echo $i; ?>" ><i class="icon-retweet greyText"></i><?php //echo $homefeed[$i]->retweeted; ?> re-tweets</a> | 
        <span class="btn-mark-as-read cyanText" style="display: <?php if($homefeed[$i]->is_read==1){echo 'none';} ?>"><i class="icon-bookmark"></i> Mark as Read</span>
        <span class="btn-mark-as-unread cyanText" style="display: <?php if($homefeed[$i]->is_read==0){echo 'none';} ?>"><i class="icon-bookmark-empty"></i> Mark as Unread</span>
    </p>
    
    
    <!-- ENGAGEMENT -->    
    <div class="engagement hide">
        <div class="engagement-header">
            <span class="engagement-btn-close btn-close pull-right">Close <i class="icon-remove-sign"></i></span>
        </div>
        <br>
        <div class="engagement-body">
            <span class="engagement-btn-hide-show btn-close pull-right"><i class="icon-caret-down"></i></span>    
            <p class="headLine">
                <span class="author">John Doe</span>
                <i class="icon-circle"></i>
                <span>posted a <span class="cyanText">comment</span></span>
                <i class="icon-circle"></i>
                <span>2 hours ago</span>
            </p>
            <div>
                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                <p><button type="button" class="btn btn-warning btn-mini">OPEN</button><button class="btn btn-primary btn-mini" style="margin-left: 5px;">RE-TWEET</button></p>
            </div>
        </div>
        <div class="engagement-body">
            <span class="engagement-btn-hide-show btn-close pull-right"><i class="icon-caret-down"></i></span>    
            <p class="headLine">
                <span class="author">John Doe</span>
                <i class="icon-circle"></i>
                <span>posted a <span class="cyanText">comment</span></span>
                <i class="icon-circle"></i>
                <span>2 hours ago</span>
            </p>
            <div>
                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco..."</p>
                <p><button type="button" class="btn btn-warning btn-mini">OPEN</button><button class="btn btn-primary btn-mini" style="margin-left: 5px;">RE-TWEET</button></p>
            </div>
        </div>
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
        <!--a role="button" class='destroy_status'><i class="icon-trash greyText"></i></a-->
        <div class="pull-right">
            <!--form class="contentForm" action="<?php //echo base_url('index.php/dashboard/socialmedia/twitteraction');?>" method="post"-->
                <button class="btn btn-reply btn-primary" data-toggle="modal"><i class="icon-mail-reply"></i></button>
                <button type="button" class="retweet btn btn-primary"><i class="icon-retweet"></i></button>
                 <button class="btn btn-dm btn-primary" data-toggle="modal"><i class="icon-envelope"></i></button>
                <button type="button" class="favorit btn btn-primary"><i class="icon-star"></i></button>
                <?php if($homefeed[$i]->following=='1'){ ?>
                <button type="button" class="unfollow btn"><i class="icon-user"></i></button>
                <?php }else{ ?>
                <button type="button" class="follow btn btn-primary" value="follow"><i class="icon-user"></i></button>
                <?php } ?>
                <button type="button" class="btn btn-danger btn-case" name="action" value="case"><i class="icon-plus"></i>CASE</button>
                <input type="hidden" class="str_id" value="<?php echo $homefeed[$i]->post_stream_id; ?>" />
                <input type="hidden" class="userid" value="<?php echo $homefeed[$i]->twitter_user_id; ?>" />
                <input type="hidden" class="followid" value="<?php echo $homefeed[$i]->twitter_user_id; ?>" />
               <!--/form-->    
        </div>
         <!--div class="actionreport compose-post-status green hide">Message Post</div-->
        <br clear="all" />
    </h4>
    
    <!-- REPLY -->  
    <div class="reply-field hide">
        <?php
        $data['mentions'] = $homefeed;
        $data['i'] = $i;
        $this->load->view('dashboard/reply_field_twitter', $data);?>
    </div>
    <!-- END REPLY -->
    
    <!-- DM -->  
    <div class="dm-field hide">
        <div class="row-fluid">
            <span class="dm-field-btn-close btn-close pull-right"><i class="icon-remove"></i></span>
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
            <textarea class='replaycontent' placeholder="Compose Message" name="content"></textarea>
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
                <button class="dm_send btn btn-primary btn-small btn-send-dm"  type="button" value="<?=$homefeed[$i]->post_stream_id;?>" >SEND</button>    
            </div>
            <br clear="all" />
            <div class="dm-status hide">MESSAGE SENT</div>
        </div>
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
<div class="filled" style="text-align: center;"><input type="hidden" class="channel_id" value="<?=$channel_id?>" /><input type="hidden"  class="channel_id" value="<?=$homefeed[0]->channel_id?>"/><input type="hidden" class="total_groups" value="<?=$total_groups?>" /><input type="hidden"  class="looppage" value=""/><button class="loadmore btn btn-info" value="feed"><i class="icon-chevron-down"></i> LOAD MORE</button></div>
