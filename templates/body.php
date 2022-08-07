</head>

<body>
  <?php if ($error_prompt_message): ?>
    <div id="alertpopup">
      <div id="alertpopup-text"><?php echo $error_prompt_message; ?></div>
      <div id="alertpopup-progress-bar"></div>
    </div>
    <script src="js/show_error.js"></script>
  <?php endif; ?>

  <div class="container">
    <div class="row upper-row">
      <div class="upper-bar">
        <div class="col-3 brand-logo">
          <img src="assets/brand-logo.png" alt="Brand logo">
        </div>

