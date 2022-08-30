<?php

  session_start();

  include_once 'config/messages.php';
  include_once 'utils/permissions.php';
  include_once 'utils/breadcrumbs.php';

  $action = intval($_GET['action']);

  $conn = new mysqli('localhost', 'root', '', 'wspolnota_ostoja');

  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  $surveyID = $_GET['surveyID'];

  $query = "SELECT a.nazwa as anazwa, p.id as pid, p.tresc as ptresc, p.typ as ptyp, o.tresc as otresc FROM ankieta_odpowiedzi o
      INNER JOIN ankieta_pytania p ON o.pytanie_id=p.id
      INNER JOIN ankieta a ON a.id=p.ankieta_id
      WHERE p.ankieta_id=".$surveyID.";";
  $result = $conn->query($query);

  $resultArray = [];
  while ($row = $result->fetch_assoc()) {
    $obj = new stdClass;
    $obj->surveyName = $row['anazwa'];
    $obj->questionId = $row['pid'];
    $obj->questionText = $row['ptresc'];
    $obj->questionType = $row['ptyp'];
    $obj->answerText = $row['otresc'];
    array_push($resultArray, $obj);
  }

  $conn->close();
?>

<!doctype html>
<html>
  <?php include('templates/header.php'); ?>
  <link rel="stylesheet" type="text/css" href="css/contakt.css" media="screen" />
  <?php include('templates/body.php'); ?>

        <div class="col-7 page-name">
          <div id="breadcrumbs-div">
            <nav class="navbar-expand-lg">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <?php Breadcrumbs::showBreadcrumbs(['page' => 'Głosowanie - wyniki', 'address' => 'voting_summary.php']); ?>
                </ol>
              </nav>
            </nav>
          </div>
          <p>Głosowanie</p>
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
              <h1 id="surveyTitle"></h1>
          </div>
          <div class="row-akt" id="surveyContent">
          </div>
      </div>
    </div>

    <?php include('templates/footer.php'); ?>
    <script>
      var resultArray = <?= json_encode($resultArray) ?>;
    </script>
    <script src="js/voting_summary.js"></script>
  </body>
</html>