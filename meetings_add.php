<?php

  session_start();
  if (!isset($_SESSION["loggedin"]) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
  }

  include_once 'utils/permissions.php';
  include_once 'config/messages.php';
  include_once 'utils/breadcrumbs.php';

  $errors = ['meeting-date' => ''];

  if (isset($_POST['add-meeting-cancel'])) {
    header('Location: meetings.php');
  }

  if (isset($_POST['add-meeting-submit'])) {
    if (empty($_POST['meeting-date'])) {
      $errors['meeting-date'] = 'Data jest wymagana';
    } else {
      $meetingDate = $_POST['meeting-date'];

      if (!empty($_POST['meeting-agenda'])) {
        $meetingAgenda = $_POST['meeting-agenda'];
      }

      $dbConn = new DBConnector();
      $sql = "INSERT INTO meetings (meetingId, meetingDate, agenda) VALUES (:meetingId, :meetingDate, :agenda)";
      $stmt = $dbConn->dbRequest($sql);
      $stmt->execute([':meetingId'=>null, ':meetingDate'=>$meetingDate, ':agenda'=>$meetingAgenda]);

      header('Location: meetings.php');
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
                  <?php Breadcrumbs::showBreadcrumbs(['page' => 'Spotkania - dodaj', 'address' => 'meetings_add.php']); ?>
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
      <form id="submit-meeting-form" action="meetings_add.php" method="post">
        <div id="buttons">
          <label>
            <div class="red-text"><?php echo $errors['meeting-date']; ?></div>
            <input id="meeting-date" name="meeting-date" placeholder="Data spotkania">
          </label>
          <label>
            <p>Agenda</p>
            <input id="meeting-agenda" name="meeting-agenda">
          </label>
          <input id="add-meeting-cancel" type="submit" name="add-meeting-cancel" value="Anuluj">
          <input id="add-meeting-submit" type="submit" name="add-meeting-submit" value="Zatwierdź">
        </div>
      </form>
    </div>

    <?php include('templates/footer.php'); ?>
    <script src="js/meetings.js"></script>
  </body>
</html>