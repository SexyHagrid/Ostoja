<?php

  require_once './permissions.php';

  if($_GET['roleId']) {
    $permissions = json_encode(Permissions::getPermissionsByRole($_GET['roleId']));

    echo $permissions;
  }

  return null;
?>