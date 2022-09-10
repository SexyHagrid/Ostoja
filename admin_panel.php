<?php

  session_start();
  if (!isset($_SESSION["loggedin"]) || $_SESSION['loggedin'] !== true) {
    header('Location: witaj');
  }

  include_once 'config/db_connect.php';
  include_once 'config/messages.php';
  include_once 'utils/permissions.php';
  include_once 'utils/breadcrumbs.php';

  if (!Permissions::hasPermission("Panel administracyjny")) {
    header('Location: hub');
  }

  $errors = ['ua_name' => '', 'ua_surname' => '', 'ua_email' => '', 'ua_password' => '', 'ua_role' => '',
              'ue_name' => '', 'ue_surname' => '', 'ue_email' => '', 'ue_password' => '', 'ue_role' => '',
              'ra_role' => '', 're_name' => '', 'pa_desc' => '', 'pe_desc' => ''];

  $ua_name = $ua_surname = $ua_email = $ua_password = $ua_role = '';
  $ue_name = $ue_surname = $ue_email = $ue_password = $ue_role = '';
  $permissionsId = $ua_permissions = $ue_permission = $users_details = $re_permission = $rolesIds = [];

  $ra_role = $re_role_name = $re_name = '';
  $pa_desc = $pe_desc = $pe_permission_desc = '';

  $ua_show = $ue_show = $ra_show = $re_show = $pa_show = $pe_show = false;

  $dbConn = new DBConnector();
  $stmt = $dbConn->dbRequest("SELECT * FROM roles");
  $stmt->execute();
  $roles = $stmt->fetchAll();

  if (isset($_POST['remove-user-button'])) {
    $ue_show = true;
    if (empty($_POST['user-emails-list-input'])) {
      $error_prompt_message = 'Nie wybrano użytkownika, który ma zostać usunięty';
    }
    else {
      $ue_email = htmlspecialchars($_POST['user-emails-list-input']);

      $stmt = $dbConn->dbRequest("DELETE FROM users WHERE email='$ue_email'");
      $stmt->execute();
      $conn = null;

      $ue_email = '';
    }
  }

  if (isset($_POST['remove-role-button'])) {
    $re_show = true;
    if (empty($_POST['role-name-edit'])) {
      $error_prompt_message = 'Nie wybrano roli, która ma zostać usunięta';
    }
    else {
      $roleName = htmlspecialchars($_POST['role-name-edit']);

      $stmt = $dbConn->dbRequest("DELETE FROM roles WHERE roleName='$roleName'");
      $stmt->execute();
      $conn = null;
    }
  }

  if (isset($_POST['remove-permission-button'])) {
    $pe_show = true;
    if (empty($_POST['permission-desc-edit'])) {
      $error_prompt_message = 'Nie wybrano permisji, która ma zostać usunięta';
    }
    else {
      $permissionDesc = htmlspecialchars($_POST['permission-desc-edit']);

      $stmt = $dbConn->dbRequest("DELETE FROM permissions WHERE permissionDesc='$permissionDesc'");
      $stmt->execute();
      $conn = null;
    }
  }

  if (isset($_POST['edit-user-button'])) {
    $ue_show = true;
    if (empty($_POST['user-name-edit'])) {
      $errors['ue_name'] = 'Imię jest wymagane';
    } else {
      $ue_name = htmlspecialchars($_POST['user-name-edit']);
    }
    if (empty($_POST['user-surname-edit'])) {
      $errors['ue_surname'] = 'Nazwisko jest wymagane';
    } else {
      $ue_surname = htmlspecialchars($_POST['user-surname-edit']);
    }
    if (empty($_POST['user-email-edit'])) {
      $errors['ue_email'] = 'Email jest wymagany';
    } else {
      $ue_email = htmlspecialchars($_POST['user-email-edit']);
    }
    if (empty($_POST['user-password-edit'])) {
      $errors['ue_password'] = 'Hasło jest wymagane';
    } else {
      $ue_password = htmlspecialchars($_POST['user-password-edit']);
    }
    if (empty($_POST['ue_role'])) {
      $errors['ue_role'] = 'Rola jest wymagana';
    } else {
      $ue_role = htmlspecialchars($_POST['ue_role']);
      $ue_permissions = Permissions::getPermissionsByRole($ue_role);
    }
    if (!empty($_POST['ue_permission'])) {
      foreach($_POST['ue_permission'] as $permission) {
        array_push($permissionsId, $permission);
      }
    }

    if (!array_filter($errors)) {
      try {
        $old_email = $_POST['user-emails-list-input'];
        $sql = "UPDATE users SET name='$ue_name', surname='$ue_surname', email='$ue_email', password='$ue_password', roleId='$ue_role' WHERE email='$old_email'";
        $stmt = $dbConn->dbRequest($sql);
        $stmt->execute();

        $stmt = $dbConn->dbRequest("SELECT userId FROM users where email like '$ue_email'");
        $stmt->execute();
        $userId = $stmt->fetchAll();

        foreach($permissionsId as $permissionId) {
          $sql = "INSERT INTO user_permissions (userId, permissionId) VALUES (:userId, :permissionId)";
          $stmt = $dbConn->dbRequest($sql);
          $stmt->execute([':userId'=>$userId[0]['userId'], ':permissionId'=>$permissionId]);
        }

        $notify_prompt_message =  'Dane zostały prawidłowo zmienione';
        $ue_name = $ue_surname = $ue_email = $ue_password = $ue_role = '';
        $permissionsId = $ue_permissions = [];
      } catch(Exception $exp) {
        $error_prompt_message = 'Operacja nie powiodła się '.$exp;
      }
    }
  }

  if (isset($_POST['edit-role-button'])) {
    $re_show = true;
    if (empty($_POST['role-name-edit'])) {
      $errors['re_name'] = 'Nazwa roli jest wymagana';
    } else {
      $re_name = htmlspecialchars($_POST['role-name-edit']);
    }

    if (!empty($_POST['re_permission'])) {
      foreach($_POST['re_permission'] as $permission) {
        array_push($permissionsId, $permission);
      }
    }

    if (!array_filter($errors)) {
      try {
        $oldRoleName = $_POST['roles-names-list-input'];
        $sql = "UPDATE roles SET roleName='$re_name' WHERE roleName='$oldRoleName'";
        $stmt = $dbConn->dbRequest($sql);
        $stmt->execute();

        $stmt = $dbConn->dbRequest("SELECT roleId FROM roles where roleName like '$re_name'");
        $stmt->execute();
        $roleResult = $stmt->fetchAll();
        $roleId = $roleResult[0]['roleId'];

        $stmt = $dbConn->dbRequest("DELETE FROM role_permissions WHERE roleId='$roleId'");
        $stmt->execute();

        foreach($permissionsId as $permissionId) {
          $sql = "INSERT INTO role_permissions (roleId, permissionId) VALUES (:roleId, :permissionId)";
          $stmt = $dbConn->dbRequest($sql);
          $stmt->execute([':roleId'=>$roleId, ':permissionId'=>$permissionId]);
        }

        $notify_prompt_message =  'Dane zostały prawidłowo zmienione';
        $re_name = '';
        $permissionsId = $re_permission = [];
      } catch(Exception $exp) {
        $error_prompt_message = 'Operacja nie powiodła się '.$exp;
      }
    }
  }

  if (isset($_POST['edit-permission-button'])) {
    $pe_show = true;
    if (empty($_POST['permission-desc-edit'])) {
      $errors['pe_desc'] = 'Opis permisji jest wymagany';
    } else {
      $pe_desc = htmlspecialchars($_POST['permission-desc-edit']);
    }

    if (!empty($_POST['pe_role'])) {
      foreach($_POST['pe_role'] as $role) {
        array_push($rolesIds, $role);
      }
    }

    if (!array_filter($errors)) {
      try {
        $oldPermissionDesc = $_POST['permissions-desc-list-input'];
        $sql = "UPDATE permissions SET permissionDesc='$pe_desc' WHERE permissionDesc='$oldPermissionDesc'";
        $stmt = $dbConn->dbRequest($sql);
        $stmt->execute();

        $stmt = $dbConn->dbRequest("SELECT permissionId FROM permissions where permissionDesc like '$pe_desc'");
        $stmt->execute();
        $permissionResult = $stmt->fetchAll();
        $permissionId = $permissionResult[0]['permissionId'];

        $stmt = $dbConn->dbRequest("DELETE FROM role_permissions WHERE permissionId='$permissionId'");
        $stmt->execute();

        foreach($rolesIds as $roleId) {
          $sql = "INSERT INTO role_permissions (roleId, permissionId) VALUES (:roleId, :permissionId)";
          $stmt = $dbConn->dbRequest($sql);
          $stmt->execute([':roleId'=>$roleId, ':permissionId'=>$permissionId]);
        }

        $notify_prompt_message =  'Dane zostały prawidłowo zmienione';
        $pe_desc = '';
        $roldsIds = [];
      } catch(Exception $exp) {
        $error_prompt_message = 'Operacja nie powiodła się '.$exp;
      }
    }
  }

  if (isset($_POST['add-user-button'])) {
    $ua_show = true;
    if (empty($_POST['user-name'])) {
      $errors['ua_name'] = 'Imię jest wymagane';
    } else {
      $ua_name = htmlspecialchars($_POST['user-name']);
    }
    if (empty($_POST['user-surname'])) {
      $errors['ua_surname'] = 'Nazwisko jest wymagane';
    } else {
      $ua_surname = htmlspecialchars($_POST['user-surname']);
    }
    if (empty($_POST['user-email'])) {
      $errors['ua_email'] = 'Email jest wymagany';
    } else {
      $ua_email = htmlspecialchars($_POST['user-email']);
    }
    if (empty($_POST['user-password'])) {
      $errors['ua_password'] = 'Hasło jest wymagane';
    } else {
      $ua_password = htmlspecialchars($_POST['user-password']);
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
        $stmt->execute([':name'=>$ua_name, ':surname'=>$ua_surname, ':userId'=>null, ':email'=>$ua_email, ':password'=>$ua_password, ':roleId'=>$ua_role]);

        $stmt = $dbConn->dbRequest("SELECT userId FROM users where email like '$ua_email'");
        $stmt->execute();
        $userId = $stmt->fetchAll();

        foreach($permissionsId as $permissionId) {
          $sql = "INSERT INTO user_permissions (userId, permissionId) VALUES (:userId, :permissionId)";
          $stmt = $dbConn->dbRequest($sql);
          $stmt->execute([':userId'=>$userId[0]['userId'], ':permissionId'=>$permissionId]);
        }
        $conn = null;

        $notify_prompt_message =  'Użytkownik został prawidłowo dodany';
        $ua_name = $ua_surname = $ua_email = $ua_password = $ua_role = '';
        $permissionsId = $ua_permissions = [];
      } catch(Exception $exp) {
        $error_prompt_message = 'Operacja nie powiodła się '.$exp;
      }
    }
  }

  if (isset($_POST['add-role-button'])) {
    $ra_show = true;
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

  if (isset($_POST['add-permission-button'])) {
    $pa_show = true;
    if (empty($_POST['add-permission-input'])) {
      $errors['pa_desc'] = 'Opis permisji jest wymagany';
    }
    else {
      $pa_desc = htmlspecialchars($_POST['add-permission-input']);
      $sql = "INSERT INTO permissions (permissionId, permissionDesc) VALUES (:permissionId, :permissionDesc)";
      $stmt = $dbConn->dbRequest($sql);
      $stmt->execute([':permissionId'=>null, ':permissionDesc'=>$pa_desc]);

      $stmt = $dbConn->dbRequest("SELECT permissionDesc FROM permissions where permissionDesc like '$pa_desc'");
      $stmt->execute();
      $permissions = $stmt->fetchAll();

      if ($permissions[0]['permissionDesc'] == $pa_desc) {
        $notify_prompt_message =  'Permisja została prawidłowo dodana';
      } else {
        $error_prompt_message = 'Operacja nie powiodła się';
      }

      $pa_desc = '';
    }
  }

?>

<!doctype html>
<html>
  <?php include('templates/header.php'); ?>
  <link rel="stylesheet" type="text/less" href="css/admin-panel.less" media="screen" />
  <?php include('templates/body.php'); ?>

        <div class="col-7 page-name">
          <div id="page-name-outer">
            <div id="breadcrumbs-div">
              <nav class="navbar-expand-lg">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <?php Breadcrumbs::showBreadcrumbs(['page' => 'Panel administracyjny', 'address' => 'panel-administracyjny']); ?>
                  </ol>
                </nav>
              </nav>
            </div>
            <p>Panel administracyjny</p>
          </div>
        </div>
        <div class="col-2 upper-right-buttons">
          <a href="wyloguj"><p id="logout-in-p">Wyloguj</p></a>
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
                <div class="action-list-button-inner" id="add-permission"><p>Dodaj</p></div>
              </div>
              <div class="user-list-button-outer">
                <div class="action-list-button-inner" id="edit-permission"><p>Edytuj</p></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="w-100"></div>

      <div class="col-7 admin-panel-main-body">
        <!-- Add user -->
        <form class="forms" id="add-user-form" action="panel-administracyjny" method="post" <?php if($ua_show) { echo 'style="display: block;"'; } ?>>
          <div class="col-12 user-data-outer">
            <p>Dane użytkownika:</p>
            <div class="col-12 user-data-inner">
              <div class="col-5 user-data-divs user-data-name-surname">
                <div class="ua-input-outer">
                  <label for="user-name">Imię:</label>
                  <div class="red-text"><?php echo $errors['ua_name']; ?></div>
                  <input type="text" name="user-name" value="<?php echo htmlspecialchars($ua_name); ?>">
                </div>
                <div class="ua-input-outer">
                  <label for="user-surname">Nazwisko:</label>
                  <span class="red-text"><?php echo $errors['ua_surname']; ?></span>
                  <input type="text" name="user-surname" value="<?php echo htmlspecialchars($ua_surname); ?>">
                </div>
              </div>
              <div class="col-5 user-data-divs user-data-email-pass">
                <div class="ua-input-outer">
                  <label for="user-email">Adres email:</label>
                  <div class="red-text"><?php echo $errors['ua_email']; ?></div>
                  <input type="text" name="user-email" value="<?php echo htmlspecialchars($ua_email); ?>">
                </div>
                <div class="ua-input-outer">
                  <label for="user-password">Hasło:</label>
                  <div class="red-text"><?php echo $errors['ua_password']; ?></div>
                  <input type="text" name="user-password" value="<?php echo htmlspecialchars($ua_password); ?>">
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
        <form class="forms" id="edit-user-form" action="panel-administracyjny" method="post" <?php if($ue_show) { echo 'style="display: block;"'; } ?>>
          <div class="search-user">
            <input type="text" list="users-emails-list" id="user-emails-list-input" name="user-emails-list-input" placeholder="Wprowadź adres email..."/>

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
                  <div class="red-text"><?php echo $errors['ue_name']; ?></div>
                  <input class="edit-input-data" id="edit-user-name" type="text" name="user-name-edit" value="<?php echo htmlspecialchars($ue_name); ?>">
                </div>
                <div class="ua-input-outer">
                  <label for="user-surname">Nazwisko:</label>
                  <span class="red-text"><?php echo $errors['ue_surname']; ?></span>
                  <input class="edit-input-data" id="edit-user-surname" type="text" name="user-surname-edit" value="<?php echo htmlspecialchars($ue_surname); ?>">
                </div>
              </div>
              <div class="col-5 user-data-divs user-data-email-pass">
                <div class="ua-input-outer">
                  <label for="user-email">Adres email:</label>
                  <div class="red-text"><?php echo $errors['ue_email']; ?></div>
                  <input class="edit-input-data" id="edit-user-email" type="text" name="user-email-edit" value="<?php echo htmlspecialchars($ue_email); ?>">
                </div>
                <div class="ua-input-outer">
                  <label for="user-password">Hasło:</label>
                  <div class="red-text"><?php echo $errors['ue_password']; ?></div>
                  <input class="edit-input-data" id="edit-user-password" type="text" name="user-password-edit" value="<?php echo htmlspecialchars($ue_password); ?>">
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 role-data-outer">
            <p>Rola:</p>
            <div class="red-text"><?php echo $errors['ue_role']; ?></div>
            <div class="col-12 role-data-inner">
              <?php foreach($roles as $role) { ?>
                <div class="role-inner-div">
                  <input type="radio" name="ue_role" class="role-radio-edit edit-input-data" value="<?php echo $role['roleId'] ?>" <?php if ($role['roleId'] == $ue_role) echo 'checked'; ?>>
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
        <form class="forms" id="add-role-form" action="panel-administracyjny" method="post" <?php if($ra_show) { echo 'style="display: block;"'; } ?>>
          <div class="col-12 add-role-data-outer">
            <div class="col-12 add-role-data-inner">
              <label for="add-role-label">Dodaj rolę:</label>
              <div class="red-text"><?php echo $errors['ra_role']; ?></div>
              <input id="add-role-input" type="text" name="add-role-input" value="<?php echo htmlspecialchars($ra_role); ?>">
            </div>
          </div>

          <div id="buttons-div">
            <input id="add-role-button" type="submit" name="add-role-button" value="Dodaj rolę">
          </div>
        </form>

       <!-- Edit role -->
        <form class="forms" id="edit-role-form" action="panel-administracyjny" method="post" <?php if($re_show) { echo 'style="display: block;"'; } ?>>
          <div class="search-role">
            <input type="text" list="roles-names-list" id="roles-names-list-input" name="roles-names-list-input" placeholder="Wprowadź rolę..."/>

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
            <input id="remove-role-button" type="submit" name="remove-role-button" value="Usuń">
            <input id="edit-role-button" type="submit" name="edit-role-button" value="Edytuj">
          </div>
        </form>

        <!-- Add permission -->
        <form class="forms" id="add-permission-form" action="panel-administracyjny" method="post" <?php if($pa_show) { echo 'style="display: block;"'; } ?>>
          <div class="col-12 add-permission-data-outer">
            <div class="col-12 add-permission-data-inner">
              <label for="add-permission-label">Dodaj permisję:</label>
              <div class="red-text"><?php echo $errors['pa_desc']; ?></div>
              <input id="add-permission-input" type="text" name="add-permission-input" value="<?php echo htmlspecialchars($pa_desc); ?>">
            </div>
          </div>

          <div id="buttons-div">
            <input id="add-permission-button" type="submit" name="add-permission-button" value="Dodaj permisję">
          </div>
        </form>

        <!-- Edit permission -->
        <form class="forms" id="edit-permission-form" action="panel-administracyjny" method="post" <?php if($pe_show) { echo 'style="display: block;"'; } ?>>
          <div class="search-role">
            <input type="text" list="permissions-desc-list" id="permissions-desc-list-input" name="permissions-desc-list-input" placeholder="Wprowadź permisję..."/>

            <datalist id="permissions-desc-list">
              <?php foreach($permissions_desc as $permission_desc): ?>
                <option><?php echo $permission_desc['permissionDesc']; ?></option>
              <?php endforeach; ?>
            </datalist>
          </div>

          <div class="col-12 user-data-outer">
            <div class="col-12 user-data-inner">
              <div class="pe-input-outer">
                <label for="permission-desc">Opis permisji:</label>
                <div class="red-text"><?php echo $errors['pe_desc']; ?></div>
                <input class="edit-permission-input-data" id="edit-permission-desc" type="text" name="permission-desc-edit" value="<?php echo htmlspecialchars($pe_permission_desc); ?>">
              </div>
            </div>
          </div>
          <div class="col-12 roles-data-permission-edit-outer">
            <p>Role:</p>
            <div class="col-12 roles-data-permission-edit-inner">
              <?php if (!empty($pe_roles)): ?>
                <?php foreach($pe_roles as $role): ?>
                  <div class="role-permission-edit-div">
                    <label class="switch">
                      <input class="edit-permission-input-data" type="checkbox" name="pe_role[]" value="<?php echo $role['roleId'] ?>" <?php if(in_array($role['roleId'], $rolesIds)) { echo 'checked'; } ?>>
                      <span class="slider"></span>
                    </label>
                    <div class="role-name">
                      <p><?php echo $role['roleName'] ?></p>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>

          <div id="buttons-div">
            <input id="remove-permission-button" type="submit" name="remove-permission-button" value="Usuń">
            <input id="edit-permission-button" type="submit" name="edit-permission-button" value="Edytuj">
          </div>
        </form>
      </div>
    </div>

    <?php include('templates/footer.php'); ?>
    <script src="js/admin_panel.js"></script>
  </body>
</html>