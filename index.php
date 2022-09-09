<?php

  session_start();
  if (!isset($_SESSION['firstVisit']) || $_SESSION['firstVisit'] === true) {
    header('Location: welcome.php');
  }

  if (!isset($_SESSION["loggedin"]) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
  }

  include_once 'utils/permissions.php';
  include_once 'config/messages.php';
  include_once 'utils/breadcrumbs.php';

?>

<!doctype html>
<html>
  <?php include('templates/header.php'); ?>
  <link rel="stylesheet" type="text/less" href="css/index.less" />
  <?php include('templates/body.php'); ?>

        <div class="col-7 page-name">
          <div id="breadcrumbs-div">
            <nav class="navbar-expand-lg">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <?php Breadcrumbs::showBreadcrumbs(['page' => 'HUB', 'address' => 'index.php']); ?>
                </ol>
              </nav>
            </nav>
          </div> 
          <!-- <div id="rentingButton" style="display: flex; justify-content: center; align-items: center; padding: 16px; border: solid 2px white; width: 40%; background-image: linear-gradient(135deg, #222222, #444444); cursor: pointer;">
            <a style="font-size: 48px; color: white; text-shadow: -2px -2px 0 #000, 2px -2px 0 #000, -2px 2px 0 #000, 2px 2px 0 #000;  ">Przeglądanie ofert</a>
          </div> -->
          <p>Hub</p> 
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
      <div class="main-col tile-image">
        <a class="tile-image-a" id="tile-image-a-resolutions" href="resolutions.php">
          <h1>Baza uchwał</h1>
        </a>
      </div>
      <div class="main-col tile-image">
        <a class="tile-image-a" id="tile-image-a-news" href="news.php">
          <h1>Aktualności</h1>
        </a>
      </div>
      <div class="main-col tile-image">
        <a class="tile-image-a" id="tile-image-a-voting" href="voting.php">
          <h1>Głosowanie on-line</h1>
        </a>
      </div>
      <div class="main-col tile-image">
        <a class="tile-image-a" id="tile-image-a-meetings" href="meetings.php">
          <h1>Terminarz spotkań</h1>
        </a>
      </div>
      <div class="main-col tile-image">
        <a class="tile-image-a" id="tile-image-a-billings" href="billings.php">
          <h1>Opłaty</h1>
        </a>
      </div>
      <div class="main-col tile-image">
        <a class="tile-image-a" id="tile-image-a-support" href="support.php">
          <h1>Wsparcie techniczne</h1>
        </a>
      </div>
    </div>

    <?php include('templates/footer.php'); ?>
    <script src="js/index.js"></script>
  </body>
</html>