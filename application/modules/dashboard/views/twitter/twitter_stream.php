<input type="hidden" class="channel-id" value="<?php if(count($mentions) > 0) echo $mentions[0]->channel_id; ?>">
<div id='ctwitter' class="container-fluid">
<!-- ==================== ACTIVITIES MENU ==================== -->
<div class="floatingBoxMenu">
    <ul class="nav stream_head">
        <li class="active"><a class='mentions'>Mentions<span class="notifyCircle red">3</span></a></li>
        <li><a class='feed'>Homefeed</a></li>
        <li><a class='sendmessage'>Send Twitter</a></li>
        <li><a class='direct'>Direct Message<span class="notifyCircle red">2</span></span></a></li>
    </ul>
</div>
<!-- ==================== END OF ACTIVITIES MENU ==================== -->

<div class="container-fluid">
    <!-- ==================== ALL ACTIVITIES CONTENT ==================== -->
    <ul class="floatingBoxContainers" id="mentions">
         <?php 
         if(is_array($mentions)){
            echo $this->load->view('dashboard/twitter/twitter_mentions', array('mentions' => $mentions));
         }else{
            echo $mentions->errors[0]->message;
         }

//print_r($mentions);        
//       ?> 
    </ul>
    
    <ul class="floatingBoxContainers" id="feed" style="display:none">
         <?php 
        // print_r($homefeed);
            if(is_array($homefeed)){
                $this->load->view('dashboard/twitter/twitter_homefeed', array('homefeed' => $homefeed));
            }else{
                echo $homefeed->errors[0]->message; 
            } 
                ?> 
    
    
    </ul>
    <ul class="floatingBoxContainers" id="sendmessage" style="display:none">
         <?php 
            //print_r($senttweets);
            if(is_array($senttweets)){
                $this->load->view('dashboard/twitter/twitter_senttweets', array('senttweets' => $senttweets));
            }else{
                echo $senttweets->errors[0]->message;
            }
             ?> 
    </ul>
    <ul class="floatingBoxContainers" id="direct" style="display:none">
         <?php 
           // print_r($directmessage);
             if(is_array($directmessage)){
                $this->load->view('dashboard/twitter/twitter_messages', array('directmessage' => $directmessage));
             }else{
                //print_r($directmessage);
                echo $directmessage->errors[0]->message;
             }   
         ?> 
    </ul>

    <!-- ==================== END OF RECENT TASKS CONTENT ==================== -->
     <div class="filled" style="text-align: center;"><button class="btn btn-info"><i class="icon-chevron-down"></i> LOAD MORE</button></div>
</div>
</div>
