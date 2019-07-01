<?php 
$title = 'Signin';
$head = '';
?>
<?php ob_start(); ?>
<section>
	<h1>Inscrivez-vous</h1>
	<form action="index.php?action=signin" method="post">
		<label for="signin-login">Pseudo</label>
		<input type="text" name="signin-login" id="signin-login" required>
		<label for="signin-password">Mot de passe</label>
		<input type="password" name="signin-password" id="signin-password" required>
		<label for="signin-email">Email</label>
		<input type="email" name="signin-email" id="signin-email" required>
		<input type="submit" class="btn" value="S'inscrire">
	</form>
</section>
<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/clientTemplate.php'); ?>