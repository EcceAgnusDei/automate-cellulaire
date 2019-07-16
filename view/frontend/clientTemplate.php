<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <title><?= $title ?></title>

        <link href="/automate-cellulaire/public/css/style.css" rel="stylesheet" />
        <link rel="shortcut icon" type="image/png" href="/automate-cellulaire/public/css/img/favicon.png">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.8.1/js/all.js" integrity="sha384-g5uSoOSBd7KkhAMlnQILrecXvzst9TdC09/VM+pjDTCM+1il8RHz5fKANTFFb+gQ" crossorigin="anonymous"></script>
        <script src="/automate-cellulaire/public/js/buttons.js"></script>
        <?= $head ?>
    </head>
        
    <body>
    	<header>
            <div class="header-content grid">
                <div class="header-head">
                    <a href="index.php"><img class="logo" src="public/css/img/logo.png" alt=""></a>
            		<nav>
            			<ul class="menu">
            				<li><a class="menu-item <?php if($home){echo 'active';} ?>" href="index.php">Accueil</a></li>
                            <li><a class="menu-item <?php if($play){echo 'active';} ?>" href="index.php?action=play">Jouer</a></li>
                            <li><a class="menu-item <?php if($artwork){echo 'active';} ?>" href="index.php?action=showgrids&amp;id=0&amp;direction=prev">Les créations</a></li>
                            <?php if(isset($_SESSION['userid']))
                            {
                            ?>
                            <li><a class="menu-item <?php if($userspace){echo 'active';} ?>" href="index.php?action=userspace">Votre espace</a></li>    
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
                </div>
                <?php
                if (isset($_SESSION['login']) && $_SESSION['login'] == "error")
                {
                    $_SESSION['login'] = '';
                    ?>
                    <p class="login-error"> Identifiant ou mot de passe incorrect !</p>
                    <?php
                }
                if (isset($_SESSION['login']) && $_SESSION['login'] == "erroremail")
                {
                    $_SESSION['login'] = '';
                    ?>
                    <p class="login-error">Cet email n'est pas inscrit !</p>
                    <?php
                }
                ?>
                <div class="menu-burger">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <?php
                if(!isset($_SESSION['userid']))
                {
                ?>
                    <div class="header-forms">
                        <form action="index.php?action=useridentifying" method="POST" class="user-login-form header-forms-item">
                            <label for="user-pseudo">Pseudo</label>
                            <input type="text" name="user-login" id="user-login" required>
                            <label for="user-password">Mot de passe</label>
                            <input type="password" name="user-password" id="user-password" required>
                            <input type="submit" value="Go" class="btn">
                        </form>
                        <form style="display: none;" action="index.php?action=passwordforgotten" method="POST" id="forgotten-form" class="header-forms-item">
                            <label for="forgotten-email">Votre email</label>
                            <input type="email" name="forgotten-email" id="forgotten-email">
                            <input type="submit" value="Envoyer" class="btn">
                        </form>
                        <div class="header-bottom-links">
                            <a href="index.php?action=signinview" class="signin-link">Inscription</a>
                            <button id="forgotten-btn" class="header-forms-item link-btn">Mot de passe oublié</button>  
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
    	</header>
        <?= $content ?>
        <footer class="client-footer">
            <p class="footer-content grid">&copy; 2019 Antoine Mondoloni . <a href="view/frontend/rgpd.html">RGPD</a> . <a href="view/frontend/legalNotice.html">Mentions légales</a> . <?php 
            if(isset($_SESSION['userid']) && !isset($_SESSION['admin'])) 
            {
            ?>
                <button class="link-btn" id="delete-account">Supprimer votre compte</button> . 
            <?php 
            }  
            else if(isset($_SESSION['admin']))
            {
            ?>
                <a href="index.php?adminaction=adminlogout">Deconnexion</a> . 
            <?php 
            }
            ?>
            <a href="index.php?action=adminlogin">Admin</a></p>
        </footer>
    </body>
    <?php
    if(isset($_SESSION['userid']))
    {
    ?>
    <script>
        $('#delete-account').click(function(){
        let confirmed = confirm("Êtes-vous sûr de vouloir supprimer définitivement votre compte ?");
        if (confirmed)
        {
            window.location.href="index.php?action=userdelete&id=<?= $_SESSION['userid'] ?>";
        }
        });
    </script>
    <?php
    }
    ?>
</html>