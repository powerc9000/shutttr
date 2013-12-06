<? if ($posts && count($posts)): ?>
  <? foreach ($posts as $post): ?>
    <? if (isset($post->photo_name)): ?>
      <?/* photo */?>
      <img src="http://shutttr.s3.amazonaws.com/photo_uploads/<?= $post->file_name ?>" />
      <br /><?= $post->slug ?><br />
    <? else: if (isset($post->rating)): ?>
      <?/* critique */?>
      <p><?= $post->body ?></p>
    <? endif; endif ?>
  <? endforeach ?>
<? endif ?>