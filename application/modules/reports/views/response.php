
<div style='margin-top: 10px;'>Case Response Times (Minute)
    <table class="table table-striped">
	<thead>
	    <tr>
		<?php foreach($count_response as $response):?>
                <th><?= date("m/d/Y", strtotime($response->created_at));?></th>
                <?php endforeach;?>
	    </tr>
	</thead>
	<tbody>
            <tr>
	    <?php foreach($count_response as $response):?>
                <td><?=round($response->average,2)?></td>
            <?php endforeach;?>
            </tr>
	</tbody>
  
    </table>
</div>