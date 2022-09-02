<?php

  session_start();

  include_once 'config/messages.php';
  include_once 'utils/permissions.php';
  include_once 'utils/breadcrumbs.php';

  $conn = new mysqli('localhost', 'root', '', 'wspolnota_ostoja');

  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  $query = "SELECT * FROM faq";
  $result = $conn->query($query);

  $resultArray = [];

  while ($row = $result->fetch_assoc()) {
    $obj = new stdClass;
    $obj->id = $row['id'];
    $obj->question = $row['pytanie'];
    $obj->answer = $row['odpowiedz'];

    array_push($resultArray, $obj);
  }

  $conn->close();

?>

<!doctype html>
<html>
  <?php include('templates/header.php'); ?>
  <link rel="stylesheet" type="text/css" href="css/faq.css" media="screen" />
  <?php include('templates/body.php'); ?>

        <div class="col-7 page-name">
          <div id="breadcrumbs-div">
            <nav class="navbar-expand-lg">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <?php Breadcrumbs::showBreadcrumbs(['page' => 'FAQ', 'address' => 'faq.php']); ?>
                </ol>
              </nav>
            </nav>
          </div>
          <p>FAQ</p>
        </div>
        <div class="col-2 upper-right-buttons">
          <?php if (isset($_SESSION['userId'])): ?>
            <?php if (Permissions::hasPermission("Panel administracyjny")): ?>
              <a href="admin_panel.php"><p id="admin-panel">Panel administracyjny</p></a>
              <hr>
            <?php endif; ?>
            <a href="logout.php"><p>Wyloguj</p></a>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="row justify-content-start main-content-row">
      <div class="col">
        <div class="row row-upper">
            <h1>FAQ</h1>
        </div>
        <?php if (Permissions::hasPermission("Dodawanie faq")): ?>
            <div>
                <button id="addNewFaqEntryButton">Dodaj faq</button>
            </div>
        <?php endif; ?>
        <div id="faqContent">
        </div>
      </div>
    </div>

    <template id="faqTemplate">
      <div class="row row-akt" style="padding-top: 10px; padding-left: 10px; padding-bottom: 10px; padding-right: 10px;">
        <table style="width: 100%;">
          <tr>
            <td rowspan=2 style="width: 20%">
              <h3></h3>
            </td>
            <td>
              <label style="font-weight: italic;"></label>
            </td>
          </tr>
          <tr>
            <td>
              <label style="font-weight: bold;"></label> 
            </td>
          </tr>
        </table>
      </div>
    </template>

    <?php include('templates/footer.php'); ?> <!-- // TODO: remove appr link -->
    <script>
      var resultArray = <?= json_encode($resultArray) ?>;
    </script>
    <script src="js/faq.js"></script>
  </body>
</html>