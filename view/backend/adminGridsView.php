<?php $title = 'Administration' ?>
<?php $head = ''; ?>
<?php ob_start(); ?>
<section class="grid last-section">
	<h1>Administration des créations</h1>
	<?php
	while($data = $grids->fetch())
	{
	?>
	<div>
		<p><?= $data['name'] ?> de <?= $userManager->getLoginById($data['author_id']) ?></p>
		<div>
			<a href="index.php?action=load&amp;id=<?= $data['id'] ?>">Voir</a>
			<button onclick='window.location.href="index.php?adminaction=griddelete&id=<?= $data['id']  ?>"'>Supprimer</button>
		</div>
	</div>
	<?php
	}
	?>
</section>
<?php $content = ob_get_clean(); ?>

<?php require('view/backend/adminTemplate.php'); ?>