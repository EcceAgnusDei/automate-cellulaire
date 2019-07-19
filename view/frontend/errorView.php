<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Erreur...</title>

	<link href="public/css/style.css" rel="stylesheet" />
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Aguafina+Script&display=swap" rel="stylesheet">
	<link rel="shortcut icon" type="image/png" href="Public/css/img/favicon.png">
</head>
<body>
	<section class="grid error-section last-section">
		<img class="error-img" src="public/css/img/error.png" alt="Erreur">
		<h2>Oups, une erreur est survenue... la voici :</h2>

		<?php 
		if(isset($errorMessage))
		{
			?>
			<p> <?= $errorMessage ?> </p>
			<?php
		}
		?>

		<p>Une seule solution : revenir à l' <a href="accueil">Accueil</a></p>
	</section>
</body>
</html>