<div id="new-post-container">

<div class="new-post-form">
<? if (isset($errors)): ?>
  <?= $errors ?>
<? endif ?>
<h1 class="new-post-header">New Photo</h1>
<?= form_open_multipart("new/photo") ?>
  <div class="new-post-title">
    <label for="title">Title <span class="more-info">Requred, Be specific.</span></label>
    <?= form_input("title") ?>
  </div>
  <label for="userfile">Photo <span class="more-info">Required, Be sure it's appropriate.</span></label>
  
      <div class="photo-uploader">
        <input type="file" name="file[]" multiple="multiple">
      </div>
   


  <div class="new-post-description">
    <label for="desc">Description <span class="more-info">Required, The more info you give the more you get back.</span></label>
    <?= form_textarea("desc") ?>
  </div>
  <div class="new-post-tags">
  <label for="new-tags">Tags <span class="more-info">Seprate each tag with a comma.</span></label>

  <?= form_textarea(array('name' => 'tags', 'id' => 'new-tags')) ?>
  </div>
  <div class="new-post-form-submit">
    <?= form_submit("submitted", "Post photo") ?>
  </div>
<?= form_close() ?>
</div>
</div>

