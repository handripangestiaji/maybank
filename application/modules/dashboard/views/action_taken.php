<div id="modal-action-log-<?php echo $post->post_stream_id ?>" class="modal modalDialog hide fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-header" style="padding-bottom: 0px;">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h3>Action Log</h3>
        <table class="table" style="background-color: #ffffff; width: 560px; margin-left: -15px; border-top: 1px solid #e1e1e1;">
            <thead>
              <tr>
                <th style="width:10%">Time</th>
                <th style="width:15%">User</th>
                <th style="width:15%">Action</th>
                <th style="width:30%">Description</th>
                <th style="width:30%">Notes</th>
              </tr>
            </thead>
        </table>
    </div>
    <div class="modal-body" style="padding: 0px;">
        <div class="floatingBox table">
            <div class="container-fluid">
                <table class="table table-striped">
                  <tbody>
                    <?php
            if(isset($post->channel_action)):
                    foreach($post->channel_action as $action):?>
                    <tr>
                      <td style="width:10%"><?php
                        $timezone = new DateTimeZone($this->session->userdata('timezone'));
                        $date=new DateTime($action->created_at.' Europe/London');
                        $date->setTimezone($timezone);
                        echo $date->format('l, M j, Y h:i A');
                        
                      ?></td>
                      <td style="width:15%"><?=$action->username?></td>
                      <td style="width:15%"><?=ucfirst(str_replace('_', ' ', $action->action_type))?></td>
                      <!--td><button class="btn btn-primary icon-book"></button></td-->
                      <td style="width:30%">
                        <?php
                            if($action->action_type == 'reply_facebook' || $action->action_type == 'twitter_reply'){
                                echo '"'.$action->comment_content.'"';
                            }
                            elseif($action->action_type == 'case_created'){
                                echo 'Assign to '.$action->assign_name;
                            }
                            elseif($action->action_type == 'case_solved'){
                                echo 'Solved by '.$action->solved_name;
                            }
                        ?>
                      </td>
                      <td style="width:30%">
                        <?php
                            if($action->action_type == 'case_created' || $action->action_type == 'case_solved'){
                                echo $action->messages;
                            }
                            ?>
                        </td>
                    </tr>
                   
            <?php endforeach;endif;?>
                  </tbody>
                </table>  
            </div>
        </div>
    </div>
</div>