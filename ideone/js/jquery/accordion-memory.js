$(document).ready(function () {
    // remember accordion selection
    var accordion = $("#accordion");
    var index = $.cookie("accordion");
    var active;
    if (index !== null) {
        active = accordion.find("h3:eq(" + index + ")");
    } else {
        active = 0
    }
    accordion.accordion({
        header: "h3",
        event: "click hoverintent",
        active: active,
        change: function (event, ui) {
            var index = $(this).find("h3").index(ui.newHeader[0]);
            $.cookie("accordion", index, {
                path: "/"
            });
        },
        autoHeight: false
    });
});