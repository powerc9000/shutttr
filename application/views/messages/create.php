<br />
<div id="container">
  <div id="content" class="create-pm">
    <h2>Message to <?= $to_username ?></h2>
    <?= form_open("messages/send") ?>
      <?= form_hidden("to_username", $to_username) ?>
      <p>
        <label for="subject">Subject:</label>
        <?= form_input(array("name" => "subject", "value" => $subject, "required" => "required")) ?>
      </p>
      <p>
        <label for="body">Message:</label><br />
        <?= form_textarea(array("name" => "body", "required" => "required")) ?>
      </p>
      <p><?= form_submit("sent", "Send Message") ?></p>
    <?= form_close() ?>
  </div>
</div>
