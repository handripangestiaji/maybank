<?php
//print_r($fb_feed);
$total_groups = ceil($count_fb_feed[0]->count_post_id/$this->config->item('item_perpage'));
$timezone=new DateTimeZone($this->session->userdata('timezone'));

for($i=0; $i<count($fb_feed);$i++):
$isMyCase=$this->case_model->chackAssignCase(array('a.post_id' => $fb_feed[$i]->post_id, 'a.status <>'=>'reassign'));
if($fb_feed[$i]->post_content != '<br />'):

?>
<li class="<?php if(isset($isMyCase[0]->assign_to)){echo "case_".$isMyCase[0]->case_id;} ?>" id="post<?=$fb_feed[$i]->social_stream_post_id?>">
    <input type="hidden" class="postId" value="<?php echo $fb_feed[$i]->post_id; ?>" />
    <input type="hidden" name="user_id" value="<?php echo $this->session->userdata('user_id'); ?>" />
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
    <p class="post-content"><?php echo RemoveUrlWithin($fb_feed[$i]->post_content)?></p>
    <p>
    <?php
    if($fb_feed[$i]->attachment){ 
        $attachment=json_decode($fb_feed[$i]->attachment);
        $attachment = isset($attachment->media) ? $attachment->media: null;
        //print_r($attachment);
        for($att=0;$att<count($attachment);$att++){
           if($attachment[$att]->type=='photo'){
            
                $src = substr($attachment[$att]->src, 0, strlen($attachment[$att]->src) - 5)."n.jpg";
                echo    "<a href='#modal-".$fb_feed[$i]->post_id."-".$attachment[$att]->type."' data-toggle='modal' ><img class='img_attachment' src='".base_url('dashboard/media_stream/SafePhoto?photo=').$src."' /></a>";
                echo    '<div id="modal-'.$fb_feed[$i]->post_id.'-'.$attachment[$att]->type.'" class="attachment-modal modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <img src="'.base_url('dashboard/media_stream/SafePhoto?photo=').$src.'" />
                            <button type="button" class="close " data-dismiss="modal"><i class="icon-remove"></i></button>
                        </div>';
           }elseif($attachment[$att]->type=='link'){              
                $attachment = json_decode($fb_feed[$i]->attachment)?>
            <center>
            <div class="compose-schedule" style="width: 85%;" >
                <div class="compose-form img-attached link" onclick="window.open('<?=$attachment->media[$att]->href?>')">
                    <!-- close button for image attached -->
                    <div style="">
                        <div style="float: left;min-height:120px; border-right: 1px solid  #ccc; width:30%;" >
                            <?php echo '<img class="link-preview-image" src="'.$attachment->media[$att]->src.'" style="display:block;width:auto;"/>';?>
                        </div>
                        <!-- img-place end -->
                        <div class="link-description">
                        <p style="text-transform: capitalize;font-size:14px;margin: 5px 0"><?=$attachment->name?></p>
                        <p class="description"><?php echo "<a href='".$attachment->media[$att]->href."'>".$attachment->media[$att]->href."</a>"; ?></p>
                        <p><?php echo $attachment->description?></p>
                        </div>
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
          // print_r($isMyCase[count($isMyCase)-1]);
          $case=new DateTime($isMyCase[count($isMyCase)-1]->solved_at.' Europe/London');
          $case->setTimezone($timezone);
            
            if($isMyCase[count($isMyCase)-1]->assign_to==$this->session->userdata('user_id') or ($isMyCase[count($isMyCase)-1]->solved_by)){ ?>
            <button  href="#caseItem-<?php echo isset($isMyCase[count($isMyCase)-1]->case_id) ? $isMyCase[count($isMyCase)-1]->case_id : "" ?>" data-toggle="modal" type="button" value="<?php echo $isMyCase[count($isMyCase)-1]->case_id?>" class="btn <?php echo $fb_feed[$i]->case_id != null ? "btn-purple btn-mini case_related ".$fb_feed[$i]->social_stream_type : "btn-inverse btn-mini" ?>"><?php echo $fb_feed[$i]->case_id != null ? 'Case #'.$fb_feed[$i]->case_id.' Assign to You ' : 'Case #'.$isMyCase[count($isMyCase)-1]->case_id.' | '.'Resolve By:'.$isMyCase[count($isMyCase)-1]->resolve_by.' | '.$case->format('j-M-Y h:i A')?></button><?php
            
            $assignCase=$this->case_model->CaseRelatedConversationItems(array('case_id'=>$isMyCase[count($isMyCase)-1]->case_id));
            $data['isMyCase'] = $assignCase;
            $data['caseMsg']=$isMyCase[count($isMyCase)-1];
            $data['assign_case_type']='facebook';
            $this->load->view('dashboard/case_item', $data);
            
         }else{ ?>
            <button type="button" class="btn <?php echo $fb_feed[$i]->case_id != null ? "btn-purple btn-mini" : "btn-inverse btn-mini" ?>">
                <?php echo $fb_feed[$i]->case_id != null ? 'Case #'.$fb_feed[$i]->case_id.' Assign to: '.$isMyCase[count($isMyCase)-1]->full_name : 'Replied'?>
            </button>  
        <?php }
    }
        ?>
        </p>
        <p>
        <?php
       // print_r($fb_feed[$i]->reply_post[0]);
        if(isset($fb_feed[$i]->reply_post[0])){
         if(isset($fb_feed[$i]->is_my_reply[0])){?>
        <button type="button" class="btn btn-inverse btn-mini" value="<?php echo $fb_feed[$i]->reply_post[0]->post_id?>">
        <?php
        $reply_date = new DateTime($fb_feed[$i]->channel_action[count($fb_feed[$i]->channel_action) - 1]->created_at);
        $reply_date->setTimezone($timezone);
        echo "Replied by: ".$fb_feed[$i]->channel_action[count($fb_feed[$i]->channel_action) - 1]->username." ".$reply_date->format("d-M-y h:i A") ?>
        </button> <?php            
        }else{?>
        <button type="button" class="btn btn-warning btn-mini no-cursor indicator" >OPEN</button>       
         <?php }         
        }else{?>
        <button type="button" class="btn btn-warning btn-mini no-cursor indicator" >OPEN</button>       
        <?php }    
        if(IsRoleFriendlyNameExist($this->user_role,'Social Stream_Current_Social Functions Like, Retweet')):?>
        <button class="fblike btn btn-primary btn-mini" style="margin-left: 5px;" value="<?php echo $fb_feed[$i]->post_stream_id;?>"><?php echo $fb_feed[$i]->user_likes == 1 ? "UNLIK" : "LIKE"?></button> 
        <?php endif ?>
    </p>    
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
        <div class="engagement-body" <?php if($comment[$j]->comment_id!='0'){ ?> style="padding-left: 45px;" <?php } ?>>
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
                
              ?></span></p>
            <p>
              <?php
//              echo "<pre>";
//              print_r($comment[$j]);
//              echo "</pre>";
                $attachment=json_decode($comment[$j]->attachment);
                if(isset($attachment->media->image->src)){
                for($att=0;$att<count($attachment);$att++){
                    echo    "<a href='#modal_comments-".$comment[$j]->comment_post_id."' data-toggle='modal' ><img class='img_attachment' src='".base_url('dashboard/media_stream/SafePhoto?photo=').$attachment->media->image->src."' /></a>";
                    echo    '<div id="modal_comments-'.$comment[$j]->comment_post_id.'" class="attachment-modal modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <img src="'.base_url('dashboard/media_stream/SafePhoto?photo=').$attachment->media->image->src.'" />
                            <button type="button" class="close " data-dismiss="modal"><i class="icon-remove"></i></button>
                        </div>';
                    //print_r($comment[$j]);
                    //echo    "<img src='".base_url('dashboard/media_stream/SafePhoto?photo=').$attachment->media->image->src."' />";
                }
             }           
              ?>
            </p> 
            
            <div class="engagement-comment">
                <p>"<?php echo RemoveUrlWithin($comment[$j]->comment_content); ?>"</p>
                
                <?php 
                    if(isset($isMyCase[count($isMyCase)-1]->assign_to)){
                        if($isMyCase[count($isMyCase)-1]->assign_to==$this->session->userdata('user_id') or ($isMyCase[count($isMyCase)-1]->solved_by)){
                ?>
                <p>
                    <?php if(IsRoleFriendlyNameExist($this->user_role, 'Social Stream_All_Take Action')):?>
                        <button type="button" role="button" class="btn btn-mini delete_post comments"  value="<?php echo $comment[$j]->comment_post_id?>" style="border: none; background-color: transparent;"><i class="icon-trash greyText"></i></button>
                    <?php endif;?>
            
                    <button type="button" class="btn btn-warning btn-mini">OPEN</button>
                    <button class="fblike btn btn-primary btn-mini" value="<?php echo $comment[$j]->post_stream_id?>"><?php echo $comment[$j]->user_likes == 1 ? "UNLIKE" : "LIKE"?></button>
                    <?php if(($comment[$j]->comment_id)=='0'){?>
                    <button type="button" class="btn btn-primary btn-engagement-reply btn-mini" ><i class="icon-mail-reply"></i></button>
                    <?php } ?>
                   <!--button type="button" class="btn btn-danger btn-engagement-case btn-mini"><i class="icon-plus"></i> CASE</button-->
                </p><!--222-->
                <?php }else{ ?>
                <p>
                    <?php if(IsRoleFriendlyNameExist($this->user_role, 'Social Stream_All_Take Action')):?>
                        <button type="button" role="button" class="btn btn-mini delete_post comments"  value="<?php echo $comment[$j]->comment_post_id?>" style="border: none; background-color: transparent;"><i class="icon-trash greyText"></i></button>
                    <?php endif;?>
            
                    <button type="button" class="btn btn-warning btn-mini">OPEN</button>
                    <button class="fblike btn btn-primary btn-mini" value="<?php echo $comment[$j]->post_stream_id?>"><?php echo $comment[$j]->user_likes == 1 ? "UNLIKE" : "LIKE"?></button>
                    <?php if(($comment[$j]->comment_id)=='0'){?>
                    <button type="button" class="btn btn-primary btn-engagement-reply btn-mini" ><i class="icon-mail-reply"></i></button>
                    <?php } ?>
                   <!--button type="button" class="btn btn-danger btn-engagement-case btn-mini"><i class="icon-plus"></i> CASE</button-->
                </p> <!--sads3333sad;-->
                <?php } 
                }elseif(!isset($isMyCase[count($isMyCase)-1])){ ?>
                <h4>
                    <p>
                    <?php if(IsRoleFriendlyNameExist($this->user_role, 'Social Stream_All_Take Action')):?>
                        <button type="button" role="button" class="btn btn-mini delete_post comments"  value="<?php echo $comment[$j]->comment_post_id?>" style="border: none; background-color: transparent;"><i class="icon-trash greyText"></i></button>
                    <?php endif;?>
                    <button type="button" class="btn btn-warning btn-mini">OPEN</button>
                    <button class="fblike btn btn-primary btn-mini" value="<?php echo $comment[$j]->post_stream_id?>"><?php echo $comment[$j]->user_likes == 1 ? "UNLIKE" : "LIKE"?></button>
                    <?php if(($comment[$j]->comment_id)=='0'){?>
                    <button type="button" class="btn btn-primary btn-engagement-reply btn-mini btn-reply" ><i class="icon-mail-reply"></i></button>
                    <?php } ?>
                   <!--button type="button" class="btn btn-danger btn-engagement-case btn-mini btn-case" name="action" value="case"><i class="icon-plus"></i> CASE</button-->
                </p><!--44-->
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
                <?php
                    /*$data['posts'] = $comment;
                    $data['posts'] = $fb_feed;
                    $data['i'] = $j;
                    $this->load->view('dashboard/case_field',$data);*/
                ?>
                </div>                
            </div>
        </div>
       <?php endfor; ?>
       <!-- ==================== CONDENSED TABLE HEADLINE ==================== -->
        <div href='#modal-action-log-<?php echo $fb_feed[$i]->post_stream_id ?>' data-toggle='modal' class="containerHeadline specialToggleTable">
            <i class="icon-table"></i><h2>Action Log</h2>
        </div>
       <!-- ==================== END OF CONDENSED TABLE HEADLINE ==================== -->

        <!-- ==================== CONDENSED TABLE FLOATING BOX ==================== -->
        
            <?php
                if(IsRoleFriendlyNameExist($this->user_role, 'Social Stream_Current_Take Action'))
                {
                    $data_loaded['post'] = $fb_feed[$i];
                    $this->load->view('dashboard/action_taken', $data_loaded);
                }
            ?>
        <!-- ==================== END OF CONDENSED TABLE FLOATING BOX ==================== --> 
    </div>
    <!-- END ENGAGEMENT -->

    <h4 class="filled">
        <!--di nonaktifin dulu, karena belum di butuhkan-->
            <?php if(IsRoleFriendlyNameExist($this->user_role, 'Social Stream_All_Take Action')):?>
                <a role="button" class='delete_post wall'><i class="icon-trash greyText"></i></a>
                <!--a style="font-size: 20px; cursor: pointer;"><i class="icon-trash greyText deleteFB"></i></a-->
            <?php endif;?>
        <div class="pull-right">
    <?php  
    //echo(count($isMyCase));
    //print_r($isMyCase[0]);
    //case
    if(isset($isMyCase[count($isMyCase)-1]->assign_to)){
       // print_r($isMyCase[count($isMyCase)-1]);
        if(($isMyCase[count($isMyCase)-1]->assign_to==$this->session->userdata('user_id') && IsRoleFriendlyNameExist($this->user_role, 'Social Stream_Current_Take Action'))){ ?> 
                <button type="button" class="btn btn-primary btn-reply"><i class="icon-mail-reply"></i></button>
           <?php if($isMyCase[count($isMyCase)-1]->status=='pending'){ ?>
                <button type="button" class="btn btn-purple  btn-resolve_fb" name="action" value="<?=$fb_feed[$i]->case_id?>"><i class="icon-check"></i> RESOLVE</button>
                <button type="button" class="btn btn-danger btn-case" name="action" value="case"><i class="icon-plus"></i> ReAssign</button>  
           <?php }else{ ?> 
              <button type="button" class="btn btn-danger btn-case" name="action" value="case"><i class="icon-plus"></i> CASE</button>
           <?php   } ?>
        </div>
        <br clear="all" />
    </h4>
    <?php }elseif((IsRoleFriendlyNameExist($this->user_role,'Social Stream_All_Resolve_Case'))){ ?>
        <button type="button" class="btn btn-primary btn-reply"><i class="icon-mail-reply"></i></button>
        <?php if($isMyCase[count($isMyCase)-1]->status=='pending'):?>
            <button type="button" class="btn btn-purple  btn-resolve_fb" name="action" value="<?=$fb_feed[$i]->case_id?>"><i class="icon-check"></i> RESOLVE</button>
            <button type="button" class="btn btn-danger btn-case" name="action" value="case"><i class="icon-plus"></i> ReAssign</button>   
        <?php else:?>
            <button type="button" class="btn btn-danger btn-case" name="action" value="case"><i class="icon-plus"></i> CASE</button>   
        <?php endif?>
        </div><!--ASDAS-->
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
        $data['posts'] = $fb_feed;        $data['i'] = $i;
        $this->load->view('dashboard/case_field',$data);
    ?>
    </div>
    <!-- END CASE -->  
</li>
<?php endif;
endfor;?>
<?php if(count($fb_feed) > 0 && (!isset($is_search))):?>
<div class="filled" style="text-align: center;"><input type="hidden" class="total_groups" value="<?php echo $total_groups?>" /><input type="hidden"  class="looppage" value=""/><input type="hidden"  class="channel_id" value="<?php echo $fb_feed[0]->channel_id?>"/><button class="loadmore btn btn-info" value="wallPosts"><i class="icon-chevron-down"></i>
 <span>LOAD MORE</span></button></div>
<?php endif;?>
