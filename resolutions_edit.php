<?php
    session_start();

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
        $query = "UPDATE uchwaly SET tresc_uchwaly='".$text."', link='".$image."' WHERE ID_uchwaly='".$id."';";
        $result=$conn->query($query);

        if ($result === TRUE) {
            echo "SUCCESS";
        } else {
            echo $result;
        }
    } else {
        $query = "SELECT * FROM uchwaly WHERE ID_uchwaly='".$id."';";
        $result=$conn->query($query);
        $row=$result->fetch_assoc();

        $resolution = new stdClass;
        $resolution->id = $row['ID_uchwaly'];
        $resolution->text = $row['tresc_uchwaly'];
        $resolution->image = $row['link'];
        $resolution->author = $row['autor'];
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
                        <?php Breadcrumbs::showBreadcrumbs(['page' => 'Uchwały - edytuj', 'address' => 'resolutions_edit.php']); ?>
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

        <div class="row justify-content-start">
            <div class="col">
                <div class="row row-upper">
                    <h1>Edytuj uchwałę</h1>
                </div>
                <form class="row-akt">
                <label>Numer uchwały:</label> <br>
                <label id="resolutionID"></label> <br>
                <label>Treść uchwały:</label> <br>
                <input type="text" id="resolutionText"/> <br>
                <label>Link do zdjęcia (opcjonalne)</label> <br>
                <input type="text" id="resolutionImage"/> <br>
                <input id="updateButton" type="button" value="Edytuj"/>
                </form>
            </div>
        </div>

        <?php include('templates/footer.php'); ?>
        <script>
            var resolution = <?= json_encode($resolution) ?>; 
        </script>
        <script src="js/resolutions_edit.js"></script>
    </body>
</html>