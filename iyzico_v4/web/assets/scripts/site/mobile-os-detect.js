function getMobileOperatingSystem() {
  var userAgent = navigator.userAgent || navigator.vendor || window.opera;

  // Windows Phone must come first because its UA also contains "Android"
  if (/windows phone/i.test(userAgent)) {
    return 'Windows Phone';
  }

  if (/android/i.test(userAgent)) {
    return 'Android';
  }

  // iOS detection from: http://stackoverflow.com/a/9039885/177710
  if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
    return 'iOS';
  }

  return 'unknown';
}

$(document).ready(function() {
  if ($('.downloadApp').length > 0) {
    var operatingSystem = getMobileOperatingSystem();

    var isMerchant = $('.downloadApp').hasClass('merchant');
    if (isMerchant) {
      var url = 'https://itunes.apple.com/tr/app/iyzico/id1084768192?l=tr&mt=8';
    } else {
      var url = 'https://itunes.apple.com/us/app/iyzico/id1436467445?ls=1&mt=8';
    }
    switch (operatingSystem) {
      case 'Android':
        if (isMerchant) {
          url =
            'https://play.google.com/store/apps/details?id=iyzico.merchant.payment&hl=en';
        } else {
          url = 'https://play.google.com/store/apps/details?id=com.iyzico.assistant';
        }
        break;
      case 'iOS':
        if (isMerchant) {
          url = 'https://itunes.apple.com/tr/app/iyzico/id1084768192?l=tr&mt=8';
        } else {
          url = 'https://itunes.apple.com/us/app/iyzico/id1436467445?ls=1&mt=8';
        }
        break;
    }
    $('.downloadApp').attr('href', url);
  }
});
