<? if (!isset($success)) $success = false; ?>
<!doctype html>

<html lang="en" class="no-js">

<head>

    <meta charset="utf-8">
    <meta name="description" content="Shutttr is a community geared toward professional and amateur photographers, as well as photo enthusiasts. With Shutttr, getting quality critiques on your photos is easier than ever before. Shutttr provides you with a quick way to get an accurate assessment of your photo with our weighted rating system. There is also incentive given to critics to write in depth and thought out critiques so that you can get the most out of your critiques."> 
    <meta name="keywords" content="photography,critique,critic,photographer,photograph,critiques,photographers,photographs,critics,rating,ratings,community,communities,social,network,networks,shutttr,shuttr,shutter,shuttter,camera,cameras" /> 
    <meta name="author" content="Joshua Hibbert">
    <meta name="author" content="Adrian Sinclair">
    <meta name="author" content="Barrett Shepherd">

  <title>Shutttr | Signup</title>
    
    <link rel="stylesheet" href="<?= site_url("assets/beta/css/style.css?v=1") ?>">
    
    <script src="<?= site_url("assets/beta/js/modernizr-1.6.min.js") ?>"></script>
    <script type="text/javascript">

      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-25176180-1']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();

    </script>
</head>

<body>
  <? if ($success): ?>
    <div class="success-message">
      Thanks for registering! We'll notify you when were ready!
    </div>
  <? endif ?>
  <? if (!isset($validation_errors)) $validation_errors = validation_errors() ?>
  <? if ($validation_errors): ?>
    <div class="error-message">
      <div>
        <?= $validation_errors ?>
      </div>
    </div>
  <? endif ?>
  <div id="twitter-bar-container">  
        <div id="twitter-bar">
      <div id="twitter_div"><ul id="twitter_update_list"><li>&nbsp;</li></ul></div>
          <a class="button" href="http://twitter.com/#!/Shutttr" target="_blank">Follow Shutttr on Twitter</a>
      </div>
    </div>
    
    <div id="container">
    <h2 style = "text-align:center; "> Already a member? Sign in <a href="<?=site_url('login')?>" style="color:#295073;">here!</a> Already have an invite code? Enter it <a href="http://shutttr.com/invite">here</a>!</h2></h2>
      <header>
      	<img src="<?= site_url("assets/images/shutttr.png") ?>" alt="Shutttr">  
    	</header>
  
      <div id="content" class="group">

        <div id="left-column" class="left">
              <h2>What is Shutttr</h2>
              <p>Shutttr is a community geared toward professional and amateur photographers, as well as photo enthusiasts. With Shutttr, getting quality critiques on your photos is easier than ever before. Shutttr provides you with a quick way to get an accurate assessment of your photo with our weighted rating system. There is also incentive given to critics to write in depth and thought out critiques so that you can get the most out of your critiques.
              </p><br>
              <h2>About Shutttr</h2>
              <p>Shutttr is based on the closed community model which means that our members will be dedicated to helping the community grow in a positive way. This means that Shutttr will always be invite only. While this system isn’t perfect, we feel it is the best for making your experience with Shutttr as excellent as possible.
              </p><br>
              <h2>Why should I sign up?</h2>
              <p>Signing up now will put you at the top of our queue when we launch. You will also be involved in the testing and feedback of Shutttr and will have an important voice in the community.
              </p><br>
             <h2>Anything else?</h2>
              <p>Feel free to email us hello@shutttr.com with any questions or comments!
              </p>
            </div>
            <div id="right-column" class="right">
              <?= form_open("welcome/signup") ?>
                <label for="first_name">First Name: <span class="red">*</span></label>
                <?= form_input("first_name", $success ? "" : set_value("first_name")) ?>
                
                <label for="email">Email: <span class="red">*</span></label>
                <?= form_input(array("type" => "email", "name" => "email", "value" => $success ? "" : set_value("email"))) ?>
                <label for="username">Username: <span class="red">*</span>
                <br>(Reserve Your Username).</label>
                <?= form_input("username", $success ? "" : set_value("username")) ?>
                <label for="twitter">Twitter:</label>
                <?= form_input('twitter', '@'); ?>
                <label for="works">Link to Work:<span class="red">*</span></label>
                <?= form_input('link_to_work', 'http://');?>
                
                
                <input id="submit" name="form_submitted" type="submit" value="Signup Now!">
              <?= form_close() ?>
          </div>
        
      </div>
    
      	<footer>
        
		<!--	<p><strong><a href="#">About</a> | <a href="#">Contact</a> | <a href="#">FAQ</a> | <a href="#">Guidelines</a> | <a href="#">Privacy</a> | <a href="#">Terms</a></strong></p>-->
            <p>Copyright &copy; 2011 Shutttr. All photos &copy; their respective owners.</p>
            <p><strong><a class="twitter" href="#">Follow Shutttr on Twitter</a></strong></p>

		</footer>
        
      </div><!-- End Container -->
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>
    <script>
      !window.jQuery && document.write(unescape('%3Cscript src="<?= site_url("assets/beta/js/jquery-1.6.2.js") ?>"%3E%3C/script%3E'))
    </script>
    <script>
      $(function() {
        setTimeout(function() {
          $(".success-message").slideUp(1000);
        }, 5000);
      });
    </script>
    <script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>
  <script type="text/javascript" src="http://twitter.com/statuses/user_timeline/shutttr.json?callback=twitterCallback2&count=1"></script>
<script type="text/javascript">
        var trackImg = document.createElement('img');
        trackImg.src = 'http://tinylitics.nfshost.com/php/tracking.php?token=c81e7&link_back='+document.referrer;
        document.body.appendChild(trackImg);
    </script>
</body>

</html>