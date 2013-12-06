<h1>Comment Flags</h1>
<table border>
<tr>
<td>Comment</td>
<td>comment Id</td>
<td>Post Link</td>
<td>Date</td>
<td>Flagee</td>
<td>Flagger</td>
<td>Action Taken</td>
<td>Delete Flag</td>
</tr>
<?if(!empty($comment_flags)):?>
<?foreach($comment_flags as $comment_flag):?>
<tr id="<?=$comment_flag['id']?>">
<td style="width:250px;">

<?=  $comment_flag['comment_body']?>
</td>
<td><?= $comment_flag['comment_id'] ?></td>
<td><a href="<?= site_url('posts/photo/'.$comment_flag['post_id']).'#comment-'.$comment_flag['comment_id'] ?>">click here</a></td>
<td><?= $comment_flag['timestamp'] ?>
<td><?= $this->user->get_username_by_id($comment_flag['flaggee'])?></td>
<td><?= $this->user->get_username_by_id($comment_flag['flagger'])?></td>
<td>
<a href="<?=site_url('admin/edit_user/').'/'.$this->user->get_username_by_id($comment_flag['flagger'])?>">Ban User</a>
 - <? if ($comment_flag['action_taken_id'] != '2'): ?><a href=" <?= site_url("admin/delete_comment/" . $comment_flag['comment_id']).'/2' ?>">Delete Comment</a><?else:?>Comment Deleted<?endif?> - Email User</td>

<td><a href="<?=site_url('admin/delete_comment_flag/').'/'.$comment_flag['id']?>" class="comment_flag">X</a></td></tr>
<?endforeach?>
<?else:?>
<h1>There are no flags at this moment in time kids so come back later</h1>
<?endif?>
</table>
<script type="text/javascript">
	$('document').ready(function(){
		$('.comment_flag').live('click',function()
        {
        	var id = $(this).parent().parent().attr('id');
        	var url = $(this).attr('href');
            var url2 = url + '/hi';
            var answer = confirm("Delete this flag?");
            if(answer)
            {
            	$('.loader-gif').css('display','block');
	            $.post(url2, '', function(response){
                            if(response == "hello!")
                            {
                            $('tr[id='+id+']').hide(1000,function(){
                            	$('tr[id='+id+']').remove();
                            });  
                            $('.loader-gif').fadeOut(1000);  
                            }
                            else
                            {
                                alert('something went wrong');
                                $('.loader-gif').fadeOut(1000);
                            }
                            
                        });
            }
            else
            {
                return false;
            }
            
            return false;
        });
	});
</script>