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
                <?php 
                    if(isset($isMyCase[count($isMyCase)-1]->assign_to)){
                        if($isMyCase[count($isMyCase)-1]->assign_to==$this->session->userdata('user_id') or ($isMyCase[count($isMyCase)-1]->solved_by)){
                ?><h4>
                <p>
                    <?php if(IsRoleFriendlyNameExist($this->user_role, array('Social Stream_All_Delete','Social Stream_Current_Delete'))): ?>
                        <button type="button" role="button" class="btn btn-mini delete_post comments"  value="<?php echo $comment[$j]->comment_post_id?>" style="border: none; background-color: transparent;"><i class="icon-trash greyText"></i></button>
                    <?php endif;?>
                    <button type="button" class="btn btn-warning btn-mini">OPEN</button>
                    <button class="fblike btn btn-primary btn-mini" value="<?php echo $comment[$j]->post_stream_id?>"><?php echo $comment[$j]->user_likes == 1 ? "UNLIKE" : "LIKE"?></button>
                    <?php if(($comment[$j]->comment_id)=='0'):?>
                        <button type="button" class="btn btn-primary btn-engagement-reply btn-mini btn-reply" ><i class="icon-mail-reply"></i></button>
                    <?php endif; ?>
                   <!--button type="button" class="btn btn-danger btn-engagement-case btn-mini btn-case"><i class="icon-plus"></i> CASE</button-->
                </p></h4><!--222 assign to you-->
                <?php }else{ ?>
                <h4>
                <p>
                    <?php if(IsRoleFriendlyNameExist($this->user_role, array('Social Stream_All_Delete','Social Stream_Current_Delete'))):?>
                        <button type="button" role="button" class="btn btn-mini delete_post comments"  value="<?php echo $comment[$j]->comment_post_id?>" style="border: none; background-color: transparent;"><i class="icon-trash greyText"></i></button>
                    <?php endif;?>
            
                    <button type="button" class="btn btn-warning btn-mini">OPEN</button>
                    <button class="fblike btn btn-primary btn-mini" value="<?php echo $comment[$j]->post_stream_id?>"><?php echo $comment[$j]->user_likes == 1 ? "UNLIKE" : "LIKE"?></button>
                    <?php if(($comment[$j]->comment_id)=='0'){?>
                    <button type="button" class="btn btn-primary btn-engagement-reply btn-mini btn-reply" ><i class="icon-mail-reply"></i></button>
                    <?php } ?>
                    <!--button type="button" class="btn btn-danger btn-engagement-case btn-mini btn-case" name="action" value="case"><i class="icon-plus"></i> CASE</button-->
                </p>
                </h4> <!--case to others sads3333sad;-->
                <?php } 
                }elseif(!isset($isMyCase[count($isMyCase)-1])){ ?>
                <h4>
                    <p>
                    <?php if(IsRoleFriendlyNameExist($this->user_role, array('Social Stream_All_Delete','Social Stream_Current_Delete'))):?>
                        <button type="button" role="button" class="btn btn-mini delete_post comments"  value="<?php echo $comment[$j]->comment_post_id?>" style="border: none; background-color: transparent;"><i class="icon-trash greyText"></i></button>
                    <?php endif;?>
                    <button type="button" class="btn btn-warning btn-mini">OPEN</button>
                    <button class="fblike btn btn-primary btn-mini" value="<?php echo $comment[$j]->post_stream_id?>"><?php echo $comment[$j]->user_likes == 1 ? "UNLIKE" : "LIKE"?></button>
                    <?php if(($comment[$j]->comment_id)=='0'){?>
                    <button type="button" class="btn btn-primary btn-engagement-reply btn-mini btn-reply" ><i class="icon-mail-reply"></i></button>
                    <?php } ?>
                   <!--button type="button" class="btn btn-danger btn-engagement-case btn-mini btn-case" name="action" value="case"><i class="icon-plus"></i> CASE</button-->
                </p><!--not yet case 44-->
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