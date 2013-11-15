<link rel="stylesheet" href="<?php echo base_url('media/css/maybankdcms.css')?>">
<!-- ==================== COMPOSE MESSAGE ==================== -->
<div class="container-fluid">
    <form class="form-horizontal contentForm compose-form">
        <div>
             <!-- button-refresh -->
            <div class="left">
                <div class="ref">
                    <a href="#"><img src="media/img/ref.png" /></a>
                </div>
            </div>
            <!-- button-refresh end -->
            <div class="compose-innercontainer compose-collapsed left">
                <textarea class="span8 compose-textbox" placeholder="Compose Message"></textarea>
                <!-- ==================== URL SHORTERNER AJAX THIS WILL BE HIDDEN BY DEFAULT ==================== -->
                <div class="compose-url-shortener">
                    <div class="post-channel">
                        <div class="left">
                                <label class="left">Add Channel : </label>
                                <select class="left" id="multipleSelect" multiple="multiple">
                                    <option id="opt7" value="opt7">FB Maybank (MY)</option>
                                    <option id="opt8" value="opt8">FB Maybankcard (MY</option>
                                    <option id="opt9" value="opt9">TW Mayabank (MY)</option>
                                    <option id="opt10" value="opt10">TW Maybankcard (MY)</option>
                                    <option id="opt11" value="opt11">Youtube Maybank (MY)</option>
                                    <option id="opt12" value="opt12">Youtube Maybankcard (MY)</option>
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
                        <input type="text" length="100" placeholder="Insert Link" />
                        <button class="btn btn-primary" type="button" onClick="window.location.href='login.html'">
                            <i class="icon-angle-right"></i> 
                            Insert
                            </button>
                        </div>
                        <div class="right">
                            <i class="icon-tag icon-large"></i>
                            <input type="text" length="100" placeholder="Separate TAG by ," />
                        </div>
                        <div class="left clear top10">
                        <select class="standard-sel">
                            <option value="#">-- Select Campaign</option>
                            <option value="#">Type Satu</option>
                            <option value="#">Type Dua</option>
                            <option value="#">Type Tiga</option>
                        </select>
                         <select class="standard-sel">
                            <option value="#">-- Select Shorten URL</option>
                            <option value="#">Type Satu</option>
                            <option value="#">Type Dua</option>
                            <option value="#">Type Tiga</option>
                        </select>
                        </div>
                        <script src="js/jquery-1.10.2.min.js"></script>
                        <script type="text/javascript">
                        $( document ).ready(function() {
                            //console.log( "ready!" );
                            $( "#open-img" ).click(function() {
                               $("#img-show").css({"display": "block"});
                            });

                            $( "#close-img" ).click(function() {
                               $("#img-show").css({"display": "none"});
                            });

                             $( "#open-cal" ).click(function() {
                               $("#cal-show").css({"display": "block"});
                            });

                             $( "#close-cal" ).click(function() {
                               $("#cal-show").css({"display": "none"});
                            });
                        });
                        </script>

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
                        <input type="file" id="inputFile" style="display: none">
                        <div class="dummyfile">
                            <input id="filename" type="text" class="input disabled span5" name="filename" readonly>
                            <a id="fileselectbutton" class="btn btn-small btn-inverse">Upload Image</a>
                        </div>
                        <div class="img-list-upload top10">
                            <div class="img-place">
                                <a id="remove-img" href="javascript:void(0);">
                                    <i class="icon-remove icon-2x"></i>
                                </a>
                                <img src="img/contoh-upload.jpg" />
                            </div>
                            <!-- img-place end -->
                            <div class="img-place">
                                <a id="remove-img" href="javascript:void(0);">
                                    <i class="icon-remove icon-2x"></i>
                                </a>
                                <img src="img/contoh-upload.jpg" />
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
                        <h5>Shcedule Post</h5>
                        <div class="img-list-upload">
                                <div class="left">
                                <label class="left">Date</label>
                                <input id="datepickerField" type="text" class="span3" value="04/26/2013">
                                </div>
                                <div class="right">
                                <label class="left">Time</label>
                                <select class="time-sel">
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
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                     <option value="22">23</option>
                                </select>
                                <select class="time-sel">
                                    <option value="">Minutes</option>
                                    <option value="5">5</option>
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
                            </div>
                        </div> 
                        <div class="img-list-upload top10">
                            <input id="demo_box_2" class="css-checkbox" type="checkbox" checked/>
                            <label for="demo_box_2" class="css-label">Email me when message is sent</label>
                        </div> 
                    </div>
                </div>
                <!-- ==================== END URL SHORTERNER AJAX  ==================== -->
              <div class="compose-send">
                <p class="twitter-character-count"><i class="icon-facebook-sign"></i> 2000</p>
                <button class="assign-btn btn btn-primary" type="button"><i class="icon-bolt"></i> POST</button>
              </div>
            </div>
        </div>
    </form>

    <div class="pull-right">
        <select style="width: 100px; float: left;">
            <option style="display:none">Type</option>
            <option value="user">User</option>
            <option value="keyword">Keyword</option>
        </select>
        <input type="text" placeholder="Search" style="width:200px; float: left; margin-left: 2px;">
        <a href="" style="float: left; height: 14px;">
            <span class="add-on" style="background-color: black;color: white;margin-left: -1px; display: inline-block; white-space: nowrap; padding: 5px 6px; font-size: 14px;"><i class="icon-search"></i></span></a>
    </div>
</div>
<!-- ==================== END COMPOSE MESSAGE ==================== -->

<div class="row-fluid">
<?php
    echo $this->load->view('dashboard/facebook/facebook_stream');
    echo $this->load->view('dashboard/twitter/twitter_stream');
    //echo $this->load->view('dashboard/youtube/youtube_stream');
?>
</div>