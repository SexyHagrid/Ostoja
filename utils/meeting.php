<?php

  require_once dirname(__FILE__).'/../config/db_connect.php';

  class Meeting {

    public static function getMeeting($date) {
      $dbConn = new DBConnector();
      $stmt = $dbConn->dbRequest("SELECT * FROM meetings where meetingDate = '$date'");
      $stmt->execute();
      $details = $stmt->fetchAll();
      $dbConn = null;

      return $details;
    }

    public static function deleteMeeting($date) {
      $dbConn = new DBConnector();
      $stmt = $dbConn->dbRequest("DELETE FROM meetings WHERE meetingDate='$date'");
      $stmt->execute();

      $stmt = $dbConn->dbRequest("SELECT * FROM meetings where meetingDate = '$date'");
      $stmt->execute();
      $meetings = $stmt->fetchAll();
      $dbConn = null;

      if (count($meetings) == 0) {
        return true;
      } else {
        return false;
      }
    }

  }

?>