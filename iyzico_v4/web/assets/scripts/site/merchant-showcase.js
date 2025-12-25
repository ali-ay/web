$(document).ready(function(){
  var $box     = $('.merchant-showcase__wrap .js-merchant-box');
  var $boxActive = $('.merchant-showcase__wrap .js-merchant-box.active');
  var $content = $('.merchant-showcase__wrap .js-merchant-content');
  $box.click(
    function() {
      $box.removeClass('active');
      $(this).addClass('active');

      $activeIndex = $(this).data('index');
      $activeTitle = '.showcase-title-index-' + $activeIndex;

      $('.merchant-showcase__wrap .js-merchant-content', this).show();

      $('.merchant-showcase__title').removeClass('active');
      console.log($activeTitle);
      $($activeTitle).addClass('active');
    }
  );
});
