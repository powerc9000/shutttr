

<? if ($flags && count($flags)): ?>

  <? foreach($flags as $flag): ?>
  <?if($flag['post']->post_type == 1):?>
    <img src="http://shutttr.s3.amazonaws.com/photo_uploads/<?= $flag["post"]->file_name ?>" height="40%">
    <?endif?>
  <? endforeach ?>
<? endif ?>
<table border="1">
  <tr>
		<th>Poster</th>
		<th>Flagger</th>
    <!--<th>Post Type</th>
    <th>Post ID</th>-->
    <th>Post Title</th>
<? if ($flags && count($flags)): ?>
  <? foreach($flags as $flag): ?>
  	<th>Link</th><? endforeach ?><? endif ?>
    <th>Reason</th>
		<th>Actions</th>
  </tr>
  <? if ($flags && count($flags)): ?>
    <? foreach ($flags as $flag): ?>
      <tr <?php if ($flag["flag"]->action_taken_id == 1) { echo 'class="blocked-flag"'; } 
			if ($flag["flag"]->action_taken_id == 2) { echo 'class="hidden_post-flag"'; } ?>>
				<td>
				<?= $flag["flaggee"]->first_name ." ". $flag["flaggee"]->last_name  ?>
				</td>
				<td>
				<?= $flag["flagger"]->first_name ." ". $flag["flagger"]->last_name  ?>
				</td>
        <!--<td>
          <? if ($flag["flag"]->post_type == 1): ?>
            Photo
          <? else: ?>
            Critique
          <? endif ?>
        </td>
        <!--<td><?= $flag["flag"]->post_id ?></td>-->
        <td>
          <? if ($flag["flag"]->post_type == 1): ?>
            <?= $flag["post"]->post_title ?>
          <? else: ?>
            <?= $flag["post"]->name ?>
          <? endif ?>
        </td>
        <td>
            <a href="<?= site_url("posts/post/" . $flag["post"]->slug) ?>">Post link</a>
        </td>
				
        <td><?= $flag["reason"] ?></td>
  			<td><?if ($flag["flag"]->action_taken_id !== 0 ): ?>
  			<? if ($flag["flaggee"]->blocked == 1 ): ?>
  				 <!--<a href="<?= site_url("admin/unblock/" . $flag["flaggee"]->username . "/" .
  			                        base64_encode("admin/posts_flags")) ?>">
  			    Unban User</a>--> User Banned |
  				<? else: ?>
  			  <a href="<?= site_url("admin/block/" . $flag["flaggee"]->username . "/" .
  			                        base64_encode("admin/posts_flags")) . "/" . $flag["flag"]->post_id ?>">
  			    Ban User</a> |
  			<? endif ?>
				<a href="mailto:<?= $flag["flaggee"]->email ?>">Email User</a> |
			 <?= secure_link("Hide Post", 
                site_url("admin/hide_photo/" . $flag["flag"]->post_id . "/" . base64_encode("admin/posts_flags"))) ?>
			<? else: ?>Action already taken!
				<? endif ?>
  			</td>
      </tr>
    <? endforeach ?>
  <? endif ?>
</table>
<br>
Actions Taken:<br>
Red - User Blocked<br>
Blue - Post Hidden<br>
Green - User Emailed