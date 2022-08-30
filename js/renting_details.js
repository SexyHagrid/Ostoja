$(document).ready(function () {
  var data = {};

  onStart();

  function onStart() {
    reorganizeData();
    displayData();
  }

  function reorganizeData() {
    var rentalData = resultArray[0];

    data.rentalId = rentalData.id;
    data.rentalPrice = rentalData.price;
    data.rentalAddress = rentalData.address;
    data.rentalTime = rentalData.time;
    data.rentalPhone = rentalData.phone;
    data.rentalInfo = rentalData.info;
    data.rentalPhotos = [];
    data.rentalType = rentalData.type;

    for (var i = 0; i < resultArray.length; i++) {
      if (resultArray[i].photo != " ") {
        data.rentalPhotos.push(resultArray[i].photo);
      }
    }
  }

  function displayData() {
    var addressLabel = document.getElementById('addressLabel');
    var additionalInfoLabel = document.getElementById('additionalInfoLabel');
    var phoneLabel = document.getElementById('phoneLabel');
    var priceLabel = document.getElementById('priceLabel');
    var timeLabel = document.getElementById('timeLabel');

    addressLabel.innerHTML = data.rentalAddress;
    additionalInfoLabel.innerHTML = data.rentalInfo;
    phoneLabel.innerHTML = data.rentalPhone;
    priceLabel.innerHTML = data.rentalPrice;
    timeLabel.innerHTML = data.rentalTime;

    var directory = 'assets/zdjeciaWynajem/' + data.rentalType + 'pokojowe/';

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
});
