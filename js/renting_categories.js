$(document).ready(function () {
  var data = {};

  onStart();

  function onStart() {
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var result = this.responseText.split('|');
        data.userID = parseInt(result[0]);
        data.userRole = parseInt(result[1]);

        if (!isNaN(data.userID) && data.userID != "") {
          showAddOfferButton();
        }
      }
    }
    xhttp.open('GET', 'user.php?sessionID=' + getSessionID(), true);
    xhttp.send();
  }

  function showAddOfferButton() {
    var addOfferButtonElement = document.getElementById('addOfferButtonElement');
    addOfferButtonElement.style.display = 'block';
  }

  function getSessionID() {
    return localStorage.getItem('sessionID');
  }
});
