<?php

  session_start();
  require_once dirname(__FILE__).'/../config/db_connect.php';

  function commentDateFilter($var){
    return $var['commentDate'] > $_POST['latestTicketDate'];
  }

  if (isset($_POST['ticketId']) && isset($_POST['latestTicketDate'])) {
    try {
      $ticketId = htmlspecialchars($_POST['ticketId']);
      $latestTicketDate = htmlspecialchars($_POST['latestTicketDate']);

      $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $latestTicketDate);
      $timestamp = $dateTime->getTimestamp();

      $dbConn = new DBConnector();
      $sql = "SELECT * FROM ticket_comments where ticketId='$ticketId' order by commentDate desc";
      $stmt = $dbConn->dbRequest($sql);
      $stmt->execute();
      $commentsDetails = array_filter($stmt->fetchAll(), 'commentDateFilter');

      for ($i = 0; $i < count($commentsDetails); $i++) {
        if ($commentsDetails[$i]['userId'] == $_SESSION['userId']) {
          $commentsDetails[$i]['reporter'] = 'c';
        } else {
          $commentsDetails[$i]['reporter'] = 'o';
        }
      }

      echo json_encode(['success' => true, 'data' => $commentsDetails]);
    } catch (Exception $ex) {
      echo json_encode(['success' => false, 'error' => $ex]);
    }

  }

?>