<html>
<head>
<title>Welcome to Shutttr</title>
<link rel="stylesheet" href="<?=site_url("assets/css/stream.css")?>">
<link rel="stylesheet" href="<?=site_url("assets/css/style.css")?>">
</head>
<div id="new-post-container">
<div class="new-post-form">
<? if (!isset($validation_errors)) $validation_errors = validation_errors() ?>
<? if ($validation_errors): ?>
  <div class="validation-errors">
    <?= $validation_errors ?>
  </div>
<? endif; ?>

<h1 class="new-post-header">Hello and welcome to Shutttr!</h1>
<h1> Before you can login we are going to need some more info.</h1>
<?= form_open("login/register/$uid") ?>
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
    <?= form_textarea("bio") ?>
  </div>
  <div class="new-post-form-submit">
    <?= form_submit("form_submitted", "Register") ?>
  </div>
<?= form_close() ?>
</div>
</div>
</html>