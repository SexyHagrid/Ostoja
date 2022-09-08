<?php

  require_once dirname(__FILE__).'/../config/db_connect.php';

  class User {

    public static function getUsersEmails() {
      $dbConn = new DBConnector();
      $stmt = $dbConn->dbRequest("SELECT email FROM users");
      $stmt->execute();
      $emails = $stmt->fetchAll();

      return $emails;
    }

    public static function getUserDetails($email) {
      $dbConn = new DBConnector();
      $stmt = $dbConn->dbRequest("SELECT * FROM users where email = '$email'");
      $stmt->execute();
      $details = $stmt->fetchAll();

      return $details;
    }

    public static function getEmailsByRoleName($roleName) {
      $dbConn = new DBConnector();
      $stmt = $dbConn->dbRequest("SELECT email FROM users u inner join roles r on u.roleId=r.roleId where roleName = '$roleName'");
      $stmt->execute();
      $emails = $stmt->fetchAll();

      return $emails;
    }
  }

?>