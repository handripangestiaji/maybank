<style type="text/css">
	#reportMenu {padding: 10px;}
	#report {border: 1px solid #ccc}
	#reportMenu button{width: 80%;text-align: left; }
	#content{background: #fff;padding: 15px;}
	#content label{padding: 5px}
	#content hr{display: block;}
	#reportDatePicker {padding: 10px;}

</style>

<div class="row-fluid" id="report">
	<div class="span2" id="reportMenu">
		<ul class="nav nav-tabs nav-stacked">
			<li class="active"><a href="#"><i class="icon-chevron-right"></i> User Performance</a></li>
			<li class=""><a href="#"> <i class="icon-chevron-right"></i>  User Activity </a></li>
		</ul>
	</div>
	<div class="span10" id="content">
		<div class="row-fluid">
			<h1 class="span2">Performance</h1>
			<div class="span4 offset5" id="reportDatePicker">
				
				<div class="input-daterange">
					<input value="2012-04-05" id="dateStart" />
					<span class="add-on">to</span>
					<input value="2012-04-07" id="dateFinish"/>
				</div>
			</div>
		</div>
		
		<hr />
		<div class="row-fluid">
			<div class="span3">
				<label class="span6">Country</label>
				<select name="country" class="span6" id="reportCountry">
					<?php
						foreach($country_list as $country):
					?>
						<option value="<?=$country->code?>"><?php echo $country->name?></option>
					<?php endforeach;?>
				</select>
			</div>
			<div class="span3">
				<label class="span6">Channel</label>
				<select name="channel" class="span6" id="reportChannel" disabled="disabled" >
					
				</select>
			</div>
			<div class="span3">
				<label class="span6">User Group</label>
				<select name="user-group" class="span6" id="reportUserGroup" disabled="disabled">
					
				</select>
			</div>
			<div class="span3">
				<label class="span6">Type</label>
				<select name="type" class="span6">
					<option value="engagement">Engagement</option>
					<option value="case">Case</option>
				</select>
			</div>
		</div>
		
		<div class="row-fluid">
			<div class="span2 offset5">
				<div class="btn-group" data-toggle="buttons-checkbox">
					<button type="button" class="btn btn-primary">Numbers</button>
					<button type="button" class="btn ">Percentage</button>
				</div>
			</div>
			<table class="table table-striped table-bordered" style="background: #fff;border: 1px solid #ccc">
				<thead>
				<tr><th>Case</th>
				<th colspan="3">
					<select name="channel" >
						<option value="">All</option>
						<option value="Feedback">Feedback</option>
						<option value="Enquiries">Enquiries</option>
						<option value="Complaints">Complaints</option>
						<option value="ReportAbuse">Report Abuse</option>
					</select>
				</th>
				<th colspan="3">Wall Post</th>
				<th colspan="3">Private Message</th></tr>
				<tr>
					<td>Products</td>
					<td>Total</td>
					<td>Resolved</td>
					<td>Avg Time</td>
					<td>Total</td>
					<td>Resolved</td>
					<td>Avg Time</td>
					<td>Total</td>
					<td>Resolved</td>
					<td>Avg Time</td>
					<td>Action</td>
					
				</tr>
				</thead>
				<tbody>
					<?php for($i=0;$i<10;$i++):?>
					<tr>
						<td>test</td>
						<td>test</td>
						<td>test</td>
						<td>test</td>
						<td>test</td>
						<td>test</td>
					</tr>
					<?php endfor?>
				</tbody>
				<tfoot>
					<td>Total</td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
				</tfoot>
			</table>
		</div>
		
	</div>
</div>

<script type="text/javascript" src="<?php echo base_url()?>media/js/reports.js"></script>