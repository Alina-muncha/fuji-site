jQuery(document).ready(function ($) {
    $(document).on("click", ".wpvp-options", function (e) {
        e.preventDefault();
        var product_id = $(this).attr("data-product_id");
        $("#wpvp-popup-" + product_id).show();
    });

    $(".wpvp-popup").each(function () {
        $(this).appendTo(".wpvp-popups-container");
    });

    $(document).keydown(function (e) {
        if (e.keyCode == 27) {
            $(".wpvp-popup").hide();
        }
    });

    $(".wpvp-popup").on("click", ".wpvp-popup-close", function (e) {
        $(".wpvp-popup").hide();
    })
});