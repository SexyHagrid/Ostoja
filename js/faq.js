$(document).ready(function () {

    var addNewFaqEntryButton = $('#addNewFaqEntryButton');
    addNewFaqEntryButton.on('click', function() {
        onAddNewFaqEntryClick();
    });

    loadData();

    function loadData() {
        var tbody = document.getElementById("faqContent");
        var template = document.querySelector('#faqTemplate');

        for (var i = 0; i < resultArray.length; i++) {
            var faqId = resultArray[i].id;
            var faqQuestion = resultArray[i].question;
            var faqAnswer = resultArray[i].answer;

            var clone = template.content.cloneNode(true);
            var h3 = clone.querySelectorAll('h3');
            var label = clone.querySelectorAll('label');

            h3[0].textContent = "Pytanie nr. " + (i + 1);
            label[0].textContent = faqQuestion;
            label[1].textContent = faqAnswer;

            tbody.append(clone);
        }
    }

    function onAddNewFaqEntryClick() {
        document.location.href = "faq_add.php";
    }
});