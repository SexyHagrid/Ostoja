<?php
    $action = intval($_GET['action']);

    $conn = new mysqli('localhost', 'root', '', 'strona_baza');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($action == 0) {
        $query = "SELECT * FROM wynajem_typ";
        $result = $conn->query($query);

        while ($row = $result->fetch_assoc()) {
            echo $row['id'] . "|" . $row['text'] . "||";
        }
    } else if ($action == 1) {
        $errors = [];
        $directory = $_GET['directory'];
        $extensions = ['jpg', 'jpeg', 'png', 'gif'];

        $all_files = count($_FILES['files']['tmp_name']);

        for ($i = 0; $i < $all_files; $i++) {
            $file_name = $_FILES['files']['name'][$i];
            $file_tmp = $_FILES['files']['tmp_name'][$i];
            $file_type = $_FILES['files']['type'][$i];
            $file_size = $_FILES['files']['size'][$i];
            $file_ext = strtolower(end(explode('.', $_FILES['files']['name'][$i])));

            $file = $directory . $file_name;

            if (!in_array($file_ext, $extensions)) {
                $errors[] = 'Extension not allowed: ' . $file_name . ' ' . $file_type;
            }

            if ($file_size > 2097152) {
                $errors[] = 'File size exceeds limit: ' . $file_name . ' ' . $file_type;
            }

            if (empty($errors)) {
                move_uploaded_file($file_tmp, $file);
                echo($file_name . "|");
            }
        }

        if ($errors) print_r($errors);
    } else if ($action == 2) {
        $type = intval($_GET['type']);
        $price = intval($_GET['price']);
        $address = $_GET['address'];
        $time = $_GET['time'];
        $phone = $_GET['phone'];
        $info = $_GET['info'];

        $query = "INSERT INTO wynajem (typ, czynsz, adres, okres_wynajmu, telefon, dodatkowe_informacje)
         VALUES (".$type.", ".$price.", '".$address."', '".$time."', '".$phone."', '".$info."');";

        $result = $conn->query($query);
        if ($result === TRUE) {
            $query = "SELECT id FROM wynajem WHERE adres='".$address."';";
            $result = $conn->query($query);
            $row = $result->fetch_assoc();
            echo $row['id'];
        } else {
            echo "Error adding rental offer";
        }

        
    } else if ($action == 3) {
        $rentalId = intval($_GET['rentalId']);
        $fileName = $_GET['fileName'];
        echo ($fileName . "|");

        $query = "INSERT INTO wynajem_zdjecia (mieszkanie_id, link) VALUES (".$rentalId.", '".$fileName."');";
        $conn->query($query);
    }

    $conn->close();
?>