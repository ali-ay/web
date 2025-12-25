var buyerProtectionSites = {
  memory: {
    endPoint: 'https://iyziup.iyzipay.com/v1/iyziup/protected-shops',
    count: 45,
    currentPage: 1,
    totalCount: false,
    loading: false,
    currentCategory: 'all',
  },
  generateItem: function(merchantName, merchantUrl, imageSource) {
    if(!merchantUrl.includes('https://') && !merchantUrl.includes('http://') ){
        merchantUrl = 'http://' + merchantUrl;
      }

    var card = $('<div style="padding:30px;">').addClass('personalReferencessCard');

    if (imageSource) {
      var image = $(
        '<img style="max-width:100%;max-height:60px" src="' + imageSource + '" />'
      );
    } else {
      var image = $(
        '<img style="height:60px" src="/assets/images/content/no-logo.png" />'
      );
    }

    card.append(image);

    var merchantName = $(
      '<a href="' +
        merchantUrl +
        '" target="_blank" rel="nofollow"><p>' +
        merchantName +
        '</p></a>'
    );
    card.append([image, merchantName]);
    return card;
  },
  fetchItems: function(category, page) {
    buyerProtectionSites.memory.loading = true;
    buyerProtectionSites.memory.currentCategory = category;
    var url = buyerProtectionSites.memory.endPoint;
    var parameters = {
      count: buyerProtectionSites.memory.count,
      page: 1,
    };
    if (category && category != 'all') {
      parameters['categoryCode'] = category;
    }
    if (page) {
      parameters['page'] = page;
    }
    $.ajax({
      url: url,
      data: parameters,
      success: function(response) {
        if (response.status == 'success') {
          buyerProtectionSites.memory.totalCount = response.totalCount;
          var fromScratch = parameters.page === 1;
          buyerProtectionSites.fillSection(fromScratch, response.protectedShops);
        }
      },
      dataType: 'json',
    });
  },
  fillSection: function(fromScratch, protectedShops) {
    if (fromScratch) {
      $('.personalReferencessContent').html('');
    }
    if (protectedShops) {
      protectedShops.map(function(shop) {
        $('.personalReferencessContent').append(
          buyerProtectionSites.generateItem(shop.merchantName, shop.webSite, shop.logoUrl)
        );
      });
    }
    buyerProtectionSites.memory.loading = false;
  },
};

$('document').ready(function() {
  if ($('body').hasClass('contractedSites')) {
    buyerProtectionSites.fetchItems('all');
    $('.sites-category-filter').click(function(e) {
      e.preventDefault();
      $('.sites-category-filter').removeClass('selected');
      $(this).addClass('selected');
      buyerProtectionSites.fetchItems($(this).data('category-id'));
    });
    $(window).scroll(function() {
      if ($(window).scrollTop() == $(document).height() - $(window).height()) {
        if (buyerProtectionSites.memory.loading != true) {
          if (
            buyerProtectionSites.memory.totalCount >
            buyerProtectionSites.memory.currentPage * buyerProtectionSites.memory.count
          ) {
            buyerProtectionSites.memory.currentPage =
              buyerProtectionSites.memory.currentPage + 1;
            buyerProtectionSites.fetchItems(
              buyerProtectionSites.memory.currentCategory,
              buyerProtectionSites.memory.currentPage
            );
          }
        }
      }
    });
  }
});

$('document').ready(function() {
  if ($('body').hasClass('supportPageHeader')) {
    buyerProtectionSites.fetchItems('all');
    $('.sites-category-filter').click(function(e) {
      e.preventDefault();
      $('.sites-category-filter').removeClass('selected');
      $(this).addClass('selected');
      buyerProtectionSites.fetchItems($(this).data('category-id'));
      window.location="#"+$(this).data('category-id');
    });
  }
});
