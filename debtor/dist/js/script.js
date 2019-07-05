$(document).on('pagebeforecreate', '[data-role="page"]', function() {
  loading('show', 1);
});
 
$(document).on('pageshow', '[data-role="page"]', function() {
  loading('hide', 1000);
});
 
function loading(showOrHide, delay) {
  setTimeout(function() {
    $.mobile.loading(showOrHide);
  }, delay);
}