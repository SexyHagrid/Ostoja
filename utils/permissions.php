<?php

  include_once 'config/db_connect.php';

  class Permissions {
  //   private $perms;

  //   public function __construct() {
  //     $this->perms = [];
  //   }

    // public function setPermissionsByRoleId($roleId) {
    //   $stmt = $this->conn->prepare("SELECT p.permissionId, p.permissionDesc FROM role_permissions rp inner join permissions p on rp.permissionId=p.permissionId where rp.roleId = $roleId");
    //   $stmt->execute();
    //   $permissions_db = $stmt->fetchAll();

    //   foreach($permissions_db as $permission) {
    //     $this->perms[$permission['permissionId']] = $permission['permissionDecr'];
    //   }
    //   $conn = null;
    // }

    // public function setPermissionsByUserId($userId) {
    //   $error_prompt_message = '';  // TODO: refactor to external error module
    //   $servername = "localhost";
    //   $dbname = "test_base";
    //   $username = "root";

    //   try {
    //     $conn = new PDO(
    //       "mysql:host=$servername; dbname=$dbname",
    //       $username, ""
    //     );
    //     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //   } catch(PDOException $e) {
    //     $error_prompt_message = "Błąd połączenia: " . $e->getMessage() . "<br>Prosimy o kontakt ze wsparciem technicznym";
    //   }

    //   $stmt = $conn->prepare("SELECT p.permissionId, p.permissionDesc FROM user_permissions up inner join permissions p on up.permissionId=p.permissionId where up.userId = $userId");
    //   $stmt->execute();
    //   $permissions_db = $stmt->fetchAll();

    //   foreach($permissions_db as $permission) {
    //     $this->perms[$permission['permissionId']] = $permission['permissionDecr'];
    //   }
    //   $conn = null;
    // }

    // public function getPermissions() {
    //   return $this->perms;
    // }

    public static function hasPermission($perm) {
      $dbConn = new DBConnector();
      $stmt = $dbConn->fetch("SELECT p.permissionId FROM user_permissions up inner join permissions p on up.permissionId=p.permissionId where up.userId = ${_SESSION['userId']} and p.permissionDesc = '$perm'");
      $stmt->execute();
      $permission = $stmt->fetchAll();

      if (!empty($permission)) {
        return true;
      }

      return false;
    }
  }

?>