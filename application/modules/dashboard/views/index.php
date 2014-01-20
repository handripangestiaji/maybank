<!-- ==================== COMPOSE MESSAGE ==================== -->
<div class="container-fluid">
        <div>
             <!-- button-refresh -->
            <div class="left">
                <div class="ref" id="refreshAllStream">
                    <a href="#"><img src="<?php echo base_url() ?>media/img/ref.png" /></a>
                    <?php $group =  $this->users_model->get_group_detail(array('user_group_id'=> $this->session->userdata('group_id')))->result();
                    
                    ?>
                    <br clear="all" />
                </div>
            </div>
            <!-- button-refresh end -->
        <?php if(IsRoleFriendlyNameExist($this->user_role, "Publishing Box_Assigned_Channel")):?>
        <div class="compose-innercontainer compose-collapsed left">
            <textarea class="span8 compose-textbox" placeholder="Compose Message" id="compose-message"></textarea>
            <!-- ==================== URL SHORTERNER AJAX THIS WILL BE HIDDEN BY DEFAULT ==================== -->
            <div class="compose-url-shortener compose-link">
                <div class="post-channel">
                    <div class="left">
                            <label class="left">Add Channel : </label>
                            <select class="left compose-channels" id="multipleSelect" multiple="multiple">
                                <?php
                                    for($i=0;$i<count($channels);$i++){
                                            for($x = 0; $x < count($group); $x++){
                                                    if($group[$x]->allowed_channel === $channels[$i]->channel_id)
                                                            echo '<option id="opt'.$channels[$i]->connection_type.'" value="'.$channels[$i]->channel_id.'">'.$channels[$i]->name.'</option>';
                                            }
                                        
                                    }
                                ?>
                            </select>
                    </div>
                    <!-- left end -->
                    <div class="right">
                        <a id="closecompose" href="javascript:void(0);">
                            Close <i class="icon-remove-sign icon-large"></i>
                        </a>
                    </div>
                </div>
                <!-- post-channel end -->
                    <div class="left">
                    <i class="icon-link icon-large"></i>
                    <input type="text" class="compose-insert-link-text" length="100" placeholder="Insert Link" />
                    <input type="hidden" class="compose-insert-link-short-url-hidden" />
                    <button class="compose-insert-link-btn btn btn-primary" type="button">
                        <i class="icon-angle-right"></i> 
                        Insert
                        </button>
                    </div>
                    <div class="right">
                       <div class="left">
                            <i class="icon-tag icon-large"></i>    
                        </div>
                        <div class="left" style="margin-left:5px;">
                            <ul id="compose-tags" style="width: 200px;"></ul>        
                        </div>
                        <br clear="all" />
                    </div>
                      
                    
                    <div class="left clear top10">
                    <select class="standard-sel compose-select-campaign">
                        <option value=''>-- Select Campaign</option>
                        <?php
                            for($i=0;$i<count($campaign);$i++){
                                echo '<option value="'.$campaign[$i]->id.'">'.$campaign[$i]->campaign_name.'</option>';
                            }
                        ?>
                    </select>
                    <select class="standard-sel select-shorten-url">
                        <option value="#">-- Select Shorten URL</option>
                    </select>
                    </div>

                    <div class="right top10 compose-link">
                        <a href="javascript:void(0);" id="open-img">
                            <i class="icon-camera icon-dark icon-2x"></i>
                        </a>
                        <a href="javascript:void(0);" id="open-cal">
                            <i class="icon-calendar icon-2x"></i>
                        </a>
                    </div>
            </div>
            <div class="compose-schedule" id="img-show">
                <div class="compose-form img-attached">
                    <!-- close button for image attached -->
                    <a id="close-img" href="javascript:void(0);">
                     <i class="icon-remove-sign icon-large"></i>
                    </a>
                    <input type="file" id="composeInputImageFile" style="display: none">
                    <div class="dummyfile">
                        <input id="filename" type="text" class="input disabled span5" name="filename" readonly>
                        <a id="fileselectbutton" class="btn btn-small btn-inverse">Upload Image</a>
                    </div>
                    <div class="img-list-upload top10">
                        <div class="img-place">
                            <a id="remove-img" href="javascript:void(0);">
                                <i class="icon-remove icon-2x"></i>
                            </a>
                            <img id="compose-preview-img"/>
                        </div>
                        <!-- img-place end -->
                    </div>
                    <!-- img-list-upload end -->  
                    <div class="img-list-upload">
                        <input id="demo_box_1" class="css-checkbox" type="checkbox" checked/>
                        <label for="demo_box_1" class="css-label">Hide URL when posting in Facebook</label>
                    </div>  
                </div>
            </div>
            <div class="compose-schedule" id="cal-show">
                <div class="compose-form img-attached">
                    <a id="close-cal" href="javascript:void(0);">
                     <i class="icon-remove-sign icon-large"></i>
                    </a>
                    <h5>Schedule Post</h5>
                    <div class="img-list-upload">
                            <div class="left">
                            <label class="left">Date</label>
                            <input id="datepickerField" type="text" class="span3">
                            </div>
                            <div class="right">
                            <p>
                                <label class="left">Time</label>
                                <select class="time-sel" id="compose-schedule-hours">
                                    <option value="">Hours</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                </select>
                                <select class="time-sel" id="compose-schedule-minutes">
                                    <option value="">Minutes</option>
                                    <option value="00">0</option>
                                    <option value="05">5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                    <option value="25">25</option>
                                    <option value="30">30</option>
                                    <option value="35">35</option>
                                    <option value="40">40</option>
                                    <option value="45">45</option>
                                    <option value="50">50</option>
                                    <option value="55">55</option>
                                </select>
                                <select class="time-sel" id="compose-schedule-ampm">
                                    <option value="AM">AM</option>
                                    <option value="PM">PM</option>
                                </select>
                            </p>
                            <br/>
                            <p>
                                <input id="email_me" type="checkbox" checked style="margin-top: 0px;"/> Email me when message is sent
                            </p> 
                        </div>
                    </div> 
                </div>
            </div>
            <div class="compose-schedule" id="url-show">
                <div class="compose-form img-attached">
                    <!-- close button for image attached -->
                    <a id="close-url" href="javascript:void(0);">
                        <i class="icon-remove-sign icon-large"></i>
                    </a>
                    <div>
                    </div>
                </div>
            </div>
            <!-- ==================== END URL SHORTERNER AJAX  ==================== -->
            <div class="compose-send">
                <p class="facebook-character-count"><i class="icon-facebook-sign"></i>&nbsp;<span class="compose-fb-char-count">2000</span</p>
                <p class="twitter-character-count">&nbsp;&nbsp;<i class="icon-twitter-sign"></i>&nbsp;<span class="compose-tw-char-count">140</span></p>
                <p class="youtube-character-count">&nbsp;&nbsp;<i class="icon-youtube-sign"></i>&nbsp;<span class="compose-yt-char-count">500</span></p>
                <button class="btn-compose-post btn btn-primary" type="button"><i class="icon-bolt"></i> POST</button>
            </div>
          <br clear="all" />
          <div class="compose-post-status green hide">Message Post</div>
        </div>
        <?php endif?>
        </div>


    
    <?php if(IsRoleFriendlyNameExist($this->user_role, "Social Stream_All_Take Action")):?>
        <div class="pull-right dashboard-search">
            <input class="dashboard-search-field" type="text" placeholder="Search" style="width:200px; float: left; margin-left: 2px;">
            <button class="btn btn-inverse btn-dashboard-search">
                <i class="icon-search"></i>
            </button>
        </div>
    <?php endif;?>
    
</div>
<!-- ==================== END COMPOSE MESSAGE ==================== -->

<div class="row-fluid" style="margin-bottom: 0px;">
<?php
    if(count($channels) > 3){
        $span = 4;
    }
    else{
        $span = 12/count($channels);
    }
    //$data['channels'] = $channels;
    $data['color'] = '#3B5998';
    $data['group'] = $group;
    $data['box_id'] = 1;
    if(count($group) >= 1){
        $this->load->view('dashboard/box_stream',$data);
    }
    $data['box_id'] = 2;
    $data['color'] = '#4099FF';
    if(count($group) >= 2){
        $this->load->view('dashboard/box_stream',$data);
    }
    $data['box_id'] = 3;
    $data['color'] = '#FF3333';
    if(count($group) >= 3)
        $this->load->view('dashboard/box_stream',$data);
    //$this->load->view('dashboard/box_stream',$data);
    //$this->load->view('dashboard/youtube/youtube_stream',$data);
?>
</div>
