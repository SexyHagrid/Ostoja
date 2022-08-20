<?php
    //$number = intval($_GET['numer']);

    $conn = new mysqli('localhost', 'root', '', 'strona_baza');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query="SELECT * FROM aktualnosci" ;

    $result=$conn->query($query);

    while ($row = $result->fetch_assoc()) {
        echo $row['ID_aktualnosci'] . '|' . $row['tresc_aktualnosci'] . '|' . ($row['link'] ?: ' ') . '|' . $row['autor'] . '||';
    }

    $conn->close();
?>