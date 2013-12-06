<html>
<head>
	<title><?=$info->post_title?> | Shutttr</title>
	<link rel="stylesheet" href="<?=site_url("assets/css/slimbox2.css")?>">
	<link rel="stylesheet" href="<?=site_url("assets/css/foundation.css")?>">
	<link rel="stylesheet" href="<?=site_url("assets/css/viewer.css")?>">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
	<script type="text/javascript">
		$("document").ready(function(){
			$("a.thumbnail").live("click",function(){
	var roofies = $(this).attr("href");	
	$("#photo-large").empty();
	$("#photo-large").append("<img src='"+roofies+"'>");
	return false;
	});
		});
	</script>
</head>
<body>
	<div class="row">
		<div class="columns sidebar">
		<!--Barrett Don't hide this ever! how will users know how to get back to the post if someone just gives them the link to the viewer don't hide it if you are logged in just don't !-->
			<a href="<?=site_url("posts/post/$info->slug")?>" class="button radius large link-to-post">See Post on Shutttr</a>
			<div class="adbg"><a href="http://adpacks.com" id="bsap_aplink">ADS VIA AD PACKS</a><div id="bsap_1270147" class="bsarocks bsap_eb58872ba13d97cbf39dce5c71fcb150"></div>
			</div>
		</div>
			<div class="columns photos">
			<div class="photos-wrapper">
			<? if(count($photos) === 1): ?>
			<h3><?=$info->post_title?></h3>
			<h6>Click the photo to make it bigger</h6>
			<? else: ?>
			<h3><?=$info->post_title?></h3>
			<h4>Photos in roll</h4>
			<h6>Click a photo to make it bigger</h6>
			<?endif?>
				<?foreach($photos as $photo):?>
					<a href="http://shutttr.s3.amazonaws.com/photo_uploads/<?=$photo->filename?>" rel="lightbox-set" class="thumbnail">
					<img src="http://shutttr.s3.amazonaws.com/photo_uploads_medium/<?=$photo->filename?>">
					</a>
				<?endforeach?>
			</div>

			<div id="photo-large">
			
			</div>

		</div>
		
	</div>
	<script type="text/javascript">
(function(){
  var bsa = document.createElement('script');
     bsa.type = 'text/javascript';
     bsa.async = true;
     bsa.src = 'http://s3.buysellads.com/ac/bsa.js';
  (document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild(bsa);
})();
</script>
</body>
</html>