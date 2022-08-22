<?php

    include_once 'config/messages.php';
    include_once 'utils/permissions.php';

    $action = intval($_GET['action']);

    $conn = new mysqli('localhost', 'root', '', 'wspolnota_ostoja');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // if ($action == 0) {
    //     $query = "SELECT * FROM ankieta";
    //     $result = $conn->query($query);

    //     $ankietaID = [];
    //     $ankietaTytul = [];
    //     $ankietaPytania = [];

    //     while ($row = $result->fetch_assoc()) {
    //         array_push($ankietaID, $row['id']);
    //         array_push($ankietaTytul, $row['nazwa']);
    //     }

    //     foreach ($ankietaID as $id) {
    //         $queryPytania = "SELECT * FROM ankieta_pytania WHERE ankieta_id='".$id."';";
    //         $resultPytania = $conn->query($queryPytania);
    //         $arrayPytania = [];
    //         while ($rowPytanie = $resultPytania->fetch_assoc()) {
    //             array_push($arrayPytania, $rowPytanie);
    //         }
    //         array_push($ankietaPytania, $arrayPytania);
    //     }

    //     for ($i = 0; $i < count($ankietaID); $i++) {
    //         for ($j = 0; $j < count($ankietaPytania[$i]); $j++) {
    //             echo $ankietaID[$i] . '|' . $ankietaTytul[$i] . '|' . $ankietaPytania[$i][$j]['tresc'] . '|' . $ankietaPytania[$i][$j]['typ'] . '||';
    //         }
    //         echo '|';
    //     }
    // }

    if ($action == 0) {
        $query = "SELECT * FROM ankieta";
        $result = $conn->query($query);

        while ($row = $result->fetch_assoc()) {
            echo $row['id'] . '|' . $row['nazwa'] . '||';
        }
    } else if ($action == 1) {
        $ankietaID = $_GET['id'];

        $query = "SELECT * FROM ankieta WHERE id='".$ankietaID."';";
        $result = $conn->query($query);
        $row = $result->fetch_assoc();
        $id = $row['id'];

        $queryPytania = "SELECT * FROM ankieta_pytania WHERE ankieta_id='".$id."';";
        $resultPytania = $conn->query($queryPytania);
        while ($rowPytanie = $resultPytania->fetch_assoc()) {
            echo $id . '|' . $row['nazwa'] . '|' . $rowPytanie['id'] . '|' . $rowPytanie['tresc'] . '|' . $rowPytanie['typ'] . '||';
        }
    } else if ($action == 2) {
        $userId = $_GET['userID'];

        $query = "SELECT * FROM ankieta_odpowiedzi INNER JOIN ankieta_pytania ON ankieta_odpowiedzi.pytanie_id=ankieta_pytania.id WHERE ankieta_odpowiedzi.uzytkownik_id='".$userId."';";
        $result = $conn->query($query);
        while($row = $result->fetch_assoc()) {
            echo $row['ankieta_id'] . '|';
        }
    } else if ($action == 3) {
        $userID = $_GET['userID'];

        foreach($_GET as $key => $value) {
            if ($key != 'action' && $key != 'userID') {
                $query = "INSERT INTO ankieta_odpowiedzi (pytanie_id, uzytkownik_id, tresc) VALUES (".intval($key).", ".intval($userID).", '".$value."');";
                $result = $conn->query($query);
            }
        }
        echo "SUCCESS";
    } else if ($action == 4) {
        $surveyID = $_GET['surveyID'];

        $query = "SELECT a.nazwa as anazwa, p.id as pid, p.tresc as ptresc, p.typ as ptyp, o.tresc as otresc FROM ankieta_odpowiedzi o
            INNER JOIN ankieta_pytania p ON o.pytanie_id=p.id
            INNER JOIN ankieta a ON a.id=p.ankieta_id
            WHERE p.ankieta_id=".$surveyID.";";
        $result = $conn->query($query);

        while ($row = $result->fetch_assoc()) {
            echo $row['anazwa'] . '|' . $row['pid'] . '|' . $row['ptresc'] . '|' . $row['ptyp'] . '|' . $row['otresc'] . '||';
        }
    }

    $conn->close();
?>

<!doctype html>
<html>
    <?php include('templates/header.php'); ?>
    <link rel="stylesheet" type="text/css" href="css/contact.css" media="screen" />
    <?php include('templates/body.php'); ?>

                <div class="col-7 page-name">
                    <p>Hub</p>
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
        <script src="js/voting.js"></script>
    </body>
</html>