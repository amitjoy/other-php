var md_done = false;
var md_height = 400;
var md_width = 400;

function md_show(caption, url, height, width) {
    md_height = height || 400;
    md_width = width || 400;
    if (!md_done) {
        $(document.body).append("<div id='md_overlay' style='display:none'></div><div id='md_window' style='display:none'><div id='md_caption'></div>" + "<div class='md_window' alt='close'></div></div>");
        $("#md_window .md_window").click(md_hide);
        $("#md_overlay").click(md_hide);
        $(window).resize(md_position);
        md_done = true;
    }

    $("#md_frame").remove();
    $("#md_window").append("<iframe id='md_frame' src='" + url + "' frameBorder='0' allowtransparency='true'></iframe>");

    $("#md_caption").html(caption);
    $("#md_overlay").fadeIn('slow');
    // scroll to top on show modal
    $('html, body').animate({
        scrollTop: 0
    }, 'slow');
    md_position();

    if (md_animation) $("#md_window").slideDown("fast");
    else $("#md_window").fadeIn('slow');
}

function md_hide() {
    $("#md_window").slideUp("slow");
    $("#md_overlay").fadeOut('slow');
}

function md_position() {
    var de = document.documentElement;
    var w = self.innerWidth || (de && de.clientWidth) || document.body.clientWidth;
    $("#md_window").css({
        width: md_width + "px",
        height: md_height + "px",
        left: ((w - md_width) / 2) + "px"
    });
    $("#md_frame").css("height", md_height - 32 + "px");
}