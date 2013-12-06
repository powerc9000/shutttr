<div id="new-post-container">

<div class="new-post-form">


<h1 class="new-post-header">Change Your Profile Photo</h1>
<h1>Upload your profile photo here. The image must be jpg or png and wider than 200px square</h1>
<?= form_open_multipart("settings/avatar") ?>
	<input type="file" name="userfile">
<div class="current-avatar">
<img src="<?=$this->user->avatar($this->session->userdata("username"))?>">
</div>
<input type="hidden" name="submitted" value="true">
<div class="new-post-form-submit">
 <input type="submit" value="Save Photo">

</div>
</form>

<div class="cf"></div>
</div>
</div>