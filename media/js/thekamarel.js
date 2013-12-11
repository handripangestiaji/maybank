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
                                $(this).closest('h4').siblings('.reply-field').show();
                                $(this).closest('h4').siblings('.case-field').hide();
                                $(this).closest('h4').siblings('.dm-field').hide();
                            }
                        );
                        
                        $(this).on('click','.btn-engagement-reply',
                            function() {
                                $(this).parent().siblings('.reply-engagement-field').show();
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
                        
                        $(this).on('click','.read-mark, .btn-case',
                            function(){
                            var me = $(this);
                            $.ajax({
                                    url : BASEURL + 'dashboard/media_stream/ReadUnread',
                                    type: "POST",
                                    data: {
                                        post_id:me.closest('li').find('.postId').val(),
                                        read : $(this).val() == 'case' ? 1 : null
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
                                            me.removeClass('redText').addClass('greyText');
                                        }
                                        else{
                                            currentNumber += 1;
                                            me.removeClass('greyText').addClass('redText');
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

                    $(".compose-insert-link-btn").click(function(){
                        $.ajax({
                                url : BASEURL + 'dashboard/media_stream/GenerateShortUrl',
                                type: "POST",
                                data: {
                                        long_url:$('.compose-insert-link-text').val(),
                                        campaign_id:$('.compose-select-campaign').val()
                                        },
                                success: function(data){
                                    var new_data = JSON.parse(data);
                                    alert(new_data.message);
                                    $('.compose-textbox').val($('.compose-textbox').val()+ 'http://maybk.co/' + new_data.short_code);
                                }
                            });
                        
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
                    });
                    
                    $(this).on('click','.reply-insert-link-btn', function(){
                        var me = $(this);
                        me.siblings(".reply-insert-link-text").linkpreview({
                            previewContainer: me.closest('.pull-left').siblings('#reply-url-show').find('div.reply-url-show-content'),  //optional
                            //previewContainerClass: ".compose-schedule",
                            refreshButton: ".reply-insert-link-btn",        //optional
                            preProcess: function() {                //optional
                                me.closest('.pull-left').siblings("#reply-url-show").show();
                                me.closest('.pull-left').siblings("#reply-url-show").find('div.reply-url-show-content').html('Loading...');
                            },
                            onSuccess: function(data) {                  //optional
                            },
                            onError: function() {                    //optional
                            },
                            onComplete: function() {                 //optional
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
                     
                     $('.compose-textbox').bind('input propertychange', function() {
                        var len = this.value.length;
                        $('.compose-fb-char-count').html(2000-len);
                        $('.compose-tw-char-count').html(140-len);
                        $('.compose-yt-char-count').html(500-len);
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
                                    confirmed = true;
                                }
                                else{
                                    confirmed = false;
                                }
                            }
                            
                            if(len > 500 && check_youtube == true){
                                var r = confirm('Your message is more than 500 characters. It will not post to Youtube. Do you still want to continue?');
                                if(r == true){
                                    $('#optyoutube').removeAttr('selected');
                                    confirmed = true;
                                }
                                else{
                                    confirmed = false;
                                }
                            }
                            
                            if(len > 2000 && check_fb == true){
                                var r = confirm('Your message is more than 2000 characters. It will not post to Facebook. Do you still want to continue?');
                                if(r == true){
                                     $('#optfacebook').removeAttr('selected');
                                    confirmed = true;
                                }
                                else{
                                    confirmed = false;
                                }
                            }
                            
                            if(confirmed == true){
                                var resultPost = 0;
                                $('.compose-channels option:selected').each(function() {
                                    if($(this).attr('id') == 'optfacebook'){
                                        $.ajax({
                                            url : BASEURL + 'dashboard/media_stream/FbStatusUpdate',
                                            type: "POST",
                                            data: {
                                                    content:$('.compose-textbox').val(),
                                                    },
                                            success: function()
                                            {
                                                resultPost = 1;
                                            },
                                        });
                                    }
                                    
                                    if($(this).attr('id') == 'opttwitter'){
                                        $.ajax({
                                            url : BASEURL + 'dashboard/socialmedia/twitterAction',
                                            type: "POST",
                                            data: {
                                                    action:'sendTweet',
                                                    content:$('.compose-textbox').val(),
                                                   },
                                            success: function()
                                                {
                                                    resultPost = 1;
                                                },
                                            });
                                    }
                                    
                                    channels[i] = $(this).val();
                                    i++
                                });
                                
                                if(resultPost == 0){
                                    $('.compose-post-status').show();
                                    $('.compose-post-status').removeClass('green');
                                    $('.compose-post-status').addClass('red');
                                    $('.compose-post-status').html('Post Failed');
                                    $('.compose-post-status').fadeOut(7500);
                                }
                                else{
                                    $('.compose-post-status').show();
                                    $('.compose-post-status').removeClass('red');
                                    $('.compose-post-status').addClass('green');
                                    $('.compose-post-status').html('Post Success');
                                    $('.compose-post-status').fadeOut(7500);
                                }
                                
                                $.ajax({
                                    url : BASEURL + 'dashboard/media_stream/SocmedPost',
                                    type: "POST",
                                    data: {
                                            channels:channels,
                                            content:$('.compose-textbox').val(),
                                            tags:$('.compose-tag-field').val()
                                            },
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
                        
                        $('.compose-textbox').val($('.compose-textbox').val() + $(".select-shorten-url option:selected").val());
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
                        var retweetBtn = $(this);
                        retweetBtn.attr('disabled', 'disabled');
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
                                str_id: $(this).val(),
                                channel_id : $(this).closest('.floatingBox').find('input.channel-id').val()
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
                                //alert(data)
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
                            }
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
                            var commentButton = $(this);
                            isSend=commentButton.html()=="SEND";
                            commentButton.html('SENDING...').attr("disabled", "disabled");

                           $.ajax({
                            url : BASEURL + 'dashboard/media_stream/FbReplyPost',
                            type: "POST",
                            data: {
                                post_id: $(this).val(),
                                channel_id : $(this).closest('.floatingBox').find('input.channel-id').val(),
                                comment :$(this).parent().siblings(".reply_comment").val(),
                            },
                            success: function(response)
                            {
                                commentButton.removeAttr("disabled");
                                if(response == true){
                                  commentButton.html("SEND");   
                                }
                                else{
                                    alert(response);
                                    commentButton.html("SEND");
                                }
                            },
                        });
                                                
                    }); 
                    
                      /*load more content*/  
                    looppage=2;
                    $(this).on('click','.loadmore',
                        function() {
                            loading = true;
                            action=$(this).val();    
                            group_numbers=2;
                            channel_ids = $(this).siblings(".channel_id").val();
                            me = $(this);
                            $(this).closest('.floatingBoxContainers').load(BASEURL + 'dashboard/media_stream/loadmore/'+action+'/'+looppage+'/'+channel_ids, function(){
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
                            
                            
                            looppage++;
                            loading = false;
                    });                  
                    
                    $(this).on('click','.specialToggleTable',
                        function() {
                        $(this).next().toggle();
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

$(function() {
//    startRefresh();
//    alert(location.href);
});

function startRefresh() {
    setTimeout(startRefresh,14000);
    //alert(location.href + ' #ctwitter');
    $('#ctwitter').parent().load(BASEURL + 'dashboard/media_stream/twitter_stream/' + $(this).siblings('.channel-stream-id').val());
}
