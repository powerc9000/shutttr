<div id="new-post-container">
<div class="new-post-form">
<h1 class="new-post-header">How many keys do you want sir?</h1>
<h1>Just input the number of keys you want generated in the form </h1>
<h1>make sure the number of keys is greater than 1 </h1>
<?= form_open("admin/invite_keys") ?>
<label for="email">Number O' Keys</label>
<?= form_input("invite_keys")?>
<input type="hidden" name="form_submitted" value="true">
<input type="submit" value="Invite!">

</form>
</div>
</div>