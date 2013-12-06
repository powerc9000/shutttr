   
        <br>
        <div id="container">
        <div id="content">
            <div id="stream">
            <header class="stream_header">
            <h2><?=$what_stream?></h2>
            <hr>
            </header>

            <? foreach ($photos as $photo): ?>
            <?if($photo->hidden == 0):?>
                <article>
              <div class="right">
                <div class="fancy-margin-fix">
                <a href="<?=site_url("posts/post/$photo->slug")?>#comment-land" class="fancy">
                  <?= $this->comment->get_number_of_comments_for_post($photo->id);?> Comments
                </a>
                </div>
                <div class="fancy-margin-fix">
                <a href="<?= site_url('posts/post').'/'.$photo->slug?>" class="fancy">View</a>
                </div>
              </div>

              <? $email = md5(strtolower(trim($this->user->get_email_by_id($photo->user_id))));
                 $size = 40;
                 $url = "http://www.gravatar.com/avatar/$email?size=$size"
                 ?>
              <div class="left"><div class="user-img-small"><img src="<?=$url?>"></div></div>

               <a href="<?=site_url('people'). '/' . $this->user->get_username_by_id($photo->user_id) ?>">
                <?=($photo->user_id == $this->session->userdata('id')) ? 'You' : implode(' ',$this->user->get_full_name_by_id($photo->user_id))?>
               </a>
               posted a 
               <?=($photo->post_type == 1) ? 'photo' : (($photo->post_type ==2) ? 'question' : 'link')?>
               <?= $this->post->relative_time(strtotime($photo->timestamp))?> 
               ago
               <div class="cf"></div>
               
                <?if($photo->post_type !=3):?>
                    <h2><a href="<?= site_url("posts/post/" . $photo->slug) ?>"><?= ucfirst($photo->post_title) ?></a></h2>
                <?else:?>
                    <h2><a href="<?= $photo->link ?>"><?= ucfirst($photo->post_title) ?></a></h2>
                    <span class="link-post-url main-stream"><a href="<?= $photo->link ?>"><?=$photo->link?></a></span>
                
                <?endif?>

                    <?if($photo->post_type ==1):?><a href="<?= site_url("posts/post" . $photo->slug) ?>"><img src="http://shutttr.s3.amazonaws.com/photo_uploads/<?= $photo->file_name ?>"></a><?endif?>
                    <p><?= $photo->description ?> <br></p>
                    
                    <div class="cf"></div>
                </article>
                <?endif?>
            <? endforeach ?> 
            <div id="prev-next" class="group">
            <?if($cur_page !=1):?>
            <a class="left" href="<?=site_url("posts/page")."/".($cur_page-1)?>">Prev</a>
            <?endif?>
            <?if($cur_page != $num_pages):?>
            <a class="right" href="<?=site_url("posts/page")."/".($cur_page+1)?>">Next</a>
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
    
        