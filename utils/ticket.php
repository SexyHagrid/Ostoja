<?php

  require_once dirname(__FILE__).'/../config/db_connect.php';

  class Ticket {

    public static function assignAssignee($email, $ticketId) {
      try {
        $dbConn = new DBConnector();
        $stmt = $dbConn->dbRequest("SELECT userId FROM users where email='$email'");
        $stmt->execute();
        $usersIds = $stmt->fetchAll();
        $userId = $usersIds[0]['userId'];

        $sql = "UPDATE tickets SET assigneeId=$userId WHERE ticketId=$ticketId";
        $stmt = $dbConn->dbRequest($sql);
        $stmt->execute();

        return true;
      } catch (Exception) {
        return false;
      }
    }

    public static function changeType($type, $ticketId) {
      try {
        $dbConn = new DBConnector();
        $sql = "UPDATE tickets SET ticketType='$type' WHERE ticketId=$ticketId";
        $stmt = $dbConn->dbRequest($sql);
        $stmt->execute();

        return true;
      } catch (Exception $ex) {
        return false;
      }
    }

    public static function changePriority($priority, $ticketId) {
      try {
        $dbConn = new DBConnector();
        $sql = "UPDATE tickets SET priority='$priority' WHERE ticketId=$ticketId";
        $stmt = $dbConn->dbRequest($sql);
        $stmt->execute();

        return true;
      } catch (Exception $ex) {
        return false;
      }
    }

    public static function changeStatus($status, $ticketId) {
      try {
        $dbConn = new DBConnector();
        $sql = "UPDATE tickets SET ticketStatus='$status' WHERE ticketId=$ticketId";
        $stmt = $dbConn->dbRequest($sql);
        $stmt->execute();

        return true;
      } catch (Exception $ex) {
        return $ex;
      }
    }
  }

?>