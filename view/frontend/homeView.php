<?php 
$title = 'Inscription';
$head = '';
?>
<?php ob_start(); ?>
<section>
	<h1>Bienvenu</h1>
</section>
<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/clientTemplate.php'); ?>