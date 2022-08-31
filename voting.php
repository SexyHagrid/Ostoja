<?php
    session_start();

    include_once 'config/messages.php';
    include_once 'utils/permissions.php';
    include_once 'utils/breadcrumbs.php';

    

    $conn = new mysqli('localhost', 'root', '', 'wspolnota_ostoja');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT * FROM ankieta";
    $result = $conn->query($query);

    $votingArray = [];
    while ($row = $result->fetch_assoc()) {
        $obj = new stdClass;
        $obj->id = $row['id'];
        $obj->name = $row['nazwa'];
        array_push($votingArray, $obj);
    }

    $userId = $_SESSION['userId'];
    
    $completedSurveysArray = [];
    $query = "SELECT * FROM ankieta_odpowiedzi INNER JOIN ankieta_pytania ON ankieta_odpowiedzi.pytanie_id=ankieta_pytania.id WHERE ankieta_odpowiedzi.uzytkownik_id='".$userId."';";
    $result = $conn->query($query);
    while($row = $result->fetch_assoc()) {
        array_push($completedSurveysArray, $row['ankieta_id']);
    }

    $conn->close();
?>

<!doctype html>
<html>
    <?php include('templates/header.php'); ?>
    <link rel="stylesheet" type="text/css" href="css/contact.css" media="screen" />
    <?php include('templates/body.php'); ?>

            <div class="col-7 page-name">
                <div id="breadcrumbs-div">
                    <nav class="navbar-expand-lg">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                        <?php Breadcrumbs::showBreadcrumbs(['page' => 'Głosowanie', 'address' => 'voting.php']); ?>
                        </ol>
                    </nav>
                    </nav>
                </div>
                <p>Głosowanie</p>
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
                    <h1>Dostępne głosowania</h1>
                </div>
                <div id="surveysContent">

                </div>
            </div>
        </div>

        <?php include('templates/footer.php'); ?>
        <script>
            var votingArray = <?= json_encode($votingArray) ?>;
            var completedSurveysArray = <?= json_encode($completedSurveysArray) ?>;
            var userId = <?= json_encode($_SESSION['userId']) ?>;
        </script>
        <script src="js/voting.js"></script>
    </body>
</html>