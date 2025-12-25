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
