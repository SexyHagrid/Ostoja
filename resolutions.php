<?php

    session_start();

    include_once 'config/messages.php';
    include_once 'utils/permissions.php';
    include_once 'utils/breadcrumbs.php';

    $conn = new mysqli('localhost', 'root', '', 'wspolnota_ostoja');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query="SELECT * FROM uchwaly";

    $result=$conn->query($query);
    $resultArray = [];

    while ($row = $result->fetch_assoc()) {
        $obj = new stdClass;
        $obj->id = $row['ID_uchwaly'];
        $obj->text = $row['tresc_uchwaly'];
        $obj->image = $row['link'];
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
                        <?php Breadcrumbs::showBreadcrumbs(['page' => 'Uchwały', 'address' => 'resolutions.php']); ?>
                        </ol>
                    </nav>
                    </nav>
                </div>
                <p>Uchwały</p>
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
            <div id="editorMenu" style="display: none;">
                <button onclick="addResolution()">Dodaj uchwale</button>
            </div>
                <div class="row row-upper">
                    <h1>Baza uchwał</h1>
                </div>
                <div id="resolutionContent">
                </div>
            </div>
        </div>

        <template id="resolutionTemplate">
            <div class="row row-akt">
            <div><h3></h3></div>
            <label></label>
            <img>
            <button style="display: none;">Edytuj</button>
            <button style="display: none;">Usuń</button>
            </div>
        </template>

        <?php include('templates/footer.php'); ?>
        <script>
            var resolutionsList = <?= json_encode($resultArray) ?>;
        </script>
        <script src="js/resolutions.js"></script>
    </body>
</html>