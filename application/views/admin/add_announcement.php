 <?if($this->user->is_admin($this->session->userdata("username"))):?>
<h1>Add an announcement</h1>
<?
$data = array(
'name' => 'body',
'rows' => '5', 'cols' => '40' )?>
<?= form_open('admin/new_announcement');?>
<?= form_textarea($data);?>
<?= form_submit('', 'submit');?>
</form>
<table border>
	<tr>
		<td>Body</td>
		<td>Creator</td>
		<td>Creation Date</td>
		<td>Views</td>
		<td>Options</td>

	</tr>
<?foreach($announcements as $announcement):?>
	<tr>
		<td>
			<?= $announcement['body']; ?>
		</td>
		<td>
		<?$creator = $this->user->get_first_name_by_id($announcement['creator_id']);?>
		<?= $creator ?>
			
		</td>
		<td>
			<?= date('M jS, Y g:i A', mysql_to_unix($announcement['timestamp']));?>
		</td>
		<td>
		<? $this->db->where('announcement_id', $announcement['id']);
		$this->db->from('announcements_viewed');
		echo $this->db->count_all_results() ;
		?>
		</td>
		<td>	
		<? if($announcement["live"] == "0"): ?><a href="<?= site_url("admin/unhide_announcement/" . $announcement['id']) ?>"><? endif ?>Enabled</a> / 	<? if($announcement["live"] == "1"): ?><a href="<?= site_url("admin/hide_announcement/" . $announcement['id']) ?>"><? endif ?>Disabled</a>
			<?= form_open('admin/delete_announcement');?>
			<?= form_hidden('val',$announcement['id'])?>
			<?= form_submit(array('value' => 'Delete')); ?>
			</form>
	</tr>
<?endforeach?>

<table>
<?else:?>
<?redirect('/posts/photos');?>
<?endif?>