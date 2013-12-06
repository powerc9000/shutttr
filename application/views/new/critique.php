<script>
$('document').ready(function(){
  $("#rating").mousemove(function(){
    var value = $("#rating").val();
    $("#rating-number").text(value);
  });
});
</script>

<div id="new-post-container">

<div class="new-post-form">

<h1 class="new-post-header">Critique "<?= $photo->post_title ?>"</h1>
<div id="post-photo">
<a href="<?= site_url("posts/photo/$photo_slug") ?>" target="_blank">
  <img src="http://shutttr.s3.amazonaws.com/photo_uploads/<?= $photo->file_name ?>" />
</a>
</div>

<? if ($errors): ?>
  <div class="errors">
    <?= $errors ?>
  </div>
<? endif ?>

<?= form_open("new/critique/$photo_slug") ?>
  <div class="new-post-title">
    <label for="title">Title:</label>
    <?= form_input("title") ?>
  </div>
  <div class="text-align-center">
    <label for="rating">Rating:</label>
    <span style="display: inline-block; vertical-align: middle;">
      <span style="display: inline-block; width: 10px;">0</span>
      <input type="range"
             value="0"
             min="0"
             max="5"
             step="0.5"
             name="rating"
             style="width: 80px" id="rating" />
      <span style="display: inline-block; width: 10px;">5</span><br />
      <span style="display: inline-block; width: 100px; text-align: center;" id="rating-number">0</span>
    </span>
  </div>
  <div class="new-post-description">
    <label for="body">Write your critique here:</label><br />
    <?= form_textarea("body") ?>
  </div>
  <div class="new-post-form-submit">
    <?= form_submit("submitted", "Post Critique") ?>
  </div>
<?= form_close() ?>
</div>
</div>