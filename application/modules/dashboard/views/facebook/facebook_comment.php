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
                $attachment=json_decode($comment[$j]->attachment);
                if(isset($attachment->media->image->src)){
                for($att=0;$att<count($attachment);$att++){
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
                <p>"<?php echo RemoveUrlWithin($comment[$j]->comment_content); ?>"</p>
                
                <p>
                    <?php if(IsRoleFriendlyNameExist($this->user_role, array('Social Stream_All_Delete','Social Stream_Current_Delete'))): ?>
                        <button type="button" role="button" class="btn btn-mini delete_post comments"  value="<?php echo $comment[$j]->comment_post_id?>" style="border: none; background-color: transparent;"><i class="icon-trash greyText"></i></button>
                    <?php endif;?>
                    <!--button type="button" class="btn btn-warning btn-mini">OPEN</button-->
                    <?php if(IsRoleFriendlyNameExist($this->user_role, array('Social Stream_Facebook_Own_Country_LikeUnlike','Social Stream_Facebook_All_Country_LikeUnlike'))):?>
                    <button class="fblike btn btn-primary btn-mini" value="<?php echo $comment[$j]->post_stream_id?>"><?php echo $comment[$j]->user_likes == 1 ? "UNLIKE" : "LIKE"?></button>
                    <?php endif;?>
                    <?php if(IsRoleFriendlyNameExist($this->user_role, array('Social Stream_Facebook_Own_Country_LikeUnlike','Social Stream_Facebook_All_Country_LikeUnlike'))):?>
                        <?php if(($comment[$j]->comment_id)=='0'):?>
                            <button type="button" class="btn btn-primary btn-engagement-reply btn-mini btn-reply" ><i class="icon-mail-reply"></i></button>
                        <?php endif; ?>
                    <?php endif;?>
                </p></h4>
                
                <div class="fb-reply-engagement-field reply-field hide">
                    <?php
                    $data['fb_feed'] = $comment;
                    $data['i'] = $j;
                    $data['reply_type']='reply_nested';
                    $this->load->view('dashboard/reply_field_facebook', $data)?>  
                </div>
                 <div class="case-field hide">
                </div>                
            </div>
        </div>