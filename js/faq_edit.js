$(document).ready(function () {

    var faqSubmitButton = $('#faqSubmitButton');
    faqSubmitButton.on('click', function() {
        onSubmitButtonClick();
    });

    onStart();

    function onStart() {
        var faqQuestionInput = document.getElementById("faqQuestionInput");
        var faqAnswerInput = document.getElementById("faqAnswerInput");
        
        faqQuestionInput.value = faq.question;
        faqAnswerInput.value = faq.answer;
    }

    function onSubmitButtonClick() {
        var id = faq.id;
        var question = document.getElementById("faqQuestionInput").value;
        var answer = document.getElementById("faqAnswerInput").value;

        var request = 'faq_edit.php?id=' + id + '&question=' + question + '&answer=' + answer;
  
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4) {
                if (this.responseText.includes("SUCCESS")) {
                    alert('Edycja przebiegła poprawnie');
                    document.location.href = "faq.php";
                } else if (this.responseText.includes("FAIL")) {
                    alert('Błąd podczas edycji FAQ');
                }
            }
        }
  
        xhttp.open('GET', request, true);
        xhttp.send();
    }
});