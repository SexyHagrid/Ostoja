<?php

  session_start();

  if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false) {
    header('Location: witaj');
  }

  include_once 'config/messages.php';
  include_once 'utils/permissions.php';
  include_once 'utils/breadcrumbs.php';

  $conn = new mysqli('remotemysql.com', 'lpqiJahZh5', '6m9cW0YAt2', 'lpqiJahZh5');

  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  if (isset($_GET['action']) && intval($_GET['action']) == 3) {
    $userID = $_GET['userID'];

    foreach($_GET as $key => $value) {
        if ($key != 'action' && $key != 'userID') {
            $query = "INSERT INTO ankieta_odpowiedzi (pytanie_id, uzytkownik_id, tresc) VALUES (".intval($key).", ".intval($userID).", '".$value."');";
            $result = $conn->query($query);
        }
    }
    echo "SUCCESS";
  } else {
    $id = $_GET['id'];
    $userId = $_SESSION['userId'];
    $questionsArray = [];

    $queryPytania = "SELECT a.nazwa AS anazwa,p.id AS pid, p.tresc AS ptresc, p.typ AS ptyp  FROM ankieta_pytania p INNER JOIN ankieta a ON a.id=p.ankieta_id WHERE p.ankieta_id='".$id."';";
    $resultPytania = $conn->query($queryPytania);
    while ($rowPytanie = $resultPytania->fetch_assoc()) {
        $obj = new stdClass;
        $obj->id = $id;
        $obj->name = $rowPytanie['anazwa'];
        $obj->questionId = $rowPytanie['pid'];
        $obj->questionText = $rowPytanie['ptresc'];
        $obj->questionType = $rowPytanie['ptyp'];
        array_push($questionsArray, $obj);
    }

    $completedSurveysArray = [];
    $query = "SELECT * FROM ankieta_odpowiedzi INNER JOIN ankieta_pytania ON ankieta_odpowiedzi.pytanie_id=ankieta_pytania.id WHERE ankieta_odpowiedzi.uzytkownik_id='".$userId."';";
    $result = $conn->query($query);
    while($row = $result->fetch_assoc()) {
        array_push($completedSurveysArray, $row['ankieta_id']);
    }
  }

  $conn->close();
?>

<!doctype html>
<html>
  <?php include('templates/header.php'); ?>
  <link rel="stylesheet" type="text/css" href="css/contact.css" media="screen" />
  <?php include('templates/body.php'); ?>

        <div class="col-7 page-name">
          <div id="breadcrumbs-div">
            <nav class="navbar-expand-lg">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <?php Breadcrumbs::showBreadcrumbs(['page' => 'Głosowanie - głosuj', 'address' => 'głosowanie-głosuj']); ?>
                </ol>
              </nav>
            </nav>
          </div>
          <p>Głosowanie</p>
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

    <div class="row justify-content-start main-content-row">
      <div class="col">
        <div class="row row-ct row-upper-ct">
          <h1 id="surveyTitle"></h1>
        </div>
        <div class="row-akt-ct" id="surveysContent" style="padding: 10px;">
        </div>
      </div>
    </div>

    <?php include('templates/footer.php'); ?>
    <script>
      var questionsArray = <?= json_encode($questionsArray) ?>;
      var completedSurveysArray = <?= json_encode($completedSurveysArray) ?>;
      var userId = <?= json_encode($_SESSION['userId']) ?>;
    </script>
    <script src="js/voting_vote.js"></script>
  </body>
</html>