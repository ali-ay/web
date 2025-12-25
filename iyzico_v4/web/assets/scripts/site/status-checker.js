var statusQueue = [];
var hasProblem = 0;
var scrollerInterval = 0;
var mobileLock = false;
var StatusService = function(dataSet, identifier, name) {
  this.dataSet = dataSet;
  this.identifier = identifier;
  this.name = name;
};
StatusService.prototype.initialize = function() {
  if (this.dataSet.status != 'success') {
    console.log('StatusService failed to initialize.');
  } else {
    this.fillStrings();
    this.renderGraph();
  }
};
CreateMarkup = function(name, identifier) {
  var thirtyDaysAgoLocale = $('#thirtyDaysAgo').val();
  var todayLocale = $('#today').val();
  var containerBlock = $('<div id="' + name + '">').addClass('table_container');
  var uptimeInfoBlock = $('<div>').addClass('info');
  var checkIcon = $('<div>')
    .addClass('check')
    .append($('<div class="loading-animation"></div>'));
  var informationBlock = $('<div>')
    .addClass('info-block')
    .append([
      $('<div>').addClass('info_title').html(identifier),
      $('<div>').addClass('info_uptime').html('').css({ textAlign: 'center' }),
    ]);
  var uptimes = $('<div>').addClass('uptimes');
  var arrowPath = $('#arrowPath').val();
  var leftArrow = $(
    '<img src="' + arrowPath + '" class="arrow left-arrow" data-ref="' + name + '"/>'
  );
  var rightArrow = $(
    '<img src="' + arrowPath + '" class="arrow right-arrow" data-ref="' + name + '"/>'
  );
  var uptimesWrapper = $('<div>').addClass('uptimes_wrapper');
  var uptimesContainer = $('<div>')
    .addClass('uptimes_container')
    .append([
      $('<div>').addClass('days_wrapper').append($('<div>').addClass('days_container')),
      $('<div>')
        .addClass('dates')
        .append([
          $('<span>').addClass('left_span').html(thirtyDaysAgoLocale),
          $('<span>').addClass('right_span').html(todayLocale),
        ]),
    ]);

  uptimeInfoBlock.append([checkIcon, informationBlock]);
  uptimes.append([uptimesWrapper.append(uptimesContainer), leftArrow, rightArrow]);
  containerBlock.append([uptimeInfoBlock, uptimes]);

  $('#status-container').append(containerBlock);
};
StatusService.prototype.fillStrings = function() {
  var uptimeLocale = $('#uptime').val();
  var currentStatus = this.dataSet.currentStatus;
  var checkmark = $('#' + this.name).find('.check');
  var lastUpdated = $('#last-updated');
  var infoUptime = $('#' + this.name).find('.info_uptime');
  lastUpdated.html(this.dataSet.lastUpdatedDate);
  if (currentStatus == 'up') {
    checkmark.html('<div class="up"><i class="fa fa-check check-icon"></i></div>');
  } else {
    checkmark.html(
      '<div class="down"><i class="fa fa-exclamation check-icon"></i></div>'
    );
    if (hasProblem == 0) {
      $('.up-title').hide();
      $('.down-title').show();
    }
    hasProblem++;
  }

  infoUptime.html('<strong>%' + this.dataSet.uptime + '</strong> ' + uptimeLocale);
};
StatusService.prototype.calculatePercentage = function(downtime) {
  return parseInt(100 * downtime / (60 * 24));
};
StatusService.prototype.renderGraph = function() {
  var downLocale = $('#down').val();
  var uptimeLocale = $('#uptime').val();
  var data = this.dataSet.data;
  var el = $('#' + this.name).find('.days_container');
  var html = '';
  for (var key in this.dataSet.data) {
    var dateRaw = key.split('-');
    var tooltipHTML = $(
      '<div><div><h3>%100 ' +
        uptimeLocale +
        '</h3><p><span class="degradedInfo" style="display:block;margin-bottom:5px;"></span> <strong>' +
        dateRaw[2] +
        '-' +
        dateRaw[1] +
        '-' +
        dateRaw[0] +
        '</strong></p></div><div>'
    );
    var down = '';
    var degraded = '';
    var heightPercentage = 0;
    if (data[key].down) {
      var downtime = data[key].down.total_minutes;
      heightPercentage = this.calculatePercentage(downtime < 120 ? 120 : downtime);
      down = '<div style="height:' + heightPercentage + '%" class="down"></div>';
      tooltipHTML = $(
        '<div><div><h3>' +
          downLocale +
          '</h3><p><strong>' +
          dateRaw[2] +
          '-' +
          dateRaw[1] +
          '-' +
          dateRaw[0] +
          '</strong> tarihinde <strong>' +
          downtime +
          ' dakika kesinti<span class="degradedInfo"></span> yaşanmıştır.</strong></p></div><div>'
      );
    }

    if (data[key].degraded) {
      var degradedTime = data[key].degraded.total_minutes;
      var heightPercentageDegraded = this.calculatePercentage(
        degradedTime < 120 ? 120 : degradedTime
      );
      var className = 'degraded';
      var dagradedStarter = '';
      if (heightPercentage) {
        className = 'degraded hasDown';
        dagradedStarter = ',';
      }

      degraded =
        '<div style="height:' +
        heightPercentageDegraded +
        '%;bottom:' +
        heightPercentage +
        '%" class="' +
        className +
        '"></div>';

      var degradedInfo = tooltipHTML.find('.degradedInfo');
      degradedInfo.html(
        dagradedStarter +
          ' <strong>' +
          degradedTime +
          ' dakika kısmi yavaşlama </strong>' +
          (heightPercentage ? '' : 'yaşanmıştır')
      );
    }

    html +=
      '<div class="day qtipit qtip-tipsy">' +
      down +
      degraded +
      '</div ><div class="tooltiptext">' +
      tooltipHTML.html() +
      '</div>';
  }
  el.html(html);
};

StatusFactory = function(queue) {
  this.queue = queue.slice(0);
};
StatusFactory.prototype.getStatusLog = function(ruleName, elementName, identifier) {
  var theFactory = this;
  var url = '/destek/servis-ay/' + ruleName;
  var data = {};
  data = $.param(data);

  $.post(url, data, function(response) {
    var responseObject = response.data;
    if (responseObject.status == 'success') {
      var service = new StatusService(responseObject, elementName, identifier);
      service.initialize();
      window.setTimeout(function() {
        $('#' + identifier).addClass('animate-opacity');
      }, 100);
      theFactory.processQueue();
    }
  });
};
StatusFactory.prototype.processQueue = function() {
  if (this.queue.length > 0) {
    var currentRule = this.queue.shift();
    CreateMarkup(currentRule.id, currentRule.name);
    this.getStatusLog(currentRule.ruleName, currentRule.name, currentRule.id);
  } else {
    $('.qtipit').each(function() {
      $(this).qtip({
        content: {
          text: $(this).next('.tooltiptext'),
        },
        position: {
          at: 'left center',
          my: 'right center',
        },
      });
    });
    $(window).resize(function() {
      scrollConfig();
    });
    scrollConfig();

    $('.arrow').click(function() {
      ref = $(this).data('ref');
      element = $('#' + ref).find('.uptimes_wrapper');
      var viewWidth = $(this).width();
      var contentWidth = $(this).find('.days_container').width();
      if ($(this).hasClass('left-arrow')) {
        element.scrollLeft(element.scrollLeft() - 100);
      } else {
        element.scrollLeft(element.scrollLeft() + 100);
      }
    });
  }
};

statusQueue = [
  {
    name: 'Ortak Ödeme Sayfası',
    id: 'cpp',
    ruleName: 'CPP',
  },
  {
    name: 'Üye İşyeri Paneli',
    id: 'merchant',
    ruleName: 'merchant',
  },
  {
    name: 'Checkout Form',
    id: 'checkout',
    ruleName: 'Checkoutform.js',
  },
  {
    name: 'API',
    id: 'api',
    ruleName: 'API',
  },
  {
    name: 'iyzico.com',
    id: 'iyzico',
    ruleName: 'iyzico.com',
  },
];

var scrollConfig = function() {
  if ($(document).width() <= 768) {
    $('.uptimes_wrapper').each(function() {
      var viewWidth = $(this).width();
      var contentWidth = $(this).find('.days_container').width();
      $('.uptimes_wrapper').scrollLeft(contentWidth - viewWidth);
    });
  }
};
var factory = new StatusFactory(statusQueue);
$(document).ready(function() {
  if ($('body').hasClass('serverStatus')) {
    factory.processQueue();
  }
});
