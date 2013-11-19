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

    $('ul.nav-tabs li a').click(function() {
        var href = $(this).attr('href'),
            $previous = $(this).closest('ul.nav-tabs').find('li.active');

        //show one particular menu
        $(href).parent().children().hide();
        $(href).fadeIn();

        $previous.removeClass('active');
        $(this).parent().stop().addClass('active');

        return false;
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
                    $( "#inputFile" ).trigger("click");
                }); 

                 $( "#closecompose" ).click(function(e){
                    //untuk close publishing
                    $('.compose-innercontainer').addClass("compose-collapsed");
                    $('.compose-innercontainer').removeClass("compose-expanded");
                }); 

                 $('#datepickerField').datepicker();

                  $( "#inputFile" ).change(function(e){
                var val = $(this).val();
                var file = val.split(/[\\/]/);
                $( "#filename" ).val(file[file.length-1]);
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
                    $('.facebook_stream').click(function() {
                        $(this).closest('div').children('button').html('<i class="icon-facebook"></i><h2>Facebook&nbsp;</h2>&nbsp;<i class="icon-caret-down"></i>');
                        $(this).closest('.containerHeadline').css( "background-color", "#3B5998" );
                        $(this).closest('.containerHeadline').next().html('&nbsp;&nbsp;Loading...');        
                        $(this).closest('.containerHeadline').next().load(BASEURL + 'dashboard/media_stream/facebook_stream');
                    });
                    
                    $('.twitter_stream').click(function() {
                        $(this).closest('div').children('button').html('<i class="icon-twitter"></i><h2>Twitter&nbsp;</h2><i class="icon-caret-down"></i>');
                        $(this).closest('.containerHeadline').css( "background-color", "#4099FF" );
                        $(this).closest('.containerHeadline').next().html('&nbsp;&nbsp;Loading...');        
                        $(this).closest('.containerHeadline').next().load(BASEURL + 'dashboard/media_stream/twitter_stream');
                    });
                    
                    $('.youtube_stream').click(function() {
                        $(this).closest('div').children('button').html('<i class="icon-youtube"></i><h2>Youtube&nbsp;</h2><i class="icon-caret-down"></i>');
                        $(this).closest('.containerHeadline').css( "background-color", "#FF3333" );
                        $(this).closest('.containerHeadline').next().html('youtube timeline here');
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
            })
            
            $(document).ready(
                function() {
                    $(".reply-btn").click(
                        function() {
                            $(this).parent().siblings(".reply").hide("slow");
                            $(this).parent().siblings(".assign").hide("slow");
                            $(this).parent().siblings(".reply").show("slow");
                        }
                    );

                    $(".assign-btn").click(
                        function() {
                            $(this).parent().siblings(".reply").hide("slow");
                            $(this).parent().siblings(".assign").hide("slow");
                            $(this).parent().siblings(".assign").show("slow");
                        }
                    );

                    $(".hide-form").click(
                        function() {
                            $(this).parent().parent().parent().hide();
                        }
                    );
                }
            );
            
    /*=============================================================================================
     ===================================== CMS ACTIONS ============================================
     =============================================================================================*/
    
    $(document).ready(function() { 
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
        }
    );
})