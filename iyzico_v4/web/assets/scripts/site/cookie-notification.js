window.onload = function(){
var userHasAccepted = Cookies.get("hasAcceptedCookiePolicy");
var userHasSeenTheNotification = Cookies.get(
  "userHasSeenTheCookieNotification"
);
if (!userHasAccepted && !userHasSeenTheNotification) {
  if ($(".cookie-notification").length > 0) {
      $("body").addClass("withCookieNotification");
      var inThirtyMinutes = new Date(new Date().getTime() + 30 * 60 * 1000);
      Cookies.set("userHasSeenTheCookieNotification", true, {
        expires: inThirtyMinutes
      });
    $(".js-close-cookie-notification").click(function(e) {
      e.preventDefault();
      $("body").removeClass("withCookieNotification");
        $(".cookie-notification").remove();
        Cookies.set("hasAcceptedCookiePolicy", true, {
          expires: 365
        });
    });
  }
} else {
  $(".cookie-notification").remove();
}
};


//$("#reSend").ready(function(){
//  countDown()
  //block will be loaded with element with id myid is ready in dom
//})

function startTimer(duration, display) {
  var timer = duration, minutes, seconds;
    var a = setInterval(function () {
      minutes = parseInt(timer / 60, 10);
      seconds = parseInt(timer % 60, 10);

      minutes = minutes < 10 ? "0" + minutes : minutes;
      seconds = seconds < 10 ? "0" + seconds : seconds;

      display.innerHTML = minutes + ":" + seconds;

      if (timer <= 0) {
          clearInterval(a);
      } else {
        timer--;
      }
      displayIcon = document.querySelector('#countdown-icon');
      displayIcon.style.display = "inline-block";
  }, 1000);
}

//window.onload = countDown;

function countDown() {
  var twoMinutes = 60 * 5,
      display = document.querySelector('#countdown');
  startTimer(twoMinutes, display);
};

$(document).ready(function(){
  $("#reSend").click(function(){
    clearInterval(a);
    $.ajax({
      url: "/forms/consumer-otp-re-send-check",
      type: "POST",
      data: ({
        memberUserId: memberUserId,
        referenceCode: referenceCode
      }),
      success: function(data) {
        $('.consumer-register-offer-modal').modal();

      },
      error: function(error) {

        $('.consumer-register-fail-offer-modal').modal();

      }
    });
  });
});



function registerNewMember() {
  var consumerRegisterChannel = window.matchMedia("(max-width: 768px)");
  if (consumerRegisterChannel.matches) {
    consumerRegisterChannel = "CONSUMER_IYZICO_MOBILE_WEB";
  } else {
    consumerRegisterChannel = "CONSUMER_IYZICO_WEB";
  }

  var consumerRegisterFormName = $('#name').val();
  var consumerRegisterFormSurname = $('#surname').val();
  var consumerRegisterFormEmail = $('#personalEmail').val();
  var consumerRegisterFormPhone = $('#personalPhone').val();
  var consumerRegisterFormPassword = $('#password').val();
  var consumerRegisterLeadSource = document.referrer;
  var consumerLocale = $('html').attr('lang');
  var reCaptchaResponse = grecaptcha.getResponse();
  var consumerMemberType = "PERSONAL";
  var pdppPermission = $('#kvkk:checked').val();
  var consumerRegisterFormCorporate = $('#corporate:checked').val();
  var consumerRegisterFormUserAgreement = $('#useragreement:checked').val();

  if(pdppPermission == 'on'){
    pdppPermission = "PERMITTED_ON_REGISTER";
  }else{
    pdppPermission = "UNCHECKED_ON_REGISTER";
  }

  if(consumerRegisterFormCorporate == 'on'){
    consumerRegisterFormCorporate = "PERMITTED";
  }else{
    consumerRegisterFormCorporate = "UNCHECKED_ON_REGISTER";
  }

  if(consumerRegisterFormUserAgreement == 'on'){
    consumerRegisterFormUserAgreement = "PERMITTED_USERAGREEMENT";
  }else{
    consumerRegisterFormUserAgreement = "UNCHECKED_ON_PERMITTED_USERAGREEMENT";
  }



  $.ajax({
    url: "/forms/new-member-register-signup",
    type: "POST",
    data: ({
      name                      : consumerRegisterFormName,
      surName                   : consumerRegisterFormSurname,
      email                     : consumerRegisterFormEmail,
      phoneNumber               : consumerRegisterFormPhone,
      secretWord                : consumerRegisterFormPassword,
      confirmSecretWord         : consumerRegisterFormPassword,
      registerLeadSource        : consumerRegisterLeadSource,
      registerChannel           : consumerRegisterChannel,
      locale                    : consumerLocale,
      reCaptchaResponse         : reCaptchaResponse,
      memberType                : consumerMemberType,
      pdppPermission            : pdppPermission,
      communicationsPermission  : consumerRegisterFormCorporate,
    }),
    success: function(data) {
      if(data.status == 'success') {

        countDown()
        $('.offer-modal-consumer').modal('hide');
        $('.consumer-offer-register-otp-modal').modal();

      } else {

        if( consumerLocale == "tr"){
          var getUrl = "/kendim-icin/hatali";
        }else{
          var getUrl = "/en/personal/fail";
        }

        window.location = getUrl;
        var errorMessage = data.errorMessage;
        document.getElementById("consumerRegisterErrorMessage").innerHTML = errorMessage;

        $('.offer-modal-consumer').modal('hide');
        $('.consumer-register-fail-offer-modal').modal();
      }
    },
    error: function(error) {
      $('.consumer-register-fail-offer-modal').modal();
    }
  });
}


function ajaxConsumerOtp() {
  var otpCode = $('#otpPhone').val();
  var consumerLocale = $('html').attr('lang');
  $.ajax({
    url: "/forms/consumer-otp-check",
    type: "POST",
    data: ({
      memberUserId : memberUserId,
      referenceCode : referenceCode,
      verificationCode : otpCode,
      clientIp : clientIp,
      loginChannel : loginChannel
    }),
    success: function(data) {
      if(data.status == 'success') {

        countDown()
        $('.consumer-offer-register-otp-modal').modal('hide');
        if( consumerLocale == "tr"){
          var getUrl = "/kendim-icin/basarili" + "?ga=kendim-icin-register";
        }else{
          var getUrl = "/en/personal/success" + "?ga=personal-register-success";
        }

        window.location = getUrl;

      } else {
        if( consumerLocale == "tr"){
          var getUrl = "/kendim-icin/hatali";
        }else{
          var getUrl = "/en/personal/fail";
        }

        window.location = getUrl;
        var errorMessage = data.errorMessage;
        document.getElementById("otpPhone").classList.add("error");
        document.getElementById("otpError").innerHTML = errorMessage;
      }

    },
    error: function(error) {
      $('.consumer-register-fail-offer-modal').modal();
    }
  });
}



$(document).ready (function(){
  $('#registerFailBack').click (function(){
    $('.consumer-register-fail-offer-modal').modal('hide');
    $('.offer-modal-consumer').modal();
  });


  var vars = [], hash;
  var q = document.URL.split('?')[1];
  if(q != undefined){
      q = q.split('&');
      for(var i = 0; i < q.length; i++){
          hash = q[i].split('=');
          vars.push(hash[1]);
          vars[hash[0]] = hash[1];
          var sayfa = vars['ga'];
      }
  }

  if(sayfa == 'iyzicolu-ol-register-success'){
    $('.consumer-register-success-modal').modal();
  }
});
