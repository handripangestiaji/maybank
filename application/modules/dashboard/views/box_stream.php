<!-- ==================== MIDDLE COL ==================== -->
<div class="span4">
    <!-- ==================== ACTIVITIES CONTAINER ==================== -->
    <div class="row-fluid">
        <div class="span12">
            <!-- ==================== ACTIVITIES HEADLINE ==================== -->
            <div class="containerHeadline" style="background-color:<?php if($type == 'facebook'){echo "#3B5998";} elseif($type == 'twitter'){echo "#4099FF";} elseif($type == 'youtube'){echo "#FF3333";}?>;color: white; height: 30px;">
                <div class="pull-left" style="padding: 4px 0px; height: auto">
                    <div class="btn-group">
                        <button class="btn trans  dropdown-toggle" data-toggle="dropdown">
                            <?php
                                if($type == 'facebook'){
                                    echo '<i class="icon-facebook"></i><h2>Facebook&nbsp;</h2><i class="icon-caret-down"></i>';
                                }
                                elseif($type == 'twitter'){
                                    echo '<i class="icon-twitter"></i><h2>Twitter&nbsp;</h2><i class="icon-caret-down"></i>';
                                }
                                elseif($type == 'youtube'){
                                    echo '<i class="icon-youtube"></i><h2>Youtube&nbsp;</h2><i class="icon-caret-down"></i>';
                                }
                            ?>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="facebook_stream">Facebook Maybank</a></li>
                            <li><a class="facebook_stream">Facebook Maybankard</a></li>
                            <li><a class="twitter_stream">Twitter Maybank</a></li>
                            <li><a class="youtube_stream">YouTube Maybank</a></li>
                        </ul>
                    </div><!-- /btn-group -->
                </div>
                <div class="pull-right">
                    <select style="width: 130px;">
                        <option value="keyword">Unread</option>
                        <option value="user">Read</option>
                        <option value="keyword">Assigned Cases</option>
                    </select>
                </div>
            </div>
            <!-- ==================== END OF ACTIVITIES HEADLINE ==================== -->

            <!-- ==================== ACTIVITIES FLOATING BOX ==================== -->
            <div class="floatingBox">
                <?php $this->load->view($stream); ?>
            </div>
            <!-- ==================== END OF ACTIVITIES FLOATING BOX ==================== -->
        
        </div>
    </div>
    <!-- ==================== END OF ACTIVITIES CONTAINER ==================== -->
</div>
<!-- ==================== END OF MIDDLE COL ==================== -->
