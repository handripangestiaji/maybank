<div class="container-fluid">
<!-- ==================== ACTIVITIES MENU ==================== -->
<div class="floatingBoxMenu">
    <ul class="nav nav-tabs">
        <li class="active"><a href='#mentions'>Mentions</a></li>
        <li><a href='#feed'>Homefeed</a></li>
        <li><a href='#sendmessage'>Send Twitter</a></li>
        <li><a href='#direct'>Direct Message</a></li>
    </ul>
</div>
<!-- ==================== END OF ACTIVITIES MENU ==================== -->

<div id="ctwitter" class="container-fluid">
    <!-- ==================== ALL ACTIVITIES CONTENT ==================== -->
    <ul class="floatingBoxContainers" id="mentions">
         <?php 
         if(is_array($mentions)){
            echo $this->load->view('dashboard/twitter/twitter_mentions', array('mentions' => $mentions));
         }else{
            echo $mentions->errors[0]->message;
         }

//print_r($mentions);        
//         ?> 
    </ul>
    
    <ul class="floatingBoxContainers" id="feed" style="display:none">
         <?php //$this->load->view('dashboard/twitter/twitter_homefeed', array('twitter' => $homefeed))?> 
    </ul>
    
    <!--
    <ul class="floatingBoxContainers" id="sendmessage" style="display:none">
         <?php /*$this->load->view('dashboard/twitter/twitter_sendmessage', array('twitter' => $twitter))*/ ?> 
    </ul>
    -->
    <ul class="floatingBoxContainers" id="direct" style="display:none">
         <?php 
            //print_r($directmessage);
             if(is_array($directmessage)){
                $this->load->view('dashboard/twitter/twitter_messages', array('directmessage' => $directmessage));
             }else{
                echo $directmessage->errors[0]->message;
             }   
         ?> 
    </ul>

    <!-- ==================== END OF RECENT TASKS CONTENT ==================== -->
     <div class="filled" style="text-align: center;"><button class="btn btn-info"><i class="icon-chevron-down"></i> LOAD MORE</button></div>
</div>
</div>
