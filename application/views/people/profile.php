<? $email = md5(strtolower(trim($user->email)));
 $size = 200;
 $url = "http://www.gravatar.com/avatar/$email?size=$size&d=http://wwww.shutttr.com/assets/images/default.png"
 ?>
 <div id="contain">
  <div id="user-contain">
 <div class="left" id="user-img">
 <img src="<?=$this->user->avatar($user->username, 200)?>">
 </div>
 
<div id="user-info">
<h1><span><?= $user->first_name ?> <?= $user->last_name ?></span> <?= $user->username?></h1><? if(isset($inviter[0])): ?>  Invited by: <a href="http://www.shutttr.com/people/<?= $this->user->get_username_by_id($inviter[0]->inviter_id) ?>"><?= $this->user->get_username_by_id($inviter[0]->inviter_id) ?></a><?endif?>
<div id="user-type">
Is a <?= $type ?> <?if(!$this->user->does_a_follow_b($this->session->userdata('id'), $user->id)):?><a href="<?=site_url("people/follow/")."/".$user->username?>">Follow</a><?else:?>
<a href="<?=site_url("people/unfollow/")."/".$user->username?>">Unfollow</a>
<?endif?> | 
<a href="<?= site_url("message/$user->username") ?>">Send Message</a>
</div>
<div id="user-email">
<a href="mailto:<?= $user->email ?>"><?= $user->email ?></a><br />
</div>
<div id="user-stats">
<p>Stats</p>

<a href="<?=site_url("people/$user->username/comments")?>"><?=$this->user->get_number_comments($user->id)?> Comments</a><br>
<a href="<?=site_url("people/$user->username/critiques")?>"><?=$this->user->get_number_critiques($user->id)?> Critiques</a><br>
<a href="<?=site_url("people/$user->username/posts")?>"><?=$this->user->get_number_posts($user->id)?> Posts</a><br>
</div>


<? $group = $this->session->userdata("group"); ?>

</div>
<div class="cf"></div>
<div id="user-bio"><?=$user->bio?></div>

<div id="user-badges">
<? foreach ($badges as $badge): ?>
<span data-tooltip="<?= $badge["name"] ?>"><img src="<?= site_url("assets/images/badges/" . $badge["id"]) ?>.png"></span>
<? endforeach ?>
</div>

</div>
  <div id="sidebar">
                
                 <? require_once(APPPATH . "/models/announcement.php") ?>
    <? $model = new Announcement ?>
    <? $announcement = $model->get() ?>
    <? if ($announcement): ?>
      <div class="announcement_contain">
        <div id="announcement" class="announcement urgency-<?= $announcement->urgency ?>" >
          <?= $announcement->body ?>
          <span id="<?= $announcement->id ?>">X</span>
        </div>
     </div>
    <? endif ?>
    <?if ($this->user->is_admin()):?>
    <div class="admin-pannel">
      <h1><center>User Admin Pannel</center></h1>
      <h2>Rank: <?=$user->p_rank?>% (<?= $user->rank ?>)</h2>
      <form action="<?=site_url("admin/update_invites")?>" method="post">
      <label>Number of invites</label>
      <input type="hidden" value="<?=$user->id?>" name="userid">
      <input type="text" name="invites" value="<?=$this->user->number_invites($user->id)?>">
      <input type="submit" value="Save">
      </form><br>
			<form action="<?=site_url("admin/update_lift_tickets")?>" method="post">
      <label>Number of Lift Tickets</label>
      <input type="hidden" value="<?=$user->id?>" name="userid">
      <input type="text" name="lift_tickets" value="<?=$this->user->number_lift_tickets($user->id)?>">
      <input type="submit" value="Save">
      </form><br>
      <?$data = $this->user->get_user_info($user->username);?>
        <? if($data['login_blocked'] == 1 and $data['unblocked_time'] > time()):?>
        Blocked Until: <?= date('F jS Y g:i A', $data['unblocked_time'])?> <a href="<?=site_url('admin/unblock_login').'/'.$user->username?>">Unblock Login</a>
        <?else:?>Block Login for: 
        <a href="<?=site_url('admin/block_login').'/'.$user->username.'/'.'86400'?>">day</a> /
        <a href="<?=site_url('admin/block_login').'/'.$user->username.'/'.'604800'?>">week</a> /
        <a href="<?=site_url('admin/block_login').'/'.$user->username.'/'.'2629743'?>">Month</a> /
        <a href="<?=site_url('admin/block_login').'/'.$user->username.'/'.'5259487'?>">2 Months</a>
        <?endif?>
        <br>
        <? if($data['comment_blocked'] == 1 and $data['unblocked_time'] > time()):?>
        Blocked Until: <?= date('F jS Y g:i A', $data['unblocked_time'])?> <a href="<?=site_url('admin/unblock_comment').'/'.$user->username?>">Unblock commenting</a>
        <?else:?>Block commenting for: 
        <a href="<?=site_url('admin/block_comment').'/'.$user->username.'/'.'86400'?>">day</a> /
        <a href="<?=site_url('admin/block_comment').'/'.$user->username.'/'.'604800'?>">week</a> /
        <a href="<?=site_url('admin/block_comment').'/'.$user->username.'/'.'2629743'?>">Month</a> /
        <a href="<?=site_url('admin/block_comment').'/'.$user->username.'/'.'5259487'?>">2 Months</a>
        <?endif?>
        <br>
        <? if($data['critique_blocked'] == 1 and $data['unblocked_time'] > time()):?>
        Blocked Until: <?= date('F jS Y g:i A', $data['unblocked_time'])?> <a href="<?=site_url('admin/unblock_critique').'/'.$user->username?>">Unblock critiquing</a>
        <?else:?>Block critiquing for: 
        <a href="<?=site_url('admin/block_critique').'/'.$user->username.'/'.'86400'?>">day</a> /
        <a href="<?=site_url('admin/block_critique').'/'.$user->username.'/'.'604800'?>">week</a> /
        <a href="<?=site_url('admin/block_critique').'/'.$user->username.'/'.'2629743'?>">Month</a> /
        <a href="<?=site_url('admin/block_critique').'/'.$user->username.'/'.'5259487'?>">2 Months</a>
        <?endif?>
       
   </div>
    <?endif?>
            
            
</div>
</div>
<pre>
<?//print_r($user)?>
</pre>
<? if (!$this->session->userdata("id") == $user->id): ?>
  <? if (!$does_follow): ?>
    (<a href="<?= site_url("people/" . $user->username . "/follow/" .
                           base64_encode("people/" . $user->username)) ?>">follow</a>)
  <? else: ?>
    (<a href="<?= site_url("people/" . $user->username . "/unfollow/" .
                           base64_encode("people/" . $user->username)) ?>">unfollow</a>)
  <? endif ?>
<? endif ?>
