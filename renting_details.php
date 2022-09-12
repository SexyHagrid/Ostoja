<?php

    session_start();

    include_once 'config/messages.php';
    include_once 'utils/permissions.php';
    include_once 'utils/breadcrumbs.php';

    $id = $_GET['id'];

    $conn = new mysqli('remotemysql.com', 'lpqiJahZh5', '6m9cW0YAt2', 'lpqiJahZh5');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT * FROM wynajem WHERE id='".$id."';";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();

    $queryPhotos = "SELECT * FROM wynajem_zdjecia WHERE mieszkanie_id='".$row['id']."';";
    $resultPhotos = $conn->query($queryPhotos);
    $resultPhotosCount = $resultPhotos->num_rows;

    $resultArray = [];
    if ($resultPhotosCount == 0) {
        $obj = new stdClass;
        $obj->id = $row['id'];
        $obj->price = $row['czynsz'];
        $obj->address = $row['adres'];
        $obj->time = $row['okres_wynajmu'];
        $obj->phone = $row['telefon'];
        $obj->info = ($row['dodatkowe_informacje'] ?: ' ');
        $obj->photo = " ";
        $obj->type = $row['typ'];
        array_push($resultArray, $obj);
    } else {
        while ($rowPhoto = $resultPhotos->fetch_assoc()) {
            $obj = new stdClass;
            $obj->id = $row['id'];
            $obj->price = $row['czynsz'];
            $obj->address = $row['adres'];
            $obj->time = $row['okres_wynajmu'];
            $obj->phone = $row['telefon'];
            $obj->info = ($row['dodatkowe_informacje'] ?: ' ');
            $obj->photo = ($rowPhoto['link'] ?: " ");
            $obj->type = $row['typ'];
            array_push($resultArray, $obj);
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
                    <?php Breadcrumbs::showBreadcrumbs(['page' => 'Wynajem - detale', 'address' => 'wynajem-detale']); ?>
                    </ol>
                </nav>
                </nav>
            </div>
            <p>Wynajem - detale</p>
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

        <div class="row main-content-row" id="contentDiv">
            <div class="main-renting-data-outer">
                <table>
                <tr>
                    <td colspan="3">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" style="width: 600px;">
                        <ol class="carousel-indicators" id="carouselIndicators">
                        </ol>
                        <div class="carousel-inner" id="carouselContent">
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </a>
                    </div>
                    </td>
                </tr>
                <tr>
                    <td>
                    <label style="font-weight: bold;">Adres: </label>
                    <label id="addressLabel"></label>
                    </td>
                    <td>
                    <label style="font-weight: bold;">Dodatkowe informacje:</label>
                    <br/>
                    <label id="additionalInfoLabel"></label>
                    </td>
                </tr>
                <tr>
                    <td>
                    <label style="font-weight: bold;">Czynsz: </label>
                    <label id="priceLabel"></label>
                    </td>
                </tr>
                <tr>
                    <td>
                    <label style="font-weight: bold;">Okres wynajmu: </label>
                    <label id="timeLabel"></label>
                    </td>
                    <td>
                    <label style="font-weight: bold;">Telefon: </label>
                    <label id="phoneLabel"></label>
                    </td>
                </tr>
                </table>
            </div>
        </div>

        <?php include('templates/footer.php'); ?>
        <script>
            var resultArray = <?= json_encode($resultArray) ?>;
        </script>
        <script src="js/renting_details.js"></script>
    </body>
</html>