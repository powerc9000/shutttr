<!doctype html>

<html lang="en" class="no-js">

<head>

    <meta charset="utf-8">
    <meta name="description" content=""> 
    <meta name="keywords" content=""> 
    <meta name="author" content="Joshua Hibbert">

	<title>Shutttr | Login</title>
    
    <link rel="stylesheet" href="<?= site_url('assets/css/login.css?v=1') ?>">
    
    <script src="<?= site_url('assets/js/modernizr-1.6.min.js') ?>"></script>
    
</head>

<body>

	<div id="header-bar"></div>

    <div id="container">

    	<header class="group">
    
			<a href="http://shutttr.com"><img class="left" src="<?= site_url('assets/logo/logo_light.png') ?>" alt="Shutttr"></a>
            <p class="right"><a href="http://www.shutttr.com">Sign Up</a></p>
         
		</header>
    
    	<div id="content">
        <? if ($this->session->flashdata("error")): ?>
          <div class="error-message"><?= $this->session->flashdata("error") ?></div>
        <? endif ?>
				<? if ($this->session->flashdata("login_validation_errors")): ?>
          <div class="error-message"><?= $this->session->flashdata("login_validation_errors") ?></div>
        <? endif ?>
    	 	<section id="login">
            	<h1>Login</h1>
                <?= form_open("login/auth") ?>
                    <label for="username">Email or Username: <span class="red">*</span></label>
                    <input id="username" name="login" type="text" placeholder="" required>
					<label for="password">Password: <span class="red">*</span></label>
                    <input id="password" name="password" type="password" placeholder="" required>
                    <p>Forgot your password? Email us hello@shutttr.com!</p>
                    <input id="submit" type="submit" value="Enter Shutttr!">
                </form>
            </section>
            
          <!--  <section id="ads">
            	<div class="ad">
                	<p>Place ads here.</p>
                </div>
            </section>-->
        
    	</div>
    
    	<footer>
            <p>Copyright &copy; 2011 Shutttr. All photos &copy; their respective owners.</p>
            <p><strong><a class="twitter" href="http://www.twitter.com/shutttr">Follow Shutttr on Twitter</a></strong></p>

		</footer>
        
    </div><!-- End Container -->
    
    <script src="//http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script>!window.jQuery && document.write(unescape('%3Cscript src="js/jquery-1.6.2.js"%3E%3C/script%3E'))</script>
    
</body>

</html>
