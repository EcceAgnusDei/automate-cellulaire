<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title><?= $title ?></title>

        <link href="/automate-cellulaire/public/css/style.css" rel="stylesheet" />
        <link rel="shortcut icon" type="image/png" href="/billet-simple/public/css/img/favicon.png">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <?= $head ?>
    </head>
        
    <body>
    	<header>
    		<div class="header-title">
    			<h1></h1>
    		    <h2></h2>
    		</div>
    		<nav class="menu grid">
    			<ul>
    				<li><a class="menu-item" href="index.php">Accueil</a></li>
                    <li><a class="menu-item" href="index.php?action=play">Jouer</a></li>
                    <li><a class="menu-item" href="index.php?action=showgrids">Les créations</a></li>
                    <?php if(true)
                    {
                    ?>    
                    <li><button class="btn menu-item" id="login-btn" href="index.php?action=">Connexion</button></li>
                    <?php
                    }
                    ?>
                    <?php if(false)
                    {
                    ?>    
                    <li><a class="menu-item" href="index.php?action=">Espace personnel</a></li>
                    <?php
                    }
                    ?>
    			</ul>
    		</nav>
            <div class="menu-burger">
                <input type="checkbox" class="toggler">
                <div class="hamburger">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <ul class="menu-mobile">
                    <li><a class="menu-item" href="index.php">Accueil</a></li>
                    <li><a class="menu-item" href="index.php?action=play">Jouer</a></li>
                    <li><a class="menu-item" href="index.php?action=showgrids">Les créations</a></li>
                     <?php if(true)
                    {
                    ?>    
                    <li><button class="btn menu-item" id="login-btn" href="index.php?action=">Connexion</button></li>
                    <?php
                    }
                    ?>
                    <?php if(false)
                    {
                    ?>    
                    <li><a class="menu-item" href="index.php?action=">Espace personnel</a></li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
            <form action="index.php?action=" class="user-login-form">
                <label for="pseudo">Pseudo</label>
                <input type="text" name="pseudo" id="pseudo">
                <label for="user-password">Mot de passe</label>
                <input type="password" name="user-password" id="user-password">
            </form>
    	</header>
        <?= $content ?>
        <footer class="client-footer">
            <p class="footer-content">&copy; 2019 Antoine Mondoloni . <a href="view/frontend/rgpd.html">RGPD</a> . <a href="view/frontend/legalNotice.html">Mentions légales</a> . <a href="index.php?action=login">Admin</a></p>
        </footer>
    </body>
    <script>
        $('#login-btn').click(function(){
            if ($('.user-login-form').css('display') === 'none')
            {
                $('.user-login-form').css('display','flex');
            }
            else
            {
                $('.user-login-form').css('display','none');
            }
        });
    </script>
</html>
