/*--------------------------------------------

        THE KAMAREL admin theme v1.2

            main javascript file
            
created by Tatto @ - matodrlicka@gmail.com

----------------------------------------------*/

var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));

/*=============================================================================================
======================== JQUERY EXPRESSION FOR CASE SENSITIVE FILTER ==========================
=============================================================================================*/

$.extend($.expr[":"],
    {
        "contains-ci": function(elem, i, match, array)
        {
            return (elem.textContent || elem.innerText || $(elem).text() || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
        }
    });

$(function(){
    $(this).on("error", ".circleAvatar img", function() {
        //$( this ).attr( "src", "missing.png" );
        console.log("error");
    });
    /*=============================================================================================
     ==================================== GET ACTUAL DATETIME =====================================
     =============================================================================================*/

    // Create two variable with the names of the months and days in an array
    var monthNames = [ "Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sept", "Oct", "Nov", "Dec" ],
        dayNames= ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
    $(document).on('load', 'img', function(){
        console.log('error');
        $(this).hide();
    });
    // Create a newDate() object
    var newDate = new Date();
    // Extract the current date from Date object
    newDate.setDate(newDate.getDate());
    // Output the day, date, month and year
    $('.date').html(dayNames[newDate.getDay()] + ", " + monthNames[newDate.getMonth()] + ' ' + newDate.getDate()  + ', ' + newDate.getFullYear() + ', ');

    setInterval( function() {
        // Create a newDate() object and extract the seconds of the current time on the visitor's
        var currentTime = new Date (),
            currentHours = currentTime.getHours (),
            currentMinutes = currentTime.getMinutes (),
            currentSeconds = currentTime.getSeconds ( );

        // Pad the minutes and seconds with leading zeros, if required
        currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
        currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;

        // Convert the hours component to 12-hour format if needed
        // currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;

        // Convert an hours component of "0" to "12"
        currentHours = ( currentHours == 0 ) ? 12 : currentHours;

        // Compose the string for display
        var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds;

        $(".time").html(currentTimeString);
    },1000);

    /*=============================================================================================
     ===================================== MAIN MENU ACTIONS ======================================
     =============================================================================================*/
    
    $( '.mainmenu li, .mainmenu div.dropdown' ).click(function() {
        var dropDownWidth =  $(this).find('.dropdown-menu').parent().width();

        if ($(this).hasClass('dropdown')) {
            $(this).find('.dropdown-menu').css({minWidth: (dropDownWidth - 1) + 'px'})
        }

    });
    
    /*=============================================================================================
     =========================== FLOATING BOX MENU / TAB MENU ACTIONS =============================
     =============================================================================================*/

    $(this).on('click', 'ul.nav-tabs li a', function() {
        $(this).parent().addClass('active');
        previous = $(this).closest('ul.nav-tabs').find('li.active');
        previous.removeClass('active');
        alert($(this).text());
    });


    /*=============================================================================================
     ==================================== SIDEBAR SHOWING ACTIONS =================================
     =============================================================================================*/

    //variable where currentAnchor is stored
    var currentSection = 0;
    // toggles the slickbox on clicking the noted link
    $('div .input-append a.sidebar').click(function() {

        var href = $(this).attr('href');
        var $previous = $('div .input-append a span.add-on.active');

        $previous.removeClass('active');
        $(this).find('span.add-on').addClass('active');

        //hide all submenus
        $('.hiddenContent>div').hide();

        //show one particular menu
        $(href).fadeIn();

        //logic for hiding and showing submenu
        if(currentSection == 0){
            $('.hiddenContent').stop().animate({right: 0}).css({display: 'block'});
            currentSection = href;
        }else if(currentSection == href){
            $('.hiddenContent').stop().animate({right: -270});
            $previous.removeClass('active');
            currentSection = 0;
        }else{
            currentSection = href;
        }
        return false;
    });
    
    $(document).ready(function(){
        $('.sidebarContent > .btn-close').click(function(){
            $('.hiddenContent>div').hide();
            $('.hiddenContent').stop().animate({right: -270}).css({display: 'block'});
            $('div .input-append a.sidebar').removeClass('active');
            currentSection = 0;
        });
        
        $('.sidebarContent > footer > .changePassword').click(function(){
            $(this).closest('#profileContent').hide();
            $(this).closest('#profileContent').siblings('#updatePassword').show();
        });
        
        $('.sidebarContent > footer > .updateProfile').click(function(){
            $(this).closest('#profileContent').hide();
            $(this).closest('#profileContent').siblings('#updateProfile').show();
        });
        
        $('.sidebarContent > footer > .updateProfile').click(function(){
            $(this).closest('#profileContent').hide();
            $(this).closest('#profileContent').siblings('#updateProfile').show();
        });
        
        $('.sidebar-btn-cancel').click(function(){
            $(this).closest('#updateProfile').hide();
            $(this).closest('#updatePassword').hide();
            $('#profileContent').show();
        });
    });

    /*=============================================================================================
     =============================== COLLAPSED SIDEBAR SHOWING ACTIONS ============================
     =============================================================================================*/

    //variable where currentAnchor is stored
    var currentSection = 0;
    // toggles the slickbox on clicking the noted link
    $('.collapsedSidebarMenu a.sidebar, a.showCollapsedSidebarMenu').click(function() {

        var href = $(this).attr('href');

        //hide all submenus
        $('.hiddenContent>div').hide();

        //show one particular menu
        $(href).fadeIn();

        return false;
    });

    /*=============================================================================================
     ======================== LOAD SLIDERS TO SETTING SIDEBAR MENU ========================
     =============================================================================================*/

    $('.sl1').slider();
    $('.sl2').slider({
        value: [40,60]
        ,min: 0
        ,max: 100
        ,step: 1
    });

    /*=============================================================================================
     ===================================== TOGGLER ACTIONS ========================================
     =============================================================================================*/

    $('#toggler').bind('change', function () {

        if ($(this).is(':checked'))
            $('.toggle .slider-selection').animate({width: '0px', opacity: 0}, 200)
        else
            $('.toggle .slider-selection').animate({width: '30px', opacity: 1}, 100)
    });

    /*=============================================================================================
     ============================= PROFILE PHOTO POSITION ANIMATE ON HOVER ========================
     =============================================================================================*/

    $('.profilePhoto').hover(function () {
        $(this).animate({
            'background-position-x': "100%"
        }, "300");
    }, function() {
        $(this).stop().animate({
            'background-position-x': "0%"
        }, "300");
    });

    /*=============================================================================================
     ================================= SMALL CHARTS IN TITLE LINE =================================
     =============================================================================================*/

    $('.usersBar').sparkline('html', {type: 'bar', barColor: '#33B5E5', barWidth: 4, height: 25} );
    $('.visitsBar').sparkline('html', {type: 'bar', barColor: '#FF4444', barWidth: 4, height: 25} );
    $('.ordersBar').sparkline('html', {type: 'bar', barColor: '#99CC00', barWidth: 4, height: 25} );

    /*=============================================================================================
     ================================== MASTER ACTIONS FUNCTION ===================================
     =============================================================================================*/

    $('ul.masterActions li').hover(function () {
        $(this).find('i').stop().animate({
            marginLeft: '25px'
        }, 300);
    }, function() {
        $(this).find('i').stop().animate({
            marginLeft: '0px'
        }, 300);
    });

    

    /*=============================================================================================
     =============================== MINIMIZE/CLOSE ELEMENT & TABLE ACTIONS ===============================
     =============================================================================================*/

    $('.minimizeElement, .minimizeTable').click(function () {
        if ($(this).hasClass('minimizeElement')) {
            $(this).parents(':eq(1)').next().slideToggle();
            $(this).toggleClass('active');
        }
        else if ($(this).hasClass('minimizeTable')) {
            $(this).parents(':eq(2)').next().slideToggle();
            $(this).find('i').toggleClass('cyanText');
        }
    });

    $('.removeElement, .removeTable').click(function () {
        if ($(this).hasClass('removeElement')) {
            $(this).parents(':eq(2)').remove();
        }
        else if ($(this).hasClass('removeTable')) {
            $(this).parents(':eq(3)').remove();
        }

    });

    /*=============================================================================================
     ============================= DROPDOWN MENU FOR MOREOPTIONS ICONS ============================
     =============================================================================================*/

    $('i.moreOptions, .tableSettings').popover({
        trigger: 'click',
        placement: 'bottom',
        html : true,
        content: function() {
            return $('#moreOptionsMenu').html();
        }
    })

    /*=============================================================================================
     ============================= CHOOSE SIDE WHERE SUBMENU OPEN --===============================
     =============================================================================================*/

    .click(function(evt) {
        var isRight = evt.pageX > (evt.view.outerWidth / 1.2);
        if (isRight === true) {
            $('.dropdown-submenu').addClass('submenu-left')
        }
        else {
            $('.dropdown-submenu').removeClass('submenu-left')
        }
    });

    /*============================================================================================
     ============ CLICK OUTSIDE OF MOREOPTIONS DROPDOWN CLOSE PREVIOUS INSTANCE ==================
     =============================================================================================*/

    $('body').on('click', function (e) {
        $('i.moreOptions, .tableSettings').each(function () {
            //the 'is' for buttons that triggers popups
            //the 'has' for icons within a button that triggers a popup
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                $(this).popover('hide');
            }
        });
    });

    /*=============================================================================================
     ===================================== DASHBOARD ACTIONS ======================================
     =============================================================================================*/
            
            $(function () {
                $('#multipleSelect').multiselect({
                buttonText: function(options, select) {
                    if (options.length == 0) {
                        return 'None selected <b class="caret"></b>';
                    }
                    else if (options.length > 1) {
                        return options.length + ' selected <b class="caret"></b>';
                    }
                    else {
                        var selected = '';
                        options.each(function() {
                            selected += $(this).text() + ', ';
                        });
                        return selected.substr(0, selected.length -2) + ' <b class="caret"></b>';
                    }
                },
                });
                
                $('.compose-textbox').click(
                    function() {
                        $('.compose-innercontainer').addClass("compose-expanded");
                        $('.compose-innercontainer').removeClass("compose-collapsed");
                    }
                );

                 $( "#fileselectbutton" ).click(function(e){
                    $( "#composeInputImageFile" ).trigger("click");
                });
                 
                 $(this).on('click', '#replyfileselectbutton', function(){
                    $(this).siblings("#replyInputImageFile" ).trigger("click");
                }); 

                 $( "#closecompose" ).click(function(e){
                    //untuk close publishing
                    $('.compose-innercontainer').addClass("compose-collapsed");
                    $('.compose-innercontainer').removeClass("compose-expanded");
                }); 

                 $('#datepickerField').datepicker();

                  $( "#composeInputImageFile" ).change(function(e){
                    var val = $(this).val();
                    var file = val.split(/[\\/]/);
                    $( "#filename" ).val(file[file.length-1]);
                    
                    if (this.files && this.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $('#compose-preview-img').show();        
                            $('#compose-preview-img').attr('src', e.target.result);        
                            $("#remove-img").show();       
                            $('#remove-img').css('left',$('#compose-preview-img').width());
                        }
                        reader.readAsDataURL(this.files[0]);
                    }
                });

                $(this).on('change','#replyInputImageFile',function(e){
                    var val = $(this).val();
                    var file = val.split(/[\\/]/);
                    $(this).siblings( "#replyfilename" ).val(file[file.length-1]);
                    var me = $(this);
                    if (this.files && this.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            me.parent().siblings('.reply-img-list-upload').find('#reply-preview-img').show();        
                            me.parent().siblings('.reply-img-list-upload').find('#reply-preview-img').attr('src', e.target.result);        
                            me.parent().siblings('.reply-img-list-upload').find('#reply-remove-img').show();
                            me.parent().siblings('.reply-img-list-upload').find('#reply-remove-img').css('left',me.parent().siblings('.reply-img-list-upload').find('#reply-preview-img').width());
                        }
                        reader.readAsDataURL(this.files[0]);
                    }
                });
                
                var upload_file = $("#composeInputImageFile");
                $( "#remove-img" ).click(function(){
                    $("#compose-preview-img").hide();
                    $("#remove-img").hide();
                    $("#filename").val('');
                    $("#compose-preview-img").removeAttr('src');
                    upload_file.replaceWith(upload_file = upload_file.clone(true));
                });
                
                $(this).on('click', "#reply-remove-img", function(){
                    $(this).siblings("#reply-preview-img").hide();
                    $(this).hide();
                    $(this).closest('.reply-img-list-upload').siblings('.dummyfile').find("#replyfilename").val('');
                    var upload_file = $(this).closest('.reply-img-list-upload').siblings('.dummyfile').find("#replyInputImageFile");
                    upload_file.replaceWith(upload_file = upload_file.clone(true));
                });
                
                $(document).mouseup(function (e)
                {
                    var container = $(".compose-expanded");
                    if (!container.is(e.target) // if the target of the click isn't the container...
                        && container.has(e.target).length === 0) // ... nor a descendant of the container
                    {
                        //untuk close publishing
                        //$('.compose-innercontainer').addClass("compose-collapsed");
                        //$('.compose-innercontainer').removeClass("compose-expanded");
                    }
                });

                $(document).ready(function() {
                    
                    $(this).on('click', '.stream_head > li > a',
                        function(e) {
                            previous = $(this).closest('ul.stream_head').find('li.active');
                            previous.removeClass('active');
                            $(this).parent().addClass('active');
                            var id_tab_name = '#' + $(this).attr('class');
                            $(this).closest('.floatingBoxMenu').next().find('.floatingBoxContainers').hide(); 
                            $(this).closest('.floatingBoxMenu').next().find(id_tab_name).show();
                            e.preventDefault();
                    });
                    
                    $('.change-read-unread-stream').on('change', function(){
                        var social_id = $(this).closest('.containerHeadline').next().children('.channel-id').val();
                        var is_read = $(this).val();
                        if($(this).closest('div').prev().find('i').attr('class') == 'icon-facebook'){
                            $(this).closest('.containerHeadline').next().html('&nbsp;&nbsp;Loading...');        
                            $(this).closest('.containerHeadline').next().load(BASEURL + 'dashboard/media_stream/facebook_stream/' + social_id + '/' + is_read, function(){
                                $(this).find('.channel-id').val(social_id);
                            });
                        }
                        else if($(this).closest('div').prev().find('i').attr('class') == 'icon-twitter'){
                            $(this).closest('.containerHeadline').next().html('&nbsp;&nbsp;Loading...');        
                            $(this).closest('.containerHeadline').next().load(BASEURL + 'dashboard/media_stream/twitter_stream/' + social_id + '/' + is_read, function(){
                                $(this).find('.channel-id').val(social_id);
                            });
                        }
                    });
                    var increment = 1;
                    setInterval(function(){
                        //$(document).RefreshAllStream();
                        //increment ++;
                        //console.log(increment);
                    }, 120000);
                    $('#refreshAllStream').click(function(){
                        $(this).RefreshAllStream();
                    });
                    var i = 0;
                    $('.containerHeadline .dropdown-stream-channels').each(function(){
                        i++;
                        var streamId, streamType, urlToLoad ;
                        urlToLoad = BASEURL + 'dashboard/media_stream/';
                        streamId = $(this).find('li:nth-child(' + i + ') input').val();
                        
                        if($(this).find('li:nth-child(' + i + ') a').hasClass('facebook_stream')){
                            streamType = "facebook";
                            urlToLoad += "facebook_stream/" + streamId
                            $(this).closest('div').children('button').html('<i class="icon-facebook"></i><h2>Facebook&nbsp;</h2><i class="icon-caret-down"></i>');
                            $(this).closest('.containerHeadline').css( "background-color", "#3B5998" );
                            $(this).closest('.containerHeadline').next().html('&nbsp;&nbsp;Loading...');
                            
                        }
                        else if($(this).find('li:nth-child(' + i + ') a').hasClass('twitter_stream')){
                            streamType = "twitter";
                            urlToLoad += "twitter_stream/" + streamId
                            $(this).closest('div').children('button').html('<i class="icon-twitter"></i><h2>Twitter&nbsp;</h2><i class="icon-caret-down"></i>');
                            $(this).closest('.containerHeadline').css( "background-color", "#4099FF" );
                            $(this).closest('.containerHeadline').next().html('&nbsp;&nbsp;Loading...');
                        }
                        else{
                            streamType = "youtube";
                            urlToLoad += "youtube_stream/" + streamId
                            $(this).closest('div').children('button').html('<i class="icon-youtube"></i><h2>Youtube&nbsp;</h2><i class="icon-caret-down"></i>');
                            $(this).closest('.containerHeadline').css( "background-color", "#FF3333" );
                            $(this).closest('.containerHeadline').next().html('&nbsp;&nbsp;Loading...');  
                        }
                        $(this).closest('.containerHeadline').next().load(urlToLoad, function(){
                            
                            $('.email').tagit({
                                autocomplete : {
                                    source:  function( request, response ) {
                                        $.ajax({
                                            "url" : BASEURL + "case/mycase/SearchEmail",
                                            data : {
                                                term : request.term
                                            },
                                            success : function(data){
                                                response( $.map( data, function( item ) {
                                                    return {
                                                      label: item.username + "(" + item.email + ")",
                                                      value: item.email
                                                    }
                                                }));
                                            }
                                        });
                                    }
                                },
                                beforeTagAdded : function(event, ui){
                                    if(validateEmail(ui.tagLabel))
                                        return true;
                                    else
                                        return false;

                                }
                            });
                            var hashUrl = window.location.hash;
                            var splitUrl = hashUrl.split('/');
                            if(splitUrl[1] == streamType)
                                $(this).ToCase();
                        });
                       
                    });
                    $('.facebook_stream').on('click',function() {
                        $(this).closest('div').children('button').html('<i class="icon-facebook"></i><h2>Facebook&nbsp;</h2><i class="icon-caret-down"></i>');
                        $(this).closest('.containerHeadline').css( "background-color", "#3B5998" );
                        $(this).closest('.containerHeadline').next().html('&nbsp;&nbsp;Loading...');        
                        $(this).closest('.containerHeadline').next().load(BASEURL + 'dashboard/media_stream/facebook_stream/' + $(this).siblings('.channel-stream-id').val());
                        
                    });
                    
                    $('.twitter_stream').on('click',function() {
                        $(this).closest('div').children('button').html('<i class="icon-twitter"></i><h2>Twitter&nbsp;</h2><i class="icon-caret-down"></i>');
                        $(this).closest('.containerHeadline').css( "background-color", "#4099FF" );
                        $(this).closest('.containerHeadline').next().html('&nbsp;&nbsp;Loading...');        
                        $(this).closest('.containerHeadline').next().load(BASEURL + 'dashboard/media_stream/twitter_stream/' + $(this).siblings('.channel-stream-id').val());
                    });
                    
                    $('.youtube_stream').on('click',function() {
                        
                        $(this).closest('div').children('button').html('<i class="icon-youtube"></i><h2>Youtube&nbsp;</h2><i class="icon-caret-down"></i>');
                        $(this).closest('.containerHeadline').css( "background-color", "#FF3333" );
                        $(this).closest('.containerHeadline').next().html('&nbsp;&nbsp;Loading...');
                        $(this).closest('.containerHeadline').next().load(BASEURL + 'dashboard/media_stream/youtube_stream/' + $(this).siblings('.channel-stream-id').val());
                    });
                });
                $(this).on('click', 'p.video', function(){
                    $(this).find('img').hide();
                    $(this).find('iframe').show().attr({
                        'width' : $(this).width() - 20,
                        'height' : 240
                    });
                });
                $(document).ready(function() {
                        $(this).on('click','.btn-reply',
                            function() {
                                $(this).closest('h4').siblings('.reply-field').show();
                                $(this).closest('h4').siblings('.case-field').hide();
                                $(this).closest('h4').siblings('.dm-field').hide();
                            }
                        );
                        
                        $(this).on('click','.btn-engagement-reply',
                            function() {
                                $(this).parent().siblings('.fb-reply-engagement-field').show();
                                $(this).parent().siblings('.case-engagement-field').hide();
                            }
                        );
                        
                        $(this).on('click','.btn-engagement-case',
                            function() {
                                $(this).parent().siblings('.reply-engagement-field').hide();
                                $(this).parent().siblings('.case-engagement-field').show();
                            }
                        );
                        
                        $(this).on('click','.btn-case',
                            function() {
                                $(this).closest('h4').siblings('.reply-field').hide();
                                $(this).closest('h4').siblings('.dm-field').hide();
                                $(this).closest('h4').siblings('.case-field').show();
                            }
                        );
                        
                         $(this).on('click','.btn-dm',
                            function() {
                                $(this).closest('h4').siblings('.reply-field').hide();
                                $(this).closest('h4').siblings('.dm-field').show();
                                $(this).closest('h4').siblings('.case-field').hide();
                            }
                        );
                            
                        $(this).on('click','.assign-btn',
                            function() {
                                $(this).parent().siblings(".reply").hide("slow");
                                $(this).parent().siblings(".assign").hide("slow");
                                $(this).parent().siblings(".assign").show("slow");
                            }
                        );
    
                        $(this).on('click','.hide-form',
                            function() {
                                $(this).parent().parent().parent().hide();
                            }
                        );
                        
                        $(this).on('click','.btn-engagement',
                            function() {
                                $(this).parent().siblings('.engagement').toggle();
                            }
                        );
                        
                        $(this).on('click','.btn-show-video',
                            function() {
                                $(this).parent().siblings('.show-video').toggle();
                                if($(this).find('.desc').html() == 'VIEW VIDEO'){
                                    $(this).find('.desc').html('HIDE VIDEO');        
                                }
                                else{
                                    $(this).find('.desc').html('VIEW VIDEO');        
                                }
                            }
                        );
                        
                        $(this).on('click','.read-mark, .btn-case, .btn-reply, .retweet, .favorit .btn-send-reply, .fblike, .dm_send',
                            function(){
                            var me = $(this);
                            $.ajax({
                                    url : BASEURL + 'dashboard/media_stream/ReadUnread',
                                    type: "POST",
                                    data: {
                                        post_id:me.closest('li').find('.postId').val(),
                                        read : $(this).val() != '' ? 1 : null
                                    },
                                    success: function(result)
                                    {
                                        
                                        var currentNumber = 0;
                                        try{
                                            currentNumber = parseInt(me.closest('.container-fluid').siblings('.floatingBoxMenu').find('li.active .notifyCircle').html());
                                        }
                                        catch(e){
                                            currentNumber = 0;
                                        }
                                        if(result == 1){
                                            currentNumber -=  1;
                                            currentNumber = currentNumber < 0 ? 0 : currentNumber;
                                            me.closest('li').find('.read-mark').removeClass('redText').addClass('greyText');
                                        }
                                        else{
                                            currentNumber += 1;
                                            me.closest('li').find('.read-mark').removeClass('greyText').addClass('redText');
                                        }
                                        
                                        me.closest('.container-fluid').siblings('.floatingBoxMenu').find('li.active .notifyCircle').html(currentNumber);
                                        if(currentNumber == 0){
                                            me.closest('.container-fluid').siblings('.floatingBoxMenu').find('li.active .notifyCircle').hide();
                                        }
                                        else
                                            me.closest('.container-fluid').siblings('.floatingBoxMenu').find('li.active .notifyCircle').show();
                                    },
                                });
                        });
                        
                        $(this).on('click','.engagement-btn-close',
                            function() {
                                 $(this).parent().parent().hide();
                            }
                        );
                        
                        $(this).on('click','.engagement-btn-hide-show',
                            function(){
                                $(this).siblings('div').toggle();
                            }
                        );
                        
                        $(this).on('click','.related-conversation-btn-hide-show',
                            function(){
                                $(this).siblings('div').toggle();
                            }
                        );
                        
                        $(this).on('click','.reply-field-btn-close',
                            function() {
                                 $(this).parent().parent().hide();
                            }
                        );
                        
                        $(this).on('click','.fb-reply-field-btn-close',
                            function() {
                                $(this).closest('.fb-reply-engagement-field').hide();
                                $(this).closest('.reply-field').hide();
                            }
                        );
                        
                        
                        $(this).on('click','.btn-send-reply',
                           function() {
                                $(this).parent().siblings('.reply-status').show();
                                $(this).parent().siblings('.reply-status').fadeOut(3000);
                            }
                        );

                        $(this).on('click','.dm-field-btn-close',
                            function() {
                                $(this).closest('.dm-field').hide();
                                $(this).closest('.reply-field').hide();
                            }
                        );
                        
                        $(this).on('click','.toggleTable',
                            function(){
                                $(this).parent().parent().next().toggle();
                            }
                        );
                        
                        $(this).on('input propertychange', '.replaycontent',
                            function() {
                                var len = $(this).val().length;
                                $(this).siblings('.reply-char-count').children('.reply-fb-char-count').html(2000-len);
                        });
                        
                        $(this).on('input propertychange', '.replaycontent',
                            function() {
                                var len = $(this).val().length;
                                $(this).siblings('.reply-char-count').children('.reply-tw-char-count').html(140-len);
                        });
                    }
                );
                
                $( document ).ready(function() {
                    $( "#open-img" ).click(function() {
                       $("#img-show").css({"display": "block"});
                    });

                    $( "#close-img" ).click(function() {
                       $("#img-show").css({"display": "none"});
                    });

                     $( "#open-cal" ).click(function() {
                       $("#cal-show").css({"display": "block"});
                    });

                     $( "#close-cal" ).click(function() {
                       $("#cal-show").css({"display": "none"});
                    });

                    $(".compose-insert-link-btn").click(function(){
                        $.ajax({
                                url : BASEURL + 'dashboard/media_stream/GenerateShortUrlWithoutCampaign',
                                type: "POST",
                                data: {
                                        url: validateURL($('.compose-insert-link-text').val()) ?
                                            $('.compose-insert-link-text').val() :
                                                "http://" + $('.compose-insert-link-text').val(),
                                        },
                                success: function(data){
                                    if(data.shortcode){
                                        $('.compose-textbox').val($('.compose-textbox').val()+ 'http://maybk.co/' + data.shortcode);  
                                        ComposeCharCheck();
                                        $('.compose-insert-link-short-url-hidden').val(data.shortcode);
                                        $(".compose-insert-link-text").linkpreview({
                                            previewContainer: "#url-show > .compose-form > div",  //optional
                                            //previewContainerClass: ".compose-schedule",
                                            refreshButton: ".compose-insert-link-btn",        //optional
                                            preProcess: function() {                //optional
                                                $('#url-show').css({"display": "block"});
                                                $('#url-show > .compose-form > div').html('Loading...');
                                            },
                                            onSuccess: function(data) {                  //optional
                                            },
                                            onError: function() {                    //optional
                                            },
                                            onComplete: function() {                 //optional
                                            }
                                       });
                                    }
                                    else{
                                        console.log(data);
                                    }
                                }
                            });
                    });
                    
                    $(this).on('click','.reply-insert-link-btn', function(e){
                        var me = $(this);
                        var isComment=me.closest('form').html();
                                                e.preventDefault();
                        me.attr("disabled", "disabled").html("SHORTENING...");
                        if(!validateURL(me.siblings(".reply-insert-link-text").val())){
                            if(!validateURL("http://" + me.siblings(".reply-insert-link-text").val())){
                                alert("Invalid Link");
                                me.removeAttr("disabled").html("SHORTEN");
                                return;
                            }
                        }
                        $.ajax({
                           "url" : BASEURL + "dashboard/media_stream/GenerateShortUrlWithoutCampaign",
                           "data" : {
                                "url" : validateURL(me.siblings(".reply-insert-link-text").val()) ? me.siblings(".reply-insert-link-text").val() :
                                    "http://" + me.siblings(".reply-insert-link-text").val()
                           },
                           "type" : "POST",
                           "success" : function (response){
                                me.removeAttr("disabled").html("SHORTEN");
                                tweetsText = me.closest('form').find(".replaycontent");
                                shortcode= me.closest('.link_url').find(".short_code");
                                tweetsText.val(tweetsText.val() + " http://maybank.co/" + response.shortcode);
                                shortcode.val(response.shortcode);
                                me.closest('reply-shorturl-show-content').val(" http://maybank.co/" + response.shortcode);
                               // alert("http://maybank.co/" + response.shortcode)
                           },
                           failed : function(response){
                                me.removeAttr("disabled").html("SHORTEN");
                           }
                           
                        });
                    });

                     $( "#close-url" ).click(function() {
                       $("#url-show").css({"display": "none"});
                    });
                     
                     $(this).on('click',"#close-reply-url-show", function() {
                       $(this).closest("#reply-url-show").hide();
                    });
                     
                    $(this).on('click','#reply-open-img', function(){
                        $(this).parent().siblings('#reply-img-show').show();
                    });
                     
                     $(this).on('click',"#close-reply-img-show", function() {
                       $(this).closest("#reply-img-show").hide();
                    });
                     
                     function ComposeCharCheck(){
                        var len = $('.compose-textbox').val().length;
                        $('.compose-fb-char-count').html(2000-len);
                        $('.compose-tw-char-count').html(140-len);
                        $('.compose-yt-char-count').html(500-len);
                     }
                     
                     $('.compose-textbox').bind('input propertychange', ComposeCharCheck);
                     
                     $(".btn-compose-post").click(function() {
                        if(!$('.compose-channels option:selected').length){
                            alert('Please select a channel');
                        }
                        else if($('.compose-textbox').val() == '')
                        {
                            alert('Message is required'); 
                        }
                        else
                        {
                            var channels = new Array();
                            var i = 0;
                            var check_twitter = false;
                            var check_fb = false;
                            var check_youtube = false;
                        
                            $('.compose-channels option:selected').each(function() {
                                if($(this).attr('id') == 'opttwitter'){
                                    check_twitter = true;
                                }
                                else if($(this).attr('id') == 'optfacebook'){
                                    check_fb = true;
                                }
                                else if($(this).attr('id') == 'optyoutube'){
                                    check_youtube = true;
                                }
                            });
                            
                            var confirmed = true;
                            var len = $('.compose-textbox').val().length;
                            if(len > 140 && check_twitter == true){
                                var r = confirm('Your message is more than 140 characters. It will not post to Twitter. Do you still want to continue?');
                                if(r == true){
                                    $('#opttwitter').removeAttr("selected");
                                }
                                else{
                                    confirmed = false;
                                }
                            }
                            
                            if(len > 500 && check_youtube == true){
                                var r = confirm('Your message is more than 500 characters. It will not post to Youtube. Do you still want to continue?');
                                if(r == true){
                                    $('#optyoutube').removeAttr('selected');
                                }
                                else{
                                    confirmed = false;
                                }
                            }
                            
                            if(len > 2000 && check_fb == true){
                                var r = confirm('Your message is more than 2000 characters. It will not post to Facebook. Do you still want to continue?');
                                if(r == true){
                                     $('#optfacebook').removeAttr('selected');
                                }
                                else{
                                    confirmed = false;
                                }
                            }
                            
                            var scheduleTime;
                            if($('#datepickerField').val() != ''){
                                if($('#compose-schedule-hours').val() == ''){
                                    alert("You haven't set your post schedule hours");
                                    confirmed = false;
                                }
                                else if($('#compose-schedule-minutes').val() == ''){
                                    alert("You haven't set your post schedule minutes");
                                    confirmed = false;
                                }
                                else{
                                    scheduleTime = $('#datepickerField').val() + ' ' + $('#compose-schedule-hours').val() + ':' + $('#compose-schedule-minutes').val() + ' ' + $('#compose-schedule-ampm').val();        
                                }
                            }
                            else{
                                scheduleTime = '';
                            }
                            
                            if(confirmed == true){
                                $(".btn-compose-post").html('POSTING...');
                                $(".btn-compose-post").prop('disabled',true);
                                
                                if(scheduleTime == ''){
                                    $('.compose-post-status').show();
                                    $('.compose-post-status').removeClass('green');
                                    $('.compose-post-status').removeClass('red');
                                    $('.compose-post-status').addClass('grey');
                                    $('.compose-post-status').html('Posting...');
                                    
                                    var resultPost = 0;
                                    var y = 0;
                                    var req = new Array();
                                    $('.compose-channels option:selected').each(function() {
                                        y++;
                                        if($(this).attr('id') == 'optfacebook'){
                                            $.ajax({
                                                url : BASEURL + 'cronjob/FbStatusUpdate',
                                                type: "POST",
                                                data: {
                                                        content:$('.compose-textbox').val(),
                                                        channel_id:$(this).val(),
                                                        title:$('#url-show').find('input').val(),
                                                        short_url:$('.compose-insert-link-short-url-hidden').val(),
                                                        description:$('#url-show').find('textarea').val(),
                                                        image:$('#compose-preview-img').attr('src') == undefined ? '' :  $('#compose-preview-img').attr('src')
                                                       },
                                                success: function(data)
                                                {
                                                    var IS_JSON = true;
                                                    try
                                                    {
                                                        var new_data = jQuery.parseJSON(data);
                                                    }
                                                    catch(err)
                                                    {
                                                        IS_JSON = false;
                                                    }                
                                                    $('.compose-innercontainer').removeClass("compose-collapsed");
                                                    $('.compose-innercontainer').addClass("compose-expanded");
                                                    resultPost = 1;
                                                    if(IS_JSON == true){
                                                        $('.compose-post-status').removeClass('grey');
                                                        $('.compose-post-status').removeClass('red');
                                                        $('.compose-post-status').addClass('green');
                                                        $('.compose-post-status').show();
                                                        $('.compose-post-status').html('Post to Facebook Success');
                                                        $('.compose-post-status').fadeOut(7500,function(){
                                                            $('.compose-innercontainer').removeClass("compose-expanded");
                                                            $('.compose-innercontainer').addClass("compose-collapsed");
                                                            $('.compose-textbox').val('');
                                                            $('.compose-insert-link-text').val('');
                                                            $("#compose-tags").tagit("removeAll");
                                                            $('.select-shorten-url').html('<option value="#">-- Select Shorten URL</option>');
                                                            $('.compose-channels').find('option').removeAttr('selected');
                                                            $('.compose-channels').next().find('button').html('None Selected <b class="caret"></b>');
                                                            $('.compose-channels').next().find('li').removeClass('active');
                                                            $('.compose-channels').next().find('input').removeAttr('checked');
                                                            $('.compose-fb-char-count').html(2000);
                                                            $('.compose-tw-char-count').html(140);
                                                            $('.compose-yt-char-count').html(500);
                                                            
                                                            $("#img-show").css({"display": "none"});
                                                            $("#img-show").find('#filename').val('');
                                                            $("#img-show").find("#remove-img").hide();
                                                            $('#img-show').find('#compose-preview-img').removeAttr('src');
                                                            
                                                            $("#cal-show").css({"display": "none"});
                                                            $("#cal-show").find('#datepickerField').val('');
                                                            $("#cal-show").find('#compose-schedule-hours').find('option').removeAttr('selected');
                                                            $("#cal-show").find('#compose-schedule-minutes').find('option').removeAttr('selected');
                                                            
                                                            $("#url-show").css({"display": "none"});
                                                            $('#url-show').find('input').val('');
                                                            $('.compose-insert-link-short-url-hidden').val('');
                                                            $('#url-show').find('textarea').val('');
                                                            $('#url-show').find('p').html('');
                                                            
                                                            $(".btn-compose-post").html('<i class="icon-bolt"></i> POST');
                                                            $(".btn-compose-post").prop('disabled',false);
                                                       });
                                                    }
                                                    else{
                                                        $('.compose-post-status').removeClass('grey');
                                                        $('.compose-post-status').removeClass('green');
                                                        $('.compose-post-status').addClass('red');
                                                        $('.compose-post-status').show();
                                                        $('.compose-post-status').html('Post to Facebook Failed');    
                                                        $('.compose-post-status').fadeOut(7500);
                                                        
                                                        $(".btn-compose-post").html('<i class="icon-bolt"></i> POST');
                                                        $(".btn-compose-post").prop('disabled',false);
                                                    }
                                                },
                                            });
                                        }
                                        
                                        if($(this).attr('id') == 'opttwitter'){                
                                            $.ajax({
                                                url : BASEURL + 'cronjob/TwitterStatusUpdate',
                                                type: "POST",
                                                data: {
                                                        content:$('.compose-textbox').val(),
                                                        channel_id:$(this).val(),
                                                        image:$('#compose-preview-img').attr('src') == undefined ? '' :  $('#compose-preview-img').attr('src')
                                                       },
                                                success: function(data)
                                                    {
                                                        $('.compose-innercontainer').removeClass("compose-collapsed");
                                                        $('.compose-innercontainer').addClass("compose-expanded");
                                                        resultPost = 1;
                                                        
                                                        var new_data = jQuery.parseJSON(data);
                                                    
                                                        if(new_data.id){
                                                            $('.compose-post-status').removeClass('grey');
                                                            $('.compose-post-status').removeClass('red');
                                                            $('.compose-post-status').addClass('green');
                                                            $('.compose-post-status').show();
                                                            $('.compose-post-status').html('Post to Twitter Success');    
                                                            $('.compose-post-status').fadeOut(7500,function(){
                                                                $('.compose-innercontainer').removeClass("compose-expanded");
                                                                $('.compose-innercontainer').addClass("compose-collapsed");
                                                                $('.compose-textbox').val('');
                                                                $('.compose-insert-link-text').val('');
                                                                $("#compose-tags").tagit("removeAll");
                                                                $('.select-shorten-url').html('<option value="#">-- Select Shorten URL</option>');
                                                                $('.compose-channels').find('option').removeAttr('selected');
                                                                $('.compose-channels').next().find('button').html('None Selected <b class="caret"></b>');
                                                                $('.compose-channels').next().find('li').removeClass('active');
                                                                $('.compose-channels').next().find('input').removeAttr('checked');
                                                                $('.compose-fb-char-count').html(2000);
                                                                $('.compose-tw-char-count').html(140);
                                                                $('.compose-yt-char-count').html(500);
                                                                
                                                                $("#img-show").css({"display": "none"});
                                                                $("#img-show").find('#filename').val('');
                                                                $("#img-show").find("#remove-img").hide();
                                                                $('#img-show').find('#compose-preview-img').removeAttr('src');
                                                                
                                                                $("#cal-show").css({"display": "none"});
                                                                $("#cal-show").find('#datepickerField').val('');
                                                                $("#cal-show").find('#compose-schedule-hours').find('option').removeAttr('selected');
                                                                $("#cal-show").find('#compose-schedule-minutes').find('option').removeAttr('selected');
                                                                
                                                                $("#url-show").css({"display": "none"});
                                                                $('#url-show').find('input').val('');
                                                                $('.compose-insert-link-short-url-hidden').val('');
                                                                $('#url-show').find('textarea').val('');
                                                                $('#url-show').find('p').html('');
                                                                
                                                                $(".btn-compose-post").html('<i class="icon-bolt"></i> POST');
                                                                $(".btn-compose-post").prop('disabled',false);
                                                            });
                                                        }
                                                        else{
                                                            $('.compose-post-status').removeClass('grey');
                                                            $('.compose-post-status').removeClass('green');
                                                            $('.compose-post-status').addClass('red');
                                                            $('.compose-post-status').show();
                                                            $('.compose-post-status').html('Post to Twitter Failed');    
                                                            $('.compose-post-status').fadeOut(7500);
                                                            
                                                            $(".btn-compose-post").html('<i class="icon-bolt"></i> POST');
                                                            $(".btn-compose-post").prop('disabled',false);
                                                        }
                                                    },
                                                });
                                        }
                                        
                                        channels[i] = $(this).val();
                                        i++;
                                    });
                                }
                                else{
                                    $('.compose-channels option:selected').each(function() {        
                                        channels[i] = $(this).val();
                                        i++;
                                    });
                                    
                                    $('.compose-post-status').show();
                                    $('.compose-post-status').addClass('green');
                                    $('.compose-post-status').removeClass('red');
                                    $('.compose-post-status').removeClass('grey');
                                    $('.compose-post-status').html('Post has been scheduled');
                                    $('.compose-post-status').fadeOut(7500,function(){
                                        $('.compose-innercontainer').removeClass("compose-expanded");
                                        $('.compose-innercontainer').addClass("compose-collapsed");
                                        $('.compose-textbox').val('');
                                        $('.compose-insert-link-text').val('');
                                        $("#compose-tags").tagit("removeAll");
                                        $('.select-shorten-url').html('<option value="#">-- Select Shorten URL</option>');
                                        $('.compose-channels').find('option').removeAttr('selected');
                                        $('.compose-channels').next().find('button').html('None Selected <b class="caret"></b>');
                                        $('.compose-channels').next().find('li').removeClass('active');
                                        $('.compose-channels').next().find('input').removeAttr('checked');
                                        $('.compose-fb-char-count').html(2000);
                                        $('.compose-tw-char-count').html(140);
                                        $('.compose-yt-char-count').html(500);
                                        
                                        $("#img-show").css({"display": "none"});
                                        $("#img-show").find('#filename').val('');
                                        $("#img-show").find("#remove-img").hide();
                                        $('#img-show').find('#compose-preview-img').removeAttr('src');
                                        
                                        $("#cal-show").css({"display": "none"});
                                        $("#cal-show").find('#datepickerField').val('');
                                        $("#cal-show").find('#compose-schedule-hours').find('option').removeAttr('selected');
                                        $("#cal-show").find('#compose-schedule-minutes').find('option').removeAttr('selected');
                                        
                                        $("#url-show").css({"display": "none"});
                                        $('#url-show').find('input').val('');
                                        $('.compose-insert-link-short-url-hidden').val('');
                                        $('#url-show').find('textarea').val('');
                                        $('#url-show').find('p').html('');
                                        
                                        $(".btn-compose-post").html('<i class="icon-bolt"></i> POST');
                                        $(".btn-compose-post").prop('disabled',false);
                                    });
                                }
                                
                                $.ajax({
                                    url : BASEURL + 'dashboard/media_stream/SocmedPost',
                                    type: "POST",
                                    data: {
                                            channels:channels,
                                            content:$('.compose-textbox').val(),
                                            tags:$("#compose-tags").tagit("assignedTags"),
                                            schedule:scheduleTime,
                                            title:$('#url-show').find('input').val(),
                                            short_url:$('.compose-insert-link-short-url-hidden').val(),
                                            description:$('#url-show').find('textarea').val(),
                                            image:$('#compose-preview-img').attr('src') == undefined ? '' :  $('#compose-preview-img').attr('src'),
                                            email_me:$('#email_me').val()
                                           },
                                    success: function(){
                                       
                                    }
                                });
                            }
                        }
                    });
                    
                    $('.compose-select-campaign').on('change', function(){
                        $.ajax({
                                url : BASEURL + 'dashboard/media_stream/GetShortenUrlByCampaignId',
                                type: "GET",
                                data: {
                                        campaignId:$(this).val(),
                                        },
                                success: function(data){
                                    var new_data = JSON.parse(data);
                                    $('.select-shorten-url').html('');
                                    for(var x=0; x<new_data.length; x++){
                                        $('.select-shorten-url').append('<option>' + 'http://maybk.co/' + new_data[x].short_code + '</option>');
                                    }
                                }
                            });
                    });
                    
                    $('.select-shorten-url').on('change', function(){
                        $(".select-shorten-url option:selected").linkpreview({
                            url: BASEURL + 'dashboard/media_stream/GetUrlPreview?url=' + $(".select-shorten-url option:selected").val(),
                            previewContainer: "#url-show > .compose-form > div",  //optional
                            //previewContainerClass: ".compose-schedule",
                            refreshButton: ".select-shorten-url option",        //optional
                            preProcess: function() {                //optional
                                $('#url-show').css({"display": "block"});
                                $('#url-show > .compose-form > div').html('Loading...');
                            },
                            onSuccess: function(data) {                  //optional    
                            },
                            onError: function() {                    //optional
                            },
                            onComplete: function() {                 //optional
                            }
                       });
                        var str = $('.select-shorten-url option:selected').val();
                        var res = str.replace('http://maybk.co/','');
                        $('.compose-textbox').val($('.compose-textbox').val() + $(".select-shorten-url option:selected").val());
                        $('.compose-insert-link-short-url-hidden').val(res);
                        ComposeCharCheck();
                    });
                    
                    $(this).on('click', ".destroy_status", function() {
                        var btnDestroyStatus = $(this);
                        var confirmStatus = confirm("Are you sure want to delete this status?")
                        
                        if(confirmStatus == true){
                            $(this).attr('disabled', 'disabled');
                            $.ajax({
                                url : BASEURL + 'dashboard/media_stream/ActionTwitterDelete',
                                type: "POST",
                                data: {
                                    post_id : btnDestroyStatus.closest('li').find('.postId').val(),
                                    //channel_id : $(this).closest('.floatingBox').find('input.channel-id').val()
                                },
                                success: function(response)
                                {
                                    if(response.success == true){
                                        btnDestroyStatus.closest('li').toggle('slow');
                                    }
                                    else
                                    {
                                        btnDestroyStatus.removeAttr('disabled');
                                        btnDestroyStatus.closest('li').toggle( "bounce", { times: 3, complete:function(){
                                            $(this).show();
                                            alert(response.message);
                                        }}, "slow");
                                        
                                    }
                                },
                                failed : function(response){
                                    btnDestroyStatus.removeAttr('disabled');
                                    btnDestroyStatus.closest('li').toggle( "bounce", { times: 3, complete:function(){
                                            $(this).show();
                                            alert(response.message);
                                    }}, "slow");
                                }
                            });    
                        }
                        
                    });
                    
                     $(this).on('click','.retweet, .favorit',
                        function() {
                        var retweetBtn = $(this);
                        var action = $(this).hasClass('favorit') ? "favorite" : "retweet";
                        if(action == "retweet"){
                            if(retweetBtn.hasClass('btn-inverse')){
                                action = "unretweet";
                                retweetBtn.attr('disabled', 'disabled').find('span').html('Unretweeting...');
                            }
                            else{
                                retweetBtn.attr('disabled', 'disabled').find('span').html('Retweeting...');
                            }
                        }
                        else{
                            if(retweetBtn.hasClass('btn-inverse')){
                                action = "unfavorite";
                                retweetBtn.attr('disabled', 'disabled').find('span').html('Unfavoriting...');
                            }
                            else{
                                retweetBtn.attr('disabled', 'disabled').find('span').html('Favoriting...');
                            }
                            
                        }
                        $.ajax({
                            url : BASEURL + 'dashboard/media_stream/ActionTwitter/' + action,
                            type: "POST",
                            data: {
                                post_id : retweetBtn.closest('li').find('.postId').val(),
                                channel_id : $(this).closest('.floatingBox').find('input.channel-id').val()
                            },
                            success: function(response){
                                retweetBtn.removeAttr('disabled').find('span').html('');
                                if(response.success == true){
                                    if(action == 'favorite')
                                        retweetBtn.closest('li').find('.indicator').append('<button type="button" class="btn btn-inverse btn-mini"><i class="icon-star"></i></button>');
                                    else
                                        retweetBtn.closest('li').find('.indicator').append('<button type="button" class="btn btn-success btn-mini"><i class="icon-retweet"></i></button>');
                                }
                                else{
                                    
                                }
                            },
                            failed : function(response){
                                retweetBtn.removeAttr('disabled').find('span').html('');
                                if(action == 'favorite')
                                        retweetBtn.closest('li').find('.indicator').append('<button type="button" class="btn btn-inverse btn-mini"><i class="icon-star"></i></button>');
                                else
                                        retweetBtn.closest('li').find('.indicator').append('<button type="button" class="btn btn-success btn-mini"><i class="icon-retweet"></i></button>');
                            }
                        });
                    });
                    

                    $(this).on('click','.follow',
                        function() {
                        var confirmResult = confirm('Are you sure want to ' + ($(this).hasClass('unfollow') ? 'unfollow' : 'follow') + " this account");
                        var followButton = $(this);
                        
                        if(confirmResult){
                            followButton.attr('disabled', 'disabled');
                            $.ajax({
                                url : BASEURL + 'dashboard/media_stream/ActionFollow/' + ($(this).hasClass('unfollow') ? 'unfollow' : 'follow'),
                                type: "POST",
                                data: {
                                    post_id : $(this).closest('li').find('.postId').val(),
                                    channel_id : $(this).closest('.floatingBox').find('input.channel-id').val()
                                },
                                success: function(response)
                                {
                                    followButton.removeAttr('disabled').find('span').html('');
                                    if(response.success == true){
                                        if(followButton.hasClass('unfollow'))
                                            followButton.removeClass('btn-inverse');
                                        else
                                            followButton.addClass('btn-inverse');
                                    }
                                },
                                error : function(x, y, z){
                                    followButton.closest('li').toggle('slow');
                                    followButton.removeAttr('disabled').find('span').html('');
                                }
                            });
                        }                        
                        
                    });
                    
                    $(this).on('click','.fblike',
                        function() {
                        var fbLikeButton = $(this);
                        isLike = fbLikeButton.html() == "LIKE";
                        fbLikeButton.html('WAITING...').attr("disabled", "disabled");
                        $.ajax({
                            url : BASEURL + 'dashboard/media_stream/FbLikeStatus',
                            type: "POST",
                            data: {
                                post_id: $(this).val(),
                                channel_id : $(this).closest('.floatingBox').find('input.channel-id').val(),
                                like : isLike
                            },
                            success: function(response)
                            {
                                fbLikeButton.removeAttr("disabled");
                                if(response == true){
                                    if(isLike == true)
                                        fbLikeButton.html("UNLIKE");
                                    else
                                        fbLikeButton.html("LIKE");
                                }
                                else{
                                    alert("Failed to like/unlike status");
                                    fbLikeButton.html("LIKE");
                                }
                            },
                        });
                    });
                    
                     $(this).on('click','.btn-send-reply',
                        function() {
                        var len=$(this).parent().siblings(".replaycontent").val().length
                        var commnetbox;
                        if(len<=0){
                            commnetbox='-';
                        }else{
                             commnetbox=$(this).parent().siblings(".replaycontent").val();
                        }
                        
                        if(len>2000){
                            $(this).parent().siblings('.pull-left').find('.message').html('<div class="alert alert-warning">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                            '<strong>Error!</strong> Your message is more than 2000 characters. It will not post to Facebook. </div>');
                            
                        }else{
                            var commentButton = $(this);
                            isSend=commentButton.html()=="SEND";
                            commentButton.html('SENDING...').attr("disabled", "disabled");

                           $.ajax({
                                url : BASEURL + 'dashboard/media_stream/FbReplyPost',
                                type: "POST",
                                data: {
                                    post_id: $(this).val(),
                                    channel_id : $(this).closest('.floatingBox').find('input.channel-id').val(),
                                    comment :commnetbox,
                                    url:$(this).parent().siblings(".link_url").find(".short_code").val(),
                                    reply_type:$(this).parent().siblings('.option-type').find(".replyType").val(),
                                    product_type:$(this).parent().siblings('.option-type').find(".productType").val(),
                                    title :$(this).parent().siblings('#reply-url-show').find(".title_link").val(),
                                    desc :$(this).parent().siblings('#reply-url-show').find(".descr-link").val(),
                                    img :$(this).parent().siblings('#reply-img-show').find("#reply-preview-img").attr('src'),
                                },
                                success: function(response)
                                {
                                    commentButton.removeAttr("disabled");
                                    if(response.success == true){
                                        commentButton.parent().siblings('.pull-left').find('.message').html('<div class="alert alert-warning">' +
                                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                                        '<strong>Success!</strong> '+response.message+' </div>');
                                        commentButton.parent().siblings(".replaycontent").val("");
                                        commentButton.html("SEND"); 
                                        setTimeout(function(){
                                                commentButton.closest('.reply-field').toggle('slow');
                                            }, 3000); 
                                    }
                                    else{
                                        commentButton.parent().siblings('.pull-left').find('.message').html('<div class="alert alert-warning">' +
                                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                                        '<strong>Error!</strong>'+response.message+'</div>');
                                        commentButton.html("SEND");
                                    }

                                },
                                error: function(response) {
                                    commentButton.removeAttr("disabled");
                                    commentButton.parent().siblings('.pull-left').find('.message').html('<div class="alert alert-warning">' +
                                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                                        '<strong>Error!</strong>: Facebook post not founds/'+response.message+'</div>');
                                    commentButton.html("SEND");
                                },
                            });
                            
                        }
                                                
                    }); 
                    
                    $(this).on('click','.btn-send-msg',
                        function() {
                        var len=$(this).parent().siblings(".replaycontent").val().length
                        if(len>2000){
                            $(this).parent().siblings('.pull-left').find('.message').html('<div class="alert alert-warning">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                            '<strong>Error!</strong> Your message is more than 2000 characters. It will not post to Facebook. </div>');
                            
                        }else{
                            var commentButton = $(this);
                            isSend=commentButton.html()=="SEND";
                            commentButton.html('SENDING...').attr("disabled", "disabled");

                           $.ajax({
                                url : BASEURL + 'dashboard/media_stream/FbReplyMsg',
                                type: "POST",
                                data: {
                                    post_id: $(this).val(),
                                    channel_id : $(this).closest('.floatingBox').find('input.channel-id').val(),
                                    comment :$(this).parent().siblings(".replaycontent").val(),
                                    url:'',
                                    title :$(this).parent().siblings('#reply-url-show').find(".title_link").val(),
                                    desc :$(this).parent().siblings('#reply-url-show').find(".descr-link").val(),
                                    img :$(this).parent().siblings('#reply-img-show').find("#reply-preview-img").attr('src'),
                                },
                                success: function(response)
                                {
                                    commentButton.removeAttr("disabled");
                                    if(response.success === true){
                                        commentButton.parent().siblings('.pull-left').find('.message').html('<div class="alert alert-warning">' +
                                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                                        '<strong>Success!</strong> '+response.message+' </div>');
                                        commentButton.parent().siblings(".replaycontent").val("");
                                        commentButton.html("SEND"); 
                                        setTimeout(function(){
                                                commentButton.closest('.reply-field').toggle('slow');
                                            }, 3000); 
                                    }
                                    else{
                                        commentButton.parent().siblings('.pull-left').find('.message').html('<div class="alert alert-warning">' +
                                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                                        '<strong>Error!</strong>'+response.message+'</div>');
                                        commentButton.html("SEND");
                                    }
                                },
                            });
                            
                        }
                                                
                    });
                                        
                    $(this).on('click','.deleteFB',
                        function(){

                            var delButton = $(this);
                            channel_id : $(this).closest('.floatingBox').find('input.channel-id').val()
                            post_id=delButton.closest('li').find('.postId').val();
                            //type=delButton.closest('li').find('.type').val();
                             delButton.attr('disabled', 'disabled').html('DELETING...');
                            $.ajax({
                                url : BASEURL + 'dashboard/media_stream/fbDeleteStatus',
                                type: "POST",
                                data: {
                                    post_id: post_id,
                                    channel_id : $(this).closest('.floatingBox').find('input.channel-id').val(),
                                },
                                success: function(response){
                                    delButton.removeAttr('disabled').html('SEND');
                                }
                            });
                            
                        });
                         $(this).on('click','.pointerCase',
                            function() {
                               $(this).ToCase();
                               var thisElement = $(this);
                               $.ajax({
                                    url : BASEURL + "case/mycase/UpdateReadStatus",
                                    data : {
                                        case_id : $(this).find("input.pointer-case").val()
                                    },
                                    success : function(response){
                                        if(response.success){
                                            thisElement.find(".notifHead").toggleClass('');
                                        }
                                    }
                               });
                            });
                    
                      /*load more content*/  
                    looppage=2;
                    $(this).on('click','.loadmore',
                        function() {
                            $(this).find('span').html("LOADING...");
                            $(this).attr("disabled", "disabled");
                            var loadMoreElement = $(this);
                            loading = true;
                            action=$(this).val();    
                            group_numbers=2;
                            channel_ids = $(this).siblings(".channel_id").val();
                            me = $(this);
                            me.attr('disabled', 'disabled').html('Loading...');
                            $(this).closest('.floatingBoxContainers').load(BASEURL + 'dashboard/media_stream/loadmore/'+action+'/'+looppage+'/'+channel_ids, function(){
                                loadMoreElement.removeAttr("disabled");
                                var currentNumber = $(this).closest('.floatingBoxContainers').find('.unread-post').length;
                                try{
                                    currentNumber += parseInt($(this).closest('.container-fluid').siblings('.floatingBoxMenu').find('li.active .notifyCircle').html());
                                }
                                catch(exception){
                                    currentNumber = $(this).closest('.floatingBoxContainers').find('.unread-post').length;
                                }
                                
                                
                                $(this).closest('.container-fluid').siblings('.floatingBoxMenu').find('li.active .notifyCircle').html(currentNumber);
                                if(currentNumber == 0){
                                    me.closest('.container-fluid').siblings('.floatingBoxMenu').find('li.active .notifyCircle').hide();
                                }
                                else
                                    me.closest('.container-fluid').siblings('.floatingBoxMenu').find('li.active .notifyCircle').show();
                            });
                            me.removeAttr('disabled').html('Loading..');
                            
                            looppage++;
                            loading = false;
                    });                  
                    
                    $(this).on('click','.specialToggleTable',
                        function() {
                        $(this).next().toggle();
                    });                                                         
                });
                

                var sampleTags = [];
                $.ajax({
                    url : BASEURL + 'dashboard/media_stream/GetAllTags',
                    type: "GET",
                    success: function(data)
                    {
                        var new_data = JSON.parse(data);
                        var x=0;
                        $.each(new_data, function(){
                           sampleTags.push(new_data[x].tag_name);
                            x++;
                        });
                    },
                });
                //-------------------------------
                // Allow spaces without quotes.
                //--
                  
                $('#compose-tags').tagit({
                    availableTags: sampleTags,
                    allowSpaces: true,
                });
                
                $(this).on('click','.btn-reply',function(){
                    $(this).closest('h4').siblings('.reply-field').find('#compose-tags-reply').tagit({
                        availableTags: sampleTags,
                        allowSpaces: true
                    });
                });                
                /*==============================================================================================
                 ====================================== LOAD WYSIWYG EDITOR ====================================
                 =============================================================================================*/   

                $('#messageContent').wysihtml5(); 
                var showMemberIcon = $('i.info').parent(),
                    editMemberIcon = $('i.edit').parent(),
                    deleteMemberIcon = $('i.delete').parent();

                $(showMemberIcon).tooltip({
                    title: 'View member profile'
                });

                $(editMemberIcon).tooltip({
                    title: 'Edit member profile'
                });

                $(deleteMemberIcon).tooltip({
                    title: 'Delete member'
                });

                $('i.info, i.edit, i.delete').parent().hover(function () {
                    $(this).children().stop().animate({
                        opacity: 1
                    }, 200);
                }, function() {
                    $(this).children().stop().animate({
                        opacity: .7
                    }, 200);
                });
            });
            
    $(document).ready(function() {
        $('.btn-dashboard-search').click(function(){
            var channel_1 = $('#box-id-1').next().find('.channel-id').val();
            var channel_2 = $('#box-id-2').next().find('.channel-id').val();
            var channel_3 = $('#box-id-3').next().find('.channel-id').val();
            $(this).closest('.container-fluid').next().find('.floatingBox').html('Loading...');
            $('#box-id-1').next().load(BASEURL + 'dashboard/search',
                                       {
                                        channel_id : channel_1,
                                        q : $('.dashboard-search-field').val()
                                        });
            $('#box-id-2').next().load(BASEURL + 'dashboard/search',
                                       {
                                        channel_id : channel_2,
                                        q : $('.dashboard-search-field').val()
                                        });
            
            $('#box-id-3').next().load(BASEURL + 'dashboard/search',
                                       {
                                        channel_id : channel_3,
                                        q : $('.dashboard-search-field').val()
                                        });
            //window.location.href = BASEURL + 'dashboard/search?q=' + $('.dashboard-search-field').val();
        });
        
        
    });
    
    $(document).ready(function() {
        var new_height = $( window ).height() - 225;
        $('.boxStream').height(new_height);
    });
    
    /*=============================================================================================
     ===================================== CMS ACTIONS ============================================
     =============================================================================================*/    
    $(document).ready(function() {
        $('#channelMg a:first').LoadContentAsync({
            url : BASEURL + "channels/listofchannel/facebook" ,
            contentReplaced : $('#channelMg .cms-table '),
            urlParameter : {
                "testParameter" : 1
            }
        });
        $("#channelMg a").click(function(){
           
            $('.btn').removeClass('btn-primary');
            $(this).LoadContentAsync ({
                url : BASEURL +"channels/listofchannel/" + $(this).attr('href').replace("#", ""),
                contentReplaced : $('#channelMg .cms-table '),
                urlParameter : {
                    "testParameter" : 1
                },
            });
        });        
        $(".table-sub-tr").hide();   
        $(".table-btn-show-sub").click(function() {
            if($(this).hasClass('active')) {
                $(this).removeClass('active');
                $(this).removeClass('btn-danger');
                $(this).addClass('btn-primary');
                $(this).html('Show <i class="icon-caret-down"></i>');
                $(this).closest('tr').next().hide('fast');
            }
            else {
                $(this).addClass('active');
                $(this).removeClass('btn-primary');
                $(this).addClass('btn-danger');
                $(this).html('Hide <i class="icon-caret-up"></i>');
                $(this).closest('tr').next().show('fast');
            }
        });
        $(this).on('click','button.delete',function(){
            var confirmBtn = confirm("Are you sure want to delete this item");
            if(confirmBtn == true){
                window.location = $(this).val();
                return true;
            }
            else{
                return false;
            }
        });
        $('#addFbStream .save-changes').click(function(){
            var value = "";
            var pageName = "";
            $('#addFbStream').find('input').each(function(){
                if($(this).is(":checked")){
                    value += $(this).attr('id').toString().replace("chk_", "") + ",";
                    pageName += $(this).val() + ",";
                }
            });
            $(this).AsyncPost({
                url : BASEURL + "channels/listofchannel/FacebookPagePick",
                urlParameter : {
                    "id" :  value,
                    "pageName" : pageName
                },
                reload : true
                
            });
        });
        
        
        $(this).on('submit', 'form.assign_case', function(e){
            var thisContext = $(this);
            console.log($(this).parent().closest('.postId').val());
           
            e.preventDefault();
           
        });
    });
    
    /*=============================================================================================
     ===================================== USERS ACTIONS ==========================================
     =============================================================================================*/

});
/*
 *  Load Content Asyncronously
*/
/*=============================================================================================
===================================== PUBLISHER ACTIONS =======================================
=============================================================================================*/
    
/* initialize the calendar
-----------------------------------------------------------------*/
$(document).ready(function(){
    var content;
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next,today',
            center: 'title',
            right: 'month,agendaWeek'
            //right: 'month,agendaWeek,agendaDay'
        },
        eventSources:[
            {
                url: BASEURL + 'dashboard/media_stream/GetScheduleData',
                type: 'GET'
            }
        ],
        eventClick: function(calEvent, jsEvent, view) {
            //alert('Event: ' + calEvent.title);
            //alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
            //alert('View: ' + view.name);
            $(this).find('.tooltip-event').toggle();
            
            console.log($('#calendar').height() - $(this).find('.tooltip-event').coord().top);
            if(($('#calendar').height() - $(this).find('.tooltip-event').coord().top) < 100){
                $(this).find('.tooltip-event').css('top','-155px');
            }
        },
        eventRender: function(event, element){
            var deleteable;
            if(event.is_posted != '1' && event.user_role == 'Admin'){
                deleteable = "<div class='pull-right'><button type='button' class='btn btn-danger btn-mini btn-delete-schedule-post'><i class='icon-remove'></i></a></div>";
            }
            else{
                deleteable = '';
            }
            
            var tooltip =
            "<div class='tooltip-event hide'>" +
                "<input type='hidden' class='schedule_post_to_id' value='" + event.post_to_id + "'>" +
                "<div class='pull-left'>" + event.post_date + " | " + event.post_time + "</div>" +
                deleteable + 
                "<br clear='all'>" +
                "<div class='tooltip-content pull-left'>" +
                    "<div class='tooltip-content-head'>" + event.title + "</div>" +
                    "<div class='tooltip-content-body'>" +
                        "<p>" +
                            event.description +
                        "</p>" +
                        "<p>" +
                            "Set By : <strong>" + event.user_name + "</strong>" +
                        "</p>" +
                    "</div>" +
                "</div>" +
            "</div>";
            element.append(tooltip);
            
            if(($('#calendar').width() - element.coord().left) < 270){
                element.find('.tooltip-event').css('left','-100px');
            }
        }
    });
    
    $(this).on('click', '.btn-delete-schedule-post', function(){
        var r = confirm('Are you sure want to delete this post?');
        if(r == true){
            var me = $(this);
            $.ajax({
                url : BASEURL + 'dashboard/media_stream/DeleteSchedulePost',
                type: "POST",
                data: {
                    post_to_id:me.parent().siblings('.schedule_post_to_id').val(),
                },
                success: function(result)
                {
                    me.closest('.fc-event').hide();
                },
            });
        }
        else{
            
        }
    });
});

serialize = function(obj) {
  var str = [];
  for(var p in obj)
    if (obj.hasOwnProperty(p)) {
      str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
    }
  return str.join("&");
}

jQuery.fn.LoadContentAsync = function(options){
    $(this).addClass('btn-primary');
    var settings = $.extend({
        url  : window.location.origin,
        urlParameter  : {},
        contentReplaced : $('document'),
        loaderImage : window.location.origin + "/media/img/loader.gif",
        callback : function(response){
            
            settings.contentReplaced.html(response);
        }
    }, options);
    settings.contentReplaced.html("<img style='width:56px;margin:20px 0 0 45%;' src='" + settings.loaderImage + "' alt='' />");
    $.ajax({
        "url" : settings.url,
        "data" : typeof settings.urlParameter == 'string' ? settings.urlParameter : serialize(settings.urlParameter),
        "success" : settings.callback
    });
};

jQuery.fn.AsyncPost = function(options){
    var settings = $.extend({
        url : window.location.origin,
        urlParameter : {},
        reload : true,
        callback : function(response){
            try{
                response = JSON.parse(response);
                alert(response.message);
                if(settings.reload)
                    window.location.reload();
            }catch(e){
                console.log(e);
            }
        }
    }, options);
    
    $.ajax({
        "url" : settings.url,
        "type" : "POST",
        "data" : typeof settings.urlParameter == 'string' ? settings.urlParameter : serialize(settings.urlParameter),
        "success" : settings.callback
    });
};

$.fn.RefreshAllStream = function(){
    $('.floatingBox').each(function(){
        var channelId = $(this).find('.channel-id').val();
        if(channelId != undefined){
            var is_read = $(this).siblings('.containerHeadline').find('.change-read-unread-stream').val();
            if($(this).closest('div').prev().find('i').attr('class') == 'icon-facebook'){
                $(this).html('&nbsp;&nbsp;Loading...');        
                $(this).load(BASEURL + 'dashboard/media_stream/facebook_stream/' + channelId + '/' + is_read, function(){
                    $(this).find('.channel-id').val(channelId);
                });
            }
            else if($(this).closest('div').prev().find('i').attr('class') == 'icon-twitter'){
                $(this).html('&nbsp;&nbsp;Loading...');        
                $(this).load(BASEURL + 'dashboard/media_stream/twitter_stream/' + channelId + '/'+ is_read, function(){
                    $(this).find('.channel-id').val(channelId);
                });
            }
            else if($(this).closest('div').prev().find('i').attr('class') == 'icon-youtube'){
                $(this).html('&nbsp;&nbsp;Loading...');        
                $(this).load(BASEURL + 'dashboard/media_stream/youtube_stream/' + channelId + '/'+ is_read, function(){
                    $(this).find('.channel-id').val(channelId);
                });
            }
        }
    });
};

$.fn.ToCase = function(type){
    var hashUrl = window.location.hash;
    var splitUrl = hashUrl.split('/');
    if(splitUrl.length == 3 ){
        var id = $('#post' + splitUrl[2]).closest('.floatingBoxContainers').attr('id');
        
        $('#' + id).parent().find('ul').hide();
        $('#' + id).show();
        $('#' + id).closest('.floatingBox').find('.stream_head li').removeClass('active');
        $('#' + id).closest('.floatingBox').find('.' + id).parent().addClass('active');
        if($('#post' + splitUrl[2]).length > 0){
            $('#post' + splitUrl[2]).closest('.floatingBox').animate({
                scrollTop: $('#post' + splitUrl[2]).offset().top -  ($('#post' + splitUrl[2]).height() + 20)
            }, 2000, function(){
                $('#post' + splitUrl[2]).toggle('bounce', { times: 3, complete:function(){
                                        $(this).removeAttr('style');
                                }}, 'slow');
            });
        }
        else{
            $.ajax({
                "url" : "",
                "data" : "post_id="
            });
        }
    }    
};


function validateURL(textval) {
    var urlregex = new RegExp(
    "^(http|https|ftp)\://[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(:[a-zA-Z0-9]*)?/?([a-zA-Z0-9\-\._\?\,\'/\\\+&amp;%\$#\=~])*$");
    role = urlregex.test(textval);
    console.log(role);
    return role;
}


function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
} 
