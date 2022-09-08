<?php

  session_start();

  // include_once 'utils/permissions.php';
  include_once 'config/messages.php';
  include_once 'utils/breadcrumbs.php';

  $_SESSION['firstVisit'] = false;

?>

<!doctype html>
<html>
  <?php include('templates/header.php'); ?>
  <link rel="stylesheet" type="text/less" href="css/index.less" />
  <link rel="stylesheet" type="text/css" href="css/welcome.css" media="screen" />
  <?php include('templates/body.php'); ?>

        <div class="col-7 page-name">
          <p>Witaj</p>
        </div>
        <div class="col-2 upper-right-buttons">
        </div>
      </div>
    </div>

    <div class="row main-content-row" style="display: flex; justify-content: center; padding: 50px;">
      <table>
        <tr>
          <td colspan=2 style="text-align: center;">
            <label class="welcome-title-first">Witaj na stronie wspólnoty mieszkaniowej</label>
            <label class="welcome-title-second">"Ostoja"</label>
          </td>
        </tr>
        <tr>
          <td style="padding-right: 50px;">
            <div class="main-col tile-image" id="img-login">
            </div>
          </td>
          <td>
            <div class="main-col tile-image" id="img-renting">
            </div>
          </td>
        </tr>
      </table>
    </div>
      
    <?php include('templates/footer.php'); ?>
    <script src="js/welcome.js"></script>
  </body>
</html>