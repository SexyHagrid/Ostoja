<?php
    session_start();
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false) {
        header('Location: witaj');
    }

    $id = intval($_GET['id']);

    $conn = new mysqli('remotemysql.com', 'lpqiJahZh5', '6m9cW0YAt2', 'lpqiJahZh5');

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