$(".main-banner-carousel").owlCarousel({loop:!0,margin:10,nav:!1,dots:!1,autoplay:!0,autoplayTimeout:8e3,touchDrag:!0,mouseDrag:!0,animateIn:"fadeIn",animateOut:"fadeOut",responsive:{0:{items:1}}}),$(".icons-menu-carousel").owlCarousel({loop:!0,dots:!0,nav:!0,autoplay:!0,margin:10,autoplayTimeout:1e4,animateIn:"fadeIn",animateOut:"fadeOut",responsive:{0:{items:1},576:{items:2},768:{items:3},992:{items:5,autoplay:!1,loop:!1,dots:!1}}}),$(".manufacturers-carousel").owlCarousel({loop:!0,dots:!0,nav:!0,autoplay:!0,margin:10,autoplayTimeout:11e3,animateIn:"fadeIn",animateOut:"fadeOut",responsive:{0:{items:3},768:{items:4},992:{items:6,autoplay:!1,loop:!1}}}),$(".search-box").focus(function(){$(".suggestion-box").addClass("d-block"),$(".suggestion-box").removeClass("d-none")}),$(".search-box").focusout(function(){$(".suggestion-box").addClass("d-none"),$(".suggestion-box").removeClass("d-block")}),$(".year").append((new Date).getFullYear());var height=$("header").height();$(".main-banner").css({height:"calc(80vh - "+height+"px)"}),$(".filter-btn").click(function(){var e=$(".filter-options").height()+20,t=$(".filters").position().top,s=$(".filter-options").position().top;$(this).toggleClass("bg-success text-white"),t-s>0?($(".filters").css({bottom:`${e}px`}),$(".toTop").css({bottom:"100px"})):($(".filters").css({bottom:"-450px"}),$(".toTop").css({bottom:"50px"}))}),$(".grid-btn").click(function(){$(this).addClass("active"),$(".list-btn").removeClass("active"),$(".list-btn").removeClass("active"),$(".search-item").addClass("col-6 col-md-4"),$(".search-item").removeClass("col-12"),$(".search-item").find("figure").removeClass("d-none"),$(".title").addClass("h6 mt-3"),$(".search-item").find("div").removeClass("px-0 px-lg-2 border-bottom")}),$(".list-btn").click(function(){$(this).addClass("active"),$(".grid-btn").removeClass("active"),$(".search-item").removeClass("col-6 col-md-4"),$(".search-item").addClass("col-12"),$(".search-item").find("figure").addClass("d-none"),$(".search-item").find("div").addClass("border-bottom"),$(".title").removeClass("h6 mt-3")});var sync1=$(".thumbnail-carousel-slider"),sync2=$(".carousel-thumbs"),thumbnailItemClass=".owl-item",slides=sync1.owlCarousel({video:!0,startPosition:12,items:1,loop:!1,margin:10,autoplay:!1,autoplayTimeout:6e3,autoplayHoverPause:!1,nav:!0,dots:!1,touchDrag:!0,mouseDrag:!0}).on("changed.owl.carousel",syncPosition);function syncPosition(e){if($owl_slider=$(this).data("owl.carousel"),$owl_slider.options.loop){var t=e.item.count-1;(s=Math.round(e.item.index-e.item.count/2-.5))<0&&(s=t),s>t&&(s=0)}else var s=e.item.index;var o="."+sync2.data("owl.carousel").options.itemClass,a=sync2.find(o).removeClass("synced").eq(s);if(a.addClass("synced"),!a.hasClass("active")){sync2.trigger("to.owl.carousel",[s,300,!0])}}var thumbs=sync2.owlCarousel({startPosition:12,items:6,loop:!1,margin:10,autoplay:!1,nav:!1,dots:!1,onInitialized:function(e){$(e.target).find(thumbnailItemClass).eq(this._current).addClass("synced")}}).on("click",thumbnailItemClass,function(e){e.preventDefault();var t=$(e.target).parents(thumbnailItemClass).index();sync1.trigger("to.owl.carousel",[t,300,!0])}).on("changed.owl.carousel",function(e){var t=e.item.index;$owl_slider=sync1.data("owl.carousel"),$owl_slider.to(t,100,!0)});!function(){"use strict";var e=document.querySelectorAll(".needs-validation");Array.prototype.slice.call(e).forEach(function(e){e.addEventListener("submit",function(t){e.checkValidity()||(t.preventDefault(),t.stopPropagation()),e.classList.add("was-validated")},!1)})}();