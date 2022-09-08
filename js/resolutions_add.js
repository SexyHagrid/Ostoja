$(document).ready(function () {
  var createResolutionButton = $('#createButton');

  createResolutionButton.on('click', function() {
    validateData();
  });

  function validateData() {
    var resolutionID = document.getElementById('resolutionID').value;
    var resolutionText = document.getElementById('resolutionText').value;

    if (resolutionID.replace(" ", "") == "") {
      alert("Numer uchwały nie może być pusty");
      return;
    }

    if (resolutionText.replace(" ", "") == "") {
      alert("Tytuł uchwały nie może być pusty");
      return;
    }

    createFilesFolder();
  }

  function createFilesFolder() {
    var xhttp = new XMLHttpRequest();
    
    var resolutionID = document.getElementById('resolutionID').value;
    var directory = "assets/uchwalyPliki/" + resolutionID;
    var request = "file_manager.php?action=1&directoryPath=" + directory;
    xhttp.onreadystatechange = function() {
      if (this.readyState === this.DONE) {
        if (this.responseText.includes("SUCCESS")) {
          handleFilesUpload();
        } else {
          alert("Błąd podczas przesyłania plików");
        }
      }
    };
    xhttp.open('GET', request, true);
    xhttp.send();
  }

  function handleFilesUpload() {
    var resolutionID = document.getElementById('resolutionID');
    var resolutionFiles = document.getElementById('uploadFilesInput');
    const formData = new FormData();

    for (var i = 0; i < resolutionFiles.files.length; i++) {
      formData.append('files[]', resolutionFiles.files[i]);
    }

    var directory = "assets/uchwalyPliki/" + resolutionID.value + "/";

    fetch('resolutions_add.php?action=1&directory=' + directory, {
      method: 'POST',
      body: formData
    })
    .then((response) => {
      response.text().then(text => {
        var responseList = text.split('|');
        responseList.pop();

        createResolution(responseList);
      })
    })
  }

  function createResolution(filesList) {
    xhttp = new XMLHttpRequest();
    var resolutionID = document.getElementById('resolutionID').value;
    var resolutionText = document.getElementById('resolutionText').value;
  
    var request = 'resolutions_add.php?action=2&id=' + resolutionID + '&text=' + resolutionText;
  
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4) {
        if (this.responseText.includes("SUCCESS")) {
          sendFilesToDatabase(resolutionID ,filesList);
        } else {
          alert('Błąd podczas dodawania uchwały');
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
              window.confirm("Uchwała została dodana!");
              document.location.href = "resolutions.php";
            }
          }
        }
        var url = 'resolutions_add.php?action=3&resolutionId=' + resolutionID + '&fileName=' + filesList[i];
        xhttp.open('GET', url, true);
        xhttp.send();
      }
    } else {
      window.confirm("Uchwała została dodana!");
      document.location.href = "resolutions.php";
    }
  }
});