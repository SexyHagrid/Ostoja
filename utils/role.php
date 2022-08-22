<?php

  require_once dirname(__FILE__).'/../config/db_connect.php';

  class Role {
    public static function getRolesNames() {
      $dbConn = new DBConnector();
      $stmt = $dbConn->dbRequest("SELECT roleName FROM roles");
      $stmt->execute();
      $names = $stmt->fetchAll();

      return $names;
    }

    public static function getRoleIdByName($roleName) {
      $dbConn = new DBConnector();
      $stmt = $dbConn->dbRequest("SELECT roleId FROM roles where roleName = '$roleName'");
      $stmt->execute();
      $roleId = $stmt->fetchAll();

      return $roleId[0];
    }
  }

?>