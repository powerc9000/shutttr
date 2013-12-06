<center><h1>User Options</h1>
<?= $data['user']->first_name;?> <?= $data['user']->first_name;?> (<?= $data['user']->username;?>)<br>
  <div id="admin_groups">
Rank:
				<? if ($data["user"]->group_id == '4') {} else { ?><a href="<?= site_url("admin/change_group/" .$data["user"]->username . "/4" . "/" .  base64_encode("admin/user_panel"))?>")><? } ?>User</a> /
				<? if ($data["user"]->group_id == '3') {} else { ?><a href="<?= site_url("admin/change_group/" .$data["user"]->username . "/3" . "/" .  base64_encode("admin/user_panel"))?>")><? } ?>Ninja</a> /
				<? if ($data["user"]->group_id == '2') {} else { ?><a href="<?= site_url("admin/change_group/" .$data["user"]->username . "/2" . "/" .  				 base64_encode("admin/user_panel"))?>")><? } ?>Moderator</a> /
				<? if ($data["user"]->group_id == '1') {} else { ?><a href="<?= site_url("admin/change_group/" .$data["user"]->username . "/1" . "/" .  base64_encode("admin/user_panel"))?>")><? } ?>Admin</a>
				</div>
				<div>
				<p>Notice unblocking login will unblock everything</p>
				Blocked:</br>
				<? if($data['login_blocked'] == 1 and $data['unblocked_time'] > time()):?>
				Blocked Until: <?= date('F jS Y g:i A', $data['unblocked_time'])?> <a href="<?=site_url('admin/unblock_login').'/'.$data['user']->username?>">Unblock Login</a>
				<?else:?>Block Login for: 
				<a href="<?=site_url('admin/block_login').'/'.$data['user']->username.'/'.'86400'?>">day</a> /
				<a href="<?=site_url('admin/block_login').'/'.$data['user']->username.'/'.'604800'?>">week</a> /
				<a href="<?=site_url('admin/block_login').'/'.$data['user']->username.'/'.'2629743'?>">Month</a> /
				<a href="<?=site_url('admin/block_login').'/'.$data['user']->username.'/'.'5259487'?>">2 Months</a>
				<?endif?>
				<br>
				<? if($data['comment_blocked'] == 1 and $data['unblocked_time'] > time()):?>
				Blocked Until: <?= date('F jS Y g:i A', $data['unblocked_time'])?> <a href="<?=site_url('admin/unblock_comment').'/'.$data['user']->username?>">Unblock commenting</a>
				<?else:?>Block commenting for: 
				<a href="<?=site_url('admin/block_comment').'/'.$data['user']->username.'/'.'86400'?>">day</a> /
				<a href="<?=site_url('admin/block_comment').'/'.$data['user']->username.'/'.'604800'?>">week</a> /
				<a href="<?=site_url('admin/block_comment').'/'.$data['user']->username.'/'.'2629743'?>">Month</a> /
				<a href="<?=site_url('admin/block_comment').'/'.$data['user']->username.'/'.'5259487'?>">2 Months</a>
				<?endif?>
				<br>
				<? if($data['critique_blocked'] == 1 and $data['unblocked_time'] > time()):?>
				Blocked Until: <?= date('F jS Y g:i A', $data['unblocked_time'])?> <a href="<?=site_url('admin/unblock_critique').'/'.$data['user']->username?>">Unblock critiquing</a>
				<?else:?>Block critiquing for: 
				<a href="<?=site_url('admin/block_critique').'/'.$data['user']->username.'/'.'86400'?>">day</a> /
				<a href="<?=site_url('admin/block_critique').'/'.$data['user']->username.'/'.'604800'?>">week</a> /
				<a href="<?=site_url('admin/block_critique').'/'.$data['user']->username.'/'.'2629743'?>">Month</a> /
				<a href="<?=site_url('admin/block_critique').'/'.$data['user']->username.'/'.'5259487'?>">2 Months</a>
				<?endif?>
				</div>
</center>