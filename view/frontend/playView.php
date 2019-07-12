<?php 
$title = 'Jouez au jeux de la vie';
?>
<?php ob_start(); ?>
<script src="public/js/grid.js"></script>
<script src="public/js/main.js"></script>
<?php $head = ob_get_clean(); ?>

<?php ob_start(); ?>
<section class="game last-section">
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
			<button class="btn grid-delete-btn" onclick='window.location.href="index.php?adminaction=griddelete&id=<?= $_GET['id'] ?>"'>Supprimer</button>
		<?php
		}
	}
	?>
	<div class="canvas-container"><canvas id="canvas"></canvas></div>
	<div class="command grid">
		<div class="command-btn">
			<button title="Suivant" aria-label="Etape suivante" class="command-btn-item btn" id="next"><i class="fas fa-step-forward"></i></button>
			<button title="Play" aria-label="Lancer" class="command-btn-item btn" id="play"><i class="fas fa-play"></i></button>
			<button title="Pause" aria-label="Pause" class="command-btn-item btn" id="stop"><i class="fas fa-pause"></i></button>
		</div>
		<button title="Retoucher" aria-label="Gomme" class="command-btn-item btn" id="rubber"><i class="fas fa-eraser"></i></button>
		<div class="save-btn">
			<button title="Charger le motif" class="command-btn-item btn" id="load">Charger</button>
			<button title="Sauvegarder temporairement le motif" class="command-btn-item btn" id="save">Sauvegarder</button>
		</div>
		<div class="command-input">
			<div>
				<label for="cols">Colonnes</label>
				<input type="text" class="command-input-item" name="cols" id="cols" value="20">
			</div>
			<div>
				<label for="rows">Lignes</label>
				<input type="text" class="command-input-item" name="rows" id="rows" value="20">
			</div>
			<div>
				<label for="square-size">Taille d'un carré</label>
				<input type="text" class="command-input-item" name="square-size" id="square-size" value="20">
			</div>
			<button title="Réinitialiser la grille" class="btn" id="set-grid">Afficher la grille</button>
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
			<form class="saving-form" action="index.php?action=save" method="POST">
				<label for="name">Nom de l'oeuvre</label>
				<input type="text" name="name" id="name" maxlength="30" required>
				<textarea name="grid-json" id="grid-json" required></textarea>
				<input title="Enregistrer votre oeuvre sur le site" type="submit" class="btn" value="Enregistrer" id="save-db"/>
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
			?>
				<div class="comment-btns">
				<?php
				if($likeManager->commentIsLiked($data['id'], $_SESSION['userid']))
				{
				?>
					<div><i class="fas fa-thumbs-up blue"></i> <span class="blue"> <?= $data['likes'] ?></span> <i class="fas fa-thumbs-down"></i> <span> <?= $data['dislikes'] ?></span></div>
				<?php
				}
				elseif($likeManager->commentIsDisliked($data['id'], $_SESSION['userid']))
				{
				?>
					<div><i class="fas fa-thumbs-up"></i> <span> <?= $data['likes'] ?></span> <i class="fas fa-thumbs-down red"></i> <span class="red"> <?= $data['dislikes'] ?></span></div>
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
				if (isset($_SESSION['admin']))
				{
				?>
					<button class="btn comment-delete-btn" onclick='window.location.href="index.php?adminaction=commentdelete&id=<?= $data['id'] ?>"'>Supprimer</button>
				<?php
				}
			}
			?>
			</div>
		</div>
	<?php
	}
	?>
</section>
<?php
}
?>
<script>
	save = <?= $grid['json'] ?>;

	let maxX = 0;
	let maxY = 0;

	for (let coord of save)
	{
		if (coord[0] > maxX)
		{
			maxX = coord[0];
		}
		if (coord[1] > maxY)
		{
			maxY = coord[1];
		}
	}

	setTimeout(function(){
		grid.grid(20, maxX + 7, maxY + 7);
		grid.load(save);
	},100);
</script>
<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/clientTemplate.php'); ?>