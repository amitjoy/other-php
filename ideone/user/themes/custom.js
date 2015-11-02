$(document).ready(function () {
    // INTITIALIZE SUPERFISH MENU
    $('ul.sf-menu').superfish({
        delay: 1000,
        // delay on mouseout - seconds
        animation: {
            opacity: 'show',
            height: 'show'
        },
        // fade-in and slide-down animation 
        speed: 'fast',
        // faster animation speed 
        autoArrows: true,
        // generation of arrow mark-up 
        dropShadows: true // drop shadows 
    });

    // INITIALIZE ACCORDION
    $(function () {
        $('#accordion').accordion({
            autoHeight: false,
            navigation: true,
            collapsible: true
        });
    });

    // TOGGLE HEADER
    // check cookie
    var headerStatus = $.cookie('showHideHeader');
    if (headerStatus === 'show') {
        $('#Header').show();
    } else if (headerStatus === 'hide') {
        $('#Header').hide();
    } else {
        $('#Header').show();
    }
    // on click
    $('#btnToggleHeader').click(function () {
        if ($('#Header').is(':visible')) {
            $('#Header').slideToggle('fast');
            $.cookie('showHideHeader', 'hide', {
                expires: 1
            });
        } else {
            $('#Header').slideToggle('fast');
            $.cookie('showHideHeader', 'show', {
                expires: 1
            });
        }
    });

    // TOGGLE MENU
    // check cookie
    var menuStatus = $.cookie('showHideMenu');
    if (menuStatus === 'show') {
        $('#Menu').show();
    } else if (menuStatus === 'hide') {
        $('#Menu').hide();
    } else {
        $('#Menu').show();
    }
    // on click
    $('#btnToggleMenu').click(function () {
        if ($('#Menu').is(':visible')) {
            $('#Menu').slideToggle('fast');
            $.cookie('showHideMenu', 'hide', {
                expires: 1
            });
        } else {
            $('#Menu').slideToggle('fast');
            $.cookie('showHideMenu', 'show', {
                expires: 1
            });
        }
    });

    // TOGGLE MEMBERSHIP HISTORY PANEL
    // check cookie
    var mbStatus = $.cookie('showHideMb');
    if (mbStatus === 'show') {
        $('#historyPanel').show();
        $('#btnHistory').text('hide');
    } else if (mbStatus === 'hide') {
        $('#historyPanel').hide();
        $('#btnHistory').text('show');
    } else {
        $('#historyPanel').show();
    }
    // on click
    $('#btnHistory').click(function () {
        if ($('#historyPanel').is(':visible')) {
            $('#historyPanel').hide();
            $('#btnHistory').text('show');
            $.cookie('showHideMb', 'hide', {
                expires: 1
            });
        } else {
            $('#historyPanel').show();
            $('#btnHistory').text('hide');
            $.cookie('showHideMb', 'show', {
                expires: 1
            });
        }
    });

    // SLIDE UP / DOWN MESSAGES
    if ($('.msgBox1').is(':visible')) {
        $('.msgBox1').hide().slideDown('slow').delay(3000).slideToggle();
    }

    if ($('.msgBox1b').is(':visible')) {
        $('.msgBox1b').hide().slideDown('slow').delay(3000).slideToggle();
    }

    if ($('.msgBox2').is(':visible')) {
        $('.msgBox2').hide().slideDown('slow').delay(3000).slideToggle();
    }

    if ($('.msgBox2b').is(':visible')) {
        $('.msgBox2b').hide().slideDown('slow').delay(3000).slideToggle();
    }

    if ($('.msgBox3').is(':visible')) {
        $('.msgBox3').hide().slideDown('slow').delay(3000).slideToggle();
    }

    if ($('.msgBox5').is(':visible')) {
        $('.msgBox5').hide().slideDown('slow').delay(3000).slideToggle();
    }

    // FOOTER PANEL
    $('#toggleFooterPanel').click(function () {
        $('#FooterPanel').slideToggle(500);
        $(this).toggleClass('active');
        return false;
    });

    // SCROLL TO TOP BUTTON
    // hide button first
    $(".toTop").hide();

    // fade in
    $(function () {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('.toTop').fadeIn();
            } else {
                $('.toTop').fadeOut();
            }
        });

        // scroll body to 0px on click
        $('.toTop').click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
    });
});