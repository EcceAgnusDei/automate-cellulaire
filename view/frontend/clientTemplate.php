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
                    <?php if(isset($_SESSION['userid']) && $_SESSION['userid'] != false)
                    {
                    ?>
                    <li><a class="menu-item" href="index.php?action=">Votre espace</a></li>    
                    <?php
                    }
                    else
                    {
                    ?>    
                    <li><button class="btn menu-item login-btn">Espace perso</button></li>
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
                <!-- <ul class="menu-mobile">
                    <li><a class="menu-item" href="index.php">Accueil</a></li>
                    <li><a class="menu-item" href="index.php?action=play">Jouer</a></li>
                    <li><a class="menu-item" href="index.php?action=showgrids">Les créations</a></li>
                     <?php if(true)
                    {
                    ?>    
                    <li><button class="btn menu-item login-btn" href="index.php?action=">Espace perso</button></li>
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
                </ul> -->
            </div>
            <?php if (isset($_GET['loginerror']))
            {
            ?>
            <p> Identifiant ou mot de passe incorrect</p>
            <?php
            }
            ?>
            <form action="index.php?action=useridentifying" method="POST" class="user-login-form">
                <label for="user-pseudo">Pseudo</label>
                <input type="text" name="user-login" id="user-login" required>
                <label for="user-password">Mot de passe</label>
                <input type="password" name="user-password" id="user-password" required>
                <input type="submit" value="Go">
                <a href="index.php?action=signinview">Inscription</a>
            </form>
    	</header>
        <?= $content ?>
        <footer class="client-footer">
            <p class="footer-content">&copy; 2019 Antoine Mondoloni . <a href="view/frontend/rgpd.html">RGPD</a> . <a href="view/frontend/legalNotice.html">Mentions légales</a> . <a href="index.php?action=login">Admin</a></p>
        </footer>
    </body>
    <script>
        $('.login-btn').click(function(){
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
