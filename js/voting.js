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
          if (id == null) {
            id = event.target.parentElement.getAttribute('data-id');
          }
          onSurveyClick(id);
        }
        div.style.cursor = "pointer";
        labelNumber.style.cursor = "pointer";
        labelTitle.style.cursor = "pointer";
      }

      // Sprawdzamy, czy użytkownik jest adminem
      // Jeżeli tak, to wyświetlamy przycisk do przejścia do podsumowania
      if (isAdmin()) {
        div.appendChild(createSummaryButton(surveyID));
      }

      tbody.appendChild(div);
    }
  }

  function showSurveySummary(surveyID) {
    document.location.href = 'voting_summary.php?id=' + surveyID;
  }

  function onSurveyClick(id) {
    document.location.href = 'voting_vote.php?id=' + id;
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
    return label;
  }

  function createNewLine() {
    return document.createElement('br');
  }

  function createSummaryButton(id) {
    var button = document.createElement('button');
    button.innerHTML = "Podsumowanie";
    button.setAttribute('data-id', id);
    button.onclick = function(event) {
      showSurveySummary(event.target.getAttribute('data-id'));
    }
    return button;
  }

  function isAdmin() {
    return data.userRole == 1;
  }

  function getSessionID() {
    return localStorage.getItem('sessionID');
  }
});