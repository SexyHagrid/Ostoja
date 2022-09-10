<?php

  session_start();
  if (!isset($_SESSION["loggedin"]) || $_SESSION['loggedin'] !== true) {
    header('Location: witaj');
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
                  <?php Breadcrumbs::showBreadcrumbs(['page' => 'HUB', 'address' => 'hub']); ?>
                </ol>
              </nav>
            </nav>
          </div>
          <p>Hub</p>
        </div>
        <div class="col-2 upper-right-buttons">
          <?php if (Permissions::hasPermission("Panel administracyjny")): ?>
            <a href="panel-administracyjny"><p id="admin-panel">Panel administracyjny</p></a>
            <hr>
          <?php endif; ?>
          <a href="wyloguj"><p id="logout-in-p">Wyloguj</p></a>
        </div>
      </div>
    </div>

    <div class="row main-content-row">
      <div class="main-col tile-image">
        <a class="tile-image-a" id="tile-image-a-resolutions" href="uchwały">
          <h1>Baza uchwał</h1>
        </a>
      </div>
      <div class="main-col tile-image">
        <a class="tile-image-a" id="tile-image-a-news" href="aktualności">
          <h1>Aktualności</h1>
        </a>
      </div>
      <div class="main-col tile-image">
        <a class="tile-image-a" id="tile-image-a-voting" href="głosowanie">
          <h1>Głosowanie on-line</h1>
        </a>
      </div>
      <div class="main-col tile-image">
        <a class="tile-image-a" id="tile-image-a-meetings" href="spotkania">
          <h1>Terminarz spotkań</h1>
        </a>
      </div>
      <div class="main-col tile-image">
        <a class="tile-image-a" id="tile-image-a-billings" href="opłaty">
          <h1>Opłaty</h1>
        </a>
      </div>
      <div class="main-col tile-image">
        <a class="tile-image-a" id="tile-image-a-support" href="wsparcie-techniczne">
          <h1>Wsparcie techniczne</h1>
        </a>
      </div>
    </div>

    <?php include('templates/footer.php'); ?>
    <script src="js/index.js"></script>
  </body>
</html>