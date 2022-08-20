<?php
    $id = intval($_GET['id']);

    $conn = new mysqli('localhost', 'root', '', 'strona_baza');

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