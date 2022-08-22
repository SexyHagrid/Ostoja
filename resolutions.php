<?php

    include_once 'config/messages.php';
    include_once 'utils/permissions.php';

    // $number = intval($_GET['numer']);

    $conn = new mysqli('localhost', 'root', '', 'wspolnota_ostoja');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // $query="SELECT * FROM uchwaly WHERE ID_uchwaly=$number";
    $query="SELECT * FROM uchwaly";

    $result=$conn->query($query);

    while ($row = $result->fetch_assoc()) {
        echo $row['ID_uchwaly'] . '|' . $row['tresc_uchwaly'] . '|' . ($row['link'] ?: ' ') . '|' . $row['autor'] . '||';
    }

    $conn->close();
?>

<!doctype html>
<html>
    <?php include('templates/header.php'); ?>
    <link rel="stylesheet" type="text/css" href="css/news.css" media="screen" />
    <?php include('templates/body.php'); ?>

                <div class="col-7 page-name">
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

        <div class="row justify-content-start">
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
        <script src="js/resolutions.js"></script>
    </body>
</html>