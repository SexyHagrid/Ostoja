$(document).ready(function () {
  let canceledComment = false;
  let clickedComment = false;
  let commentText = '';

  $('.ticket-details-status-inner').width($('#ticket-details-status-inner-h4').width()+20);

  let statusColor = 'linear-gradient(45deg, #eeeeee, #f7f5f5, #eeeeee)';
  switch ($('#ticket-details-status-inner-h4').text()) {
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
  $('.ticket-details-status-outer').css('visibility', 'visible');

  function fetchNewComments() {
    let ticketId = $('.active').text().trim().substring(4);
    let latestTicketDate = $('.ticket-comment-outer:first').children('.ticket-comment-inner').children('.tcilu').children('.ticket-comment-label-date').text().trim();

    $.ajax({
      type: "POST",
      url: "utils/fetchTicketComments.php",
      data: {
        ticketId,
        latestTicketDate
      },
      dataType: 'json'
    }).done(function(response) {
      if (response.success === true) {
        response.data.forEach(function(comment) {
          $('.ticket-comments-comments').prepend(`
          <div class="ticket-comment-outer">
            <div class="ticket-comment-inner">
              <div class="ticket-comment-inner-label-${comment.reporter}-user">
                <p class="ticket-comment-label-name">${comment.userName} ${comment.userSurname}</p>
                <p class="ticket-comment-label-date"> ${comment.commentDate}</p>
              </div>
              <div class="ticket-comment-inner-text">
                ${comment.commentText.replace(/\n/g,'<br/>')}
              </div>
            </div>
          </div>`);
        })
      }

      setTimeout(fetchNewComments, 60000);
    })
  }

  $(".ticket-comments-add-comment").on('click', function() {
    clickedComment = true;
  });

  $(document).on('click', function() {
    if (clickedComment) {
      if (!canceledComment) {
        $('#ticket-comment-add').css('height', '15vh');
        $('.buttons-div').css('display', 'block');

        if (commentText) {
          $('#ticket-comment-add').val(commentText);
        }
      }

      canceledComment = false;
      clickedComment = false;
    } else {
      if ($('.buttons-div').css('display') !== 'none') {
        commentText = $('#ticket-comment-add').val();

        if (commentText.length > 0) {
          $('#ticket-comment-add').prop('placeholder', '* Dodaj komentarz...');
        }

        $('#ticket-comment-add').val('');
        $('#ticket-comment-add').css('height', '7vh');
        $('.buttons-div').css('display', 'none');
      }
    }
  })

  function emptyCommentInput() {
    canceledComment = true;
    commentText = '';

    $('#ticket-comment-add').val('');
    $('#ticket-comment-add').prop('placeholder', 'Dodaj komentarz...');
    $('#ticket-comment-add').css('height', '7vh');
    $('.buttons-div').css('display', 'none');
  }

  $('#cancel-add-comment').on('click', function() {
    emptyCommentInput();
  })

  $('#submit-add-comment').on('click', function() {
    let ticketId = $('.active').text().trim().substring(4);
    let commentText = $('#ticket-comment-add').val();

    $.ajax({
      type: "POST",
      url: "utils/ticketDetails.php",
      data: {
        ticketId,
        commentText
      },
      dataType: 'json'
    }).done(function(response) {
      if (response.success) {
        $('.ticket-comments-comments').prepend(`
        <div class="ticket-comment-outer">
          <div class="ticket-comment-inner">
            <div class="tcilu ticket-comment-inner-label-c-user">
              <p class="ticket-comment-label-name">${response.data.userName} ${response.data.userSurname}</p>
              <p class="ticket-comment-label-date"> ${response.data.commentDate}</p>
            </div>
            <div class="ticket-comment-inner-text">
              ${response.data.commentText.replace(/\n/g,'<br/>')}
            </div>
          </div>
        </div>`);

        emptyCommentInput();
      }
    })
  })

  $('#ticket-comment-add').on('input', function() {
    if ($(this).val().length !== 0) {
      $('#submit-add-comment').prop('disabled', false);
      $('#submit-add-comment').removeClass('disabled-input')
      $('#submit-add-comment').addClass('hover-bttn')
    } else {
      $('#submit-add-comment').prop('disabled', true);
      $('#submit-add-comment').addClass('disabled-input')
      $('#submit-add-comment').removeClass('hover-bttn')
    }
  })

  fetchNewComments();
});