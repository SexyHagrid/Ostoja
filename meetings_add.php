<?php

  session_start();
  if (!isset($_SESSION["loggedin"]) || $_SESSION['loggedin'] !== true) {
    header('Location: witaj');
  }

  include_once 'utils/permissions.php';
  include_once 'config/messages.php';
  include_once 'utils/breadcrumbs.php';

  $errors = ['meeting-date' => ''];

  if (isset($_POST['add-meeting-cancel'])) {
    header('Location: spotkania');
  }

  if (isset($_POST['add-meeting-submit'])) {
    if (empty($_POST['meeting-date'])) {
      $errors['meeting-date'] = 'Data jest wymagana';
    } else {
      $meetingDate = $_POST['meeting-date'];

      if (!empty($_POST['agenda-textarea'])) {
        $meetingAgenda = $_POST['agenda-textarea'];
      }

      $dbConn = new DBConnector();
      $sql = "INSERT INTO meetings (meetingId, meetingDate, agenda) VALUES (:meetingId, :meetingDate, :agenda)";
      $stmt = $dbConn->dbRequest($sql);
      $stmt->execute([':meetingId'=>null, ':meetingDate'=>$meetingDate, ':agenda'=>$meetingAgenda]);

      header('Location: spotkania');
    }
  }

?>

<!doctype html>
<html>
  <?php include('templates/header.php'); ?>
  <link rel="stylesheet" type="text/less" href="css/meetings_add.less" />
  <?php include('templates/body.php'); ?>

        <div class="col-7 page-name">
          <div id="breadcrumbs-div">
            <nav class="navbar-expand-lg">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <?php Breadcrumbs::showBreadcrumbs(['page' => 'Spotkania - dodaj', 'address' => 'spotkania-dodaj']); ?>
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

    <div class="row main-content-row">
      <form id="submit-meeting-form" action="spotkania-dodaj" method="post">
        <h2>Dodaj spotkanie</h2>
        <hr>
        <div id="buttons">
          <label>
            <p>Data</p>
            <div class="red-text"><?php echo $errors['meeting-date']; ?></div>
            <input id="meeting-date" name="meeting-date">
          </label>
          <label>
            <p>Agenda</p>
            <textarea id="agenda-textarea" name="agenda-textarea"></textarea>
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