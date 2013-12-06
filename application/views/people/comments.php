
<br>
<div id="container">
<div id="content">
<div id="stream">
<header class="stream_header">
            <h2><?=$what_stream?></h2>
        </header>
<?if (!empty($comments)):?>
<?$name = $this->user->get_full_name_by_id($comments[0]->user_id)?>
<?$current_users_name = implode(' ',$this->user->get_full_name_by_id($this->session->userdata('id')))?>
<?$fullname = implode(' ', $name) ?>
<?$username = $this->user->get_username_by_id($comments[0]->user_id)?>

<?foreach($comments as $comment):?>
<?$post_type = $this->post->get_post_type_by_id($comment->post_id);?>
<? $slug = $this->post->get_slug_by_id($comment->post_id)?>
<? $email = md5(strtolower(trim($this->user->get_email_by_id($this->user->get_userid_by_slug($slug)))));
                 $size = 40;
                 $url = "http://www.gravatar.com/avatar/$email?size=$size"
                 ?>
<article>
<header class="post-header">
                 <div class="right">
                 
              <div class="right">

              <div class="user-img-small"><img src="<?=$url?>"></div></div>
              <a href="<?= site_url('people').'/'.$username?>">
		<?= ($fullname == $current_users_name)? 'You' : $fullname?>
	</a> commented on 
	
	<?$poster_name = implode(' ', $this->user->get_full_name_by_id($this->user->get_userid_by_slug($slug)))?>
               <a href="<?= site_url('people').'/'. $this->user->get_username_by_id($this->user->get_userid_by_slug($slug))?>"><?= ($this->user->get_userid_by_slug($slug) == $comment->user_id) ? "their own" : $poster_name.'\'s' ?></a>
	<a href="<?=site_url('posts/').'/'.$slug?>">
		<?= ($post_type ==1)? 'photo' : (($post_type==2)? 'question' : 'link');?>
	</a>
               <br>
               <div class="right">
               <span class="post-time">
               <?= $this->post->relative_time(strtotime($comment->timestamp))?> 
               ago
               </span>
               </div>
                
                </div>
                
                <div class="interaction-group">
                <a href="<?= site_url('posts/post').'/'.$slug?>" class="fancy">View Post</a>
                </div>
                </header>
                <div class="cf"></div>

<p><?=$comment->body?></p>

</article>
<?endforeach?>
<?else:?>
<h1>They have no comments</h1>
<?endif?>
<div id="prev-next" class="group">
            <?if($cur_page !=1):?>
            <a class="left" href="<?=site_url("$stream")."/".($cur_page-1)?>">Prev</a>
            <?endif?>
            
            <?if($cur_page != $num_pages and $num_pages > 1):?>
            
            <a class="right" href="<?=site_url("$stream")."/".($cur_page+1)?>">Next</a>
            <?endif?>
            
            </div>
</div>

</div>
<div id="sidebar">
 <div id="new-post">
                    <a href="<?=site_url('create')?>">New Post +</a>
                </div>
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
    <div class="ad">
                    <p>Place ads here.</p>
                </div>
</div>
</div>