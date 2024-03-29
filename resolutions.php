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

    $query="SELECT * FROM uchwaly";

    $result=$conn->query($query);
    $resultArray = [];

    while ($row = $result->fetch_assoc()) {
        $obj = new stdClass;
        $obj->id = $row['ID_uchwaly'];
        $obj->text = $row['tresc_uchwaly'];
        $obj->author = $row['autor'];

        $filesArray = [];
        $queryFiles = "SELECT * FROM uchwaly_pliki WHERE uchwala_id=".$obj->id.";";
        $resultFiles = $conn->query($queryFiles);
        while ($rowFile = $resultFiles->fetch_assoc()) {
            array_push($filesArray, $rowFile['nazwa']);
        }
        $obj->filesList = $filesArray;

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
                        <?php Breadcrumbs::showBreadcrumbs(['page' => 'Uchwały', 'address' => 'uchwały']); ?>
                        </ol>
                    </nav>
                    </nav>
                </div>
                <p>Uchwały</p>
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

        <div class="row row-akt-main main-content-row">
            <div class="col">
                <div class="row-upper-akt">
                    <h1>Baza uchwał</h1>
                </div>
                <?php if (Permissions::hasPermission("Dodawanie uchwał")): ?>
                    <div>
                        <button id="addNewResolutionButton">Dodaj uchwale</button>
                    </div>
                <?php endif; ?>
                <div id="resolutionContent">
                </div>
            </div>

            <template id="resolutionTemplate">
                <div class="row row-akt" style="padding-top: 10px; padding-left: 10px; padding-bottom: 10px; padding-right: 10px;">
                    <table style="width: 100%;">
                        <tr>
                            <td rowspan="2" style="width: 15%;">
                                <h3></h3>
                            </td>
                            <td>
                                <h2></h2>
                            </td>
                            <td>
                                <button style="display: none; position: absolute; right: 90px;">Edytuj</button>
                                <button style="display: none; position: absolute; right: 30px;">Usuń</button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div id="files"></div>
                            </td>
                        </tr>
                    </table>
                </div>
            </template>
        </div>

        <?php include('templates/footer.php'); ?>
        <script>
            var resolutionsList = <?= json_encode($resultArray) ?>;
            var userId = <?= json_encode($_SESSION['userId']) ?>;
            var hasEditDeletePermission = <?= json_encode(Permissions::hasPermission("Edytowanie i usuwanie uchwał innych uzytkowników")) ?>;
        </script>
        <script src="js/resolutions.js"></script>
    </body>
</html>