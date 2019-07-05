<?php 
$title = 'Jouez au jeux de la vie';
?>
<?php ob_start(); ?>
<script src="public/js/grid.js"></script>
<script src="public/js/main.js"></script>
<?php $head = ob_get_clean(); ?>

<?php ob_start(); ?>
<section class="last-section game grid">
	<?php
	if (!isset($gridManager))
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
	<?php
	if (isset($gridManager, $_SESSION['userid']) || isset($gridManager, $_SESSION['admin']))
	{
		if (!$gridIsLiked)
		{
		?>
			<button onclick='window.location.href="index.php?action=gridlike&id=<?= $_GET['id'] ?>"'><i class="fas fa-thumbs-up"></i> <?= $grid['likes'] ?></button>
		<?php
		}
		else
		{
		?>
			<p><i class="fas fa-thumbs-up"></i> <span><?= $grid['likes'] ?></span></p>	
		<?php
		}
		if (isset($_SESSION['admin']))
		{
		?>
			<button onclick='window.location.href="index.php?adminaction=griddelete&id=<?= $_GET['id'] ?>"'>Supprimer</button>
		<?php
		}
		?>
		<form action="index.php?action=addcomment&amp;id=<?= $_GET['id'] ?>" method="POST" class="comment-form">
			<label for="comment">Laissez un commentaire</label>
			<textarea name="comment-content" id="comment-content"></textarea>
			<input type="submit" value="Envoyer" class="btn">
		</form>
		<?php
		while ($data = $comments->fetch())
		{
			$commentAuthor = $userManager->getLoginById($data['author_id']);
			?>
			<div class="comment">
				<p><?= $commentAuthor ?> <em>le <?= $data['comment_date_fr'] ?></em></p>
				<p><?= $data['comment'] ?></p>
				<?php
				if (isset($_SESSION['userid']))
				{
					if($likeManager->commentIsLiked($data['id'], $_SESSION['userid']))
					{
						?>
						<p><i class="fas fa-thumbs-up" color="green"></i> <span> <?= $data['likes'] ?></span> <i class="fas fa-thumbs-down"></i> <span> <?= $data['dislikes'] ?></span></p>
						<?php
					}
					elseif($likeManager->commentIsDisliked($data['id'], $_SESSION['userid']))
					{
						?>
						<p><i class="fas fa-thumbs-up"></i> <span> <?= $data['likes'] ?></span> <i class="fas fa-thumbs-down" color="red"></i> <span> <?= $data['dislikes'] ?></span></p>
						<?php
					}
					else
					{
						?>
						<div>
							<button onclick='window.location.href="index.php?action=commentlike&id=<?= $data['id'] ?>"'><i class="fas fa-thumbs-up"></i> <span><?= $data['likes'] ?></span></button>
							<button onclick='window.location.href="index.php?action=commentdislike&id=<?= $data['id'] ?>"'><i class="fas fa-thumbs-down"></i> <span> <?= $data['dislikes'] ?></span></button>
						</div>
						<?php
					}
				}
				if (isset($_SESSION['admin']))
				{
				?>
					<button onclick='window.location.href="index.php?adminaction=commentdelete&id=<?= $data['id'] ?>"'>Supprimer</button>
				<?php
				}
				?>
			</div>
		<?php
		}
	}
		?>
</section>
<?= $script ?>
<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/clientTemplate.php'); ?>