<?php

  require_once './user.php';
  require_once './role.php';
  require_once './permissions.php';
  require_once './meeting.php';

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

      case 'getPermissions':
        echo json_encode(Permissions::getPermissions());
        break;

      case 'getRoles':
        echo json_encode(Role::getRoles());
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

      case 'getRolesByPermissionDesc':
        $permissionDesc = htmlspecialchars($_GET['permissionDesc']);
        echo json_encode(Role::getRolesByPermissionDesc($permissionDesc));
        break;

      case 'getMeeting':
        $meetingDate = htmlspecialchars($_GET['date']);
        echo json_encode(Meeting::getMeeting($meetingDate));
        break;

      case 'deleteMeeting':
        $meetingDate = htmlspecialchars($_GET['date']);
        echo json_encode(Meeting::deleteMeeting($meetingDate));
        break;

      case 'getEmailsByRoleName':
        $roleName = htmlspecialchars($_GET['roleName']);
        echo json_encode(['success' => true, 'data' => User::getEmailsByRoleName($roleName)]);
        break;

      case 'assignAssignee':
        $email = htmlspecialchars($_GET['userEmail']);
        $ticketId = htmlspecialchars($_GET['ticketId']);
        echo json_encode(['success' => Ticket::assignAssignee($email, $ticketId)]);
        break;
    }
  }

?>