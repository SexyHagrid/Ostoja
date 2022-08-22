$(document).ready(function () {
  var data = {};

  onStart();

  function onStart() {
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var result = this.responseText.split('|');
        data.userID = parseInt(result[0]);
        data.userRole = parseInt(result[1]);

        getRentalOffers();
      }
    }
    xhttp.open('GET', 'user.php?sessionID=' + getSessionID(), true);
    xhttp.send();
  }

  function getRentalOffers() {
    data.rentalType = new URLSearchParams(window.location.search).get('id');

    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        reorganizeData(this.responseText);
        displayData();
      }
    }
    xhttp.open('GET', 'Wynajem_lista.php?id=' + data.rentalType, true);
    xhttp.send();
  }

  function reorganizeData(responseData) {
    var rentalList = responseData.split('||');

    data.idList = [];
    data.addressList = [];
    data.imagesList = [];

    for (var i = 0; i < rentalList.length; i++) {
      var rentalData = rentalList[i].split('|');

      var id = rentalData[0];
      if (isNaN(id) || id == "") {
        break;
      }

      var address = rentalData[1];
      var image = rentalData[2];

      if (!data.idList.includes(id)) {
        data.idList.push(id);
        data.addressList.push(address);
        data.imagesList.push([]);
      }

      var index = data.idList.indexOf(id);
      data.imagesList[index].push(image);
    }
  }

  function displayData() {
    var contentDiv = document.getElementById('contentDiv');

    for (var i = 0; i < data.idList.length; i++) {
      var item = createCardElement(data.idList[i], data.imagesList[i][0]);
      var address = createAddressElement(data.addressList[i]);

      item.onclick = function (mouseEvent) {
        var id = event.target.getAttribute('data-id');
        if (id == null) {
          id = event.target.parentElement.getAttribute('data-id');
        }
        onItemClick(id);
      }

      item.append(address);
      contentDiv.append(item);
    }
  }

  function createCardElement(id, backgroundImage) {
    var div = document.createElement('div');
    div.classList.add('col-3');
    div.classList.add('main-col');
    div.setAttribute('data-id', id);

    var directory = 'zdjeciaWynajem/' + data.rentalType + 'pokojowe/';
    div.style.backgroundImage = 'url(' + directory + backgroundImage + ')';
    div.style.backgroundSize = 'cover';
    div.style.backgroundRepeat = 'no-repeat';
    return div;
  }

  function createAddressElement(address) {
    var label = document.createElement('label');
    label.innerHTML = address;
    label.style.color = 'black';
    label.style.backgroundColor = 'white';
    label.style.width = '100%';
    return label;
  }

  function createNewLineElement() {
    return document.createElement('br');
  }

  function onItemClick(id) {
    document.location.href = 'Wynajem_detale.html?id=' + id;
  }

  function getSessionID() {
    return localStorage.getItem('sessionID');
  }
});
