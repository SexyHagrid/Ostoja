$(document).ready(function () {
  var data = {};
  var createResolutionButton = $('#createButton');

  createResolutionButton.on('click', function() {
    createResolution();
  });


  function createResolution() {
    xhttp = new XMLHttpRequest();
    var resolutionID = document.getElementById('resolutionID').value;
    var resolutionText = document.getElementById('resolutionText').value;
    var resolutionImage = document.getElementById('resolutionImage').value;
  
    var request = 'resolutions_add.php?id=' + resolutionID + '&text=' + resolutionText + '&image=' + resolutionImage;
  
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4) {
        if (this.responseText.includes("SUCCESS")) {
          alert('Uchwała została dodana');
          document.location.href = "resolutions.php";
        } else {
          alert('Błąd podczas dodawania uchwały');
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

        // Przekieruj do bazy uchwał jeżeli typ użytkownika różny od admina i redaktora
        if (!isAdminOrEditor()) {
          document.location.href = "resolutions.php";
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