$(document).ready(function () {
  var oneRoomButton = $('#oneRoomButton');
  var twoRoomButton = $('#twoRoomButton');
  var threeRoomButton = $('#threeRoomButton');
  var addOfferButton = $('#addOfferButtonElement');

  oneRoomButton.on('click', function() {
    document.location.href = "renting_list.php?id=1";
  });

  twoRoomButton.on('click', function() {
    document.location.href = "renting_list.php?id=2";
  });

  threeRoomButton.on('click', function() {
    document.location.href = "renting_list.php?id=3";
  });

  addOfferButton.on('click', function() {
    document.location.href = "renting_add.php";
  });

  onStart();

  function onStart() {
    if (isLoggedIn) {
      showAddOfferButton();
    }
  }

  function showAddOfferButton() {
    var addOfferButtonElement = document.getElementById('addOfferButtonElement');
    addOfferButtonElement.style.display = 'block';
  }
});
