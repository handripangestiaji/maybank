<!-- ==================== MIDDLE COL ==================== -->
<div class="span4">
    <!-- ==================== ACTIVITIES CONTAINER ==================== -->
    <div class="row-fluid">
        <div class="span12">
            <!-- ==================== ACTIVITIES HEADLINE ==================== -->
            <div class="containerHeadline" style="background-color:<?php echo $color; ?>;color: white; height: 30px;">
                <div class="pull-left" style="padding: 4px 0px; height: auto">
                    <div class="btn-group">
                        <button class="btn trans  dropdown-toggle" data-toggle="dropdown">
                            
                        </button>
                        <ul class="dropdown-menu dropdown-stream-channels">
                            <?php
                                for($i=0;$i<count($channels);$i++){
                                    echo '<li>
                                            <a class="'.$channels[$i]->connection_type.'_stream change_stream">'.$channels[$i]->name.' ('.$channels[$i]->connection_type.')</a>
                                            <input type="hidden" class="channel-stream-id" value="'.$channels[$i]->channel_id.'">
                                            </li>';
                                }
                            ?>
                        </ul>
                    </div><!-- /btn-group -->
                </div>
                <div class="pull-right">
                    <select class="change-read-unread-stream" style="width: 130px;">
                        <option value="0">Unread</option>
                        <option value="1">Read</option>
                        <option value="2">Assigned Cases</option>
                    </select>
                </div>
            </div>
            <!-- ==================== END OF ACTIVITIES HEADLINE ==================== -->

            <!-- ==================== ACTIVITIES FLOATING BOX ==================== -->
            <div class="floatingBox">
                Loading...
            </div>
            <!-- ==================== END OF ACTIVITIES FLOATING BOX ==================== -->
        
        </div>
    </div>
    <!-- ==================== END OF ACTIVITIES CONTAINER ==================== -->
</div>
<!-- ==================== END OF MIDDLE COL ==================== -->
