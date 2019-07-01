<?php 
$title = 'Admirez les créations';
$head = '';
?>

<?php ob_start(); ?>
<section>
<?php
while ($data = $grids->fetch())
{
?>
	<p><a href="index.php?action=load&amp;id=<?= $data['id'] ?>"><?= $data['name'] ?> de : <?= $data['author'] ?></a></p>  
<?php
}
?>
</section>
<?php
$grids->closeCursor();
$content = ob_get_clean(); 
?>

<?php require('view/frontend/clientTemplate.php'); ?>