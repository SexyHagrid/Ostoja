<?php

    session_start();

    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false) {
        header('Location: index.php');
    }

    include_once 'config/messages.php';
    include_once 'utils/permissions.php';
    include_once 'utils/breadcrumbs.php';

    $id = intval($_GET['id']);
    $text = $_GET['text'];
    $image = $_GET['image'];
    $author = $_GET['author'];

    $conn = new mysqli('localhost', 'root', '', 'wspolnota_ostoja');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($text)) {
        $query = "UPDATE aktualnosci SET tresc_aktualnosci='".$text."', link='".$image."' WHERE ID_aktualnosci='".$id."';";
        $result=$conn->query($query);

        if ($result === TRUE) {
            echo "SUCCESS";
        } else {
            echo $result;
        }
    } else {
        $query = "SELECT * FROM aktualnosci WHERE ID_aktualnosci='".$id."';";  // TODO: why id not autoincremented key?
        $result=$conn->query($query);
        $row=$result->fetch_assoc();

        $obj = new stdClass;
        $obj->id = $row['ID_aktualnosci'];
        $obj->text = $row['tresc_aktualnosci'];
        $obj->image = $row['link'];
        $obj->author = $row['autor'];
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
                        <?php Breadcrumbs::showBreadcrumbs(['page' => 'Aktualności - edytuj', 'address' => 'news_edit.php']); ?>
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

        <div class="row justify-content-start">
            <div class="col">
                <div class="row row-upper">
                    <h1>Edytuj aktualnosc</h1>
                </div>
                <form class="row-akt" style="padding-top: 10px; padding-left: 10px; padding-bottom: 10px; padding-right: 10px;">
                    <label>Numer aktualnosci:</label> <br>
                    <label id="resolutionID"></label> <br>
                    <label>Treść aktualnosci:</label> <br>
                    <textarea rows = "10" cols = "100" id="resolutionText"></textarea> <br>
                    <label>Link do zdjęcia (opcjonalne)</label> <br>
                    <input type="text" id="resolutionImage"/> <br>
                    <input id="updateButton" type="button" value="Edytuj"/>
                </form>
            </div>
        </div>

        <?php include('templates/footer.php'); ?>
        <script>
            var result = <?= json_encode($obj) ?>;
            var userId = <?= json_encode($_SESSION['userId']) ?>;
            var hasEditDeletePermission = <?= json_encode(Permissions::hasPermission("Edytowanie i usuwanie aktualności innych")) ?>;
        </script>
        <script src="js/news_edit.js"></script>
    </body>
</html>