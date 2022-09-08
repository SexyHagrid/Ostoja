$(document).ready(function () {

    var faqSubmitButton = $('#faqSubmitButton');
    faqSubmitButton.on('click', function() {
        onSubmitButtonClick();
    });

    function onSubmitButtonClick() {
        var question = document.getElementById("faqQuestionInput").value;
        var answer = document.getElementById("faqAnswerInput").value;

        var request = 'faq_add.php?question=' + question + '&answer=' + answer;
  
        alert(request);

        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4) {
                if (this.responseText.includes("SUCCESS")) {
                    alert('Dodano poprawnie nowe FAQ');
                    document.location.href = "faq.php";
                } else if (this.responseText.includes("FAIL")) {
                    alert('Błąd podczas dodawania FAQ');
                }
            }
        }
  
        xhttp.open('GET', request, true);
        xhttp.send();
    }
});