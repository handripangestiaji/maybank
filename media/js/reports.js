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
        })
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
                'type' : $('#reportType').val()
            },
            "type" : "POST",
            "success" : function(response){
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
        
        $('#caseType').change(function(){
            if($(this).val() == '') return;
            $('#report .table tbody').html('<tr><td colspan="11" style="text-align: center">Filtering Report...</td></tr>');
            $.ajax({
                "url" : BASEURL + "reports/report_ajax/FilterReport",
                "data" : "case_type=" + $(this).val(),
                "type" : "GET",
                "success" : function(response){
                    $('#report .table tbody').html('');
                    $('#reportCreate').createReportTable(response);
                },
                "error" : function(){
                     $('#report .table tbody').html('<tr><td colspan="11" style="text-align: center">No Result</td></tr>');
                }
            });
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
        $(this).find("span").html('Create').removeAttr('disabled');
        $('#report .table tbody').html('');
        $('#report .table .resolved').html('Resolved');
        $('#report .table .avg_time').html('Avg Time');
        
        for(var i=0; i< response.product_list.length; i++){
            var summary = firstLane = secondLane = "<td colspan='3'>No Result</td>" ;
            summary = "<td colspan='3' class='summary'>No Result</td>";
            if(response.product_list[i].parent_id > 0){
                for(var x=0; x< response.main.length; x++){
                    var val = response.main[x].type == 'facebook' || response.main[x].type2 == 'homefeed' || response.main[x].type2 == 'mentions' ?
                        1 : 2;
                    if(response.product_list[i].id == response.main[x].id){
                        if(val == 1 )
                        firstLane = "<td class='cols" + (val*3 + 1) + "'>" + response.main[x].total_case +"</td><td class='cols" + (val*3 + 2) + "'>" +
                                    response.main[x].total_solved +"</td><td class='cols" + (val*3 + 3) + " time-value'><input type='hidden' value='" +
                                    response.main[x].average_response + "'/>" +  response.main[x].average_response_string +"</td>";
                        else if(val == 2)
                        secondLane = "<td class='cols" + (val*3 + 1) + "'>" + response.main[x].total_case +"</td><td class='cols" + (val*3 + 2) + "'>" +
                                    response.main[x].total_solved +"</td><td class='cols" + (val*3 + 3) + " time-value'><input type='hidden' value='" +
                                    response.main[x].average_response + "'/>" +  response.main[x].average_response_string +"</td>";
                        
                    }
                }
                $('#report .table tbody').append('<tr id="pId' + response.product_list[i].id + '" class="pId'+ response.product_list[i].parent_id +  '"><td>' +
                    response.product_list[i].product_name + '</td>' + summary + firstLane + secondLane + '</tr>')    
            }
            else{
                
                for(var z=0; z< response.main_per_parent.length; z++){
                    var val = response.main_per_parent[z].type == 'facebook' || response.main_per_parent[z].type2 == 'homefeed' || response.main_per_parent[z].type2 == 'mentions' ?
                        1 : 2;
                    if(response.product_list[i].id == response.main_per_parent[z].parent_id){
                        if(val == 1)
                        firstLane = "<td class='cols" + (val*3 + 1) + "'>" + response.main_per_parent[z].total_case +"</td><td class='cols" + (val*3 + 2) + "'>" +
                                    response.main_per_parent[z].total_solved +"</td><td class='cols" + (val*3 + 3) + " time-value'><input type='hidden' value='" +
                                    response.main_per_parent[z].average_response + "'/>" +  response.main_per_parent[z].average_response_string +"</td>";
                        else if(val == 2)
                        secondLane = "<td class='cols" + (val*3 + 1) + "'>" + response.main_per_parent[z].total_case +"</td><td class='cols" + (val*3 + 2) + "'>" +
                                    response.main_per_parent[z].total_solved +"</td><td class='cols" + (val*3 + 3) + " time-value'><input type='hidden' value='" +
                                    response.main_per_parent[z].average_response + "'/>" +  response.main_per_parent[z].average_response_string +"</td>";
                    }
                }
                $('#report .table tbody').append('<tr id="pId' + response.product_list[i].id + '" class="pId'+ response.product_list[i].parent_id +  '"><td>' +
                    response.product_list[i].product_name + '</td>' + summary + firstLane + secondLane + '<td><button class="btn toggleSub">Show</button></td></tr>')
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
        
        $('#report .table tbody tr').each(function(){
            var cols = [];
            for(i=4;i<=9;i++){
                if(i%3 != 0)
                    cols['cols'+ i] = $(this).find('.cols' + i).html() == undefined ||  $(this).find('.cols' + i).html() == '' ?
                    0 : parseInt($(this).find('.cols' + i).html());
                else
                    cols['cols' + i] = $(this).find('.cols' + i + '.time-value input').val() == undefined ? 0 :
                    parseFloat($(this).find('.cols' + i + ' input').val()) ;
            }
            $(this).find('.summary').attr('colspan', 0).addClass('cols1').after('<td class="cols2"></td><td class="cols3"></td>');
            $(this).find('.cols1' ).html((cols.cols4 + cols.cols7).toString());
            $(this).find('.cols2' ).html((cols.cols5 + cols.cols8).toString());
            $(this).find('.cols3' ).html("<input type='hidden' value='" + ((cols.cols6 + cols.cols9) / 2 )+ "' /> " + time_elapsed((cols.cols6 + cols.cols9) / 2));
        });
        for(i=1;i<=9;i++){
            var summary = 0;
            var x = 0;
            $('.cols' + i).each(function(){
                if(i%3 != 0){
                    summary += parseInt($(this).html());    
                }
                else{
                    console.log($(this).find('input').val());
                    summary += $(this).find('input').val() == undefined || $(this).find('input').val() == '' ||
                            $(this).find('input').val() == null || isNaN($(this).find('input').val()) ?
                            0 : parseFloat($(this).find('input').val()) ;
                }
                x++
            });
            
            if(i%3 != 0){
                $('#report .table tfoot .sum' + i).html(Math.floor(summary));
            }
            else{
                
                $('#report .table tfoot .sum' + i).html(time_elapsed(summary/x));
            }
        }
    }

    $.fn.createReportTableEngagement = function(response){
        $(this).find("span").html('Create').removeAttr('disabled');
        $('#report .table tbody').html('');
        $('#report .table tbody').html('');
        var parent_array_id = 0;
        for(var i=0; i< response.product_list.length; i++){
            var summary = firstLane = secondLane = "<td colspan='3'>No Result</td>" ;
            firstLane = "<td colspan='3' class='summary'>No Result</td>";
            secondLane = "<td colspan='3' class='summary'>No Result</td>";
            
            if(response.product_list[i].parent_id > 0){
                if (response.product_list[i].count_cases_total != 0){
                    summary = "<td>" + response.product_list[i].count_cases_total + "</td><td>" + response.product_list[i].count_engagement_total + "</td><td>" + response.product_list[i].avg_respond_time_total_string + "</td>";
                }
                
                if (response.product_list[i].count_cases_wall_post != 0) {
                    firstLane = "<td>" + response.product_list[i].count_cases_wall_post + "</td><td>" + response.product_list[i].count_engagement_wall_post + "</td><td>" + response.product_list[i].avg_respond_time_wall_post_string + "</td>";
                }
                
                if (response.product_list[i].count_cases_pm != 0) {
                    secondLane = "<td>" + response.product_list[i].count_cases_pm + "</td><td>" + response.product_list[i].count_engagement_pm + "</td><td>" + response.product_list[i].avg_respond_time_pm_string + "</td>";
                }
                
                $('#report .table tbody').append('<tr id="pId' + response.product_list[i].id + '" class="pId'+ response.product_list[i].parent_id +  '"><td>' +
                    response.product_list[i].product_name + '</td>' + summary + firstLane + secondLane + '</tr>')
            }
            else{
                if (response.parents[parent_array_id].count_cases_total != 0){
                    summary = "<td>" + response.parents[parent_array_id].count_cases_total + "</td><td>" + response.parents[parent_array_id].count_engagement_total + "</td><td>" + response.parents[parent_array_id].avg_respond_time_total_string + "</td>";
                }
                
                if (response.parents[parent_array_id].count_cases_wall_post != 0){
                    firstLane = "<td>" + response.parents[parent_array_id].count_cases_wall_post + "</td><td>" + response.parents[parent_array_id].count_engagement_wall_post + "</td><td>" + response.parents[parent_array_id].avg_respond_time_wall_post_string + "</td>";
                }
                
                if (response.parents[parent_array_id].count_cases_pm != 0){
                    secondLane = "<td>" + response.parents[parent_array_id].count_cases_pm + "</td><td>" + response.parents[parent_array_id].count_engagement_pm + "</td><td>" + response.parents[parent_array_id].avg_respond_time_pm_string + "</td>";
                }
                
                $('#report .table tbody').append('<tr id="pId' + response.product_list[i].id + '" class="pId'+ response.product_list[i].parent_id +  '"><td>' +
                    response.product_list[i].product_name + '</td>' + summary + firstLane + secondLane + '<td><button class="btn toggleSub">Show</button></td></tr>')
                parent_array_id++;
            }
        }
        
        $('#report .table .resolved').html('Engagement');
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
        $('#report .table tfoot .sum2').html(response.all.engagement_total);
        $('#report .table tfoot .sum3').html(response.all.avg_respond_time_total);
        $('#report .table tfoot .sum4').html(response.all.cases_wall_post);
        $('#report .table tfoot .sum5').html(response.all.engagement_wall_post);
        $('#report .table tfoot .sum6').html(response.all.avg_respond_time_wall_post);
        $('#report .table tfoot .sum7').html(response.all.cases_pm);
        $('#report .table tfoot .sum8').html(response.all.engagement_pm);
        $('#report .table tfoot .sum9').html(response.all.avg_respond_time_pm);
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
        form.setAttribute("action", BASEURL + "reports/report_ajax/DownloadUserPerformance");
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "table_download");
        hiddenField.setAttribute("value", "<table>" + $(this).val() + "</table>");
        
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