$(document).ready(function() {
  $('.culture-carousel').slick({
    centerMode: false,
    slidesToShow: 4,
    slidesToScroll: 4,
    infinite: true,
    dots: false,
    arrows: false,
    variableWidth: true,
    autoplay: true,
    autoplaySpeed: 2000,
  });

  $('.iyzi-brands-carousel').slick({
    centerMode: false,
    slidesToShow: 8,
    infinite: false,
    dots: false,
    arrows: false,
    variableWidth: true,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 6,
          variableWidth: false,
        },
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 4,
        },
      },
      {
        breakpoint: 480,
        settings: {
          arrows: false,
          centerMode: true,
          centerPadding: '15px',
          slidesToShow: 3,
          infinite: true,
          variableWidth: true,
        },
      },
    ],
  });

  $('.iyzi-brands-carousel-custom-length').each(function() {
    var itemCount = $(this).data('length');
    $(this).slick({
      centerMode: false,
      variableWidth: false,
      slidesToShow: itemCount,
      infinite: false,
      dots: false,
      arrows: false,
      responsive: [
        {
          breakpoint: 992,
          settings: {
            slidesToShow: 6,
          },
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 4,
          },
        },
        {
          breakpoint: 480,
          settings: {
            arrows: false,
            centerMode: true,
            centerPadding: '15px',
            slidesToShow: 3,
            infinite: true,
            variableWidth: true,
          },
        },
      ],
    });
  });

  $('.references-carousel').slick({
    variableWidth: false,
    infinite: true,
    centerMode: false,
    slidesToShow: 3,
    arrows: false,
    dots: true,
    responsive: [
      {
        breakpoint: 992,
        settings: {
          slidesToShow: 2,
        },
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 1,
        },
      },
      {
        breakpoint: 480,
        settings: {
          arrows: false,
          slidesToShow: 1,
        },
      },
    ],
  });

  $('.iyzi-default-carousel').slick({
    dots: true,
    arrows: false,
  });

  $('.iyzi-why-carousel').slick({
    dots: true,
    arrows: false,
    slidesToShow: 3,
    responsive: [
      {
        breakpoint: 992,
        settings: {
          arrows: false,
          centerPadding: '40px',
          slidesToShow: 1,
        },
      },
      {
        breakpoint: 480,
        settings: {
          arrows: false,
          centerPadding: '40px',
          slidesToShow: 1,
        },
      },
    ],
  });

  var $width = $(window).width();
  if ($width < 768) {
    $('.iyzi-showcase-carousel').slick({
      infinite: true,
      dots: false,
      arrows: false,
      slidesToShow: 5,
      responsive: [
        {
          breakpoint: 992,
          settings: {
            arrows: false,
            centerPadding: '40px',
            slidesToShow: 5,
          },
        },
        {
          breakpoint: 768,
          settings: {
            arrows: false,
            centerPadding: '40px',
            slidesToShow: 1,
          },
        },
        {
          breakpoint: 630,
          settings: {
            arrows: false,
            centerPadding: '40px',
            slidesToShow: 1,
          },
        },
        {
          breakpoint: 480,
          settings: {
            arrows: false,
            centerPadding: '40px',
            slidesToShow: 1,
          },
        },
      ],
    });
  }

  $('.merchant-showcase-content-carousel').slick({
    infinite: true,
    dots: false,
    arrows: false,
    fade: true,
    swipe: false,
    slidesToShow: 1,
    initialSlide: 2,
  });

  $('.iyzi-product-carousel').slick({
    dots: true,
    arrows: false,
    slidesToShow: 3,
    responsive: [
      {
        breakpoint: 992,
        settings: {
          arrows: false,
          centerPadding: '40px',
          slidesToShow: 1,
        },
      },
      {
        breakpoint: 480,
        settings: {
          arrows: false,
          centerPadding: '40px',
          slidesToShow: 1,
        },
      },
    ],
  });

  $('.merchant-showcase__box').click(function() {
    slideIndex = $(this).data('index');
    $('.merchant-showcase-content-carousel').slick('slickGoTo', slideIndex, true);
  });

  $('.iyzi-steps-carousel').slick({
    centerMode: false,
    slidesToShow: 4,
    arrows: false,
    dots: true,
    responsive: [
      {
        breakpoint: 992,
        settings: {
          slidesToShow: 3,
        },
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 1,
        },
      },
      {
        breakpoint: 480,
        settings: {
          arrows: false,
          slidesToShow: 1,
        },
      },
    ],
  });

  $('.iyzi-steps-boxes-carousel').slick({
    centerMode: false,
    slidesToShow: 5,
    arrows: false,
    dots: true,
    responsive: [
      {
        breakpoint: 992,
        settings: {
          slidesToShow: 4,
        },
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 2,
        },
      },
      {
        breakpoint: 480,
        settings: {
          arrows: false,
          slidesToShow: 1,
        },
      },
    ],
  });

  $('.iyzi-open-source-carousel').slick({
    centerMode: false,
    slidesToShow: 4,
    arrows: false,
    dots: true,
    responsive: [
      {
        breakpoint: 992,
        settings: {
          slidesToShow: 4,
        },
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 3,
        },
      },
      {
        breakpoint: 480,
        settings: {
          arrows: false,
          slidesToShow: 2,
        },
      },
    ],
  });

  $('.head-products-carousel').slick({
    centerMode: false,
    slidesToShow: 3,
    arrows: false,
    dots: true,
    responsive: [
      {
        breakpoint: 992,
        settings: {
          centerMode: false,
          slidesToShow: 2,
        },
      },
      {
        breakpoint: 768,
        settings: {
          centerMode: false,
          slidesToShow: 1,
        },
      },
      {
        breakpoint: 480,
        settings: {
          centerMode: false,
          slidesToShow: 1,
        },
      },
    ],
  });

  $('.press-carousel').slick({
    centerMode: false,
    slidesToShow: 4,
    centerPadding: '70px',
    arrows: false,
    dots: true,
    responsive: [
      {
        breakpoint: 992,
        settings: {
          centerMode: false,
          slidesToShow: 4,
        },
      },
      {
        breakpoint: 769,
        settings: {
          centerMode: true,
          slidesToShow: 1,
        },
      },
      {
        breakpoint: 480,
        settings: {
          centerMode: true,
          centerPadding: '50px',
          slidesToShow: 1,
        },
      },
      {
        breakpoint: 360,
        settings: {
          centerMode: true,
          centerPadding: '50px',
          slidesToShow: 1,
        },
      },
    ],
  });

  $('.pwiCarousel-carousel').slick({
    centerMode: false,
    slidesToShow: 4,
    centerPadding: '70px',
    arrows: false,
    dots: true,
    responsive: [
      {
        breakpoint: 992,
        settings: {
          centerMode: false,
          slidesToShow: 4,
        },
      },
      {
        breakpoint: 767,
        settings: {
          centerMode: true,
          centerPadding: '50px',
          slidesToShow: 1,
        },
      },
      {
        breakpoint: 480,
        settings: {
          centerMode: true,
          centerPadding: '50px',
          slidesToShow: 1,
        },
      },
      {
        breakpoint: 360,
        settings: {
          centerMode: true,
          centerPadding: '50px',
          slidesToShow: 1,
        },
      },
    ],
  });

  if ($('.sliderTestimonial').length > 0) {
    $('.buyerProtectionSlider').slick({
      infinite: true,
      autoplay: true,
      speed: 300,
      slidesToShow: 1,
      centerMode: true,
      arrows: false,
      variableWidth: true,
    });
  }
  if ($('.videosliderTestimonial').length > 0) {
    $('.virtualPosTestimonialSlider').slick({
      infinite: true,
      autoplay: false,
      slidesToShow: 1,
      centerMode: true,
      arrows: true,
      variableWidth: true,
      responsive: [
        {
          breakpoint: 767,
          settings: {
            arrows: false,
            draggable: true,
          }
        },
      ]
    });
  }

  if ($('.sliderScreen').length > 0) {
    $('.banner_slider').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      fade: true,
      asNavFor: '.thumbnail_slider'
    });
    $('.thumbnail_slider').slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      asNavFor: '.banner_slider',
      dots: false,
      arrows: false,
      centerMode: false,
      focusOnSelect: true,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            infinite: true,
            dots: false
          }
        },
        {
          breakpoint: 767,
          settings: {
            slidesToShow: 1,
            centerMode: true,
            slidesToScroll: 1,
            arrows: false
          }
        }
      ]
    });
    $('.banner_slider_mp').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      fade: true,
      asNavFor: '.thumbnail_slider_mp'
    });
    $('.thumbnail_slider_mp').slick({
      slidesToShow: 2,
      slidesToScroll: 1,
      asNavFor: '.banner_slider_mp',
      dots: false,
      arrows: false,
      centerMode: false,
      focusOnSelect: true,
      responsive: [

        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            infinite: true,
            dots: false
          }
        },
        {
          breakpoint: 767,
          settings: {
            slidesToShow: 1,
            centerMode: true,
            slidesToScroll: 1,
            arrows: false
          }
        }
      ]
    });
  }

  if ($('.merchant-showcase__wrap').length > 0) {
    $('.merchant-showcase__wrap').slick({
      infinite: true,
      autoplay: true,
      speed: 300,
      slidesToShow: 1,
      centerMode: true,
      arrows: false,
      variableWidth: true,
    });
  }
  $('.single-item').slick({
    dots: true,
    infinite: true,
    speed: 300,
    slidesToShow: 1,
    adaptiveHeight: true
  });
  if ($('.campaignSlider').length > 0) {
    $('.personalCampaignSlider').slick({
      dots: true,
      infinite: true,
      speed: 300,
      slidesToShow: 1,
      adaptiveHeight: true,
      autoplay: true,
      autoplaySpeed: 5000,
      responsive: [

        {
          breakpoint: 960,
          settings: {
            arrows: false,
            leftMode: true,
            slidesToShow: 1,
            dots: true,
          }
        }
      ]
    });
  }
  if ($('.personalMobileAppSlider').length > 0) {
    $('.personalCampaignSlider').slick({
      dots: false,
      infinite: true,
      speed: 800,
      slidesToShow: 5,
      slidesToScroll: 1,
      swipeToSlide: true,
      swipe: true,
      centerMode: false,
      variableWidth: true,
      responsive: [

        {
          breakpoint: 961,
          settings: {
            arrows: false,
            slidesToShow: 2,
            speed: 300,
            dots: true
          }
        }
      ]
    });
  }
  if ($('.careerSlider').length > 0) {
    $('.personalCampaignSlider').slick({
      dots: true,
      infinite: true,
      speed: 300,
      slidesToShow: 1,
      adaptiveHeight: true,
      autoplay: false,
      autoplaySpeed: 5000,
      responsive: [

        {
          breakpoint: 961,
          settings: {
            arrows: false,
            slidesToShow: 1,
            dots: true,
            slidesToScroll: 1,
            focusOnSelect: true,
            variableWidth: true
          }
        }
      ]
    });
  }
});
