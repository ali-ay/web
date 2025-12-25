$(document).ready(function() {
  $('.user-action__localization').on('click', function() {
    $('.user-action__languages').fadeIn('200');
  });

  $('.user-action__languages--item.close').on('click', function() {
    $('.user-action__languages').fadeOut('200');
  });
  if (typeof translatedPage != "undefined") {
    $('.lang-switcher').attr('href',translatedPage);
  }
  $('html').on('click', function(e) {
      var target = $(e.target);

      if (target.is('.user-action__languages') || target.is('.user-action__localization')) {
          return;
      } else {
          $('.user-action__languages').fadeOut('200');
      }
  });
});
