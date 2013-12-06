<ul>
  <? foreach ($critiques as $critique): ?>
    <li>
      <h3>
        <a href="<?= site_url("posts/critique/" . $critique["critique"]->slug) ?>">
          <?= $critique["critique"]->name ?></a>,
        a critique of
        <a href="<?= site_url("posts/photo/" . $critique["photo"]->slug) ?>">
          <?= $critique["photo"]->post_title ?>
        </a>
      </h3>
      <small>
        Critique by
        <span data-tooltip="<?= $critique["critique_poster"]->username ?>">
          <?= $critique["critique_poster"]->first_name ?>
          <?= $critique["critique_poster"]->last_name ?></span>.
        Photo by
        <span data-tooltip="<?= $critique["photo_poster"]->username ?>">
          <?= $critique["photo_poster"]->first_name ?>
          <?= $critique["photo_poster"]->last_name ?></span>.
      </small>
    </li>
  <? endforeach ?>
</ul>
<?= $this->pagination->create_links() ?>