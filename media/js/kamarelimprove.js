/*

    This file was created by Eko Purnomo to improve kamarel.js
*/

$(function(){
    $(this).on('submit', '.case-field form', function(e){
        var thisElement = $(this);
        $(this).find('button[type=submit]').attr('disabled', 'disabled');
        $(this).find('button[type=submit]').html('<i class="icon-stop icon-large"></i> Assigning case...');
      

        $(this).AsyncPost({
            "url" : BASEURL + "case/mycase/CreateCase",
            "urlParameter" : $(this).serialize(),
            "reload" : false,
            "callback" : function(response){
                if(response.success){
                    thisElement.find('input[type=text], textarea, select').each(function(){
                        $(this).val(''); 
                    });
                    thisElement.find('.message').html('<div class="alert alert-success">' +
                    '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                    '<strong>Well done!</strong> ' + response.message + '</div>');
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
                
                
            }
        });
        e.preventDefault();
    });
    
    $(this).on('click', '.assign-case .twitter', function(e){
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
                console.log(response);
                $(modalID + " .loader-image").hide();
                for(i = 0; i<response.length;i++){
                    $(modalID + ' form').append(
                         '<div class="related-conversation-body">' + 
                        '<span class="related-conversation-btn-hide-show btn-close pull-right"><i class="icon-caret-down"></i></span>' + 
                        '<p class="headLine">' + 
                            '<input type="checkbox" class="related-conversation-check" value="' + response[i].post_id + '">' + 
                            '<span class="author">' +  response[i].name + '(@' + response[i].screen_name + ')</span>' + 
                            '<i class="icon-circle"></i>' + 
                            '<span>posted a <span class="cyanText">Tweet</span></span>' + 
                            '<i class="icon-circle"></i>' + 
                            '<span>' + response[i].created_at + '</span>' + 
                            '<i class="icon-play-circle moreOptions pull-right"></i>' +
                        '</p>' + 
                        '<div>' +
                            '<p>' + response[i].text + '</p>' +
                            '<p><button class="btn btn-primary btn-mini btn-retweet" style="margin-left: 5px;">RETWEET</button></p>' +
                        '</div></div>'
                    );
                }
                
            }
        });
        
        
        
    });
    $(this).on('click','.add-related-conversation', function(){
        var modalBody = $(this).parent().parent().find('.modal-body');
        currentElement = $(this);
        var relatedConversation = '';
        modalBody.find('input[type="checkbox"]').each(function(){
            if($(this).is(":checked")){
                relatedConversation += $(this).val() +",";
            }
        });
        
        $('#relatedCoversation-'+$(this).val()).val(relatedConversation);
    });
});