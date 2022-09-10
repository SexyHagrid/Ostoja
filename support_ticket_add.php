<?php

  session_start();
  if (!isset($_SESSION["loggedin"]) || $_SESSION['loggedin'] !== true) {
    header('Location: witaj');
  }

  include_once 'utils/permissions.php';
  include_once 'config/messages.php';

  if (!Permissions::hasPermission('Dodawanie zgłoszeń')) {
    header('Location: wsparcie-techniczne');
  }

  $dbConn = new DBConnector();

  if (isset($_POST['create-ticket-submit'])) {
    $ticketName = $_POST['create-ticket-topic'];
    $ticketPriority = $_POST['create-ticket-priority'];
    $ticketDesc = $_POST['create-ticket-description'];

    $sql = "INSERT INTO tickets (ticketId, ticketName, description, ticketStatus, priority, ticketDateStart, ticketDateEnd, userId)
            VALUES (:ticketId, :ticketName, :description, :ticketStatus, :priority, :ticketDateStart, :ticketDateEnd, :userId)";
    $stmt = $dbConn->dbRequest($sql);
    $stmt->execute([':ticketId'=>null, ':ticketName'=>$ticketName, ':description'=>$ticketDesc, ':ticketStatus'=>'OTWARTY', ':priority'=>$ticketPriority, ':ticketDateStart'=>null, ':ticketDateEnd'=>null, ':userId'=>$_SESSION['userId']]);
  }

  $stmt = $dbConn->dbRequest("SELECT * FROM tickets");
  $stmt->execute();
  $tickets = $stmt->fetchAll();
  $ticketsCount = count($tickets);

?>