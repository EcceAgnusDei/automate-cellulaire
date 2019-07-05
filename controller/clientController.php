<?php
require_once('model/GridManager.php');
require_once('model/UserManager.php');
require_once('model/CommentManager.php');
require_once('model/LikeManager.php');

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
	$script = '';
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
	?>
	<?php ob_start();?>
	<script>
		save = <?= $grid['json'] ?>;

		const squareCoords = <?= $grid['json'] ?>;
		let maxX = 0;
		let maxY = 0;

		for (let coord of squareCoords)
		{
			if (coord[0] > maxX)
			{
				maxX = coord[0];
			}
			if (coord[1] > maxY)
			{
				maxY = coord[1];
			}
		}

		setTimeout(function(){
			grid.grid(20, maxX + 7, maxY + 7);
			grid.load(save);
		},10);
	</script>
	<?php $script = ob_get_clean(); ?>
	<?php

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
	require('view/frontend/showGridsView.php');
}

function showGridsByLikes()
{
	$gridManager = new GridManager();
	$userManager = new UserManager();

	$grids = $gridManager->getGridsByLikes();
	require('view/frontend/showGridsView.php');
}

function signinView()
{
	$userManager = new UserManager();
	$request = $userManager->getUsers();

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

function userSpaceView($id)
{
	$gridManager = new GridManager();
	$grids = $gridManager->getGridsByAuthorId($id);

	require ('view/frontend/userSpaceView.php');

}

function userLogout()
{
	session_destroy();
	header('Location: index.php');
}

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

	var_dump($gridManager->getAuthorIdById($userId));

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
 * Redirige vers la page de connexion
 * @return [type] [description]
 */
function adminLogin()
{
	$error = '';
	require('view/backend/adminLoginView.php');
}

/**
 * Redirige vers la page de connexion lorsque les identifiant/mot de passe ne sont pas bons.
 */
function adminLogingError()
{
	$error = "<p style='color: red'>Identifiant ou mot de passe incorrect</p>";
	require('view/backend/adminLoginView.php');
}

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

		