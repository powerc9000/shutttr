<div id="new-post-container">
<div class="new-post-form">
<h1 class="new-post-header">Invite someone to Shuttr</h1>
<?if($number_invites < 1): ?>
<h1>You dont have any invites, if youd like some email hello@shutttr.com</h1>
<?else:?>
<h1>You currently have <?=$number_invites?> invites.</h1>
<?endif?>
<?= form_open("invite/email") ?>
<label for="email">Email:</label>
<?= form_input("email", set_value("email")) ?>
<input type="hidden" name="form_submitted" value="true">
<input type="submit" value="Invite!">

</form>
</div>
</div>