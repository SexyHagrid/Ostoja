<?php

  session_start();

  include_once 'config/messages.php';
  include_once 'utils/permissions.php';
  include_once 'utils/breadcrumbs.php';

    $id = $_GET['id'];

    $conn = new mysqli('localhost', 'root', '', 'wspolnota_ostoja');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT * FROM wynajem WHERE typ=".$id.";";
    $result = $conn->query($query);
    $resultArray = [];
    while ($row = $result->fetch_assoc()) {
        $queryPhotos = "SELECT * FROM wynajem_zdjecia WHERE mieszkanie_id='".$row['id']."';";
        $resultPhotos = $conn->query($queryPhotos);
        $rowCount = $resultPhotos->num_rows;
        if ($rowCount == 0) {
          $obj = new stdClass;
          $obj->id = $row['id'];
          $obj->address = $row['adres'];
          $obj->image = " ";
          array_push($resultArray, $obj);
        } else {
            while ($rowPhoto = $resultPhotos->fetch_assoc()) {
              $obj = new stdClass;
              $obj->id = $row['id'];
              $obj->address = $row['adres'];
              $obj->image = ($rowPhoto['link'] ?: " ");
              array_push($resultArray, $obj);
            }
        }
    }

    $conn->close();
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
                  <?php Breadcrumbs::showBreadcrumbs(['page' => 'Wynajem - lista', 'address' => 'renting_list.php']); ?>
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

    <div class="row justify-content-center" id="contentDiv">
    </div>

    <?php include('templates/footer.php'); ?>
    <script>
      var resultArray = <?= json_encode($resultArray) ?>;
    </script>
    <script src="js/renting_list.js"></script>
  </body>
</html>