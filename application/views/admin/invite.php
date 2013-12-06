<table border="1">
<center><h1>There are <?= $total_signups?> total sign ups<!--, <?= $total_closed_testing ?> are going to particpate in closed testing!--></h1></center><br>
  <tbody>
    <tr>
  	  <td>Name: </td>
      <td>Username: </td>
      <td>Email: </td>
  	  <td>Link to work: </td>
			<td>Twitter: </td>
  	  <td>Accept or Deny? </td>
    </tr>
    <? foreach ($waiting_list as $user): ?>
      <tr>
    	<td><?= $user->first_name . ' ' . $user->last_name ?></td>
        <td><?= $user->username ?></td>
  	    <td><?= $user->email ?></td>
		    <td><a href="<?= $user->link_to_work ?>"><?= $user->link_to_work ?></a></td>
		 		<td><a href="http://twitter.com/#!/<?= $user->twitter ?>"><?= $user->twitter ?></a></td>
  	    <td>
  	      <a href="<?= site_url("admin/invite/" . $user->username); ?>">Invite</a> /
  	      <a href="<?= site_url("admin/deny_invite/" . $user->username) ?>">Deny</a>
  	    </td>
      </tr>
	  <? endforeach ?>
  </tbody>
</table>
<?= $this->pagination->create_links() ?>