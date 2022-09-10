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
    $hasViewSummaryPermission = Permissions::hasPermission("Wyświetlanie podsumowania ankiet");
    
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
                        <?php Breadcrumbs::showBreadcrumbs(['page' => 'Głosowanie', 'address' => 'głosowanie']); ?>
                        </ol>
                    </nav>
                    </nav>
                </div>
                <p>Głosowanie</p>
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
                <div class="row row-ct">
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
            var hasViewSummaryPermission = <?= json_encode($hasViewSummaryPermission) ?>;
        </script>
        <script src="js/voting.js"></script>
    </body>
</html>