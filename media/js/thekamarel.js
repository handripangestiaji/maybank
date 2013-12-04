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

    /*=============================================================================================
     ==================================== GET ACTUAL DATETIME =====================================
     =============================================================================================*/

    // Create two variable with the names of the months and days in an array
    var monthNames = [ "Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sept", "Oct", "Nov", "Dec" ],
        dayNames= ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];

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

    $('.collapseMenu').click(function() { 

        if ($(this).hasClass('uncollapsed')) {
            $('.mainmenu').animate({left: -120}, 200, function() {
                $('.collapseMenu').removeClass('uncollapsed').animate({left: 40}, 200);
                $('.deCollapse').css({display: 'inline-block'});
            });  
        }

        else {
            $('.collapseMenu').addClass('uncollapsed').animate({left: 0}, 200, function() {
                $('.mainmenu').animate({left: 0}, 200);
                $('.deCollapse').css({display: 'none'});
            }); 
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

                var upload_file = $("#composeInputImageFile");
                $( "#remove-img" ).click(function(){
                    $("#compose-preview-img").hide();
                    $("#remove-img").hide();
                    $("#filename").val('');
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
                        function() {
                            previous = $(this).closest('ul.stream_head').find('li.active');
                            previous.removeClass('active');
                            $(this).parent().addClass('active');
                            var id_tab_name = '#' + $(this).attr('class');
                            $(this).closest('.floatingBoxMenu').next().find('.floatingBoxContainers').hide(); 
                            $(this).closest('.floatingBoxMenu').next().find(id_tab_name).show();
                            
                        /*
                        var href = $(this).attr('href'),
                        $previous = $(this).closest('ul.nav-tabs').find('li.active');
                
                        //show one particular menu
                        $(href).parent().children().hide();
                        $(href).fadeIn();
                        */
                    });
    
                    $('.change-read-unread-stream').on('change', function(){
                        var social_id = $(this).closest('.containerHeadline').next().children('.channel-id').val();
                        var is_read = $(this).val();
                        if($(this).closest('div').prev().find('i').attr('class') == 'icon-facebook'){
                            $(this).closest('.containerHeadline').next().html('&nbsp;&nbsp;Loading...');        
                            $(this).closest('.containerHeadline').next().load(BASEURL + 'dashboard/media_stream/facebook_stream/' + social_id + '/' + is_read);
                        }
                        else if($(this).closest('div').prev().find('i').attr('class') == 'icon-twitter'){
                            $(this).closest('.containerHeadline').next().html('&nbsp;&nbsp;Loading...');        
                            $(this).closest('.containerHeadline').next().load(BASEURL + 'dashboard/media_stream/twitter_stream/' + social_id + '/' + is_read);
                        }
                    });
                    var i = 0;
                    $('.containerHeadline .dropdown-stream-channels').each(function(){
                        i++;
                        var streamId, streamType, urlToLoad ;
                        urlToLoad = BASEURL + 'dashboard/media_stream/';
                        streamId = $(this).find('li:nth-child(' + i + ') input').val();
                        
                        if($(this).find('li:nth-child(' + i + ') a').hasClass('facebook_stream')){
                            urlToLoad += "facebook_stream/" + streamId
                            $(this).closest('div').children('button').html('<i class="icon-facebook"></i><h2>Facebook&nbsp;</h2><i class="icon-caret-down"></i>');
                            $(this).closest('.containerHeadline').css( "background-color", "#3B5998" );
                            $(this).closest('.containerHeadline').next().html('&nbsp;&nbsp;Loading...'); 
                        }
                        else if($(this).find('li:nth-child(' + i + ') a').hasClass('twitter_stream')){
                            urlToLoad += "twitter_stream/" + streamId
                            $(this).closest('div').children('button').html('<i class="icon-twitter"></i><h2>Twitter&nbsp;</h2><i class="icon-caret-down"></i>');
                            $(this).closest('.containerHeadline').css( "background-color", "#4099FF" );
                            $(this).closest('.containerHeadline').next().html('&nbsp;&nbsp;Loading...');                                   
                        }
                        $(this).closest('.containerHeadline').next().load(urlToLoad);                      
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
                        $(this).closest('.containerHeadline').next().html('youtube timeline here');
                    });
                });
                            
                $(document).ready(function() {
                        $(this).on('click','.btn-reply',
                            function() {
                                $(this).closest('h4').next().show();
                                $(this).closest('h4').next().next().hide();
                            }
                        );
                        
                        $(this).on('click','.btn-engagement-reply',
                            function() {
                                $(this).parent().siblings('.reply-engagement-field').show();
                                $(this).parent().siblings('.case-engagement-field').hide();
                            }
                        );
                        
                        $(this).on('click','.btn-case',
                            function() {
                                $(this).closest('h4').next().hide();
                                $(this).closest('h4').next().next().show();
                            }
                        );
                        
                         $(this).on('click','.btn-dm',
                            function() {
                                $(this).closest('h4').next().hide();
                                $(this).closest('h4').next().next().show();
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
                                $(this).parent().siblings('.engagement').show();
                            }
                        );
                        
                        $(this).on('click','.read-mark',
                            function(){
                            var me = $(this);
                            $.ajax({
                                    url : BASEURL + 'dashboard/media_stream/ReadUnread',
                                    type: "POST",
                                    data: {
                                            post_id:me.siblings('.postId').val(),
                                            },
                                    success: function(result)
                                    {
                                        if(result == 1){
                                            me.removeClass('redText').addClass('greyText');
                                        }
                                        else{
                                            me.removeClass('greyText').addClass('redText');
                                        }
                                    },
                                });
                        });
                        
                        $(this).on('click','.btn-mark-as-read',function(){
                            var me = $(this);
                            $.ajax({
                                    url : BASEURL + 'dashboard/media_stream/ReadUnread',
                                    type: "POST",
                                    data: {
                                            post_id:$(this).parent().siblings('.postId').val(),
                                            },
                                    success: function()
                                    {
                                        me.hide();
                                        me.siblings('.btn-mark-as-unread').show();
                                        me.parent().siblings('.read-mark').removeClass('redText').addClass('greyText');
                                    },
                                });
                        });
                        
                        $(this).on('click','.btn-mark-as-unread',function(){
                            var me = $(this);
                            $.ajax({
                                    url : BASEURL + 'dashboard/media_stream/ReadUnread',
                                    type: "POST",
                                    data: {
                                            post_id:$(this).parent().siblings('.postId').val(),
                                            },
                                    success: function()
                                    {
                                        me.hide();
                                        me.siblings('.btn-mark-as-read').show();
                                        me.parent().siblings('.read-mark').removeClass('greyText').addClass('redText');
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
                        
                        
                        $(this).on('click','.btn-send-reply',
                           function() {
                                $(this).parent().siblings('.reply-status').show();
                                $(this).parent().siblings('.reply-status').fadeOut(3000);
                            }
                        );

                        $(this).on('click','.dm-field-btn-close',
                            function() {
                                 $(this).parent().parent().hide();
                            }
                        );
                        
                        
                        $(this).on('click','.btn-send-dm',
                           function() {
                                $(this).parent().siblings('.dm-status').show();
                                $(this).parent().siblings('.dm-status').fadeOut(3000);
                            }
                        );
                
                        
                        $(this).on('click','.toggleTable',
                            function(){
                                $(this).parent().parent().next().toggle();
                            }
                        );
                        
                        $(this).on('input propertychange', '.reply_comment',
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

                    $( ".compose-insert-link" ).click(function() {
                       $("#url-show").css({"display": "block"});
                    });

                     $( "#close-url" ).click(function() {
                       $("#url-show").css({"display": "none"});
                    });
                     
                     $('.compose-textbox').bind('input propertychange', function() {
                        var len = this.value.length;
                        $('.compose-fb-char-count').html(2000-len);
                        $('.compose-tw-char-count').html(140-len);
                    });
                     
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
                            if($('#optTw').is(':selected')){
                                $.ajax({
                                    url : BASEURL + 'dashboard/socialmedia/twitterAction',
                                    type: "POST",
                                    data: {
                                            action:'sendTweet',
                                            content:$('.compose-textbox').val()
                                            },
                                    success: function()
                                    {
                                        $('.compose-post-status').show();
                                        $('.compose-post-status').fadeOut(5000);
                                    },
                                });
                            }
                            
                            if($('#optFb').is(':selected')){
                                $.ajax({
                                    url : BASEURL + 'dashboard/socialmedia/fbstatusupdate',
                                    type: "POST",
                                    data: {
                                            content:$('.compose-textbox').val()
                                            },
                                    success: function()
                                    {
                                        $('.compose-post-status').show();
                                        $('.compose-post-status').fadeOut(5000);
                                    },
                                });
                            }
                        }
                    });
                    
                    $(".destroy_status").click(function() {
                        $.ajax({
                            url : BASEURL + 'dashboard/socialmedia/twitterAction',
                            type: "POST",
                            data: {
                                    action:'destroy_status',
                                    str_id: $(".pull-right").siblings(".str_id").val()
                                   },
                            success: function()
                            {
                                $('.compose-post-status').show();
                                $('.compose-post-status').fadeOut(5000);
                            },
                        });
                    });
                    
                     $(this).on('click','.retweet',
                        function() {
                        $.ajax({
                            url : BASEURL + 'dashboard/socialmedia/twitterAction',
                            type: "POST",
                            data: {
                                    action:'retweet',
                                    str_id: $(this).siblings(".str_id").val()
                                    },
                            success: function()
                            {
                                $('.compose-post-status').show();
                                $('.compose-post-status').fadeOut(5000);
                            },
                        });
                    });
                    
                    $(this).on('click','.replayTweet',
                        function() {
                        $.ajax({
                            url : BASEURL + 'dashboard/socialmedia/twitterAction',
                            type: "POST",
                            data: {
                                    action:'replayTweet',
                                    content:$(this).parent().siblings(".replaycontent").val(),
                                    str_id: $(this).val()
                                    },
                            success: function(data)
                            {
                                $('.compose-post-status').show();
                                $('.compose-post-status').fadeOut(5000);
                            },
                        });
                    });
                    
                    $(this).on('click','.dm_send',
                        function() {
                        $.ajax({
                            url : BASEURL + 'dashboard/socialmedia/twitterAction',
                            type: "POST",
                            data: {
                                    action:'dm_send',
                                    content:$(this).parent().siblings(".replaycontent").val(),
                                    screen_name: $(this).siblings(".screen_name").val(),
                                    friendid: $(this).val()
                                    },
                            success: function(data)
                            {
                                alert(data)
                            },
                        });
                    });
                    
                    
                    $(this).on('click','.favorit',
                        function() {
                        $.ajax({
                            url : BASEURL + 'dashboard/socialmedia/twitterAction',
                            type: "POST",
                            data: {
                                    action:'favorit',
                                    str_id: $(this).siblings(".str_id").val()
                                    },
                            success: function()
                            {
                                $('.compose-post-status').show();
                                $('.compose-post-status').fadeOut(5000);
                            },
                        });
                    });

                    $(this).on('click','.follow',
                        function() {
                        $.ajax({
                            url : BASEURL + 'dashboard/socialmedia/twitterAction',
                            type: "POST",
                            data: {
                                    action:'follow',
                                    followid: $(this).siblings(".followid").val()
                                    },
                            success: function()
                            {
                                $('.compose-post-status').show();
                                $('.compose-post-status').fadeOut(5000);
                            },
                        });
                    });
                    
                    $(this).on('click','.unfollow',
                        function() {
                        $.ajax({
                            url : BASEURL + 'dashboard/socialmedia/twitterAction',
                            type: "POST",
                            data: {
                                    action:'unfollow',
                                    followid: $(this).siblings(".followid").val()
                                    },
                            success: function()
                            {
                                $('.compose-post-status').show();
                                $('.compose-post-status').fadeOut(5000);
                            },
                        });
                    });
                    
                    $(this).on('click','.fblike',
                        function() {
                        $.ajax({
                            url : BASEURL + 'dashboard/media_stream/FbLikeStatus',
                            type: "POST",
                            data: {
                                    post_id: $(this).val()
                                    },
                            success: function()
                            {
                                $('.compose-post-status').show();
                                $('.compose-post-status').fadeOut(5000);
                            },
                        });
                    });
                    
                     $(this).on('click','.send_reply',
                        function() {
                        $.ajax({
                            url : BASEURL + 'dashboard/media_stream/FbReplyPost',
                            type: "POST",
                            data: {
                                    post_id:$(this).val(),
                                    comment: $(this).parent().siblings(".reply_comment").val()
                                    },
                            success: function()
                            {
                                $('.compose-post-status').show();
                                $('.compose-post-status').fadeOut(5000);
                            },
                        });
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
                }
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
        loaderImage : window.location.origin + "/media/img/loader.gif"
    }, options);
    settings.contentReplaced.html("<img style='width:56px;margin:20px 0 0 45%;' src='" + settings.loaderImage + "' alt='' />");
    $.ajax({
        "url" : settings.url,
        "data" : serialize(settings.urlParameter),
        "success" : function(response){
            settings.contentReplaced.html(response);
        }
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

$(function() {
//    startRefresh();
//    alert(location.href);
});

function startRefresh() {
    setTimeout(startRefresh,14000);
    //alert(location.href + ' #ctwitter');
    $('#ctwitter').parent().load(BASEURL + 'dashboard/media_stream/twitter_stream/' + $(this).siblings('.channel-stream-id').val());
}
