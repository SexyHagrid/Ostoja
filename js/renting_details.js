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

        getRentalOffer();
      }
    }
    xhttp.open('GET', 'user.php?sessionID=' + getSessionID(), true);
    xhttp.send();
  }

  function getRentalOffer() {
    data.id = new URLSearchParams(window.location.search).get('id');
    data.isGalleryVisible = false;

    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        reorganizeData(this.responseText);
        displayData();
      }
    }
    xhttp.open('GET', 'Wynajem_detale.php?id=' + data.id, true);
    xhttp.send();
  }

  function reorganizeData(responseData) {
    var rentalList = responseData.split('||');
    var rentalData = rentalList[0].split('|');

    data.rentalId = rentalData[0];
    data.rentalPrice = rentalData[1];
    data.rentalAddress = rentalData[2];
    data.rentalTime = rentalData[3];
    data.rentalPhone = rentalData[4];
    data.rentalInfo = rentalData[5];
    data.rentalPhotos = [];
    data.rentalType = rentalData[7];

    for (var i = 0; i < rentalList.length; i++) {
      var rentalData = rentalList[i].split('|');

      var id = rentalData[0];
      if (isNaN(id) || id == "") {
        break;
      }

      if (rentalData[6] != " ") {
        data.rentalPhotos.push(rentalData[6]);
      }
    }
  }

  function displayData() {
    var addressLabel = document.getElementById('addressLabel');
    var additionalInfoLabel = document.getElementById('additionalInfoLabel');
    var phoneLabel = document.getElementById('phoneLabel');
    var priceLabel = document.getElementById('priceLabel');
    var timeLabel = document.getElementById('timeLabel');
    var rentalImage = document.getElementById('rentalImage');

    addressLabel.innerHTML = data.rentalAddress;
    additionalInfoLabel.innerHTML = data.rentalInfo;
    phoneLabel.innerHTML = data.rentalPhone;
    priceLabel.innerHTML = data.rentalPrice;
    timeLabel.innerHTML = data.rentalTime;

    var directory = 'zdjeciaWynajem/' + data.rentalType + 'pokojowe/';

    if (data.rentalPhotos.length == 0) {
      addImageToSlider("placeholder.png", 0);
    } else {
      for (var i = 0; i < data.rentalPhotos.length; i++) {
        addImageToSlider(directory + data.rentalPhotos[i], i);
      }
    }
  }

  function addImageToSlider(img, index) {
    var div = document.createElement('div');
    div.classList.add('carousel-item');
    if (index == 0) {
      div.classList.add('active');
    }

    var image = document.createElement('img');
    image.src = img;
    image.classList.add('d-block');
    image.classList.add('w-100');

    div.append(image);

    var carouselContent = document.getElementById('carouselContent');
    carouselContent.append(div);


    var li = document.createElement('li');
    li.setAttribute('data-target', '#carouselExampleIndicators');
    li.setAttribute('data-slide-to', index);
    if (index == 0) {
      li.classList.add('active');
    }
    var carouselIndicators = document.getElementById('carouselIndicators');
    carouselIndicators.append(li);
  }

  function toggleGalleryVisibility() {
    data.isGalleryVisible = !data.isGalleryVisible;
    var carousel = document.getElementById('carouselExampleIndicators');

    if (data.isGalleryVisible) {
      carousel.style.display = 'block';
    } else {
      carousel.style.display = 'none';
    }
  }

  function getSessionID() {
    return localStorage.getItem('sessionID');
  }
});
