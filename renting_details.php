<?php

    include_once 'config/messages.php';
    include_once 'utils/permissions.php';

    $id = $_GET['id'];

    $conn = new mysqli('localhost', 'root', '', 'wspolnota_ostoja');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT * FROM wynajem WHERE id='".$id."';";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();

    $queryPhotos = "SELECT * FROM wynajem_zdjecia WHERE mieszkanie_id='".$row['id']."';";
    $resultPhotos = $conn->query($queryPhotos);
    $resultPhotosCount = $resultPhotos->num_rows;

    if ($resultPhotosCount == 0) {
        echo $row['id'] . "|" .  $row['czynsz'] . "|" . $row['adres'] . "|" . $row['okres_wynajmu'] . "|" . $row['telefon'] . "|" . ($row['dodatkowe_informacje'] ?: ' ') . "|" . " " . "|" . $row['typ'] . "||";
    } else {
        while ($rowPhoto = $resultPhotos->fetch_assoc()) {
            echo $row['id'] . "|" .  $row['czynsz'] . "|" . $row['adres'] . "|" . $row['okres_wynajmu'] . "|" . $row['telefon'] . "|" . ($row['dodatkowe_informacje'] ?: ' ') . "|" . ($rowPhoto['link'] ?: " ") . "|" . $row['typ'] . "||";
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
                    <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
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

        <?php include('templates/footer.php'); ?>
        <script src="js/renting_details.js"></script>
    </body>
</html>