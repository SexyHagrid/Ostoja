$(document).ready(function () {
  let interval = 30;
  var id = setInterval(frame, interval);
  function frame() {
    if (width <= 0) {
      clearInterval(id);
    } else {
      var width = $("#alertpopup-progress-bar").width() - 1;
      $("#alertpopup-progress-bar").css("width", width+"px");
    }
  }

  setTimeout(function() {
    $("#alertpopup").css("visibility", "hidden");
  }, $("#alertpopup-progress-bar").width()*interval);
});