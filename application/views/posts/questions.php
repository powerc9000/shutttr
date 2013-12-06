<div id="container">
  <div id="content">
    <div id="stream">
      <? foreach ($question as $question): ?>
        <? if (!$question->hidden): ?>
          <article>
            <h2><a href="<? site_url("posts/question/" . $question->slug) ?>">
              <?= $photo->photo_name ?>
            </a></h2>
            <p><?= $question->question ?></p>
          </article>
        <? endif ?>
      <? endforeach ?>

            <div id="prev-next" class="group">
            <a class="left" href="#">Prev</a>
            <a class="right" href="#">Next</a>
            </div>
            </div>
             
            
            <div id="sidebar">
            	<div id="new-post">
            		<a href="<?=site_url('create/photo')?>">New Post +</a>
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
            <!--	<div class="ad">
                	<p>Place ads here.</p>
                </div>-->
            </div>
        
    	</div>
    
    	
