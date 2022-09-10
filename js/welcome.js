$(document).ready(function () {
  var imgLogin = $('#img-login');
  var imgRenting = $('#img-renting');

  imgLogin.on('click', function() {
    document.location.href = "zaloguj";
  });

  imgRenting.on('click', function() {
    document.location.href = "wynajem-kategorie";
  });
});