<?php

  include_once 'config/db_connect.php';
  include_once 'config/messages.php';
  include_once 'utils/permissions.php';

  $errors = ['ua_name' => '', 'ua_surname' => '', 'ua_email' => '', 'ua_password' => '', 'ua_role' => '', 'ra_role' => '', 're_name' => ''];

  $name = $surname = $email = $password = $ua_role = $ue_role = '';
  $permissionsId = $ua_permissions = $ue_permissions = $users_details = [];

  $ra_role = $re_role_name = $re_name = '';
  $ua_permissions = [];

  $dbConn = new DBConnector();
  $stmt = $dbConn->dbRequest("SELECT * FROM roles");
  $stmt->execute();
  $roles = $stmt->fetchAll();

  if (isset($_POST['remove-user-button'])) {
    if (empty($_POST['user-email-edit'])) {
      $error_prompt_message = 'Nie wybrano użytkownika, który ma zostać usunięty';
    }
    else {
      $email = htmlspecialchars($_POST['user-email-edit']);

      $stmt = $dbConn->dbRequest("DELETE FROM users WHERE email='$email'");
      $stmt->execute();
      $conn = null;

      $email = '';
    }
  }

  if (isset($_POST['edit-user-button'])) {
    if (empty($_POST['user-name-edit'])) {
      $errors['ua_name'] = 'Imię jest wymagane';
    } else {
      $name = htmlspecialchars($_POST['user-name']);
    }
    if (empty($_POST['user-surname-edit'])) {
      $errors['ua_surname'] = 'Nazwisko jest wymagane';
    } else {
      $surname = htmlspecialchars($_POST['user-surname']);
    }
    if (empty($_POST['user-email-edit'])) {
      $errors['ua_email'] = 'Email jest wymagany';
    } else {
      $email = htmlspecialchars($_POST['user-email']);
    }
    if (empty($_POST['user-password-edit'])) {
      $errors['ua_password'] = 'Hasło jest wymagane';
    } else {
      $password = htmlspecialchars($_POST['user-password']);
    }
    if (empty($_POST['role'])) {
      $errors['ua_role'] = 'Rola jest wymagana';
    } else {
      $ue_role = htmlspecialchars($_POST['ue_role']);
      $ue_permissions = Permissions::getPermissionsByRole($ue_role);
    }
    if (!empty($_POST['ue_permissions'])) {
      foreach($_POST['ue_permissions'] as $permission) {
        array_push($permissionsId, $permission);
      }
    }

    if (!array_filter($errors)) {
      try {
        $sql = "UPDATE users SET name='$name', surname='$surname', password='$password', role='$ue_role' WHERE email='$email'";
        $stmt = $dbConn->dbRequest($sql);
        $stmt->execute();

        $stmt = $dbConn->dbRequest("SELECT userId FROM users where email like '$email'");
        $stmt->execute();
        $userId = $stmt->fetchAll();

        foreach($permissionsId as $permissionId) {
          $sql = "INSERT INTO user_permissions (userId, permissionId) VALUES (:userId, :permissionId)";
          $stmt = $dbConn->dbRequest($sql);
          $stmt->execute([':userId'=>$userId[0]['userId'], ':permissionId'=>$permissionId]);
        }

        $notify_prompt_message =  'Dane zostały prawidłowo zmienione';
        $name = $surname = $email = $password = $ue_role = '';
        $permissionsId = $ue_permissions = [];
      } catch(Exception $exp) {
        $error_prompt_message = 'Operacja nie powiodła się '.$exp;
      }
    }
  }

  if (isset($_POST['add-user-button'])) {
    if (empty($_POST['user-name'])) {
      $errors['ua_name'] = 'Imię jest wymagane';
    } else {
      $name = htmlspecialchars($_POST['user-name']);
    }
    if (empty($_POST['user-surname'])) {
      $errors['ua_surname'] = 'Nazwisko jest wymagane';
    } else {
      $surname = htmlspecialchars($_POST['user-surname']);
    }
    if (empty($_POST['user-email'])) {
      $errors['ua_email'] = 'Email jest wymagany';
    } else {
      $email = htmlspecialchars($_POST['user-email']);
    }
    if (empty($_POST['user-password'])) {
      $errors['ua_password'] = 'Hasło jest wymagane';
    } else {
      $password = htmlspecialchars($_POST['user-password']);
    }
    if (empty($_POST['ua_role'])) {
      $errors['ua_role'] = 'Rola jest wymagana';
    } else {
      $ua_role = htmlspecialchars($_POST['ua_role']);
      $ua_permissions = Permissions::getPermissionsByRole($ua_role);
    }
    if (!empty($_POST['ua_permissions'])) {
      foreach($_POST['ua_permissions'] as $permission) {
        array_push($permissionsId, $permission);
      }
    }

    if (!array_filter($errors)) {
      try {
        $sql = "INSERT INTO users (name, surname, userId, email, password, roleId) VALUES (:name, :surname, :userId, :email, :password, :roleId)";
        $stmt = $dbConn->dbRequest($sql);
        $stmt->execute([':name'=>$name, ':surname'=>$surname, ':userId'=>null, ':email'=>$email, ':password'=>$password, ':roleId'=>$ua_role]);

        $stmt = $dbConn->dbRequest("SELECT userId FROM users where email like '$email'");
        $stmt->execute();
        $userId = $stmt->fetchAll();

        foreach($permissionsId as $permissionId) {
          $sql = "INSERT INTO user_permissions (userId, permissionId) VALUES (:userId, :permissionId)";
          $stmt = $dbConn->dbRequest($sql);
          $stmt->execute([':userId'=>$userId[0]['userId'], ':permissionId'=>$permissionId]);
        }
        $conn = null;

        $notify_prompt_message =  'Użytkownik został prawidłowo dodany';
        $name = $surname = $email = $password = $ua_role = '';
        $permissionsId = $ua_permissions = [];
      } catch(Exception $exp) {
        $error_prompt_message = 'Operacja nie powiodła się '.$exp;
      }
    }
  }

  if (isset($_POST['add-role-button'])) {
    if (empty($_POST['add-role-input'])) {
      $errors['ra_role'] = 'Rola jest wymagana';
    }
    else {
      $ra_role = htmlspecialchars($_POST['add-role-input']);
      $sql = "INSERT INTO roles (roleId, roleName) VALUES (:roleId, :roleName)";
      $stmt = $dbConn->dbRequest($sql);
      $stmt->execute([':roleId'=>null, ':roleName'=>$ra_role]);

      $stmt = $dbConn->dbRequest("SELECT roleName FROM roles where roleName like '$ra_role'");
      $stmt->execute();
      $roles = $stmt->fetchAll();

      if ($roles[0]['roleName'] == $ra_role) {
        $notify_prompt_message =  'Rola została prawidłowo dodana';
      } else {
        $error_prompt_message = 'Operacja nie powiodła się';
      }

      $ra_role = '';
    }
  }

?>

<!doctype html>
<html>
  <?php include('templates/header.php'); ?>
  <link rel="stylesheet" type="text/less" href="css/admin-panel.less" media="screen" />
  <?php include('templates/body.php'); ?>

        <div class="col-7 page-name">
          <p>Panel administracyjny</p>
        </div>
        <div class="col-2 upper-right-buttons">
          <a href="logout.php"><p>Wyloguj</p></a>
        </div>
      </div>
    </div>

    <div class="row justify-content-center main-content-row">
      <div class="actions-bar">
        <div class="col-2 action">
          <div class="action-inner">
            <p>Użytkownicy</p>
            <div class="subactions user-list">
              <div class="user-list-button-outer">
                <div class="action-list-button-inner" id="add-user"><p>Dodaj</p></div>
              </div>
              <div class="user-list-button-outer">
                <div class="action-list-button-inner" id="edit-user"><p>Edytuj</p></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-2 action">
          <div class="action-inner">
            <p>Role</p>
            <div class="subactions role-list">
              <div class="user-list-button-outer">
                <div class="action-list-button-inner" id="add-role"><p>Dodaj</p></div>
              </div>
              <div class="user-list-button-outer">
                <div class="action-list-button-inner" id="edit-role"><p>Edytuj</p></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-2 action">
          <div class="action-inner">
            <p>Permisje</p>
            <div class="subactions permission-list">
              <div class="user-list-button-outer">
                <div class="action-list-button-inner"><p>Dodaj</p></div>
              </div>
              <div class="user-list-button-outer">
                <div class="action-list-button-inner"><p>Edytuj</p></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="w-100"></div>

      <div class="col-7 admin-panel-main-body">
        <!-- Add user -->
        <form class="forms" id="add-user-form" action="admin_panel.php" method="post">
          <div class="col-12 user-data-outer">
            <p>Dane użytkownika:</p>
            <div class="col-12 user-data-inner">
              <div class="col-5 user-data-divs user-data-name-surname">
                <div class="ua-input-outer">
                  <label for="user-name">Imię:</label>
                  <div class="red-text"><?php echo $errors['ua_name']; ?></div>
                  <input type="text" name="user-name" value="<?php echo htmlspecialchars($name); ?>">
                </div>
                <div class="ua-input-outer">
                  <label for="user-surname">Nazwisko:</label>
                  <span class="red-text"><?php echo $errors['ua_surname']; ?></span>
                  <input type="text" name="user-surname" value="<?php echo htmlspecialchars($surname); ?>">
                </div>
              </div>
              <div class="col-5 user-data-divs user-data-email-pass">
                <div class="ua-input-outer">
                  <label for="user-email">Adres email:</label>
                  <div class="red-text"><?php echo $errors['ua_email']; ?></div>
                  <input type="text" name="user-email" value="<?php echo htmlspecialchars($email); ?>">
                </div>
                <div class="ua-input-outer">
                  <label for="user-password">Hasło:</label>
                  <div class="red-text"><?php echo $errors['ua_password']; ?></div>
                  <input type="text" name="user-password" value="<?php echo htmlspecialchars($password); ?>">
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 role-data-outer">
            <p>Rola:</p>
            <div class="red-text"><?php echo $errors['ua_role']; ?></div>
            <div class="col-12 role-data-inner">
              <?php foreach($roles as $role) { ?>
                <div class="role-inner-div">
                  <input type="radio" name="ua_role" class="role-radio-add" value="<?php echo $role['roleId'] ?>" <?php if ($role['roleId'] == $ua_role) echo 'checked'; ?>>
                  <label for="ua_role"><?php echo $role['roleName'] ?></label>
                </div>
              <?php } ?>
            </div>
          </div>
          <div class="col-12 permissions-data-add-outer">
            <p>Permisje:</p>
            <div class="col-12 permissions-data-add-inner">
              <?php if (!empty($ua_permissions)): ?>
                <?php foreach($ua_permissions as $permission): ?>
                  <div class="permission-add-div">
                    <label class="switch">
                      <input type="checkbox" name="ua_permission[]" value="<?php echo $permission['permissionId'] ?>" <?php if(in_array($permission['permissionId'], $permissionsId)) { echo 'checked'; } ?>>
                      <span class="slider"></span>
                    </label>
                    <div class="permission-description">
                      <p><?php echo $permission['permissionDesc'] ?></p>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>

          <div id="buttons-div">
            <input id="add-user-button" type="submit" name="add-user-button" value="Dodaj użytkownika">
          </div>
        </form>

        <!-- Edit user -->
        <form class="forms" id="edit-user-form" action="admin_panel.php" method="post">
          <div class="search-user">
            <input type="text" list="users-emails-list" id="user-emails-list-input" placeholder="Wprowadź adres email..."/>

            <datalist id="users-emails-list">
              <?php foreach($users_details as $user_details): ?>
                <option><?php echo $user_details['email']; ?></option>
              <?php endforeach; ?>
            </datalist>
          </div>

          <div class="col-12 user-data-outer">
            <p>Dane użytkownika:</p>
            <div class="col-12 user-data-inner">
              <div class="col-5 user-data-divs user-data-name-surname">
                <div class="ua-input-outer">
                  <label for="user-name">Imię:</label>
                  <div class="red-text"><?php echo $errors['ua_name']; ?></div>
                  <input class="edit-input-data" id="edit-user-name" type="text" name="user-name-edit" value="<?php echo htmlspecialchars($name); ?>">
                </div>
                <div class="ua-input-outer">
                  <label for="user-surname">Nazwisko:</label>
                  <span class="red-text"><?php echo $errors['ua_surname']; ?></span>
                  <input class="edit-input-data" id="edit-user-surname" type="text" name="user-surname-edit" value="<?php echo htmlspecialchars($surname); ?>">
                </div>
              </div>
              <div class="col-5 user-data-divs user-data-email-pass">
                <div class="ua-input-outer">
                  <label for="user-email">Adres email:</label>
                  <div class="red-text"><?php echo $errors['ua_email']; ?></div>
                  <input id="edit-user-email" type="text" name="user-email-edit" value="<?php echo htmlspecialchars($email); ?>" disabled>
                </div>
                <div class="ua-input-outer">
                  <label for="user-password">Hasło:</label>
                  <div class="red-text"><?php echo $errors['ua_password']; ?></div>
                  <input class="edit-input-data" id="edit-user-password" type="text" name="user-password-edit" value="<?php echo htmlspecialchars($password); ?>">
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 role-data-outer">
            <p>Rola:</p>
            <div class="red-text"><?php echo $errors['ua_role']; ?></div>
            <div class="col-12 role-data-inner">
              <?php foreach($roles as $role) { ?>
                <div class="role-inner-div">
                  <input type="radio" name="ue_role" class="role-radio-edit edit-input-data" value="<?php echo $role['roleId'] ?>" <?php if ($role['roleId'] == $ua_role) echo 'checked'; ?>>
                  <label for="ue_role"><?php echo $role['roleName'] ?></label>
                </div>
              <?php } ?>
            </div>
          </div>
          <div class="col-12 permissions-data-edit-outer">
            <p>Permisje:</p>
            <div class="col-12 permissions-data-edit-inner">
              <?php if (!empty($ue_permissions)): ?>
                <?php foreach($ue_permissions as $permission): ?>
                  <div class="permission-edit-div">
                    <label class="switch">
                      <input class="edit-input-data" type="checkbox" name="ue_permission[]" value="<?php echo $permission['permissionId'] ?>" <?php if(in_array($permission['permissionId'], $permissionsId)) { echo 'checked'; } ?>>
                      <span class="slider"></span>
                    </label>
                    <div class="permission-description">
                      <p><?php echo $permission['permissionDesc'] ?></p>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>

          <div id="buttons-div">
            <input id="remove-user-button" type="submit" name="remove-user-button" value="Usuń">
            <input id="edit-user-button" type="submit" name="edit-user-button" value="Edytuj">
          </div>
        </form>

        <!-- Add role -->
        <form class="forms" id="add-role-form" action="admin_panel.php" method="post">
          <div class="col-12 add-role-data-outer">
            <label for="add-role-label">Dodaj rolę:</label>
            <div class="red-text"><?php echo $errors['ra_role']; ?></div>
            <input id="add-role-input" type="text" name="add-role-input" value="<?php echo htmlspecialchars($ra_role); ?>">
          </div>

          <div id="buttons-div">
            <input id="add-role-button" type="submit" name="add-role-button" value="Dodaj rolę">
          </div>
        </form>

       <!-- Edit role -->
       <form class="forms" id="edit-role-form" action="admin_panel.php" method="post">
          <div class="search-role">
            <input type="text" list="roles-names-list" id="roles-names-list-input" placeholder="Wprowadź rolę..."/>

            <datalist id="roles-names-list">
              <?php foreach($role_names as $role_name): ?>
                <option><?php echo $role_name['roleName']; ?></option>
              <?php endforeach; ?>
            </datalist>
          </div>

          <div class="col-12 user-data-outer">
            <div class="col-12 user-data-inner">
              <div class="re-input-outer">
                <label for="role-name">Nazwa roli:</label>
                <div class="red-text"><?php echo $errors['re_name']; ?></div>
                <input class="edit-role-input-data" id="edit-role-name" type="text" name="role-name-edit" value="<?php echo htmlspecialchars($re_role_name); ?>">
              </div>
            </div>
          </div>
          <div class="col-12 permissions-data-role-edit-outer">
            <p>Permisje:</p>
            <div class="col-12 permissions-data-role-edit-inner">
              <?php if (!empty($re_permissions)): ?>
                <?php foreach($re_permissions as $permission): ?>
                  <div class="permission-role-edit-div">
                    <label class="switch">
                      <input class="edit-role-input-data" type="checkbox" name="re_permission[]" value="<?php echo $permission['permissionId'] ?>" <?php if(in_array($permission['permissionId'], $permissionsId)) { echo 'checked'; } ?>>
                      <span class="slider"></span>
                    </label>
                    <div class="permission-description">
                      <p><?php echo $permission['permissionDesc'] ?></p>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>

          <div id="buttons-div">
            <input id="remove-user-button" type="submit" name="remove-user-button" value="Usuń">
            <input id="edit-user-button" type="submit" name="edit-user-button" value="Edytuj">
          </div>
        </form>
      </div>
    </div>

    <?php include('templates/footer.php'); ?>
    <script src="js/admin_panel.js"></script>
  </body>
</html>