<?php

  session_start();
  if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header('Location: witaj');
  } else {
    echo "<script> localStorage.removeItem('sessionID'); </script>";
  }

  include_once 'config/db_connect.php';
  include 'utils/user.php';
  include_once 'config/messages.php';
  include_once 'utils/permissions.php';

  $email = $password = '';
  $errors = ['email' => '', 'password' => ''];

  if (isset($_POST['submit'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    if (empty($email)) {
      $errors['email'] = 'Email jest wymagany';
    }
    if (empty($password)) {
      $errors['password'] = 'Hasło jest wymagane';
    }

    if (!array_filter($errors)) {
      $dbConn = new DBConnector();
      $stmt = $dbConn->dbRequest("SELECT * FROM users where email like '$email'");
      $stmt->execute();
      $users = $stmt->fetchAll();

      if (count($users) == 0) {
        $error_prompt_message = 'Nieprawidłowe dane uwierzytelniające';
      } elseif ($users[0]['password'] !== $password) {
        $error_prompt_message = 'Nieprawidłowe dane uwierzytelniające';
      } else {
        $_SESSION["loggedin"] = true;
        $_SESSION["userId"] = $users[0]["userId"];
        $_SESSION["email"] = $users[0]["email"];
        $_SESSION["name"] = $users[0]["name"];
        $_SESSION["surname"] = $users[0]["surname"];

        $sessionID = 'dsfsdfsdf'; // getRandomString();  // TODO: ????

        // $dbonn = new DBConnector();
        // $stmt = $dbConn->dbRequest("INSERT INTO sesja (uzytkownik, numer_sesji) VALUES ('".$users[0]["id"]."', '".$sessionID."')");  // TODO: insert nie fetch
        // $stmt->execute();
        // $conn = null;

        // echo "<script>
        //   localStorage.setItem('sessionID', '".$sessionID."');  // TODO: ????
        // </script>";

        header('Location: hub');
      }
    }
  }
?>

<!doctype html>
<html>
    <?php include('templates/header.php'); ?>
    <link rel="stylesheet" href="css/login.css" />
    <?php include('templates/body.php'); ?>

        <div class="col-7 page-name">
          <p>Autoryzacja</p>
        </div>
        <div class="col-2 upper-right-buttons">
        </div>
      </div>
    </div>

    <div class="row main-content-row">
      <div class="login-body">
        <form id="login-form" action="zaloguj" method="post">
          <div class="login-box">
            <h1>Zaloguj</h1>
            <div>
              <div class="textbox">
                <input class="login-input" type="text" placeholder="Adres e-mail" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>">
              </div>
              <div class="red-text"><?php echo $errors['email']; ?></div>
            </div>
            <div>
              <div class="textbox">
                <input class="login-input" type="password" placeholder="Hasło" name="password" id="password" value="<?php echo htmlspecialchars($password); ?>">
              </div>
              <div class="red-text"><?php echo $errors['password']; ?></div>
            </div>
            <input class="button" type="submit" name="submit" value="Zaloguj">
          </div>
        </form>
      </div>
    </div>

    <?php include('templates/footer.php'); ?>
  </body>
</html>