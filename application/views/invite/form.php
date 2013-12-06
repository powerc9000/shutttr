<html>
<head>
<title>Welcome to Shutttr</title>
<link rel="stylesheet" href="<?=site_url("assets/css/stream.css")?>">
<link rel="stylesheet" href="<?=site_url("assets/css/style.css")?>">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script src="<?= site_url("assets/js/modernizr-1.6.min.js") ?>"></script>
<script src="<?= site_url("assets/js/bootstrap-alerts.js") ?>"></script>

</head>
<body>
 
   <?if($this->session->flashdata("message")):?>
    <div class="alert-message fade in <?=$this->session->flashdata('type')?>" data-alert="true">
          <a class="close" href="#">×</a>
          <p><?= $this->session->flashdata('message') ?></p>
        </div>
    <?endif?>
<div id="new-post-container">
<div class="new-post-form">
<? if (!isset($validation_errors)) $validation_errors = validation_errors() ?>
<? if ($validation_errors): ?>
  <div class="validation-errors">
    <?= $validation_errors ?>
  </div>
<? endif; ?>

<h1 class="new-post-header">Hello and welcome to Shutttr!</h1>
<h1>Please provide us with some basic information and then you can log in</h1>
<?= form_open("invite/$uid") ?>
<div class="new-post-title">
    <label for="last_name">Username:</label>
    <?= form_input("username", set_value("username")) ?>
  </div>
  <div class="new-post-title">
    <label for="last_name">Email:</label>
    <?= form_input("email", set_value("email")) ?>
  </div>
  <div class="new-post-title">
    <label for="first_name">First Name:</label>
    <?= form_input("first_name", set_value("first_name")) ?>
  </div>
  <div class="new-post-title">
    <label for="last_name">Last Name:</label>
    <?= form_input("last_name", set_value("last_name")) ?>
  </div>
   
  <div class="new-post-title">
    <label for="password">Password:</label>
    <?= form_password("password") ?>
  </div>
  <div class="new-post-title">
    <label for="passconf">Confirm password:</label>
    <?= form_password("passconf") ?>
  </div>
  <input type="hidden" name="uid" value="<?=$uid?>">
  <div class="new-post-description">
    <label for="bio">About yourself:</label><br />
    <?= form_textarea("bio", set_value("bio")) ?>
  </div>
  <div class="new-post-form-submit">
    <?= form_submit("form_submitted", "Register") ?>
  </div>
<?= form_close() ?>
</div>
</div>
</body>
</html>