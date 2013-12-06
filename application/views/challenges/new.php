<h1>Make a new challenge</h1>
<form action="<?=site_url("challenges/new_challenge")?>" method="post">
	<input type="text" placeholder="Challenge Title" name="title">
	<br>
	<textarea placeholder="Challenge Description" name="description"></textarea>
	<br>
	<input type="text" placeholder="Starting date mm/dd/yyyy" name="start_date">
	<br>
	<input type="text" placeholder="Ending date mm/dd/yyyy" name="end_date">
	<input type="hidden" name="submitted" value="true">
	<br>
	<input type="submit" value="Add Challenge">
</form>