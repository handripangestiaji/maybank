<div class="container-fluid new-compose-message-fields">
    <div class="row-fluid">
        Add Channel : 
        <select class="left compose-channels" id="multipleSelect" multiple="multiple">
            <?php
                $group =  $this->users_model->get_group_detail(array('user_group_id'=> $this->session->userdata('group_id')))->result();
                for($i=0;$i<count($channels);$i++){
                        for($x = 0; $x < count($group); $x++){
                            if($channels[$i]->connection_type != 'youtube'){
                                if($group[$x]->allowed_channel === $channels[$i]->channel_id)
                                        echo '<option id="opt'.$channels[$i]->connection_type.'" value="'.$channels[$i]->channel_id.'">'.$channels[$i]->name.'</option>';
                            }
                        }
                }
            ?>
        </select>
    </div>
    <div class="row-fluid">
        <textarea class="span12 compose-textbox" style="height: 100px;" placeholder="Compose Message" id="compose-message"></textarea>
    </div>
    <div class="row-fluid">
        <i class="icon-link icon-large"></i>
        <input type="text" class="compose-insert-link-text" style="margin-left: 5px;" length="100" placeholder="Insert Link" />
            <input type="hidden" class="compose-insert-link-short-url-hidden" />
            <button class="compose-insert-link-btn btn btn-primary" type="button">
                <i class="icon-plus"></i> 
            </button>
        <div class="url-show" id="url-show">
            <div class="compose-form img-attached">
                <!-- close button for image attached -->
                <a id="close-url" href="javascript:void(0);">
                    <i class="icon-remove-sign icon-large"></i>
                </a>
                <div>
                </div>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="left">
            <i class="icon-tag icon-large"></i>    
        </div>
        <div class="left" style="margin-left:5px;">
            <ul id="compose-tags" style="width: 200px;"></ul>        
        </div>
        <br clear="all" />
    </div>
    <!--div class="row-fluid">
        <select class="standard-sel compose-select-campaign">
            <option value=''>-- Select Campaign</option>
            <?php
            /*
                for($i=0;$i<count($campaign);$i++){
                    echo '<option value="'.$campaign[$i]->id.'">'.$campaign[$i]->campaign_name.'</option>';
                }
            */
            ?>
        </select>
    </div-->
    <div class="row-fluid img-show">
        <input type="file" id="composeInputImageFile" style="display: none">
        <i class="icon-camera icon-large"></i>
        <input id="filename" type="text" class="input disabled" name="filename" lenght="100" style="margin-left: 5px" readonly>
        <a id="fileselectbutton" class="btn btn-small btn-inverse">...</a>
        <div class="img-list-upload top10">
            <div class="img-place">
                <a id="remove-img" href="javascript:void(0);">
                    <i class="icon-remove icon-2x"></i>
                </a>
                <img id="compose-preview-img" />
            </div>
            <!-- img-place end -->
        </div>
    </div>
    <div class="row-fluid cal-show">
        <i class="icon-calendar icon-large"></i>
        Post at (leave date & time blank, if you want to post now)
        <div style="margin-top: 5px;">
            <table>
                <tr>
                    <td>
                        <p>Date</p>
                    </td>
                    <td>        
                        <input id="datepickerField" type="text">
                    </td>
                </tr>
                <tr>
                    <td>        
                        <p>Time</p>
                    </td>
                    <td>
                        <p>
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
                    </td>
                </tr>
            </table>
            <p>
                <input id="email_me" type="checkbox" checked style="margin-top: 0px;"/> Email me when message is sent
            </p> 
        </div>
    </div>
    <div class="row-fluid">
        <button class="btn btn-primary btn-compose-post span12"><i class="icon-bolt icon-2x"></i> POST</button>
    </div>
    <div class="compose-post-status green hide">Message Post</div>
</div>