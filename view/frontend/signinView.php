<?php 
$title = 'Signin';
$head = '';
?>
<?php ob_start(); ?>
<section>
	<h1>Inscrivez-vous</h1>
	<form action="index.php?action=signin" method="post">
		<p style="color: red;" id="error"></p>
		<label for="signin-login">Pseudo</label>
		<input type="text" name="signin-login" id="signin-login" maxlength="20" required>
		<label for="signin-password">Mot de passe</label>
		<input type="password" name="signin-password" id="signin-password" maxlength="20" required>
		<label for="signin-email">Email</label>
		<input type="email" name="signin-email" id="signin-email" required>
		<input type="submit" class="btn" value="S'inscrire">
	</form>
</section>
<script>
	const logins = [];

	<?php
	while($data = $request->fetch())
	{
	?>
		logins.push('<?= $data['login'] ?>');
	<?php	
	}
	?>

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
			$('#error').text('Ce pseudo existe déjà !');
		}
	});

</script>
<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/clientTemplate.php'); ?>