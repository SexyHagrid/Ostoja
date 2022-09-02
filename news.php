<?php

    session_start();

    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false) {
        header('Location: index.php');
    }

    include_once 'config/messages.php';
    include_once 'utils/permissions.php';
    include_once 'utils/breadcrumbs.php';

    $conn = new mysqli('localhost', 'root', '', 'wspolnota_ostoja');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query="SELECT * FROM aktualnosci" ;

    $result=$conn->query($query);
    $resultArray = [];

    while ($row = $result->fetch_assoc()) {
        $obj = new stdClass;
        $obj->id = $row['ID_aktualnosci'];
        $obj->text = $row['tresc_aktualnosci'];
        $obj->image = ($row['link'] ?: ' ');
        $obj->author = $row['autor'];
        array_push($resultArray, $obj);
    }

    $conn->close();
?>

<!doctype html>
<html>
    <?php include('templates/header.php'); ?>
    <link rel="stylesheet" type="text/css" href="css/news.css" media="screen" />
    <?php include('templates/body.php'); ?>

            <div class="col-7 page-name">
                <div id="breadcrumbs-div">
                    <nav class="navbar-expand-lg">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                        <?php Breadcrumbs::showBreadcrumbs(['page' => 'Aktualności', 'address' => 'news.php']); ?>
                        </ol>
                    </nav>
                    </nav>
                </div>
                <p>Aktualności</p>
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
                    <h1>Aktualności</h1>
                </div>
                <?php if (Permissions::hasPermission("Dodawanie aktualności")): ?>
                    <div>
                        <button id="addNewNewsButton">Dodaj aktualność</button>
                    </div>
                <?php endif; ?>
                <div id="newsContent">

                </div>
            </div>
        </div>

        <template id="newsTemplate">
            <div class="row row-akt" style="padding-top: 10px; padding-left: 10px; padding-bottom: 10px; padding-right: 10px;">
                <div style="width: 15%;"><h3></h3></div>
                <label style="width: 50%;"></label>
                <img>
                <button style="display: none; position: absolute; right: 90px;">Edytuj</button>
                <button style="display: none; position: absolute; right: 30px;">Usuń</button>
            </div>
        </template>

        <?php include('templates/footer.php'); ?>
        <script>
            var resultArray = <?= json_encode($resultArray) ?>;
            var userId = <?= json_encode($_SESSION['userId']) ?>;
            var hasEditDeletePermission = <?= json_encode(Permissions::hasPermission("Edytowanie i usuwanie aktualności innych")) ?>;
        </script>
        <script src="js/news.js"></script>
    </body>
</html>