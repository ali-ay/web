function hasConsecutiveNumbers(val, consecutiveThreshold) {
  function _toConsumableArray(arr) {
    return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr);
  }
  function _unsupportedIterableToArray(o, minLen) {
    if (!o) return;
    if (typeof o === 'string') return _arrayLikeToArray(o, minLen);
    var n = Object.prototype.toString.call(o).slice(8, -1);
    if (n === 'Object' && o.constructor) n = o.constructor.name;
    if (n === 'Map' || n === 'Set') return Array.from(o);
    if (n === 'Arguments' || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n))
      return _arrayLikeToArray(o, minLen);
  }
  function _iterableToArray(iter) {
    if (typeof Symbol !== 'undefined' && Symbol.iterator in Object(iter)) return Array.from(iter);
  }
  function _arrayWithoutHoles(arr) {
    if (Array.isArray(arr)) return _arrayLikeToArray(arr);
  }
  function _arrayLikeToArray(arr, len) {
    if (len == null || len > arr.length) len = arr.length;
    for (var i = 0, arr2 = new Array(len); i < len; i++) {
      arr2[i] = arr[i];
    }
    return arr2;
  }
  var valueChars = val.split('').map(Number);
  var consecutiveAdjacents = _toConsumableArray(Array(consecutiveThreshold).keys()).map(function(
    i
  ) {
    return i + 1;
  });
  return valueChars.slice(0, valueChars.length - consecutiveThreshold).some(function(value, index) {
    var isDecremental = value - 1 === valueChars[index + 1];
    function functionToCheck(value, adjacentIndex) {
      if (isDecremental) {
        return value - adjacentIndex;
      }
      return value + adjacentIndex;
    }
    return consecutiveAdjacents.every(function(adjacentIndex) {
      var nextValue = valueChars[index + adjacentIndex];
      var nextConsecutiveValue = functionToCheck(value, adjacentIndex);
      return !(nextValue == null) && nextConsecutiveValue === nextValue;
    });
  });
}


function hasUniqueNumbers(val, uniqueNumberAmount) {
  function _toConsumableArray(arr) {
    return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr);
  }
  function _unsupportedIterableToArray(o, minLen) {
    if (!o) return;
    if (typeof o === 'string') return _arrayLikeToArray(o, minLen);
    var n = Object.prototype.toString.call(o).slice(8, -1);
    if (n === 'Object' && o.constructor) n = o.constructor.name;
    if (n === 'Map' || n === 'Set') return Array.from(o);
    if (n === 'Arguments' || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n))
      return _arrayLikeToArray(o, minLen);
  }
  function _iterableToArray(iter) {
    if (typeof Symbol !== 'undefined' && Symbol.iterator in Object(iter)) return Array.from(iter);
  }
  function _arrayWithoutHoles(arr) {
    if (Array.isArray(arr)) return _arrayLikeToArray(arr);
  }
  function _arrayLikeToArray(arr, len) {
    if (len == null || len > arr.length) len = arr.length;
    for (var i = 0, arr2 = new Array(len); i < len; i++) {
      arr2[i] = arr[i];
    }
    return arr2;
  }
  return _toConsumableArray(new Set(val.split(''))).length >= uniqueNumberAmount;
}

function passEyes() {

  var x = document.getElementById("myDIV");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

$('.pass-eye').click(function() {
  $('.pass-eye').toggleClass('eyeToogle');
  $('.pass-eye').each(function() {
    if ($(this).hasClass('eyeToogle')) {
      $('#password').attr('type', 'text');
    }else{
      $('#password').attr('type', 'password');
    }
  });
});
