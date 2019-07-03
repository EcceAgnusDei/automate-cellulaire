<?php $head = ''; ?>
<?php ob_start(); ?>
<section class="grid last-section">
	<h2>La liste des commentaires</h2>
	<nav class="comment-sort">
		<ul>
			<li><a href="index.php?adminaction=commentsbydateview" <?php if($_GET['adminaction']=='commentsbydateview'){echo "style= 'border-top: 1px solid #348ffe;'";} ?> >Trier par date <i class="fas fa-sort-down"></i></a></li>
			<li><a href="index.php?adminaction=commentsbydislikesview" <?php if($_GET['adminaction']=='commentsbydislikesview'){echo "style= 'border-top: 1px solid #348ffe;'";} ?> >Trier par impopularité <i class="fas fa-sort-down"></i></a></li>
		</ul>
	</nav>
	<?php
	while($data = $comments->fetch())
	{
	?>
	<div class="comments">
		<div class="comment-body">
			<p>
				<strong><?= $userManager->getLoginById($data['author_id']); ?></strong>
				<em>le <?= $data['comment_date_fr'] ?> :</em>
			</p>

			<p>
				<?= nl2br($data['comment']) ?>
			</p>
			<p class="show-post"><a href="index.php?action=load&amp;id=<?= $data['grid_id'] ?>&amp;commentid=<?= $data['id'] ?>">Afficher la création</a></p>
		</div>
		<div class="comment-info">
			<p> Nombre de dislikes : <?= $data['dislikes'] ?>
			</p>
			<div class="comment-info-btn">
				<button class="btn del-btn" onclick='window.location.href="index.php"'>Supprimer</button>
				<button class="btn" onclick='window.location.href="index.php"'>Approuver</button>
			</div>
		</div>
	</div>
	<?php
	}
	?>
</section>
<?php $content = ob_get_clean(); ?>

<?php require('view/backend/adminTemplate.php'); ?>