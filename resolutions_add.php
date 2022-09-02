<?php
    session_start();

    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false) {
        header('Location: index.php');
    }

    include_once 'config/messages.php';
    include_once 'utils/permissions.php';
    include_once 'utils/breadcrumbs.php';

    if (isset($_GET['id']) && isset($_GET['text']) && isset($_SESSION['userId'])) {
        $id = $_GET['id'];
        $text = $_GET['text'];
        $image = $_GET['image'];
        
        $author = $_SESSION['userId'];

        $conn = new mysqli('localhost', 'root', '', 'wspolnota_ostoja');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query = "INSERT INTO uchwaly (ID_uchwaly, tresc_uchwaly, link, autor) VALUES ('".$id."', '".$text."', '".$image."', '".$author."')";

        $result=$conn->query($query);
        if ($result === TRUE) {
            echo "SUCCESS";
        } else {
            echo $result;
        }

        $conn->close();
    }
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
                        <?php Breadcrumbs::showBreadcrumbs(['page' => 'Uchwały - dodaj', 'address' => 'resolutions_add.php']); ?>
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
                <div class="row row-upper">
                    <h1>Dodaj nową uchwałę</h1>
                </div>
                <form class="row-akt" style="padding-top: 10px; padding-left: 10px; padding-bottom: 10px; padding-right: 10px;">
                    <label>Numer uchwały:</label> <br>
                    <input type="number" id="resolutionID"/> <br>
                    <label>Treść uchwały:</label> <br>
                    <textarea id="resolutionText" rows="10" cols="100"></textarea> <br>
                    <label>Link do zdjęcia (opcjonalne)</label> <br>
                    <input type="text" id="resolutionImage"/> <br>
                    <input id="createButton" type="button" value="Utwórz" style="cursor: pointer;"/>
                </form>
            </div>
        </div>

        <?php include('templates/footer.php'); ?>
        <script src="js/resolutions_add.js"></script>
    </body>
</html>