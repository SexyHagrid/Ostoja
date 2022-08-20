<?php
    // $number = intval($_GET['numer']);

    $conn = new mysqli('localhost', 'root', '', 'strona_baza');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // $query="SELECT * FROM uchwaly WHERE ID_uchwaly=$number";
    $query="SELECT * FROM uchwaly";

    $result=$conn->query($query);

    while ($row = $result->fetch_assoc()) {
        echo $row['ID_uchwaly'] . '|' . $row['tresc_uchwaly'] . '|' . ($row['link'] ?: ' ') . '|' . $row['autor'] . '||';
    }

    $conn->close();
?>