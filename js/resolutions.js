$(document).ready(function () {
  var data = {};

  loadData();

  function loadData() {

    var tbody = document.getElementById("resolutionContent");
    var template = document.querySelector('#resolutionTemplate');

    for (var i = 0; i < resolutionsList.length; i++) {
      var resolutionID = resolutionsList[i].id;
      var resolutionText = resolutionsList[i].text;
      var resolutionImage = resolutionsList[i].image;
      var resolutionAuthor = resolutionsList[i].author;

      var clone = template.content.cloneNode(true);
      var h3 = clone.querySelectorAll('h3');
      var label = clone.querySelectorAll('label');
      var button = clone.querySelectorAll('button');

      h3[0].textContent = "Uchwała nr. " + resolutionID;
      label[0].textContent = resolutionText;

      if (resolutionImage != null) {
        var image = clone.querySelectorAll('img');
        image[0].src = resolutionImage;
      }

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

      tbody.appendChild(clone);

    } 
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
          if (this.responseText.includes("SUCCESS")) {
            alert('Uchwała została usunięta');
            window.location.reload(true);
          } else {
            alert('Błąd podczas usuwania uchwały');
          }
        }
      }
      xhttp.open('GET', 'resolutions_delete.php?id=' + resolutionID, true);
      xhttp.send();
    }
  }

  function getSessionID() {
    return localStorage.getItem('sessionID');
  }
});