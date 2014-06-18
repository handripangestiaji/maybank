<script src="<?php echo base_url(); ?>media/js/vendor/jquery-date-range-picker/jquery.daterangepicker.js"></script>               
<style type="text/css">
	#reportMenu {padding: 10px;}
	#report {border: 1px solid #ccc}
	#reportMenu button{width: 80%;text-align: left; }
	#content{background: #fff;padding: 15px;}
	#content label{padding: 5px}
	#content hr{display: block;}
	#reportDatePicker {padding: 0px;}
	.input-daterange input{border: 1px solid #aaa;padding: 4px 10px;}
	.table th{text-align: left; vertical-align: middle}
</style>

<link rel="stylesheet" href="<?php echo base_url(); ?>media/js/vendor/jquery-date-range-picker/daterangepicker.css" />
 
<div class="row-fluid" id="report" style="width: 100%; margin: 0px auto;" >
    <div class="span2" id="reportMenu">
	    <ul class="nav nav-tabs nav-stacked">
		    <li class=""><a href="#"><i class="icon-chevron-right"></i> User Performance</a></li>
		    <li class="active"><a href="#"> <i class="icon-chevron-right"></i>  User Activity </a></li>
	    </ul>
    </div>
        
    <div class="span10" id="content">
	<div class="row-fluid">
	    <h3 class="span2">User Activity</h3>
	    <div class="span6 offset4" id="reportDatePicker">
			<div class="input-daterange row">
				<div class="control-group info span5" >
					<label class="control-label" for="inputWarning">Date Start</label>
					<div class="controls">
					<input value="2014/03/01" id="dateStart" />
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
				<div class="span2" style="padding: 30px 0 0"> <button id="reportCreateActivity" class="btn  btn-primary" type="button" id="btnReport" data-loading-text="Loading..."><i class=" icon-filter"></i> <span>Create</span></button></div>
			</div>
		</div>
	    <br clear="all"/>
	</div>
	<div class="row-fluid">
			<div class="span3">
				<label class="span6">Country</label>
				<select name="country" class="span6" id="reportCountry">
					<option value="">Select Country</option>
					<?php foreach($country_list as $country):?>
						<option value="<?=$country->code?>"><?php echo $country->name?></option>
					<?php endforeach;?>
				</select>
			</div>
			<div class="span3">
				<label class="span6">User Group</label>
				<select name="user-group" class="span6" id="reportUserGroup" disabled="disabled">
					
				</select>
			</div>
			<div class="span3">
				<label class="span6">User </label>
				<select name="user-group" class="span6" id="reportUserList" disabled="disabled">
					
				</select>
			</div>
	</div>
	<div>
	    <div class="floatingBox table" style="display: block;">
		<div class="container-fluid">
		    <table class="table table-striped" id="report_activity_table">
		      <thead>
			<tr>
			  <th>Time</th>
			  <th>User</th>
			  <th>Role</th>
			  <th>Action</th>
			  <th>Status</th>
			</tr>
		      </thead>
		      <tbody>
		      </tbody>
		    </table>
		</div>
	    </div>
	</div>
	<div>
	    <button class="btn btn-warning left">Download</button>
	    <div class="page pull-right">
		<button class="btn btn-inverse btn-pagination-first x-pagination" data-offset="0" data-limit="0">First</button>&nbsp;
		<button class="btn btn-inverse btn-pagination-prev x-pagination" data-offset="20" data-limit="0">Previous</button>&nbsp;		
		<button class="btn btn-inverse btn-pagination-next x-pagination" data-offset="20" data-limit="0">Next</button>&nbsp;
		<button class="btn btn-inverse btn-pagination-last x-pagination" data-offset="0" data-limit="0">Last</button>&nbsp;
	    </div>
	</div>
        <br clear="all"/>
	</div>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url()?>media/js/reports.js"></script>