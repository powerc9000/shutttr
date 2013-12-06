<br />
<div id="container">
  <div id="content" class="directory">
    <? $even = false ?>
    <? foreach ($users as $user): ?>
      <? $email = md5(strtolower(trim($user['user']->email)));
       $size = 200;
       $url = "http://www.gravatar.com/avatar/$email?size=$size&d=http://wwww.shutttr.com/assets/images/default.png"
       ?>
     
        <a href="<?= site_url("people/" . $user["user"]->username) ?>"
           class="<? if ($even) echo "even"; else echo "odd" ?> user"> 
           <img src="<?=$this->user->avatar($user['user']->username, 200)?>">
          <div>
            <span data-tooltip="<?= $user["user"]->username ?>"> 
              <?= $user["user"]->first_name ?> <?= $user["user"]->last_name ?> 
            </span>
            <? if ($this->user->is_admin($user["user"]->username) | $user["user"]->type == 2 ): ?>
              (staff)
            <? endif ?>
						
            
           
            
            is a <?= $user["type"] ?>
          </div> 
          
        </a>
        <? $even = !$even ?>
        
    <? endforeach ?>
    <? if ($cur_page > 1): ?>
      <a id="dir-prev" href="<?= site_url("people/page/" . ($cur_page - 1)) ?>">&larr;</a>
    <? endif ?>
    
    <?if($cur_page != $num_pages and $num_pages > 1):?>
      <a id="dir-next" href="<?= site_url("people/page/" . ($cur_page + 1)) ?>">&rarr;</a>
    <? endif ?>
  </div>
</div>
