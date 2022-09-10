<?php

  session_start();
  if (!isset($_SESSION["loggedin"]) || $_SESSION['loggedin'] !== true) {
    header('Location: witaj');
  }

  include_once 'utils/permissions.php';
  include_once 'config/messages.php';
  include_once 'utils/breadcrumbs.php';

  $ticketComments = [];
  $ticketIdFull = $_GET['ticketId'];
  $ticketId = substr($ticketIdFull, 4);

  $dbConn = new DBConnector();
  $stmt = $dbConn->dbRequest("SELECT * FROM tickets where ticketId='$ticketId'");
  $stmt->execute();
  $ticketDetails = $stmt->fetchAll();

  $stmt = $dbConn->dbRequest("SELECT * FROM ticket_comments where ticketId='$ticketId' order by commentDate desc");
  $stmt->execute();
  $ticketComments = $stmt->fetchAll();


  $reporterDetails = $assigneeUsers = $ticketStatusArray = null;
  if (!Permissions::hasPermission("Panel wsparcia technicznego")) {
    $reporterId = $ticketDetails[0]['userId'];
    $stmt = $dbConn->dbRequest("SELECT * FROM users where userId='$reporterId'");
    $stmt->execute();
    $reporterDetails = $stmt->fetchAll();

    $stmt = $dbConn->dbRequest("SELECT email FROM users u inner join roles r on u.roleId=r.roleId where roleName = 'Wsparcie techniczne'");
    $stmt->execute();
    $assigneeUsers = $stmt->fetchAll();

    $assigneeId = $ticketDetails[0]['assigneeId'];
    $stmt = $dbConn->dbRequest("SELECT * FROM users where userId='$assigneeId'");
    $stmt->execute();
    $assigneeDetails = $stmt->fetchAll();

    $ticketStatusArray = ['OTWARTY', 'W TRAKCIE', 'ZAKOŃCZONY', 'ANULOWANY'];
  }

?>

<!doctype html>
<html>
  <?php include('templates/header.php'); ?>
  <link rel="stylesheet" type="text/less" href="css/ticket_details.less" />
  <?php if (Permissions::hasPermission("Panel wsparcia technicznego")): ?>
    <link rel='stylesheet' type='text/less' href='css/ticket_details_meta.less' />
  <?php endif; ?>
  <?php include('templates/body.php'); ?>

        <div class="col-7 page-name">
          <div id="breadcrumbs-div">
            <nav class="navbar-expand-lg">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <?php Breadcrumbs::showBreadcrumbs(['page' => "${ticketIdFull}", 'address' => "zgłoszenie?ticketId=${ticketIdFull}"]); ?>
                </ol>
              </nav>
            </nav>
          </div>
          <p>Wsparcie techniczne</p>
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
      <?php if (!Permissions::hasPermission("Panel wsparcia technicznego")): ?>
        <div class="main-ticket-details-outer">
          <div class="main-ticket-details">
            <div class="main-ticket-details-inner">
              <div class="ticket-details">
                <div class="ticket-details-name-and-status">
                  <div class="ticket-details-name">
                    <h3><?php echo $ticketDetails[0]['ticketName']; ?></h3>
                  </div>
                  <div class="ticket-details-status">
                    <div class="ticket-details-status-outer">
                      <div class="ticket-details-status-inner">
                        <h4 id="ticket-details-status-inner-h4"><?php echo $ticketDetails[0]['ticketStatus']; ?></h4>
                      </div>
                    </div>
                  </div>
                </div>
                <hr>
                <div class="ticket-details-description">
                  <?php echo nl2br($ticketDetails[0]['description']); ?>
                </div>
              </div>
              <div class="ticket-comments">
                <div class="ticket-comments-add-comment">
                  <form id="add-comment" method="get">
                    <textarea id="ticket-comment-add" name="ticket-comment-add" placeholder="Dodaj komentarz..."></textarea>
                    <div class="buttons-div">
                      <button id="cancel-add-comment" type="button">Anuluj</button>
                      <button class="disabled-input" id="submit-add-comment" type="button" disabled>Dodaj</button>
                    </div>
                  </form>
                </div>

                <div class="ticket-comments-comments">
                  <?php foreach ($ticketComments as $comment): ?>
                    <div class="ticket-comment-outer">
                      <div class="ticket-comment-inner">
                        <div class='tcilu <?php echo $comment['userId'] === $_SESSION['userId'] ? "ticket-comment-inner-label-c-user" : "ticket-comment-inner-label-o-user" ?>'>
                          <p class="ticket-comment-label-name"><?php echo $comment['userName'].' '.$comment['userSurname']; ?></p>
                          <p class="ticket-comment-label-date"> <?php echo $comment['commentDate']; ?></p>
                        </div>
                        <div class="ticket-comment-inner-text">
                          <?php echo nl2br($comment['commentText']); ?>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      <!-- Support panel -->
      <?php else: ?>
        <div class="main-ticket-details-outer">
          <div class="main-ticket-details">
            <div class="main-ticket-details-inner">
              <div class="ticket-details">
                <div class="ticket-details-name-and-status">
                  <div class="ticket-details-name">
                    <h3><?php echo $ticketDetails[0]['ticketName']; ?></h3>
                  </div>
                  <div class="ticket-details-status">
                    <div class="ticket-details-status-outer hover-bttn">
                      <div class="ticket-details-status-inner">
                        <h4 id="ticket-details-status-inner-h4"><?php echo $ticketDetails[0]['ticketStatus']; ?></h4>
                      </div>
                    </div>
                  </div>
                </div>
                <hr>
                <?php if (Permissions::hasPermission('Edytowanie opisu zgłoszeń')): ?>
                  <div class="ticket-details-description-outer">
                    <textarea class="ticket-details-description tdd-ta"><?php echo $ticketDetails[0]['description']; ?></textarea>
                    <div class="buttons-div-tdd-ta">
                      <button class="hover-bttn" id="cancel-edit-description" type="button">Anuluj</button>
                      <button class="hover-bttn" id="submit-edit-description" type="button">Zapisz</button>
                    </div>
                  </div>
                <?php else: ?>
                  <div class="ticket-details-description">
                    <?php echo nl2br($ticketDetails[0]['description']); ?>
                  </div>
                <?php endif; ?>
              </div>
              <div class="ticket-comments">
                <div class="ticket-comments-add-comment">
                  <form id="add-comment" method="get">
                    <textarea id="ticket-comment-add" name="ticket-comment-add" placeholder="Dodaj komentarz..."></textarea>
                    <div class="buttons-div">
                      <button id="cancel-add-comment" type="button">Anuluj</button>
                      <button class="disabled-input" id="submit-add-comment" type="button" disabled>Dodaj</button>
                    </div>
                  </form>
                </div>

                <div class="ticket-comments-comments">
                  <?php foreach ($ticketComments as $comment): ?>
                    <div class="ticket-comment-outer <?php echo $comment['userId'] === $_SESSION['userId'] ? "c-user" : "o-user" ?>">
                      <div class="ticket-comment-inner">
                        <div class='tcilu <?php echo $comment['userId'] === $_SESSION['userId'] ? "ticket-comment-inner-label-c-user" : "ticket-comment-inner-label-o-user" ?>'>
                          <p class="ticket-comment-label-name"><?php echo $comment['userName'].' '.$comment['userSurname']; ?></p>
                          <p class="ticket-comment-label-date"> <?php echo $comment['commentDate']; ?></p>
                        </div>
                        <div class="ticket-comment-inner-text">
                          <?php echo nl2br($comment['commentText']); ?>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>

          <div class="ticket-meta">
            <h4>Detale</h4>
            <hr>
            <div class="ticket-meta-details ticket-meta-details-outer">
              <div class="ticket-meta-reporter">
                <div class="ticket-meta-reporter-inner ticket-meta-details-inner">
                  <label>Zgłoszony przez</label>
                  <input class="ticket-meta-details-input" id="ticket-meta-details-reporter" name="ticket-meta-details-reporter" value="<?php echo $reporterDetails[0]['email']; ?>" disabled>
                </div>
              </div>
              <div class="ticket-meta-assignee ticket-meta-details-outer">
                <div class="ticket-meta-assignee-inner ticket-meta-details-inner">
                  <label>Przypisany do</label>
                  <input list="assignee-list" class="ticket-meta-details-input" id="ticket-meta-details-assignee" name="ticket-meta-details-assignee" value="<?php echo $assigneeDetails ? $assigneeDetails[0]['email'] : ''; ?>">

                  <datalist id="assignee-list">
                    <?php foreach ($assigneeUsers as $assignee): ?>
                      <option value="<?php echo $assignee['email']; ?>">
                    <?php endforeach; ?>
                  </datalist>
                </div>
                <div class="assign-to-me-div">
                  <p id="assign-to-me">Przypisz do mnie</p>
                </div>
              </div>
              <div class="ticket-meta-priority ticket-meta-details-outer">
                <div class="ticket-meta-priority-inner ticket-meta-details-inner">
                  <label>Priorytet</label>
                  <input list="priority-list" class="ticket-meta-details-input" id="ticket-meta-details-priority" name="ticket-meta-details-priority" value="<?php echo $ticketDetails[0]['priority']; ?>">

                  <datalist id="priority-list">
                    <option value="Krytyczny">
                    <option value="Wysoki">
                    <option value="Średni">
                    <option value="Niski">
                  </datalist>
                </div>
              </div>
              <div class="ticket-meta-type ticket-meta-details-outer">
                <div class="ticket-meta-type-inner ticket-meta-details-inner">
                  <label>Typ zgłoszenia</label>
                  <input list="ticket-type-list" class="ticket-meta-details-input" id="ticket-meta-details-type" name="ticket-meta-details-type" value="<?php echo $ticketDetails[0]['ticketType']; ?>">

                  <datalist id="ticket-type-list">
                    <option value="Awarie">
                    <option value="Błąd na stronie">
                    <option value="Usprawnienie strony">
                    <option value="Konto użytkownika">
                  </datalist>
                </div>
              </div>
              <div class="ticket-details-meta-dates">
                <hr>
                <div class="ticket-details-meta-date">
                  <div>
                    <p>Utworzony:</p>
                  </div>
                  <div class="ticket-details-meta-date-value">
                    <p><?php echo $ticketDetails[0]['ticketDateStart'] ?></p>
                  </div>
                </div>
                <div class="ticket-details-meta-date">
                  <div>
                    <p>Zaktualizowany:</p>
                  </div>
                  <div class="ticket-details-meta-date-value">
                    <p id="ticket-details-meta-date-update-value"><?php echo $ticketDetails[0]['ticketDateUpdate'] ?></p>
                  </div>
                </div>
                <div class="ticket-details-meta-date" <?php if (!$ticketDetails[0]['ticketDateEnd']) { echo 'style="display: none"'; } ?>>
                  <div>
                    <p>Zakończony:</p>
                  </div>
                  <div class="ticket-details-meta-date-value">
                    <p id="ticket-details-meta-date-end-value"><?php echo $ticketDetails[0]['ticketDateEnd'] ?></p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="change-ticket-status">
            <div class="hover-bttn" id="close-curtain">&#10006;</div>

            <h4>Zmień status zgłoszenia</h4>
            <hr>
            <?php foreach ($ticketStatusArray as $ticketStatus): ?>
              <label>
                <input type="radio" name="change-ticket-status" class="change-ticket-status-c" value="<?php echo $ticketStatus; ?>" <?php if ($ticketStatus == $ticketDetails[0]['ticketStatus']) echo 'checked'; ?>>
                <p><?php echo $ticketStatus; ?></p>
              </label>
            <?php endforeach; ?>

            <button class="hover-bttn" id="change-ticket-status-submit" type="button">Zmień</button>
          </div>
        </div>
      <?php endif; ?>
    </div>

    <?php include('templates/footer.php'); ?>
    <script src='js/ticket_details.js'></script>
    <?php if (Permissions::hasPermission("Panel wsparcia technicznego")) { echo "<script src='js/ticket_details_meta.js'></script>"; } ?>
  </body>
</html>