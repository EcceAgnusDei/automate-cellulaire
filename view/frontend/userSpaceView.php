<?php 
$title = 'Votre atelier';
?>
<?php ob_start(); ?>
<script src="public/js/grid.js"></script>
<script src="public/js/showMiniature.js"></script>
<?php $head = ob_get_clean(); ?>

<?php ob_start(); ?>
<nav class="grid">
	<ul class="userspace-nav">
		<li><button id="show-artwork" class="link-btn">Vos oeuvres</button></li>
		<li><button id="show-comments" class="link-btn">Vos commentaires</button></li>
		<li><button class="btn" onclick='window.location.href="index.php?action=userlogout"'>Déconnexion</button></li>
	</ul>
</nav>
<section class="user-artwork last-section grid">
	<h3>Vos oeuvres</h3>
	<div class="artwork-container">
<?php
while ($data = $grids->fetch())
{
?>
	<div class="artwork"><canvas id="canvas<?= $data['id'] ?>"></canvas>
		<p class="grids-title"><a href="creation-<?= $data['id'] ?>"><?= $data['name'] ?></a></p>
		<div class="blue"> <i class="fas fa-thumbs-up"></i> <?= $data['likes'] ?></div>
		<button class="btn" onclick='window.location.href="index.php?action=griddelete&id=<?= $data['id']?>"'>Supprimer</button>
	</div>
	<script>
		showMiniature (<?= $data['json'] ?>, "canvas<?= $data['id'] ?>");
	</script>	
<?php
}
?>
	</div>
</section>
<section class="user-comments last-section grid">
	<h3>Vos commentaires</h3>
<?php
	while ($data = $comments->fetch())
	{
		$commentAuthor = $userManager->getLoginById($data['author_id']);
		?>
		<div class="comment">
			<p><strong class="orange"><?= $commentAuthor ?></strong> <em>le <?= $data['comment_date_fr'] ?></em> : </p>
			<p><?= nl2br($data['comment']) ?></p>
			<div class="comment-btns">
				<div>
					<i class="fas fa-thumbs-up blue"></i> <span class="blue"> <?= $data['likes'] ?></span> <i class="fas fa-thumbs-down red"></i> <span class="red"> <?= $data['dislikes'] ?></span>
				</div>
				<button class="btn comment-delete-btn" onclick='window.location.href="index.php?action=commentdelete&id=<?= $data['id'] ?>"'>Supprimer</button>
			</div>
		</div>
	<?php
	}
	?>
</section>
<?php
$grids->closeCursor();
$content = ob_get_clean();
$userspace = '';
$metaDescription = "Vous avez accès ici à votre espace personnel de manière à pouvoir gérer vos créations et commentaires"; 
?>

<?php require('view/frontend/clientTemplate.php'); ?>