<h1>User Admin Table</h1>
<table border="1">
  <tbody>
    <tr>
	  	<td>Name:</td>
      <td>Username:</td>
      <td>Email:</td>
      <td>Info:</td>
      <td>Guidelines Views:</td>
	  	<td>Options:</td>
      <td>Rank:</td>
    </tr>
    <? foreach ($users as $user): ?>
      <tr>
    		<td><?= $user["user"]->first_name ?> <?= $user["user"]->last_name ?> </td>
        <td><?= $user["user"]->username ?></td>
  	    <td><?= $user["user"]->email ?></td>
				<td>
					<a href="<?= site_url("people/" . $user["user"]->username)?>/posts")>Posts</a> /
				 	<a href="<?= site_url("people/" . $user["user"]->username)?>/comments")>Comments</a> /  
					<a href="<?= site_url("people/" . $user["user"]->username)?>/critiques")>Critiques</a>
				</td>
        <td>
          <?= $this->user->guideline_views($user["user"]->id)->guideline_views ?>
        </td>
  	    <td>
    	  <a href="<?= site_url("admin/edit_user/" . $user["user"]->username); ?>">Options</a> 
    	    
  	    </td>
        <td>
        <div id="admin_groups">
					<? if ($user["user"]->group_id == '4'): ?>User <? elseif ($user["user"]->group_id == '3'): ?>Ninja <? endif ?>	<? if ($user["user"]->group_id == '2'): ?>Moderator <? elseif ($user["user"]->group_id == '1'): ?>Admin <? endif ?>
          </div>
				</td>	
      </tr>
	  <? endforeach ?>
  </tbody>
</table>
