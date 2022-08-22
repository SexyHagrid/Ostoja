<?php

    include_once 'config/messages.php';
    include_once 'utils/permissions.php';

    $action = intval($_GET['action']);

    $conn = new mysqli('localhost', 'root', '', 'wspolnota_ostoja');

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
            $tmp = explode('.', $_FILES['files']['name'][$i]);
            $file_ext = strtolower(end($tmp));

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

<!doctype html>
<html>
    <?php include('templates/header.php'); ?>
    <link rel="stylesheet" type="text/css" href="css/renting_categories.css" media="screen" />
    <?php include('templates/body.php'); ?>

                <div class="col-7 page-name">
                    <p>Dodaj</p>
                    </div>
                <div class="col-2 upper-right-buttons">
                    <?php if (Permissions::hasPermission("Panel administracyjny")): ?>
                        <a href="admin_panel.php"><p id="admin-panel">Panel administracyjny</p></a>
                        <hr>
                    <?php endif; ?>
                    <a href="logout.php"><p>Wyloguj</p></a>
                </div>
            </div>
        </div>

        <div class="row justify-content-center" id="contentDiv">
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <table>
                <tr>
                <td>
                    <label>Typ mieszkania:</label>
                </td>
                <td>
                    <select id="typeSelectElement"></select>
                </td>
                </tr>
                <tr>
                <td>
                    <label>Czynsz:*</label>
                </td>
                <td>
                    <input type="number" id="priceElement"/>
                </td>
                </tr>
                <tr>
                <td>
                    <label>Adres:*</label>
                </td>
                <td>
                    <input type="text" id="addressElement"/>
                </td>
                </tr>
                <tr>
                <td>
                    <label>Okres wynajmu:*</label>
                </td>
                <td>
                    <input type="text" id="timeElement"/>
                </td>
                </tr>
                <tr>
                <td>
                    <label>Telefon:*</label>
                </td>
                <td>
                    <input type="text" id="phoneNumberElement"/>
                </td>
                </tr>
                <tr>
                <td>
                    <label>Dodatkowe informacje:</label>
                </td>
                <td>
                    <textarea id="additionalInfoElement" rows="5"></textarea>
                </td>
                </tr>
                <tr>
                <td>
                    <label>Zdjęcia:</label>
                </td>
                <td>
                    <input id="uploadPhotosElement" type="file" multiple/>
                </td>
                </tr>
                <tr>
                <td>

                </td>
                <td>
                    <button id="submitButton" onclick="onSendButtonClick()">Wyślij</button>
                </td>
                </tr>
            </table>
            </div>
        </div>

        <?php include('templates/footer.php'); ?>
        <script src="js/renting_add.js"></script>
    </body>
</html>