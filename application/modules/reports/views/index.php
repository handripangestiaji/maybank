<div class="row-fluid" style="width: 100%; margin: 0px auto;">
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
                    <select>
                        <option>select channel</option>
                    </select>
                </div>
                <div style="float: left;margin-left: 75px;">
                    <input id="datepickerField" type="text" placeholder="Data From" />
                    <input id="datepickerField1" type="text" placeholder="Data To" />
                </div>
                <div style='clear: both;'></div>
            </div>
            
            <hr>
            
            <div style='margin-top: 10px;'>
                <span style='font-size:16px;'>TOTAL CASES: <b>1,034</b></span>
                <span style='font-size: 16px; margin-left: 20px;'>RESOLVED: <b>920</b></span>
                <span style='font-size: 16px; margin-left: 20px;'>Percentage: <b>94%</b></span>
            </div>
            
            <div style='float: left; width: 300px; height: 300px;'>
                <ul class="gaugeContainers">
                    <li id="gaugeDemo1"></li>
                    <li style='float: left; margin-left: 18%; text-align: center;'><span style='font-weight: bold;'>FEEDBACK</span></li>
                </ul>
            </div>
            <div style='float: left; width: 300px; height: 300px;'>
                <ul class="gaugeContainers">
                    <li id="gaugeDemo2"></li>
                    <li style='float: left; margin-left: 18%; text-align: center;'><span style='font-weight: bold;'>ENQUIRIES</span></li>
                </ul>
            </div>
            <div style='float: left; width: 300px; height: 300px;'>
                <ul class="gaugeContainers">
                    <li id="gaugeDemo3"></li>
                    <li style='float: left; margin-left: 18%;'><span style='font-weight: bold;'>COMPLAINT</span></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script type="text/javascript">
   $(document).ready(function () {
            var gaugeDemo1 = new JustGage({
                id: "gaugeDemo1",
                value : 50,
                min: 0,
                max: 100,
            });
            var gaugeDemo2 = new JustGage({
                id: "gaugeDemo2",
                value : 50,
                min: 0,
                max: 100,
            });
            var gaugeDemo3 = new JustGage({
                id: "gaugeDemo3",
                value : 50,
                min: 0,
                max: 100,
            });
            
            $('#datepickerField1').datepicker();
        });
</script>