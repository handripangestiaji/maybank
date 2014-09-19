<style type="text/css">
	#reportMenu {padding: 10px;}
	#report {border: 1px solid #ccc}
	#reportMenu button{width: 80%;text-align: left; }
	#content{background: #fff;padding: 15px;}
	#content label{padding: 5px}
	#content hr{display: block;}
	#reportDatePicker {padding: 0px;}
	#reportDatePicker input{width: 70%}
	.input-daterange input{border: 1px solid #aaa;padding: 4px 10px;}
	.table th{text-align: center;vertical-align: middle}
</style>

<div class="row-fluid" id="report">
	<div class="span2" id="reportMenu">
		<?php $this->load->view('reports/reports_menu'); ?>
	</div>
	<div class="span10" id="content">
		<div class="alert alert-block span12" style="display: none">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<h4 style="margin-bottom:10px">Warning!</h4>
				<div class="help-inline"></div>
			</div>
		<div class="row-fluid">
			<h2 class="span2">Performance</h2>
			<div class="span7 offset3" id="reportDatePicker">
				
				<div class="input-daterange row">
					<div class="control-group info span5" >
						<label class="control-label" for="inputWarning">Date Start</label>
						<div class="controls">
						<input value="<?php echo date("Y/m/d",strtotime("-3 months")); ?>" id="dateStart" />
						<span class="help-inline"></span>
						</div>
					</div>
					<div class="control-group info span5">
						<label class="control-label" for="inputWarning">Date Finish</label>
						<div class="controls">
						<input value="<?php echo date("Y/m/d")?>" id="dateFinish"/>
						<span class="help-inline"></span>
						</div>
					</div>
					<div class="span2" style="padding: 30px 0 0"> <button id="reportCreate" class="btn  btn-primary" type="button" id="btnReport" data-loading-text="Loading..."><i class=" icon-filter"></i> <span>Create</span></button></div>
					
				</div>
			</div>
		</div>
		
		<hr />
		<div class="row-fluid">
			<div class="span3">
				<label class="span4">Country</label>
				<select name="country" class="span8" id="reportCountry">
					<option value="">Select Country</option>
					<?php foreach($country_list as $country):?>
						<option value="<?=$country->code?>"><?php echo $country->name?></option>
					<?php endforeach;?>
				</select>
			</div>
			<div class="span3">
				<label class="span4">Channel</label>
				<select name="channel" class="span8" id="reportChannel" disabled="disabled" >
					
				</select>
			</div>
			<div class="span3">
				<label class="span6">User Group</label>
				<select name="user-group" class="span6" id="reportUserGroup" disabled="disabled">
					
				</select>
			</div>
			<div class="span3">
				<label class="span4">Type</label>
				<select name="type" class="span8" id="reportType">
					<option value="case">Case</option>
					<option value="engagement">Engagement</option>
				</select>
			</div>
		</div>
		
		<div class="row-fluid">
			<!--div class="span2 offset5">
				<div class="btn-group" data-toggle="buttons-checkbox">
					<button type="button" class="btn btn-primary">Numbers</button>
					<button type="button" class="btn ">Percentage</button>
				</div>
			</div-->
			<table class="table table-striped table-bordered" style="background: #fff;border: 1px solid #ccc">
				<thead>
				<tr><th>Case</th>
				<th colspan="3">
					<select name="case_type" id="caseType" >
						<option value="all">All</option>
						<option value="Feedback">Feedback</option>
						<option value="Compliment">Compliment</option>
						<option value="Enquiry">Enquiries</option>
						<option value="Complaint">Complaints</option>
						<option value="Report_Abuse">Report Abuse</option>
					</select>
				</th>
				<th colspan="3">Wall Post</th>
				<th colspan="3">Private Message</th>
				<th rowspan="2">Action</th></tr>
				<tr>
					<td>Products</td>
					<td>Total</td>
					<td class="resolved">Resolved</td>
					<td class="avg_time">Avg Time</td>
					<td>Total</td>
					<td class="resolved">Resolved</td>
					<td class="avg_time">Avg Time</td>
					<td>Total</td>
					<td class="resolved">Resolved</td>
					<td class="avg_time">Avg Time</td>
				</tr>
				</thead>
				<tbody>
					<tr><td colspan="11" style="text-align: center">No Result</td></tr>
				</tbody>
				<tfoot>
					<td>Total</td>
					<td class="sum1">0</td>
					<td class="sum2">0</td>
					<td class="sum3">0</td>
					<td class="sum4">0</td>
					<td class="sum5">0</td>
					<td class="sum6">0</td>
					<td class="sum7">0</td>
					<td class="sum8">0</td>
					<td class="sum9">0</td>
					<td style="text-align: center">
						<?php //if (!IsRoleFriendlyNameExist($this->user_role, 'Reporting_Download_All_Country')):?>
						<button class="btn btn-download  btn-primary" type="button" ><i class=" icon-download"></i> Download</button>
						<?php //endif;?>
					</td>
				</tfoot>
			</table>
		</div>
		
	</div>
</div>

<script type="text/javascript" src="<?php echo base_url()?>media/js/reports.js"></script>