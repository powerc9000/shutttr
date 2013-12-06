<br />
<div id="container">
  <div id="content" class="messages">
    <h2>Your Messages</h2>
    <ul>
      <? foreach ($messages as $message): ?>
        <li>
          <h3><a href="<?= site_url("messages/view/$message->id") ?>">
            <?= $message->subject ?>
          </a> from <a href="<?= site_url("people/$message->from_username")?>">
            <?= $message->from_username ?>
          </a></h3>
        </li>
      <? endforeach ?>
    </ul>
  </div>
</div>
