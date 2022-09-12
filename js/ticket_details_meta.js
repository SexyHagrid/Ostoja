$(document).ready(function () {
  let usersEmails = [];
  let priorities = ['Krytyczny', 'Wysoki', 'Średni', 'Niski'];
  let ticketTypes = ['Awarie', 'Błąd na stronie', 'Usprawnienie strony', 'Konto użytkownika'];
  let ticketId = $('.active').text().trim().substring(4);
  let ticketDescription = $('.ticket-details-description').val();

  $('.tdd-ta').css('height', ($('.tdd-ta').prop('scrollHeight')) + "px");

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
        $('#ticket-details-meta-date-update-value').text(response.data.ticketDateUpdate);
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
          } else {
            $('#ticket-details-meta-date-update-value').text(response.data.ticketDateUpdate);
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
          } else {
            $('#ticket-details-meta-date-update-value').text(response.data.ticketDateUpdate);
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
          } else {
            $('#ticket-details-meta-date-update-value').text(response.data.ticketDateUpdate);
          }
        })
      }
    })
  })

  $('.ticket-details-status-outer').on('click', function() {
    let status = $('#ticket-details-status-inner-h4').text();
    if (status === 'ZAKOŃCZONY' || status === 'ANULOWANY') {
      $('input[name="change-ticket-status"][value="OTWARTY"]').prop('disabled', true);
      $('input[name="change-ticket-status"][value="W TRAKCIE"]').prop('disabled', true);

    }

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
        $('#ticket-details-meta-date-update-value').text(response.data.ticketDateUpdate);
        $('#ticket-details-meta-date-end').css('display', 'block');
        $('#ticket-details-meta-date-end-value').text(response.data.ticketDateEnd);

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

  let clickedDescription = false;
  let canceledDescription = false;
  $(".ticket-details-description-outer").on('click', function() {
    clickedDescription = true;
  });

  $(document).on('click', function() {
    if (clickedDescription) {
      if (!canceledDescription) {
        $('.buttons-div-tdd-ta').css('display', 'block');
      }

      canceledDescription = false;
      clickedDescription = false;
    } else {
      $('.buttons-div-tdd-ta').css('display', 'none');
    }
  })

  function cancelEditDescription() {
    $('.ticket-details-description').val(ticketDescription);
    $('.buttons-div-tdd-ta').css('display', 'none');
  }

  $('#cancel-edit-description').on('click', function() {
    canceledDescription = true;
    cancelEditDescription();
  })

  $('#submit-edit-description').on('click', function() {
    let ticketDescriptionEdit = $('.ticket-details-description').val();

    $.ajax({
      type: "POST",
      url: "utils/ticketDetails.php",
      data: {
        ticketId,
        method: 'changeTicketDescription',
        ticketDescription: ticketDescriptionEdit
      },
      dataType: 'json'
    }).done(function(response) {
      if (response.success) {
        $('#ticket-details-meta-date-update-value').text(response.data.ticketDateUpdate);
        $('.buttons-div-tdd-ta').css('display', 'none');
        ticketDescription = $('.ticket-details-description').val();
      } else {
        cancelEditDescription();
      }
    })
  })
});
