
<html>
<head>
	<title></title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
	<script type="text/javascript" src="<?=site_url("assets/js/masonry.js")?>"></script>
	<script type="text/javascript">
	$("document").ready(function(){
		$('#contain').imagesLoaded(function(){
		$('#contain').masonry({
			itemSelector : '.photo_photo',
    		
		});
	});
	});
	</script>
	<style>
		
		#contain{
			
			position:relative;
			clear:both;
		}
		#contain div {
			width: 350px;
  			margin: 10px;
  			float: left;
			

		}
		 a.overlord img{
			max-width:350px;
			
		}
		a.underling img{
			max-width:100px;
		}
	</style>
</head>
<body>

	<div id="contain">
	
	
		<?foreach($photos as $photo):?>
		<?$stack = $this->post->get_stack_photos($photo->id)?>
		
			<?if(empty($stack)):?>
				<div class="photo_photo"><a href="#" class="overlord">
					<img src="http://shutttr.s3.amazonaws.com/photo_uploads_medium/<?=$photo->file_name?>">
					
				</a>
				<p><?= $photo->description?></p>
				</div>
			<?else:?>
				
					<div class="photo_photo">
						<?foreach($stack as $key=>$s):?>
							<?if($key==0):?>
								<a href="#" class="overlord">
									<img src="http://shutttr.s3.amazonaws.com/photo_uploads_medium/<?=$s->filename?>">
									
								</a>
								<?else:?>
								<a href="#" class="underling"><img src="http://shutttr.s3.amazonaws.com/photo_uploads_medium/<?=$s->filename?>"></a>
							<?endif?>
							
								
							
						<?endforeach?>
						<p><?= $photo->description?></p>
					</div>
					
			<?endif?>
		<?endforeach?>
	
</div>
</body>
</html>
