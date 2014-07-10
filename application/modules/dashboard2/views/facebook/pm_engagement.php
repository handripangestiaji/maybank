<?php  
    $timezone = new DateTimeZone($this->session->userdata('timezone'));
    for($j=0;$j < count($comment) ;$j++){
        if($comment[$j]->messages != '' || $comment[$j]->attachment != '' ):
?>
<div class="engagement-body">
            <span class="engagement-btn-hide-show btn-close pull-right"><i class="icon-caret-down"></i></span>    
            <p class="headLine">
                <span class="author"><?php echo $comment[$j]->name; ?></span>
                <i class="icon-circle"></i>
                <span>posted a <span class="cyanText">reply</span></span>
                <i class="icon-circle"></i>
                <span><?php
                $created_detail_pm = new DateTime($comment[$j]->created_at);
                $created_detail_pm->setTimezone($timezone);
                echo $created_detail_pm->format('l, M j, Y h:i A'); ?></span>
               
            </p>
            
            <div>
                  
                <?php
                $att_to_print = "";
                if($comment[$j]->attachment != ''):
                    $attachment = json_decode($comment[$j]->attachment);
                    $attachment = $attachment->data[0];
                    
                    if(isset($attachment->image_data)){
                        if(isset($attachment->image_data->url)){
                            $att_to_print = '<a href="#detail'.$comment[$j]->detail_id.'" data-toggle="modal" ><img src="'.base_url('dashboard/media_stream/SafePhoto?photo=').urlencode($attachment->image_data->url).'" style="width:60%;" /></a>';
                            $src = urlencode($attachment->image_data->url);
                        }
                        else{
                            $att_to_print = '<img src="'.base_url('dashboard/media_stream/SafePhoto?photo=').urlencode('https://www.facebook.com/ajax/messaging/attachment.php?attach_id='.$attachment->id.'&mid='.substr($comment[$j]->detail_id_from_facebook, 2).'&preview=1').'" style="width:60%;" />';
                            $src = urlencode('https://www.facebook.com/ajax/messaging/attachment.php?attach_id='.$attachment->id.'&mid='.substr($comment[$j]->detail_id_from_facebook, 2).'&preview=1');
                        }
                        
                        $att_to_print .= '<div id="detail'.$comment[$j]->detail_id.'" class="attachment-modal modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <img src="'.base_url('dashboard/media_stream/SafePhoto?photo=').$src.'" />
                            <button type="button" class="close " data-dismiss="modal"><i class="icon-remove"></i></button>
                        </div>';
                    }
                    else 
                        $att_to_print = '<a href="https://www.facebook.com/ajax/messaging/attachment.php?attach_id='.$attachment->id.'&mid='.substr($comment[$j]->detail_id_from_facebook, 2).'" target="_blank" style="font-size:16px;">ATTACHMENT</a>';
                
                    
                endif;?>
                <?php if($comment[$j]->messages != ""){?>
                    <p class="engagement-message"><?php echo CreateUrlFromText($comment[$j]->messages)?></p>
                <?php }?>
                <p><?=$att_to_print;?> </p>
              
            </div>
        </div>
<?php endif;
       }?>