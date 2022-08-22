<?php

  require_once dirname(__FILE__).'/../config/db_connect.php';

  class Permissions {

    public static function hasPermission($perm) {
      if (!isset($_SESSION)) {
        return false;
      }

      $userId = $_SESSION['userId'];
      $dbConn = new DBConnector();
      $stmt = $dbConn->dbRequest("SELECT p.permissionId FROM user_permissions up inner join permissions p on up.permissionId=p.permissionId where up.userId = '$userId' and p.permissionDesc = '$perm'");
      $stmt->execute();
      $permission = $stmt->fetchAll();

      if (!empty($permission)) {
        return true;
      }

      return false;
    }

    public static function getPermissions() {
      $dbConn = new DBConnector();
      $stmt = $dbConn->dbRequest("SELECT * FROM permissions");
      $stmt->execute();
      $permissions = $stmt->fetchAll();

      return $permissions;
    }

    public static function getPermissionsByRole($roleId) {
      $dbConn = new DBConnector();
      $stmt = $dbConn->dbRequest("SELECT p.permissionId, p.permissionDesc FROM role_permissions rp inner join permissions p on rp.permissionId=p.permissionId where rp.roleId = $roleId");
      $stmt->execute();
      $permissions = $stmt->fetchAll();

      return $permissions;
    }

    public static function getPermissionsByUser($userId) {
      $dbConn = new DBConnector();
      $stmt = $dbConn->dbRequest("SELECT p.permissionId, p.permissionDesc FROM user_permissions up inner join permissions p on up.permissionId=p.permissionId where up.userId = $userId");
      $stmt->execute();
      $permissions = $stmt->fetchAll();

      return $permissions;
    }
  }

?>