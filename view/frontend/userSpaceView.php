<?php 
$title = 'Votre atelier';
$head = '';
?>

<?php ob_start(); ?>
<section>
	<button class="btn" onclick='window.location.href="index.php?action=userlogout"'>Déconnexion</button>
	<h2>Vos oeuvres</h2>
<?php
while ($data = $grids->fetch())
{
?>
	<div>
		<p><?= $data['name'] ?></p>
		<a href="index.php?action=load&amp;id=<?= $data['id'] ?>">Voir</a>
		<button onclick='window.location.href="index.php?action=griddelete&id=<?= $data['id']?>"'>Supprimer</button>
	</div>
<?php
}
?>
</section>
<?php
$grids->closeCursor();
$content = ob_get_clean(); 
?>

<?php require('view/frontend/clientTemplate.php'); ?>