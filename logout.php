<?php

  session_start();
  if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    unset($_SESSION['loggedin']);
    unset($_SESSION['userId']);
    unset($_SESSION['email']);
    unset($_SESSION['breadcrumbs']);
  }

  header('Location: login.php');

?>