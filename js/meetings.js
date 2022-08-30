$(document).ready(function () {
  const CLOSEST_DATE = $('#closest-date').text();

  function getMeetingDetails(date) {
    return new Promise((resolve) => {
      $.ajax({
        type: "GET",
        url: "utils/getDetails.php",
        data: {
          method: 'getMeeting',
          date
        },
        dataType: 'json',
      }).done(function (response) {
        resolve(response);
      });
    })
  }

  function setHeader(meetingId) {
    let date = $(`#${meetingId}`).children('.div-date').text();
    if (date == CLOSEST_DATE) {
      $(`#${meetingId}`).children('.div-header').text('Najbliższe spotkanie');
    } else if (date > CLOSEST_DATE) {
      $(`#${meetingId}`).children('.div-header').text('Nadchodzące spotkanie');
    } else {
      $(`#${meetingId}`).children('.div-header').text('Ubiegłe spotkanie');
    }
  }

  $('.meeting-overview-tile').on('click', async function() {
    $('.meeting-overview-tile').each(function() {
      $(this).removeClass('mot-chosen');
    });

    $(this).addClass('mot-chosen');
    $('#meeting-past').css('display', 'block');
    $('#meeting-incoming').css('display', 'block');

    let closest = $(this);
    let past = closest.prev();
    let incoming = closest.next();

    let closestData = await getMeetingDetails(closest.children('.inner-text').text());
    $('#closest-date').text(closestData[0][1]);
    $('#closest-agenda').text(closestData[0][2]);
    setHeader('meeting-closest');

    if (past.children('.inner-text').text()) {
      let pastData = await getMeetingDetails(past.children('.inner-text').text());
      $('#past-date').text(pastData[0][1]);
      setHeader('meeting-past');
    } else {
      $('#meeting-past').css('display', 'none');
    }

    if (incoming.children('.inner-text').text()) {
      let incomingData = await getMeetingDetails(incoming.children('.inner-text').text());
      $('#incoming-date').text(incomingData[0][1]);
      setHeader('meeting-incoming');
    } else {
      $('#meeting-incoming').css('display', 'none');
    }
  })

  $('#meeting-past').on('click', async function() {
    if ($('#meeting-incoming').css('display') == 'none') {
      $('#meeting-incoming').css('display', 'block');
    }

    $('#incoming-date').text($('#closest-date').text());
    $('#closest-date').text($('#past-date').text());

    let closestDate = await getMeetingDetails($('#closest-date').text());
    $('#closest-agenda').text(closestDate[0][2]);

    let pastDate = $(`.meeting-overview-tile:contains('${$('#past-date').text()}')`).prev();
    if (pastDate.children('.inner-text').text()) {
      $('#past-date').text(pastDate.children('.inner-text').text());
      setHeader('meeting-past');
    } else {
      $('#meeting-past').css('display', 'none');
    }

    $('.meeting-overview-tile').each(function() {
      $(this).removeClass('mot-chosen');
    });

    $(`.meeting-overview-tile:contains('${$('#closest-date').text()}')`).addClass('mot-chosen');

    setHeader('meeting-closest');
    setHeader('meeting-incoming');
  })

  $('#meeting-incoming').on('click', async function() {
    if ($('#meeting-past').css('display') == 'none') {
      $('#meeting-past').css('display', 'block');
    }

    $('#past-date').text($('#closest-date').text());
    $('#closest-date').text($('#incoming-date').text());

    let closestDate = await getMeetingDetails($('#closest-date').text());
    $('#closest-agenda').text(closestDate[0][2]);

    let incomingDate = $(`.meeting-overview-tile:contains('${$('#incoming-date').text()}')`).next();
    if (incomingDate.children('.inner-text').text()) {
      $('#incoming-date').text(incomingDate.children('.inner-text').text());
      setHeader('meeting-incoming');
    } else {
      $('#meeting-incoming').css('display', 'none');
    }

    $('.meeting-overview-tile').each(function() {
      $(this).removeClass('mot-chosen');
    });

    $(`.meeting-overview-tile:contains('${$('#closest-date').text()}')`).addClass('mot-chosen');

    setHeader('meeting-closest');
    setHeader('meeting-past');
  })

  // Edit meetings
  function removeMeeting(date) {
    return new Promise((resolve) => {
      $.ajax({
        type: "GET",
        url: "utils/getDetails.php",
        data: {
          method: 'deleteMeeting',
          date
        },
        dataType: 'json',
      }).done(function (response) {
        if (response == true) {
          resolve(true);
        } else {
          resolve(false);
        }
      });
    })
  }

  $('.x-glyph').on('click', async function(e) {
    e.stopPropagation();

    let date = $(this).next().text();
    let isRemoved = await removeMeeting(date);
    if (isRemoved) {
      $(`.meeting-overview-tile:contains('${date}')`).remove();

      if (date == $('#past-date').text()) {
        let pastDate = $(`.meeting-overview-tile:contains('${$('#closest-date').text()}')`).prev();
        if (pastDate.children('.inner-text').text()) {
          $('#past-date').text(pastDate.children('.inner-text').text());
          setHeader('meeting-past');
        } else {
          $('#meeting-past').css('display', 'none');
        }
      }

      if (date == $('#incoming-date').text()) {
        let incomingDate = $(`.meeting-overview-tile:contains('${$('#closest-date').text()}')`).next();
        if (incomingDate.children('.inner-text').text()) {
          $('#incoming-date').text(incomingDate.children('.inner-text').text());
          setHeader('meeting-incoming');
        } else {
          $('#meeting-incoming').css('display', 'none');
        }
      }

      if (date == $('#closest-date').text()) {
        let incomingDate = $(`.meeting-overview-tile:contains('${$('#incoming-date').text()}')`);
        let pastDate = $(`.meeting-overview-tile:contains('${$('#past-date').text()}')`);
        if (incomingDate.children('.inner-text').text()) {
          $('#closest-date').text(incomingDate.children('.inner-text').text());
          setHeader('meeting-closest');

          incomingDate = $(`.meeting-overview-tile:contains('${$('#incoming-date').text()}')`).next();
          if (incomingDate.children('.inner-text').text()) {
            $('#closest-date').text(incomingDate.children('.inner-text').text());
            setHeader('meeting-closest');
          } else {
            $('#meeting-incoming').css('display', 'none');
          }
        } else if (pastDate.children('.inner-text').text()) {
          $('#closest-date').text(pastDate.children('.inner-text').text());
          setHeader('meeting-closest');

          pastDate = $(`.meeting-overview-tile:contains('${$('#past-date').text()}')`).past();
          if (pastDate.children('.inner-text').text()) {
            $('#closest-date').text(pastDate.children('.inner-text').text());
            setHeader('meeting-closest');
          } else {
            $('#meeting-past').css('display', 'none');
          }
        } else {
          $('#meeting-closest').css('display', 'none');
        }
      }
    }
  })

  $('#edit-meetings').on('click', function() {
    let btnText = $(this).text();
    if (btnText == 'Edytuj') {
      $(this).text('Zakończ');
      $('.inner-text').css('font-size', 'medium');
      $('.inner-text').css('margin-top', '0');
      $('.x-glyph').css('display', 'block');
    } else if (btnText == 'Zakończ') {
      $(this).text('Edytuj');
      $('.x-glyph').css('display', 'none');
      $('.inner-text').css('font-size', 'large');
      $('.inner-text').css('margin-top', '10%');
    }
  })
});
