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
    $('#reportCountry').change(function(){
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
    $('#reportCreate').click(function(e){
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
                for(i = 0;i<response.length;   i++){
                    if(!$.inArray(response[i].product_name, printedProduct)){
                        $('#report .table tbody').append('<tr><td>' + response[i].product_name + '</td></tr>');
                    }
                    printedProduct[i] = response[i].product_name;        
                }
            }
        })
    });
    
    
})