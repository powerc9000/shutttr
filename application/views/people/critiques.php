<?if (!empty($comments)):?>
<?$current_users_name = implode(' ',$this->user->get_full_name_by_id($this->session->userdata('id')))?>
<?$fullname = implode(' ', $this->user->get_full_name_by_id($comments[0]->user_id)) ?>
<?$username = $this->user->get_username_by_id($comments[0]->user_id)?>
<?foreach($comments as $comment):?>

<? $slug = $this->post->get_slug_by_id($comment->photo_id)?>
<P>
	<a href="<?= site_url('people').'/'.$username?>">
		<?= ($fullname == $current_users_name)? 'You' : $fullname?>
	</a> commented on 
	
	<?$poster_name = implode(' ', $this->user->get_full_name_by_id($comment->user_id))?>
	
	<a href="<?= site_url('people').'/'.$username?>"><?= ($poster_name == $fullname) ? "their own" : $poster_name.'\'s' ?>
	<a href="<?=site_url('posts/photo').'/'.$slug[0]->slug?>">
		photo
	</a>
</p>
<p><?=$comment->body?></p>


<?endforeach?>
<?else:?>
<h1>They have no critiques</h1>
<?endif?>