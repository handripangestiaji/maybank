<!-- ==================== MIDDLE COL ==================== -->
<div id='ctwitter' class="span4">
    <!-- ==================== ACTIVITIES CONTAINER ==================== -->
    <div class="row-fluid">
        <div class="span12">
            <!-- ==================== ACTIVITIES HEADLINE ==================== -->
            <div class="containerHeadline" style="background-color:<?php echo $color; ?>;color: white; height: 30px;">
                <div class="pull-left" style="padding: 4px 0px; height: auto">
                    <div class="btn-group">
                        <button class="btn trans  dropdown-toggle" data-toggle="dropdown">
                            <?php if($stream=='dashboard/facebook/facebook_stream'){ ?>
                                <i class="icon-facebook"></i> <h2>Facebook </h2> 
                            <?php }elseif($stream=='dashboard/twitter/twitter_stream'){ ?>
                                <i class="icon-twitter"></i> <h2>Twitter</h2>
                            <?php } ?>
                            &nbsp;&nbsp;<span class="caret"></span>
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
