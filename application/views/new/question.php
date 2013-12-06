<div id="new-post-container">
<div class="new-post-form">
<? if (isset($errors)): ?>
  <?= $errors ?>
<? endif ?>
<h1 class="new-post-header">New Question</h1>
<?= form_open('create/question')?>
<div class="new-post-title">
    <label for="title">Title <span class="more-info">Requred, Be specific.</span></label>
    <input type="text" name="title">
  </div>
  <div class="new-post-description">
    <label for="desc">Question <span class="more-info">Required, The more info you give the more you get back.</span></label>
    <textarea name="question"></textarea>
  </div>

<div class="new-post-tags">
  <label for="new-tags">Tags <span class="more-info">Seprate each tag with a comma.</span></label>

  <?= form_textarea(array('name' => 'tags', 'id' => 'new-tags')) ?>
  </div>
<input type="hidden" name="submitted" value="true">
<div class="new-post-form-submit">
<input type="submit" value="Ask away!">
</div>
</div>
</div>
