<?foreach($challenges as $c):?>
<a href="<?=site_url()?>challenges/challenge/<?=$c->id?>"><?=$c->title?></a><br>
<?endforeach?>