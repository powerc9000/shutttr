  
   <script src="<?=site_url("assets/js/like.js")?>"></script>
        <br>
        <div id="container">
    	<div id="content">
			<div id="stream">
            <header class="stream_header">
            <h2><?=$what_stream?></h2>
            </header>
<? if(!empty($photos)):?>
			<? foreach ($photos as $photo): ?>
            <?if($photo->hidden == 0):?>
            	<article>
              <? $email = md5(strtolower(trim($this->user->get_email_by_id($photo->user_id))));
                 $size = 40;
                 $url = "http://www.gravatar.com/avatar/$email?size=$size"
                 ?>
                 <header class="post-header">
                 <div class="right">
                 
              <div class="right">

              <div class="user-img-small"><img src="<?=$this->user->avatar($this->user->get_username_by_id($photo->user_id), 40)?>"></div></div>

               <a href="<?=site_url('people'). '/' . $this->user->get_username_by_id($photo->user_id) ?>">
                <?=($photo->user_id == $this->session->userdata('id')) ? 'You' : implode(' ',$this->user->get_full_name_by_id($photo->user_id))?>
               </a>
               posted a 
                <?=($photo->post_type == 1) ? 'photo' : (($photo->post_type ==2) ? 'question' : (($photo->post_type == 3) ? 'link' : 'critique')) ?>
               <br>
               <div class="right">
               <span class="post-time">
               <?= $this->post->relative_time(strtotime($photo->timestamp))?> 
               ago
               </span>
               </div>
                
                </div>
                <?if($photo->post_type !=3):?>
                  <h2><a href="<?= site_url("posts/post/" . $photo->slug) ?>"><?= ucfirst($photo->post_title) ?></a></h2>
                <?else:?>
                    <h2><a href="<?= $photo->link ?>"><?= ucfirst($photo->post_title) ?></a></h2>
                    <span class="link-post-url main-stream"><a href="<?= $photo->link ?>"><?=$photo->link?></a></span>
                
                <?endif?>
                <?if($photo->post_type==4):?>
                <span class="critique-photo-rating">A critique of <?=implode(' ',$this->user->get_full_name_by_id($this->user->get_userid_by_slug($this->post->get_slug_by_id($photo->photo_id))))?>'s Photo</span>
                <?endif?>
                <div class="interaction-group">
                <a href="<?=site_url("posts/post/$photo->slug")?>#ski-lift" class="fancy">
                  <?= $this->comment->get_number_of_comments_for_post($photo->id);?> <?= ($this->comment->get_number_of_comments_for_post($photo->id) == 1)? 'Comment': 'Comments'?>
                </a>
                <span class="post-slug" style="display:none;"><?=$photo->slug?></span>
                <?if($this->post->has_user_liked($this->session->userdata("id"),$photo->id)):?>
                
                <a href="<?= site_url('posts/unlike_post').'/'.$photo->slug?>" class="fancy green like"  username="<?=$this->session->userdata("username")?>" poster-username="<?=$this->user->get_username_by_id($photo->user_id)?>" like="unlike"><span data-tooltip="Unlike Post" class="like-data-tooltip"><span class="num-likes"><?=$this->post->get_number_of_likes_for_post($photo->id)?></span> <?=($this->post->get_number_of_likes_for_post($photo->id) == 1)? 'Like' : 'Likes'?></span></a>
                 <?else:?>
                 <a href="<?= site_url('posts/like_post').'/'.$photo->slug?>" class="fancy like"  username="<?=$this->session->userdata("username")?>" poster-username="<?=$this->user->get_username_by_id($photo->user_id)?>" like="like"><span data-tooltip="Like Post" class="like-data-tooltip"><span class="num-likes"><?=$this->post->get_number_of_likes_for_post($photo->id)?></span> <?=($this->post->get_number_of_likes_for_post($photo->id) == 1)? 'Like' : 'Likes'?></span></a>
                 <?endif?>
                <a href="<?= site_url('posts/post').'/'.$photo->slug?>" class="fancy">View</a>
                <?if($photo->post_type==4):?>
                <?$photo_slug = $this->post->get_slug_by_id($photo->photo_id)?>
                <a href="<?= site_url('posts/post').'/'.$photo_slug?>" class="fancy">View Photo</a>
                <?endif?>

                <?if($photo->post_type==4):?>
                <span class="critique-photo-rating"><?=($photo->user_id == $this->session->userdata('id')) ? 'You' : implode(' ',$this->user->get_full_name_by_id($photo->user_id))?> rated this photo <?=$photo->rating/2?>/5</span>
                <?endif?>
                </div>
                </header>
                <div class="cf"></div>
                    <?if($photo->post_type ==1):?>

                    <?
                    if($photo->file_name){
                      $object->filename = $photo->file_name;
                      $stacks =  array($object);
                    }
                    else{
                      $stacks = $this->post->get_stack_photos($photo->id);
                    }
                    ?>
                    
                    
                    
                    
                    <?if(count($stacks) == 1):?>
                      <? if ($this->user->has_blocked_downloading($photo->user_id)): ?>
                        <a href="<?= site_url("posts/viewer/$photo->slug") ?>" class="dl-prev-wrap" target="_blank">
                          <div class="dl-prev-wrap">
                            <img src="http://shutttr.s3.amazonaws.com/photo_uploads_medium/<?= $stacks[0]->filename ?>">
                            <div class="dl-prev"></div>
                          </div>
                        </a>
                      <? else: ?>
                        <a href="<?= site_url("posts/viewer/$photo->slug") ?>" target="_blank">
                          <img src="http://shutttr.s3.amazonaws.com/photo_uploads_medium/<?= $stacks[0]->filename ?>">
                        </a>
                      <? endif ?>
                      <?else:?>
                      <?for($i=0;$i<count($stacks)and $i<4;$i++):?>
                      <?$stack = $stacks[$i] ?>
                        <div class="roll_photo">
                         <a href="<?=site_url("posts/viewer/$photo->slug")?>" target="_blank"> <img src="http://shutttr.s3.amazonaws.com/photo_uploads_medium/<?= $stacks[$i]->filename ?>"></a>
                        </div>
                      <?endfor?>

                      <?if(count($stacks)>4):?>
                        <?=count($stacks) - 4?> photos
                      <?endif?>
                      <?endif?>
                    <?endif?>
                    <div class="cf"></div>
                   <?if($photo->post_type==4):?>
                   
                   <img src="http://shutttr.s3.amazonaws.com/photo_uploads_medium/<?=$this->post->get_photo_by_id($photo->photo_id)?>" style="max-width:200px">
                   <?endif?>
                    <p><?= $photo->description ?> <br></p>
                    
                    
                </article>
                <?endif?>
            <? endforeach ?> 
            <div id="prev-next" class="group">
            <?if($cur_page !=1):?>
            <a class="left" href="<?=site_url("$stream")."/".($cur_page-1)?>">Prev</a>
            <?endif?>
            
            <?if($cur_page != $num_pages and $num_pages > 1):?>
            
            <a class="right" href="<?=site_url("$stream")."/".($cur_page+1)?>">Next</a>
            <?endif?>
            
            </div>
            </div>
            <?else:?>
             <h1>This stream seems to have no posts yet :/</h1>
             <?endif?>
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
               <div id="tags">
               <h3>Popular Tags</h3>
               <p>
               
               <?foreach($popular_tags as $tag):?>
                    <? /*put the tag into an ok url */$tag_url =''; $tag_url = implode('-', explode(' ', $tag['tag']));?>
                    <a href="<?= site_url('posts/tagged_with').'/'.$tag_url?>"><?= $tag['tag'] ?></a>
                
                <?endforeach?>
                </p>
                </div>
                <!--<div id="categories">
                    <h3>Categories</h3>
                    <p>
                        <ul>
                            <li><a href="#">Category 1</a></li>
                            <li><a href="#">Category 2</a></li>
                            <li><a href="#">Category 3</a></li>
                            <li><a href="#">Category 4</a>
                                <ul>
                                    <li><a href="#">Sub-Category 1</a></li>
                                    <li><a href="#">Sub-Category 2</a></li>
                                    <li><a href="#">Sub-Category 3</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Category 5</a></li>
                            <li><a href="#">Category 6</a></li>
                        </ul>
                    </p>
                </div>-->
               <br> <div class="ad">
 <center><div class="adbg"><a href="http://adpacks.com" id="bsap_aplink">ADS VIA AD PACKS</a><div id="bsap_1270147" class="bsarocks bsap_eb58872ba13d97cbf39dce5c71fcb150"></div>
</div></div></center>
                </div>
            </div>
            
           
        
    	</div>
    
    	
