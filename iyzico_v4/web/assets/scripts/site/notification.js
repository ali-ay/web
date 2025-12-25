$(document).ready(function() {
  $('.js-close-notification').on('click', function() {
    $('.top-notification').fadeOut();
    $('.international-page-nav')
      .removeClass('international-page-nav')
      .css({ top: 0 });
  });


  if ($('#flash-modal').length > 0) {
    $('#flash-modal').modal('show');
  }

  if ($('#debit-modal').length > 0) {
    var userHasSeenDebitCardNotification = Cookies.get(
      'userHasSeenDebitCardNotification'
    );
    if (!userHasSeenDebitCardNotification) {
      $('#debit-modal').modal('show');
      Cookies.set('userHasSeenDebitCardNotification', true, { expires: 365 });
    }
  }

  if ($('#video-section-afterload').length > 0) {

    window.setTimeout(function() {
      var webM = $('.parallax-video').data('webm');
      var mp4 = $('.parallax-video').data('mp4');

      $('.parallax-video').append(
        '<source src="' + mp4 + '" type="video/mp4">'
      );
      $('.parallax-video').append(
        '<source src="' + webM + '" type="video/webm">'
      );

      $('.parallax-video')[0].play();
    }, 750);
  }


  if ($('#video-modal').length > 0) {
    $('#video-modal').on('hidden.bs.modal', function() {
      $('#link-video-iframe').attr('src', '');
      $('#link-video-iframe').hide();
    });

    $('#iyzilink-video-list > li').each(function() {
      $(this).click(function() {
        var videoUrl =
          'https://www.youtube.com/embed/' +
          $(this).data('video-id') +
          '?autoplay=1&rel=0';
        $('#link-video-iframe').attr('src', videoUrl);
        $('#video-modal').modal('show');
        $('#link-video-iframe').show();
      });
    });
  }

  function scrollableElement(els) {
    for (var i = 0, argLength = arguments.length; i < argLength; i++) {
      var el = arguments[i], $scrollElement = $(el);
      if ($scrollElement.scrollTop() > 0) {
        return el;
      } else {
        $scrollElement.scrollTop(1);
        var isScrollable = $scrollElement.scrollTop() > 0;
        $scrollElement.scrollTop(0);
        if (isScrollable) {
          return el;
        }
      }
    }
    return [];
  }

  if (
    typeof scrollToElement != 'undefined' && $('#' + scrollToElement).length > 0
  ) {
    var targetOffset = $('#' + scrollToElement).offset().top;
    $(scrollableElement('html', 'body')).animate(
      { scrollTop: targetOffset - 200 },
      600
    );
  }
});

function showVideoList(showLast) {
  var iframe = $('#link-video-iframe');
  var activeVideoUrl = $('.video-button.active').data('youtube');

  if (showLast) {
    $('.video-button').removeClass('active');
    var lastVideoButton = $('.video-button').last();
    lastVideoButton.addClass('active');
    activeVideoUrl = lastVideoButton.data('youtube');
  }

  $('#link-video-iframe').attr('src', activeVideoUrl);
  $('#video-modal').modal('show');
  $('#link-video-iframe').show();
}

$(document).ready(function() {
  var p = $('#dash p');
  var ks = $('#dash').height();
  while ($(p).outerHeight() > ks) {
    $(p).text(function(index, text) {
      return text.replace(/\W*\s(\S)*$/, '...');
    });
  }
});

$(document).ready(function() {
  (function($) {

    function mediaSize() {

      if (window.matchMedia("(min-width: 749px)").matches) {

        document.getElementById("notify").innerHTML = "Sıfır komisyon, ücretsiz eğitimler ve özel indirimlerle";

      } else {
        document.getElementById("notify").innerHTML = "Tüm Desteğimizle";

      }
    }

    mediaSize();

    window.addEventListener("resize", mediaSize, false);
  })(jQuery);

});
