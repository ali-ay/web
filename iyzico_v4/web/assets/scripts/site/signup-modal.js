function openSignupModal() {
  return false;
  if (typeof isIyziLinkPage != 'undefined' && isIyziLinkPage == true) {
    openIyzilinkModal();
  } else {
    if (
      /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
        navigator.userAgent
      )
    ) {
      window.location = registerPagePath;
    } else {
      if (
        $('#recaptcha-holder-signup').length != 0 &&
        $('#recaptcha-holder-signup').children().length == 0
      ) {
        grecaptcha.render('recaptcha-holder-signup', {
          sitekey: '6LcdQz4UAAAAAC2WQlZInj-6cmv3GwZR1bGg4S8J',
          callback: 'signupUserValidated',
        });
      }
      $('.signup-modal').modal();
    }
  }
}
function openOfferModal() {
  if (
    $('#recaptcha-holder-offer').length != 0 &&
    $('#recaptcha-holder-offer').children().length == 0
  ) {
    grecaptcha.render('recaptcha-holder-offer', {
      sitekey: '6LcdQz4UAAAAAC2WQlZInj-6cmv3GwZR1bGg4S8J',
      callback: 'offerUserValidated',
    });
  }
  $('.offer-modal').modal();
}
function openCepPosOfferModal() {
  if (
    $('#recaptcha-holder-offer').length != 0 &&
    $('#recaptcha-holder-offer').children().length == 0
  ) {
    grecaptcha.render('recaptcha-holder-offer', {
      sitekey: '6LcdQz4UAAAAAC2WQlZInj-6cmv3GwZR1bGg4S8J',
      callback: 'offerUserValidated',
    });
  }
  $('.offer-modal-cep-pos').modal();
}

function openPersonalOnboardModal() {
  if (
    $('#recaptcha-holder-offer').length != 0 &&
    $('#recaptcha-holder-offer').children().length == 0
  ) {
    grecaptcha.render('recaptcha-holder-offer', {
      sitekey: '6LcdQz4UAAAAAC2WQlZInj-6cmv3GwZR1bGg4S8J',
      callback: 'offerUserValidated',
    });
  }
}

function openBuyerProtectedMoneyTransferModal() {
  if (
    $('#recaptcha-holder-offer').length != 0 &&
    $('#recaptcha-holder-offer').children().length == 0
  ) {
    grecaptcha.render('recaptcha-holder-offer', {
      sitekey: '6LcdQz4UAAAAAC2WQlZInj-6cmv3GwZR1bGg4S8J',
      callback: 'offerUserValidated',
    });
  }
  $('.buyerProtectedMoneyTransfer').modal();
}

function openMassPayOutModal() {
  if (
    $('#recaptcha-holder-offer').length != 0 &&
    $('#recaptcha-holder-offer').children().length == 0
  ) {
    grecaptcha.render('recaptcha-holder-offer', {
      sitekey: '6LcdQz4UAAAAAC2WQlZInj-6cmv3GwZR1bGg4S8J',
      callback: 'offerUserValidated',
    });
  }
  $('.massPayOutModal').modal();
}

function openBusinessPwiModal() {
  if (
    $('#recaptcha-holder-offer').length != 0 &&
    $('#recaptcha-holder-offer').children().length == 0
  ) {
    grecaptcha.render('recaptcha-holder-offer', {
      sitekey: '6LcdQz4UAAAAAC2WQlZInj-6cmv3GwZR1bGg4S8J',
      callback: 'offerUserValidated',
    });
  }
  $('.businessPwiModal').modal();
}

function opencashPackageOfferModal() {
  if (
    $('#recaptcha-holder-offer').length != 0 &&
    $('#recaptcha-holder-offer').children().length == 0
  ) {
    grecaptcha.render('recaptcha-holder-offer', {
      sitekey: '6LcdQz4UAAAAAC2WQlZInj-6cmv3GwZR1bGg4S8J',
      callback: 'offerUserValidated',
    });
  }
  $('.offer-modal-cash-package').modal();
}

function openConsumerOfferModal() {
  if (
    $('#recaptcha-holder-offer').length != 0 &&
    $('#recaptcha-holder-offer').children().length == 0
  ) {
    grecaptcha.render('recaptcha-holder-offer', {
      sitekey: '6LcdQz4UAAAAAC2WQlZInj-6cmv3GwZR1bGg4S8J',
      callback: 'offerUserValidated',
    });
  }
  $('.offer-modal-consumer').modal();
}
function openPwiBrandsModal() {
  if (
    $('#recaptcha-holder-offer').length != 0 &&
    $('#recaptcha-holder-offer').children().length == 0
  ) {
    grecaptcha.render('recaptcha-holder-offer', {
      sitekey: '6LcdQz4UAAAAAC2WQlZInj-6cmv3GwZR1bGg4S8J',
      callback: 'offerUserValidated',
    });
  }
  $('.pwi-brands-modal').modal();
}
function openAppDownloadWithQRModal() {
  if (
    $('#recaptcha-holder-offer').length != 0 &&
    $('#recaptcha-holder-offer').children().length == 0
  ) {
    grecaptcha.render('recaptcha-holder-offer', {
      sitekey: '6LcdQz4UAAAAAC2WQlZInj-6cmv3GwZR1bGg4S8J',
      callback: 'offerUserValidated',
    });
  }
  $('.app-download-with-qr').modal();
}
function openAppDownloadWithQRApplyForCardModal() {
  if (
    $('#recaptcha-holder-offer').length != 0 &&
    $('#recaptcha-holder-offer').children().length == 0
  ) {
    grecaptcha.render('recaptcha-holder-offer', {
      sitekey: '6LcdQz4UAAAAAC2WQlZInj-6cmv3GwZR1bGg4S8J',
      callback: 'offerUserValidated',
    });
  }
  $('.app-download-with-qr-apply-for-card').modal();
}
function openPwiHowToBrandsModal() {
  if (
    $('#recaptcha-holder-offer').length != 0 &&
    $('#recaptcha-holder-offer').children().length == 0
  ) {
    grecaptcha.render('recaptcha-holder-offer', {
      sitekey: '6LcdQz4UAAAAAC2WQlZInj-6cmv3GwZR1bGg4S8J',
      callback: 'offerUserValidated',
    });
  }
  $('.pwi-brands-how-to-modal').modal();
}
function consumerOfferRegisterOtpModal() {
  if (
    $('#recaptcha-holder-offer').length != 0 &&
    $('#recaptcha-holder-offer').children().length == 0
  ) {
    grecaptcha.render('recaptcha-holder-offer', {
      sitekey: '6LcdQz4UAAAAAC2WQlZInj-6cmv3GwZR1bGg4S8J',
      callback: 'offerUserValidated',
    });
  }
  $('.consumer-offer-register-otp-modal').modal();
}

function openIyzilinkModal() {
  return false;
  if (
    /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
      navigator.userAgent
    )
  ) {
    window.location = iyziLinkApplypath;
  } else {
    if (
      $('#recaptcha-holder-iyzilink').length != 0 &&
      $('#recaptcha-holder-iyzilink').children().length == 0
    ) {
      grecaptcha.render('recaptcha-holder-iyzilink', {
        sitekey: '6LcdQz4UAAAAAC2WQlZInj-6cmv3GwZR1bGg4S8J',
        callback: 'iyzilinkUserValidated',
      });
    }
    $('.iyzilink-modal').modal();
  }
}

function offerUserValidated(val) {
  $('#recaptcha-holder-offer').hide();
  $('#submit-button-holder-offer').show();
  $('#recaptcha-value-offer').val(val);
}
function signupUserValidated(val) {
  $('#recaptcha-holder-signup').hide();
  $('#submit-button-holder-signup').show();
  $('#recaptcha-value-signup').val(val);
}
function iyzilinkUserValidated(val) {
  $('#recaptcha-holder-iyzilink').hide();
  $('#submit-button-holder-iyzilink').show();
  $('#recaptcha-value-iyzilink').val(val);
}

$( document ).ready(function() {
    console.log( "ready!" );
});


