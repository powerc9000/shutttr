
	<h1><?=$challenge->title?></h1>
	<?if($challenge->active == 1):?>
	<a href="create">Enter a photo</a>
	<?endif?>
	<p><?=$challenge->description?></p>
	<?$photos = $this->challenge->get_challenge_entries($challenge->id);?>
	<?var_dump($photos)?>
