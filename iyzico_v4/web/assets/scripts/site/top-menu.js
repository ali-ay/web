$('document').ready(function() {
  $('.custom-submenu-toggle').click(function() {
    $('.base-main').addClass('blur');
    var targetClass = $(this).data('target');
    var isBackgroundVisible = false;
    $(this).addClass('active');
    $('.custom-submenu').each(function() {
      if (!$(this).hasClass(targetClass)) {
        $(this).hide();
      } else {
        $(this).show();
        isBackgroundVisible = true;
      }
    });
    $('.custom-submenu-toggle').each(function() {
      if ($(this).data('target') !== targetClass) {
        $(this).removeClass('active');
      }
    });
    if (isBackgroundVisible) {
      $('.mainNavigation').addClass('white-background');
      $('.base-header').addClass('white-background');
    } else {
      $('.mainNavigation').removeClass('white-background');
      $('.base-header').removeClass('white-background');
    }
  });

  $('.mainNavigation').on('mouseleave', function() {
    if ($(this).hasClass('white-background')) {
      $(this).removeClass('white-background');
      $('.base-header').removeClass('white-background');
      $('.custom-submenu-toggle').removeClass('active');
      $('.custom-submenu').hide();
      $('.base-main').removeClass('blur');
    }
  });
});

//for mobile
$('document').ready(function() {
  $('.hamburgerMenu').click(function() {
    $('.iyzi-site').toggleClass('menu-open');
    if (!$('.iyzi-site').hasClass('menu-open')) {
      window.setTimeout(function() {
        $('.iyzi-site').addClass('heightFix');
      }, 350);
    } else {
      $('.iyzi-site').removeClass('heightFix');
    }
  });
  $('.mobileMenuSubMenu.hasSub').find('.menuToggler').click(function(event) {
    event.preventDefault();
    $(this).parent().toggleClass('menuOpen');
    var currentText = $(this).text();
    if ($(this).parent().hasClass('menuOpen')) {
      $('.mobileMenuSubMenu.hasSub').each(function() {
        if ($(this).find('.menuToggler').text() !== currentText) {
          $(this).removeClass('menuOpen');
        }
      });
    }
  });
});

//for accordion
$('document').ready(function() {
  $('.accordion.hasSub').find('.sssHeader').click(function(event) {
    event.preventDefault();
    $(this).parent().toggleClass('menuOpen');
    var currentText = $(this).text();
    if ($(this).parent().hasClass('menuOpen')) {
      $('.accordion.hasSub').each(function() {
        if ($(this).find('.sssHeader').text() !== currentText) {
          $(this).removeClass('menuOpen');
        }
      });
    }
  });
});


// for footer

$('document').ready(function() {
  $('.accordion.hasSub').find('.footerMenuTitle').click(function(event) {
    event.preventDefault();
    $(this).parent().toggleClass('menuOpen');
    var currentText = $(this).text();
    if ($(this).parent().hasClass('menuOpen')) {
      $('.accordion.hasSub').each(function() {
        if ($(this).find('.footerMenuTitle').text() !== currentText) {
          $(this).removeClass('menuOpen');
        }
      });
    }
  });
});

$('document').ready(function() {
  $("#secreenMenu li:first").addClass("active");
  $(".image img:first").addClass("active");
  $("ul#secreenMenu li").click(function () {
    $("ul#secreenMenu li").removeClass("active");
    $(this).addClass('active');
    var indis = $(this).index();
    $(".image img").removeClass("active");
    $(".image img:eq(" + indis + ")").addClass("active");

  })
});

$('document').ready(function() {
  $(".screenSelect ul#secreenMenu li:first").addClass("active");
  $(".image img:first").addClass("active");
  $(".screenSelect ul#secreenMenu li").click(function () {
    $(".screenSelect ul#secreenMenu li").removeClass("active");
    $(this).addClass('active');
    var indis = $(this).index();
    if(indis == 0){
      $("#secreenMenu").addClass("mL0");
      $("#secreenMenu").removeClass("mL1 mL2");
      console.log(indis);
    } else if ( indis == 1 ) {
      $("#secreenMenu").addClass("mL1");
      $("#secreenMenu").removeClass("mL0 mL2");
      console.log(indis);
    } else if ( indis == 2 ){
      $("#secreenMenu").addClass("mL2");
      $("#secreenMenu").removeClass("mL0 mL1");
      console.log(indis);
    }
    console.log(indis);
    $(".screenImage img").removeClass("active");
    $(".screenImage img:eq(" + indis + ")").addClass("active");
  })
});
