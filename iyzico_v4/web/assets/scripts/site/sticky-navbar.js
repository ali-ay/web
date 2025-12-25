var isInternationalPage = !!$(".international-page").length;

function defaultNavScrollEffect() {
  var scrollTop = $(window).scrollTop();
  var $nav = $(".navbar-fixed-top");
  if ($(window).scrollTop() > 5) {
    $nav.addClass("navbar-fixed-bg navbar-fixed-bg-border");
  } else {
    $nav.removeClass("navbar-fixed-bg navbar-fixed-bg-border");
  }
}

function internationalNavScrollEffect() {
  var scrollTop = $(window).scrollTop();
  var $nav = $(".navbar-fixed-top");
  var $topNotificaton = $(".top-notification");
  var $cookieNotification = $(".cookie-notification");
  var topNotificatonHeight = $topNotificaton.outerHeight();
  if ($topNotificaton.is(":visible") && $cookieNotification.length == 0) {
    $([$topNotificaton, $nav]).each(function(i, $item) {
      if (scrollTop < topNotificatonHeight) {
        $item.css({ top: -scrollTop });
      } else {
        $item.css({ top: -topNotificatonHeight });
      }
    });
  }
}

$(window).scroll(function() {
  defaultNavScrollEffect();
  if (isInternationalPage) internationalNavScrollEffect();
});

$(document).ready(function() {
  defaultNavScrollEffect();
});
