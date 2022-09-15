<?php

  session_start();

  include_once 'config/messages.php';
  include_once 'utils/permissions.php';
  include_once 'utils/breadcrumbs.php';

  $conn = new mysqli('remotemysql.com', 'lpqiJahZh5', '6m9cW0YAt2', 'lpqiJahZh5');

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

  $hasEditDeletePermission = Permissions::hasPermission("Edytowanie i usuwanie faq");

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
                  <?php Breadcrumbs::showBreadcrumbs(['page' => 'FAQ', 'address' => 'faq']); ?>
                </ol>
              </nav>
            </nav>
          </div>
          <p>FAQ</p>
        </div>
        <div class="col-2 upper-right-buttons">
          <?php if (isset($_SESSION['userId'])): ?>
            <?php if (Permissions::hasPermission("Panel administracyjny")): ?>
              <a href="panel-administracyjny"><p id="admin-panel">Panel administracyjny</p></a>
              <hr>
            <?php endif; ?>
            <a href="wyloguj"><p id="logout-in-p">Wyloguj</p></a>
          <?php else: ?>
            <a href="zaloguj"><p id="logout-in-p">Zaloguj</p></a>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="row main-content-row">
      <div class="col">
        <div class="row row-upper-faq">
            <h1>FAQ</h1>
        </div>
        <?php if (isset($_SESSION['userId'])): ?>
        <?php if (Permissions::hasPermission("Dodawanie faq")): ?>
            <div>
                <button id="addNewFaqEntryButton">Dodaj faq</button>
            </div>
           <?php endif; ?>
        <?php endif; ?>
        <div id="faqContent">
        </div>
      </div>
    </div>

    <template id="faqTemplate">
      <div class="row row-akt-faq" style="padding-top: 10px; padding-left: 10px; padding-bottom: 10px; padding-right: 10px;">
        <table style="width: 100%;">
          <tr>
            <td rowspan=2 style="width: 20%">
              <h3></h3>
            </td>
            <td style="width: 70%">
              <label style="font-weight: italic;"></label>
            </td>
            <td>
              <button style="display: none; right: 90px;">Edytuj</button>
              <button style="display: none; right: 30px;">Usuń</button>
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

    <?php include('templates/footer.php'); ?>
    <script>
      var resultArray = <?= json_encode($resultArray) ?>;
      var hasEditDeletePermission = <?= json_encode($hasEditDeletePermission) ?>;
    </script>
    <script src="js/faq.js"></script>
  </body>
</html>