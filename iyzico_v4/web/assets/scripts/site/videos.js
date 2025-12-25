$(document).ready(function() {
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
});


$(document).ready(function(){
  $('.small-video-holder').on('click','.vjs-playing .vjs-big-play-button',function(){
      var thePlayer = videojs('iyzi-video_html5_api');
      thePlayer.pause();
  })
});
