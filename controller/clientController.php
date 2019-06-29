<?php
if(session_status() == PHP_SESSION_NONE)
{
    session_start();
}
require_once('model/GridManager.php');

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