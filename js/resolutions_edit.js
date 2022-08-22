$(document).ready(function () {
  var data = {};

  function editResolution() {
    xhttp = new XMLHttpRequest();
    var resolutionID = data.resolutionID;
    var resolutionText = document.getElementById('resolutionText').value;
    var resolutionImage = document.getElementById('resolutionImage').value;
    var resolutionAuthor = data.resolutionAuthor;
    var request = 'baza_uchwal_edytuj.php?id=' + resolutionID + '&text=' + resolutionText + '&image=' + resolutionImage + '&author=' + resolutionAuthor;

    // alert("AAAAAAA " + request + " AAAAAAAAA");

    xhttp.onreadystatechange = function() {
      if (this.readyState == 4) {
        if (this.responseText == "SUCCESS") {
          alert('Edycja przebiegła poprawnie');
          document.location.href = "Baza_uchwal.html";
        } else {
          alert('Błąd podczas edycji uchwały');
        }
      }
    }

    xhttp.open('GET', request, true);
    xhttp.send();
  }

  //Pobieramy dane o użytkowniku
  function getUserRole() {
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var result = this.responseText.split('|');

        data.userID = parseInt(result[0]);
        data.userRole = parseInt(result[1]);

        // Przekieruj do bazy uchwał jeżeli typ użytkownika różny od admina i redaktora
        if (!isAdminOrEditor()) {
          document.location.href = "Baza_uchwal.html";
        } else {
          var urlParams = new URLSearchParams(window.location.search);
          data.resolutionID = urlParams.get('id');

          getResolution();
        }
      }
    }

    xhttp.open('GET', 'user.php?sessionID=' + getSessionID(), true);
    xhttp.send();
  }

  function getResolution() {
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var result = this.responseText.split('|');

        var resolutionText = result[1];
        var resolutionImage = result[2];
        var resolutionAuthor = result[3];

        data.resolutionAuthor = resolutionAuthor;

        // Sprawdzamy czy użytkownik jest adminem lub autorem uchwały
        // Jeżeli nie -> wracamy do listy uchwał
        if (!isUserTheAdmin() && !isUserTheAuthor(resolutionAuthor)) {
          document.location.href = "Baza_uchwal.html";
        } else {
          document.getElementById('resolutionID').innerHTML = data.resolutionID;
          document.getElementById('resolutionText').value = resolutionText;
          document.getElementById('resolutionImage').value = resolutionImage;
        }
      }
    }
    xhttp.open('GET', 'baza_uchwal_edytuj.php?id=' + data.resolutionID, true);
    xhttp.send();
  }

  function isAdminOrEditor() {
    return data.userRole == 1 || data.userRole == 2;
  }

  function getSessionID() {
    return localStorage.getItem('sessionID');
  }

  function isUserTheAdmin() {
    return data.userRole == 1;
  }

  function isUserTheAuthor(author) {
    return parseInt(author) == data.userID;
  }
});