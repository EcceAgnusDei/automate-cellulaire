<?php 
$title = 'Admirez les créations';
$head = '';
?>

<?php ob_start(); ?>
<section>
	<nav class="grid-sort">
		<ul>
			<li><a href="index.php?action=showgrids" <?php if($_GET['action']=='showgrids'){echo "style= 'border-top: 1px solid #348ffe;'";} ?> >Trier par date <i class="fas fa-sort-down"></i></a></li>
			<li><a href="index.php?action=showgridsbylikes" <?php if($_GET['action']=='showgridsbylikes'){echo "style= 'border-top: 1px solid #348ffe;'";} ?> >Trier par popularité <i class="fas fa-sort-down"></i></a></li>
		</ul>
	</nav>
<?php
while ($data = $grids->fetch())
{
	$author = $userManager->getLoginById($data['author_id']);
?>
	<p><a href="index.php?action=load&amp;id=<?= $data['id'] ?>"><?= $data['name'] ?> de <?= $author?></a> <span><?= $data['likes'] ?></span></p>
<?php
}
?>
</section>
<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/clientTemplate.php'); ?>