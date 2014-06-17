<style type="text/css">
	#reportMenu {padding: 10px;}
	#report {border: 1px solid #ccc}
	#reportMenu button{width: 80%;text-align: left; }
	#content{background: #fff;padding: 15px;}
	#content label{padding: 5px}
	#content hr{display: block;}
	#reportDatePicker {padding: 0px;}
	.input-daterange input{border: 1px solid #aaa;padding: 4px 10px;}
	.table th{text-align: center;vertical-align: middle}
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
	<div>
	    <h3 class="left">USER ACTIVITY</h3>
	    <div class="right">
		<input id="date-range0" size="40" value="<?php echo date("Y-m-d", strtotime("-3 months")) ?> to <?php echo date("Y-m-d") ?>">
		<button class="btn btn-primary btn-refresh-activity">Refresh</button>
	    </div>
	    <br clear="all"/>
	</div>
	<div>
	    <div class="left">
		Country&nbsp;
		<select name="country">
		    <option>Malaysia</option>
		    <option>Indonesia</option>
		    <option>Singapore</option>
		</select>
	    </div>
	    <div class="left" style=margin-left:10px;">
		User Group&nbsp;
		<select name="country">
		    <option>Malaysia</option>
		    <option>Indonesia</option>
		    <option>Singapore</option>
		</select>
	    </div>
	    <div class="right">
		User&nbsp;
		<select name="country">
		    <option>Malaysia</option>
		    <option>Indonesia</option>
		    <option>Singapore</option>
		</select>
	    </div>
	    <br clear="all"/>
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