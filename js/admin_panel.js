$(document).ready(function () {
  var forms = $('.forms');
  var actionListBttn = $('.action-list-button-inner');
  var usersEmails;

  actionListBttn.on('click', function () {
    let thisId = $(this).attr('id');
    forms.css('display', 'none');
    $('#' + thisId + '-form').css('display', 'block');
  });

  function appendPermissionsAdd(permissions) {
    let permissionsContainer = $('.permissions-data-add-inner')
    permissionsContainer.empty();
    permissions.forEach(permission => {
      permissionsContainer.append(
        `<div class="permission-add-div">
          <label class="switch">
            <input type="checkbox" name="ua_permission[]" value="${permission[0]}">
            <span class="slider"></span>
          </label>
          <div class="permission-description">
            <p>${permission[1]}</p>
          </div>
        </div>`
      )
    });
  }
  function appendPermissionsEdit(permissions) {
    let permissionsContainer = $('.permissions-data-edit-inner')
    permissionsContainer.empty();
    console.log(permissions)
    permissions.forEach(permission => {
      permissionsContainer.append(
        `<div class="permission-edit-div">
          <label class="switch">
            <input class="edit-input-data" type="checkbox" name="ue_permission[]" value="${permission[0]}">
            <span class="slider"></span>
          </label>
          <div class="permission-description">
            <p>${permission[1]}</p>
          </div>
        </div>`
      )
    });
  }

  $('.role-radio-add').on('change', function () {
    let roleId = $(this).val();

    $.ajax({
      type: "POST",
      url: "utils/getRolePermissions.php",
      data: {
        roleId
      },
      dataType: 'json',
    }).done(function (response) {
      appendPermissionsAdd(response)
    });
  })

  $('.role-radio-edit').on('change', function () {
    let roleId = $(this).val()
    let email = $('#edit-user-email').val()
    console.log(email)
    $.ajax({
      type: "POST",
      url: "utils/getUsersDetails.php",
      data: {
        method: 'getUserDetails',
        email
      },
      dataType: 'json',
    }).done(function (userDetails) {
      $.ajax({
        type: "GET",
        url: "utils/getRolePermissions.php",
        data: {
          roleId
        },
        dataType: 'json',
      }).done(function (response) {
        appendPermissionsEdit(response)
        setUserPermissions(userDetails[0][2]);
      })
    })
  })

  function getUsersEmails() {
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

  function setUserPermissions(userId) {
    $.ajax({
      type: 'GET',
      url: 'utils/getUsersDetails.php',
      data: { method: 'getUserPermissions', userId },
      dataType: 'json',
    }).done(function (permissions) {
      permissions.forEach(permission => {
        $(`input[name='ue_permission[]'][value='${permission[0]}']`).prop('checked', true)
      })
    });
  }

  function getRolePermissions(roleId, userId) {
    $.ajax({
      type: 'GET',
      url: 'utils/getUsersDetails.php',
      data: { method: 'getRolePermissions', roleId },
      dataType: 'json',
    }).done(function (permissions) {
      permissions.forEach(permission => {
        $(".permissions-data-edit-inner").append(
          `<div class="permission-edit-div">
            <label class="switch">
              <input class="edit-input-data" type="checkbox" name="ue_permission[]" value="${permission[0]}">
              <span class="slider"></span>
            </label>
            <div class="permission-description">
              <p>${permission[1]}</p>
            </div>
          </div>`
        );
      })

      setUserPermissions(userId);
    });
  }

  function getUserDetails(email) {
    $.ajax({
      type: 'POST',
      url: 'utils/getUsersDetails.php',
      data: { method: 'getUserDetails', email },
      dataType: 'json',
    }).done(function (details) {
      details = details[0];
      $('#edit-user-name').val(details[0]);
      $('#edit-user-surname').val(details[1]);
      $('#edit-user-email').val(details[3]);
      $('#edit-user-password').val(details[4]);
      $(`input[name=ue_role][value='${details[5]}']`).prop('checked', true);

      getRolePermissions(details[5], details[2]);
    });
  }

  $('#edit-user').on('click', function () {
    if ($('#user-emails-list-input').val().length == 0) {
      $('.edit-input-data').prop('disabled', true);
    }
    getUsersEmails()
  });

  $('#user-emails-list-input').on('change', function () {
    $('.edit-input-data').prop('disabled', false);
    getUserDetails(this.value);
  })

  /* Roles */
  function getRolesNames() {
    $.ajax({
      type: 'GET',
      url: 'utils/role_utils.php',
      data: { method: 'getRolesNames' },
      dataType: 'json',
    }).done(function (names) {
      $('#roles-names-list').empty();
      names.forEach(name => {
        let nameOption = document.createElement('option');
        nameOption.innerHTML = name[0];
        $('#roles-names-list').append(nameOption);
      })
    });
  }

  function setRoleNameAndPermissions() {
    let roleName = $('#roles-names-list-input').val()
    $('#edit-role-name').val(roleName)

    $.ajax({
      type: 'GET',
      url: 'utils/getUsersDetails.php',
      data: { method: 'getRolePermissionsByName', roleName },
      dataType: 'json',
    }).done(function (permissions) {
      permissions.forEach(permission => {
        $(".permissions-data-role-edit-inner").append(
          `<div class="permission-role-edit-div">
            <label class="switch">
              <input class="edit-input-data" type="checkbox" name="re_permission[]" value="${permission[0]}">
              <span class="slider"></span>
            </label>
            <div class="permission-description">
              <p>${permission[1]}</p>
            </div>
          </div>`
        );
      })

      // setRolePermissions(roleName);
    });
  }

  $('#edit-role').on('click', function () {
    if ($('#roles-names-list-input').val().length == 0) {
      $('.edit-role-input-data').prop('disabled', true);
    }
    getRolesNames()
  });

  $('#roles-names-list-input').on('change', function () {
    $('.edit-role-input-data').prop('disabled', false);
    setRoleNameAndPermissions()
  })

  $(document).on("keydown", "form", function (event) {
    return event.key != "Enter";
  });
});
