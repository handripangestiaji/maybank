<div class="floatingBox table hide">
    <div class="container-fluid">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Time Stamp</th>
              <th>Username</th>
              <th>Action Taken</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach($post->channel_action as $action):?>
            <tr>
              <td><?php $timezone = new DateTimeZone($this->config->item('timezone'));
              $timestamp = new DateTime($action->created_at.' Europe/London', $timezone);
              echo $timestamp->format('M j, Y h:i A');
              ?></td>
              <td><?=$action->username?></td>
              <td><?=ucfirst(str_replace('_', ' ', $action->action_type))?></td>
              <!--td><button class="btn btn-primary icon-book"></button></td-->
            </tr>
           
            <?php endforeach;?>
          </tbody>
        </table>  
    </div>
</div>