<?php
if(session_status() == PHP_SESSION_NONE)
{
    session_start();
}
require_once('model/GridManager.php');
require_once('model/UserManager.php');
require_once('model/CommentManager.php');

/**
 * Affiche la liste des articles
 * 
 */
function save($json)
{
	$gridManager = new GridManager();
	$succes = $gridManager->save($json);

	if ($succes)
	{
		header('location: index.php');
	}
	else
	{
		throw new Exception('La grille n\'a pas peu être enregistrée');
	}
	require('view/frontend/listPostsView.php');
}

function playView()
{
	$script = '';
	require ('view/frontend/playView.php');
}

function load($id)
{
	$gridManager = new GridManager();

	$grid = $gridManager->load($id);
	$script = 'save =' . $grid['json'] . '; setTimeout(function(){grid.load(save);},1);';

	require ('view/frontend/playView.php');
}

function showGrids()
{
	$gridManager = new GridManager();
	$grids = $gridManager->getGrids();
	require('view/frontend/showGridsView.php');
}

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
	require('view/frontend/listPostsView.php');
}

function userIdentifying($login, $password)
{
	$userManager = new UserManager();
	$id = $userManager->getId($login, $password);
	if(!$id)
	{
		$_SESSION['login'] = 'error';
		if ($_SERVER['HTTP_REFERER'] == 'http://localhost/automate-cellulaire/' || $_SERVER['HTTP_REFERER'] == 'http://localhost/automate-cellulaire/index.php')
		{
			header('location: index.php?loginerror=1');
		}
		else
		{
			header('location: ' . $_SERVER['HTTP_REFERER']);
		}
	}
	else
	{
		$_SESSION['userid'] = $id;
		header('location: ' . $_SERVER['HTTP_REFERER']);
	}
}
	