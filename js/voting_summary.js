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

        var urlParams = new URLSearchParams(window.location.search);
        data.surveyID = urlParams.get('id');

        // Jeżeli żaden użytkownik nie jest zalogowany -> przechodzimy do listy ankiet
        if (isNaN(data.userID) || !isAdmin()) {
          document.location.href = "Glosowania.html";
        }

        getSurveyAnswers();
      }
    }

    xhttp.open('GET', 'user.php?sessionID=' + getSessionID(), true);
    xhttp.send();
  }

  function getSurveyAnswers() {
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var answersList = this.responseText.split('||');

        data.surveyName = answersList[0].split('|')[0];
        data.questionIDList = [];
        data.questionTextList = [];
        data.questionTypeList = [];
        data.answerTextList = [];

        for (var i = 0; i < answersList.length; i++) {
          var answerData = answersList[i].split('|');

          var questionID = answerData[1];
          if (isNaN(questionID)) {
            break;
          }
          var questionText = answerData[2];
          var questionType = answerData[3];
          var answerText = answerData[4];

          if (!data.questionIDList.includes(questionID)) {
            data.questionIDList.push(questionID);
            data.questionTextList.push(questionText);
            data.questionTypeList.push(questionType);
            data.answerTextList.push([]);
          }

          var index = data.questionIDList.indexOf(questionID);
          data.answerTextList[index].push(answerText);
        }

        loadAnswers();
      }
    }
    xhttp.open('GET', 'voting.php?action=4&surveyID=' + data.surveyID, true);
    xhttp.send();
  }

  function loadAnswers() {
    var surveyTitle = document.getElementById('surveyTitle');
    surveyTitle.innerHTML = data.surveyName + " - PODSUMOWANIE";

    var tbody = document.getElementById('surveyContent');

    for (var i = 0; i < data.questionIDList.length; i++) {
      var questionText = data.questionTextList[i];
      var questionType = parseInt(data.questionTypeList[i]);
      var answersList = data.answerTextList[i];

      tbody.append(createQuestionLabel(questionText));
      tbody.append(createNewLine());

      if (questionType == 0) {
        for (var j = 0; j < answersList.length; j++) {
          tbody.append(createAnswerLabel(answersList[j]));
          tbody.append(createNewLine());
        }
      } else if (questionType == 1) {
        var sum = 0;
        for (var j = 0; j < answersList.length; j++) {
          sum += parseInt(answersList[j]);
        }

        var mean = sum / answersList.length;
        tbody.append(createMeanAnswerLabel(mean));
        tbody.append(createNewLine());
      } else if (questionType == 2) {
        var positiveAnswerNumber = 0;
        for (var j = 0; j < answersList.length; j++) {
          console.log(answersList[j]);

          if (answersList[j] === 'true') {
            positiveAnswerNumber++;
          }
        }

        var positivePercentage = Math.round((positiveAnswerNumber / answersList.length) * 100 * 10) / 10;
        var negativePercentage = 100 - positivePercentage;

        tbody.append(createBoolAnswerLabel(positivePercentage, negativePercentage));
        tbody.append(createNewLine());
      }
    }

    tbody.append(createNewLine());
  }

  function createQuestionLabel(text) {
    var label = document.createElement('label');
    label.innerHTML = text;
    label.setAttribute('style', 'font-weight: bold;');
    return label;
  }

  function createNewLine() {
    return document.createElement('br');
  }

  function createAnswerLabel(text) {
    var label = document.createElement('label');
    label.innerHTML = text;
    return label;
  }

  function createMeanAnswerLabel(text) {
    var label = document.createElement('label');
    label.innerHTML = "Średnia ocena: " + Math.round(text * 10) / 10;
    return label;
  }

  function createBoolAnswerLabel(positivePercentage, negativePercentage) {
    var label = document.createElement('label');
    label.innerHTML = "TAK: " + positivePercentage + "%      NIE: " + negativePercentage + "%";
    return label;
  }

  function getSessionID() {
    return localStorage.getItem('sessionID');
  }

  function isAdmin() {
    return data.userRole == 1;
  }
});
