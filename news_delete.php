<?php
    session_start();
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false) {
    header('Location: witaj');
    }

    $id = intval($_GET['id']);

    $conn = new mysqli('localhost', 'root', '', 'wspolnota_ostoja');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query="DELETE FROM aktualnosci WHERE ID_aktualnosci='".$id."';";

    $result=$conn->query($query);
    if ($result === TRUE) {
        echo "SUCCESS";
    } else {
        echo $result;
    }

    $conn->close();
?>