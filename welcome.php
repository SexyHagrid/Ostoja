<?php

  session_start();

  // include_once 'utils/permissions.php';
  include_once 'config/messages.php';
  include_once 'utils/breadcrumbs.php';

  $_SESSION['firstVisit'] = false;

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
          <p>Witaj</p>
        </div>
        <div class="col-2 upper-right-buttons">
        </div>
      </div>
    </div>
    
    
    <div class="row justify-content-center" style="padding: 50px;">
      <h1 style="font-weight: bold;">Witaj na stronie wspólnoty mieszkaniowej "Ostoja"</h1>
    </div>
    <div class="row main-content-row justify-content-center">      
      <div class="main-col tile-image">
        <a class="tile-image-a" href="login.php" style="display: flex; justify-content: center; align-items: center;">
          <h1>Zaloguj się</h1>
        </a>
      </div>
      <div class="main-col tile-image">
        <a class="tile-image-a" href="renting_categories.php" style="display: flex; justify-content: center; align-items: center;">
          <h1>Przeglądaj oferty</h1>
        </a>
      </div>
    </div>

    <?php include('templates/footer.php'); ?>
  </body>
</html>