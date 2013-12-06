<!DOCTYPE html>

<html lang="en">
  <head>
<meta name="google-site-verification" content="5WbGA04niDjQPQMpc3qv5M2EHYi5PDL4cnIDx5euYUA" />
    <meta charset="utf-8" />
  <link rel="icon" href="<?= site_url("assets/logo/favicon.ico") ?>" />
    <link rel="stylesheet" href="<?= site_url("assets/css/stream.css?v=1") ?>">
    <link rel="stylesheet" href="<?= site_url("assets/css/style.css?v=1") ?>">
    <link rel="stylesheet" href="<?= site_url("assets/css/lightbox.css?v=1") ?>">
    <title><?= isset($title) ? $title : "Shutttr" ?></title>
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <script src="<?= site_url("assets/js/modernizr-1.6.min.js") ?>"></script>
    <script src="<?= site_url("assets/js/bootstrap-alerts.js") ?>"></script>
    <script src="<?= site_url("assets/js/lightbox.js") ?>"></script>
  </head>
  <body>
  <script type="text/javascript">
(function(){
  var bsa = document.createElement('script');
     bsa.type = 'text/javascript';
     bsa.async = true;
     bsa.src = 'http://s3.buysellads.com/ac/bsa.js';
  (document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild(bsa);
})();
</script>
  <form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="donate-form">
    <input type="hidden" name="cmd" value="_s-xclick">
    <input type="hidden" name="hosted_button_id" value="UU7KUQUDBEDZ6">
    <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
    <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
  </form>
  <div class="loader-gif">Loading</div>
  <script>


  $('document').ready(function(){
    
  $('#post-photo a').lightBox({
    imageLoading: "<?=site_url("assets/images/ajaxloader.gif")?>",
  imageBtnClose: "<?=site_url("assets/images/lightbox-close.gif")?>",
  }); 
    
    $('#announcement span').live('click', function(){
      var id = $('#announcement span').attr('id');
      var post_data = {'id': id};
      $.post("<?= site_url('admin/announcement_viewed')?>", post_data, function(response)
    { 
      if(response)
      {
      $('#announcement').slideUp(100, function(){
      $('#announcement').remove();
      });
      var json = $.parseJSON(response);
      if(json != 'false')
      {
      $('.announcement_contain').append('<div id="announcement" class="announcement urgency-'+json.urgency+'">'+json.body+'<span id="'+json.id+'">X</span></div>').$(this).stop();
      
      }
    }
      
    });
      
    
    });
  });
  </script>
<div id="header-bar">
      <header class="group">
      <a href="<?= site_url() ?>"><img class="left" src="<?=site_url('assets/logo/logo_light.png')?>" alt="Shutttr"></a>
      <? $email = md5(strtolower(trim($this->session->userdata('email'))));
         $size = 36;
         $url = "http://www.gravatar.com/avatar/$email?s=$size"
         ?>
        
            <div class="right group account-dropdown-parent"><img id="avatar" class="left" src="<?=$this->user->avatar($this->session->userdata("username"), 36)?>" width="36px"alt="avatar"><a class="right  first-level" href="<?= site_url("people").'/'.$this->session->userdata('username') ?>">My&nbsp;Profile</a>
             <ul class="account-dropdown">
                  <li><a href="<?= site_url("messages") ?>">Your Messages</a></li>
                  <li><a href="<?= site_url("settings") ?>">Account Settings</a></li>
                  <li><a href="<?= site_url("logout") ?>">Logout</a></li>
                </ul>

            </div>
              <!-- stop censorshipr code !-->
               
              
           
    </header>
    </div>
    <div id="sub-menu-wrapper" class="group">
      <div id="sub-menu">
          <nav>
            <ul>
              <li class="parent">
                <a href="<?= site_url() ?>">Posts</a>
                <ul>
                  <li><a href="<?= site_url() ?>">All Posts</a></li>
                  <li><a href="<?= site_url("posts/photos") ?>">Photos</a></li>
                  <li><a href="<?= site_url("posts/critiques") ?>">Critiques</a></li>
                  <li><a href="<?= site_url("posts/questions") ?>">Questions</a></li>
                  <li><a href="<?= site_url("posts/links") ?>">Links</a></li>
									<hr>
									<li><a href="<?= site_url("posts/popular") ?>">Popular</a></li>
                  <li><a href="<?= site_url("posts/following") ?>">People You follow</a></li>
                </ul>
              </li>
              <li>
                <a href="<?= site_url("people/") ?>">People</a>
              </li>
              <li>
                <a href="<?= site_url("people/" . $this->session->userdata("username") . "/posts") ?>">My Posts</a>
              </li>
            <? if($this->user->is_admin($this->session->userdata("username"))): ?>
              <li class="parent">
                <a href="<?= site_url("admin") ?>">Admin</a>
                <ul>
                  <li><a href="<?= site_url("admin/invites") ?>">Invite Queue</a></li>
                  <li><a href="<?= site_url("admin/posts_flags") ?>">Post Flags</a></li>
                  <li><a href="<?= site_url("admin/comment_flags") ?>">Comment Flags</a></li>
									<li><a href="<?= site_url("admin/announcements") ?>">Announcments</a></li>
                  <li><a href="<?= site_url("admin/user_panel") ?>">User Panel</a></li>
									<li><a href="<?= site_url("admin/metrics") ?>">User Metrics</a></li>
                </ul>
              </li>
            <?endif?>
            <? if(!$this->user->is_admin($this->session->userdata("username"))): ?><? $v_g = !$this->user->guideline_views($this->session->userdata("id"))->guideline_views ?>
            <li<?= $v_g ? ' class="not-viewed-gl"' : "" ?>>
              <a href="<?= site_url("guidelines") ?>">Guidelines</a>
            </li><?endif?>
<? if(($num_invites = $this->user->number_invites($this->session->userdata("id"))) >= 1): ?>
	<li>
               <a href="<?= site_url("invite/email") ?>">Invites <small class="invite-badge"><?= $num_invites ?></small></a>
              </li>
<?endif ?> 
<? if($this->user->is_admin($this->session->userdata("username"))): ?>
<? if(($num_lift_tickets = $this->user->number_lift_tickets($this->session->userdata("id"))) >= 1): ?>
	<li>
               <a href="#">Lift Tickets <small class="invite-badge"><?= $num_lift_tickets ?></small></a>
              </li>
<?endif ?> <?endif ?> 
            </ul>
          </nav>
         
            <!--<input class="right" type="search">-->
        </div>
    </div>
    
	 <?if($this->session->flashdata("message")):?>
    <div class="alert-message fade in <?=$this->session->flashdata('type')?>" data-alert="true">
          <a class="close" href="#">×</a>
          <p><?= $this->session->flashdata('message') ?></p>
        </div>
    <?endif?>
    <?= $content ?>
    <footer>
          <div style="margin-top:5px; text-align:center;"><a href="http://www.mediatemple.net#a_aid=4e97536c36cd5&amp;a_bid=07f65597" target="_top"><img src="https://affiliate.mediatemple.net/accounts/default1/banners/mt-60x30-dk.gif" alt="Great web hosting by Media Temple" title="Great web hosting by Media Temple" width="60" height="30" /></a><img style="border:0" src="https://affiliate.mediatemple.net/scripts/imp.php?a_aid=4e97536c36cd5&amp;a_bid=07f65597" width="1" height="1" alt="" /></div>
          <p><strong><a href="http://blog.shutttr.com">Blog</a> | <a href="mailto:hello@shutttr.com">Contact</a> | <span data-tooltip="Coming Soon" class="like-data-tooltip"><a href="#">FAQ</a></span> | <a href="<?= site_url("guidelines") ?>">Guidelines</a> | <span data-tooltip="Coming Soon" class="like-data-tooltip"><a href="#">Privacy</a></span> | <span data-tooltip="Coming Soon" class="like-data-tooltip"><a href="#">Terms</a></strong><span> </p>
            <p>Copyright &copy; 2011 Shutttr. All photos &copy; their respective owners.</p>
            <p><strong><a class="twitter" href="#">Follow Shutttr on Twitter</a></strong><div class="cf"></div></p>

           
           
    </footer>
        
    </div><!-- End Container -->
    
    
  </body>
  <?if($this->user->is_admin($this->session->userdata("username"))): ?>
     <script type="text/javascript">
     $(document).ready(function(){
        $('#admin_groups a').click(function() {
    var group = $(this).text();
    var answer = confirm("Change user to a " +group+"?" );
    if (answer) {
        return true;
    }
    else {
        return false;
    }
});
        });
        </script>
         <?endif?>
<!--<?
 if($this->user->is_admin($this->session->userdata("username"))){}
else{
?>-->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-27670749-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<!--<? }?>-->


</html>
