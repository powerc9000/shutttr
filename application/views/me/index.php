
<div id="new-post-container">
<div class="new-post-form">
<h1 class="new-post-header">Shutttr.me Settings</h1>
<form action="<?site_url("me")?>" method="post">
	
		<input type="hidden" value="true" name="submitted">
	<div class="new-post-title inline">
		<input type="checkbox" name="work" id="work" <?if($user->work):?> checked<?endif?>>
		<label for="work">I am available for work <span class="more-info">a badge will be added to your Shutttr.me page</span></label>
	</div>

	<div class="new-post-title inline">
		<input type="checkbox" name="contact" id="contact" <?if($user->contact):?> checked<?endif?>>
		<label for="contact">Let people contact me through my Shutttr.me page</label>
	</div>

	<div class="new-post-title">
	    <label for="tumblr">Tumblr username <span class="more-info">optional</span></label>
		<input type="text" name="tumblr" id="tumblr" value="<?=$user->tumblr?>">
	</div>
	<div class="new-post-title">
	    <label for="flickr">Flickr username <span class="more-info">optional</span></label>
		<input type="text" name="flickr" id="flickr" value="<?=$user->flickr?>">
	</div>
	
	<div class="new-post-title">
	    <label for="facebook">Facebook username <span class="more-info">optional</span></label>
		<input type="text" name="facebook" id="facebook" value="<?=$user->facebook?>">
	</div>
	<div class="new-post-title">
	    <label for="d_art">Deviant Art username <span class="more-info">optional</span></label>
		<input type="text" name="d_art" id="d_art" value="<?=$user->d_art?>">
	</div>
	
	<div class="new-post-title">
	    <label for="youtube">YouTube username <span class="more-info">optional</span></label>
		<input type="text" name="youtube" id="youtube" value="<?=$user->youtube?>">
	</div>
	<label>Select your best photos to display on your Shutttr.me</label>
	<ul class="shutttrme-photos">
	<?foreach($photos as $photo):?>
		<li>
		<input type="checkbox" name="photos[]" value="<?=$photo->id?>" <?=$photo->selected?>>
		<img src="http://shutttr.s3.amazonaws.com/photo_uploads_medium/<?=$photo->file_name?>" width="150px">
	<?endforeach?>
	</ul>
	<div class="new-post-form-submit">
		<input type="submit" value="Update">
	</div>
</form>
</div>
</div>