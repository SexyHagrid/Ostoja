<?php

  class DBConnector {
    private $servername = 'localhost';
    private $dbname = 'test_base';
    private $username = 'root';
    private $password = '';

    public static function fetch($query) {
      try {
        $conn = new PDO("mysql:host=localhost; dbname=test_base", 'root', '');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn->prepare($query);
      } catch(PDOException $e) {
        echo "Błąd połączenia: " . $e->getMessage() . "<br>Prosimy o kontakt ze wsparciem technicznym";
        // $error_prompt_message = "Błąd połączenia: " . $e->getMessage() . "<br>Prosimy o kontakt ze wsparciem technicznym"; // TODO: refactor to external module
      }
    }

    public function getConnector() {
      return $this->conn;
    }
  }

?>