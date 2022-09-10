<?php

  session_start();

  include_once 'config/messages.php';
  include_once 'utils/permissions.php';
  include_once 'utils/breadcrumbs.php';

?>

<!doctype html>
<html>
  <?php include('templates/header.php'); ?>
  <link rel="stylesheet" type="text/css" href="css/renting_categories.css" media="screen" />
  <?php include('templates/body.php'); ?>

        <div class="col-7 page-name">
          <div id="breadcrumbs-div">
            <nav class="navbar-expand-lg">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <?php Breadcrumbs::showBreadcrumbs(['page' => 'Wynajem - kategorie', 'address' => 'wynajem-kategorie']); ?>
                </ol>
              </nav>
            </nav>
          </div>
          <p>Wynajem</p>
        </div>
        <div class="col-2 upper-right-buttons">
          <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
            <?php if (Permissions::hasPermission("Panel administracyjny")): ?>
              <a href="panel-administracyjny"><p id="admin-panel">Panel administracyjny</p></a>
              <hr>
            <?php endif; ?>
            <a href="wyloguj"><p id="logout-in-p">Wyloguj</p></a>
          <?php else:  ?>
            <a href="zaloguj"><p id="logout-in-p">Zaloguj</p></a>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="main-content-row">
      <div class="row justify-content-center">
        <div class="col-3 main-col" id="oneRoomButton">
          <p class="czcionka_glowna_kategorie">1-pokojowe</p>
        </div>
        <div class="col-3 main-col" id="twoRoomButton">
          <p class="czcionka_glowna_kategorie">2-pokojowe</p>
        </div>
        <div class="col-3 main-col" id="threeRoomButton">
          <p class="czcionka_glowna_kategorie">3-pokojowe</p>
        </div>
        <div class="col-3 main-col" style="background-color: white;">
          <a class="czcionka_glowna_kategorie"><p></p></a>
        </div>
        <div id="addOfferButtonElement" class="col-3 main-col" id="addOfferButton" style="display: none;">
          <p class="czcionka_glowna_kategorie">Dodaj ofertę</p>
        </div>
        <div class="col-3 main-col" style="background-color: white;">
          <a class="czcionka_glowna_kategorie"><p></p></a>
        </div>
      </div>
    </div>
    <?php include('templates/footer.php'); ?>
    <script>
      var isLoggedIn = <?= isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true ?>;
    </script>
    <script src="js/renting_categories.js"></script>
  </body>
</html>