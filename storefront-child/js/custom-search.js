jQuery(document).ready(function ($) {
  $('#ajax-product-search').on('keyup', function () {
    var searchTerm = $(this).val();

    $.ajax({
      url: ajax_object.ajax_url,
      type: 'POST',
      data: {
        action: 'ajax_product_search',
        term: searchTerm
      },
      success: function (response) {
        $('#product-search-results').html(response);
      }
    });
  });
});
