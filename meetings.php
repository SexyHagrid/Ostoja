<?php

  session_start();
  if (!isset($_SESSION["loggedin"]) || $_SESSION['loggedin'] !== true) {
    header('Location: witaj');
  }

  include_once 'utils/permissions.php';
  include_once 'config/messages.php';
  include_once 'utils/breadcrumbs.php';

  $dbConn = new DBConnector();

  if (isset($_POST['edit-meeting-submit'])) {
    $meetingDateEdit = '';
    if (!isset($_POST['meeting-date-edit'])) {
      $error_prompt_message = 'Data jest wymagana';
    } else {
      $meetingDateEdit = $_POST['meeting-date-edit'];
    }

    if (isset($_POST['agenda-textarea-edit'])) {
      $meetingAgendaEdit = $_POST['agenda-textarea-edit'];
    }

    if (!$error_prompt_message) {
      $old_date = $_POST['meeting-date-old'];
      $sql = "UPDATE meetings SET meetingDate='$meetingDateEdit', agenda='$meetingAgendaEdit' WHERE meetingDate='$old_date'";
      $stmt = $dbConn->dbRequest($sql);
      $stmt->execute();
    }
  }

  function sortByDate($date_1, $date_2) {
    if ($date_1['meetingDate'] == $date_2['meetingDate']) {
        return 0;
    }
    return ($date_1['meetingDate'] < $date_2['meetingDate']) ? -1 : 1;
  }

  $stmt = $dbConn->dbRequest("SELECT * FROM meetings");
  $stmt->execute();
  $meetings = $stmt->fetchAll();
  $meetingsCount = count($meetings);
  usort($meetings, "sortByDate");

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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <?php include('templates/body.php'); ?>

        <div class="col-7 page-name">
          <div id="breadcrumbs-div">
            <nav class="navbar-expand-lg">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <?php Breadcrumbs::showBreadcrumbs(['page' => 'Spotkania', 'address' => 'spotkania']); ?>
                </ol>
              </nav>
            </nav>
          </div>
          <p>Terminarz spotkań</p>
        </div>
        <div class="col-2 upper-right-buttons">
          <?php if (Permissions::hasPermission("Panel administracyjny")): ?>
            <a href="panel-administracyjny"><p id="admin-panel">Panel administracyjny</p></a>
            <hr>
          <?php endif; ?>
          <a href="wyloguj"><p id="logout-in-p">Wyloguj</p></a>
        </div>
      </div>
    </div>

    <div class="curtain"></div>
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

        <form id="add-meeting-form" action="spotkania-dodaj">
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
              <div id="edit-closest-button"><span class="fa fa-pencil"></span></div>
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

        <form id="edit-meeting-div" action="spotkania" method="post">
          <div id="close-curtain">&#10006;</div>
          <h2>Edytuj spotkanie</h2>
          <input id="meeting-date-old" name="meeting-date-old" value="">
          <hr>
          <div id="edit-meeting-div-inner">
            <div id="edit-meeting-data">
              <label>
                <p>Data</p>
                <div class="red-text meeting-date-edit-red"></div>
                <input id="meeting-date-edit" name="meeting-date-edit">
              </label>
            </div>
            <label id="agenda-edit-outer">
              <p>Agenda</p>
              <textarea id="agenda-textarea-edit" name="agenda-textarea-edit"></textarea>
            </label>
            <input class="hover-bttn" id="edit-meeting-submit" type="submit" name="edit-meeting-submit" value="Zatwierdź">
          </div>
        </form>
      </div>
    </div>

    <?php include('templates/footer.php'); ?>
    <script src="js/meetings.js"></script>
  </body>
</html>