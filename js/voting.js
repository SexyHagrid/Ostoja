$(document).ready(function () {
  var data = {};

  onStart();

  function onStart() {
    getCompletedSurveys();
  }

  // pobieramy listę ankiet (listę ID), które zostały wypełnione przez zalogowanego użytkownika
  function getCompletedSurveys() {
    data.completedSurveys = [...new Set(completedSurveysArray)];
    getAllSurveys();
  }

  // Pobieramy z bazy danych wszystkie dostępne ankiety
  function getAllSurveys() {
    var tbody = document.getElementById("surveysContent");


    // Tworzymy w pętli ankiety
    for (var i = 0; i < votingArray.length; i++) {
      var surveyID = votingArray[i].id;
      var surveyTitle = votingArray[i].name;

      // Sprawdzamy, czy nie dostaliśmy pustej ankiety
      if (surveyID == '') {
        break;
      }

      var div = document.createElement('div');
      div.setAttribute('class', 'row-akt');
      div.setAttribute('data-id', surveyID);
      div.style.padding = "10px";

      // Ładujemy dane ankiety
      var labelNumber = createNumberLabel(i + 1);
      var labelTitle = createTitleLabel(surveyTitle);

      div.appendChild(labelNumber);
      div.appendChild(createNewLine());
      div.appendChild(labelTitle);

      // Sprawdzamy, czy użytkownik wypełnił daną ankietę
      // Jeżeli tak, to dodajemy napis - WYPEŁNIONA
      if (data.completedSurveys.includes(surveyID)) {
        var completedLabel = createCompletedSurveyLabel();
        div.appendChild(completedLabel);
      }

      // Sprawdzamy, czy użytkownik jest zalogowany, a jeżeli tak, to czy wypełnił już daną ankietę.
      // Jeżeli tak, to pozwalamy, żeby ankieta była klikalna -> po kliknięciu przechodzimy do wypełniania.
      // Jeżeli nie, to wyświetlamy ankietę, ale nie pozwalamy jej wypełnić
      if (!isNaN(userId) && !data.completedSurveys.includes(surveyID)) {
        div.onclick = function (event) {
          var id = event.target.getAttribute('data-id');
          if (event.target.type == "submit") {
            return;
          } else if (id == null) {
            id = event.target.parentElement.getAttribute('data-id');
          }
          onSurveyClick(id);
        }
        div.style.cursor = "pointer";
        labelNumber.style.cursor = "pointer";
        labelTitle.style.cursor = "pointer";
      }

      if (hasViewSummaryPermission) {
        div.appendChild(createSummaryButton(surveyID));
      }

      tbody.appendChild(div);
    }
  }

  function showSurveySummary(surveyID) {
    document.location.href = 'głosowanie-wyniki?surveyID=' + surveyID;
  }

  function onSurveyClick(id) {
    document.location.href = 'głosowanie-głosuj?id=' + id;
  }

  function createNumberLabel(number) {
    var label = document.createElement('label');
    label.innerHTML = "Ankieta nr. " + (number);
    return label;
  }

  function createTitleLabel(text) {
    var label = document.createElement('label');
    label.innerHTML = text;
    label.setAttribute('style', 'font-weight: bold;');
    return label;
  }

  function createCompletedSurveyLabel() {
    var label = document.createElement('label');
    label.innerHTML = "   --- WYPEŁNIONA ---";
    label.setAttribute('style', 'color: red;');
    label.style.marginLeft = "20px";
    return label;
  }

  function createNewLine() {
    return document.createElement('br');
  }

  function createSummaryButton(id) {
    var button = document.createElement('button');
    button.innerHTML = "Podsumowanie";
    button.setAttribute('data-id', id);
    button.style.marginLeft = "20px";
    button.style.cursor = "pointer";
    button.onclick = function(event) {
      showSurveySummary(event.target.getAttribute('data-id'));
    }
    return button;
  }
});
