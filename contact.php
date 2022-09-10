<?php

  session_start();

  include_once 'config/messages.php';
  include_once 'utils/permissions.php';
  include_once 'utils/breadcrumbs.php';

?>

<!doctype html>
<html>
  <?php include('templates/header.php'); ?>
  <link rel="stylesheet" type="text/css" href="contact.css" media="screen" />
  <?php include('templates/body.php'); ?>

        <div class="col-7 page-name">
          <div id="breadcrumbs-div">
            <nav class="navbar-expand-lg">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <?php Breadcrumbs::showBreadcrumbs(['page' => 'Kontakt', 'address' => 'kontakt']); ?>
                </ol>
              </nav>
            </nav>
          </div>
          <p>Kontakt</p>
        </div>
        <div class="col-2 upper-right-buttons">
          <?php if (isset($_SESSION['userId'])): ?>
            <?php if (Permissions::hasPermission("Panel administracyjny")): ?>
              <a href="panel-administracyjny"><p id="admin-panel">Panel administracyjny</p></a>
              <hr>
            <?php endif; ?>
            <a href="wyloguj"><p id="logout-in-p">Wyloguj</p></a>
          <?php else: ?>
            <a href="zaloguj"><p id="logout-in-p">Zaloguj</p></a>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="row justify-content-center main-content-row">
      <div class="row" style="border: 1px solid black; padding: 10px;">
        <table>
          <tr>
            <td style="width: 40%">
              <p>Prezydent Wspólnoty Ostoja:</p>
            </td>
            <td>
              <p>Wiktor</p>
            </td>
            <td rowspan="3" style="background-image: url(assets/wiktor.png); background-size: contain; background-repeat: no-repeat; width: 300px">

            </td>
          </tr>
          <tr>
            <td>
              <p>E-mail: wiktor@ostoja.com</p>
            </td>
            <td>
              <p> Telefon: 132-466-798</p>
            </td>

          </tr>
          <tr>
            <td style="height: 100px;">
              <p style="color: white;">u</p>
            </td>
          </tr>
          <tr>
            <td style="height: 100px;">
              <p style="color: white;">u</p>
            </td>
          </tr>
          <tr>
            <td>
              <p>Wice-Prezydent Wspólnoty Ostoja:</p>
            </td>
            <td>
              <p>Pawel</p>
            </td>
            <td rowspan="3" style="background-image: url(assets/P.Patyk.jpg); background-size: contain; background-repeat: no-repeat;">

            </td>
          </tr>
          <tr>
            <td>
              <p>E-mail: pawel@ostoja.com</p>
            </td>
            <td>
              <p> Telefon: 888-777-666</p>
            </td>
          </tr>
          <tr>
            <td style="height: 100px;">
              <p style="color: white;">u</p>
            </td>
          </tr>
        </table>
      </div>
    </div>

    <?php include('templates/footer.php'); ?>
  </body>
</html>