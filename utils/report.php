<?php

  require_once dirname(__FILE__).'/../config/db_connect.php';

  class Report {

    public static function getReports() {
      $dbConn = new DBConnector();
      $stmt = $dbConn->dbRequest("SELECT * FROM reports");
      $stmt->execute();
      $reports = $stmt->fetchAll();

      return $reports;
    }
  }

?>