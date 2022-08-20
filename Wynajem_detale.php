<?php
    $id = $_GET['id'];

    $conn = new mysqli('localhost', 'root', '', 'strona_baza');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT * FROM wynajem WHERE id='".$id."';";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();

    $queryPhotos = "SELECT * FROM wynajem_zdjecia WHERE mieszkanie_id='".$row['id']."';";
    $resultPhotos = $conn->query($queryPhotos);
    $resultPhotosCount = $resultPhotos->num_rows;

    if ($resultPhotosCount == 0) {
        echo $row['id'] . "|" .  $row['czynsz'] . "|" . $row['adres'] . "|" . $row['okres_wynajmu'] . "|" . $row['telefon'] . "|" . ($row['dodatkowe_informacje'] ?: ' ') . "|" . " " . "|" . $row['typ'] . "||";
    } else {
        while ($rowPhoto = $resultPhotos->fetch_assoc()) {
            echo $row['id'] . "|" .  $row['czynsz'] . "|" . $row['adres'] . "|" . $row['okres_wynajmu'] . "|" . $row['telefon'] . "|" . ($row['dodatkowe_informacje'] ?: ' ') . "|" . ($rowPhoto['link'] ?: " ") . "|" . $row['typ'] . "||";
        }
    }

    $conn->close();
?>