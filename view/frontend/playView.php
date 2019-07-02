<?php 
$title = 'Jouez au jeux de la vie';
?>
<?php ob_start(); ?>
<script src="public/js/grid.js"></script>
<script src="public/js/main.js"></script>
<?php $head = ob_get_clean(); ?>

<?php ob_start(); ?>
<section>
	<?php
	if (!$gridManager)
	{
	?>
	<h1>A vous de jouer au Jeu de la Vie !</h1>
	<?php
	}
	else
	{
	$gridAuthor = $userManager->getLoginById($grid['author_id']);
	?>
	<h1><em><?= $grid['name'] ?></em> de <?= $gridAuthor ?></h1>
	<?php
	}
	?>
	<canvas id="canvas"></canvas>
	<?php
	if (isset($gridManager, $_SESSION['userid']))
	{
		if (!$isLiked)
		{
		?>
	<button onclick='window.location.href="index.php?action=gridlike&id=<?= $_GET['id'] ?>"'>like</button>
		<?php
		}
		?>
	<form action="index.php?action=addcomment&amp;id=<?= $_GET['id'] ?>" method="POST" class="comment-form">
		<label for="comment">Laissez un commentaire</label>
		<textarea name="comment-content" id="comment-content"></textarea>
		<input type="submit" value="Envoyer" class="btn">
	</form>
	<?php
	}
	while ($data = $comments->fetch())
	{
		$commentAuthor = $userManager->getLoginById($data['author_id']);
	?>
	<div class="comment">
		<p><?= $commentAuthor ?> <em>le <?= $data['comment_date_fr'] ?></em></p>
		<p><?= $data['comment'] ?></p>
		<?php
		if(isset($_SESSION['userid']))
		{
		?>
		<div>
			<button onclick='window.location.href="index.php?action=commentlike"'>like</button>
			<button onclick='window.location.href="index.php?action=commentdislike"'>dislike</button>
		</div>
		<?php
		}
		?>
	</div>
	<?php
	}
	?>
	<div class="grid-command">
		<button id="next">Suivant</button>
		<button id="set-grid">Afficher la grille</button>
		<button id="play">Lancer</button>
		<button id="stop">Arrêter</button>
		<button id="load">Charger</button>
		<button id="save">Sauvegarder</button>
		<?php if(isset($_SESSION['userid']) && !isset($_GET['id']))
		{
		?>
		<form action="index.php?action=save" method="POST">
			<label for="name">Le nom de l'oeuvre</label>
			<input type="text" name="name" id="name" required>
			<textarea name="grid-json" id="grid-json" required></textarea>
			<input type="submit" value="Enregistrer"/>
		</form>
		<button id="db-load" onclick='window.location.href="index.php?action=load&id=1"'>Charger depuis db</button>
		<?php
		}
		?>
		<label for="cols">Nombre de colonnes</label>
		<input type="text" name="cols" id="cols" value="20">
		<label for="rows">Nombre de lignes</label>
		<input type="text" name="rows" id="rows" value="20">
		<label for="square-size">Taille d'un carré</label>
		<input type="text" name="square-size" id="square-size" value="20">
		<label for="speed" min="0.5" max="50" step="0.5">Vitesse</label>
		<input type="range" name="speed" id="speed" min="0.5" max="50" value="1">
	</div>
</section>
<script><?= $script ?></script>
<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/clientTemplate.php'); ?>