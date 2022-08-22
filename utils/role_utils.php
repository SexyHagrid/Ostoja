<?php

  require_once './role.php';

  if(isset($_GET['method'])) {
    $method = htmlspecialchars($_GET['method']);
    switch($method) {
      case 'getRolesNames':
        echo json_encode(Role::getRolesNames());
        break;
    }
  }

?>