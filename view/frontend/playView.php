<?php 
$title = 'Jouez au jeux de la vie';
?>
<?php ob_start(); ?>
<script src="public/js/grid.js"></script>
<script src="public/js/main.js"></script>
<?php $head = ob_get_clean(); ?>

<?php ob_start(); ?>
<section class="game grid last-section">
	<?php
	if (!isset($gridManager))
	{
	?>
		<h3>A vous de jouer au Jeu de la Vie !</h3>
	<?php
	}
	else
	{
		$gridAuthor = $userManager->getLoginById($grid['author_id']);
	?>
		<h3><em><?= $grid['name'] ?></em> de <?= $gridAuthor ?></h3>
	<?php
	}
	if(isset($gridManager))
	{
		if (!$gridIsLiked)
		{
		?>
			<button onclick='window.location.href="index.php?action=gridlike&id=<?= $_GET['id'] ?>"' class="like-btn grid-like-btn"><i class="fas fa-thumbs-up"></i> <?= $grid['likes'] ?></button>
		<?php
		}
		else
		{
		?>
			<p class="blue"><i class="fas fa-thumbs-up"></i> <span><?= $grid['likes'] ?></span></p>	
		<?php
		}
		if (isset($_SESSION['admin']))
		{
		?>
			<button class="btn" onclick='window.location.href="index.php?adminaction=griddelete&id=<?= $_GET['id'] ?>"'>Supprimer</button>
		<?php
		}
	}
	?>
	<canvas id="canvas"></canvas>
	<div class="command">
		<div class="command-btn">
			<button class="command-btn-item btn" id="next"><i class="fas fa-step-forward"></i></button>
			<button class="command-btn-item btn" id="play"><i class="fas fa-play"></i></button>
			<button class="command-btn-item btn" id="stop"><i class="fas fa-pause"></i></button>
		</div>
		<div class="save-btn">
			<button class="command-btn-item btn" id="load">Charger</button>
			<button class="command-btn-item btn" id="save">Sauvegarder</button>
		</div>
		<div class="command-input">
			<label for="cols">Colonnes</label>
			<input type="text" class="command-input-item" name="cols" id="cols" value="20">
			<label for="rows">Lignes</label>
			<input type="text" class="command-input-item" name="rows" id="rows" value="20">
			<label for="square-size">Taille d'un carré</label>
			<input type="text" class="command-input-item" name="square-size" id="square-size" value="20">
			<button class="btn" id="set-grid">Afficher la grille</button>
		</div>
		<div class="speed-selector">
			<label for="speed" min="0.5" max="50" step="0.5">Vitesse</label>
			<input type="range" name="speed" id="speed" min="0.5" max="50" value="1">
		</div>
	</div>
	<?php 
		if(isset($_SESSION['userid']) && !isset($_GET['id']))
		{
		?>
			<form action="index.php?action=save" method="POST">
				<label for="name">Nom de l'oeuvre</label>
				<input type="text" name="name" id="name" maxlength="30" required>
				<textarea name="grid-json" id="grid-json" required></textarea>
				<input type="submit" class="btn" value="Enregistrer" id="save-db"/>
			</form>
		<?php
		}
		?>
</section>
<?php
if (isset($gridManager, $_SESSION['userid']))
{
?>
<section class="comment-section grid last-section">
	<h3 class="comments-title">Commentaires (<?= $nbComments ?>)</h3>
	<form action="index.php?action=addcomment&amp;id=<?= $_GET['id'] ?>" method="POST" class="comment-form">
		<label for="comment">Laissez un commentaire</label>
		<textarea name="comment-content" id="comment-content" required></textarea>
		<input type="submit" value="Envoyer" class="btn">
	</form>
	<?php
	while ($data = $comments->fetch())
	{
		$commentAuthor = $userManager->getLoginById($data['author_id']);
		?>
		<script>console.log("coucou");</script>
		<div class="comment">
			<p><strong class="orange"><?= $commentAuthor ?></strong> <em>le <?= $data['comment_date_fr'] ?></em> : </p>
			<p><?= nl2br($data['comment']) ?></p>
			<?php
			if (isset($_SESSION['userid']))
			{
				if($likeManager->commentIsLiked($data['id'], $_SESSION['userid']))
				{
					?>
					<p><i class="fas fa-thumbs-up blue"></i> <span class="blue"> <?= $data['likes'] ?></span> <i class="fas fa-thumbs-down"></i> <span> <?= $data['dislikes'] ?></span></p>
					<?php
				}
				elseif($likeManager->commentIsDisliked($data['id'], $_SESSION['userid']))
				{
					?>
					<p><i class="fas fa-thumbs-up"></i> <span> <?= $data['likes'] ?></span> <i class="fas fa-thumbs-down red"></i> <span class="red"> <?= $data['dislikes'] ?></span></p>
					<?php
				}
				else
				{
					?>
					<div>
						<button class="like-btn" onclick='window.location.href="index.php?action=commentlike&id=<?= $data['id'] ?>"'><i class="fas fa-thumbs-up"></i> <span><?= $data['likes'] ?></span></button>
						<button class="dislike-btn" onclick='window.location.href="index.php?action=commentdislike&id=<?= $data['id'] ?>"'><i class="fas fa-thumbs-down"></i> <span> <?= $data['dislikes'] ?></span></button>
					</div>
					<?php
				}
			}
			if (isset($_SESSION['admin']))
			{
			?>
				<button class="btn" onclick='window.location.href="index.php?adminaction=commentdelete&id=<?= $data['id'] ?>"'>Supprimer</button>
			<?php
			}
			?>
		</div>
	<?php
	}
	?>
</section>
<?php
}
?>
<?= $script ?>
<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/clientTemplate.php'); ?>