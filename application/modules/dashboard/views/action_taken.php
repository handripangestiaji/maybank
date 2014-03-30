<div id="modal-action-log-<?=$post->social_stream_type=='facebook_conversation'? $post->post_id: $post->post_stream_id; ?>" class="modal modalDialog hide fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-header" style="padding-bottom: 0px;">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h3>Action Log</h3>
        <table class="table" style="background-color: #ffffff; width: 560px; margin-left: -15px; border-top: 1px solid #e1e1e1;">
            <thead>
              <tr>
                <th style="width:100px">Time</th>
                <th style="width:77px">User</th>
                <th style="width:79px">Action</th>
                <th style="width:130px">Status</th>
                <th style="width:139px">Notes</th>
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
                      <td style="width:100px"><?php
                        $timezone = new DateTimeZone($this->session->userdata('timezone'));
                        $date=new DateTime($action->created_at.' Europe/London');
                        $date->setTimezone($timezone);
                        echo $date->format('l, M j, Y h:i A');
                        
                      ?></td>
                      <td style="width:77px"><?=$action->username?></td>
                      <td style="width:79px">
                        <?php
                            echo ucfirst(str_replace('_', ' ', $action->action_type));
                            if($action->action_type == 'case_created')
                                echo ' #'.$action->case_id;
                        ?>      
                      </td>
                      <!--td><button class="btn btn-primary icon-book"></button></td-->
                      <td style="width:130px">
                        <?php
                            
                            if($action->action_type == 'reply_facebook'){
                                echo $action->page_reply_content;
                            }
                            else if($action->action_type == "twitter_reply"){
                                echo '"'.$action->text.'"';
                            }
                            elseif($action->action_type == 'case_created'){
                                echo 'Assign to '.$action->assign_name;
                            }
                            elseif($action->action_type == 'case_solved'){
                                echo 'Solved by '.$action->solved_name;
                            }
                            elseif($action->action_type == 'case_reassign'){
                                echo 'Reassign by '.$action->solved_name;
                            }
                            else if($action->action_type = "conversation_facebook")
                                echo $action->log_text;
                        ?>
                      </td>
                      <td style="width:139px">
                        <?php
                            if($action->action_type == 'case_created'){
                                echo $action->messages;
                            }
                            else if( $action->action_type == 'case_solved'){
                                echo $action->solved_message;
                            }
                            else if( $action->action_type == 'case_reassign'){
                                echo '';
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