$(document).ready(function () {
  var data = {};

  onStart();

  function onStart() {
    // Pobieramy z bazy danych id i rolę użytkownika
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var result = this.responseText.split('|');
        data.userID = parseInt(result[0]);
        data.userRole = parseInt(result[1]);

        // Jeżeli żaden użytkownik nie jest zalogowany -> przechodzimy do listy ankiet
        if (isNaN(data.userID)) {
          document.location.href = "Glosowania.html";
        }

        getCompletedSurveys();
      }
    }

    xhttp.open('GET', 'user.php?sessionID=' + getSessionID(), true);
    xhttp.send();
  }

  function getCompletedSurveys() {
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        data.completedSurveys = [...new Set(this.responseText.split('|'))];

        var urlParams = new URLSearchParams(window.location.search);
        data.surveyID = urlParams.get('id');

        if (data.completedSurveys.includes(data.surveyID)) {
          var title = document.getElementById('surveyTitle');
          title.innerHTML = "Już odpowiedziałeś na tą ankietę";
        } else {
          getSurvey();
        }
      }
    }
    xhttp.open('GET', 'voting.php?action=2&userID=' + data.userID, true);
    xhttp.send();
  }

  function getSurvey() {
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var questions = this.responseText.split('||');
        var surveyTitle = questions[0].split('|')[1];

        var tbody = document.getElementById("surveysContent");
        var title = document.getElementById('surveyTitle');
        title.innerHTML = surveyTitle;

        // Ładujemy pytania
        for (var i = 0; i < questions.length; i++) {
          var questionData = questions[i].split('|');

          for (var j = 2; j < questionData.length; j+=3) {
            var questionID = questionData[j];
            var questionText = questionData[j+1];
            var questionType = questionData[j+2];

            tbody.append(createQuestionLabel(questionText));
            tbody.append(createNewLine());
            tbody.append(createAnswerInput(questionID, questionType));
            tbody.append(createNewLine());
          }
        }

        tbody.appendChild(createSubmitButton());
      }
    }
    xhttp.open('GET', 'voting.php?action=1&id=' + data.surveyID, true);
    xhttp.send();
  }

  function sendSurvey() {
    var tbody = document.getElementById("glosowaniaContent");
    var answers = document.getElementsByTagName('input');

    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.responseText == "SUCCESS") {
        alert('Ankieta została wysłana');
        document.location.href = "Glosowania.html";
      }
    }

    var request = 'voting.php?action=3&userID=' + data.userID;
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

  function getSessionID() {
    return localStorage.getItem('sessionID');
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
    return button;
  }
});
