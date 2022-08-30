$(document).ready(function () {
  var data = {};

  onStart();

  function onStart() {
    getCompletedSurveys();
  }

  function getCompletedSurveys() {
    data.completedSurveys = [...new Set(completedSurveysArray)];

    var urlParams = new URLSearchParams(window.location.search);
    data.surveyID = urlParams.get('id');

    if (data.completedSurveys.includes(data.surveyID)) {
      var title = document.getElementById('surveyTitle');
      title.innerHTML = "Już odpowiedziałeś na tą ankietę";
    } else {
      getSurvey();
    }
  }

  function getSurvey() {
    var surveyTitle = questionsArray[0].name;

    var tbody = document.getElementById("surveysContent");
    var title = document.getElementById('surveyTitle');
    title.innerHTML = surveyTitle;

    for (var i = 0; i < questionsArray.length; i++) {
      var questionID = questionsArray[i].questionId;
      var questionText = questionsArray[i].questionText;
      var questionType = questionsArray[i].questionType;

      tbody.append(createQuestionLabel(questionText));
      tbody.append(createNewLine());
      tbody.append(createAnswerInput(questionID, questionType));
      tbody.append(createNewLine());
    }

    tbody.appendChild(createSubmitButton());
  }

  function sendSurvey() {
    var answers = document.getElementsByTagName('input');

    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.responseText.includes("SUCCESS")) {
        alert('Ankieta została wysłana');
        document.location.href = "voting.php";
      }
    }

    var request = 'voting_vote.php?action=3&userID=' + userId;
    for (var i = 0; i < answers.length; i++) {
      var type = answers[i].getAttribute('data-type');
      if (type == 0) {
        request += '&' + answers[i].getAttribute('id') + '=' + answers[i].value;
      } else if (type == 1) {
        request += '&' + answers[i].getAttribute('id') + '=' + answers[i].value;
      } else if (type == 2) {
        request += '&' + answers[i].getAttribute('id') + '=' + answers[i].checked;
      }
    }

    xhttp.open('GET', request, true);
    xhttp.send();
  }

  function createQuestionLabel(text) {
    var label = document.createElement('label');
    label.innerHTML = text;
    return label;
  }

  function createNewLine() {
    return document.createElement('br');
  }

  function createAnswerInput(id, type) {
    var answer = document.createElement('input');

    if (type == 0) {
      answer.setAttribute('type', 'text');
    } else if (type == 1) {
      answer.setAttribute('type', 'number');
      answer.setAttribute('min', 0);
      answer.setAttribute('max', 10);
    } else if (type == 2) {
      answer.setAttribute('type', 'checkbox');
    }
    answer.setAttribute('id', id);
    answer.setAttribute('data-type', type);

    return answer;
  }

  function createSubmitButton() {
    var button = document.createElement('button');
    button.innerHTML = "Wyślij";
    button.onclick = function(event) {
      sendSurvey();
    }
    button.style.cursor = "pointer";
    return button;
  }
});
