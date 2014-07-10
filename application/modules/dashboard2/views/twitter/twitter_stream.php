<?php
    $count_unread_mentions = 0;
    if($mentions){
        foreach($mentions as $m){
            if($m->is_read == 0){        
                $count_unread_mentions++;
            }
        }
    }
    
    $count_unread_homefeed = 0;
    if($homefeed){
        foreach($homefeed as $h){
            if($h->is_read == 0){        
                $count_unread_homefeed++;
            }
        }
    }
    //print_r($mentions);
    $count_unread_dm = 0;
    if($directmessage){
        foreach($directmessage as $dm){
            if($dm->is_read == 0){        
                $count_unread_dm++;
            }
        }
    }
    //print_r($directmessage);
?>
<script type="text/javascript">
			    $(document).ready(function() {
			      
				 $('.multipleSelect').multiselect({
                    buttonText: function(options, select) {
                    if (options.length == 0) {
                        return 'TAG Short-URL <b class="caret"></b>';
                    }
                    else if (options.length > 1) {
                        return options.length + ' selected <b class="caret"></b>';
                    }
                    else {
                        var selected = '';
                        options.each(function() {
                            selected += $(this).text() + ', ';
                        });
                        return selected.substr(0, selected.length -2) + ' <b class="caret"></b>';
                    }
                },
                });
                $('.multipleSelect').siblings('.btn-group').find('button').attr('disabled','disabled');

                    
			    });
			</script>
<input type="hidden" class="channel-id" value="<?php if(count($mentions) > 0) {echo $mentions[0]->channel_id;} else {echo $channel_id;} ?>">
<div id='ctwitter_<?=$channel_id?>' class="container-fluid" style="height: 95%">
<!-- ==================== ACTIVITIES MENU ==================== -->
<div class="floatingBoxMenu">
    <ul class="nav stream_head">
        <li class="active">
            <a class='mentions'>
                Mentions
                <span class="notifyCircle red
                <?php if($count_unread_mentions==0 || isset($is_search)) echo 'hide';?>"><?php echo $count_unread_mentions?></span>
                <?php if(isset($is_search) && count($mentions)!=0) {echo '<span class="notifyCircle cyan">'.count($mentions).'</span>';}?>
            </a></li>
        <li><a class='feed'>Homefeed<!--span class="notifyCircle red
        <?php if($count_unread_homefeed==0 || isset($is_search)) echo 'hide';?>"><?php echo $count_unread_homefeed ?></span>
        <?php if(isset($is_search) && count($homefeed)!=0){echo '<span class="cyan">'.count($homefeed).'</span>';}?>-->
        </a></li>
        <li><a class='sendmessage'>Tweets
        <?php if(isset($is_search) && count($senttweets)!=0){echo '<span class="notifyCircle cyan">'.count($senttweets).'</span>';}?>
        </a></li>
        <li><a class='direct'>Direct Message <span class="notifyCircle red
        <?php if($count_unread_dm==0 || isset($is_search)) echo 'hide';?>"><?php echo $count_unread_dm?></span>
        <?php if(isset($is_search) && count($directmessage)!=0){echo '<span class="notifyCircle cyan">'.count($directmessage).'</span>';}?>
        </a></li>
    </ul>
</div>
<!-- ==================== END OF ACTIVITIES MENU ==================== -->

<div class="container-fluid center subStream">
    <!-- ==================== ALL ACTIVITIES CONTENT ==================== -->
    <ul class="floatingBoxContainers" id="mentions">
         <?php
         if($mentions){
            if(is_array($mentions)){
               echo $this->load->view('dashboard2/twitter/twitter_mentions', array('mentions' => $mentions));
            }else{
               echo $mentions->errors[0]->message;
            }
         }
         else{
            $this->load->view('dashboard2/no_display');
         }

//print_r($mentions);        
//       ?> 
    </ul>
    
    <ul class="floatingBoxContainers" id="feed" style="display:none">
         <?php 
        // print_r($homefeed);
        if($homefeed){
            if(is_array($homefeed)){
                $this->load->view('dashboard2/twitter/twitter_homefeed', array('homefeed' => $homefeed));
            }else{
                echo $homefeed->errors[0]->message; 
            }
        }
        else{
            $this->load->view('dashboard2/no_display');
        }
        ?> 
    
    
    </ul>
    <ul class="floatingBoxContainers" id="sendmessage" style="display:none">
         <?php 
            //print_r($senttweets);
            if($senttweets){
                if(is_array($senttweets)){
                    $this->load->view('dashboard2/twitter/twitter_senttweets', array('senttweets' => $senttweets));
                }else{
                    echo $senttweets->errors[0]->message;
                }
            }
            else{
                $this->load->view('dashboard2/no_display');
            }
             ?> 
    </ul>
    <ul class="floatingBoxContainers" id="direct" style="display:none">
         <?php 
           // print_r($directmessage);
           if($directmessage){
            if(is_array($directmessage)){
                $this->load->view('dashboard2/twitter/twitter_messages');
             }else{
                //print_r($directmessage);
                //echo $directmessage->errors[0]->message;
             }
           }
           else{
            $this->load->view('dashboard2/no_display');
           }
         ?> 
    </ul>

    <!-- ==================== END OF RECENT TASKS CONTENT ==================== -->

</div>
</div>
