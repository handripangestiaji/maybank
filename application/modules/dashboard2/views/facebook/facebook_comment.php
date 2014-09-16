<?php
$timezone = new DateTimeZone($this->session->userdata('timezone'));
for($j=0; $j<count($comment); $j++):
$comment[$j]->case = !isset($comment[$j]->case) ? null: $comment[$j]->case;
?>    

<div class="engagement-body" <?php if($comment[$j]->comment_id != '0'){ ?> style="padding-left: 45px;" <?php } ?>>
        <span class="engagement-btn-hide-show btn-close pull-right"><i class="icon-caret-down"></i></span>    
        <p class="headLine">
            <span class="author"><?php echo $comment[$j]->name; ?></span>
            <i class="icon-circle"></i>
            <span>posted a <span class="cyanText">comment</span></span>
            <i class="icon-circle"></i>
            <span><?php 
            $date=new DateTime($comment[$j]->created_at.' UTC');
            $date->setTimezone($timezone);
            echo $date->format('l, M j, Y h:i A');
            
          ?></span></p>
        <p>
          <?php
            $attachment=json_decode($comment[$j]->attachment);
            if(isset($attachment->media->image->src)){
                if($attachment->type == "photo"){
                    echo    "<a href='#modal_comments-".$comment[$j]->comment_post_id."' data-toggle='modal' ><img class='img_attachment' src='".base_url('dashboard/media_stream/SafePhoto?photo=').$attachment->media->image->src."' /></a>";
                    echo    '<div id="modal_comments-'.$comment[$j]->comment_post_id.'" class="attachment-modal modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
                        <img src="'.base_url('dashboard/media_stream/SafePhoto?photo=').$attachment->media->image->src.'" />
                        <button type="button" class="close " data-dismiss="modal"><i class="icon-remove"></i></button>
                    </div>';    
                }
            }           
          ?>
        </p> 
        
        <div class="engagement-comment">
            <p><?php echo CreateUrlFromText($comment[$j]->comment_content); ?></p>
                <?php
                        $loop = true;
                        $last_reply = null;
                        for($x=$j+1;$x<count($comment);$x++){
                                if($comment[$x]->comment_id == 0){
                                        break;
                                }
                                if($comment[$x]->page_reply_id){
                                        $last_reply = $comment[$x];
                                }
                        }
                ?>
                <p><?php echo $this->load->view('facebook/facebook_reply_indicator', array('comment' => $comment[$j],'last_reply' => $last_reply)) ?></p>
            <p>
                <?php if(IsRoleFriendlyNameExist($this->user_role, 'Social Stream_Channel_General_Function_Own_Country_Delete') ||
                 IsRoleFriendlyNameExist($this->user_role, 'Social Stream_Channel_General_Function_All_Country_Delete')
                 ):?>
                    <button type="button" role="button" class="btn btn-mini delete_post comments"  value="<?php echo $comment[$j]->comment_post_id?>" style="border: none; background-color: transparent;"><i class="icon-trash greyText"></i></button>
                <?php endif;?>
                <?php if(IsRoleFriendlyNameExist($this->user_role, array('Social Stream_Facebook_Own_Country_LikeUnlike','Social Stream_Facebook_All_Country_LikeUnlike'))):?>
                <button class="fblike btn btn-primary btn-mini" value="<?php echo $comment[$j]->post_stream_id?>"><?php echo $comment[$j]->user_likes == 1 ? "UNLIKE" : "LIKE"?></button>
                <?php endif;?>
                <?php if(IsRoleFriendlyNameExist($this->user_role, array('Social Stream_Facebook_Own_Country_LikeUnlike','Social Stream_Facebook_All_Country_LikeUnlike'))):?>
                    <?php if(($comment[$j]->comment_id)=='0'):?>
                        <button type="button" class="btn btn-primary btn-engagement-reply btn-mini btn-reply nested_reply" ><i class="icon-mail-reply"></i></button>
                    <?php endif; ?>
                <?php endif;?>
            </p></h4>
            
            <div class="fb-reply-engagement-field reply-field hide">
                <?php
                $data['fb_feed'] = $comment;
                $data['i'] = $j;
                $data['reply_type']='reply_nested';
                $data['product_list'] = $product_list;
                $this->load->view('dashboard2/reply_field_facebook', $data)?>  
            </div>
             <div class="case-field hide">
            </div>                
        </div>
    </div>
<?php endfor?>