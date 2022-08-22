<?php

  include_once 'config/messages.php';
  include_once 'utils/permissions.php';

?>

<!doctype html>
<html>
  <?php include('templates/header.php'); ?>
  <link rel="stylesheet" type="text/css" href="css/contact.css" media="screen" />
  <?php include('templates/body.php'); ?>

        <div class="col-7 page-name">
          <p>Głosowania</p>
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

    <div class="row justify-content-start">
      <div class="col">
        <div class="row row-upper">
          <h1 id="surveyTitle"></h1>
        </div>
        <div class="row-akt" id="surveysContent">
        </div>
      </div>
    </div>

    <?php include('templates/footer.php'); ?>
    <script src="js/voting_vote.js"></script>
  </body>
</html>