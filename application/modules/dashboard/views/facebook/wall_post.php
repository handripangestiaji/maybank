<?php
//print_r($fb_feed);
$total_groups = ceil($count_fb_feed[0]->count_post_id/$this->config->item('item_perpage'));
$timezone=new DateTimeZone($this->config->item('timezone'));

for($i=0; $i<count($fb_feed);$i++):?>
<li>
    <input type="hidden" class="postId" value="<?php echo $fb_feed[$i]->post_id; ?>" />
    <div class="circleAvatar"><img src="https://graph.facebook.com/<?=number_format($fb_feed[$i]->facebook_id, 0,'.','')?>/picture?small" alt=""></div>
    <div class="read-mark <?php if($fb_feed[$i]->is_read==0){echo 'redText';} else { echo 'greyText'; } ?>"><i class="icon-bookmark icon-large"></i></div>
    <br />
    <p class="headLine">
        <span class="author"><?php echo $fb_feed[$i]->name//."(".$fb_feed[$i][$i]->users->usename.")"?></span>
        <i class="icon-circle"></i>
        <span>posted a <span class="cyanText">new post</span></span>
        <i class="icon-circle"></i>
        <span>
        <?php 
            $date=new DateTime($fb_feed[$i]->created_at.' Europe/London');
            $date->setTimezone($timezone);
            echo $date->format('l, M j, Y H:i:s');
        ?>
        
    </p>
    <p><?=$fb_feed[$i]->post_content?></p>
    <p>
    <?php
    if($fb_feed[$i]->attachment){ 
        $attachment=json_decode($fb_feed[$i]->attachment);
        for($att=0;$att<count($attachment);$att++){
           if($attachment[$att]->type=='photo'){
                echo    "<a href='#modal-".$fb_feed[$i]->post_id."-".$attachment[$att]->type."' data-toggle='modal' ><img src='".$attachment[$att]->src."' /></a>";
                echo    '<div id="modal-'.$fb_feed[$i]->post_id.'-'.$attachment[$att]->type.'" class="attachment-modal modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <button type="button" class="close " data-dismiss="modal"><i class="icon-remove"></i></button>
                            <img src="'.$attachment[$att]->src.'" />
                        </div>';
           }elseif($attachment[$att]->type=='link'){
                echo    "<a href='".$attachment[$att]->href."'>".$attachment[0]->href."</a>";
           }elseif($attachment[$att]->type=='video'){?>
                <iframe width="320" height="auto" src="<?=$attachment[$att]->video->source_url."?version=3&autohide=1&autoplay=0"?>"></iframe>
                <a href="<?=$attachment[$att]->video->display_url?>" ><?=$attachment[0]->alt?></a>
       <?php 
            }
      } 
    }
    ?>
    </p>

    <p><button type="button" class="btn <?=$fb_feed[$i]->case_id != null ? "btn-purple" : "btn-warning btn-mini" ?>"><?=$fb_feed[$i]->case_id != null ? 'CASE #'.$fb_feed[$i]->case_id : 'OPEN'?></button>
        <button class="fblike btn btn-primary btn-mini" style="margin-left: 5px;" value="<?php echo $fb_feed[$i]->post_stream_id;?>"><?=$fb_feed[$i]->user_likes == 1 ? "UNLIKE" : "LIKE"?></button> </p>
    <p>
        <span class="btn-engagement"><i class="icon-eye-open"></i> <?php echo $fb_feed[$i]->total_comments;?> Engagements</span> |
        <span class="cyanText"><i class="icon-thumbs-up-alt"></i></i> <?php echo $fb_feed[$i]->total_likes; ?> likes</span> 
    </p>

    <!-- ENGAGEMENT -->    
    <div class="engagement hide">
        <div class="engagement-header">
            <span class="engagement-btn-close btn-close pull-right">Close <i class="icon-remove-sign"></i></span>
        </div>
        <br />
        <?php 
            $comment=$this->facebook_model->RetriveCommentPostFb($fb_feed[$i]->social_stream_post_id);
            //echo "<pre>";
           // print_r($comment);
            //echo "</pre>";
            
            for($j=0;$j<count($comment);$j++):
        ?>
        <div class="engagement-body">
            <span class="engagement-btn-hide-show btn-close pull-right"><i class="icon-caret-down"></i></span>    
            <p class="headLine">
                <span class="author"><?php echo $comment[$j]->name; ?></span>
                <i class="icon-circle"></i>
                <span>posted a <span class="cyanText">comment</span></span>
                <i class="icon-circle"></i>
                <span><?php echo $comment[$j]->created_at; ?></span>
            </p>
            <div class="engagement-comment">
                <p>"<?php echo $comment[$j]->comment_content; ?>"</p>
                <p>
                    <button type="button" class="btn btn-warning btn-mini">OPEN</button>
                    <button class="fblike btn btn-primary btn-mini" value="<?=$comment[$j]->post_stream_id?>"><?=$comment[$j]->user_likes == 1 ? "UNLIKE" : "LIKE"?></button>
                    <?php if(($comment[$j]->comment_id)=='0'){?>
                    <button type="button" class="btn btn-primary btn-engagement-reply btn-mini" ><i class="icon-mail-reply"></i></button>
                    <?php } ?>
                   <button type="button" class="btn btn-danger btn-engagement-case btn-mini"><i class="icon-plus"></i> CASE</button>
                </p>
                <div class="reply-engagement-field hide">
                    <?php
                    $data['fb_feed'] = $comment;
                    $data['i'] = $i;
                    $this->load->view('dashboard/reply_field_facebook', $data)?>  
                </div>
                <div class="case-engagement-field hide">
                    <div class="row-fluid">
                        <span class="reply-field-btn-close btn-close pull-right"><i class="icon-remove"></i></span>
                        CASE ID      : #012345
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
                        <br clear="all" />
                        <button class="btn btn-small btn-purple btn-add-related">Add Related Conversation</button>
                        <br clear="all" />
                        <div class="pull-left">
                            Assign To:
                        </div>
                        <div class="pull-right">
                            <select>
                                <option value="keyword">Nicole Lee</option>
                                <option value="user">Azahan Azad</option>
                                <option value="keyword">Azahamad Arif</option>
                            </select>
                        </div>
                        <br clear="all" />
                        <div class="pull-left">
                            Email:
                        </div>
                        <div class="pull-right">
                            <input type="text">
                        </div>
                        <br clear="all" />
                        Message :
                        <br>
                        <textarea placeholder="Compose Message"></textarea>
                        <br clear="all" />
                        <div class="pull-right">
                            <button class="btn-purple btn btn-small"><i class="icon-ok-circle icon-large"></i> Assign</button>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
       <?php endfor; ?>
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
        <a style="font-size: 20px;"><i class="icon-trash greyText"></i></a>
        <div class="pull-right">
            <button type="button" class="btn btn-primary btn-reply"><i class="icon-mail-reply"></i></button>
            <?php if(!$fb_feed[$i]->case_id):?>
                <button type="button" class="btn btn-danger btn-case" name="action" value="case"><i class="icon-plus"></i> CASE</button>
            <?php else:?>
                <button type="button" class="btn btn-purple btn-case" name="action" value="Resolved"><i class="icon-check"></i> RESOLVE</button>
            <?php endif?>
        </div>
        <br clear="all" />
    </h4>
    
    <!-- REPLY -->  
    <div class="reply-field hide">
    <?php
    $data['fb_feed'] = $fb_feed;
    $data['i'] = $i;
    $this->load->view('dashboard/reply_field_facebook', $data)?>  
    </div>
    <!-- END REPLY -->
    
    <!-- CASE -->
    <div class="case-field hide">
    <?php
        $data['posts'] = $fb_feed;
        $data['i'] = $i;
        $this->load->view('dashboard/case_field',$data);
    ?>
    </div>
    <!-- END CASE -->  
</li>
<?php endfor;?>
<?php if(count($fb_feed) > 0):?>
<div class="filled" style="text-align: center;"><input type="hidden" class="total_groups" value="<?=$total_groups?>" /><input type="hidden"  class="looppage" value=""/><input type="hidden"  class="channel_id" value="<?=$fb_feed[0]->channel_id?>"/><button class="loadmore btn btn-info" value="wallPosts"><i class="icon-chevron-down"></i> LOAD MORE</button></div>
<?php endif;?>
