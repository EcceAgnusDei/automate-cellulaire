<?php 
$title = 'Admirez les créations';
?>
<?php ob_start(); ?>
<script src="public/js/grid.js"></script>
<script src="public/js/showMiniature.js"></script>
<?php $head = ob_get_clean(); ?>

<?php ob_start(); ?>
<section class="grid last-section grids-view">
	<h3>Les créations</h3>
	<nav>
		<ul class="sort">
			<li><a href="les-creations" <?php if($_GET['action']=='showgrids'){echo "style= 'border-top: 1px solid #f38320;'";} ?> >Trier par date <i class="fas fa-sort-down"></i></a></li>
			<li><a href="les-creations-par-likes" <?php if($_GET['action']=='showgridsbylikes'){echo "style= 'border-top: 1px solid #f38320;'";} ?> >Trier par popularité <i class="fas fa-sort-down"></i></a></li>
		</ul>
	</nav>
	<div class="artwork-container">
<?php
foreach ($grids as $data)
{
	$author = $userManager->getLoginById($data['author_id']); ?>
	<div class="artwork"><canvas id="canvas<?= $data['id'] ?>"></canvas>
		<p class="grids-title"><a href="creation-<?= $data['id'] ?>"><?= $data['name'] ?> de <?= $author?></a></p>
		<div class="blue"> <i class="fas fa-thumbs-up"></i> <?= $data['likes'] ?></div>
		<?php
		if (isset($_SESSION['admin']))
		{
		?>
			<button class="btn grid-delete-btn" onclick='window.location.href="index.php?adminaction=griddelete&id=<?= $data['id']  ?>"'>Supprimer</button>
		<?php	
		}
		?>
	</div>
	<script>
		showMiniature (<?= $data['json'] ?>, "canvas<?= $data['id'] ?>");
	</script>
<?php
}
?>
	</div>
	<div class="grid-page-nav">
<?php
if ($displayPrev)
{
?>
	<a href="les-creations-<?php if($_GET['action'] == "showgrids"){echo "";}else {echo "par-likes-";} ?><?= $grids[0]['id'] ?>-prev"><i class="fas fa-chevron-left"></i></a>
<?php
}
if ($displayNext)
{
?>
	<a href="les-creations-<?php if($_GET['action'] == "showgrids"){echo "";}else {echo "par-likes-";} ?><?= $grids[0]['id'] ?>-next"><i class="fas fa-chevron-right"></i></a>
<?php
}
?>
	</div>
</section>

<?php 
$content = ob_get_clean();
$artwork = ''; 
$metaDescription = "Venez admirer les populations du jeu de la vie créées par les autres utilisateurs ! Vous pourrez les commenter ainsi que les liker !";
?>

<?php require('view/frontend/clientTemplate.php'); ?>