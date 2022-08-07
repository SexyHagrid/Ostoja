<?php
  session_start();
  if (!isset($_SESSION["loggedin"]) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
  }

  $error_prompt_message = '';

  include 'utils/permissions.php';

?>

<!doctype html>
<html>
  <?php include('templates/header.php'); ?>
  <link rel="stylesheet" href="css/index.css" />
  <?php include('templates/body.php'); ?>

        <div class="col-7">
          <p>Hub</p>
        </div>
        <div class="col-2">
          <div class="upper-buttons">
            <?php if (Permissions::hasPermission("Panel administracyjny")): ?>
              <a href="admin_panel.php"><p>Panel administracyjny</p></a>
            <?php endif; ?>
            <a href="logout.php"><p>Wyloguj</p></a>
          </div>
        </div>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="main-col">
        <a href="Baza_uchwal.html"><p>Baza uchwał</p></a>
      </div>
      <div class="main-col">
        <a href="Aktualnosci.html"><p>Aktualności</p></a>
      </div>
      <div class="main-col">
        <a href="Glosowania.html"><p>Głosowanie on-line</p></a>
      </div>
      <div class="main-col">
        <a href="Spotkania.html"><p>Terminarz spotkań</p></a>
      </div>
      <div class="main-col">
        <a href="Oplaty.html"><p>Naliczone opłaty</p></a>
      </div>
      <div class="main-col">
        <a href="Awarie.html"><p>Zgłaszanie awarii</p></a>
      </div>
    </div>

    <?php include('templates/footer.php'); ?>
</html>