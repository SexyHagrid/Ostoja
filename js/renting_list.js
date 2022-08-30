$(document).ready(function () {
  var data = {};

  onStart();

  function onStart() {
    data.rentalType = new URLSearchParams(window.location.search).get('id');

    reorganizeData();
    displayData();
  }

  function reorganizeData() {
    data.idList = [];
    data.addressList = [];
    data.imagesList = [];

    for (var i = 0; i < resultArray.length; i++) {

      var id = resultArray[i].id;
      if (isNaN(id) || id == "") {
        break;
      }

      var address = resultArray[i].address;
      var image = resultArray[i].image;

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

    var directory = 'assets/zdjeciaWynajem/' + data.rentalType + 'pokojowe/';
    div.style.backgroundImage = 'url(' + directory + backgroundImage + ')';
    div.style.backgroundSize = 'cover';
    div.style.backgroundRepeat = 'no-repeat';
    div.style.cursor = "pointer";
    return div;
  }

  function createAddressElement(address) {
    var label = document.createElement('label');
    label.innerHTML = address;
    label.style.color = 'black';
    label.style.backgroundColor = 'white';
    label.style.width = '100%';
    label.style.cursor = "pointer";
    return label;
  }

  function onItemClick(id) {
    document.location.href = 'renting_details.php?id=' + id;
  }
});
