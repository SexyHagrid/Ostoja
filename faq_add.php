<?php

  session_start();

  if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false) {
    header('Location: index.php');
  }

  include_once 'config/messages.php';
  include_once 'utils/permissions.php';
  include_once 'utils/breadcrumbs.php';

  $conn = new mysqli('localhost', 'root', '', 'wspolnota_ostoja');

  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  if (isset($_GET['question']) && isset($_GET['answer'])) {
    $question = $_GET['question'];
    $answer = $_GET['answer'];
  
    $query = "INSERT INTO faq(pytanie, odpowiedz) VALUES ('".$question."', '".$answer."');";

    $result = $conn->query($query);
    if ($result === TRUE) {
      echo "SUCCESS";
    } else {
      echo "FAIL";
    }
  }

  $conn->close();

?>

<!doctype html>
<html>
  <?php include('templates/header.php'); ?>
  <link rel="stylesheet" type="text/css" href="css/faq.css" media="screen" />
  <?php include('templates/body.php'); ?>

        <div class="col-7 page-name">
          <div id="breadcrumbs-div">
            <nav class="navbar-expand-lg">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <?php Breadcrumbs::showBreadcrumbs(['page' => 'FAQ_Add', 'address' => 'faq_add.php']); ?>
                </ol>
              </nav>
            </nav>
          </div>
          <p>FAQ</p>
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

    <div class="main-content-row">
      <div class="row justify-content-start">
        <div class="col">
          <div class="row row-upper">
              <h1>Dodaj FAQ</h1>
          </div>
          <div class="row justify-content-center">
            <form>
              <label>Pytanie: </label> <br/>
              <textarea rows="6" cols="150" id="faqQuestionInput"></textarea> <br/> <br/>
              <label>Odpowiedź: </label> <br/>
              <textarea rows="6" cols="150" id="faqAnswerInput"></textarea> <br/>
              <input id="faqSubmitButton" type="button" value="Wyślij" style="cursor: pointer;"/>
            </form>
          </div>
        </div>
      </div>
    </div>

    <?php include('templates/footer.php'); ?> <!-- // TODO: remove appr link -->
    <script src="js/faq_add.js"></script>
  </body>
</html>