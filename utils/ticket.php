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

        $ticketDateUpdate = date('Y/m/d h:i:s', time());

        $sql = "UPDATE tickets SET assigneeId=$userId, ticketDateUpdate='$ticketDateUpdate' WHERE ticketId=$ticketId";
        $stmt = $dbConn->dbRequest($sql);
        $stmt->execute();

        $ticketDetails = Ticket::getDetails($ticketId);

        return ['status' => true, 'data' => ['ticketDateUpdate' => $ticketDetails['ticketDateUpdate']]];
      } catch (Exception $ex) {
        return ['status' => false, 'data' => $ex];
      }
    }

    public static function changeType($type, $ticketId) {
      try {
        $dbConn = new DBConnector();
        $ticketDateUpdate = date('Y/m/d h:i:s', time());
        $sql = "UPDATE tickets SET ticketType='$type', ticketDateUpdate='$ticketDateUpdate' WHERE ticketId=$ticketId";
        $stmt = $dbConn->dbRequest($sql);
        $stmt->execute();

        $ticketDetails = Ticket::getDetails($ticketId);

        return ['status' => true, 'data' => ['ticketDateUpdate' => $ticketDetails['ticketDateUpdate']]];
      } catch (Exception $ex) {
        return ['status' => false, 'data' => $ex];
      }
    }

    public static function changePriority($priority, $ticketId) {
      try {
        $dbConn = new DBConnector();
        $ticketDateUpdate = date('Y/m/d h:i:s', time());
        $sql = "UPDATE tickets SET priority='$priority', ticketDateUpdate='$ticketDateUpdate' WHERE ticketId=$ticketId";
        $stmt = $dbConn->dbRequest($sql);
        $stmt->execute();

        $ticketDetails = Ticket::getDetails($ticketId);

        return ['status' => true, 'data' => ['ticketDateUpdate' => $ticketDetails['ticketDateUpdate']]];
      } catch (Exception $ex) {
        return ['status' => false, 'data' => $ex];
      }
    }

    public static function changeStatus($status, $ticketId) {
      try {
        $sql = '';
        $ticketDateEnd = date('Y/m/d h:i:s', strtotime('+2 hours'));
        if ($status === 'ZAKOŃCZONY' || $status === 'ANULOWANY') {
          $sql = "UPDATE tickets SET ticketStatus='$status', ticketDateUpdate='$ticketDateEnd', ticketDateEnd='$ticketDateEnd' WHERE ticketId=$ticketId";
        } else {
          $sql = "UPDATE tickets SET ticketStatus='$status', ticketDateUpdate='$ticketDateEnd' WHERE ticketId=$ticketId";
        }

        $dbConn = new DBConnector();
        $stmt = $dbConn->dbRequest($sql);
        $stmt->execute();

        $ticketDetails = Ticket::getDetails($ticketId);

        return ['status' => true, 'data' => ['ticketDateUpdate' => $ticketDetails['ticketDateUpdate'], 'ticketDateEnd' => $ticketDetails['ticketDateEnd']]];
      } catch (Exception $ex) {
        return ['status' => false, 'data' => $ex];
      }
    }

    public static function changeDescription($description, $ticketId) {
      try {
        $dbConn = new DBConnector();
        $ticketDateUpdate = date('Y/m/d h:i:s', time());
        $sql = "UPDATE tickets SET description='$description', ticketDateUpdate='$ticketDateUpdate' WHERE ticketId=$ticketId";
        $stmt = $dbConn->dbRequest($sql);
        $stmt->execute();

        $ticketDetails = Ticket::getDetails($ticketId);

        return ['status' => true, 'data' => ['ticketDateUpdate' => $ticketDetails['ticketDateUpdate']]];
      } catch (Exception $ex) {
        return ['status' => false, 'data' => $ex];
      }
    }
  }

?>