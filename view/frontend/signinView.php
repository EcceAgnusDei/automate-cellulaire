<?php 
$title = 'Vous inscrire';
$head = '';
?>
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
<script>
	let logins = [];

	$.get(
		'public/ajax/getLogins.php',
		'false',
		callback,
		'text'
		);

	$('#signin-login').keyup(function()
	{
		let exists = false;
		console.log($('#signin-login').val());
		for (let login of logins)
		{
			if ($('#signin-login').val() == login)
			{
				exists = true;
			}
		}

		if (exists || $('#signin-login').val() == '')
		{
			$('#signin-login').css('background-color', 'red');
		}
		else
		{
			$('#signin-login').css('background-color', 'green');
		}
	});

	$('#signin-password').keyup(function()
	{
		if ($('#signin-password').val().length < 8)
		{
			$('#signin-password').css('background-color', 'red');
		}
		else
		{
			$('#signin-password').css('background-color', 'green');
		}
	});

	$('form').submit(function(evt){
		let exists2;
		for (let login of logins)
		{
			if ($('#signin-login').val() == login)
			{
				exists2 = true;
			}
		}
		if (exists2)
		{
			evt.preventDefault();
			$('#error').css('display', 'block');
			$('#error').text('Ce pseudo existe déjà !');
		}
		else if ($('#signin-password').val().length < 8)
		{
			evt.preventDefault();
			$('#error').css('display', 'block');
			$('#error').text('Mot de passe trop court');
		}
	});

	function callback(result)
	{
		console.log('coucou');
		logins = JSON.parse(result);
	}

</script>
<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/clientTemplate.php'); ?>