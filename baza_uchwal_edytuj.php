<?php
    $id = intval($_GET['id']);
    $text = $_GET['text'];
    $image = $_GET['image'];
    $author = $_GET['author'];

    $conn = new mysqli('localhost', 'root', '', 'strona_baza');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($text)) {
        $query = "UPDATE uchwaly SET tresc_uchwaly='".$text."', link='".$image."' WHERE ID_uchwaly='".$id."';";
        $result=$conn->query($query);

        if ($result === TRUE) {
            echo "SUCCESS";
        } else {
            echo $result;
        }
    } else {
        $query = "SELECT * FROM uchwaly WHERE ID_uchwaly='".$id."';";
        $result=$conn->query($query);
        $row=$result->fetch_assoc();
        echo $row['ID_uchwaly'] . '|' . $row['tresc_uchwaly'] . '|' . $row['link'] . '|' . $row['autor'];
    }

    $conn->close();
?>