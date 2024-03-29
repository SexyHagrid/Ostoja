$(document).ready(function () {
  var data = {};
  var editButton = $('#updateButton');
  editButton.on('click', function() {
    editNews();
  });

  getNews();

  function editNews() {
    xhttp = new XMLHttpRequest();
    var resolutionID = result.id;
    var resolutionText = document.getElementById('resolutionText').value;
    var resolutionImage = document.getElementById('resolutionImage').value;
    var resolutionAuthor = result.author;
    var request = 'news_edit.php?id=' + resolutionID + '&text=' + resolutionText + '&image=' + resolutionImage + '&author=' + resolutionAuthor;

    xhttp.onreadystatechange = function() {
      if (this.readyState == 4) {
        if (this.responseText.includes("SUCCESS")) {
          alert('Edycja przebiegła poprawnie');
          document.location.href = "news.php";
        } else {
          alert('Błąd podczas edycji aktualności');
        }
      }
    }

    xhttp.open('GET', request, true);
    xhttp.send();
  }

  function getNews() {
    var resolutionText = result.text;
    var resolutionImage = result.image;
    var resolutionAuthor = result.author;

    // Sprawdzamy czy użytkownik jest adminem lub autorem aktualnosci
    // Jeżeli nie -> wracamy do listy aktualnosci
    if (!hasEditDeletePermission() && !isUserTheAuthor(result.author)) {
      document.location.href = "news.php";
    } else {
      document.getElementById('resolutionID').innerHTML = result.id;
      document.getElementById('resolutionText').value = resolutionText;
      document.getElementById('resolutionImage').value = resolutionImage;
    }
  }

  function hasEditDeletePermission() {
    return hasEditDeletePermission;
  }

  function isUserTheAuthor(author) {
    return author == userId;
  }
});