
<div style='margin-top: 10px;'>Case Response Times (Minute)
    <table class="table table-striped">
	<thead>
	    <tr>
		<?php foreach($count_resolution as $resolution):?>
                <th><?= date("m/d/Y", strtotime($resolution->created_at));?></th>
                <?php endforeach;?>
	    </tr>
	</thead>
	<tbody>
            <tr>
	    <?php foreach($count_resolution as $resolution):?>
                <td><?=round($resolution->average,2)?></td>
            <?php endforeach;?>
            </tr>
	</tbody>
  
    </table>
</div>