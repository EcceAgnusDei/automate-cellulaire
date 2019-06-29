<?php $title = 'Jouez au jeux de la vie'; ?>
<?php ob_start(); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="public/js/grid.js"></script>
<script src="public/js/main.js"></script>
<?php $head = ob_get_clean(); ?>

<?php ob_start(); ?>
<section>
	<canvas id="canvas"></canvas>
	<div class="grid-command">
		<button id="next">Suivant</button>
		<button id="reload">Recommencer</button>
		<button id="set-grid">Afficher la grille</button>
		<button id="play">Lancer</button>
		<button id="stop">Arrêter</button>
		<button id="load">Charger</button>
		<button id="save">Sauvegarder</button>
		<form action="index.php?action=save" method="POST">
			<textarea name="grid-json" id="grid-json"></textarea>
			<input type="submit" value="Enregistrer"/>
		</form>
		<form action="index.php?action=save" method="POST">
			<textarea name="grid-json" id="grid-json"></textarea>
			<input type="submit" value="Enregistrer"/>
		</form>
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
<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/clientTemplate.php'); ?>