$(document).ready(function() {
  $('.dropdown-item').click(function(e) {
    e.preventDefault();
    $(this).parent().parent().find('.dropdown-toggle').html($(this).html());
    $(this).parent().parent().parent().removeClass('error');
    $('#subject').val($(this).data('value'));
  });
  $('#contact-submit').click(function(e) {
    e.preventDefault();
    $('.dropdownMenu').removeClass('error');
    if ($('#subject').val() == '') {
      $('.dropdownMenu').addClass('error');
      return false;
    }
    $('#contact').submit();
  });
  $('#contact').validate({
    rules: {
      email: {
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
      name: '',
      email: '',
      message: '',
    },
    submitHandler: function(form) {
      form.submit();
    },
  });
});
