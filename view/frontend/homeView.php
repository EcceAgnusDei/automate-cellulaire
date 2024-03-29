<?php 
$title = 'Le jeu de la vie de Conway';
$head = '';
?>
<?php ob_start(); ?>
<section class="home grid last-section">
	<h1>Bienvenue sur le site du jeu de la vie !</h1>
	<p>Ce site est dédié aux curieux avides de satisfaire leur esprit ingénieux et créatifs en concevant des automates cellulaires de <strong>John Conway</strong>. Pour cela rien de plus simple, il vous suffit de cliquer sur <a href="play">Jouer</a> !</p>
	<h3>Inscrivez-vous pour pouvoir sauvegarder vos chefs-d'oeuvre.</h3>
	<p>Vous pourrez également partager vos créations avec les autres utilisateurs, les commenter et les liker !</p>
	<p>Vous trouverez même un classement des créations les plus appréciées dans la rubrique <a href="index.php?action=showgridsbylikes">Les créations</a>. Il ne vous reste plus qu'à redoubler d'ingéniosité pour créer la population de cellules la plus ludique.</p>
	<h3>Comment cela fonctionne ?</h3>
	<div class="explanation">
		<img src="/automate-cellulaire/public/css/img/step1.png" alt="">
		<div class="explanation-arrow"><i class="fas fa-long-arrow-alt-right"></i></div>
		<img src="/automate-cellulaire/public/css/img/step2.png" alt="">
	</div>
	<p>Cliquer sur différents carrés de la grille pour faire apparaître des cellules. Si celles-ci ont plus de 3 voisins elles mourront de surpopulation, si elles ont moins de 2 voisins, c'est l'isolement qui les exterminera. Il vous suffit de cliquer sur suivant pour avancer d'une génération, ou sur le bouton play pour lancer l'animation. Le but du jeu ici est de créer une colonie de cellules proposant un évolution ludique, bref qui donne vie à votre écran !<strong> N'oubliez pas de sauvegarder votre création avant de passer à la génération suivant, ou l'état initial sera perdu !</strong></p>
	<p><strong>A vous de jouer !</strong></p>
</section>
<?php
$content = ob_get_clean();
$home = '';
$metaDescription = "Le site vous permettant d'expérimenter le jeu de la vie, ou encore automate cellulaire, de John Conway. Vous pourrez enregistrer vos découvertes, les partager, admirer, commenter ou encore liker celles des autres !"; 
?>

<?php require('view/frontend/clientTemplate.php'); ?>