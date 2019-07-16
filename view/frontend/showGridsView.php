<?php 
$title = 'Admirez les créations';
?>
<?php ob_start(); ?>
<script src="public/js/grid.js"></script>
<?php $head = ob_get_clean(); ?>

<?php ob_start(); ?>
<section class="grid last-section grids-view">
	<h3>Les créations</h3>
	<nav>
		<ul class="sort">
			<li><a href="index.php?action=showgrids&amp;id=0&amp;direction=prev" <?php if($_GET['action']=='showgrids'){echo "style= 'border-top: 1px solid #f38320;'";} ?> >Trier par date <i class="fas fa-sort-down"></i></a></li>
			<li><a href="index.php?action=showgridsbylikes&amp;id=0&amp;direction=prev" <?php if($_GET['action']=='showgridsbylikes'){echo "style= 'border-top: 1px solid #f38320;'";} ?> >Trier par popularité <i class="fas fa-sort-down"></i></a></li>
		</ul>
	</nav>
<?php
foreach ($grids as $data)
{
	$author = $userManager->getLoginById($data['author_id']); ?>
	<div class="artwork"><canvas id="canvas<?= $data['id'] ?>"></canvas>
		<p class="grids-title"><a href="index.php?action=load&amp;id=<?= $data['id'] ?>"><?= $data['name'] ?> de <?= $author?></a> <span class="blue"> <i class="fas fa-thumbs-up"></i> <?= $data['likes'] ?></span></p>
		<?php
		if (isset($_SESSION['admin']))
		{
		?>
			<button class="btn grid-delete-btn" onclick='window.location.href="index.php?adminaction=griddelete&id=<?= $data['id']  ?>"'>Supprimer</button>
		<?php	
		}
		?></div>
	<script>
		const squareCoords<?= $data['id'] ?> = <?= $data['json'] ?>;
		let maxX<?= $data['id'] ?> = 0;
		let maxY<?= $data['id'] ?> = 0;
		const grid<?= $data['id'] ?> = new Grid("canvas<?= $data['id'] ?>");

		for (let coord of squareCoords<?= $data['id'] ?>)
		{
			if (coord[0] > maxX<?= $data['id'] ?>)
			{
				maxX<?= $data['id'] ?> = coord[0];
			}
			if (coord[1] > maxY<?= $data['id'] ?>)
			{
				maxY<?= $data['id'] ?> = coord[1];
			}
		}

		grid<?= $data['id'] ?>.grid(7, maxX<?= $data['id'] ?> +5, maxY<?= $data['id'] ?> +5);
		grid<?= $data['id'] ?>.load(<?= $data['json'] ?>);

		$("#canvas<?= $data['id'] ?>").click(function(evt){
			evt.preventDefault();
		});
	</script>
<?php
}
?>
	<div class="grid-page-nav">
<?php
if ($displayPrev)
{
?>
	<a href="index.php?action=<?= $_GET['action'] ?>&amp;id=<?= $grids[0]['id'] ?>&amp;direction=prev"><i class="fas fa-chevron-left"></i></a>
<?php
}
if ($displayNext)
{
?>
	<a href="index.php?action=<?= $_GET['action'] ?>&amp;id=<?= $grids[0]['id'] ?>&amp;direction=next"><i class="fas fa-chevron-right"></i></a>
<?php
}
?>
	</div>
</section>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/clientTemplate.php'); ?>