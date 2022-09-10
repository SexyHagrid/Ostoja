<?php

  session_start();
  if (!isset($_SESSION["loggedin"]) || $_SESSION['loggedin'] !== true) {
    header('Location: witaj');
  }

  include_once 'utils/permissions.php';
  include_once 'config/messages.php';
  include_once 'utils/breadcrumbs.php';
  include_once 'utils/report.php';

  $reportName = $add_report_name = $userEmail = $reportPermission = '';
  $addReport = $hasErrors = false;
  $fieldsAmount = 0;
  $reports = $billings = $billingsAdd = [];
  $errors = ['reportName' => '', 'billingsAdd' => [], 'reportPermission' => ''];

  $dbConn = new DBConnector();

  if (isset($_POST['get-report-details'])) {
    $reportName = $_POST['get-report-details'];
    $stmt = $dbConn->dbRequest("SELECT * FROM report_fees rp inner join reports r on rp.reportId=r.reportId where r.name = '$reportName'");
    $stmt->execute();
    $billings = $stmt->fetchAll();
  }

  if (isset($_POST['add-report'])) {
    $addReport = true;
  }

  if (isset($_POST['add-report-submit'])) {
    foreach(array_keys($_POST) as $key) {
      if (str_contains($key, 'fee-name-')) $fieldsAmount++;
    }

    if (empty($_POST['add-report-report-name'])) {
      $hasErrors = true;
      $errors['reportName'] = 'Nazwa jest wymagana';
    } else {
      $add_report_name = htmlspecialchars($_POST['add-report-report-name']);
    }

    if (empty($_POST['report-permission'])) {
      $hasErrors = true;
      $errors['reportPermission'] = 'Pole jest wymagane';
    } else {
      if ($_POST['report-permission'] == 'association') {
        $reportPermission = 'association';
        $reportUserId = 1;
      } elseif ($_POST['report-permission'] == 'occupant'){
        $reportPermission = 'occupant';

        if (empty($_POST['user-emails-list-input'])) {
          $hasErrors = true;
          $errors['reportPermission'] = 'Pole jest wymagane';
        } else {
          $userEmail = $_POST['user-emails-list-input'];

          $stmt = $dbConn->dbRequest("SELECT userId FROM users where email = '$userEmail'");
          $stmt->execute();
          $usersIds = $stmt->fetchAll();
          $reportUserId = $usersIds[0]['userId'];
        }
      }
    }

    for($i = 0; $i < $fieldsAmount; $i++ ) {
      $feeName = $feeValue = $feeCategory = $errorName = $errorValue = $errorCategory = '';

      if (empty($_POST['fee-name-'.$i])) {
        $errorName = 'Nazwa opłaty jest wymagana';
      } else {
        $feeName = $_POST['fee-name-'.$i];
      }

      if (empty($_POST['fee-value-'.$i])) {
        $errorValue = 'Wartość opłaty jest wymagana';
      } else {
        $feeValue = $_POST['fee-value-'.$i];
      }

      if (empty($_POST['fee-category-'.$i])) {
        $errorCategory = 'Kategoria jest wymagana';
      } else {
        $feeCategory = $_POST['fee-category-'.$i];
      }

      $billingsAdd[] = ['feeName' => $feeName, 'feeValue' => $feeValue, 'feeCategory' => $feeCategory];
      if ($errorName || $errorValue || $errorCategory || $errors['reportName']) {
        $hasErrors = true;
        $errors['billingsAdd'][] = ['feeName' => $errorName, 'feeValue' => $errorValue, 'feeCategory' => $errorCategory];
      } else {
        $errors['billingsAdd'][] = ['feeName' => '', 'feeValue' => '', 'feeCategory' => ''];
      }

    }

    if (!$hasErrors) {
      $sql = "INSERT INTO reports (reportId, name, userId, creationDate) VALUES (:reportId, :name, :userId, :creationDate)";
      $stmt = $dbConn->dbRequest($sql);
      $stmt->execute([':reportId'=>null, ':name'=>$add_report_name, ':userId'=>$reportUserId, ':creationDate'=>null]);

      $stmt = $dbConn->dbRequest("SELECT reportId FROM reports where name = '$add_report_name'");
      $stmt->execute();
      $reportId = $stmt->fetchAll();

      foreach($billingsAdd as $billingAdd) {
        $sql = "INSERT INTO report_fees (feeId, reportId, feeName, amount, category) VALUES (:feeId, :reportId, :feeName, :amount, :category)";
        $stmt = $dbConn->dbRequest($sql);
        $stmt->execute([':feeId'=>null, ':reportId'=>$reportId[0]['reportId'], ':feeName'=>$billingAdd['feeName'], ':amount'=>$billingAdd['feeValue'], ':category'=>$billingAdd['feeCategory']]);
      }
    } else {
      $error_prompt_message = 'Nie wszystkie pola zostały prawidłowo wypełnione';
    }
  }

  $stmt = '';
  if (Permissions::hasPermission('Dostęp do wszystkich raportów')) {
    $stmt = $dbConn->dbRequest("SELECT * FROM reports");
  } else {
    $userId = $_SESSION['userId'];
    $stmt = $dbConn->dbRequest("SELECT * FROM reports where userId = '$userId'");
  }
  $stmt->execute();
  $reports = $stmt->fetchAll();

?>

<!doctype html>
<html>
  <?php include('templates/header.php'); ?>
  <link rel="stylesheet" type="text/less" href="css/billings.less" />
  <?php include('templates/body.php'); ?>

        <div class="col-7 page-name">
          <div id="breadcrumbs-div">
            <nav class="navbar-expand-lg">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <?php Breadcrumbs::showBreadcrumbs(['page' => 'Opłaty', 'address' => 'opłaty']); ?>
                </ol>
              </nav>
            </nav>
          </div>
          <p>Opłaty</p>
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

    <div class="row justify-content-around main-content-row">
      <div class="col-2 left-search-box">
        <div class="search-report">
          <input type="text" id="search-report-input" name="search-report-input" placeholder="Wyszukaj raport...">
        </div>
        <hr>
        <div class="reports">
          <form action="opłaty" method="post">
            <?php foreach($reports as $report): ?>
              <input class="report-name" type="submit" name="get-report-details" value="<?php echo $report['name']; ?>">
            <?php endforeach; ?>
          </form>
        </div>
      </div>

      <div class="col-9 main-data-box">
        <div id="show-details-div" <?php if ($addReport || $hasErrors) { echo "style='display: none;'"; } ?>>
          <h4><?php echo $reportName; ?></h4>
          <?php if (Permissions::hasPermission("Dodawanie raportów")): ?>
            <form id="add-report-form" action="opłaty" method="post">
              <input id="add-report" type="submit" name="add-report" value="Dodaj raport">
            </form>
          <?php endif; ?>
          <div class="fees-outer fixed-fees-outer">
            <p>Opłaty stałe</p>
            <div class="fees-inner fixed-fees-inner">
            <?php foreach($billings as $billing):
                if ($billing['category'] == 'fixed'): ?>
                <div class="fee-inner-input fixed-fees-inner-div">
                  <label><?php echo $billing['feeName']; ?>
                    <input type="text" name="<?php echo $billing['feeName']; ?>" value="<?php echo $billing['amount']; ?>" readonly>
                  </label>
                </div>
              <?php endif;
              endforeach; ?>
            </div>
          </div>
          <div class="fees-outer quarterly-fees-outer">
            <p>Opłaty kwartalne</p>
            <div class="fees-inner quarterly-fees-inner">
            <?php foreach($billings as $billing):
                if ($billing['category'] == 'quarterly'): ?>
                <div class="fee-inner-input quarterly-fees-inner-div">
                  <label><?php echo $billing['feeName']; ?>
                    <input type="text" name="<?php echo $billing['feeName']; ?>" value="<?php echo $billing['amount']; ?>" readonly>
                  </label>
                </div>
              <?php endif;
              endforeach; ?>
            </div>
          </div>
          <div class="fees-outer long-term-fees-outer">
            <p>Opłaty długoterminowe</p>
            <div class="fees-inner long-term-fees-inner">
              <?php foreach($billings as $billing):
                if ($billing['category'] == 'long-term'): ?>
                <div class="fee-inner-input long-term-fees-inner-div">
                  <label><?php echo $billing['feeName']; ?>
                    <input type="text" name="<?php echo $billing['feeName']; ?>" value="<?php echo $billing['amount']; ?>" readonly>
                  </label>
                </div>
              <?php endif;
              endforeach; ?>
            </div>
          </div>
          <div class="fees-outer unplanned-fees-outer">
            <p>Opłaty niezaplanowane</p>
            <div class="fees-inner unplanned-fees-inner">
              <?php foreach($billings as $billing):
                if ($billing['category'] == 'unplanned'): ?>
                <div class="fee-inner-input unplanned-fees-inner-div">
                  <label><?php echo $billing['feeName']; ?>
                    <input type="text" name="<?php echo $billing['feeName']; ?>" value="<?php echo $billing['amount']; ?>" readonly>
                  </label>
                </div>
              <?php endif;
              endforeach; ?>
            </div>
          </div>
        </div>
        <div id="add-report-div" <?php if (!$addReport && !$hasErrors) { echo "style='display: none;'"; } ?>>
          <form id="add-report-form" action="opłaty" method="post">
            <div id="buttons">
              <button id="add-field" type="button">&plus;</button>
              <input id="add-report-submit" type="submit" name="add-report-submit" value="Dodaj">
            </div>
            <h4>Dodaj raport</h4>
            <label id="report-name-div">
              <p>Nazwa raportu</p>
              <div class="red-text"><?php echo $errors['reportName']; ?></div>
              <input type="text" id="add-report-report-name" name="add-report-report-name" value="<?php echo $add_report_name; ?>">
            </label>

            <div id="report-permission-type">
              <div class="red-text" id="report-permission-red-text"><?php echo $errors['reportPermission']; ?></div>
              <input type="radio" name="report-permission" class="report-permission" value="occupant" <?php if ($reportPermission == 'occupant') echo 'checked'; ?>>
              <label for="report-permission">mieszkaniec</label>
              <input type="radio" name="report-permission" class="report-permission" value="association" <?php if ($reportPermission == 'association') echo 'checked'; ?>>
              <label for="report-permission">spółdzielnia</label>

              <div class="search-user" <?php if ($reportPermission == 'occupant') echo "style='display: inline-block;'"; ?>>
                <input type="text" list="users-emails-list" id="user-emails-list-input" name="user-emails-list-input" placeholder="Wprowadź adres email..." value="<?php echo $userEmail; ?>">

                <datalist id="users-emails-list">
                  <?php foreach($users_details as $user_details): ?>
                    <option><?php echo $user_details['email']; ?></option>
                  <?php endforeach; ?>
                </datalist>
              </div>
            </div>


            <div id="fees-container-outer">
              <p>Opłaty</p>
              <div id="fees-container-inner">
                <?php for($i = 0; $i < $fieldsAmount; $i++): ?>
                  <div class="fee-div">
                    <label>
                      <div class="red-text"><?php echo $errors['billingsAdd'][$i]['feeName']; ?></div>
                      <input class="fee-name" name="fee-name-<?php echo $i; ?>" placeholder="Nazwa opłaty" value="<?php echo $billingsAdd[$i]['feeName']; ?>">
                      <div class="red-text"><?php echo $errors['billingsAdd'][$i]['feeValue']; ?></div>
                      <input class="fee-value" name="fee-value-<?php echo $i; ?>" value="<?php echo $billingsAdd[$i]['feeValue']; ?>">
                    </label>
                    <div class="red-text"><?php echo $errors['billingsAdd'][$i]['feeCategory']; ?></div>
                    <div id="fee-categories">
                      <label>
                        <p>stała</p>
                        <input type="radio" name="fee-category-<?php echo $i; ?>" class="fee-category" value="fixed" <?php if ($billingsAdd[$i]['feeCategory'] == 'fixed') echo 'checked' ?>>
                      </label>
                      <label>
                        <p>kwartalna</p>
                        <input type="radio" name="fee-category-<?php echo $i; ?>" class="fee-category" value="quarterly" <?php if ($billingsAdd[$i]['feeCategory'] == 'quarterly') echo 'checked' ?>>
                      </label>
                      <label>
                        <p>długoterminowa</p>
                        <input type="radio" name="fee-category-<?php echo $i; ?>" class="fee-category" value="long-term" <?php if ($billingsAdd[$i]['feeCategory'] == 'long-term') echo 'checked' ?>>
                      </label>
                      <label>
                        <p>niezaplanowana</p>
                        <input type="radio" name="fee-category-<?php echo $i; ?>" class="fee-category" value="unplanned" <?php if ($billingsAdd[$i]['feeCategory'] == 'unplanned') echo 'checked' ?>>
                      </label>
                    </div>
                  </div>
                <?php endfor; ?>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <?php include('templates/footer.php'); ?>
    <script src="js/billings.js"></script>
  </body>
</html>