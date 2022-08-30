<?php

  session_start();
  if (!isset($_SESSION["loggedin"]) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
  }

  include_once 'utils/permissions.php';
  include_once 'config/messages.php';
  include_once 'utils/breadcrumbs.php';


  $dbConn = new DBConnector();
  $stmt = $dbConn->dbRequest("SELECT * FROM meetings");
  $stmt->execute();
  $meetings = $stmt->fetchAll();
  $meetingsCount = count($meetings);

  $closestMeeting = $meetings[0]['meetingDate'];
  $currentDateTime = new DateTime(date('Y-m-d h:i:s'));
  $firstMeet = new DateTime($closestMeeting);
  $lowestDiff = abs($firstMeet->getTimestamp()-$currentDateTime->getTimestamp());
  for($i = 1; $i < $meetingsCount; $i++) {
    $meetDate = new DateTime($meetings[$i]['meetingDate']);
    $meetDateTimestamp = abs($meetDate->getTimestamp()-$currentDateTime->getTimestamp());
    if ($meetDateTimestamp <= $lowestDiff) {
      $lowestDiff = $meetDateTimestamp;
      $closestMeeting = $meetings[$i]['meetingDate'];
    }
  }
?>

<!doctype html>
<html>
  <?php include('templates/header.php'); ?>
  <link rel="stylesheet" type="text/less" href="css/meetings.less" />
  <?php include('templates/body.php'); ?>

        <div class="col-7 page-name">
          <div id="breadcrumbs-div">
            <nav class="navbar-expand-lg">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <?php Breadcrumbs::showBreadcrumbs(['page' => 'Spotkania', 'address' => 'meetings.php']); ?>
                </ol>
              </nav>
            </nav>
          </div>
          <p>Terminarz spotkań</p>
        </div>
        <div class="col-2 upper-right-buttons">
          <?php if (Permissions::hasPermission("Panel administracyjny")): ?>
            <a href="admin_panel.php"><p id="admin-panel">Panel administracyjny</p></a>
            <hr>
          <?php endif; ?>
          <a href="logout.php"><p>Wyloguj</p></a>
        </div>
      </div>
    </div>

    <div class="row main-content-row">
      <div class="upper-elements">
        <div class="upper-meetings-overview-outer">
          <div class="upper-meetings-overview-inner">
            <?php foreach($meetings as $meeting): ?>
              <div class="meeting-overview-tile <?php if ($meeting['meetingDate'] == $closestMeeting) echo 'mot-chosen'; ?>">
                <p class="x-glyph">&#10006;</p>
                <p class="inner-text"><?php echo $meeting['meetingDate']; ?></p>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <form id="add-meeting-form" action="meetings_add.php">
          <div id="buttons">
            <button id="edit-meetings" type="button">Edytuj</button>
            <input id="add-meeting" type="submit" name="add-meeting-submit" value="Dodaj spotkanie">
          </div>
        </form>
      </div>

      <div class="meetings-div">
        <?php for($i = 0; $i < $meetingsCount; $i++):
          if ($meetings[$i]['meetingDate'] == $closestMeeting): ?>
            <div id="meeting-closest">
              <p class="div-header">Najbliższe spotkanie</p>
              <h2 class="div-date" id="closest-date"><?php echo $meetings[$i]['meetingDate']; ?></h2>
              <hr>
              <h3>Agenda</h3>
              <p id="closest-agenda">
                <?php echo $meetings[$i]['agenda']; ?>
              </p>
            </div>
          <?php elseif ($meetingsCount >= 2 && $i < $meetingsCount-2 && $meetings[$i+1]['meetingDate'] == $closestMeeting): ?>
            <div id="meeting-past">
              <p class="div-header">Ubiegłe spotkanie</p>
              <h4 class="div-date" id="past-date"><?php echo $meetings[$i]['meetingDate']; ?></h4>
            </div>
          <?php elseif ($meetingsCount >= 3 && $i > 1 && $meetings[$i-1]['meetingDate'] == $closestMeeting): ?>
            <div id="meeting-incoming">
              <p class="div-header">Nadchodzące spotkanie</p>
              <h4 class="div-date" id="incoming-date"><?php echo $meetings[$i]['meetingDate'];?></h4>
            </div>
          <?php endif; ?>
        <?php endfor; ?>
      </div>
    </div>

    <?php include('templates/footer.php'); ?>
    <script src="js/meetings.js"></script>
  </body>
</html>