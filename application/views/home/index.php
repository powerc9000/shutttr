<center>
  Welcome <?= $username ?>!
  <? if ($is_admin): ?>
    <br><br>
    <a href="<?= site_url("admin") ?>">Visit admin panel?</a><br>
    <a href="<?= site_url("admin/invites") ?>">Invite users?</a>
  <? endif ?><br><br>
  <a href="<?= site_url("logout") ?>">Logout!</a>
</center>