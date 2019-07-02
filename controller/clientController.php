<?php
if(session_status() == PHP_SESSION_NONE)
{
    session_start();
}
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
		header('location: index.php');
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

	$isLiked = false;

	if (isset($_SESSION['userid']))
	{
		$isLiked = $likeManager->gridIsLiked($id, $_SESSION['userid']);
	}

	$comments = $commentManager->getComments($id);
	$grid = $gridManager->load($id);

	$script = 'save =' . $grid['json'] . '; setTimeout(function(){grid.load(save);},1);';

	require ('view/frontend/playView.php');
}

/**
 * Affiche les grilles de la base de données
 */
function showGrids()
{
	$gridManager = new GridManager();
	$userManager = new UserManager();

	$grids = $gridManager->getGrids();
	require('view/frontend/showGridsView.php');
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
	var_dump($gridManager->getAuthorIdById($userId));

	if ($userId == $gridManager->getAuthorIdById($id))
	{
		$succes = $gridManager->delete($id);

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
		throw new Exception('Désolé, le commentaire n\'a peu être liké');
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


