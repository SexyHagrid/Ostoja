$(document).ready(function () {
  let usersEmails = [];
  let priorities = ['Krytyczny', 'Wysoki', 'Średni', 'Niski'];
  let ticketTypes = ['Awarie', 'Błąd na stronie', 'Usprawnienie strony', 'Konto użytkownika'];
  let ticketId = $('.active').text().trim().substring(4);

  function getUsersByRole() {
    $.ajax({
      type: "GET",
      url: "utils/getDetails.php",
      data: {
        roleName: 'Wsparcie techniczne',
        method: 'getEmailsByRoleName'
      },
      dataType: 'json'
    }).done(function(response) {
      if (response.success) {
        response.data.forEach(function(email) {
          usersEmails.push(email.email);
        })
      }
    })
  }
  getUsersByRole();

  $('#assign-to-me').on('click', function() {
    $.ajax({
      type: "POST",
      url: "utils/ticketDetails.php",
      data: {
        ticketId,
        method: 'assignCurrent'
      },
      dataType: 'json'
    }).done(function(response) {
      if (response.success) {
        $('#ticket-meta-details-assignee').val(response.data.email);
      }
    })
  })

  $('#ticket-meta-details-assignee').on('input', function() {
    let userEmail = $('#ticket-meta-details-assignee').val().trim();

    usersEmails.forEach(email => {
      if (email == userEmail) {
        $.ajax({
          type: "POST",
          url: "utils/ticketDetails.php",
          data: {
            ticketId,
            method: 'assignAssignee',
            userEmail
          },
          dataType: 'json'
        }).done(function(response) {
          if (!response.success) {
            $('#ticket-meta-details-assignee').val();
          }
        })
      }
    })
  })

  $('#ticket-meta-details-priority').on('input', function() {
    let priority = $('#ticket-meta-details-priority').val().trim();

    priorities.forEach(prio => {
      if (prio == priority) {
        $.ajax({
          type: "POST",
          url: "utils/ticketDetails.php",
          data: {
            ticketId,
            method: 'changeTicketPriority',
            priority
          },
          dataType: 'json'
        }).done(function(response) {
          if (!response.success) {
            $('#ticket-meta-details-priority').val();
          }
        })
      }
    })
  })

  $('#ticket-meta-details-type').on('input', function() {
    let ticketType = $('#ticket-meta-details-type').val().trim();

    ticketTypes.forEach(type => {
      if (type == ticketType) {
        $.ajax({
          type: "POST",
          url: "utils/ticketDetails.php",
          data: {
            ticketId,
            method: 'changeTicketType',
            ticketType
          },
          dataType: 'json'
        }).done(function(response) {
          if (!response.success) {
            $('#ticket-meta-details-type').val();
          }
        })
      }
    })
  })

  $('.ticket-details-status-outer').on('click', function() {
    $('.curtain').css('display', 'block');
    $('.change-ticket-status').css('display', 'block');
  })

  $('#close-curtain').on('click', function() {
    $('.curtain').css('display', 'none');
    $('.change-ticket-status').css('display', 'none');
  })

  $('#change-ticket-status-submit').on('click', function() {
    let ticketStatus = $('input[name="change-ticket-status"]:checked').val().trim();

    $.ajax({
      type: "POST",
      url: "utils/ticketDetails.php",
      data: {
        ticketId,
        method: 'changeTicketStatus',
        ticketStatus
      },
      dataType: 'json'
    }).done(function(response) {
      if (response.success === true) {
        $('#ticket-details-status-inner-h4').text(ticketStatus);
        let statusColor = 'linear-gradient(45deg, #eeeeee, #f7f5f5, #eeeeee)';
        switch (ticketStatus) {
          case 'W TRAKCIE':
            statusColor = 'linear-gradient(45deg, #faf8e9, #e6e3cc, #faf8e9)';
            break;

          case 'ZAKOŃCZONY':
            statusColor = 'linear-gradient(45deg, #a7cc61, #d0e6a6, #a7cc61)';
            break;

          case 'ANULOWANY':
            statusColor = 'linear-gradient(45deg, #e45046, #cc4137, #e45046)';
            break;

          case 'OTWARTY':
          default:
            statusColor = 'linear-gradient(45deg, #eeeeee, #f7f5f5, #eeeeee)';
            break;
        }
        $('.ticket-details-status-inner').css('background', statusColor);
      }

      $('.curtain').css('display', 'none');
      $('.change-ticket-status').css('display', 'none');
    })
  })
});
