<?php

  require_once dirname(__FILE__).'/../config/db_connect.php';

  class Ticket {

    public static function getDetails($ticketId) {
      $dbConn = new DBConnector();
      $stmt = $dbConn->dbRequest("SELECT * FROM tickets where ticketId=$ticketId");
      $stmt->execute();
      $details = $stmt->fetchAll();

      return $details[0];
    }

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

        $ticketDetails = Ticket::getDetails($ticketId);

        return ['status' => true, 'data' => ['ticketDateUpdate' => $ticketDetails['ticketDateUpdate']]];
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

        $ticketDetails = Ticket::getDetails($ticketId);

        return ['status' => true, 'data' => ['ticketDateUpdate' => $ticketDetails['ticketDateUpdate']]];
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

        $ticketDetails = Ticket::getDetails($ticketId);

        return ['status' => true, 'data' => ['ticketDateUpdate' => $ticketDetails['ticketDateUpdate']]];
      } catch (Exception $ex) {
        return false;
      }
    }

    public static function changeStatus($status, $ticketId) {
      try {
        $sql = '';
        if ($status === 'ZAKOŃCZONY' || $status === 'ANULOWANY') {
          $sql = "UPDATE tickets SET ticketStatus='$status', ticketDateEnd=CURRENT_TIMESTAMP WHERE ticketId=$ticketId";
        } else {
          $sql = "UPDATE tickets SET ticketStatus='$status' WHERE ticketId=$ticketId";
        }

        $dbConn = new DBConnector();
        $stmt = $dbConn->dbRequest($sql);
        $stmt->execute();

        $ticketDetails = Ticket::getDetails($ticketId);

        return ['status' => true, 'data' => ['ticketDateUpdate' => $ticketDetails['ticketDateUpdate'], 'ticketDateEnd' => $ticketDetails['ticketDateEnd']]];
      } catch (Exception $ex) {
        return ['status' => false];
      }
    }

    public static function changeDescription($description, $ticketId) {
      try {
        $dbConn = new DBConnector();
        $sql = "UPDATE tickets SET description='$description' WHERE ticketId=$ticketId";
        $stmt = $dbConn->dbRequest($sql);
        $stmt->execute();

        $ticketDetails = Ticket::getDetails($ticketId);

        return ['status' => true, 'data' => ['ticketDateUpdate' => $ticketDetails['ticketDateUpdate']]];
      } catch (Exception $ex) {
        return ['status' => false];
      }
    }
  }

?>