$(document).ready(function () {
  $('#close-popup').on('click', function() {
    $(this).parent().css('visibility', 'hidden');
  })
});