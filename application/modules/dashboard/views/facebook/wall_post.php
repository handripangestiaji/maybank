<?php
//print_r($fb_feed);
$total_groups = ceil($count_fb_feed[0]->count_post_id/$this->config->item('item_perpage'));
$timezone=new DateTimeZone($this->session->userdata('timezone'));

for($i=0; $i<count($fb_feed);$i++):
$isMyCase=$this->case_model->chackAssignCase(array('a.post_id' => $fb_feed[$i]->post_id, 'a.status <>'=>'reassign'));
//print_r($isMyCase);
?>
<li class="<?php if(isset($isMyCase[0]->assign_to)){echo "case_".$isMyCase[0]->case_id;} ?>" id="post<?=$fb_feed[$i]->social_stream_post_id?>">
    <input type="hidden" class="postId" value="<?php echo $fb_feed[$i]->post_id; ?>" />
    <div class="circleAvatar"><img src="<?php echo base_url('dashboard/media_stream/SafePhoto?photo=')."https://graph.facebook.com/".number_format($fb_feed[$i]->facebook_id, 0,'.','')?>/picture?small" alt=""></div>
    <?php if (IsRoleFriendlyNameExist($this->user_role, 'Social Stream_Current_Take Action')):?>
    <div class="read-mark <?php if($fb_feed[$i]->is_read==0){echo 'redText';} else { echo 'greyText'; } ?>"><i class="icon-bookmark icon-large"></i></div>
    <?php endif ?>
    <br />
    <p class="headLine">
        <span class="author"><?php echo $fb_feed[$i]->name//."(".$fb_feed[$i][$i]->users->usename.")"?></span>
        <i class="icon-circle"></i>
        <span>posted a <span class="cyanText">new post</span></span>
        <i class="icon-circle"></i>
        <span>
        <?php 
        
            $date=new DateTime($fb_feed[$i]->post_date.' Europe/London');
            $date->setTimezone($timezone);
            echo $date->format('l, M j, Y h:i A');
        ?>        
    </p>
    <p><?php echo $fb_feed[$i]->post_content?></p>
    <p>
    <?php
    if($fb_feed[$i]->attachment){ 
        $attachment=json_decode($fb_feed[$i]->attachment);
        $attachment = isset($attachment->media) ? $attachment->media: null;
        //print_r($attachment);
        for($att=0;$att<count($attachment);$att++){
           if($attachment[$att]->type=='photo'){
            
                $src = substr($attachment[$att]->src, 0, strlen($attachment[$att]->src) - 5)."n.jpg";
                echo    "<a href='#modal-".$fb_feed[$i]->post_id."-".$attachment[$att]->type."' data-toggle='modal' ><img src='".base_url('dashboard/media_stream/SafePhoto?photo=').$src."' /></a>";
                echo    '<div id="modal-'.$fb_feed[$i]->post_id.'-'.$attachment[$att]->type.'" class="attachment-modal modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <img src="'.base_url('dashboard/media_stream/SafePhoto?photo=').$src.'" />
                            <button type="button" class="close " data-dismiss="modal"><i class="icon-remove"></i></button>
                        </div>';
           }elseif($attachment[$att]->type=='link'){              
//                print_r($attachment);?>
            <center>
            <div class="compose-schedule" style="width: 85%;" >
                <div class="compose-form img-attached">
                    <!-- close button for image attached -->
                    <div>
                        <div style="float: left;min-height:30px; border-right: 1px solid  #616161; padding: 5px;" >
                            <?php echo '<img id="compose-preview-img" src="'.$attachment[$att]->src.'" style="widht:auto;"/>';?>
                        </div>
                        <!-- img-place end -->
                        <div style="float: left;min-height:30px;  position:relative; padding: 5px;"><?php echo "<a href='".$attachment[$att]->href."'>".$attachment[0]->href."</a>"; ?></div>
                    </div>
                    <!-- img-list-upload end -->  
                </div>
            </div>  <br clear="all" />
           </center>
           <?php }elseif($attachment[$att]->type=='video'){?>
                <iframe width="90%" height="240" src="<?php echo $attachment[$att]->video->source_url."?version=3&autohide=1&autoplay=0"?>"></iframe>
                <a href="<?php echo $attachment[$att]->video->display_url?>" ><?php echo $attachment[0]->alt?></a>
       <?php 
            }
      } 
    }
    ?>
    </p>
    <p class="indicator">
    <?php 
    if(isset($isMyCase[0]->assign_to)){
        if($isMyCase[0]->assign_to==$this->session->userdata('user_id') or ($isMyCase[0]->solved_by)){ ?>
            <button type="button" class="btn <?php echo $fb_feed[$i]->case_id != null ? "btn-purple btn-mini" : "btn-inverse btn-mini" ?>"><?php echo $fb_feed[$i]->case_id != null ? 'CASE #'.$fb_feed[$i]->case_id.' Assign to You ' : 'CASE #'.$isMyCase[0]->case_id.'-'.'RESOLVE BY '.$isMyCase[0]->full_name?></button>
        <?php }else{ ?>
            <button type="button" class="btn <?php echo $fb_feed[$i]->case_id != null ? "btn-purple btn-mini" : "btn-inverse btn-mini" ?>">
                <?php echo $fb_feed[$i]->case_id != null ? 'CASE #'.$fb_feed[$i]->case_id.' Assign to: '.$isMyCase[0]->full_name : 'REPLIED'?>
            </button>  
    <?php    }
    }else{ 
       // print_r($fb_feed[$i]->reply_post[0]);
        if(isset($fb_feed[$i]->reply_post[0])){
        ?>
    
        <!--button type="button" class="btn <?php echo count($fb_feed[$i]->reply_post) == 0 ? "btn-warning btn-mini no-cursor indicator" : "btn-inverse btn-mini no-cursor indicator" ?>"><?php echo count($fb_feed[$i]->reply_post) == 0 ? 'OPEN' :  'Replied '?></button-->
        <button type="button" class="btn btn-inverse btn-mini" value="<?php echo $fb_feed[$i]->reply_post[0]->post_id?>">
        
        <?php
        
        $reply_date = new DateTime($fb_feed[$i]->reply_post[count($fb_feed[$i]->reply_post) - 1]->created_at);
        $reply_date->setTimezone($timezone);
        echo "Replied by: ".$fb_feed[$i]->reply_post[count($fb_feed[$i]->reply_post) - 1]->name." ".$reply_date->format("d-M-y h:i A") ?>
        </button>  
    <?php }else{?>
  <button type="button" class="btn <?php echo count($fb_feed[$i]->reply_post) == 0 ? "btn-warning btn-mini no-cursor indicator" : "btn-inverse btn-mini no-cursor indicator" ?>"><?php echo count($fb_feed[$i]->reply_post) == 0 ? 'OPEN' :  'Replied '?></button>        
    <?php }
    
    } ?>
    <?php if(IsRoleFriendlyNameExist($this->user_role,'Social Stream_Current_Social Functions Like, Retweet')):?>
        <button class="fblike btn btn-primary btn-mini" style="margin-left: 5px;" value="<?php echo $fb_feed[$i]->post_stream_id;?>"><?php echo $fb_feed[$i]->user_likes == 1 ? "UNLIKE" : "LIKE"?></button> </p>
    <?php endif ?>
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
            $comment = $fb_feed[$i]->reply_post;
           // echo "<pre>";
//            print_r($comment[$j]);
//            echo "</pre>";
            for($j=0;$j<count($comment);$j++):
            
        ?>
        <div class="engagement-body">
            <span class="engagement-btn-hide-show btn-close pull-right"><i class="icon-caret-down"></i></span>    
            <p class="headLine">
                <span class="author"><?php echo $comment[$j]->name; ?></span>
                <i class="icon-circle"></i>
                <span>posted a <span class="cyanText">comment</span></span>
                <i class="icon-circle"></i>
                <span><?php 
                $date=new DateTime($comment[$j]->created_at.' Europe/London');
                $date->setTimezone($timezone);
                echo $date->format('l, M j, Y h:i A');
                
              ?></span>
              <?php
//              echo "<pre>";
//              print_r($comment[$j]);
//              echo "</pre>";
                $attachment=json_decode($comment[$j]->attachment);
                if(isset($attachment->media->image->src)){
                $attachment=json_decode($comment[$j]->attachment);
             // echo "<pre>";
//              print_r($attachment);
//                echo "</pre>";
             echo    "<a href='#modal-".$comment[$j]->post_id."-photo1' data-toggle='modal' ><img src='".base_url('dashboard/media_stream/SafePhoto?photo=').$attachment->media->image->src."' /></a>";
                echo    '<div id="modal-'.$comment[$j]->post_id.'-photo1" class="attachment-modal modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <img src="'.base_url('dashboard/media_stream/SafePhoto?photo=').$attachment->media->image->src.'" />
                            <button type="button" class="close " data-dismiss="modal"><i class="icon-remove"></i></button>
                        </div>';
             }           
              ?>
              
            </p>
            <div class="engagement-comment">
                <p>"<?php echo $comment[$j]->comment_content; ?>"</p>
                
                <?php 
                    if(isset($isMyCase[0]->assign_to)){
                        if($isMyCase[0]->assign_to==$this->session->userdata('user_id') or ($isMyCase[0]->solved_by)){
                ?>
                <p>
                    <button type="button" class="btn btn-warning btn-mini">OPEN</button>
                    <button class="fblike btn btn-primary btn-mini" value="<?php echo $comment[$j]->post_stream_id?>"><?php echo $comment[$j]->user_likes == 1 ? "UNLIKE" : "LIKE"?></button>
                    <?php if(($comment[$j]->comment_id)=='0'){?>
                    <button type="button" class="btn btn-primary btn-engagement-reply btn-mini" ><i class="icon-mail-reply"></i></button>
                    <?php } ?>
                   <button type="button" class="btn btn-danger btn-engagement-case btn-mini"><i class="icon-plus"></i> CASE</button>
                </p>
                <?php } 
                }elseif(!isset($isMyCase[0])){?>
                <h4>
                    <p>
                    <button type="button" class="btn btn-warning btn-mini">OPEN</button>
                    <button class="fblike btn btn-primary btn-mini" value="<?php echo $comment[$j]->post_stream_id?>"><?php echo $comment[$j]->user_likes == 1 ? "UNLIKE" : "LIKE"?></button>
                    <?php if(($comment[$j]->comment_id)=='0'){?>
                    <button type="button" class="btn btn-primary btn-engagement-reply btn-mini btn-reply" ><i class="icon-mail-reply"></i></button>
                    <?php } ?>
                   <!--button type="button" class="btn btn-danger btn-engagement-case btn-mini btn-case" name="action" value="case"><i class="icon-plus"></i> CASE</button-->
                </p>
                </h4>
                <?php } ?>
                <div class="fb-reply-engagement-field reply-field hide">
                    <?php
                    $data['fb_feed'] = $comment;
                    $data['i'] = $j;
                    $data['reply_type']='reply_nested';
                    $this->load->view('dashboard/reply_field_facebook', $data)?>  
                </div>
                 <div class="case-field hide">
                <?php /*
                    //$data['posts'] = $comment;
                    $data['posts'] = $fb_feed;
                    $data['i'] = $j;
                    $this->load->view('dashboard/case_field',$data);
                */
                ?>
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
        
            <?php if(IsRoleFriendlyNameExist($this->user_role, 'Social Stream_Current_Take Action')):
            $data_loaded['post'] = $fb_feed[$i];
            $this->load->view('dashboard/action_taken', $data_loaded);
            endif
            ?>
        <!-- ==================== END OF CONDENSED TABLE FLOATING BOX ==================== --> 
    </div>
    <!-- END ENGAGEMENT -->

    <h4 class="filled">
        <!--di nonaktifin dulu, karena belum di butuhkan-->
        <!--a style="font-size: 20px; cursor: pointer;"><i class="icon-trash greyText deleteFB"></i></a-->
        <div class="pull-right">
    <?php  
    //print_r($isMyCase[0]);
    if(isset($isMyCase[0]->assign_to)){
        if(($isMyCase[0]->assign_to==$this->session->userdata('user_id') && IsRoleFriendlyNameExist($this->user_role, 'Social Stream_Current_Take Action'))){ ?> 
                <button type="button" class="btn btn-primary btn-reply"><i class="icon-mail-reply"></i></button>
           <?php if(($isMyCase[0]->status)!='solved'){?>
                <button type="button" class="btn btn-purple  btn-resolve" name="action" value="<?=$fb_feed[$i]->case_id?>"><i class="icon-check"></i> RESOLVE</button>
           <?php } 
           if(isset($isMyCase[0]->case_id)){ ?>
                <button type="button" class="btn btn-danger btn-case" name="action" value="case"><i class="icon-plus"></i> CASE</button>
           <?php }?>
                 
        </div>
        <br clear="all" />
    </h4>
    <?php }elseif((IsRoleFriendlyNameExist($this->user_role,'Social Stream_All_Resolve_Case'))){ ?>
        <button type="button" class="btn btn-primary btn-reply"><i class="icon-mail-reply"></i></button>
        <?php if(($isMyCase[0]->status)!='solved'):?>
        <button type="button" class="btn btn-purple  btn-resolve" name="action" value="<?=$fb_feed[$i]->case_id?>"><i class="icon-check"></i> RESOLVE</button>
        <?php endif?>        
        <button type="button" class="btn btn-danger btn-case" name="action" value="case"><i class="icon-plus"></i> CASE</button>   
        </div>
        <br clear="all" />
    </h4>
    <?php } 
    }else{ 
        ?>
            <?php if(!$fb_feed[$i]->case_id):
                if($isMyCase){ ?>                   
                 <?php }else{ ?>
                    <?php if(IsRoleFriendlyNameExist($this->user_role, 'Social Stream_Current_Take Action')):?>
                        <button type="button" class="btn btn-primary btn-reply"><i class="icon-mail-reply"></i></button>
                        <button type="button" class="btn btn-danger btn-case" name="action" value="case"><i class="icon-plus"></i> CASE</button>
                    <?php endif;?>
                <?php } 
                  else:?>
                
            <?php endif?>
        </div>
        <br clear="all" />
    </h4>        
    <?php 
    }
    ?>
    <!-- REPLY -->  
    <div class="reply-field hide">
    <?php
    $data['fb_feed'] = $fb_feed;
    $data['i'] = $i;
    $data['reply_type']='replaycontent';
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
<?php if(count($fb_feed) > 0 && (!isset($is_search))):?>
<div class="filled" style="text-align: center;"><input type="hidden" class="total_groups" value="<?php echo $total_groups?>" /><input type="hidden"  class="looppage" value=""/><input type="hidden"  class="channel_id" value="<?php echo $fb_feed[0]->channel_id?>"/><button class="loadmore btn btn-info" value="wallPosts"><i class="icon-chevron-down"></i>
 <span>LOAD MORE</span></button></div>
<?php endif;?>
