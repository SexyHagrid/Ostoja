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
                  <?php Breadcrumbs::showBreadcrumbs(['page' => 'Wynajem - kategorie', 'address' => 'renting_categories.php']); ?>
                </ol>
              </nav>
            </nav>
          </div>
          <p>Wynajem</p>
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

    <div class="row justify-content-center">
      <div class="col-3 main-col" style="background-color: lightblue;">
        <a href="renting_list.php?id=1" class="czcionka_glowna_kategorie"><p>1-pokojowe</p></a>
      </div>
      <div class="col-3 main-col" style="background-color: lightblue;">
        <a href="renting_list.php?id=2" class="czcionka_glowna_kategorie"><p>2-pokojowe</p></a>
      </div>
      <div class="col-3 main-col" style="background-color: lightblue;">
        <a href="renting_list.php?id=3" class="czcionka_glowna_kategorie"><p>3-pokojowe</p></a>
      </div>
      <div class="col-3 main-col" style="background-color: white;">
        <a class="czcionka_glowna_kategorie"><p></p></a>
      </div>
      <div id="addOfferButtonElement" class="col-3 main-col" style="background-color: lightblue; display: none;">
        <a href="renting_add.php" class="czcionka_glowna_kategorie"><p>Dodaj ofertę</p></a>
      </div>
      <div class="col-3 main-col" style="background-color: white;">
        <a class="czcionka_glowna_kategorie"><p></p></a>
      </div>
    </div>

    <?php include('templates/footer.php'); ?>
    <script src="js/renting_categories.js"></script>
  </body>
</html>