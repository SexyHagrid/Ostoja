$(document).ready(function () {
  var data = {};
  var addNewsButton = $('#createButton');
  addNewsButton.on('click', function() {
    createNews();
  });

  function createNews() {
    xhttp = new XMLHttpRequest();
    var resolutionID = document.getElementById('resolutionID').value;
    var resolutionText = document.getElementById('resolutionText').value;
    var resolutionImage = document.getElementById('resolutionImage').value;

    var request = 'news_add.php?id=' + resolutionID + '&text=' + resolutionText + '&image=' + resolutionImage;

    xhttp.onreadystatechange = function() {
      if (this.readyState == 4) {
        if (this.responseText.includes("SUCCESS")) {
          alert('Aktualnosc została dodana');
          document.location.href = "news.php";
        } else {
          alert('Błąd podczas dodawania aktualnosci');
        }
      }
    }

    xhttp.open('GET', request, true);
    xhttp.send();
  }

  function isAdminOrEditor() {
    return data.userRole == 1 || data.userRole == 2;
  }

  function getSessionID() {
    return localStorage.getItem('sessionID');
  }
});