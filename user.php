<?php
    $sessionID = $_GET['sessionID'];

    $conn = new mysqli('remotemysql.com', 'lpqiJahZh5', '6m9cW0YAt2', 'lpqiJahZh5');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query="SELECT users.id, role, numer_sesji FROM sesja INNER JOIN users ON sesja.uzytkownik=users.ID WHERE numer_sesji='".$sessionID."';";
    $result=$conn->query($query);

    $row = $result->fetch_assoc();
    echo $row['id'] . '|' . $row['role'];

    $conn->close();
?>