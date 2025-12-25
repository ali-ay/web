ajaxHandler = function(url, data, successHandler, errorHandler) {
  $.ajax({
    url: url,
    data: data,
    type: 'POST',
    beforeSend: function(xhr) {
      xhr.setRequestHeader('Accept', 'application/json');
      xhr.setRequestHeader('Content-Type', 'application/json');
    },
    success: successHandler,
    error: errorHandler,
  });
};
ajaxHandlerWithUpload = function(url, data, successHandler, errorHandler) {
  $.ajax({
    url: url,
    data: data,
    type: 'POST',
    contentType: false,
    processData: false,
    cache: false,
    enctype: 'multipart/form-data',
    beforeSend: function(xhr) {
      xhr.setRequestHeader('Accept', 'application/json');
      xhr.setRequestHeader('Content-Type', 'application/json');
    },
    success: successHandler,
    error: errorHandler,
  });
};
