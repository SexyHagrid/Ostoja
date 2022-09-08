$(document).ready(function () {
  var imgLogin = $('#img-login');
  var imgRenting = $('#img-renting');

  imgLogin.on('click', function() {
    document.location.href = "login.php";
  });

  imgRenting.on('click', function() {
    document.location.href = "renting_categories.php";
  });
});