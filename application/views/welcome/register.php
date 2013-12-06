<!doctype html>

<html lang="en" class="no-js">

<head>

    <meta charset="utf-8">
    <meta name="description" content=""> 
    <meta name="keywords" content=""> 
    <meta name="author" content="Joshua Hibbert">

  <title>Shutttr | Signup</title>
    
    <link rel="stylesheet" href="<?= site_url("assets/beta/css/style.css?v=1") ?>">
    
    <script src="<?= site_url("assets/beta/js/modernizr-1.6.min.js") ?>"></script>
    
</head>

<body>

  <div id="twitter-bar-container">  
        <div id="twitter-bar">
      <div id="twitter_div"><ul id="twitter_update_list"><li>&nbsp;</li></ul></div>
          <a class="button" href="http://twitter.com/#!/Shutttr" target="_blank">Follow Shutttr on Twitter</a>

        <!-- <p><strong>Shutttr is now on Twitter!</strong> &ndash; <small>30 minutes ago</small></p> -->
        
      </div>
    </div>
    
    <div id="container">

      <header>
    
      <img src="images/logo.png" alt="Shutttr">
         
    </header>
    
      <div id="content" class="group">
    
        <div id="left-column" class="left">
              <h2>About Shutttr</h2>
                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                <h2>What is Shutttr?</h2>
                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                <img class="sample-image" src="images/sample.png" alt="Sample Photo">
            </div>
            
            <div id="right-column" class="right">
              <? if (!isset($validation_errors)) $validation_errors = validation_errors() ?>
              <? if ($validation_errors): ?>
                <div class="validation-errors">
                  <?= $validation_errors ?>
                </div>
              <? endif; ?>
              <?= form_open("register") ?>
                <label for="first-name">First Name: <span class="red">*</span></label>
                <?= form_input("first_name", set_value("first_name"), array("required" => "yes")) ?>
                <label for="last-name">Last Name: <span class="red">*</span></label>
                <?= form_input("last_name", set_value("last_name"), array("required" => "yes")) ?>
                <label for="email">Email: <span class="red">*</span></label>
                <?= form_input(array("type" => "email", "name" => "email", "value" => set_value("email"), "required" => "yes")) ?>
                <label for="username">Username: <span class="red">*</span></label>
                <?= form_input("username", set_value("username"), array("required" => "yes")) ?>
                <label for="username">Password: <span class="red">*</span></label>
                <?= form_password("password", "", array("required" => "yes")) ?>
                <label for="username">Confirm Password: <span class="red">*</span></label>
                <?= form_password("passconf", "", array("required" => "yes")) ?>
                <label for="about-yourself">About Yourself: <span class="red">*</span></label>
                <textarea id="about-yourself" name="about-yourself" rows="9" required></textarea>
                <?= form_textarea("bio", "", array("required" => "yes")) ?>
                <label for="account-type">Account Type: <span class="red">*</span></label>
                <select id="account-type" name="account-type" required>
                  <option value="" selected>Option A</option>
                  <option value="">Option B</option>
                  <option value="">Option C</option>
                </select>
                <input id="submit" type="submit" value="Signup Now!">
              <?= form_close() ?>
              <!--
              <? if (!isset($validation_errors)) $validation_errors = validation_errors() ?>
              <? if ($validation_errors): ?>
                <div class="validation-errors">
                  <?= $validation_errors ?>
                </div>
              <? endif; ?>
              <?= form_open("register") ?>
                <p>
                  <label for="first_name">First Name:</label>
                  <?= form_input("first_name", set_value("first_name")) ?>
                </p>
                <p>
                  <label for="last_name">Last Name:</label>
                  <?= form_input("last_name", set_value("last_name")) ?>
                </p>
                <p>
                  <label for="username">Username:</label>
                  <?= form_input("username", set_value("username")) ?>
                </p>
                <p>
                  <label for="password">Password:</label>
                  <?= form_password("password") ?>
                </p>
                <p>
                  <label for="passconf">Confirm password:</label>
                  <?= form_password("passconf") ?>
                </p>
                <p>
                  <label for="email">Email address:</label>
                  <?= form_input(array("type" => "email", "name" => "email", "value" => set_value("email"))) ?>
                </p>
                <p>
                  <label for="bio">About yourself:</label><br />
                  <?= form_textarea("bio") ?>
                </p>
                <p>
                  <?= form_submit("form_submitted", "Register") ?>
                </p>
              <?= form_close() ?>
              -->
          </div>
        
      </div>
    
      <footer>
        
      <p>Copyright &copy; 2011 Shutttr.</p>

    </footer>
        
    </div><!-- End Container -->
    
    <script src="//http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script>
      !window.jQuery && document.write(unescape('%3Cscript src="<?= site_url("assets/beta/js/jquery-1.6.2.js") ?>"%3E%3C/script%3E'))
    </script>
    
    <script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>
  <script type="text/javascript" src="http://twitter.com/statuses/user_timeline/shutttr.json?callback=twitterCallback2&count=1"></script>
    
</body>

</html>