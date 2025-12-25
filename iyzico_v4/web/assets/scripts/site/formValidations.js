$(document).ready(function () {
  $('.password-input').keyup(function () {
    value = $(this).val();
    tooltipText = $(this).parent().find('.tooltiptext');
    tooltipText.find('span').each(function () {
      $(this).removeClass('dashed');
      $(this).removeClass('wrong');
    });
    var isSixDigit = /^\d{6}$/gm.test(value);
    var hasTwoConsecutiveNumbers = hasConsecutiveNumbers(value,2);
    var hasThreeTimesRepeatedOneBlock = /\d*(\d)\1{2,}\d*/.test(value);
    var hasThreeTimesRepeatedTwoBlock = /(?:(\d)\1){3}/.test(value);
    var hasTreeUniqNumbers = hasUniqueNumbers(value,3);
    var isFirstThreeAndLastThreeSame = /(\d{3})\1/.test(value);

    if (isSixDigit)
      {
        tooltipText.find('.sixDigit').addClass('dashed');
      }else{
        tooltipText.find('.sixDigit').removeClass('dashed');
      }

    if (!(value.length < 3)){
      if (!hasTwoConsecutiveNumbers)
        {
          tooltipText.find('.hasTwoConsecutiveNumbers').addClass('dashed');
        }else{
          tooltipText.find('.hasTwoConsecutiveNumbers').addClass('wrong');
        }

      if (!hasThreeTimesRepeatedOneBlock)
        {
          tooltipText.find('.hasThreeTimesRepeatedOneBlock').addClass('dashed');
        }else{
          tooltipText.find('.hasThreeTimesRepeatedOneBlock').addClass('wrong');
        }

      if (hasTreeUniqNumbers)
        {
            tooltipText.find('.hasTreeUniqNumbers').addClass('dashed');
        }else{
          if (!(value.length < 6)){
            tooltipText.find('.hasTreeUniqNumbers').addClass('wrong');
            }
        }
    }

    if (!(value.length < 6)){
      if (!hasThreeTimesRepeatedTwoBlock)
      {
        tooltipText.find('.hasThreeTimesRepeatedTwoBlock').addClass('dashed');

      }else{
        tooltipText.find('.hasThreeTimesRepeatedTwoBlock').addClass('wrong');
      }

      if (!isFirstThreeAndLastThreeSame)
      {
        tooltipText.find('.isFirstThreeAndLastThreeSame').addClass('dashed');
      }else{
        tooltipText.find('.isFirstThreeAndLastThreeSame').addClass('wrong');
      }
    }

  });

  $('.password-input-new').keyup(function () {
    value = $(this).val();
    tooltipText = $(this).parent().find('.tooltiptext');
    tooltipText.find('span').each(function () {
      $(this).removeClass('dashed');
    });
    var isSixDigit = /[A-Z]/.test(value);
    var hasLowerCase = /[a-z]/.test(value);
    var hasNumbers = /\d/.test(value);

    if (isSixDigit) tooltipText.find('.sixDigit').addClass('dashed');
    if (hasLowerCase) tooltipText.find('.pass-lower').addClass('dashed');
    if (hasNumbers) tooltipText.find('.pass-number').addClass('dashed');

    if (!(value.length < 8)) {
      tooltipText.find('.pass-length').addClass('dashed');
    }
  });

  var lang = $("#other-language").html();

  if(lang === 'ENG') {
    $.extend( $.validator.messages, {
      required: "Lütfen işaretli alanları doldurun.",
      remote: "Lütfen bu alanı düzeltin.",
      email: "Lütfen geçerli bir e-posta adresi giriniz.",
      url: "Lütfen geçerli bir web adresi (URL) giriniz.",
      date: "Lütfen geçerli bir tarih giriniz.",
      dateISO: "Lütfen geçerli bir tarih giriniz(ISO formatında)",
      number: "Lütfen geçerli bir sayı giriniz.",
      digits: "Lütfen sadece sayısal karakterler giriniz.",
      equalTo: "Lütfen aynı değeri tekrar giriniz.",
      extension: "Lütfen geçerli uzantıya sahip bir değer giriniz.",
      maxlength: $.validator.format( "Lütfen en fazla {0} karakter uzunluğunda bir değer giriniz." ),
      minlength: $.validator.format( "Lütfen en az {0} karakter uzunluğunda bir değer giriniz." ),
      rangelength: $.validator.format( "Lütfen en az {0} ve en fazla {1} uzunluğunda bir değer giriniz." ),
      range: $.validator.format( "Lütfen {0} ile {1} arasında bir değer giriniz." ),
      max: $.validator.format( "Lütfen {0} değerine eşit ya da daha küçük bir değer giriniz." ),
      min: $.validator.format( "Lütfen {0} değerine eşit ya da daha büyük bir değer giriniz." ),
    } );
  }

  $.validator.addMethod(
    'passwordRegex',
    function(value, element, regexpr) {
      if (!(value.length < 6)) {
        var isSixDigit = /^\d{6}$/gm.test(value);
        var hasTwoConsecutiveNumbers = hasConsecutiveNumbers(value,2);
        var hasThreeTimesRepeatedOneBlock = /\d*(\d)\1{2,}\d*/.test(value);
        var hasThreeTimesRepeatedTwoBlock = /(?:(\d)\1){3}/.test(value);
        var hasTreeUniqNumbers = hasUniqueNumbers(value,3);
        var isFirstThreeAndLastThreeSame = /(\d{3})\1/.test(value);
        if (isSixDigit + !hasTwoConsecutiveNumbers + !hasThreeTimesRepeatedOneBlock + !hasThreeTimesRepeatedTwoBlock + hasTreeUniqNumbers + !isFirstThreeAndLastThreeSame == 6) {
          return true;

        } else {
          return false;
        }
      } else {
        return false;
      }

    },

    ''
  );
  $.validator.addMethod(
    'nameRegex',
    function(value, element, regexpr) {
      regexpr = /^(?=.{2,150}$).*/;
      testValue = value.replace(/ /g, '');
      if (!(testValue.length < 2)) {
        return regexpr.test(value);
      } else {
        return false;
      }
    },
    ''
  );
  $.validator.addMethod(
    'phoneRegex',
    function(value, element, regexpr) {
      regexpr = /^\s*(?:\+?(\d{1,3}))?([-. (]*(\d{3})[-. )]*)?((\d{3})[-. ]*(\d{2,4})(?:[-.x ]*(\d+))?)\s*$/gm;
      testValue = value.replace(/ /g, '');
      if (!(testValue.length < 6)) {
        return regexpr.test(value);
      } else {
        return false;
      }
    },
    ''
  );
  $.validator.addMethod(
    'emailRegex',
    function(value, element, regexpr) {
      regexpr = /^[a-z0-9._%+-]+@.+\..+/;
      testValue = value.replace(/ /g, '');
      if (!(testValue.length < 6)) {
        return regexpr.test(value);
      } else {
        return false;
      }
    },
    ''
  );

  $('.signup-form-inpage').validate({
    rules: {
      email: {
        required: true,
        email: true,
      },
      phone: {
        required: true,
        phoneRegex: /^[0-9\-\(\)\s]+$/,
      },
      website: {
        required: true,
      },
      password: {
        required: true,
        passwordRegex: /[a-z]/,
      },
      passwordRepeat: {
        required: true,
        equalTo: '#passwordPage',
      },
    },
    messages: {
      email: '',
      phone: '',
      password: '',
      passwordRepeat: '',
    },
    submitHandler: function(form) {
      form.submit();
    },
  });

  $('.signup-form-popup').validate({
    rules: {
      email: {
        required: true,
        email: true,
      },
      phone: {
        required: true,
        phoneRegex: /^[0-9\-\(\)\s]+$/,
      },
      website: {
        required: true,
      },
      password: {
        required: true,
        passwordRegex: /[a-z]/,
      },
      passwordRepeat: {
        required: true,
        equalTo: '#passwordPopup',
      },
    },
    messages: {
      email: '',
      phone: '',
      password: '',
      passwordRepeat: '',
    },
    submitHandler: function(form) {
      form.submit();
    },
  });
  $('.iyzilink-form-popup').validate({
    rules: {
      name: {
        required: true,
      },
      email: {
        required: true,
        email: true,
      },
      phone: {
        required: true,
        phoneRegex: /^[0-9\-\(\)\s]+$/,
      },
      website: {
        required: true,
      },
      password: {
        required: true,
        passwordRegex: /[a-z]/,
      },
      passwordRepeat: {
        required: true,
        equalTo: '#passwordPopupLink',
      },
    },
    messages: {
      name: '',
      email: '',
      phone: '',
      website: '',
      password: '',
      passwordRepeat: '',
    },
    submitHandler: function(form) {
      form.submit();
    },
  });

  $('.iyzilink-form-inpage').validate({
    rules: {
      name: {
        required: true,
      },
      email: {
        required: true,
        email: true,
      },
      phone: {
        required: true,
        phoneRegex: /^[0-9\-\(\)\s]+$/,
      },
      website: {
        required: true,
      },
      password: {
        required: true,
        passwordRegex: /[a-z]/,
      },
      passwordRepeat: {
        required: true,
        equalTo: '#passwordPageLink',
      },
    },
    messages: {
      name: '',
      email: '',
      phone: '',
      website: '',
      password: '',
      passwordRepeat: '',
    },
    submitHandler: function(form) {
      form.submit();
    },
  });

  $('#join-us-form').validate({
    rules: {
      name: {
        required: true,
      },
      position: {
        required: true,
      },
      mail: {
        required: true,
        email: true,
      },
      phone: {
        required: true,
        phoneRegex: /^[0-9\-\(\)\s]+$/,
      },
    },
    messages: {
      name: '',
      position: '',
      email: '',
      phone: '',
    },
    submitHandler: function(form) {
      if ($('#file').val() == '') {
        $('#fake-file').addClass('error');
      } else {
        form.submit();
      }
    },
  });
  $('.offer-form-popup').validate({
    rules: {
      name: {
        required: true,
      },
      emaillead: {
        required: true,
        email: true,
      },
      phone: {
        required: true,
        phoneRegex:  /^(\+\d{2,4})?\s?(\d{10})$/,
      },
      website: {
        required: true,
      },
    },
    messages: {
      name:
        {
          required: '',
          minlength: '',
        },
      website:
        {
          required: '',
        },
      emaillead:
        {
          required: '',
          email: ''
        },
      phone:
        {
          required: '',
          minlength: ''
        },
    },
    submitHandler: function(form) {
      form.submit();
    },
  });

  $('.signup-form-final').validate({
    rules: {
      name: {
        required: true,
        nameRegex: /^(?=.{2,150}$).*/,
      },
      surname: {
        required: true,
        nameRegex: /^(?=.{2,150}$).*/
      },
      email: {
        required: true,
        emailRegex: /^[a-z0-9._%+-]+@.+\..+/,
      },
      phone: {
        required: true,
        phoneRegex: /^\s*(?:\+?(\d{1,3}))?([-. (]*(\d{3})[-. )]*)?((\d{3})[-. ]*(\d{2,4})(?:[-.x ]*(\d+))?)\s*$/gm,
      },
      website: {
        required: true,
      },
      password: {
        required: true,
        passwordRegex: /^(?=.{8,})(?=.*\d)(?=.*[a-zçıöğşü])(?=.*[A-ZÇİÖŞÜ]).*$/gm,
      },
      captchaCheck: {
          required: function () {
              return !grecaptcha.getResponse();
          }
      }
    },
    messages: {
      name: '',
      surname: '',
      email: '',
      phone: '',
      password: '',
    },
    submitHandler: function (form) {
      if (grecaptcha.getResponse()) {
        form.submit();
      } else {
        grecaptcha.reset();
        grecaptcha.execute();
      }
    },
  });

  $('.register-new-member-signup-popup').validate({
    rules: {
      name: {
        required: true,
        nameRegex: /^(?=.{2,150}$).*/,
      },
      surname: {
        required: true,
        nameRegex: /^(?=.{2,150}$).*/
      },
      personalEmail: {
        required: true,
        emailRegex: /^[a-z0-9._%+-]+@.+\..+/,
      },
      personalPhone: {
        required: true,
        phoneRegex: /^\s*(?:\+?(\d{1,3}))?([-. (]*(\d{3})[-. )]*)?((\d{3})[-. ]*(\d{2,4})(?:[-.x ]*(\d+))?)\s*$/gm,
      },
      password: {
        required: true,
        passwordRegex: /^(?=.{8,})(?=.*\d)(?=.*[a-zçıöğşü])(?=.*[A-ZÇİÖŞÜ]).*$/gm,
      },
      captchaCheck: {
        required: function () {
          return !grecaptcha.getResponse();
        }
      }
    },

    errorPlacement: function (error, element) {
      var checkkMessage = "Lütfen işaretli alanları doldurun.";
      var errorType = error[0].innerText;
      if (errorType === checkkMessage) {
        $('#alertMessage').empty();
        error.appendTo($('#alertMessage'));
      } else {
        if (errorType !== checkkMessage) {
          error.insertAfter(element)
        }
      }
    },

    submitHandler: function (form) {
      if (grecaptcha.getResponse()) {
        registerNewMember();
      } else {
        grecaptcha.reset();
        grecaptcha.execute();
      }
    },
  });

  $('.consumer-otp-popup').validate({
    rules: {
      otpPhone: {
        required: true,
        phoneRegex: /^\s*(?:\+?(\d{1,3}))?([-. (]*(\d{3})[-. )]*)?((\d{3})[-. ]*(\d{2,4})(?:[-.x ]*(\d+))?)\s*$/gm,
      },
    },

    errorPlacement: function (error, element) {
      var checkkMessage = "Lütfen işaretli alanları doldurun.";
      var errorType = error[0].innerText;
      if (errorType === checkkMessage) {
        $('#alertMessage').empty();
        error.appendTo($('#alertMessage'));
      } else {
        if (errorType !== checkkMessage) {
          error.insertAfter(element)
        }
      }
    },


    submitHandler: function (form) {
      if (grecaptcha.getResponse()) {
        ajaxConsumerOtp();
      } else {
        grecaptcha.reset();
        grecaptcha.execute();
      }
    },
  });
  $('.consumer-otp-re-send-popup').validate({

    submitHandler: function (form) {
        form.submit();
    },
  });

  $('.cash-package-offer-form-popup').validate({
    rules: {
      name: {
        required: true,
      },
      emailcash: {
        required: true,
        email: true
      },
      phone: {
        required: true,
        phoneRegex:  /^(\+\d{2,4})?\s?(\d{10})$/,
      },
      website: {
        required: true
      },
    },
    messages: {
      name:
        {
          required: '',
          minlength: '',
        },
      website:
        {
          required: '',
        },
      emailcash:
        {
          required: '',
          email: ''
        },
      phone:
        {
          required: '',
          minlength: ''
        },
    },
    submitHandler: function(form) {
      form.submit();
    },
  });
  $('.buyer-protected-money-transfer-popup').validate({
    rules: {
      name: {
        required: true,
      },
      emailcash: {
        required: true,
        email: true
      },
      phone: {
        required: true,
        phoneRegex:  /^(\+\d{2,4})?\s?(\d{10})$/,
      },
      website: {
        required: true
      },
    },
    messages: {
      name:
        {
          required: '',
          minlength: '',
        },
      website:
        {
          required: '',
        },
      emailcash:
        {
          required: '',
          email: ''
        },
      phone:
        {
          required: '',
          minlength: ''
        },
    },
    submitHandler: function(form) {
      form.submit();
    },
  });
  $('.mass-pay-out-popup').validate({
    rules: {
      name: {
        required: true,
      },
      emailcash: {
        required: true,
        email: true
      },
      phone: {
        required: true,
        phoneRegex:  /^(\+\d{2,4})?\s?(\d{10})$/,
      },
      website: {
        required: true
      },
    },
    messages: {
      name:
        {
          required: '',
          minlength: '',
        },
      website:
        {
          required: '',
        },
      emailcash:
        {
          required: '',
          email: ''
        },
      phone:
        {
          required: '',
          minlength: ''
        },
    },
    submitHandler: function(form) {
      form.submit();
    },
  });
  $('.business-pwi-popup').validate({
    rules: {
      name: {
        required: true,
      },
      emailcash: {
        required: true,
        email: true
      },
      phone: {
        required: true,
        phoneRegex:  /^(\+\d{2,4})?\s?(\d{10})$/,
      },
      website: {
        required: true
      },
    },
    messages: {
      name:
        {
          required: '',
          minlength: '',
        },
      website:
        {
          required: '',
        },
      emailcash:
        {
          required: '',
          email: ''
        },
      phone:
        {
          required: '',
          minlength: ''
        },
    },
    submitHandler: function(form) {
      form.submit();
    },
  });
  $('.offer-form-subscription').validate({
    rules: {
      name: {
        required: true,
      },
      phone: {
        required: true,
        phoneRegex: /^(\+\d{2,4})?\s?(\d{10})$/,
      },
    },
    messages: {
      phone: '',
    },
    submitHandler: function(form) {
      form.submit();
    },
  });
  $('.offer-form-subscription-widget').validate({
    rules: {
      name: {
        required: true,
      },
      phone: {
        required: true,
        phoneRegex: /^(\+\d{2,4})?\s?(\d{10})$/,
      },
    },
    messages: {
      phone: '',
    },
    submitHandler: function(form) {
      form.submit();
    },
  });
  $('.offer-form-mass-pay-out-widget').validate({
    rules: {
      name: {
        required: true,
      },
      phone: {
        required: true,
        phoneRegex: /^(\+\d{2,4})?\s?(\d{10})$/,
      },
    },
    messages: {
      phone: '',
    },
    submitHandler: function(form) {
      form.submit();
    },
  });
  $('.offer-form-subscription-pricing').validate({
    rules: {
      name: {
        required: true,
      },
      phone: {
        required: true,
        phoneRegex: /^(\+\d{2,4})?\s?(\d{10})$/,
      },
    },
    messages: {
      phone: '',
    },
    submitHandler: function(form) {
      form.submit();
    },
  });
  $('.offer-form').validate({
    rules: {
      name: {
        required: true,
      },
      email: {
        required: true,
        email: true,
      },
      phone: {
        required: true,
        phoneRegex: /^[0-9\-\(\)\s]+$/,
      },
      website: {
        required: true,
      },
    },
    messages: {
      name: '',
      website: '',
      email: '',
      phone: '',
    },
    submitHandler: function(form) {
      form.submit();
    },
  });
  $('#partner-form').validate({
    rules: {
      name: {
        required: true,
      },
      mail: {
        required: true,
        email: true,
      },
      phone: {
        required: true,
        phoneRegex: /^[0-9\-\(\)\s]+$/,
      },
      web: {
        required: true,
      },
    },
    messages: {
      name: '',
      web: '',
      mail: '',
      phone: '',
    },
    submitHandler: function(form) {
      form.submit();
    },
  });
  $('.international-contact__form').validate({
    rules: {
      name: {
        required: true,
      },
      email: {
        required: true,
        email: true,
      },
      phone: {
        required: true,
        phoneRegex: /^[0-9\-\(\)\s]+$/,
      },
      website: {
        required: true,
      },
    },
    messages: {
      name: '',
      website: '',
      email: '',
      phone: '',
    },
    submitHandler: function(form) {
      form.submit();
    },
  });
  $('#contact').validate({
    rules: {
      subject: {
        required: true,
      },
      mail: {
        required: true,
        email: true,
      },
      name: {
        required: true,
      },
      message: {
        required: true,
      },
    },
    messages: {
      subject: '',
      name: '',
      email: '',
      message: '',
    },
    submitHandler: function(form) {
      form.submit();
    },
  });
  dynamicValidation = function(formClass) {
    $form = $('.' + formClass).find('form').first();
    $form.validate({
      rules: {
        name: {
          required: true,
        },
        mail: {
          required: true,
          email: true,
        },
        message: {
          required: true,
        },
      },
      messages: {
        name: '',
        email: '',
        message: '',
      },
      submitHandler: function(form) {
        form.submit();
      },
    });
  };
  $('.campaign-form-inpage').validate({
    rules: {
      name: {
        required: true,
      },
      email: {
        required: true,
        email: true,
      },
      website: {
        required: true,
      },
      campaigns: {
        required: true,
      },
      terms: {
        required: true,
      },
    },
    messages: {
      email: '',
      name: '',
      website: '',
      campaigns: '',
      terms: 'Kullanım şartlarını kabul etmeniz gerekmektedir.',
    },
    submitHandler: function(form) {
      form.submit();
    },
  });
  $('.cep-pos-offer').validate({
    rules: {
      name: {
        required: true,
        nameRegex: /^(?=.{2,150}$).*/,
      },
      email: {
        required: true,
        emailRegex: /^[a-z0-9._%+-]+@.+\..+/,
      },
      phone: {
        required: true,
        phoneRegex: /^\s*(?:\+?(\d{1,3}))?([-. (]*(\d{3})[-. )]*)?((\d{3})[-. ]*(\d{2,4})(?:[-.x ]*(\d+))?)\s*$/gm,
      },
      website: {
        required: true,
      },
      captchaCheck: {
          required: function () {
              return !grecaptcha.getResponse();
          }
      }
    },
    messages: {
      name: '',
      email: '',
      phone: '',
      website: '',
    },
    submitHandler: function (form) {
      if (grecaptcha.getResponse()) {
        form.submit();
      } else {
        grecaptcha.reset();
        grecaptcha.execute();
      }
    },
  });
});


function phoneControl(event)
{
    if(event.keyCode != 8 && event.keyCode != 0 && (event.keyCode < 48 || event.keyCode > 57))
        return false;

    var frm = document.getElementById("NewMember_UyeOl_Form");
    frm.setAttribute("onsubmit", true);
    return true;
}

function isNumeric(event)
{
    if(event.keyCode != 8 && event.keyCode != 0 && (event.keyCode < 48 || event.keyCode > 57))
        return false;
    var frm = document.getElementById("passwordControl");
    frm.setAttribute("onsubmit", true);
    return true;
}

function isEmail()
{
  var txt = $("input.emailVal");
  var func = function() {
      txt.val(txt.val().replace(/\s/g, ''));
  }
  txt.keyup(func).blur(func);
}
