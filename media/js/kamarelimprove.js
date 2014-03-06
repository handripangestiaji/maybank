/*
    This file was created by Eko Purnomo to improve kamarel.js
*/

$(function(){
    $('#countrySelect').multiselect();
  
    $('.sidebarContent').height($(window).height() * 0.95);
    $(this).on('submit', '.case-field form', function(e){
        var thisElement = $(this);
        $(this).find('button[type=submit]').attr('disabled', 'disabled');
        $(this).find('button[type=submit]').html('<i class="icon-stop icon-large"></i> Assigning case...');
        var openButton = $(this).closest('li').find('button:first');
        var fb_reassign=$(this).find('button[type=submit]').val();
        $.ajax({
            "url" : BASEURL + "case/mycase/CreateCase",
            "data" : $(this).serialize(),
            "type" : "POST",
            "success" : function(response){
                if(response.success){
                    thisElement.find('input[type=text], textarea, select').each(function(){
                        $(this).val(''); 
                    });
                    thisElement.find('.message').html('<div class="alert alert-success">' +
                    '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                    '<strong>Well done!</strong> CASE #' + response.result.case_id + " was made. " +  response.message + '</div>');
                    openButton.removeClass('btn-warning').addClass('btn-purple').html('CASE #' + response.result.case_id ).val(response.result.case_id);
                   
//                   if(fb_reassign != "reassign"){
//                        thisElement.closest('li').find('.btn-case').removeClass('btn-danger btn-case').addClass('btn-purple btn-resolve').html('<i class="icon-check"></i><span>RESOLVE</span>');
//                        thisElement.closest('li').find('.btn-case').parent().append('<button type="button" class="btn btn-danger btn-case" name="action" value="reassign"><i class="icon-plus"></i> <span>ReAssign</span></button>');
//                    }

                    thisElement.parent().parent().toggle('slow');
                }
                else{
                    var errorMessages = "<ul class='error-list'>";
                    for(i=0;i<response.errors.length;i++){
                        errorMessages += "<li>" + response.errors[i].message + "</li>";
                    }
                    errorMessages += "</ul>";
                    
                    thisElement.find('.message').html('<div class="alert alert-error">' +
                    '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                    '<h4>Something Wrong!</h4>' + response.message + ' See detail below:' + errorMessages +'</div>');
                }
                thisElement.find('button[type=submit]').removeAttr('disabled').html('<i class="icon-ok-circle icon-large"></i> Assign');
                thisElement.find(".email").tagit("removeAll");
            },
            "error" : function(response){
                thisElement.find('.message').html('<div class="alert alert-error">' +
                    '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                    '<h4>Something Wrong! </h4><p>System failed when creating new case. </p>');
                thisElement.find('button[type=submit]').removeAttr('disabled').html('<i class="icon-ok-circle icon-large"></i> Assign');
            }
        });
        e.preventDefault();
    });
    
    $(this).on('click', '.assign-case .twitter, .assign-case .twitter_dm', function(e){
        var modalID = $(this).attr("href");
        var twitter_id = $(modalID + " input[name=twitter_user_id]").val();
        var type = $(modalID + " input[name=type]").val();
        $(modalID + " .loader-image").show();
        $(modalID + " .related-conversation-body").remove();
        var textToAppend = "" ;
        
        $(this).LoadContentAsync({
            url : BASEURL + "case/mycase/TwitterRelatedConversation/" + twitter_id + "/" + type,
            urlParameter : {
                post_id : $(modalID + " input[name=twitter_user_id]").val()
            },
            callback : function(response){
                //console.log(response);
                $(modalID + " .loader-image").hide();
                var post_stream_id = [];
                console.log(response);
                if(response.length == 0)
                    $(modalId).append("<h2>No related conversation found.</h2>");
                else
                    for(i = 0; i<response.length;i++){
                        var myDate = new Date(response[i].social_stream_created_at + " UTC");
                        $(modalID + ' form').append(
                            '<div class="related-conversation-body">' + 
                            '<div><span class="related-conversation-btn-hide-show btn-close pull-right"><i class="icon-caret-down"></i></span>' + 
                            '<p class="headLine">' + 
                                '<input type="checkbox" class="related-conversation-check" value="' + response[i].post_id + '">' + 
                                '<span class="author">' +  response[i].name + '(@' + response[i].screen_name + ')</span>' + 
                                '<i class="icon-circle"></i>' + 
                                '<span class="UTCTimestamp">' + dateFormat(myDate, "mmmm dS, yyyy h:MM:ss TT") + '</span>' + 
                                '<i class="icon-play-circle moreOptions pull-right"></i>' +
                            '</p></div>' + 
                            '<div>' +
                                '<p>' + response[i].text + '</p>' +
                            '</div></div>'
                        );
                        
                    
                    }
                    
                
            }
        });
        
        
        
    });
    
    $(this).on('click', '.assign-case .facebook', function(e){
        var modalID = $(this).attr("href");
        var facebook_id = $(modalID).find("input[name=user_id]").val();
        var type = $(modalID + " input[name=type_facebook]").val();
       // alert(type)
        $(modalID + " .loader-image").show();
        $(modalID + " .related-conversation-body").remove();
        var textToAppend = "" ;
        var author_id = $(modalID).closest('.sender_id');
        var post_type;
        
        $(this).LoadContentAsync({
            url : BASEURL + "case/mycase/FacebookRelatedConversation/" + facebook_id + "/"+type,
            urlParameter : {
                post_id : $(modalID + " input[name=post_id]").val(),
                channel_id : $(this).closest('.floatingBox').find('input.channel-id').val(),
                //author_id:author_id
            },
            callback : function(response){
//                console.log(response.length);
                $(modalID + " .loader-image").hide();
                if(response.length>=1){
                    for(i = 0; i<response.length;i++){
                        var myDate = new Date(response[i].created_at + " UTC");
                        if(response[i].type=="facebook_comment"){
                            post_type="Wall Post";
                        }else{
                            post_type="Private Messages";
                        }   
                                             
                        $(modalID + ' form').append(
                             '<div class="related-conversation-body">' + 
                            '<span class="related-conversation-btn-hide-show btn-close pull-right"><i class="icon-caret-down"></i></span>' + 
                            '<p class="headLine">' + 
                                '<input type="checkbox" class="related-conversation-check" value="' + response[i].comment_post_id + '">' + 
                                '<span class="author">' +  response[i].name + '</span>' + 
                                '<i class="icon-circle"></i>' + 
                                '<span>posted a <span class="cyanText">'+ post_type +'</span></span>' + 
                                '<i class="icon-circle"></i>' + 
                                '<span class="UTCTimestamp">' +  dateFormat(myDate, "mmmm dS, yyyy h:MM:ss TT") + '</span>' + 
                                '<i class="icon-play-circle moreOptions pull-right"></i>' +
                            '</p>' + 
                            '<div>' +
                                '<p>' + response[i].comment_content + '</p>' +
                                '<!--p><button class="btn btn-primary btn-mini btn-reply" style="margin-left: 5px;">Reply</button></p-->' +
                            '</div></div>'
                        );
                       // $('.UTCTimestamp').localTimeFromUTC('MM/dd/yyyy hh:mm:ss a');
                    }
                }else{
                     $(modalID + ' form').append(
                             '<div class="related-conversation-body">' + 
                            '<span class="related-conversation-btn-hide-show btn-close pull-right"><i class="icon-caret-down"></i></span>' + 
                            '<h2>No related conversation exists.</h2>'
                        );
                }
            }
        });
    });
    
    $(this).on('click', '.assign-case .facebook_conversation', function(e){
        var modalID = $(this).attr("href");
        var facebook_id = $(modalID + " input[name=post_id]").val();
       // var author_id = $(modalID).closest('.sender_id');
       // console.log(author_id);
        var type = $(modalID + " input[name=type]").val();
        $(modalID + " .loader-image").show();
        //$(modalID + " .related-conversation-body").remove();
        var textToAppend = "" ;
        
        $(this).LoadContentAsync({
            url : BASEURL + "case/mycase/FacebookRelatedConversation/" + facebook_id + "/" + type,
            urlParameter : {
                post_id : $(modalID + " input[name=post_id]").val(),
                channel_id : $(this).closest('.floatingBox').find('input.channel-id').val(),                
            },
            callback : function(response){
                //console.log(response);
                $(modalID + " .loader-image").hide();
                if(response.length == 0)
                    $(modalId).append("<h2>No related conversation found.</h2>");
                for(i = 0; i<response.length;i++){
                      var myDate = new Date(response[i].created_at + " UTC");
                       if(response[i].type=="facebook_comment"){
                            post_type="Wall Post";
                        }else{
                            post_type="Private Messages";
                        }  
                    $(modalID + ' form').append(
                         '<div class="related-conversation-body">' + 
                        '<span class="related-conversation-btn-hide-show btn-close pull-right"><i class="icon-caret-down"></i></span>' + 
                        '<p class="headLine">' + 
                            '<input type="checkbox" class="related-conversation-check" value="' + response[i].comment_post_id + '">' + 
                            '<span class="author">' +  response[i].name + '</span>' + 
                            '<i class="icon-circle"></i>' + 
                            '<span>posted a <span class="cyanText">'+post_type+'</span></span>' +
                            '<i class="icon-circle"></i>' + 
                            '<span class="UTCTimestamp">' +  dateFormat(myDate, "mmmm dS, yyyy h:MM:ss TT") + '</span>' + 
                            '<i class="icon-play-circle moreOptions pull-right"></i>' +
                        '</p>' + 
                        '<div>' +
                            '<p>' + response[i].comment_content + '</p>' +
                            '<!--p><button class="btn btn-primary btn-mini btn-reply" style="margin-left: 5px;">Reply</button></p-->' +
                        '</div></div>'
                    );
                   
                }
                
            }
        });
    });
    
    $(this).on('click', '.case_related', function(e){
        
        var modalID = $(this).attr("href");
        var case_id=$(this).val();
        $(modalID + " .loader-image").show();
        $(modalID + " .related-conversation-body").remove();
        var textToAppend = "" ;

        $(this).LoadContentAsync({
            url : BASEURL + "case/mycase/GetCaseRelatedConversationItems/",
            urlParameter : {
                post_id : case_id,
                channel_id : $(this).closest('.floatingBox').find('input.channel-id').val(),                
            },
            callback : function(response){
                
                //alert(response.length);
                
                $(modalID + " .loader-image").hide();
                if(response.length == 0)
                    $(modalId).append("<h2>No related conversation found.</h2>");
                for(i = 0; i<response.length; i++){
                 if(response[i].type=="facebook_comment"){
                            post_type="Wall Post";
                 }else{
                            post_type="Private Messages";
                 }   
                    // var myDate = new Date(response[i].created_at + " UTC");
                    console.log(response)
                    if(response[i].name!=null){
                        $(modalID + ' form').append(
                             '<div class="related-conversation-body">' + 
                            '<span class="related-conversation-btn-hide-show btn-close pull-right"><i class="icon-caret-down"></i></span>' + 
                            '<p class="headLine">' +
                                '<span class="author">' +  response[i].name + '</span>' + 
                                '<i class="icon-circle"></i>' + 
                                '<span>posted a <span class="cyanText">'+post_type+'</span></span>' +
                                '<i class="icon-circle"></i>' + 
                                '<span class="UTCTimestamp">' +response[i].created_at + '</span>' + 
                                '<i class="icon-play-circle moreOptions pull-right"></i>' +
                            '</p>' + 
                            '<div>' +
                                '<p>' + response[i].comment_content + '</p>' +
                                '<!--p><button class="btn btn-primary btn-mini btn-reply" style="margin-left: 5px;">Reply</button></p-->' +
                            '</div></div>'
                        );
                    }else{
                       $(modalID + ' form').append(
                             '<div class="related-conversation-body">' + 
                            '<span class="related-conversation-btn-hide-show btn-close pull-right"><i class="icon-caret-down"></i></span>' + 
                            '<p class="headLine">'+ 
                            '<p>No related conversation attach.</p>'+
                            '</p>' + 
                            '</div>'
                        );
                    }                   
                }
            }
        });
    });
    
    $(this).on('click','.add-related-conversation', function(){
        var modalBody = $(this).parent().parent().find('.modal-body');
        currentElement = $(this);
        var relatedConversation = '';
        var selected = 0;
        modalBody.find('input[type="checkbox"]').each(function(){
            if($(this).is(":checked")){
                relatedConversation += $(this).val() +",";
                selected ++ ;
            }
        });
        
        if(selected > 0){
            
            
            $('#relatedCoversation-'+$(this).val()).parent().find('.btn-add-related').html('Add Related Conversation (' + selected +' added)');
        }
        
        $('#relatedCoversation-'+$(this).val()).val(relatedConversation);
    });
    
    
    $('form.update_password').submit(function(e){
        
        var pass = $(this).find('input[name=pass]').val();
        var exist = $(this).find('input[name=exist]').val();
        var cPas = $(this).find('input[name=cpass]').val();
        var me = $(this);
        if(pass != cPas){
            me.find('.error-pass').html('Password is not equal.');
            me.find('.error-cpass').html('Password is not equal.');
        }
        else{
            $.ajax({
                "url" : BASEURL + "users/users_json/CheckPassword",
                "data" : {exist: exist,
                            pass: pass },
                "type" : "POST",
                "success" : function(response){
                    if(response == false){
                        me.find('.error-exist').html('Password is incorrect.');
                    }
                    else{
                        me.find('.message').html('<div class="alert alert-success">' +
                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                        '<h4>Update</h4> Password updated sucessfully!</div>');
                    }
                },
                "failed" : function(){
                    
                }
            });
           
        }
        
        e.preventDefault();
    });
    
    $('form.update_profile').submit(function(e){
        var display = $(this).find('input[name=display-name]').val();
        var about = $(this).find('.about-me').val();
        var time = $(this).find('.timezone').val();
        console.log(display);
        console.log(time);
        var me = $(this);
        
        $.ajax({
                "url" : BASEURL + "users/users_json/update_profil",
                "data" : {display : display,
                          about: about,
                          time: time},
                "type" : "POST",
                "success" : function(response){
                                if(response == false){
                                    alert("GAGAL1");
                                }
                                else{
                                    me.find('.yes_update').html('<div class="alert alert-success">' +
                                    '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                                    '<h4>Update</h4> Profile updated sucessfully!</div>');
                                }
                            },
                "failed" : function()
                {
                    alert("GAGAL2");
                }
            });
        e.preventDefault();
    });
    
    
    $(this).on('submit','.reply-tweet ', function(e){
        var buttonSubmit = $(this).find('button[type=submit]');
        buttonSubmit.attr('disabled', 'disabled').html('SENDING...');
        var openButton = $(this).closest('li').find('button:first');
        var me = $(this);
        e.preventDefault();
        $.ajax({
            "url" : BASEURL + "dashboard/media_stream/ReplyTwitter",
            "type" : "POST",
            "data" : $(this).serialize() + "&channel_id=" + $(this).closest('.floatingBox').find('input.channel-id').val() +
                        "&filename=" + ($(this).find('.reply-preview-img').attr('src') == undefined ? '' :  $(this).find('.reply-preview-img').attr('src')),
            "success" : function(response){
                buttonSubmit.removeAttr('disabled').html('SEND');
                try{
                    if(response.success == false){
                        var message = '';
                        if(response.result.errors){
                            for(x=0; x<response.result.errors.length; x++){
                                message += response.result.errors[x].message + "<br />";
                            }
                        }
                        
                        me.find('.message').html('<div class="alert alert-warning">' +
                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                        '<strong>Error!</strong> ' + response.message + '<br />' + message + '</div>');
                        
                    }
                    else{
                        me.find('.message').html('<div class="alert alert-success">' +
                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                        '<h4>Reply Tweet</h4> ' + response.message + '!</div>');
                        me.find('input, textarea').val('');
                        me.find('.reply-preview-img').toggle('slow');
                        openButton.removeClass('btn-warning').addClass('btn-inverse').html('REPLIED').val('');
                        setTimeout(function(){
                            me.closest('.reply-field').toggle('slow');
                            var currentHtml = me.closest('li');
                            currentHtml.find('.reply-preview-img').toggle('slow');
                            me.closest('ul').prepend(currentHtml);
                            me.closest('.subStream').animate({
                                scrollTop: 0
                            });
                        }, 1500);
                        
                    }
                }
                catch(e){
                      me.find('.message').html('<div class="alert alert-danger">' +
                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                        '<strong>Error!</strong> Replying tweet failed.</div>');
                }
                
            },
            "error" :  function( jqXHR, textStatus, errorThrown ){
                buttonSubmit.removeAttr('disabled').html('SEND');
                me.find('.message').html('<div class="alert alert-danger">' +
                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                        '<strong>Error!</strong> Replying tweet failed.</div>');
            }
        });
    });
    
    $(this).on('click', '.btn-resolve', function(e){
        var btnResolve = $(this);
        confirmed = prompt("Resolved Message?", "","Are you sure to solve this case");
        //confirmed = confirm('Are you sure to solve this case?');
        e.preventDefault();
        if(confirmed){
            btnResolve.attr("disabled", "disabled");
            $.ajax({
               "url" : BASEURL + "case/mycase/ResolveCase",
               "type" : "POST",
               "data" : "case_id=" + btnResolve.val()+"&solved_message="+confirmed,
               "success" : function(response){
                    if(response.success){
                        btnResolve.siblings('.btn-case').remove();
                        btnResolve.removeAttr("disabled").html('<i class="icon-plus"></i> <span>CASE</span>').removeClass('btn-resolve btn-purple').addClass('btn-case btn-danger');
                        btnResolve.closest('li').find('.btn-purple:first').html('Case ID #' + response.result.case_id + ' solved by ' + response.result.solved_by.display_name).removeClass('btn-purple').addClass('btn-inverse');
                    }
               },
               "error" : function(){
                    alert("There is something error when resolve this case.")
               }
        
            });
        }
    });
    
    $(this).on('click', '.btn-resolve_fb', function(e){
        var btnResolve = $(this);
        var user_id= $(" input[name=user_id]").val();
       // var solved_message=
//        confirmed = confirm('Are you sure to solve this case?');
        confirmed = prompt("Resolved Message?", "","Are you sure to solve this case");
        //alert("You have entered : " +  retVal );
       // alert(confirmed);
        e.preventDefault();
        if(confirmed){
            btnResolve.attr("disabled", "disabled");
            $.ajax({
               "url" : BASEURL + "case/mycase/ResolveCase",
               "type" : "POST",
               "data" : "case_id=" + btnResolve.val()+"&user_id="+user_id+"&solved_message="+confirmed,
               
               "success" : function(response){
                    if(response.success){
                        btnResolve.addClass('hide') //removeAttr("disabled").html('<i class="icon-plus"></i> <span>CASE</span>').removeClass('btn-resolve btn-purple').addClass('btn-case btn-danger');
                        btnResolve.closest('li').find('.btn-purple:first').addClass('hide');
                    }
               },
               "error" : function(){
                    alert("There is something error when resolve this case.")
               }
        
            });
        }
    });

    $(this).on('click', '.twitter-case-related', function(e){
        
        $($(this).attr('href')).removeClass('hide fade');
    });
    
});


function contains(a, obj) {
    var i = a.length;
    while (i--) {
       if (a[i] === obj) {
           return true;
       }
    }
    return false;
}
