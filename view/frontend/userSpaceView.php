<?php 
$title = 'Votre atelier';
$head = '';
?>

<?php ob_start(); ?>
<nav class="user-space-nav grid">
	<ul>
		<li><button id="show-artwork">Vos oeuvres</button></li>
		<li><button id="show-comments">Vos commentaires</button></li>
		<li><button class="btn" onclick='window.location.href="index.php?action=userlogout"'>Déconnexion</button></li>
	</ul>
</nav>
<section class="user-artwork last-section grid">
	<h3>Vos oeuvres</h3>
<?php
while ($data = $grids->fetch())
{
?>
	<div>
		<p><?= $data['name'] ?><span class="blue"> <i class="fas fa-thumbs-up"></i><?= $data['likes'] ?></span></p>
		<div>
			<a href="index.php?action=load&amp;id=<?= $data['id'] ?>">Voir</a>
			<button onclick='window.location.href="index.php?action=griddelete&id=<?= $data['id']?>"'>Supprimer</button>
		</div>
	</div>
<?php
}
?>
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
			<p><i class="fas fa-thumbs-up blue"></i> <span class="blue"> <?= $data['likes'] ?></span> <i class="fas fa-thumbs-down red"></i> <span class="red"> <?= $data['dislikes'] ?></span></p>
			<button class="btn" onclick='window.location.href="index.php?adminaction=commentdelete&id=<?= $data['id'] ?>"'>Supprimer</button>
		</div>
	<?php
	}
	?>
</section>
<script>
	$("#show-artwork").click(function(){
		$(".user-comments").css('display','none');
		$(".user-artwork").css('display', 'block');
	});

	$("#show-comments").click(function(){
		$(".user-comments").css('display','block');
		$(".user-artwork").css('display', 'none');
	});
</script>
<?php
$grids->closeCursor();
$content = ob_get_clean(); 
?>

<?php require('view/frontend/clientTemplate.php'); ?>