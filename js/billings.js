$(document).ready(function () {
  var fieldIndex = 0;

  function addUsersEmail() {
    $.ajax({
      type: 'GET',
      url: 'utils/getUsersDetails.php',
      data: { method: 'getUsersEmails' },
      dataType: 'json',
    }).done(function (emails) {
      $('#users-emails-list').empty();
      emails.forEach(email => {
        let emailOption = document.createElement('option');
        emailOption.innerHTML = email[0];
        $('#users-emails-list').append(emailOption);
      })
    });
  }

  if($('#add-report-div').css('display') != 'none') {
    addUsersEmail();
  }

  $("#search-report-input").on("keyup", function() {
    var value = this.value.toLowerCase().trim();
    $(".report-name").show().filter(function() {
      return $(this)[0].value.toLowerCase().trim().indexOf(value) == -1;
    }).hide();
  });

  $('#add-field').on('click', function() {
    $('#fees-container-inner').append(
      `<div class="fee-div">
        <label>
          <input class="fee-name" name="fee-name-${fieldIndex}" placeholder="Nazwa opłaty">
          <input class="fee-value" name="fee-value-${fieldIndex}">
        </label>
        <div id="fee-categories">
        <label>
          <p>stała</p>
          <input type="radio" name="fee-category-${fieldIndex}" class="fee-category" value="fixed">
        </label>
        <label>
          <p>kwartalna</p>
          <input type="radio" name="fee-category-${fieldIndex}" class="fee-category" value="quarterly">
        </label>
        <label>
          <p>długoterminowa</p>
          <input type="radio" name="fee-category-${fieldIndex}" class="fee-category" value="long-term">
        </label>
        <label>
          <p>niezaplanowana</p>
          <input type="radio" name="fee-category-${fieldIndex}" class="fee-category" value="unplanned">
        </label>
        </div>
      </div>`
    )
    fieldIndex++;
  })

  $("input[name='report-permission'][value='occupant']").on('click', function() {
    $('.search-user').css('display', 'inline-block');

    addUsersEmail();
  })

  $("input[name='report-permission'][value='association']").on('click', function() {
    $('.search-user').css('display', 'none');
    console.log('association pressed');
  })
});
