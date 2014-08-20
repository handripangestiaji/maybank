<?php

$timezone=new DateTimeZone($this->session->userdata('timezone'));
for($i=0;$i<count($senttweets);$i++){
?>
    <li id="post<?=$senttweets[$i]->social_stream_post_id?>">
        <input type="hidden" class="postId" value="<?php echo $senttweets[$i]->social_stream_post_id; ?>" />
        <div class="circleAvatar"><img src="<?php echo base_url('dashboard/media_stream/SafePhoto?photo=').$senttweets[$i]->profile_image_url;?>" alt=""></div>
        <div class="read-mark <?php if($senttweets[$i]->is_read==0){echo 'redText';} else { echo 'greyText'; } ?>"><i class="icon-bookmark icon-large"></i></div>
        <br />
        <p class="headLine">
            <span class="author"><?php echo $senttweets[$i]->screen_name; ?></span>
            <i class="icon-circle"></i>
            <span>Sent Tweets</span>
            <i class="icon-circle"></i>
            <span><?php 
            $date=new DateTime($senttweets[$i]->social_stream_created_at.' UTC');
            $date->setTimezone($timezone);
            echo $date->format('l, M j, Y h:i A');
            $entities = json_decode($senttweets[$i]->twitter_entities);?></span>
        </p>
        <p>
            <?php
                $senttweets[$i]->text = str_replace("\n", "<br />", $senttweets[$i]->text);
                $html = html_entity_decode($senttweets[$i]->text);
                
                
                $html =  linkify(html_entity_decode($html), true, false);
                echo $html;
            ?>
        </p>
        <p>
            <?php if(isset($entities->media[0])){
                    echo "<a href='#modal-".$senttweets[$i]->post_id."' data-toggle='modal' ><img class='img_attachment' src='".base_url('dashboard/media_stream/SafePhoto?photo=').$entities->media[0]->media_url_https."' /></a>";
                    echo '<div id="modal-'.$senttweets[$i]->post_id.'" class="attachment-modal modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
                                    <img src="'.base_url('dashboard/media_stream/SafePhoto?photo=').$entities->media[0]->media_url_https.'" />
                                    <button type="button" class="close " data-dismiss="modal"><i class="icon-remove"></i></button>
                        </div>';
                    }
            ?>
        </p>
        <!--p><button type="button" class="btn btn-warning btn-mini">OPEN</button-->
        
     
        
        <h4 class="filled">
            <?php if(IsRoleFriendlyNameExist($this->user_role,array('Social Stream_Channel_General_Function_Own_Country_Delete',
                                                                    'Social Stream_Channel_General_Function_All_Country_Delete'))):?>
                <a role="button" class='destroy_status'><i class="icon-trash greyText"></i></a>
            <?php endif;?>
            <div class="pull-right">
                <?php
                    $data = array(
                        'come_from' => "user_timeline",
                        'post' => $senttweets[$i]
                    );
                    $this->load->view('dashboard2/twitter/twitter_button', $data);
                ?>
            </div>
            <br clear="all" />
        </h4>
        
        <!-- REPLY -->  
        
    </li>
<?php } ?>
<?php if((count($senttweets) > 0) && (!isset($is_search))): ?>
 <div class="filled" style="text-align: center;">
    <input type="hidden"  class="channel_id" value="<?php echo $senttweets[0]->channel_id?>"/>
    <button class="loadmore btn btn-info" value="user_timeline">
 
 
 <i class="icon-chevron-down"></i> <span>LOAD MORE</span></button></div>
<?php endif?>
