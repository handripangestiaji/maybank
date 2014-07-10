<?php
//print_r($fb_feed);
$total_groups = ceil($count_fb_feed[0]->count_post_id/$this->config->item('item_perpage'));
$timezone=new DateTimeZone($this->session->userdata('timezone'));

for($i=0; $i<count($fb_feed);$i++):
$isMyCase=$this->case_model->chackAssignCase(array('a.post_id' => $fb_feed[$i]->post_id, 'a.status <>'=>'reassign'));
$attachment = json_decode($fb_feed[$i]->attachment);

if($fb_feed[$i]->post_content != '<br />' || isset($attachment->media)):

?>
<li  id="post<?=$fb_feed[$i]->social_stream_post_id?>">
    <input type="hidden" class="postId" value="<?php echo $fb_feed[$i]->post_id; ?>" />
    <input type="hidden" name="user_id" value="<?php echo $this->session->userdata('user_id'); ?>" />
    <input type="hidden" name="facebook_user" value="<?php echo $fb_feed[$i]->facebook_id; ?>" />
    <div class="circleAvatar"><img src="<?php echo base_url('dashboard/media_stream/SafePhoto?photo=')."https://graph.facebook.com/".number_format($fb_feed[$i]->facebook_id, 0,'.','')?>/picture?small" alt=""></div>
    <?php if (IsRoleFriendlyNameExist($this->user_role, array('Social Stream_Channel_General_Function_Own_Country_Reply',
                                                              'Social Stream_Channel_General_Function_All_Country_Reply'))):?>
        <div class="read-mark <?php echo $fb_feed[$i]->is_read==0 ? 'redText' : 'greyText'?>"><i class="icon-bookmark icon-large"></i></div>
    <?php endif ?>
    <br />
    <p class="headLine">
        <span class="author"><?php echo $fb_feed[$i]->name?></span>
        <i class="icon-circle"></i>
        <span>posted a <span class="cyanText">new post</span></span>
        <i class="icon-circle"></i>
        <span>
        <?php 
            $date=new DateTime($fb_feed[$i]->post_date.' UTC');
            $date->setTimezone($timezone);
            echo $date->format('l, M j, Y h:i A');
        ?>        
    </p>
    <p class="post-content"><?php echo CreateUrlFromText($fb_feed[$i]->post_content)?></p>
    <p>
    <?php
    if($fb_feed[$i]->attachment){ 
        $attachment=json_decode($fb_feed[$i]->attachment);
        $attachment = isset($attachment->media) ? $attachment->media: null;
        for($att=0;$att<count($attachment);$att++){
           if($attachment[$att]->type=='photo'){
                
                if(isset($attachment[$att]->photo->images[1])){
                    $src = $attachment[$att]->photo->images[1]->src;
                }
                else{
                    $src = $attachment[$att]->src;
                }
                echo    "<a href='#modal-".$fb_feed[$i]->post_id."-".$attachment[$att]->type."' data-toggle='modal' ><img class='img_attachment' src='".base_url('dashboard/media_stream/SafePhoto?photo=').$src."' /></a>";
                echo    '<div id="modal-'.$fb_feed[$i]->post_id.'-'.$attachment[$att]->type.'" class="attachment-modal modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <img src="'.base_url('dashboard/media_stream/SafePhoto?photo=').$src.'" />
                            <button type="button" class="close " data-dismiss="modal"><i class="icon-remove"></i></button>
                        </div>';
                break;
           }elseif($attachment[$att]->type=='link'){              
                $attachment = json_decode($fb_feed[$i]->attachment)?>
            
            <div class="compose-schedule" style="width: 85%;margin:10px auto;" >
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
        <?php $this->load->view('facebook/facebook_indicator', array('post'=>$fb_feed[$i]))?>
        <?php if(IsRoleFriendlyNameExist($this->user_role, array('Social Stream_Facebook_All_Country_LikeUnlike',
                                                              'Social Stream_Facebook_All_Country_LikeUnlike'))):?>        
        <button class="fblike btn btn-primary btn-mini" style="margin-left: 5px;" value="<?php echo $fb_feed[$i]->post_stream_id;?>"><?php echo $fb_feed[$i]->user_likes == 1 ? "UNLIKE" : "LIKE"?></button>
        <?php endif;?>                                                              
    </p>    
    <p>
        <span class="btn-engagement" title="comments"><i class="icon-eye-open"></i> <?php echo $fb_feed[$i]->total_comments;?> Engagements</span> |
        <span class="cyanText"><i class="icon-thumbs-up-alt"></i></i> <?php echo $fb_feed[$i]->total_likes; ?> likes</span> 
    </p>


    <!-- ENGAGEMENT -->    
    <div class="engagement hide">
        <div class="engagement-header">
            <span class="engagement-btn-close btn-close pull-right">Close <i class="icon-remove-sign"></i></span>
        </div>
        <br />
        <div class="engagement-list">
            <img class="loading" src="<?=base_url()?>media/img/loader.gif" alt="loading..." style="margin:10px 0 10px 40%;width: 48px;" />
            
        </div>
       <!-- ==================== CONDENSED TABLE HEADLINE ==================== -->
       <?php $unique_id = uniqid(); ?>
        <div href='#modal-action-log-<?php echo $fb_feed[$i]->post_stream_id.$unique_id ?>' data-toggle='modal' class="containerHeadline specialToggleTable">
            <i class="icon-table"></i><h2>Action Log</h2>
        </div>
       <!-- ==================== END OF CONDENSED TABLE HEADLINE ==================== -->

        <!-- ==================== CONDENSED TABLE FLOATING BOX ==================== -->
        
            <?php
                if(IsRoleFriendlyNameExist($this->user_role, array('Social Stream_Channel_General_Function_Own_Country_View',
                                                              'Social Stream_Channel_General_Function_All_Country_View')))
                {
                    $data_loaded['post'] = $fb_feed[$i];
                    $data_loaded['unique_id'] = $unique_id;
                    $this->load->view('dashboard/action_taken', $data_loaded);
                }
            ?>
        <!-- ==================== END OF CONDENSED TABLE FLOATING BOX ==================== --> 
    </div>
    <!-- END ENGAGEMENT -->

    <h4 class="filled">
        
            <?php if(IsRoleFriendlyNameExist($this->user_role, 'Social Stream_Channel_General_Function_Own_Country_Delete') ||
                     IsRoleFriendlyNameExist($this->user_role, 'Social Stream_Channel_General_Function_All_Country_Delete')
                     ):?>
                <a role="button" class='delete_post wall'><i class="icon-trash greyText"></i></a>
            <?php endif;?>
        <div class="pull-right">
            <?php $this->load->view('facebook_button', array('post'=> $fb_feed[$i], 'reply_type'=>'replaycontent'));?>
        </div>
        <br clear="all" />
    </h4> 
    <!-- REPLY -->  
    <div class="reply-field hide">

    </div>
    <!-- END REPLY -->
    
    <!-- CASE -->
    <div class="case-field hide">
    <?php
        $data['posts'] = $fb_feed;        
        $data['i'] = $i;
        //$this->load->view('dashboard/case_field',$data);
    ?>
    </div>
    <!-- END CASE -->  
</li>
<?php endif;
endfor;?>
<?php if(count($fb_feed) > 0 && (!isset($is_search)) && !isset($no_load_more)):?>
<div class="filled" style="text-align: center;"><input type="hidden" class="total_groups" value="<?php echo $total_groups?>" /><input type="hidden"  class="looppage" value=""/><input type="hidden"  class="channel_id" value="<?php echo $fb_feed[0]->channel_id?>"/><button class="loadmore btn btn-info" value="wallPosts"><i class="icon-chevron-down"></i>
 <span>LOAD MORE</span></button></div>
<?php endif;?>
