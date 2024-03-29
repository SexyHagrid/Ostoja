$(document).ready(function () {
  $(".search-ticket").on("keyup", function() {
    var value = this.value.toLowerCase().trim();
    $(".ticket").show().filter(function() {
      return $(this).children('.ticket-details-outer').children('.ticket-name').text().toLowerCase().trim().indexOf(value) == -1;
    }).hide();
  });

  $('#add-ticket').on('click', function() {
    $('.curtain').css('display', 'block');
    $('#create-ticket-div').css('display', 'block');
  })

  function sortTickets(asc) {
    var subjects = $(".ticket");
    var subjectsArray = Array.from(subjects);
    let sorted = subjectsArray.sort(function(a, b) {
      let textA = $(a).children('.ticket-details-outer').children('.ticket-name').text();
      let textB = $(b).children('.ticket-details-outer').children('.ticket-name').text();

      if (textA < textB)
      return asc ? -1 : 1;
      if (textA > textB)
          return asc ? 1 : -1;
      return 0;
    });

    $(".tickets-inner-div").append(sorted);
  }

  $('.two-side-sort-col').on('click', function() {
    let text = $(this).children('.ticket-p-arrow').text();

    if (text === '⮝') {
      $(this).children('.ticket-p-arrow').text('⮟');

      sortTickets(true)
    } else {
      $(this).children('.ticket-p-arrow').text('⮝');

      sortTickets(false);
    }
  })

  $('#close-curtain').on('click', function() {
    $('#create-ticket-div').css('display', 'none');
    $('.curtain').css('display', 'none');
  })

  $('#create-ticket-topic').on('input', function() {
    let text = $(this).val();
    if (text.length === 0) {
      $('.create-ticket-data-topic').css('border-color', 'red');
      $('.create-ticket-data-topic').css('color', 'red');
    } else {
      $('.create-ticket-data-topic').css('border-color', 'black');
      $('.create-ticket-data-topic').css('color', 'black');
    }
  })

  function priorityInArray() {
    let val = $('#create-ticket-priority').val();
    let prioArray = ['Krytyczny', 'Wysoki', 'Średni', 'Niski'];
    let contains = false;

    prioArray.forEach(priority => {
      if (val == priority) {
        contains = true;
      }
    });

    return contains;
  }

  $('#create-ticket-priority').on('input', function() {
    if (!priorityInArray()) {
      $('.create-ticket-data-priority').css('border-color', 'red');
      $('.create-ticket-data-priority').css('color', 'red');
    } else {
      $('.create-ticket-data-priority').css('border-color', 'black');
      $('.create-ticket-data-priority').css('color', 'black');
    }
  })

  $('.create-ticket-input').on('input', function() {
    if ($('#create-ticket-topic').val().length !== 0 && priorityInArray()) {
      $('#create-ticket-submit').prop('disabled', false);
      $('#create-ticket-submit').removeClass('disabled-input')
      $('#create-ticket-submit').addClass('hover-bttn')
    } else {
      $('#create-ticket-submit').prop('disabled', true);
      $('#create-ticket-submit').addClass('disabled-input')
      $('#create-ticket-submit').removeClass('hover-bttn')
    }
  })

  $('.ticket').on('click', function() {
    let text = $(this).children('.ticket-details-outer').children('.ticket-name').text().trim();
    window.location = 'zgłoszenie?ticketId=' + text.substring(0, text.indexOf(' '));
  })
});
