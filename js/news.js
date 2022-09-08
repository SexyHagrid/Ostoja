$(document).ready(function () {
  var data = {};

  var addNewNewsButton = $('#addNewNewsButton');
  addNewNewsButton.on('click', function() {
    addNews();
  });

  onStart();

  function onStart() {
    loadData();
    showEditorMenu();
  }

  function loadData() {
    var tbody = document.getElementById("newsContent");
    var template = document.querySelector('#newsTemplate');

    for (var i = 0; i < resultArray.length; i++) {
      var resolutionID = resultArray[i].id;
      var resolutionText = resultArray[i].text;
      var resolutionImage = resultArray[i].image;
      var resolutionAuthor = resultArray[i].author;

      var clone = template.content.cloneNode(true);
      var h3 = clone.querySelectorAll('h3');
      var label = clone.querySelectorAll('label');
      var button = clone.querySelectorAll('button');

      h3[0].textContent = "Aktualność nr. " + resolutionID;
      label[0].textContent = resolutionText;

      if (resolutionImage != ' ') {
        var image = clone.querySelectorAll('img');
        image[0].src = resolutionImage;
      }

      if (hasEditDeletePermission() || isUserTheAuthor(resolutionAuthor)) {
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

  function showEditorMenu() {
    if (data.userRole == 1 || data.userRole == 2) {
      var editorMenu = document.getElementById("editorMenu");
      editorMenu.style.display = "block";
    }
  }

  function hasEditDeletePermission() {
    return hasEditDeletePermission;
  }

  function isUserTheAuthor(author) {
    return parseInt(author) == userId;
  }

  function addNews() {
    document.location.href = "news_add.php";
  }

  function editResolution(uchwalaID) {
    document.location.href = "news_edit.php?id=" + uchwalaID;
  }

  function deleteResolution(resolutionID) {
    var answer = window.confirm("Czy na pewno chcesz usunąć aktualnosc?");
    if (answer) {
      xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4) {
          if (this.responseText.includes("SUCCESS")) {
            alert('Aktualność została usunięta');
            window.location.reload(true);
          } else {
            alert('Błąd podczas usuwania aktualności');
          }
        }
      }
      xhttp.open('GET', 'news_delete.php?id=' + resolutionID, true);
      xhttp.send();
    }
  }
});