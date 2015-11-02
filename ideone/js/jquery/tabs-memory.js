$(function () {
    $("ul.tabs li").click(function () {
        $("ul.tabs li").removeClass("active");
        $(this).addClass("active");
        $(".tab_content").hide();

        var activeTab = $(this).find("a").attr("href");
        if ($.support.opacity) $(activeTab).fadeIn();
        else $(activeTab).show();

        $.cookie("currentTab", $(this).find("a").attr("rel"), {
            expires: 7
        });
        return false;
    });

    $(".tab_content").hide();
    $("ul.tabs li:eq(" + ($.cookie("currentTab") || 1) + ")").click();
});