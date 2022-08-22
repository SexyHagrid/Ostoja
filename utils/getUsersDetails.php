<?php

  require_once './user.php';
  require_once './role.php';
  require_once './permissions.php';

  if(isset($_POST['method'])) {
    $method = htmlspecialchars($_POST['method']);
    switch($method) {
      case 'getUserDetails':
        $email = htmlspecialchars($_POST['email']);
        echo json_encode(User::getUserDetails($email));
        break;
    }
  } elseif (isset($_GET['method'])) {
    $method = htmlspecialchars($_GET['method']);
    switch($method) {
      case 'getUsersEmails':
        echo json_encode(User::getUsersEmails());
        break;

      case 'getRolePermissions':
        $roleId = htmlspecialchars($_GET['roleId']);
        echo json_encode(Permissions::getPermissionsByRole($roleId));
        break;

      case 'getRolePermissionsByName':
        $roleName = htmlspecialchars($_GET['roleName']);
        $roleId = Role::getRoleIdByName($roleName);
        echo json_encode(Permissions::getPermissionsByRole($roleId['roleId']));
        break;

      case 'getUserPermissions':
        $userId = htmlspecialchars($_GET['userId']);
        echo json_encode(Permissions::getPermissionsByUser($userId));
        break;
    }
  }

?>