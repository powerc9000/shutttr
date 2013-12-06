
<script src="<?=site_url("assets/js/like.js")?>"></script>
<script>
  
  $("document").ready(function(){
    //show flag comment form
    $('#show-flag-form').click(function(){
      $('#flag-form').show();
      $('.overlay').show();
    });
    $('#form-close').click(function(){
      $('#flag-form').hide();
      $('.overlay').hide();
    });
    //flag comments
    $('#flag_comment').click(function(){
      var yes = confirm("flag this post?");
      if(yes)
      {
        var url = $('#flag_comment').attr('href');
        $.post(url);
        $(this).remove();
        return false;
      }
      else
      {
        return false;
      }
  });
  $('#delete_post').click(function(){
    var yes = confirm("Delete this post? There is no undelete. Once you click that it goes to post hell! Use this power wisely.");
    if(yes)
    {
      return true;
    }
    else
    {
      return false;
    }
  });
});
  </script>

    
    
<div id="contain">

<div id="post-contain">
<? $email = md5(strtolower(trim($user->email)));
 $size = 40;
 $url = "http://www.gravatar.com/avatar/$email?size=$size"
 ?>
<div class="option-group">
<?$username =$user->username; if($this->session->userdata('username') == $user->username | $this->user->is_admin($this->session->userdata('username'))):?> <a href="<?= site_url('posts/edit').'/'.$photo->id.'/'.$username?>" class="fancy  green">Edit Post</a>  <a href="<?= site_url('posts/delete').'/'.$photo->id.'/'.$username?>" id="delete_post" class="fancy">Delete</a>  <a href="<?= site_url('posts/close_post').'/'.$photo->id.'/'.$user->username?>" class="fancy">Close Post</a><?endif?>
<?if($this->user->is_admin($this->session->userdata('username'))):?>
<?if($photo->hidden == 0):?>
  <a href="<?= site_url('posts/hide_post').'/'.$photo->id?>" class="fancy">Hide Post</a>
<?else:?>
This Post is hidden <a href="<?= site_url('posts/unhide_post').'/'.$photo->id?>">Unhide it</a>
<?endif?>
<?endif?>

</div>
<header class="post-header">
 <div class="right">
                 
              <div class="right">

              <div class="user-img-small"><img src="<?=$this->user->avatar($this->user->get_username_by_id($photo->user_id),40)?>"></div></div>

               <a href="<?=site_url('people'). '/' . $this->user->get_username_by_id($photo->user_id) ?>">
                <?=($photo->user_id == $this->session->userdata('id')) ? 'You' : implode(' ',$this->user->get_full_name_by_id($photo->user_id))?>
               </a>
               posted a 
               <?=($photo->post_type == 1) ? 'photo' : (($photo->post_type ==2) ? 'question' : (($photo->post_type == 3) ? 'link' : 'critique')) ?>
               <br>
               <div class="right">
              <?if(!$this->user->does_a_follow_b($this->session->userdata('id'), $user->id)):?><a href="<?=site_url("people/follow/")."/".$this->user->get_username_by_id($photo->user_id)?>">Follow</a> <?else:?>
<a href="<?=site_url("people/unfollow/")."/".$this->user->get_username_by_id($photo->user_id)?>">Unfollow</a>
<?endif?><span class="post-time"><?= $this->post->relative_time(strtotime($photo->timestamp))?> 
               ago</spam>
               </div>
                </div>

<?if($photo->post_type != 3):?>


<h2 id="post-title"><?= ucfirst($photo->post_title) ?></h2>
<?else:?>
<h2 id="post-title" class="link-post"><a href="<?=$photo->link?>"><?= ucfirst($photo->post_title) ?></a></h2>
<h3 class="link-post-url"><a href="<?=$photo->link?>"><?=$photo->link?></a></h3>
<?endif?>
<div class="interaction-group">
<span class="post-slug" style="display:none;"><?=$photo->slug?></span>
 <? if ($has_liked): ?>
      <a href="<?= site_url('posts/unlike_post').'/'.$photo->slug?>" class="fancy green like"  username="<?=$this->session->userdata("username")?>" poster-username="<?=$username?>" like="unlike"><span data-tooltip="Unlike Post" class="like-data-tooltip"><span class="num-likes"><?=$this->post->get_number_of_likes_for_post($photo->id)?></span> Likes</span></a>
    <? else: ?>
      <a href="<?= site_url('posts/like_post').'/'.$photo->slug?>" class="fancy like"  username="<?=$this->session->userdata("username")?>" poster-username="<?=$username?>" like="like"><span data-tooltip="Like Post" class="like-data-tooltip"><span class="num-likes"><?=$this->post->get_number_of_likes_for_post($photo->id)?></span> Likes</span></a>
    <? endif ?>
    <?if($photo->post_type == 4):?>
      <? $photo_slug = $this->post->get_slug_by_id($photo->photo_id) ?>
      <a href="#critique" class="fancy">Rating <?= ($photo->rating)?$photo->rating/2:"-" ?>/5</a>
      <a href="<?= site_url('posts/post').'/'.$photo_slug ?>" class="fancy">View Photo</a>
    <?endif?>
    <a href="#" id="show-flag-form" class="fancy">Flag Post</a>
    </div>

   
                

  </header>
<div class="cf"> </div>
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
                        <a href="<?= site_url("posts/viewer/$slug") ?>" class="dl-prev-wrap" target="_blank">
                          <div class="dl-prev-wrap">
                            <img src="http://shutttr.s3.amazonaws.com/photo_uploads_medium/<?= $stacks[0]->filename ?>">
                            <div class="dl-prev"></div>
                          </div>
                        </a>
                      <? else: ?>
                        <a href="<?= site_url("posts/viewer/$slug") ?>" target="_blank">
                          <img src="http://shutttr.s3.amazonaws.com/photo_uploads_medium/<?= $stacks[0]->filename ?>">
                        </a>
                      <? endif ?>
                      <?else:?>
                      <?for($i=0;$i<count($stacks);$i++):?>
                      <?$stack = $stacks[$i] ?>
                        <div class="roll_photo">
                         <a href="<?=site_url("posts/viewer/$slug")?>" target="_blank"> <img src="http://shutttr.s3.amazonaws.com/photo_uploads_medium/<?= $stacks[$i]->filename ?>"></a>
                        </div>
                      <?endfor?>

                      <?if(count($stacks)>4):?>
                        <?=count($stacks) - 4?> photos
                      <?endif?>
                      <?endif?>
                    <?endif?>
<?if($photo->post_type == 4):?>
<div id="post-photo">
 <img src="http://shutttr.s3.amazonaws.com/photo_uploads_medium/<?=$this->post->get_photo_by_id($photo->photo_id)?>" style="max-width:200px">
 </div>
<?endif?>

<div class="cf"></div>

<div class="photo-description"><?= $photo->description ?></div>
<?if($tags != ''): ?>
<h3>Tags</h3>
<? $size = sizeof($tags) -1?>
<div id="post-tags">
<?foreach($tags as $key =>$tag):?>
<? /*put the tag into an ok url */$tag_url =''; $tag_url = implode('-', explode(' ', $tag['tag']));?>

<a href="<?= site_url('posts/tagged_with').'/'.$tag_url?>" class="tag"><?= $tag['tag']?></a>
<?endforeach?>
</div>
<?endif?>
<? if ($photo->user_id == $this->session->userdata("id")): ?>
 <br>
<? endif ?>



  <div id="flag-form">
  <div class="right"><a href="#" id="form-close"><span data-tooltip="close">X</span></a></div>
  <p>Flag Post</p>
  <?= form_open("posts/flag_photo") ?>
    <?= form_hidden("post_type", "photo") ?>
    <?= form_hidden("id", $photo->id) ?>
  	<?= form_hidden("flaggee_id", $photo->user_id) ?>
    <select name="reason_id">
      <option value="1">Pornography</option>
      <option value="2">Doesn't belong on shutttr</option>
      <option value="3">Inapropriate</option>
      <option value="4">Copyrighted Material</option>
    </select>
    <?= form_submit("submitted", "flag") ?>
  <?= form_close() ?>
  </div>
<?if($photo->post_type == 1):?>
<section>
  <h1>Critiques - <?if($this->session->userdata('can_critique') != 1 or time() > $this->session->userdata('unblocked_time')): ?>
<a href="<?= site_url("new/critique/$slug") ?>" target="_blank" class="fancy" id="critique">Write a critique</a><br />
<?else:?>
<h1>You are blocked from writing critiques </h1>
<?endif?>
</h1>

  <ul>

    <? foreach ($critiques as $critique): ?>
      <li>
        <a href="<?=site_url('people'). '/' . $this->user->get_username_by_id($photo->user_id) ?>">
                <?=($critique["critique"]->user_id == $this->session->userdata('id')) ? 'You' : implode(' ',$this->user->get_full_name_by_id($critique["critique"]->user_id))?>
        </a>
        gave this photo
        <a href="<?= site_url("posts/post/" . $critique["critique"]->slug) ?>">
<?= $critique["critique"]->rating ?>
        stars.</a>
      </li>
    <? endforeach ?>
  </ul>
</section>
<?endif?>

<div id="sidebar">
  <div id="new-post">
    <a href="<?=site_url('create')?>">New Post +</a>
  </div>
 <div class="ad">
    <!-- BuySellAds.com Ad Code -->
<br> <div class="ad">
 <center><div class="adbg"><a href="http://adpacks.com" id="bsap_aplink">ADS VIA AD PACKS</a><div id="bsap_1270147" class="bsarocks bsap_eb58872ba13d97cbf39dce5c71fcb150"></div>
</div></div></center>
<!-- End BuySellAds.com Ad Code -->

 

</div>
</div>
</div>
<!-- Comment section goes here -->
<div class="left" id="comment-box">
<h2>Comments</h2>
<hr>
<ul style="list-style:none" id="comments1234">

  <? foreach ($comments as $comment): ?>
    <li id="comment-<?=$comment['comment_id']?>" class="comment">
    <? $email = md5(strtolower(trim($comment['user']->email)));
 $size = 40;
 $url = "http://www.gravatar.com/avatar/$email?size=$size"
 ?>
      <div class="left"><div class="user-img-small"><img src="<?=$this->user->avatar($comment['user']->username, 40)?>" width="40px"></div></div>
      <h2 class="commenter"><span data-tooltip="<?= $comment["user"]->first_name ?> <?= $comment["user"]->last_name ?>">
      <?$username = $comment['user']->username?>

        <a href="<?=site_url("people/$username") ?>"><?= $comment["user"]->username ?></a></span>
        <?if($comment["user"]->group_id==1 | $comment["user"]->group_id == 2):?><span class="badge staff">Staff</span><?endif?><? if ($comment["user"]->p_rank >= 95 && $comment["user"]->group_id != 1): ?><span class="badge pro">Awesome Contributor</span><? endif ?>

      </span> said:</h2>
				<p class="comment-body">
        <?= parse_markdown(auto_link($comment["body"])) ?>
      </p>
     <span class="comment-time"><?= $this->post->relative_time(strtotime($comment['timestamp']))?> ago</span>   &#149;
      <?if($this->session->userdata('id') != $comment["user"]->id):?>
      <?if(! $this->comment_flags->has_user_flagged_comment($this->session->userdata('id'),$comment['comment_id'])):?>
      <?$userid= $this->session->userdata('id');?>
      <a href="<?= site_url("comments/flag_comment/").'/'.$userid.'/'.$comment['comment_id'].'/'.$photo->slug.'/'.$comment["user"]->id?>" id="flag_comment">Flag comment</a>

      <?endif?>
      <?else:?>
      <a href="<?= site_url("admin/delete_comment/").'/'.$comment['comment_id']?>" class="delete-comment">Delete Comment</a>
      <?endif?>
      &bull;
      <?$comment_id = $comment['comment_id'] ?>
      <?if(!$this->comment->is_liked($comment_id, $this->session->userdata("id"))):?>
      <a href="<?= site_url("comments/like_comment/$comment_id")?>" class="c-like"><span data-tooltip="Like Comment"><?=$this->comment->number_likes($comment_id)?> <?=($this->comment->number_likes($comment_id)==1)?"Like":"Likes"?></span></a>
      <?else:?>
      <a href="<?= site_url("comments/unlike_comment/$comment_id")?>" class="c-like"><span data-tooltip="Unlike Comment"> <?=$this->comment->number_likes($comment_id)?> <?=($this->comment->number_likes($comment_id)==1)?"Like":"Likes"?></span></a>
      <?endif?>
      
    &bull; <a href="#" class="reply-button" data-username="<?=  $comment["user"]->username ?>">Reply</a></li>
  <? endforeach ?>
  
</ul>
<? $email = md5(strtolower(trim($this->session->userdata['email'])));
 $size = 40;
 $url = "http://www.gravatar.com/avatar/$email?size=$size"
 ?>
      <span id="myemail" email="<?=$this->user->avatar($this->session->userdata("username"), 40)?>"></span>
<? if($photo->closed == 0):?>

<?if($this->session->userdata('can_comment') != 1 or time() > $this->session->userdata('unblocked_time')): ?>
<h1 id="ski-lift">Leave a Comment (Use @username to mention someone)</h1>
<? if ($comment_errors): ?>
  <div class="error">
    <?= $comment_errors ?>
  </div>
<? endif ?>
<?= form_open("comments/add_photo") ?>
<input type="hidden" name="photo_id" value="<?=$photo->id?>" id="post_id">
  <input type="hidden" name="url" value="<?= site_url("posts/$photo->slug")?>" id="post_url">
  
  
  <p>
    <div id="comment-form">
    <?= form_textarea(array('name'=>'body','id'=>'comment_body', 'rows' =>5)) ?>
  </p>
  <p>
  
    <?= form_submit(array('value'=>'Add Comment', 'id'=>'add_comment')) ?>
    <?else:?>
    <h1>You cannot comment</h1>
    <?endif?>
    <?else:?>
    <h1>This post is closed <?if($this->session->userdata('username') == $user->username | $this->user->is_admin($this->session->userdata('username')) && $photo->closed == 1):?><a href="<?= site_url('posts/open_post').'/'.$photo->id.'/'.$user->username?>">Open it</a><?endif?></h1>

    <?endif?>
    <?if($this->session->userdata('username') == $user->username | $this->user->is_admin($this->session->userdata('username')) && $photo->closed == 0):?>
    
    <?endif?>
  </p>
<?= form_close() ?>
</div>
</div>

<script>
 $("document").ready(function(){
    $('#add_comment').click(function(){
      var body = $('#comment_body').val();
      if(body === '' || body===' ')
      {
        alert('Put some text in there!');
        return false;
      }
      var user_email = $('#myemail').attr('email');
      var id = $('#post_id').val();
      var key = 'hello';
      var json = {'body' : body, 'photo_id' : id, 'key' : key};
      var url = "<?= site_url('comments/add_photo')?>";
      $('.loader-gif').css('display','block');
      $.post(url, json, function(response)
    {
      
      if(response)
      {
        
        $('#comment_body').val('');
        $("<li class=comment ><div class='left'><div class='user-img-small'><img src='"+user_email+"' width=\"40px\"></div></div><h2 class='commenter'><span data-tooltip='<?= $this->session->userdata('username') ?>'>You Said:</span></h2><p>"+ body +"</p><span class='comment-time'>Mere seconds ago</span> &#149; <a href='<?= site_url('admin/delete_comment/')?><?='/'?>"+ response +"' id='delete_comment'>Delete Comment</a></li>").appendTo('#comments1234');
        $('.loader-gif').fadeOut(500);
      }
    });
      return false;
    });
  });

$(function(){
var commentBox = $("#comment_body");

$(".reply-button").click(function() {

commentBox.focus().val("@"+$(this).attr("data-username")+" ");
return false;
	});
});

  </script>
  <div class="overlay"></div>
  <div class="cf"></div>
</div>
