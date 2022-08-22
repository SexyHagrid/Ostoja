<?php

  class DBConnector {
    private static $servername = 'localhost';
    private static $dbname = 'wspolnota_ostoja';
    private static $username = 'root';
    private static $password = '';

    public static function dbRequest($query) {
      try {
        $conn = new PDO("mysql:host=".DBConnector::$servername."; dbname=".DBConnector::$dbname, DBConnector::$username, DBConnector::$password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn->prepare($query);
      } catch(PDOException $e) {
        echo "Błąd połączenia: " . $e->getMessage() . "<br>Prosimy o kontakt ze wsparciem technicznym";
      }
    }

    public function getConnector() {
      return $this->conn;
    }
  }

?>