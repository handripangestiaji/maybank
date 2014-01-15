<div>
    <span style='font-size:16px;'>TOTAL CASES: <b><?php echo $count_all_case; ?></b></span>
    <span style='font-size: 16px; margin-left: 20px;'>RESOLVED: <b><?php echo $count_solved_case; ?></b></span>
    <span style='font-size: 16px; margin-left: 20px;'>Percentage: <b><?php echo $percentage; ?>%</b></span>
</div>
<div style='margin-top: 10px;'>No of Cases
    <table class="table table-striped">
	<thead>
	    <tr>
		<?php foreach($case_list_by_date as $case):?>
                <th><?= date("m/d/Y", strtotime($case->created_at));?></th>
                <?php endforeach;?>
	    </tr>
	</thead>
	<tbody>
            <tr>
	    <?php foreach($case_list_by_date as $case):?>
                <td><?=$case->counted?></td>
            <?php endforeach;?>
            </tr>
	</tbody>
  
    </table>
</div>