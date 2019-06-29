<?php $title = 'Admirez les créations'; ?>
<?php ob_start(); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="public/js/grid.js"></script>
<script src="public/js/main.js"></script>
<?php $head = ob_get_clean(); ?>

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
<script><?= $script ?></script>
<?php
$grids->closeCursor();
$content = ob_get_clean(); 
?>

<?php require('view/frontend/clientTemplate.php'); ?>