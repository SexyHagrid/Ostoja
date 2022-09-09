<?php

  session_start();
  if (!isset($_SESSION["loggedin"]) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
  }

  include_once 'utils/permissions.php';
  include_once 'config/messages.php';
  include_once 'utils/breadcrumbs.php';

  $dbConn = new DBConnector();
  $stmt = $dbConn->dbRequest("SELECT * FROM tickets");
  $stmt->execute();
  $tickets = $stmt->fetchAll();
  $ticketsCount = count($tickets);

?>

<!doctype html>
<html>
  <?php include('templates/header.php'); ?>
  <link rel="stylesheet" type="text/less" href="css/support.less" />
  <?php include('templates/body.php'); ?>

        <div class="col-7 page-name">
          <div id="breadcrumbs-div">
            <nav class="navbar-expand-lg">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <?php Breadcrumbs::showBreadcrumbs(['page' => 'Wsparcie techniczne', 'address' => 'support.php']); ?>
                </ol>
              </nav>
            </nav>
          </div>
          <p>Wsparcie techniczne</p>
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
      <div class="user-main-div">
        <div class="ticket-upper-bar">
          <div id="search-ticket">
            <div class="search-ticket-inner">
              <label>Wyszukaj</label>
              <input class="search-ticket" id="search-ticket" name="search-ticket">
            </div>
          </div>
          <button id="add-ticket" type="button">Dodaj zgłoszenie</button>
        </div>

        <div class="curtain"></div>
        <div class="tickets-outer-div">
          <div class="tickets-columns">
            <div class="tickets-col-outer">
              <div class="tickets-col-inner two-side-sort-col" id="ticket-col-name">
                <p>Nazwa zgłoszenia</p>
                <p class="ticket-p-arrow">&#11165;</p>
              </div>
            </div>
            <div class="tickets-col-outer">
              <div class="tickets-col-inner" id="ticket-col-status">
                <p>Status</p>
                <p class="ticket-p-arrow">&#11165;</p>
              </div>
            </div>
            <div class="tickets-col-outer">
              <div class="tickets-col-inner two-side-sort-col" id="ticket-col-date-start">
                <p>Data zgłoszenia</p>
                <p class="ticket-p-arrow">&#11165;</p>
              </div>
            </div>
            <div class="tickets-col-outer">
              <div class="tickets-col-inner two-side-sort-col" id="ticket-col-date-end">
                <p>Data zakończenia</p>
                <p class="ticket-p-arrow">&#11165;</p>
              </div>
            </div>
          </div>

          <div class="tickets-inner-div">
            <?php if ($ticketsCount === 0): ?>
                <div class="tickets-inner-no-tickets">Wygląda na to, że nie masz jeszcze żadnych zgłoszeń</div>
            <?php endif; ?>

            <?php foreach ($tickets as $ticket): ?>
              <div class="ticket">
                <div class="ticket-details-outer">
                  <div class="ticket-details-inner ticket-name">
                    <p><?php echo 'OST-'.$ticket['ticketId'].'  '.$ticket['ticketName']; ?></p>
                  </div>
                </div>
                <div class="ticket-details-outer">
                  <div class="ticket-details-inner ticket-status">
                  <p><?php echo $ticket['ticketStatus']; ?></p>
                  </div>
                </div>
                <div class="ticket-details-outer">
                  <div class="ticket-details-inner ticket-date-start">
                  <p><?php echo $ticket['ticketDateStart']; ?></p>
                  </div>
                </div>
                <div class="ticket-details-outer">
                  <div class="ticket-details-inner ticket-date-end">
                  <p><?php echo $ticket['ticketDateEnd'] ?: 'Zgłoszenie otwarte'; ?></p>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <form id="create-ticket-div" action="support_ticket_add.php" method="post">
          <div id="close-curtain">&#10006;</div>
          <h2>Dodaj zgłoszenie</h2>
          <hr>
          <div id="create-ticket-div-inner">
            <div id="create-ticket-data">
              <div class="create-ticket-data-inner create-ticket-data-topic">
                <label>Temat</label>
                <input class="create-ticket-input" id="create-ticket-topic" name="create-ticket-topic">
              </div>
            </div>

            <div id="create-ticket-data">
              <div class="create-ticket-data-inner create-ticket-data-priority">
                <label>Priorytet</label>
                <input list="priority-list" class="create-ticket-input" id="create-ticket-priority" name="create-ticket-priority">

                <datalist id="priority-list">
                  <option value="Krytyczny">
                  <option value="Wysoki">
                  <option value="Średni">
                  <option value="Niski">
                </datalist>
              </div>
            </div>

            <div id="create-ticket-data">
              <div class="create-ticket-data-inner create-ticket-data-desc">
                <label>Opis</label>
                <textarea id="create-ticket-description" name="create-ticket-description"></textarea>
              </div>
            </div>

            <input class="disabled-input" id="create-ticket-submit" type="submit" name="create-ticket-submit" value="Dodaj" disabled>
          </div>
        </form>
    </div>

    <?php include('templates/footer.php'); ?>
    <script src='js/support.js'></script>
  </body>
</html>