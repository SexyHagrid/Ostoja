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
                  <?php Breadcrumbs::showBreadcrumbs(['page' => 'Kontakt', 'address' => 'contact.php']); ?>
                </ol>
              </nav>
            </nav>
          </div>
          <p>Kontakt</p>
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

    <div class="row justify-content-start main-content-row">
      <div class="col">
        <div class="row row-upper">
            <h1>Kontakt</h1>
        </div>
        <div class="row-akt center">
          <table class="tabela">
            <tr>
              <td class="komorka">
                <p>Prezydent Wspólnoty Ostoja:</p>
              </td>
              <td class="komorka">
                <p>Wiktor</p>
              </td>
              <td class="komorka" rowspan="3" style="background-image: url(assets/wiktor.png); background-size: contain; background-repeat: no-repeat;">

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
              <td>
                <p>Wice-Prezydent Wspólnoty Ostoja:</p>
              </td>
              <td>
                <p>Pawel</p>
              </td>
              <td class="komorka" rowspan="3" style="background-image: url(assets/P.Patyk.jpg); background-size: contain; background-repeat: no-repeat;">

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
            <!-- <p>Prezydent Wspólnoty Ostoja: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; Wiktor  </p>
            <p>E-mail: wiktor@ostoja.com &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;  Telefon: 132-466-798  </p>
            <br/>
            <p>Wice-prezydent Wspólnoty Ostoja: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; Paweł  </p>
            <p>E-mail: pawel@ostoja.com &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;  Telefon: 888-777-666  </p> -->
        </div>
      </div>
    </div>

    <?php include('templates/footer.php'); ?> <!-- // TODO: remove appr link -->
  </body>
</html>