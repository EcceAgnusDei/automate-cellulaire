<?php $title = 'Vous inscrire'; ?>
<?php ob_start(); ?>
<script src="/automate-cellulaire/public/js/loginVerification.js"></script>
<?php $head = ob_get_clean(); ?>

<?php ob_start(); ?>
<section class="grid">
	<h3>Inscrivez-vous</h3>
	<form action="index.php?action=signin" method="post" class="signin-form">
		<p style="color: red;" id="error"></p>
		<label class="block" for="signin-login">Pseudo</label>
		<input type="text" title="Entrez votre pseudo." name="signin-login" id="signin-login" maxlength="20" required>
		<label class="block" for="signin-password">Mot de passe</label>
		<input type="password" title="Votre mot de passe doit contenir au moins 8 caractères." name="signin-password" id="signin-password" maxlength="20" required>
		<label class="block" for="signin-email">Email</label>
		<input type="email" title="Entre votre mail." name="signin-email" id="signin-email" required>
		<input type="submit" class="btn" value="S'inscrire">
	</form>
</section>
<?php 
$content = ob_get_clean(); 
$metaDescription = "Inscrivez-vous sur le site du jeu de la vie pour pouvoir profiter de toutes les fonctionnalités du site. Vous pourrez ainsi enregistrer vos créations dans une base de données, commenter celles des autres et gérer votre espace personnel !";
?>

<?php require('view/frontend/clientTemplate.php'); ?>