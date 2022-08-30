$(document).ready(function () {
  var data = {};
  var editButton = $('#updateButton');
  editButton.on('click', function() {
    editResolution();
  });

  onStart();

  function onStart() {

    if (!isUserTheAdmin() && !isUserTheAuthor(resolution.author)) {
      document.location.href = "resolutions.php";
    } else {
      document.getElementById('resolutionID').innerHTML = resolution.id;
      document.getElementById('resolutionText').value = resolution.text;
      document.getElementById('resolutionImage').value = resolution.image;
    }
  }

  function editResolution() {
    xhttp = new XMLHttpRequest();
    var resolutionID = resolution.id;
    var resolutionText = document.getElementById('resolutionText').value;
    var resolutionImage = document.getElementById('resolutionImage').value;
    var resolutionAuthor = resolution.author;
    var request = 'resolutions_edit.php?id=' + resolutionID + '&text=' + resolutionText + '&image=' + resolutionImage + '&author=' + resolutionAuthor;

    xhttp.onreadystatechange = function() {
      if (this.readyState == 4) {
        if (this.responseText.includes("SUCCESS")) {
          alert('Edycja przebiegła poprawnie');
          document.location.href = "resolutions.php";
        } else {
          alert('Błąd podczas edycji uchwały');
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

  function isUserTheAdmin() {
    return true;
  }

  function isUserTheAuthor(author) {
    return true;
  }
});