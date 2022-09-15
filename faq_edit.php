<?php

  session_start();

  include_once 'config/messages.php';
  include_once 'utils/permissions.php';
  include_once 'utils/breadcrumbs.php';

  if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false) {
    header('Location: faq.php');
  }

  $conn = new mysqli('remotemysql.com', 'lpqiJahZh5', '6m9cW0YAt2', 'lpqiJahZh5');

  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  $id = intval($_GET['id']);

  if (isset($_GET['question']) && isset($_GET['answer'])) {
    $question = $_GET['question'];
    $answer = $_GET['answer'];
  
    $query = "UPDATE faq SET pytanie='".$question."', odpowiedz='".$answer."' WHERE id=".$id.";";

    $result = $conn->query($query);
    if ($result === TRUE) {
      echo "SUCCESS";
    } else {
      echo "FAIL";
    }
  } else {

    $query = "SELECT * FROM faq WHERE id=".$id.";";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();

    $obj = new stdClass;
    $obj->id = $row['id'];
    $obj->question = $row['pytanie'];
    $obj->answer = $row['odpowiedz'];
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
                  <?php Breadcrumbs::showBreadcrumbs(['page' => 'FAQ dodaj', 'address' => 'faq-dodaj']); ?>
                </ol>
              </nav>
            </nav>
          </div>
          <p>FAQ</p>
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

    <div class="main-content-row">
      <div class="row justify-content-start">
        <div class="col">
          <div class="row row-upper">
              <h1>Edytuj FAQ</h1>
          </div>
          <div class="row justify-content-center">
            <form>
              <label>Pytanie: </label> <br/>
              <textarea rows="6" cols="150" id="faqQuestionInput"></textarea> <br/> <br/>
              <label>Odpowiedź: </label> <br/>
              <textarea rows="6" cols="150" id="faqAnswerInput"></textarea> <br/>
              <input id="faqSubmitButton" type="button" value="Edytuj" style="cursor: pointer;"/>
            </form>
          </div>
        </div>
      </div>
    </div>

    <?php include('templates/footer.php'); ?>
    <script>
      var faq = <?= json_encode($obj) ?>;
    </script>
    <script src="js/faq_edit.js"></script>
  </body>
</html>