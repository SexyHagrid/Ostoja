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
            $id = intval($_GET['id']);
            $text = $_GET['text'];

            $conn = new mysqli('remotemysql.com', 'lpqiJahZh5', '6m9cW0YAt2', 'lpqiJahZh5');

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $query = "UPDATE uchwaly SET tresc_uchwaly='".$text."' WHERE ID_uchwaly=".$id.";";

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
        } else if ($action == 4) {
            $resolutionId = intval($_GET['resolutionId']);
            $fileName = $_GET['fileName'];

            $query = "DELETE FROM uchwaly_pliki WHERE uchwala_id=".$resolutionId." AND nazwa='".$fileName."';";
            $result = $conn->query($query);
            if ($result === TRUE) {
                echo "SUCCESS";
            } else {
                echo $result;
            }
        }



    } else {
        $id = intval($_GET['id']);

        $query = "SELECT * FROM uchwaly WHERE ID_uchwaly='".$id."';";
        $result=$conn->query($query);
        $row=$result->fetch_assoc();

        $resolution = new stdClass;
        $resolution->id = $row['ID_uchwaly'];
        $resolution->text = $row['tresc_uchwaly'];
        $resolution->author = $row['autor'];

        $resolutionFiles = [];
        $queryFiles = "SELECT * FROM uchwaly_pliki WHERE uchwala_id=".$resolution->id.";";
        $resultFiles = $conn->query($queryFiles);
        while($rowFile = $resultFiles->fetch_assoc()) {
            array_push($resolutionFiles, $rowFile['nazwa']);
        }
        $resolution->files = $resolutionFiles;
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
                        <?php Breadcrumbs::showBreadcrumbs(['page' => 'Uchwały - edytuj', 'address' => 'uchwały-edytuj']); ?>
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

        <div class="row main-content-row">
            <div class="col">
                <div class="row row-upper-akt">
                    <h1>Edytuj uchwałę</h1>
                </div>
                <form class="row-akt" style="padding-top: 10px; padding-left: 10px; padding-bottom: 10px; padding-right: 10px;">
                    <label>Numer uchwały:</label> <br/>
                    <label id="resolutionID"></label> <br/> <br/>
                    <label>Tytuł uchwały:</label> <br/>
                    <textarea rows = "1" cols = "100" id="resolutionText"></textarea> <br/> <br/>
                    <div id="existingFilesList" style="display: none;">
                        <label>Pliki</label> <br/>
                    </div>
                    <label>Dodaj nowe pliki (opcjonalne):</label> <br/>
                    <input id="uploadFilesInput" type="file" multiple/> <br/> <br/>
                    <input id="updateButton" type="button" value="Edytuj"/>
                </form>
            </div>
        </div>

        <?php include('templates/footer.php'); ?>
        <script>
            var resolution = <?= json_encode($resolution) ?>;
            var userId = <?= json_encode($_SESSION['userId']) ?>;
            var hasEditDeletePermission = <?= json_encode(Permissions::hasPermission("Edytowanie i usuwanie uchwał innych uzytkowników")) ?>;
        </script>
        <script src="js/resolutions_edit.js"></script>
    </body>
</html>