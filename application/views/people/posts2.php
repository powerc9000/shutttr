<? foreach ($photos as $photo): ?>
	<?= $photo->post_title ?><br>
	<?if($photo->post_type ==1):?>
  <a href="<?= site_url("posts/photo/" . $photo->slug) ?>">
    <img src="http://shutttr.s3.amazonaws.com/photo_uploads/<?= $photo->file_name ?>" />
  </a><?endif?><br>
  <?= $photo->description ?><br><br>
  <hr>
<? endforeach ?>
<?= $this->pagination->create_links() ?>