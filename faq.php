<?php

  include_once 'config/messages.php';
  include_once 'utils/permissions.php';

?>

<!doctype html>
<html>
  <?php include('templates/header.php'); ?>
  <link rel="stylesheet" type="text/css" href="css/faq.css" media="screen" />
  <?php include('templates/body.php'); ?>

  <div class="col-7 page-name">
          <p>FAQ</p>
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

    <div class="row justify-content-start main-content-row">
      <div class="col">
          <div class="row row-upper">
              <h1>FAQ</h1>
          </div>
          <div class="row row-akt">
              <div><h3>Pytanie 1</h3></div>
              <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam a suscipit enim, nec aliquam dolor. Fusce a maximus turpis, in pellentesque neque. Mauris id ante nisi. Suspendisse potenti. Curabitur semper massa in enim auctor gravida.</div>
          </div>
          <div class="row row-akt">
              <div><h3>Pytanie 2</h3></div>
              <p>Suspendisse potenti. Curabitur semper massa in enim auctor gravida. Proin urna felis, elementum id lacus sed, aliquet consequat tortorSuspendisse potenti. Curabitur semper massa in enim auctor gravida.</p>
          </div>
          <div class="row row-akt">
              <h3>Pytanie 3</h3>
              <p>Duis mollis, lectus ac fringilla convallis, ipsum urna aliquet erat, at condimentum nibh nisi id purus. Nunc ut mauris velit. Suspendisse potenti. Curabitur semper massa in enim auctor gravida. Nullam rhoncus quam vel congue lacinia.</p>
          </div>
          <div class="row row-akt">
              <h3>Pytanie 4</h3>
              <p>Vestibulum vestibulum auctor nisi, id malesuada urna. Aenean leo lectus, fermentum ut elementum sed, suscipit vel tellus. Suspendisse potenti. Curabitur semper massa in enim auctor gravida. Sed consectetur pharetra magna, et fringilla est interdum non. Sed vitae placerat velit, sed dapibus arcu</p>
          </div>
      </div>
    </div>

    <?php include('templates/footer.php'); ?> <!-- // TODO: remove appr link -->
  </body>
</html>