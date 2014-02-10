<div class="row-fluid" style="width: 100%; margin: 0px auto;" >
    <div class="cms-content row-fluid">
        <div class="cms-filter pull-left">
	    <h4>SUMMARY</h4>
            <table>
                <tr>
                    <td><input type="button" style='width: 101px;' value="Case" /><br /></td>
                </tr>
                <tr>
                    <td><input type="button" style='width: 101px;' value="Engagement" /></td>
                </tr>
            </table>
            
            <h5>User</h5>
            <table>
                <tr>
                    <td><input type="button" style='width: 101px;' value="Performance" /></td>
                </tr>
                <tr>
                    <td><input type="button" style='width: 101px;' value="Activity" /></td>
                </tr>
            </table>
        </div>
        
        <div class="cms-table pull-right">
            <div>
                <div style='float: left'>
                    <h4>CASE SUMMARY</h4>
                </div>
                <div style="float: left;margin-left: 100px;">
                    Filter via
                    <select id="slcFilter">
                        <option>select channel</option>
                        <?php foreach($channel->result() as $c){?>
                            <option value='<?php echo $c->channel_id;?>'><?php echo $c->name;?></option>
                        <?php }?>
                    </select>
                </div>
                <div style="float: left;margin-left: 75px;">
                    <input id="datepickerField" type="text" placeholder="Data From" />
                    <input id="datepickerField1" type="text" placeholder="Data To" />
		    <input type="button" value="Filter" name="filt" id="filt" class="btn btn-min" style="margin-top: -11px;"/>
                </div>
                <div style='clear: both;'></div>
            </div>
            <hr>
            <div id="NoOfCase">
	    </div>
	    <div style="height: auto; float: left; width: 100%">
		<h4>CASE STATUS</h4>
		<?php $i=0; foreach($count_percentage_product as $c){?>      
		   <div style='float: left; width: 300px; height: 300px;'>
		    <ul class="gaugeContainers">
			<li id="gaugeDemo<?php echo $i;?>"></li>
			<li style='float: left; margin-left: 18%; text-align: center;'><span style='font-weight: bold;'><?php echo strtoupper($c->product_name);?></span></li>
		    </ul>
		   </div>
		   <input type="hidden" id="gaugValue<?php echo $i;?>" value="<?php echo round(($c->percentage),2);?>" />
		<?php $i++;} ?>
		<input type="hidden" id="countproduct" value="<?php echo $i;?>" />
	    </div>
	    <div>
                <div style='float: left'>
                    <h4>CASE RESPONSE TIMES</h4>
                </div>
                <div style="float: left;margin-left: 100px;">
                    Filter Product
                    <select id="slcFilterProduct">
                        <option>select product</option>
                        <?php foreach($product->result() as $p){?>
                            <option value='<?php echo $p->id;?>'><?php echo $p->product_name;?></option>
                        <?php }?>
                    </select>
                </div>
                <div style="float: left;margin-left: 75px;">
                    <input id="datepickerFieldResponse" type="text" placeholder="Data From" />
                    <input id="datepickerFieldResponse1" type="text" placeholder="Data To" />
		    <input type="button" value="Filter" name="filtResponse" id="filtResponse" class="btn btn-min" style="margin-top: -11px;" />
                </div>
                <div style='clear: both;'></div>
            </div>
            <hr>
	    <div id="Response">
	    </div>
	<div>
                <div style='float: left'>
                    <h4>CASE RESOLUTION TIMES</h4>
                </div>
                <div style="float: left;margin-left: 100px;">
                    Filter Product
                    <select id="slcFilterProduct1">
                        <option>select product</option>
                        <?php foreach($product->result() as $p){?>
                            <option value='<?php echo $p->id;?>'><?php echo $p->product_name;?></option>
                        <?php }?>
                    </select>
                </div>
                <div style="float: left;margin-left: 75px;">
                    <input id="datepickerFieldResolution" type="text" placeholder="Data From" />
                    <input id="datepickerFieldResolution1" type="text" placeholder="Data To" />
		    <input type="button" value="Filter" name="filtResolution" id="filtResolution" class="btn btn-min" style="margin-top: -11px;" />
                </div>
                <div style='clear: both;'></div>
            </div>
	<hr />
	<div id="Resolution">
	</div>
            <div style='clear: both;'></div>
                    <?php
                        function time_hour($secs){
                            if($secs!=NULL){
                            $bit = array(
                                ' year'        => $secs / 31556926 % 12,
                                ' week'        => $secs / 604800 % 52,
                                ' day'        => $secs / 86400 % 7,
                                ' hour'        => $secs / 3600 % 24,
                                ' minute'    => $secs / 60 % 60,
                                ' second'    => $secs % 60
                                );
                                
                            foreach($bit as $k => $v){
                                if($v > 1)$ret[] = $v . $k . 's';
                                if($v == 1)$ret[] = $v . $k;
                                }
                            array_splice($ret, count($ret)-1, 0);
                            
                            return join(' ', $ret);
                            }
                        }
                    ?>
            <div>
                <table style='float: left;' border='1' cellpadding='4'>
                        <thead>
                        <tr><td rowspan="2">Product</td>
                        <!--
                            $header = array();
                            $i=0;
                            foreach($show as $sh){
                                if(!in_array($sh->case_type, $header)){
                                    
                                    $header [] = $sh->case_type;
                                    
                                    echo "<th colspan='3'>$sh->case_type</th>";
                                    $i++;
                                }
                            }
                        -->
			    <th colspan='3'>Enquiry</th>
			    <th colspan='3'>Feedback</th>
			    <th colspan='3'>Complaint</th>
                        </tr>
                        <tr>
                        <!--
                            foreach($header as $h){
                                //echo "<td>Total</td><td>Average Solved Time</td><td>Resolved</td>";
                            }
                            
                        -->
			<td>Total</td><td>Average Solved Time</td><td>Resolved</td>
			<td>Total</td><td>Average Solved Time</td><td>Resolved</td>
			<td>Total</td><td>Average Solved Time</td><td>Resolved</td>
                        </tr>
                        </thead>
                    
                        <!--
                            $array = array();
                            
                            foreach($show as $sh){
                                if(!in_array($sh->product_name,$array))
                                {
                                    echo "<tr>";
                                    $array[] = $sh->product_name;
                                    echo "<td>$sh->product_name</td>";
				    echo "<td>$sh->total</td>";
                                    echo "</tr>";
                                }
                            }
                            */
                        -->
			<?php
			    foreach($show as $sh){
				echo "<tr>";
                                echo "<td>$sh->product_name</td>";
				echo "<td>$sh->enquiry</td>";
				echo "<td>".round($sh->enquiry_time,2)."</td>";
				echo "<td>$sh->enquiry_solv</td>";
				echo "<td>$sh->feedback</td>";
				echo "<td>".round($sh->feedback_time)."</td>";
				echo "<td>$sh->feedback_solv</td>";
				echo "<td>$sh->complaint</td>";
				echo "<td>".round($sh->complaint_time)."</td>";
				echo "<td>$sh->complaint_solv</td>";
                                echo "</tr>";
			    }
			?>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script type="text/javascript">
   $(document).ready(function () {
	    var totalProduct = $( "#countproduct" ).val();
	    var gauge=[];
	    for (var i=0;i<totalProduct;i++)
	    { 
		gauge[i] = new JustGage({
                id: "gaugeDemo"+i,
                value : $( "#gaugValue"+i ).val(),
                min: 0,
                max: 100,
            });
	    }
            
            $('#datepickerField1').datepicker();
	    $('#datepickerFieldResponse').datepicker();
	    $('#datepickerFieldResponse1').datepicker();
	    $('#datepickerFieldResolution').datepicker();
	    $('#datepickerFieldResolution1').datepicker();
	    
	    $('#filt').click(function(){
		var chanel = $( "#slcFilter" ).val();
		var dateFrom1 = new Date($( "#datepickerField" ).val());
		var dateTo1 = new Date($( "#datepickerField1" ).val());
		var dateFrom = $( "#datepickerField" ).val();
		var dateTo = $( "#datepickerField1" ).val();
		var filterElement = $(this);
		
		if (dateFrom1 > dateTo1) {
		    //code
		    alert('Start Date Greater Than End Date');
		}
		else if ($( "#slcFilter" ).val()== 'select channel') {
		    alert('Please Select Channel');
		}
		else{
		    filterElement.val("Filtering...").attr("disabled", "disabled");
		    $.ajax({
		    type: "GET",
		    url: "reports/report_ajax/filter",
		    data: { channel: chanel, dateFrom: dateFrom, dateTo: dateTo},
		    success: function(msg){
		    filterElement.val("Filter").removeAttr("disabled");
		    $("#NoOfCase").html(msg);
		    
		}
	      });
		}
	    });
	    
	    
	    $('#filtResponse').click(function(){
		var product 	= $( "#slcFilterProduct" ).val();
		var dateFrom1 	= new Date($( "#datepickerFieldResponse" ).val());
		var dateTo1	= new Date($( "#datepickerFieldResponse1" ).val());
		var dateFrom 	= $( "#datepickerFieldResponse" ).val();
		var dateTo 	= $( "#datepickerFieldResponse1" ).val();
		var filterElement1 = $(this);
		
		if (dateFrom1 > dateTo1) {
		    //code
		    alert('Start Date Greater Than End Date');
		}
		else if ($( "#slcFilterProduct" ).val()== 'select product') {
		    alert('Please Select Product');
		}
		else{
		    filterElement1.val("Filtering...").attr("disabled", "disabled");
		    
		    $.ajax({
		    type: "GET",
		    url: "reports/report_ajax/filterResponse",
		    data: { product: product, dateFrom: dateFrom, dateTo: dateTo},
		    success: function(msgRespon){
			filterElement1.val("Filter").removeAttr("disabled");
			$("#Response").html(msgRespon);    
		    }
		  });	
		}
	    });
	    
	    $('#filtResolution').click(function(){
		var product 	= $( "#slcFilterProduct1" ).val();
		var dateFrom1 	= new Date($( "#datepickerFieldResolution" ).val());
		var dateTo1	= new Date($( "#datepickerFieldResolution1" ).val());
		var dateFrom 	= $("#datepickerFieldResolution" ).val();
		var dateTo 	= $("#datepickerFieldResolution1" ).val();
		var filterElement2 = $(this);
		
		if (dateFrom1 > dateTo1) {
		    //code
		    alert('Start Date Greater Than End Date');
		}
		else if ($( "#slcFilterProduct1" ).val()== 'select product') {
		    alert('Please Select Product');
		}
		else{
		    filterElement2.val("Filtering...").attr("disabled", "disabled");
		    
		    $.ajax({
		    type: "GET",
		    url: "reports/report_ajax/filterResolution",
		    data: { product: product, dateFrom: dateFrom, dateTo: dateTo},
		    success: function(msgResol){
			 filterElement2.val("Filter").removeAttr("disabled");
			 $("#Resolution").html(msgResol);
			
		    }
		  });
		}
	      });
        });
</script>