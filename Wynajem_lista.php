<?php
    $id = $_GET['id'];

    $conn = new mysqli('localhost', 'root', '', 'strona_baza');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT * FROM wynajem WHERE typ=".$id.";";
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        $queryPhotos = "SELECT * FROM wynajem_zdjecia WHERE mieszkanie_id='".$row['id']."';";
        $resultPhotos = $conn->query($queryPhotos);
        $rowCount = $resultPhotos->num_rows;
        if ($rowCount == 0) {
            echo $row['id'] . "|" . $row['adres'] . "|" . " " . "||";
        } else {
            while ($rowPhoto = $resultPhotos->fetch_assoc()) {
                echo $row['id'] . "|" . $row['adres'] . "|" . ($rowPhoto['link'] ?: " ") . "||";
            }
        }
    }

    $conn->close();
?>