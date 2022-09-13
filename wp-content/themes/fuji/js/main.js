jQuery(document).ready(function($) {
    $(".main-banner-carousel").owlCarousel({
        loop: true,
        margin: 10,
        nav: false,
        dots: false,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: false,
        touchDrag: true,
        mouseDrag: true,
        animateIn: "fadeIn", // add this
        animateOut: "fadeOut", // and this
        responsive: {
            0: {
                items: 1,
            },
        },
    });

    $(".icons-menu-carousel").owlCarousel({
        loop: true,
        dots: true,
        nav: true,
        autoplay: true,
        margin: 10,
        autoplayTimeout: 10000,
        animateIn: "fadeIn", // add this
        animateOut: "fadeOut", // and this
        responsive: {
            0: {
                items: 1,
            },
            576: {
                items: 2,
            },
            768: {
                items: 3,
            },
            992: {
                items: 5,
                autoplay: false,
                loop: false,
                dots: false,
            },
        },
    });

    $(".manufacturers-carousel").owlCarousel({
        loop: true,
        dots: true,
        nav: true,
        autoplay: true,
        margin: 10,
        autoplayTimeout: 11000,
        animateIn: "fadeIn", // add this
        animateOut: "fadeOut", // and this
        responsive: {
            0: {
                items: 3,
            },
            768: {
                items: 4,
            },
            992: {
                items: 6,
                autoplay: false,
                loop: false,
            },
        },
    });

    $(".search-box").focus(function() {
        $(".suggestion-box").addClass("d-block");
        $(".suggestion-box").removeClass("d-none");
    });

    $(".search-box").focusout(function() {
        $(".suggestion-box").addClass("d-none");
        $(".suggestion-box").removeClass("d-block");
    });

    $(".year").append(new Date().getFullYear());

    var height = $("header").height();
    $(".main-banner").css({ height: "calc(80vh - " + height + "px)" });

    $(".filter-btn").click(function() {
        var height = $(".filter-options").height() + 20;
        var top = $(".filters").position().top;
        var filterHeight = $(".filter-options").position().top;
        $(this).toggleClass("bg-success text-white");

        if (top - filterHeight > 0) {
            $(".filters").css({ bottom: `${height}px` });
            $(".toTop").css({ bottom: `100px` });
        } else {
            $(".filters").css({ bottom: `-450px` });
            $(".toTop").css({ bottom: `50px` });
        }
    });

    $(".grid-btn").click(function() {
        $(this).addClass("active");
        $(".list-btn").removeClass("active");
        $(".list-btn").removeClass("active");
        $(".search-item").addClass("col-6 col-md-4 col-lg-3");
        $(".search-item").removeClass("col-12");
        $(".search-item").find("figure").removeClass("d-none");
        $(".title").addClass("h6 mt-3");
        $(".search-item").find("div").removeClass("px-0 px-lg-2 border-bottom");
        $(".cart-button-group").removeClass("d-none");
        $(".list_type_btn_wrapper").hide();
    });

    $(".list-btn").click(function() {
        $(this).addClass("active");
        $(".grid-btn").removeClass("active");
        $(".search-item").removeClass("col-6 col-md-4 col-lg-3");
        $(".search-item").addClass("col-12");
        $(".search-item").find("figure").addClass("d-none");
        $(".search-item").find("div").addClass("border-bottom");
        $(".title").removeClass("h6 mt-3");
        $(".cart-button-group").addClass("d-none");
        $(".list_type_btn_wrapper").show();
    });
});
// Owl Carousel with Thumbnails
var sync1 = $(".thumbnail-carousel-slider");
var sync2 = $(".carousel-thumbs");
var thumbnailItemClass = ".owl-item";

var slides = sync1
    .owlCarousel({
        video: true,
        startPosition: 12,
        items: 1,
        loop: false,
        margin: 10,
        autoplay: false,
        autoplayTimeout: 6000,
        autoplayHoverPause: false,
        nav: true,
        dots: false,
        touchDrag: true,
        mouseDrag: true,
    })
    .on("changed.owl.carousel", syncPosition);


function syncPosition(el) {
    $owl_slider = $(this).data("owl.carousel");
    var loop = $owl_slider.options.loop;

    if (loop) {
        var count = el.item.count - 1;
        var current = Math.round(el.item.index - el.item.count / 2 - 0.5);
        if (current < 0) {
            current = count;
        }
        if (current > count) {
            current = 0;
        }
    } else {
        var current = el.item.index;
    }

    var owl_thumbnail = sync2.data("owl.carousel");
    var itemClass = "." + owl_thumbnail.options.itemClass;

    var thumbnailCurrentItem = sync2
        .find(itemClass)
        .removeClass("synced")
        .eq(current);

    thumbnailCurrentItem.addClass("synced");

    if (!thumbnailCurrentItem.hasClass("active")) {
        var duration = 300;
        sync2.trigger("to.owl.carousel", [current, duration, true]);
    }
}

var thumbs = sync2
    .owlCarousel({
        startPosition: 12,
        items: 6,
        loop: false,
        margin: 10,
        autoplay: false,
        nav: false,
        dots: false,
        onInitialized: function(e) {
            var thumbnailCurrentItem = $(e.target)
                .find(thumbnailItemClass)
                .eq(this._current);
            thumbnailCurrentItem.addClass("synced");
        },
    })
    .on("click", thumbnailItemClass, function(e) {
        e.preventDefault();
        var duration = 300;
        var itemIndex = $(e.target).parents(thumbnailItemClass).index();
        sync1.trigger("to.owl.carousel", [itemIndex, duration, true]);
    })
    .on("changed.owl.carousel", function(el) {
        var number = el.item.index;
        $owl_slider = sync1.data("owl.carousel");
        $owl_slider.to(number, 100, true);
    });

// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
    "use strict";

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll(".needs-validation");

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms).forEach(function(form) {
        form.addEventListener(
            "submit",
            function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.classList.add("was-validated");
            },
            false
        );
    });
})();

$('#mega-menu-wrap-menu-1').css({ position: '' });