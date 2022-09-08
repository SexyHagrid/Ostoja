$(document).ready(function () {

    var rentingButton = $('#rentingButton');
    rentingButton.on('click', function() {
        onRentingButtonClick();
    });

    function onRentingButtonClick() {
        document.location.href = "renting_categories.php";
    }    
});