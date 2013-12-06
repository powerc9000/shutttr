
<div id="new-post-container">

<div class="new-post-form">

<? if (!isset($validation_errors)) $validation_errors = validation_errors() ?>
<? if ($validation_errors): ?>
  <div class="validation-errors">
    <?= $validation_errors ?>
  </div>
<? endif; ?>
<h1 class="new-post-header">Account Settings</h1>
<?= form_open("settings") ?>
  <div class="new-post-title">
	<label for="first_name">First Name:</label>
	<?= form_input("first_name", $user->first_name);?>
  </div>
  <div class="new-post-title">
	<label for="last_name">Last Name:</label>
	<?= form_input("last_name", $user->last_name); ?>
  </div>
  <div class="new-post-title">
    <label for="email">Email address:</label>
    <?= form_input(array("type" => "email", "name" => "email", "value" => $user->email)) ?>
 </div>
	<? $user_group = $this->session->userdata("group"); ?>
	<?php if(Turnstiles::restrict('settings_type', $user_group)): ?>
 
	<? endif?>
  <div class="new-post-title">
  <label>Password</label>
  <?= form_password('password')?>
  <label>Confirm Password</label>
  <?= form_password('passconf')?>
  </div>
   <div class="new-post-description">
  <label>Bio:</label>
  
  <?= form_textarea('bio',$user->bio);?>
  </div>
  <div class="new-post-title">
  <label for="twitter">Twitter Username</label>
  <input type="text" name="twitter" id="twitter" value="<?=$user->twitter?>">
  </div>
  <div class="new-post-title">
  <label for="website">Link to your work</label>
  <input type="text" name="website" id="website" value="<?=$user->link_to_work?>">
  </div>
  <div class="new-post-title inline">
    <label>Use Gravatar as my <a href="<?=site_url("settings/avatar")?>">profile picture</a>:</label>
    <?= form_checkbox("gravatar", 'gravatar', $user->gravatar) ?>
  </div>
  <div class="new-post-title inline">
    <label>Block others from downloading your photos:</label>
    <?= form_checkbox("b_dl", "DUH DUH DUH", $user->b_dl) ?>
  </div>
  <div class="new-post-form-submit">
  <?= form_submit('update', 'Update') ?>


  </div>
<?= form_close() ?>
</div>
</div>
