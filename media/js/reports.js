/*
 * Created By CloudMOtion
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
                'date_finish' : $('#dateFinish').val()
            },
            "type" : "POST",
            "success" : function(response){
                
                thisButton.createReportTable(response);
                
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
        var productList = response[3];
        for(var i=0; i< productList.length; i++){
            var summary = firstLane = secondLane = "<td colspan='3'>No Result</td>" ;
            for(var x=0; x<response[2].length; x++){
                if(productList[i].id == response[2][x].id){
                    summary = "<td class='cols1'>" + response[2][x].total_case +"</td><td class='cols2'>" + response[2][x].total_solved +"</td><td class='cols3 time-value'><input type='hidden' value='" + response[2][x].average_response + "'/>" +  timeConverter(response[2][x].average_response) +"</td>";
                }
            }
            for(var y=0; y < response[0].length; y++){
                 if(productList[i].id == response[0][y].id){
                    firstLane = "<td class='cols4'>" + response[0][y].total_case +"</td><td class='cols5'>" + response[0][y].total_solved +"</td><td class='cols6 time-value'><input type='hidden' value='" + response[0][y].average_response + "'/>" +  timeConverter(response[0][y].average_response) +"</td>";
                }
            }
            for(var z=0; z<response[1].length; z++){
                 if(productList[i].id == response[1][z].id){
                    secondLane = "<td class='cols7'>" + response[1][z].total_case +"</td><td class='cols8'>" + response[1][z].total_solved +"</td><td class='cols9 time-value'><input type='hidden' value='" + response[1][z].average_response + "'/>" +  timeConverter(response[1][z].average_response)+"</td>";
                }
            }
            var isHidden = productList[i].parent_id > 0;
            $('#report .table tbody').append('<tr id="pId' + productList[i].id+ '" class="pId'+ productList[i].parent_id +  '"><td>' +
                        productList[i].product_name + '</td>' + summary + firstLane + secondLane + (!isHidden ? '<td><button class="btn toggleSub">Show</button></td>' : '')  +'</tr>')
            
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
        var summary = []; 
        $('#report .table tbody td').each(function(){
            for(i=0;i<10;i++){
                summary[i] = summary[i] == undefined ? 0 : summary[i];
                if($(this).hasClass('cols' + i.toString())){
                    
                    summary[i] += $(this).hasClass('time-value') ? parseFloat($(this).find('input').val()) : parseFloat($(this).html());
                    
                }
            }
        });
        for(i=0;i<summary.length; i++){
            if(i%3 == 0){
                $('#report .table tfoot td.sum'+ i).html(timeConverter(summary[i]));
            }
            else
                $('#report .table tfoot td.sum'+ i).html(summary[i]);
        }
        $('.table tfoot .btn-download').val($('#report .table').html());
    }
    
    $(this).on('click', '#btn-download-report-activity', function(){
         $.ajax({
            url : BASEURL + 'reports/report_ajax/PrintReportActivity',
            type: "POST",
            data: {
                date_start: $('#dateStart').val(),
                date_finish: $('#dateFinish').val(),
                country: $('#reportCountry').val(),
                group: $('#reportUserGroup').val(),
                user: $('#reportUserList').val()
            }
        });
    });
    

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
                console.log(result);
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
                console.log(result);
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
    
    function generatePagination(total_count, limit, current_offset){
        //segments = count_all_records / limit
        var segments = Math.floor(total_count / limit);
        console.log(segments);
        
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