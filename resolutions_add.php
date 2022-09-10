<?php
    session_start();

    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false) {
        header('Location: witaj');
    }

    include_once 'config/messages.php';
    include_once 'utils/permissions.php';
    include_once 'utils/breadcrumbs.php';

    $conn = new mysqli('localhost', 'root', '', 'wspolnota_ostoja');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_GET['action'])) {
        $action = intval($_GET['action']);

        if ($action == 1) {
            $errors = [];
            $directory = $_GET['directory'];
    
            if (isset($_FILES['files']['tmp_name'])) {
                $all_files = count($_FILES['files']['tmp_name']);
    
                for ($i = 0; $i < $all_files; $i++) {
                    $file_name = $_FILES['files']['name'][$i];
                    $file_tmp = $_FILES['files']['tmp_name'][$i];
                    $file_type = $_FILES['files']['type'][$i];
                    $file_size = $_FILES['files']['size'][$i];
                    $tmp = explode('.', $_FILES['files']['name'][$i]);
                    $file_ext = strtolower(end($tmp));
    
                    $file = $directory . $file_name;
    
                    if ($file_size > 2097152) {
                        $errors[] = 'File size exceeds limit: ' . $file_name . ' ' . $file_type;
                    }
    
                    if (empty($errors)) {
                        move_uploaded_file($file_tmp, $file);
                        echo($file_name . "|");
                    }
                }
            }
        } else if ($action == 2) {
            $id = $_GET['id'];
            $text = $_GET['text'];
            $author = $_SESSION['userId'];

            $conn = new mysqli('localhost', 'root', '', 'wspolnota_ostoja');

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $query = "INSERT INTO uchwaly (ID_uchwaly, tresc_uchwaly, autor) VALUES ('".$id."', '".$text."', '".$author."')";

            $result=$conn->query($query);
            if ($result === TRUE) {
                echo "SUCCESS";
            } else {
                echo $result;
            }
        } else if ($action == 3) {
            $resolutionId = intval($_GET['resolutionId']);
            $fileName = $_GET['fileName'];
    
            $query = "INSERT INTO uchwaly_pliki (uchwala_id, nazwa) VALUES (".$resolutionId.", '".$fileName."');";
            $conn->query($query);
        }
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
                        <?php Breadcrumbs::showBreadcrumbs(['page' => 'Uchwały - dodaj', 'address' => 'uchwały-dodaj']); ?>
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

        <div class="row justify-content-start main-content-row">
            <div class="col">
                <div class="row row-upper">
                    <h1>Dodaj nową uchwałę</h1>
                </div>
                <form class="row-akt" style="padding-top: 10px; padding-left: 10px; padding-bottom: 10px; padding-right: 10px;">
                    <label>Numer uchwały:</label> <br/>
                    <input type="number" id="resolutionID"/> <br/> <br/>
                    <label>Tytuł uchwały:</label> <br/>
                    <textarea id="resolutionText" rows="1" cols="100"></textarea> <br/> <br/>
                    <label>Pliki (opcjonalne):</label> <br/>
                    <input id="uploadFilesInput" type="file" multiple/> <br/> <br/>
                    <input id="createButton" type="button" value="Utwórz" style="cursor: pointer;"/>
                </form>
            </div>
        </div>

        <?php include('templates/footer.php'); ?>
        <script src="js/resolutions_add.js"></script>
    </body>
</html>