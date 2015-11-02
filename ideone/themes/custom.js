// DECLARE MODAL ANIMATION
var md_animation = true;
$(document).ready(function () {
    // MODAL - CONTACT FORM
    $("a.modal").click(function () {
        var x = this.title || $(this).text() || this.href;
        var window_height = $(window).height() + 20;
        md_show(x, this.href, window_height, 690);
        return false;
    });

    // SHOW / HIDE CONTROL LINKS ON LOGIN ETC.
    $('#nav').hide();
    $('#show_nav').click(function () {
        if ($('#nav').is(':visible')) {
            $('#nav').slideToggle('fast');
        } else {
            $('#nav').slideToggle('fast');
        }
    });

    // SLIDE DOWN / UP MESSAGES
    if ($('.msgBox1').is(':visible')) {
        $('.msgBox1').hide().slideDown('slow').delay(6000).slideToggle();
    }

    if ($('.msgBox2').is(':visible')) {
        $('.msgBox2').hide().slideDown('slow').delay(6000).slideToggle();
    }

    if ($('.msgBox3').is(':visible')) {
        $('.msgBox3').hide().slideDown('slow').delay(6000).slideToggle();
    }

    if ($('.msgBox4').is(':visible')) {
        $('.msgBox4').hide().slideDown('slow').delay(6000).slideToggle();
    }

    if ($('.msgBox5').is(':visible')) {
        $('.msgBox5').hide().slideDown('slow').delay(6000).slideToggle();
    }

    if ($('.msgBoxSM').is(':visible')) {
        $('.msgBoxSM').hide().slideDown('slow').delay(6000).slideToggle();
    }

    // CONTROL BOXES SLIDE IN WRAP - LOGIN, REGISTER ETC.
    //$('#control_box').slideUp(0).delay(100).slideDown('fast');
    $('#control_box').slideUp(0).delay(100).fadeIn('slow');

    // LOGIN FORM - CHECK FOR EMPTY FIELDS
    $("#frmLogin #btnSubmit").click(function () {
        // user name field
        var txbUn = $("input.txbUn").val();
        if (txbUn == "") {
            $("input.txbUn").focus();
            return false;
        }
        // password field
        var txbPw = $("input.txbPw").val();
        if (txbPw == "") {
            $("input.txbPw").focus();
            return false;
        }
    });

    // REGISTRATION FORM - USER NAME CHECK - EMPTY FIELD
    $("#frmRegister #btnCheck").click(function () {
        // user name field
        var txbUn = $("input.txbUn").val();
        if (txbUn == "") {
            $("input.txbUn").focus();
            return false;
        }
    });

    // REGISTRATION FORM - CHECK FOR EMPTY FIELDS
    $("#frmRegister #btnSubmit").click(function () {
        // user name field
        var txbUn = $("input.txbUn").val();
        if (txbUn == "") {
            $("input.txbUn").focus();
            return false;
        }
        // password field
        var txbPw = $("input.password").val();
        if (txbPw == "") {
            $("input.password").focus();
            return false;
        }
        // password confirm field
        var txbConfirmPw = $("input.txbConfirmPw").val();
        if (txbConfirmPw == "") {
            $("input.txbConfirmPw").focus();
            return false;
        }
        // email field
        var txbEmail = $("input.txbEmail").val();
        if (txbEmail == "") {
            $("input.txbEmail").focus();
            return false;
        }
        // security Q field
        var txbQuestion = $("input.txbQuestion").val();
        if (txbQuestion == "") {
            $("input.txbQuestion").focus();
            return false;
        }
        // security A field
        var txbAnswer = $("input.txbAnswer").val();
        if (txbAnswer == "") {
            $("input.txbAnswer").focus();
            return false;
        }
    });

    // RECOVER PW FORM - CHECK FOR EMPTY FIELDS
    $("#frmRecover #btnSubmit").click(function () {
        // user name field
        var txbUn = $("input.txbUn").val();
        if (txbUn == "") {
            $("input.txbUn").focus();
            return false;
        }
        // security Q field
        var txbQuestion = $("input.txbQuestion").val();
        if (txbQuestion == "") {
            $("input.txbQuestion").focus();
            return false;
        }
        // security A field
        var txbAnswer = $("input.txbAnswer").val();
        if (txbAnswer == "") {
            $("input.txbAnswer").focus();
            return false;
        }
    });

    // RECOVER USER NAME FORM - CHECK FOR EMPTY FIELDS
    $("#frmRecoverUn #btnSubmit").click(function () {
        // email field
        var txbEmail = $("input.txbEmail").val();
        if (txbEmail == "") {
            $("input.txbEmail").focus();
            return false;
        }
        // security Q field
        var txbQuestion = $("input.txbQuestion").val();
        if (txbQuestion == "") {
            $("input.txbQuestion").focus();
            return false;
        }
        // security A field
        var txbAnswer = $("input.txbAnswer").val();
        if (txbAnswer == "") {
            $("input.txbAnswer").focus();
            return false;
        }
    });

    // RECOVER ACTIVATION CODE FORM - CHECK FOR EMPTY FIELDS
    $("#frmResend #btnSubmit").click(function () {
        // user name field
        var txbUn = $("input.txbUn").val();
        if (txbUn == "") {
            $("input.txbUn").focus();
            return false;
        }
    });

    // HIDE IE WARNING MESSAGE ON CLICK
    // check cookie
    var ie_warning = $.cookie("ie_warning");
    if (ie_warning === 'hide') {
        $('#msgBox_IE').hide();
    }
    // on click
    $('#hide_warning').click(function () {
        if ($('#msgBox_IE').is(':visible')) {
            $('#msgBox_IE').slideToggle();

            var date = new Date();
            // set 5 minutes
            date.setTime(date.getTime() + (5 * 60 * 1000));
            $.cookie("ie_warning", "hide", {
                expires: date
            });
        }
    });
});