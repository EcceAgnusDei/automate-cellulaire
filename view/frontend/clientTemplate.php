<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title><?= $title ?></title>

        <link href="/automate-cellulaire/public/css/style.css" rel="stylesheet" />
        <link rel="shortcut icon" type="image/png" href="/billet-simple/public/css/img/favicon.png">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.8.1/js/all.js" integrity="sha384-g5uSoOSBd7KkhAMlnQILrecXvzst9TdC09/VM+pjDTCM+1il8RHz5fKANTFFb+gQ" crossorigin="anonymous"></script>
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
                    <?php if(isset($_SESSION['userid']))
                    {
                    ?>
                    <li><a class="menu-item" href="index.php?action=userspace">Votre espace</a></li>    
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
            </div>
            <?php if (isset($_SESSION['login']) && $_SESSION['login'] == "error")
            {
                $_SESSION['login'] = '';
            ?>
            <p> Identifiant ou mot de passe incorrect</p>
            <?php
            }
            ?>
            <div class="user-login-form">
                <form action="index.php?action=useridentifying" method="POST" >
                    <label for="user-pseudo">Pseudo</label>
                    <input type="text" name="user-login" id="user-login" required>
                    <label for="user-password">Mot de passe</label>
                    <input type="password" name="user-password" id="user-password" required>
                    <input type="submit" value="Go">
                    <a href="index.php?action=signinview">Inscription</a>
                </form>
                <button id="forgotten-btn">Mot de passe oublié</button>
                <form style="display: none;" action="index?action=passwordforgotten" method="POST" id="forgotten-form">
                    <label for="forgotten-email">Votre email</label>
                    <input type="email" name="forgotten-email" id="forgotten-email">
                </form>
            </div>
    	</header>
        <?= $content ?>
        <footer class="client-footer">
            <p class="footer-content">&copy; 2019 Antoine Mondoloni . <a href="view/frontend/rgpd.html">RGPD</a> . <a href="view/frontend/legalNotice.html">Mentions légales</a> . <a href="index.php?action=adminlogin">Admin</a></p>
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

        $('#forgotten-btn').click(function(){
            if ($('#forgotten-form').css('display') === 'none')
            {
                $('#forgotten-form').css('display','block');
            }
            else
            {
                $('#forgotten-form').css('display','none');
            }
        });
    </script>
</html>
