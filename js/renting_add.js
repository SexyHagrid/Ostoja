$(document).ready(function () {
  var data = {};
  var submitButton = $('#submitButton');
  submitButton.on('click', function() {
    onSendButtonClick();
  });

  onStart();

  function onStart() {
    getRentalCategories();
  }

  function getRentalCategories() {
    data.idList = [];
    data.nameList = [];

    for (var i = 0; i < resultArray.length; i++) {
      var id = resultArray[i].id;
      var name = resultArray[i].text;

      if (!isNaN(id) && id != "") {
        data.idList.push(id);
        data.nameList.push(name);
      }
    }

    displayData();
  }

  function displayData() {
    var typeSelectElement = document.getElementById('typeSelectElement');
        for (var i = 0; i < data.nameList.length; i++) {
          var option = document.createElement('option');
          option.value = data.idList[i];
          option.innerHTML = data.nameList[i];
          typeSelectElement.append(option);
        }
  }

  function onSendButtonClick() {
    validateInputData();
  }

  function validateInputData() {
    var price = document.getElementById('priceElement').value;
    var address = document.getElementById('addressElement').value;
    var time = document.getElementById('timeElement').value;
    var phone = document.getElementById('phoneNumberElement').value;

    if (price.replace(" ", "") == "") {
      alert("Cena nie może być pusta");
      return;
    }

    if (address.replace(" ", "") == "") {
      alert("Adres nie może być pusty");
      return;
    }

    if (time.replace(" ", "") == "") {
      alert("Czas nie może być pusty");
      return;
    }

    if (phone.replace(" ", "") == "") {
      alert("Numer telefonu nie może być pusty");
      return;
    }

    handleImageUpload();
  }

  function handleImageUpload() {
    var uploadPhotosElement = document.getElementById('uploadPhotosElement');
    var typeSelectElement = document.getElementById('typeSelectElement');
    const formData = new FormData();

    for (var i = 0; i < uploadPhotosElement.files.length; i++) {
      formData.append('files[]', uploadPhotosElement.files[i]);
    }

    var directory = 'assets/zdjeciaWynajem/' + typeSelectElement.value + 'pokojowe/';
    fetch('renting_add.php?action=1&directory=' + directory, {
      method: 'POST',
      body: formData
    })
    .then((response) => {
      response.text().then(text => {
        var responseList = text.split('|');
        responseList.pop();

        sendDataToDatabase(responseList);
      })
    })
  }

  function sendDataToDatabase(photosList) {
    var type = document.getElementById('typeSelectElement').value;
    var price = document.getElementById('priceElement').value;
    var address = document.getElementById('addressElement').value;
    var time = document.getElementById('timeElement').value;
    var phone = document.getElementById('phoneNumberElement').value;
    var additionalInfo = document.getElementById('additionalInfoElement').value;

    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var rentalId = this.responseText;
        sendPhotosInfoToDatabase(photosList, rentalId);
      }
    }
    var url = 'renting_add.php?action=2&type=' + type + '&price=' + price + '&address=' + address + '&time=' + time + '&phone=' + phone + '&info=' + additionalInfo;
    xhttp.open('GET', url, true);
    xhttp.send();
  }

  function sendPhotosInfoToDatabase(photosList, rentalId) {
    data.photosUploaded = 0;
    data.photosToUpload = photosList.length;

    for (var i = 0; i < photosList.length; i++) {
      xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          data.photosUploaded++;
          if (data.photosUploaded >= data.photosToUpload) {
            window.confirm("Oferta została dodana!");
            document.location.href = "renting_categories.php";
          }
        }
      }
      var url = 'renting_add.php?action=3&rentalId=' + rentalId + '&fileName=' + photosList[i];
      xhttp.open('GET', url, true);
      xhttp.send();
    }
  }

});
