<?php


  class Role {
    // private $roleId;
    // private $roleName;
    // private $permissions;
    // private $conn;

    // public function __construct($email) {
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


    //   $this->fetchRoleByEmail($email);
    //   // $this->fetchPermissions();
    // }

    // public function fetchRoleByEmail($email) {
    //   $stmt = $this->conn->prepare("SELECT r.roleId, r.roleName FROM roles r inner join users u on r.roleId=u.roleId where u.email like '$email'");
    //   $stmt->execute();
    //   $role = $stmt->fetchAll();
    //   $conn = null;

    //   $this->roleId = $role[0]['roleId'];
    //   $this->roleName = $role[0]['roleName'];
    // }

    // public function fetchPermissions() {
    //   $stmt = $conn->prepare("SELECT permissions FROM permissions inner join roles r on p.roleId=u.roleId where u.email like '$email'");
    //   $stmt->execute();
    //   $role = $stmt->fetchAll();
    //   $conn = null;
    // }
  }

?>