$(document).ready(function () {
  var data = {};

  onStart();

  function onStart() {
    // Pobieramy z bazy danych id i rolę użytkownika
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var result = this.responseText.split('|');
        data.userID = parseInt(result[0]);
        data.userRole = parseInt(result[1]);

        loadData();
        showEditorMenu();
      }
    }
    var sessionID = getSessionID();
    xhttp.open('GET', 'user.php?sessionID=' + getSessionID(), true);
    xhttp.send();
  }

  // Pobieramy uchwały z bazy danych i je wyświetlamy
  function loadData() {
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var tbody = document.getElementById("resolutionContent");
        var template = document.querySelector('#resolutionTemplate');

        var resolutionsResponse = this.responseText.split('||');
        for (var i = 0; i < resolutionsResponse.length; i++) {
          var resolution = resolutionsResponse[i].split('|');
          var resolutionID = resolution[0];
          var resolutionText = resolution[1];
          var resolutionImage = resolution[2];
          var resolutionAuthor = resolution[3];

          //Sprawdzamy, czy uchwała istnieje (php zwraca nam jedną pustą za dużo)
          if (resolutionID == '') {
            break;
          }

          // Tworzymy uchwałę: numer uchwały, treść oraz obrazek (jeżeli jest)
          var clone = template.content.cloneNode(true);
          var h3 = clone.querySelectorAll('h3');
          var label = clone.querySelectorAll('label');
          var button = clone.querySelectorAll('button');

          h3[0].textContent = "Uchwała nr. " + resolutionID;
          label[0].textContent = resolutionText;

          // Tworzymy obrazek (jeżeli jest)
          if (resolutionImage != ' ') {
            var image = clone.querySelectorAll('img');
            image[0].src = resolutionImage;
          }

          // Sprawdzamy czy użytkownik jest adminem/autorem uchwały
          // Jeżeli tak -> wyświetlamy przyciski do edycji i usunięcia
          if (isUserTheAdmin() || isUserTheAuthor(resolutionAuthor)) {
            button[0].setAttribute('data-id', resolutionID);
            button[0].onclick = function(event) {
              editResolution(event.target.getAttribute('data-id'));
            }
            button[0].style.display = "block";

            button[1].setAttribute('data-id', resolutionID);
            button[1].onclick = function(event) {
              deleteResolution(event.target.getAttribute('data-id'));
            }
            button[1].style.display = "block";
          }

          tbody.appendChild(clone)
        }
      }
    }
    xhttp.open('GET', 'baza_uchwal.php', true);
    xhttp.send();
  }

  function showEditorMenu() {
    if (data.userRole == 1 || data.userRole == 2) {
      var editorMenu = document.getElementById("editorMenu");
      editorMenu.style.display = "block";
    }
  }

  function isUserTheAdmin() {
    return data.userRole == 1;
  }

  function isUserTheAuthor(author) {
    return parseInt(author) == data.userID;
  }

  function addResolution() {
    document.location.href = "Baza_uchwal_dodaj.html";
  }

  function editResolution(uchwalaID) {
    document.location.href = "Baza_uchwal_edytuj.html?id=" + uchwalaID;
  }

  function deleteResolution(resolutionID) {
    var answer = window.confirm("Czy na pewno chcesz usunąć uchwałę?");
    if (answer) {
      xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4) {
          if (this.responseText == "SUCCESS") {
            alert('Uchwała została usunięta');
            window.location.reload(true);
          } else {
            alert('Błąd podczas usuwania uchwały');
          }
        }
      }
      xhttp.open('GET', 'baza_uchwal_usun.php?id=' + resolutionID, true);
      xhttp.send();
    }
  }

  function getSessionID() {
    return localStorage.getItem('sessionID');
  }
});