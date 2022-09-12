$(document).ready(function () {
  var data = {};

  var addNewResolutionButton = $('#addNewResolutionButton');
  addNewResolutionButton.on('click', function() {
    addResolution();
  });

  loadData();

  function loadData() {

    var tbody = document.getElementById("resolutionContent");
    var template = document.querySelector('#resolutionTemplate');

    for (var i = 0; i < resolutionsList.length; i++) {
      var resolutionID = resolutionsList[i].id;
      var resolutionText = resolutionsList[i].text;
      var resolutionAuthor = resolutionsList[i].author;
      var resolutionFiles = resolutionsList[i].filesList;

      var clone = template.content.cloneNode(true);
      var h3 = clone.querySelectorAll('h3');
      var h2 = clone.querySelectorAll('h2');
      var filesDiv = clone.querySelector('#files');
      var button = clone.querySelectorAll('button');

      h3[0].textContent = "Uchwała nr. " + resolutionID;
      h2[0].textContent = resolutionText;

      var directory = "assets/uchwalyPliki/" + resolutionID + "/";
      for (var j = 0; j < resolutionFiles.length; j++) {
        var name = resolutionFiles[j];
        var a = document.createElement('a');
        a.href = directory + name;
        a.download = name;
        a.innerHTML = name;

        filesDiv.appendChild(a);
        filesDiv.appendChild(document.createElement('div'));
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

      tbody.appendChild(clone);

    } 
  }

  function hasEditDeletePermission() {
    return hasEditDeletePermission;
  }

  function isUserTheAuthor(author) {
    return parseInt(author) == userId;
  }

  function addResolution() {
    document.location.href = "uchwały-dodaj";
  }

  function editResolution(uchwalaID) {
    document.location.href = "uchwały-edytuj?id=" + uchwalaID;
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