<div id="modal-action-log-<?php echo $post->post_stream_id ?>" class="modal modalDialog hide fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h3>Action Log</h3>
    </div>
    <div class="modal-body">
        <div class="floatingBox table">
            <div class="container-fluid">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Time</th>
                      <th>User</th>
                      <th>Action Taken</th>
                      <th>Channels</th>
                      <th>Details</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach($post->channel_action as $action):?>
                    <tr>
                      <td><?php
                        $timezone = new DateTimeZone($this->session->userdata('timezone'));
                        $date=new DateTime($action->created_at.' Europe/London');
                        $date->setTimezone($timezone);
                        echo $date->format('l, M j, Y h:i A');
                        
                      ?></td>
                      <td><?=$action->username?></td>
                      <td><?=ucfirst(str_replace('_', ' ', $action->action_type))?></td>
                      <!--td><button class="btn btn-primary icon-book"></button></td-->
                      <td></td>
                      <td></td>
                    </tr>
                   
                    <?php endforeach;?>
                  </tbody>
                </table>  
            </div>
        </div>
    </div>
</div>