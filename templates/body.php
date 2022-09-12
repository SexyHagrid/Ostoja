  <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/2.5.1/less.min.js"></script>
</head>

<body>
  <?php if ($error_prompt_message): ?>
    <div id="alertpopup">
      <div id="alertpopup-text"><?php echo $error_prompt_message; ?></div>
      <div id="alertpopup-progress-bar"></div>
    </div>
    <script src="js/show_error.js"></script>
    <script src="js/popups.js"></script>
  <?php endif; ?>

  <?php if ($notify_prompt_message): ?>
    <div id="notifypopup">
      <div id="notifypopup-text"><?php echo $notify_prompt_message; ?></div>
      <div id="notifypopup-progress-bar"></div>
    </div>
    <script src="js/show_notification.js"></script>
  <?php endif; ?>

  <div class="container">
    <div class="row upper-row">
      <div class="upper-bar">
        <div class="col-3 brand-logo">
          <a href="hub"><img id="brand-logo-image" src="assets/brand-logo.png" alt="Brand logo"></a>
        </div>
