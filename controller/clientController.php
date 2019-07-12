<?php
/**
 * Renvoie à la page d'accueil
 *   
 */
function home()
{
	$home = true;
	$play = false;
	$artwork = false;
	$userspace = false;

	require('view/frontend/homeView.php');
}
/**
 * Affiche la liste des articles
 * 
 */
function save($json, $authorId, $name)
{
	$gridManager = new GridManager();
	$succes = $gridManager->save($json, $authorId, $name);

	if ($succes)
	{
		header('location: index.php?action=userspace');
	}
	else
	{
		throw new Exception('La grille n\'a pas peu être enregistrée');
	}
}

/**
 * Affiche la page du jeu
 */
function playView()
{
	$home = false;
	$play = true;
	$artwork = false;
	$userspace = false;

	require ('view/frontend/playView.php');
}

/**
 * Charge une grille à partir de la base de données
 * @param  Int $id Id de la grille
 */
function load($id)
{
	$gridManager = new GridManager();
	$commentManager = new CommentManager();
	$userManager = new UserManager();
	$likeManager = new LikeManager();

	$gridIsLiked = false;
	$commentIsLiked = false;
	$commentIsDisliked = false;

	$home = false;
	$play = true;
	$artwork = false;
	$userspace = false;

	$nbComments = $commentManager->countComments($id);

	if (isset($_SESSION['userid']))
	{
		$gridIsLiked = $likeManager->gridIsLiked($id, $_SESSION['userid']);
	}

	if (isset($_GET['commentid']))
	{
		$comments = $commentManager->getCommentById($_GET['commentid']);
	}
	else
	{
		$comments = $commentManager->getComments($id);
	}
	
	$grid = $gridManager->load($id);

	require ('view/frontend/playView.php');
}

/**
 * Affiche les grilles de la base de données
 */
function showGrids()
{
	$gridManager = new GridManager();
	$userManager = new UserManager();

	$grids = $gridManager->getGridsByDate();

	$home = false;
	$play = false;
	$artwork = true;
	$userspace = false;

	require('view/frontend/showGridsView.php');
}

/**
 * Affiche les création triées par nombre de like
 * 
 */
function showGridsByLikes()
{
	$gridManager = new GridManager();
	$userManager = new UserManager();

	$grids = $gridManager->getGridsByLikes();

	$home = false;
	$play = false;
	$artwork = true;
	$userspace = false;

	require('view/frontend/showGridsView.php');
}

/**
 * Affiche le formulaire d'inscription
 */
function signinView()
{
	$userManager = new UserManager();
	$request = $userManager->getUsers();

	$home = false;
	$play = false;
	$artwork = false;
	$userspace = false;

	require('view/frontend/signinView.php');
}

/**
 * Permet l'enregistrement d'un utilisateur
 * @param  String $login    Identifient de l'utilisateur
 * @param  String $password Mot de passe de l'utilisateur
 * @param  String $email    Email de l'utilisateur
 */
function signin($login, $password, $email)
{
	$userManager = new UserManager();
	$succes = $userManager->saveUser($login, $password, $email);

	if ($succes)
	{
		header('location: index.php');
	}
	else
	{
		throw new Exception('Désolé, l\'inscription n\'a peu se faire');
	}
}

/**
 * Identifie un utilisateur et vérifie si celui-ci existe bien
 * @param  String $login    Identifiant de l'utilisateur
 * @param  String $password Mot de passe de l'utilisateur
 */
function userIdentifying($login, $password)
{
	$userManager = new UserManager();
	$id = $userManager->getId($login, $password);
	if(!$id)
	{
		$_SESSION['login'] = 'error';
		if ($_SERVER['HTTP_REFERER'] == 'http://localhost/automate-cellulaire/' || $_SERVER['HTTP_REFERER'] == 'http://localhost/automate-cellulaire/index.php')
		{
			header('location: index.php');
		}
		else
		{
			header('location: ' . $_SERVER['HTTP_REFERER']);
		}
	}
	else
	{
		$_SESSION['userid'] = (int)$id['id'];
		header('location: ' . $_SERVER['HTTP_REFERER']);
	}
}

/**
 * Permet l'affichage de l'espace utilisateur
 * @param  Int $id Id de l'utilisateur
 */
function userSpaceView($id)
{
	$gridManager = new GridManager();
	$commentManager = new CommentManager();
	$userManager = new UserManager();

	$grids = $gridManager->getGridsByAuthorId($id);
	$comments = $commentManager->getCommentsByUserId($id);

	$home = false;
	$play = false;
	$artwork = false;
	$userspace = true;

	require ('view/frontend/userSpaceView.php');

}

/**
 * Ferme la session
 */
function userLogout()
{
	session_destroy();
	header('Location: index.php');
}

/**
 * Supprime une création
 * @param  Int $id     Id de la création
 * @param  Int $userId Id de l'utilisateur qui supprime sa création
 * @return [type]         [description]
 */
function gridDelete($id, $userId)
{
	$gridManager = new GridManager();
	$likeManager = new LikeManager();
	$commentManager = new CommentManager();

	$ids = $commentManager->commentIdByGrid($id);

	foreach ($ids as $commentId)
	{
		commentDelete($commentId);
	}

	if ($userId == $gridManager->getAuthorIdById($id))
	{
		$succes = $gridManager->delete($id);
		$likeManager->deleteGridLikes($id);

		if ($succes)
		{
			header('location: index.php?action=userspace');
		}
		else
		{
			throw new Exception('Désolé, la suppression n\'a peu se faire');
		}
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à supprimer cette création');
	}
}

/**
 * Supprime un commentaire
 * @param  Int $id Id du commentaire à supprimer
 */
function commentDelete($id)
{
	$commentManager = new CommentManager();
	$likeManager = new LikeManager();
	$likeManager->deleteCommentLikes($id);
	$likeManager->deleteCommentDislikes($id);
	$succes = $commentManager->delete($id);

	if ($succes)
	{
		header('location: ' . $_SERVER['HTTP_REFERER']);
	}
	else
	{
		throw new Exception('Désolé, la suppression n\'a peu se faire');
	}
}

/**
 * Like une création
 * @param  Int $gridId Id de la création
 * @param  Int $userId Id de l'utilisateur qui like la création
 */
function gridLike($gridId, $userId)
{
	$gridManager = new GridManager();
	$likeManager = new LikeManager();

	$succes = $likeManager->gridLike($gridId, $userId);

	if ($succes)
	{
		header('location: index.php?action=load&id=' . $gridId);
	}
	else
	{
		throw new Exception('Désolé, la grille n\'a peu être likée');
	}
}

/**
 * Ajoute un commentaire dans la base de données
 * @param Int $gridId  Id de la création commentée
 * @param Int $userId  Id de l'utilisateur qui commente
 * @param String $content Contenu du commentaire
 */
function addComment($gridId, $userId, $content)
{
	$commentManager = new CommentManager();
	$succes = $commentManager->addComment($gridId, $userId, $content);

	if ($succes)
	{
		header('location: index.php?action=load&id=' . $gridId);
	}
	else
	{
		throw new Exception('Désolé, le commentaire n\'a peu être ajouté');
	}
}

/**
 * Like un commentaire
 * @param  Int $commentId Id du commentaire liké
 * @param  Int $userId    Id de l'utilisateur qui like
 */
function commentLike($commentId, $userId)
{
	$commentManager = new CommentManager();
	$likeManager = new LikeManager();

	$succes = $likeManager->commentLike($commentId, $userId);

	if ($succes)
	{
		header('location: ' . $_SERVER['HTTP_REFERER']);
	}
	else
	{
		throw new Exception('Désolé, le commentaire n\'a peu être liké');
	}
}

/**
 * Dislike un commentaire
 * @param  Int $commentId Id du commentaire disliké
 * @param  Int $userId    Id de l'utilisateur qui dislike
 */
function commentdisLike($commentId, $userId)
{
	$commentManager = new CommentManager();
	$likeManager = new LikeManager();

	$succes = $likeManager->commentDislike($commentId, $userId);

	if ($succes)
	{
		header('location: ' . $_SERVER['HTTP_REFERER']);
	}
	else
	{
		throw new Exception('Désolé, le commentaire n\'a peu être liké');
	}
}

/**
 * Envoie un mail à l'utilisateur qui veut récupérer son mot de passe 
 * @param  String $email mail de l'utilisateur
 */
function passwordForgotten($email)
{
	$userManager = new UserManager();
	$request = $userManager->getUserByEmail($email);

	if ($request->fetch() === false)
	{
		$_SESSION['login'] = 'erroremail';
		header('location: ' . $_SERVER['HTTP_REFERER']);
	}
	else
	{
		$data = $request->fetch();
		$login = $data['login'];
		$password = $data['password'];

		$header = "MIME-Version: 1.0\r\n";
		$header.="From:'mondoloni-dev.fr'<support@mondoloni-dev.fr>"."\n";
		$header.='Content-Type:text/html; charset="utf-8"'."\n";
		$header.='Content-Transfert-Encoding: 8bit';

		$message='
		<html>
			<body>
				<div align="center">
					Votre pseudo : $login
					Votre mot de passe : $password
				</div>
			</body>
		</html>';
		mail($email, "Votre pseudo et mot de passe", $message);
	}
}

function userDelete($id, $userId)
{
	$userManager = new UserManager();
	$commentManager = new CommentManager();
	$gridManager = new GridManager();
	$likeManager = new LikeManager();

	if ($id == $userId)
	{
		$succes = $userManager->delete($id);
		$succes2 = $commentManager->userDelete($id);
		$succes3 = $gridManager->userDelete($id);
		$succes4 = $likeManager->userDelete($id);
		userLogout();
	}
	else
	{
		throw new Exception('Vous n\'avez pas le droit de faire cela');
	}

	if (!($succes && $succes2 && $succes3 && $succes4))
	{
		throw new Exception('Le compte utilisateur n\'a pas peu être supprimé');
	}
}

		