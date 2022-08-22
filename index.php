<?php
  session_start();
  if (!isset($_SESSION["loggedin"]) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
  }

  include 'utils/permissions.php';
  include_once 'config/messages.php';

?>

<!doctype html>
<html>
  <?php include('templates/header.php'); ?>
  <link rel="stylesheet" href="css/index.css" />
  <?php include('templates/body.php'); ?>

        <div class="col-7 page-name">
          <div id="page-name-outer">
            <div id="breadcrumbs-div">
              <nav class="navbar-expand-lg">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">Item first</li>
                      <li class="breadcrumb-item">List</li>
                      <li class="breadcrumb-item active" aria-current="page">Data</li>
                    </ol>
                  </nav>
              </nav>
            </div>
            <div id="page-name-inner"><p>Hub</p></div>
          </div>
        </div>
        <div class="col-2 upper-right-buttons">
          <?php if (Permissions::hasPermission("Panel administracyjny")): ?>
            <a href="admin_panel.php"><p id="admin-panel">Panel administracyjny</p></a>
            <hr>
          <?php endif; ?>
          <a href="logout.php"><p>Wyloguj</p></a>
        </div>
      </div>
    </div>

    <div class="row main-content-row">
      <div class="main-col">
        <a href="resolutions.php"><p>Baza uchwał</p></a>
      </div>
      <div class="main-col">
        <a href="news.php"><p>Aktualności</p></a>
      </div>
      <div class="main-col">
        <a href="voting.php"><p>Głosowanie on-line</p></a>
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
  </body>
</html>