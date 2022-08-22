$(document).ready(function () {
  var data = {};

  function createResolution() {
    xhttp = new XMLHttpRequest();
    var resolutionID = document.getElementById('resolutionID').value;
    var resolutionText = document.getElementById('resolutionText').value;
    var resolutionImage = document.getElementById('resolutionImage').value;
    var resolutionAuthor = data.userID;

    var request = 'news_add.php?id=' + resolutionID + '&text=' + resolutionText + '&image=' + resolutionImage + '&author=' + resolutionAuthor;

    xhttp.onreadystatechange = function() {
      if (this.readyState == 4) {
        if (this.responseText == "SUCCESS") {
          alert('Aktualnosc została dodana');
          document.location.href = "news.html";
        } else {
          alert('Błąd podczas dodawania aktualnosci');
        }
      }
    }

    xhttp.open('GET', request, true);
    xhttp.send();
  }

  function getUserRole() {
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var result = this.responseText.split('|');
        data.userID = parseInt(result[0]);
        data.userRole = parseInt(result[1]);

        // Przekieruj do bazy aktualnosci jeżeli typ użytkownika różny od admina i redaktora
        if (!isAdminOrEditor()) {
          document.location.href = "news.html";
        }
      }
    }

    xhttp.open('GET', 'user.php?sessionID=' + getSessionID(), true);
    xhttp.send();
  }

  function isAdminOrEditor() {
    return data.userRole == 1 || data.userRole == 2;
  }

  function getSessionID() {
    return localStorage.getItem('sessionID');
  }
});