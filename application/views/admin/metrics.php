<center><h1> Top Ten Commenters</h1></center>
<br>
<table>
	<tr>
		<td><h1>User Name</h1></td>
		<td><h1># of comments</h1></td>
	</tr>
<?foreach($commenters as $commenter):?>
	<tr>
		<td>
		<?=$this->user->get_username_by_id($commenter->user_id)?> 
		</td>
		<td>
		<?=$commenter->usercount?>
		</td>
	</tr>
<?endforeach?>
<? $month = date('F')?>
</table>
<br>
<h1>Likes Last Month: <?=$monthly_likes?></h1>
<br>
<h1>Comments Last Month: <?=$monthly_comments?></h1>
<br>
<h1>Posts Last Month: <?=$monthly_posts?></h1>
<br>
<h1>Likes Yesterday: <?=$daily_likes?></h1>
<br>
<h1>Comments Yesterday: <?=$daily_comments?></h1>
<br>
<h1>Posts Yesterday: <?=$daily_posts?></h1>