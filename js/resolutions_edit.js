$(document).ready(function () {
  var editButton = $('#updateButton');
  editButton.on('click', function() {
    validateData();
  });

  onStart();

  function onStart() {
    if (!hasEditDeletePermission() && !isUserTheAuthor(resolution.author)) {
      document.location.href = "resolutions.php";
    } else {
      document.getElementById('resolutionID').innerHTML = resolution.id;
      document.getElementById('resolutionText').value = resolution.text;
      if (resolution.files.length > 0) {
        var existingFilesDiv = document.getElementById('existingFilesList');
        existingFilesDiv.style.display = 'block';

        for (var i = 0; i < resolution.files.length; i++) {
          existingFilesDiv.appendChild(createExistingFileElement(resolution.id, resolution.files[i]));
        }
        existingFilesDiv.append(document.createElement('br'));
      }
      
    }
  }

  function validateData() {
    var resolutionID = document.getElementById('resolutionID').innerHTML;
    var resolutionText = document.getElementById('resolutionText').value;

    if (resolutionID.replace(" ", "") == "") {
      alert("Numer uchwały nie może być pusty");
      return;
    }

    if (resolutionText.replace(" ", "") == "") {
      alert("Tytuł uchwały nie może być pusty");
      return;
    }

    handleFilesUpload();
  }

  function handleFilesUpload() {
    var resolutionFiles = document.getElementById('uploadFilesInput');
    const formData = new FormData();

    for (var i = 0; i < resolutionFiles.files.length; i++) {
      formData.append('files[]', resolutionFiles.files[i]);
    }

    var directory = "assets/uchwalyPliki/" + resolution.id + "/";

    fetch('resolutions_edit.php?action=1&directory=' + directory, {
      method: 'POST',
      body: formData
    })
    .then((response) => {
      response.text().then(text => {
        var responseList = text.split('|');
        responseList.pop();

        editResolution(responseList);
      })
    })
  }

  function editResolution(filesList) {
    xhttp = new XMLHttpRequest();
    var resolutionID = resolution.id;
    var resolutionText = document.getElementById('resolutionText').value;
  
    var request = 'resolutions_edit.php?action=2&id=' + resolutionID + '&text=' + resolutionText;
  
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4) {
        if (this.responseText.includes("SUCCESS")) {
          sendFilesToDatabase(resolutionID ,filesList);
        } else {
          alert('Błąd podczas edytowania uchwały');
        }
      }
    }
  
    xhttp.open('GET', request, true);
    xhttp.send();
  }

  function sendFilesToDatabase(resolutionID, filesList) {
    var filesUploaded = 0;
    var totalFilesCount = filesList.length;

    if (totalFilesCount != 0) {
      for (var i = 0; i < totalFilesCount; i++) {
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            filesUploaded++;
            if (filesUploaded >= totalFilesCount) {
              window.confirm("Edycja przebiegła poprawnie!");
              document.location.href = "resolutions.php";
            }
          }
        }
        var url = 'resolutions_edit.php?action=3&resolutionId=' + resolutionID + '&fileName=' + filesList[i];
        xhttp.open('GET', url, true);
        xhttp.send();
      }
    } else {
      window.confirm("Edycja przebiegła poprawnie!");
      document.location.href = "resolutions.php";
    }
  }

  function createExistingFileElement(resolutionId, fileName) {
    var div = document.createElement('div');
    div.setAttribute('id', resolutionId + fileName);

    var a = document.createElement('a');
    var directory = "assets/uchwalyPliki/" + resolutionId + "/";
    a.href = directory + fileName;
    a.download = fileName;
    a.innerHTML = fileName;

    var button = document.createElement('input');
    button.type = "button";
    button.setAttribute('data-resolutionId', resolutionId);
    button.setAttribute('data-fileName', fileName);
    button.style.cursor = "pointer";
    button.onclick = function(event) {
      var id = event.target.getAttribute('data-resolutionId');
      var name = event.target.getAttribute('data-fileName');
      removeExistingFile(id, name);
    }
    button.value = "Usuń";

    div.appendChild(a);
    div.appendChild(button);

    return div;
  }

  function removeExistingFile(resolutionId, fileName) {
    var r = confirm("Czy na pewno chcesz usunąć ten plik");
    if (r == true) {
      xhttp = new XMLHttpRequest();
      var request = 'resolutions_edit.php?action=4&resolutionId=' + resolutionId + '&fileName=' + fileName;

      xhttp.onreadystatechange = function() {
        if (this.readyState == 4) {
          if (this.responseText.includes("SUCCESS")) {
            document.getElementById(resolutionId + fileName).remove();
          } else {
            alert('Błąd podczas usuwania pliku');
          }
        }
      }

      xhttp.open('GET', request, true);
      xhttp.send();
    }
    
  }

  function hasEditDeletePermission() {
    return hasEditDeletePermission;
  }

  function isUserTheAuthor(author) {
    return author == userId;
  }
});