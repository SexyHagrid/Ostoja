<?php
  session_start();
  require_once dirname(__FILE__).'/../config/db_connect.php';
  require_once './ticket.php';

  if (isset($_POST['ticketId']) && isset($_POST['commentText'])) {
    try {
      $ticketId = (int) htmlspecialchars($_POST['ticketId']);
      $commentText = htmlspecialchars($_POST['commentText']);
      $userId = $_SESSION['userId'];
      $userName = $_SESSION['name'];
      $userSurname = $_SESSION['surname'];

      $dbConn = new DBConnector();
      $sql = "INSERT INTO ticket_comments (ticketCommentId, ticketId, userId, userName, userSurname, commentText, commentDate)
              VALUES (:ticketCommentId, :ticketId, :userId, :userName, :userSurname, :commentText, :commentDate)";
      $stmt = $dbConn->dbRequest($sql);
      $stmt->execute([':ticketCommentId'=>null, ':ticketId'=>$ticketId, ':userId'=>$userId, ':userName'=>$userName, ':userSurname'=>$userSurname, ':commentText'=>$commentText, ':commentDate'=>null]);

      $sql = "SELECT * FROM ticket_comments";
      $stmt = $dbConn->dbRequest($sql);
      $stmt->execute();
      $commentsDetails = $stmt->fetchAll();

      echo json_encode(['success' => true, 'data' => $commentsDetails[count($commentsDetails)-1]]);
    } catch (Exception $ex) {
      echo json_encode(['success' => false]);
    }
  }

  if (isset($_POST['method']) && isset($_POST['ticketId'])) {
      if ($_POST['method'] == 'assignCurrent') {
      try {
        $ticketId = (int) htmlspecialchars($_POST['ticketId']);
        $userId = $_SESSION['userId'];

        $dbConn = new DBConnector();
        $sql = "UPDATE tickets SET assigneeId=$userId WHERE ticketId=$ticketId";
        $stmt = $dbConn->dbRequest($sql);
        $stmt->execute();

        echo json_encode(['success' => true, 'data' => ['email' => $_SESSION['email']]]);
      } catch (Exception $ex) {
        echo json_encode(['success' => false]);
      }
    }
  }

  if (isset($_POST['method']) && isset($_POST['ticketId'])) {
    if ($_POST['method'] === 'changeTicketType') {
      $ticketId = (int) htmlspecialchars($_POST['ticketId']);
      $ticketType = htmlspecialchars($_POST['ticketType']);

      $response = Ticket::changeType($ticketType, $ticketId);

      echo json_encode(['success' =>  $response['status'], 'data' => $response['data']]);
    }

    if ($_POST['method'] === 'changeTicketPriority') {
      $ticketId = (int) htmlspecialchars($_POST['ticketId']);
      $ticketPriority = htmlspecialchars($_POST['priority']);

      $response = Ticket::changePriority($ticketPriority, $ticketId);

      echo json_encode(['success' => $response['status'], 'data' => $response['data']]);
    }

    if ($_POST['method'] === 'changeTicketStatus') {
      $ticketId = (int) htmlspecialchars($_POST['ticketId']);
      $ticketStatus = htmlspecialchars($_POST['ticketStatus']);

      $response = Ticket::changeStatus($ticketStatus, $ticketId);

      echo json_encode(['success' => $response['status'], 'data' => $response['data']]);
    }

    if ($_POST['method'] === 'changeTicketDescription') {
      $ticketId = (int) htmlspecialchars($_POST['ticketId']);
      $ticketDescription = htmlspecialchars($_POST['ticketDescription']);

      $response = Ticket::changeDescription($ticketDescription, $ticketId);

      echo json_encode(['success' =>  $response['status'], 'data' => $response['data']]);
    }
  }
?>