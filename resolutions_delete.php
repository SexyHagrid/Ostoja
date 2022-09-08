<?php
    session_start();
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false) {
        header('Location: index.php');
    }

    $id = intval($_GET['id']);

    $conn = new mysqli('localhost', 'root', '', 'wspolnota_ostoja');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query="DELETE FROM uchwaly WHERE ID_uchwaly=".$id.";";
    $result=$conn->query($query);

    $queryFiles="DELETE FROM uchwaly_pliki WHERE uchwala_id=".$id.";";
    $resultFiles = $conn->query($queryFiles);

    if ($result === TRUE && $resultFiles === TRUE) {
        echo "SUCCESS";
    } else {
        echo $result;
    }

    $conn->close();
?>