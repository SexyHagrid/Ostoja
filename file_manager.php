<?php
    session_start();
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false) {
        header('Location: witaj');
    }

    if (isset($_GET['action'])) {
        $id = intval($_GET['id']);

        $conn = new mysqli('localhost', 'root', '', 'wspolnota_ostoja');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $action = intval($_GET['action']);
        
        if ($action == 1) {
            $directoryPath = $_GET['directoryPath'];
            if (!file_exists($directoryPath)) {
                $result = mkdir($directoryPath, 0777, true);
                if ($result) {
                    echo "SUCCESS";
                } else {
                    echo "FAIL";
                }
            } else {
                echo "SUCCESS";
            }

        }

        $conn->close();
    }

?>