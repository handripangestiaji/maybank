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
                
                thisButton.find("span").html('Create').removeAttr('disabled');
                $('#report .table tbody').html('');
                var productList = response[3];
                for(var i=0; i< productList.length; i++){
                    var summary = firstLane = secondLane = "<td colspan='3'>No Result</td>" ;
                    for(var x=0; x<response[2].length; x++){
                        if(productList[i].id == response[2][x].id){
                            summary = "<td class='cols1'>" + response[2][x].total_case +"</td><td class='cols2'>" + response[2][x].total_solved +"</td><td class='cols3'>" +  timeConverter(response[2][x].average_response) +"</td>";
                        }
                    }
                    for(var y=0; y < response[0].length; y++){
                         if(productList[i].id == response[0][y].id){
                            firstLane = "<td class='cols4'>" + response[0][y].total_case +"</td><td class='cols5'>" + response[0][y].total_solved +"</td><td class='cols6'>" +  timeConverter(response[0][y].average_response) +"</td>";
                        }
                    }
                    for(var z=0; z<response[1].length; z++){
                         if(productList[i].id == response[1][z].id){
                            secondLane = "<td class='cols7'>" + response[1][z].total_case +"</td><td class='cols8'>" + response[1][z].total_solved +"</td><td class='cols9  '>" +  timeConverter(response[1][z].average_response)+"</td>";
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
                    var productList = response[3];
                    for(var i=0; i< productList.length; i++){
                        var summary = firstLane = secondLane = "<td colspan='3'>No Result</td>" ;
                        for(var x=0; x<response[2].length; x++){
                            if(productList[i].id == response[2][x].id){
                                summary = "<td>" + response[2][x].total_case +"</td><td>" + response[2][x].total_solved +"</td><td>" +  timeConverter(response[2][x].average_response) +"</td>";
                            }
                        }
                        for(var y=0; y < response[0].length; y++){
                             if(productList[i].id == response[0][y].id){
                                firstLane = "<td>" + response[0][y].total_case +"</td><td>" + response[0][y].total_solved +"</td><td>" +  timeConverter(response[0][y].average_response) +"</td>";
                            }
                        }
                        for(var z=0; z<response[1].length; z++){
                             if(productList[i].id == response[1][z].id){
                                secondLane = "<td>" + response[1][z].total_case +"</td><td>" + response[1][z].total_solved +"</td><td>" +  timeConverter(response[1][z].average_response)+"</td>";
                            }
                        }
                        var isHidden = productList[i].parent_id != null;
                        $('#report .table tbody').append('<tr id="pId' + productList[i].id+ '" class=' + (isHidden ? '"hide ' + productList[i].id + '" style="display:none"' : ''  ) + '"><td>' +
                                productList[i].product_name + '</td>' + summary + firstLane + secondLane + (isHidden ? '<td><button class="btn btn-info toggleSub">Show</button></td>' : '')  +'</tr>')
                        
                        
                    }
                },
                "error" : function(){
                     $('#report .table tbody').html('<tr><td colspan="11" style="text-align: center">No Result</td></tr>');
                }
            });
        });
    });
    function timeConverter(UNIX_timestamp){
    var a = new Date(UNIX_timestamp*1000);
        var hour = a.getHours();
        var min = a.getMinutes();
        var sec = a.getSeconds();
        var time = hour+' hour '+min+' minutes ';
        return time;
    }
    
    $.fn.Calculate = function(){
        $(this).each(function(){
             
        });
    }
    
})