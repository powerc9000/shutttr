<div id="edit-post-container">
<div class="edit-post-form">
<? if (isset($errors)): ?>
  <?= $errors ?>
<? endif ?>
<h1 class="edit-post-header">Edit Post</h1>
<?if($info->post_type ==1):?>
 <?
                    if($info->file_name){
                      $object->filename = $info->file_name;
                      $stacks =  array($object);
                    }
                    else{
                      $stacks = $this->post->get_stack_photos($info->id);
                    }
                    ?>
 <?foreach($stacks as $stack):?>
  <img src="http://shutttr.s3.amazonaws.com/photo_uploads_medium/<?= $stack->filename ?>" style="max-width: 45%;
display: inline;
text-align: center;">
  <?endforeach?>
<?endif?>
<?= form_open(site_url('posts/save_edit').'/'.$username.'/'.$info->id.'/'.$info->slug)?>
<div class="new-post-title">
<label for="title">Title <span class="more-info">Requred, Be specific.</span></label>
<?= form_input(array('value'=>$info->post_title,'name'=>'title', 'id'=>"title")) ?></div>
<div class="new-post-description">
<label for="desc">Description <span class="more-info">Required, The more info you give the more you get back.</span></label>
<?= form_textarea(array('value'=>$info->description, 'name'=>'description'))?></div>
<? $t='';if($tags !=''):?>
<? foreach($tags as $tag)
{
	$t .= $tag['tag'].', ';
}
?>

<?endif?>
<div class="new-post-tags">
<label for="new-tags">Tags <span class="more-info">Seprate each tag with a comma.</span></label>
<?= form_textarea(array('name'=>'tags', 'value'=>$t, 'rows'=>'2', 'id' => 'new-tags'));?>
</div>
<div class="new-post-form-submit">
<?= form_submit('submit','Save Post')?>
</div>
<?= form_close() ?>
</div>
</div>