$(document).ready(function () {
  let interval = 15;
  var id = setInterval(frame, interval);
  function frame() {
    if (width <= 0) {
      clearInterval(id);
    } else {
      var width = $("#notifypopup-progress-bar").width() - 1;
      $("#notifypopup-progress-bar").css("width", width+"px");
    }
  }

  setTimeout(function() {
    $("#notifypopup").css("visibility", "hidden");
  }, $("#notifypopup-progress-bar").width()*interval);
});