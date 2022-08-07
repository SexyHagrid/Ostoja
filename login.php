<?php
  session_start();
  if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header('Location: index.php');
  }

  include_once 'config/db_connect.php';
  include 'utils/user.php';

  $email = $password = '';
  $errors = ['email' => '', 'password' => ''];
  $error_prompt_message = '';

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
      $stmt = $dbConn->fetch("SELECT email, password, userId FROM users where email like '$email'");
      $stmt->execute();
      $users = $stmt->fetchAll();
      $conn = null;

      if (count($users) == 0) {
        $error_prompt_message = 'Nieprawidłowe dane uwierzytelniające';
      } elseif ($users[0]['password'] !== $password) {
        $error_prompt_message = 'Nieprawidłowe dane uwierzytelniające';
      } else {
        $_SESSION["loggedin"] = true;
        $_SESSION["userId"] = $users[0]["userId"];
        $_SESSION["email"] = $users[0]["email"];

        header('Location: index.php');
      }
    }
  }
?>

<!doctype html>
<html>
    <?php include('templates/header.php'); ?>
    <link rel="stylesheet" href="css/login.css" />
    <?php include('templates/body.php'); ?>

        <div class="col-7">
          <p>Autoryzacja</p>
        </div>
        <div class="col-2">
        </div>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="login-body">
        <form id="login-form" action="login.php" method="post">
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
</html>