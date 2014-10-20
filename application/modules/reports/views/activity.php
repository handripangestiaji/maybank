<?php $this->user_role = $this->users_model->get_collection_detail(
		array('role_collection_id'=>$this->session->userdata('role_id'))); ?>
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
	<?php $this->load->view('reports/reports_menu'); ?>
	</div>
        
    <div class="span10" id="content">
	<div class="row-fluid">
	    <h2 class="span3">User Activity</h2>
	    <div class="span8 offset1" id="reportDatePicker">
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
						<?php if((IsRoleFriendlyNameExist($this->user_role, array ('Reporting_View_Own_Country'))) || (IsRoleFriendlyNameExist($this->user_role, array ('Reporting_View_All_Country')))){ ?>
							<option value="<?=$country->code?>"><?php echo $country->name?></option>		
						<?php } elseif(IsRoleFriendlyNameExist($this->user_role, array ('Reporting_View_Current_Channel'))){ ?>	
							<?php if($this->session->userdata('country') == $country->code){ ?>
								<option value="<?=$country->code?>"><?php echo $country->name?></option>
							<?php }
						} ?>
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
		
		
	<?php
	
	//if (!IsRoleFriendlyNameExist($this->user_role, 'Reporting_Download_All_Country')):?>
	    <button class="btn btn-warning left" id="btn-download-report-activity">Download</button>
	<?php //endif?>
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