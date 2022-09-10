<?php

  class DBConnector {
    private static $servername = 'remotemysql.com';
    private static $dbname = 'lpqiJahZh5';
    private static $username = 'lpqiJahZh5';
    private static $password = '6m9cW0YAt2';

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