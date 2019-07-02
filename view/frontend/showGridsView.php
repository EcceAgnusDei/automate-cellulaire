<?php 
$title = 'Admirez les créations';
$head = '';
?>

<?php ob_start(); ?>
<section>
<?php
while ($data = $grids->fetch())
{
	$author = $userManager->getLoginById($data['author_id']);
?>
	<p><a href="index.php?action=load&amp;id=<?= $data['id'] ?>"><?= $data['name'] ?> de <?= $author?></a></p>  
<?php
}
?>
</section>
<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/clientTemplate.php'); ?>