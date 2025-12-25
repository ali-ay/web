$(document).ready(function() {
  $('#join-us-submit').click(function(e) {
    e.preventDefault();
    $('#fake-file').removeClass('error');
    if ($('#file').val() == '') {
      $('#fake-file').addClass('error');
      return false;
    }
    $('#join-us-form').submit();
  });
  $('#join-us-form').validate({
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
      },
    },
    messages: {
      name: '',
      mail: '',
      phone: '',
    },
    submitHandler: function(form) {
      form.submit();
    },
  });
});
