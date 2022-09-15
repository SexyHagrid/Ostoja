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
            var button = clone.querySelectorAll('button');

            h3[0].textContent = "Pytanie nr. " + (i + 1);
            label[0].textContent = faqQuestion;
            label[1].textContent = faqAnswer;

            if (hasEditDeletePermission()) {
                button[0].style.display = "block";
                button[0].setAttribute("data-id", faqId);
                button[0].onclick = function(event) {
                    var id = event.target.getAttribute("data-id");
                    onEditButtonClick(id);
                }

                button[1].style.display = "block";
                button[1].setAttribute("data-id", faqId);
                button[1].onclick = function(event) {
                    var id = event.target.getAttribute("data-id");
                    onDeleteButtonClick(id);
                }
            }
            tbody.append(clone);
        }
    }

    function onAddNewFaqEntryClick() {
        document.location.href = "faq_add.php";
    }

    function hasEditDeletePermission() {
        return hasEditDeletePermission;
    }

    function onEditButtonClick(id) {
        document.location.href = "faq_edit.php?id=" + id;
    }

    function onDeleteButtonClick(id) {
        var answer = window.confirm("Czy na pewno chcesz usunąć FAQ?");
        if (answer) {
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4) {
                    if (this.responseText.includes("SUCCESS")) {
                        alert('FAQ zostało usunięte');
                        window.location.reload(true);
                    } else {
                        alert('Błąd podczas usuwania FAQ');
                    }
                }
            }
            xhttp.open('GET', 'faq_delete.php?id=' + id, true);
            xhttp.send();
        }
    }
});