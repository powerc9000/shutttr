<html>
<head>
<title>Welcome to Shutttr</title>
<link rel="stylesheet" href="<?=site_url("assets/css/stream.css")?>">
<link rel="stylesheet" href="<?=site_url("assets/css/style.css")?>">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script src="<?= site_url("assets/js/modernizr-1.6.min.js") ?>"></script>
<script src="<?= site_url("assets/js/bootstrap-alerts.js") ?>"></script>

</head>
<body>
 
  
<div id="new-post-container">
<div class="new-post-form">
<h1 class="new-post-header">Shutttr invite key</h1>

<?= form_open("invite") ?>
<label for="email">Insert key here</label>
<?= form_input("key")?>
<input type="hidden" name="form_submitted" value="true">
<input type="submit" value="Invite!">

</form>
</body>
</html>