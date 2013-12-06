<? $errors = validation_errors() ?>
<? if ($errors): ?>
  <div class="error">
    <?= $errors ?>
  </div>
<? endif ?>

<?= form_open("login/forgot") ?>
  <p>
    <label for="email">Email Address:</label>
    <?= form_input("email", set_value("email"), array("type" => "email")) ?>
  </p>
  <p>
    <?= form_submit("submitted", "Send me a link to reset my password") ?>
  </p>
<?= form_close() ?>