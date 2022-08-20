<?php
    $id = $_GET['id'];
    $text = $_GET['text'];
    $image = $_GET['image'];
    $author = $_GET['author'];

    $conn = new mysqli('localhost', 'root', '', 'strona_baza');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "INSERT INTO uchwaly (ID_uchwaly, tresc_uchwaly, link, autor) VALUES ('".$id."', '".$text."', '".$image."', '".$author."')";

    $result=$conn->query($query);
    if ($result === TRUE) {
        echo "SUCCESS";
    } else {
        echo $result;
    }

    $conn->close();
?>