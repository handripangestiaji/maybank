
<?php
//print_r($group);
    if(count($group) > 3){
        $span = 4;
    }
    else{
        $span = 12/count($group);
    }
?>
<!-- ==================== MIDDLE COL ==================== -->
<div class="span<?php echo $span ?>">
    <!-- ==================== ACTIVITIES CONTAINER ==================== -->
    <div class="row-fluid" style="margin-bottom: 0px;">
        <div class="span12">
            <!-- ==================== ACTIVITIES HEADLINE ==================== -->
            <div class="containerHeadline" id="box-id-<?php echo $box_id ?>" style="background-color:<?php echo $color; ?>;color: white; height: 30px;">
                <div class="pull-left" style="padding: 4px 0px; height: auto">
                    <div class="btn-group">
                        <button class="btn trans dropdown-toggle btn-dropdown-stream-channels" data-toggle="dropdown">
                        </button>
                        <ul class="dropdown-menu dropdown-stream-channels">
                            <?php
                                for($i=0;$i<count($channels);$i++){
                                    for($x = 0; $x < count($group); $x++){
                                        if($group[$x]->allowed_channel === $channels[$i]->channel_id)
                                        echo '<li>
                                            <a class="'.$channels[$i]->connection_type.'_stream change_stream">'.$channels[$i]->name.' ('.$channels[$i]->connection_type.')</a>
                                            <input type="hidden" class="channel-stream-id" value="'.$channels[$i]->channel_id.'">
                                            </li>';
                                    }
                                }
                            ?>
                        </ul>
                    </div><!-- /btn-group -->
                </div>
                <div class="pull-right">
                    <select class="change-read-unread-stream" style="width: 130px;">
                        <option value="">All</option>
                        <option value="0">Unread</option>
                        <option value="1">Read</option>
                        <option value="2">Assigned Cases</option>
                    </select>
                </div>
            </div>
            <!-- ==================== END OF ACTIVITIES HEADLINE ==================== -->

            <!-- ==================== ACTIVITIES FLOATING BOX ==================== -->
            <div class="floatingBox center" style="height: 400px; overflow: auto; margin-bottom: 0px; min-height: 400px; background-color: #FFFFFF;">
                Loading...
            </div>
            <!-- ==================== END OF ACTIVITIES FLOATING BOX ==================== -->
        
        </div>
    </div>
    <!-- ==================== END OF ACTIVITIES CONTAINER ==================== -->
</div>
<!-- ==================== END OF MIDDLE COL ==================== -->
