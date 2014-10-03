/*
 * Created By CloudMotion
 * Section Report Module
 */


$(function(){
    // Retrieve Element Filter AJAX
    $('#reportDatePicker input').datepicker({
        endDate : new Date(),
        format : "yyyy/mm/dd",
        startDate : new Date("2014/3/31")
    });
    $(this).on('change', '#reportCountry', function(){
        if($(this).val() == '') return;
        $('#reportChannel').attr('disabled', 'disabled');
        $('#reportChannel option,#reportUserGroup option ').remove();
        $('#reportUserGroup').attr('disabled', 'disabled');
        $.ajax({
           "url" : BASEURL + "reports/report_ajax/ChannelList/" + $(this).val(),
           "data" : "",
           "type" : "GET",
           "success" : function(response){
                for(i=0;i<response.length;i++)
                    $('#reportChannel').append($('<option>', {
                        value: response[i].channel_id,
                        text: response[i].name + "(" + response[i].connection_type + ")"
                    }));
                    $('#reportChannel').removeAttr('disabled');
           }
        });
        $.ajax({
            "url" : BASEURL + "reports/report_ajax/UserGroupList/" + $(this).val(),
            "data" : "",
            "type" : "GET",
            "success" : function(response){ 
                $('#reportUserGroup').append($('<option>', {
                    value: null,
                    text: 'All'
                }));
                for(i=0;i<response.length;i++)
                    $('#reportUserGroup').append($('<option>', {
                        value: response[i].group_id,
                        text: response[i].group_name
                    }));
                $('#reportUserGroup').removeAttr('disabled');
            }
        });
        $('#reportUserList').html('');
        $('#reportUserList').attr('disabled','disabled');
    });
    
    
    $(this).on('change','#reportUserGroup', function(){
       if($('#reportUserList').length > 0){
            $.ajax({
               "url" : BASEURL + "reports/report_ajax/GetUserList/" ,
               "data" : "group_id=" + $(this).val(),
               "type" : "GET",
               "success" : function(response){
                $('#reportUserList').find('option').remove();
                $('#reportUserList').append($('<option>', {
                    value: null,
                    text: 'All'
                }));
                  for(i=0;i<response.length;i++)
                    $('#reportUserList').append($('<option>', {
                        value: response[i].user_id,
                        text: response[i].full_name + "(" + response[i].username + ")"
                    }));
                    $('#reportUserList').removeAttr('disabled');
               }
            });
       }
    });
    //GENERATE REPORT
    $(this).on('click', '#reportCreate', function(e){
        $('.btn-download').hide();
        $(this).find("span").html('Creating...').attr('disabled', 'disabled');
        $('#report .table tbody').html('<tr><td colspan="11" style="text-align: center">Creating Report...</td></tr>');
        var thisButton = $(this);
        printedProduct = [];
        $.ajax({
            "url" : BASEURL + "reports/report_ajax/CreateReport",
            "data" : {
                "channel_id" : $('#reportChannel').val(),
                "group_id" : $('#reportUserGroup').val(),
                'date_start' : $('#dateStart').val(),
                'date_finish' : $('#dateFinish').val(),
                'type' : $('#reportType').val(),
                'case_type' : $('#caseType').val(),
                'user' : $('#reportUserList').val(),
                'country' : $('#reportCountry').val()
            },
            "type" : "POST",
            "success" : function(response){
                if (response.is_download == true) {
                    $('.btn-download').show();
                }
                
                if (response.type == 'case') {
                    thisButton.createReportTable(response);
                }
                else{
                    thisButton.createReportTableEngagement(response);
                }
            },
            "error" : function(response){
                data = JSON.parse(response.responseText);
                $('#content .alert ').show('slow');
                thisButton.find("span").html('Create').removeAttr('disabled');
                $('#content .alert .help-inline').html('');
                for(var i =0; i<data.length; i++){
                    $('#content .alert .help-inline').append('<span class="data">' + data[i].message + '</span> <br />');
                }
            }
        })
    });
    
    $('#caseType').change(function(){
        if($(this).val() == '') return;
        $('#report .table tbody').html('<tr><td colspan="11" style="text-align: center">Filtering Report...</td></tr>');
        $.ajax({
            "url" : BASEURL + "reports/report_ajax/CreateReport",
            "data" : {
                'channel_id' : $('#reportChannel').val(),
                'group_id' : $('#reportUserGroup').val(),
                'date_start' : $('#dateStart').val(),
                'date_finish' : $('#dateFinish').val(),
                'type' : $('#reportType').val(),
                'case_type' : $(this).val(),
                'user' : $('#reportUserList').val()
            },
            "type" : "POST",
            "success" : function(response){
                if (response.type == 'case') {
                    $('#report .table tbody').html('');
                    $('#reportCreate').createReportTable(response);
                }
                else{
                    $('#report .table tbody').html('');
                    $('#reportCreate').createReportTableEngagement(response);
                }
            },
            "error" : function(response){
                data = JSON.parse(response.responseText);
                $('#content .alert ').show('slow');
                thisButton.find("span").html('Create').removeAttr('disabled');
                $('#content .alert .help-inline').html('');
                for(var i =0; i<data.length; i++){
                    $('#content .alert .help-inline').append('<span class="data">' + data[i].message + '</span> <br />');
                }
            }
        });
    });
    
    function timeConverter(UNIX_timestamp){
    var a = new Date(UNIX_timestamp*1000);
        var day = a.getDate();
        var hour = a.getHours();
        var min = a.getMinutes();
        var sec = a.getSeconds();
        
        var time =  hour+' hour '+min+' minutes ';
        time = day != 0 ? (day + (30 * a.getMonth())).toString() + " days " + time : time;
        return time;
    }
    
    $.fn.createReportTable = function(response){
        $('#table_title').html('Case');
        $('.td_total').show();
        $('.total_engagement_received').hide();
        $('#th_cat_filter').attr('colspan',3);
        $('#th_wall_post').attr('colspan',3);
        $('#th_pm').attr('colspan',3);
        $('#total_replied').html('Total');
        $(this).find("span").html('Create').removeAttr('disabled');
        
        var parent_array_id = 0;
        if (response.status == 'success') {
            for(var i=0; i< response.product_list.length; i++){
                var summary = firstLane = secondLane = "<td colspan='3'>No Result</td>" ;
                firstLane = "<td colspan='3' class='summary'>No Result</td>";
                secondLane = "<td colspan='3' class='summary'>No Result</td>";
                
                if(response.product_list[i].parent_id > 0){
                    if (response.product_list[i].count_cases_total != 0){
                        summary = "<td>" + response.product_list[i].count_cases_total + "</td><td>" + response.product_list[i].count_cases_total_resolved + "</td><td>" + response.product_list[i].avg_respond_time_total_string + "</td>";
                    }
                    
                    if (response.product_list[i].count_cases_wall_post != 0) {
                        firstLane = "<td>" + response.product_list[i].count_cases_wall_post + "</td><td>" + response.product_list[i].count_cases_wall_post_resolved + "</td><td>" + response.product_list[i].avg_respond_time_wall_post_string + "</td>";
                    }
                    
                    if (response.product_list[i].count_cases_pm != 0) {
                        secondLane = "<td>" + response.product_list[i].count_cases_pm + "</td><td>" + response.product_list[i].count_cases_pm_resolved + "</td><td>" + response.product_list[i].avg_respond_time_pm_string + "</td>";
                    }
                    
                    $('#report .table tbody').append('<tr id="pId' + response.product_list[i].id + '" class="pId'+ response.product_list[i].parent_id +  '"><td>' +
                        response.product_list[i].product_name + '</td>' + summary + firstLane + secondLane + '</tr>')
                }
                else{
                    if (response.parents[parent_array_id].count_cases_total != 0){
                        summary = "<td>" + response.parents[parent_array_id].count_cases_total + "</td><td>" + response.parents[parent_array_id].count_cases_total_resolved + "</td><td>" + response.parents[parent_array_id].avg_respond_time_total_string + "</td>";
                    }
                    
                    if (response.parents[parent_array_id].count_cases_wall_post != 0){
                        firstLane = "<td>" + response.parents[parent_array_id].count_cases_wall_post + "</td><td>" + response.parents[parent_array_id].count_cases_wall_post_resolved + "</td><td>" + response.parents[parent_array_id].avg_respond_time_wall_post_string + "</td>";
                    }
                    
                    if (response.parents[parent_array_id].count_cases_pm != 0){
                        secondLane = "<td>" + response.parents[parent_array_id].count_cases_pm + "</td><td>" + response.parents[parent_array_id].count_cases_pm_resolved + "</td><td>" + response.parents[parent_array_id].avg_respond_time_pm_string + "</td>";
                    }
                    
                    $('#report .table tbody').append('<tr id="pId' + response.product_list[i].id + '" class="pId'+ response.product_list[i].parent_id +  '"><td><strong>' +
                        response.product_list[i].product_name + '</strong></td>' + summary + firstLane + secondLane + '<td><button class="btn toggleSub">Show</button></td></tr>')
                    parent_array_id++;
                }
            }
            
            $('#report .table .resolved').html('Resolved');
            $('#report .table .avg_time').html('Avg Respond Time');
            
            $('#report .table tbody > :not(tr.pIdnull)').toggle('fast');
            $('#report .table .toggleSub').click(function(){
                idTrParent = $(this).closest('tr').attr('id');
                $('.' + idTrParent).toggle('slow');
                if($(this).html() == "Show")
                    $(this).html('Hide');
                else
                    $(this).html('Show');
            });
            
            $('#report .table tfoot .sum1').html(response.all.cases_total);
            $('#report .table tfoot .sum2').html(response.all.cases_total_resolved);
            $('#report .table tfoot .sum3').html(response.all.avg_respond_time_total);
            $('#report .table tfoot .sum4').html(response.all.cases_wall_post);
            $('#report .table tfoot .sum5').html(response.all.cases_wall_post_resolved);
            $('#report .table tfoot .sum6').html(response.all.avg_respond_time_wall_post);
            $('#report .table tfoot .sum7').html(response.all.cases_pm);
            $('#report .table tfoot .sum8').html(response.all.cases_pm_resolved);
            $('#report .table tfoot .sum9').html(response.all.avg_respond_time_pm);
            
            $('#total_engagement_received_value').html(0);
            $('#total_wall_post_engagement_received_value').html(0);
            $('#total_pm_engagement_received_value').html(0);
            $('#total_unattended_value').html(0);
            $('#total_wall_post_unattended_value').html(0);
            $('#total_pm_unattended_value').html(0);
        }
        else{
            $('#report .table tbody').html('<tr><td colspan="11" style="text-align: center">No Result</td></tr>');
            for(i=1;i<=9;i++){
                $('#report .table tfoot .sum' + i).html('0');
            }
        }
    }

    $.fn.createReportTableEngagement = function(response){
        $('#report .table .resolved').html('Engagement');
        $('#report .table .avg_time').html('Avg Respond Time');
            
        $('#total_engagement_received_value').html(0);
        $('#total_wall_post_engagement_received_value').html(0);
        $('#total_pm_engagement_received_value').html(0);
        $('#total_unattended_value').html(0);
        $('#total_wall_post_unattended_value').html(0);
        $('#total_pm_unattended_value').html(0);
            
        $('#table_title').html('Engagement');
        $('.td_total').hide();
        $('.total_engagement_received').show();
        $('#th_cat_filter').attr('colspan',2);
        $('#th_wall_post').attr('colspan',2);
        $('#th_pm').attr('colspan',2);
        $('#total_replied').html('Total Replied');
        $(this).find("span").html('Create').removeAttr('disabled');
        
        var parent_array_id = 0;
        if (response.status == 'success') {
            for(var i=0; i< response.product_list.length; i++){
                var summary = firstLane = secondLane = "<td colspan='2'>No Result</td>" ;
                firstLane = "<td colspan='2' class='summary'>No Result</td>";
                secondLane = "<td colspan='2' class='summary'>No Result</td>";
                
                if(response.product_list[i].parent_id > 0){
                    if (response.product_list[i].count_engagement_total != 0){
                        summary = "<td>" + response.product_list[i].count_engagement_total + "</td><td>" + response.product_list[i].avg_respond_time_total_string + "</td>";
                    }
                    
                    if (response.product_list[i].count_engagement_wall_post != 0) {
                        firstLane = "<td>" + response.product_list[i].count_engagement_wall_post + "</td><td>" + response.product_list[i].avg_respond_time_wall_post_string + "</td>";
                    }
                    
                    if (response.product_list[i].count_engagement_pm != 0) {
                        secondLane = "<td>" + response.product_list[i].count_engagement_pm + "</td><td>" + response.product_list[i].avg_respond_time_pm_string + "</td>";
                    }
                    
                    $('#report .table tbody').append('<tr id="pId' + response.product_list[i].id + '" class="pId'+ response.product_list[i].parent_id +  '"><td>' +
                        response.product_list[i].product_name + '</td>' + summary + firstLane + secondLane + '</tr>')
                }
                else{
                    if (response.parents[parent_array_id].count_engagement_total != 0){
                        summary = "<td>" + response.parents[parent_array_id].count_engagement_total + "</td><td>" + response.parents[parent_array_id].avg_respond_time_total_string + "</td>";
                    }
                    
                    if (response.parents[parent_array_id].count_engagement_wall_post != 0){
                        firstLane = "<td>" + response.parents[parent_array_id].count_engagement_wall_post + "</td><td>" + response.parents[parent_array_id].avg_respond_time_wall_post_string + "</td>";
                    }
                    
                    if (response.parents[parent_array_id].count_engagement_pm != 0){
                        secondLane = "<td>" + response.parents[parent_array_id].count_engagement_pm + "</td><td>" + response.parents[parent_array_id].avg_respond_time_pm_string + "</td>";
                    }
                    
                    $('#report .table tbody').append('<tr id="pId' + response.product_list[i].id + '" class="pId'+ response.product_list[i].parent_id +  '"><td><strong>' +
                        response.product_list[i].product_name + '</strong></td>' + summary + firstLane + secondLane + '<td><button class="btn toggleSub">Show</button></td></tr>')
                    parent_array_id++;
                }
            }
            
            $('#report .table tbody > :not(tr.pIdnull)').toggle('fast');
            $('#report .table .toggleSub').click(function(){
                idTrParent = $(this).closest('tr').attr('id');
                $('.' + idTrParent).toggle('slow');
                if($(this).html() == "Show")
                    $(this).html('Hide');
                else
                    $(this).html('Show');
            });
            
            $('#report .table tfoot .sum1').html(0);
            $('#report .table tfoot .sum2').html(response.all.engagement_total);
            $('#report .table tfoot .sum3').html(response.all.avg_respond_time_total);
            $('#report .table tfoot .sum4').html(0);
            $('#report .table tfoot .sum5').html(response.all.engagement_wall_post);
            $('#report .table tfoot .sum6').html(response.all.avg_respond_time_wall_post);
            $('#report .table tfoot .sum7').html(0);
            $('#report .table tfoot .sum8').html(response.all.engagement_pm);
            $('#report .table tfoot .sum9').html(response.all.avg_respond_time_pm);
            
            $('#total_engagement_received_value').html(response.customer_engagement.count_ce);
            $('#total_wall_post_engagement_received_value').html(response.customer_engagement.count_ce_wall_post);
            $('#total_pm_engagement_received_value').html(response.customer_engagement.count_ce_pm);
            $('#total_unattended_value').html(response.unattended.count_total);
            $('#total_wall_post_unattended_value').html(response.unattended.count_wall_post);
            $('#total_pm_unattended_value').html(response.unattended.count_pm);
        }
        else{
            $('#report .table tbody').html('<tr><td colspan="11" style="text-align: center">No Result</td></tr>');
            for(i=1;i<=9;i++){
                $('#report .table tfoot .sum' + i).html('0');
            }
            $('#total_engagement_received_value').html(response.customer_engagement.count_ce);
            $('#total_wall_post_engagement_received_value').html(response.customer_engagement.count_ce_wall_post);
            $('#total_pm_engagement_received_value').html(response.customer_engagement.count_ce_pm);
            $('#total_unattended_value').html(response.unattended.count_total);
            $('#total_wall_post_unattended_value').html(response.unattended.count_wall_post);
            $('#total_pm_unattended_value').html(response.unattended.count_pm);
        }
    }
    
    $('.x-pagination').on('click',function(){
        var me = $(this);
        var offset = me.attr('data-offset');
        var limit = me.attr('data-limit');
        
        $.ajax({
            url : BASEURL + 'reports/report_ajax/GetReportActivity',
            type: "POST",
            data: {
                limit: limit,
                offset: offset,
                date_start: $('#dateStart').val(),
                date_finish: $('#dateFinish').val(),
                country: $('#reportCountry').val(),
                group: $('#reportUserGroup').val(),
                user: $('#reportUserList').val()
            },
            success: function(result)
            {
                //console.log(result);
                $('#report_activity_table').find('tbody').html('');
                for(var x=0; x < result.records.length; x++){
                    $('#report_activity_table').find('tbody').append(
                        '<tr>' +
                            '<td>' + result.records[x].time + '</td>' +
                            '<td>' + result.records[x].username + '</td>' +
                            '<td>' + result.records[x].rolename + '</td>' +
                            '<td>' + result.records[x].action + '</td>' +
                            '<td>' + result.records[x].status + '</td>' +
                        '</tr>'
                    );
                }
                generatePagination(result.count_total,limit,offset);
            },
        });
    });
    
    $('#reportCreateActivity').on('click',function(){
        var limit = 20;
        var offset = 0;
        
        $.ajax({
            url : BASEURL + 'reports/report_ajax/GetReportActivity',
            type: "POST",
            data: {
                limit: 20,
                offset: 0,
                date_start: $('#dateStart').val(),
                date_finish: $('#dateFinish').val(),
                country: $('#reportCountry').val(),
                group: $('#reportUserGroup').val(),
                user: $('#reportUserList').val()
            },
            success: function(result)
            {
                //console.log(result);
                $('#report_activity_table').find('tbody').html('');
                for(var x=0; x < result.records.length; x++){
                    $('#report_activity_table').find('tbody').append(
                        '<tr>' +
                            '<td>' + result.records[x].time + '</td>' +
                            '<td>' + result.records[x].username + '</td>' +
                            '<td>' + result.records[x].rolename + '</td>' +
                            '<td>' + result.records[x].action + '</td>' +
                            '<td>' + result.records[x].status + '</td>' +
                        '</tr>'
                    );
                }
                generatePagination(result.count_total,limit,offset);
            },
        });
    });
    
    $(this).on('click','.btn-download ', function(){
        var form = document.createElement("form");
        form.setAttribute("method", "POST");
        form.setAttribute("action", BASEURL + "reports/report_ajax/DownloadUserPerformance/" + $('#reportType').val() + ' - ' + $('#caseType').val());
        var hiddenField = document.createElement("input");
        var $table = $(this).closest('table').html();
        $table = $table.replace(/style="display: none;"/g,'');
        $table = $table.replace(/<tr ><td colspan="11" style="text-align: center">Creating Report...<\/td><\/tr>/g,'');
        $table = $table.replace(/Action/g,'');
        $table = $table.replace(/Show/g,'');
        $table = $table.replace(/Download/g,'');
       
        $table = $table.replace(/<option value="all">All<\/option>/g,'')
        $table = $table.replace(/<option value="Feedback">Feedback<\/option>/g,'')
        $table = $table.replace(/<option value="Compliment">Compliment<\/option>/g,'')
        $table = $table.replace(/<option value="Enquiry">Enquiries<\/option>/g,'')
        $table = $table.replace(/<option value="Complaint">Complaints<\/option>/g,'')
        $table = $table.replace(/<option value="Report_Abuse">Report Abuse<\/option>/g,'')
        $table = $table.replace(/<select name="case_type" id="caseType">/g,'');
        $table = $table.replace(/<\/select>/g,$(this).closest('table').find('#caseType').val());
        
        if ($('#reportType').val() == 'engagement') {
            $table = $table.replace(/<td class="td_total" >Total<\/td>/g,'');
            $table = $table.replace(/<td class="sum1 td_total" >0<\/td>/g,'');
            $table = $table.replace(/<td class="sum4 td_total" >0<\/td>/g,'');
            $table = $table.replace(/<td class="sum7 td_total" >0<\/td>/g,'');
        }
        else{
             $table = $table.replace(/<td>Total Engagement Received<\/td>/g,'');
             $table = $table.replace(/<td colspan="2" id="total_engagement_received_value">0<\/td>/g,'');
             $table = $table.replace(/<td colspan="2" id="total_wall_post_engagement_received_value">0<\/td>/g,'');
             $table = $table.replace(/<td colspan="2" id="total_pm_engagement_received_value">0<\/td>/g,'');
             
             $table = $table.replace(/<td>Total Unattended<\/td>/g,'');
             $table = $table.replace(/<td colspan="2" id="total_unattended_value">0<\/td>/g,'');
             $table = $table.replace(/<td colspan="2" id="total_wall_post_unattended_value">0<\/td>/g,'');
             $table = $table.replace(/<td colspan="2" id="total_pm_unattended_value">0<\/td>/g,'');
        }
        
        console.log($table);
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "table_download");
        hiddenField.setAttribute("value", "<table>" + $table + "</table>");
        
        form.appendChild(hiddenField);
        form.submit();
        form.remove();
    });
    
    
    $(this).on('click', '#btn-download-report-activity', function(){
        var form = document.createElement("form");
        form.setAttribute("method", "POST");
        form.setAttribute("action", BASEURL + "reports/report_ajax/PrintReportActivity");
        
        var dateStart = document.createElement("input");
        dateStart.setAttribute("type", "hidden");
        dateStart.setAttribute("name", "date_start");
        dateStart.setAttribute("value", $('#dateStart').val());
        
        var dateFinish = document.createElement("input");
        dateFinish.setAttribute("type", "hidden");
        dateFinish.setAttribute("name", "date_finish");
        dateFinish.setAttribute("value", $('#dateFinish').val());
        
        var country = document.createElement("input");
        country.setAttribute("type", "hidden");
        country.setAttribute("name", "country");
        country.setAttribute("value", $('#reportCountry').val());
        
        var group = document.createElement("input");
        group.setAttribute("type", "hidden");
        group.setAttribute("name", "group");
        group.setAttribute("value", $('#reportUserGroup').val());
        
        var user = document.createElement("input");
        user.setAttribute("type", "hidden");
        user.setAttribute("name", "user");
        user.setAttribute("value", $('#reportUserList').val());
        
        form.appendChild(dateStart);
        form.appendChild(dateFinish);
        form.appendChild(country);
        form.appendChild(group);
        form.appendChild(user);
        form.submit();
        form.remove();
    });
    
    function generatePagination(total_count, limit, current_offset){
        //segments = count_all_records / limit
        var segments = Math.floor(total_count / limit);
        
        //first
        $('.btn-pagination-first').attr('data-offset',0);
        $('.btn-pagination-first').attr('data-limit', limit);
        
        //last
        $('.btn-pagination-last').attr('data-offset',parseInt(segments) * parseInt(limit));
        $('.btn-pagination-last').attr('data-limit', limit);
        
        //prev
        if(current_offset != 0){
            $('.btn-pagination-prev').removeClass('disabled');
            $('.btn-pagination-first').removeClass('disabled');
            $('.btn-pagination-prev').attr('data-offset',parseInt(current_offset) - parseInt(limit));
            $('.btn-pagination-prev').attr('data-limit', limit);
        }
        else{
            $('.btn-pagination-prev').addClass('disabled');
            $('.btn-pagination-first').addClass('disabled');
        }
        
        //next
        if(current_offset < segments * 20){
            $('.btn-pagination-next').removeClass('disabled');
            $('.btn-pagination-last').removeClass('disabled');
            $('.btn-pagination-next').attr('data-offset',parseInt(current_offset) + parseInt(limit));
            $('.btn-pagination-next').attr('data-limit', limit);
        }
        else{
            $('.btn-pagination-next').addClass('disabled');
            $('.btn-pagination-last').addClass('disabled');
        }
        
        //numbers
    }
});


function time_elapsed(secs){
    var bit = {
        'y' : Math.floor((secs / 31556926) % 12),
        'w' : Math.floor((secs / 604800) % 52),
        'd' : Math.floor((secs / 86400) % 7),
        'h' : Math.floor((secs / 3600) % 24),
        'm' : Math.floor((secs / 60) % 60),
    };
    var text = '';
    for(o in bit){
        if(bit[o]>0)
            text += bit[o] +  o + " ";
    }
    return text;
}