<h1>
  <?= $critique->name ?>,
  a critique of
  <a href="<?= site_url("posts/photo/" . $photo->slug) ?>"><?= $photo->post_title ?></a>
</h1>
<a href="<?= site_url("posts/photo/" . $photo->slug) ?>">
  <img src="http://shutttr.s3.amazonaws.com/photo_uploads/<?= $photo->file_name ?>">
</a><br />
<small>Photo by <span data-tooltip="<?= $photo_poster->username ?>">
  <?= $photo_poster->first_name ?> <?= $photo_poster->last_name ?>
</span></small>
<p>
  This critique by
  <span data-tooltip="<?= $critique_poster->username ?>">
    <?= $critique_poster->first_name ?> <?= $critique_poster->last_name ?>
  </span>
  <? if (!$critique_poster->id == $this->session->userdata("id")): ?>
    <? if (!$does_follow): ?>
      (<a href="<?= site_url("people/" . $critique_poster->username . "/follow/" .
                             base64_encode("posts/critique/$slug")) ?>">follow</a>)
    <? else: ?>
      (<a href="<?= site_url("people/" . $critique_poster->username . "/unfollow/" .
                             base64_encode("posts/critique/$slug")) ?>">unfollow</a>)
    <? endif ?>
  <? endif ?>
  gave the photo a rating of <?= $critique->rating ?> and is rated <?= $rating ?>
</p>
<p><?= $critique->body ?></p>

<h2>Comments</h2>
<ul style="list-style: none;">
  <? foreach ($comments as $comment): ?>
    <li>
      <h2>
        <span data-tooltip="<?= $comment["user"]->username ?>">
          <?= $comment["user"]->first_name ?> <?= $comment["user"]->last_name ?>
        </span>
        gave this critique a rating of
        <?= $comment["rating"] / 2 ?>.
      </h2>
			<p>
        <?= parse_markdown(auto_link($comment["body"])) ?>
      </p>
    </li>
  <? endforeach ?>
</ul>

<h2>Leave a comment</h2>
<? if ($errors): ?>
  <div class="error">
    <?= $errors ?>
  </div>
<? endif ?>

<?= form_open("comments/add_critique") ?>
  <?= form_hidden("critique_id", $critique->id) ?>
  <?= form_hidden("url", "posts/critique/" . $critique->slug) ?>
  <p>
    <label for="rating">Rating:</label>
    <span style="display: inline-block; vertical-align: middle;">
      <span style="display: inline-block; width: 10px;">0</span>
      <input type="range"
             value="0"
             min="0"
             max="5"
             step="0.5"
             name="rating"
             style="width: 80px" />
      <span style="display: inline-block; width: 10px;">5</span><br />
      <output onforminput="value = rating.valueAsNumber"
              style="display: inline-block; width: 100px; text-align: center;">0</output>
    </div>
  </p>
  <p>
    <label for="body">Comment:</label><br />
    <?= form_textarea("body") ?>
  </p>
  <p>
    <?= form_submit("", "Add Comment") ?>
  </p>
<?= form_close() ?>