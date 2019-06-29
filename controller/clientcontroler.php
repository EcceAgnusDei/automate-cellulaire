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
function save()
{
	$postManager = new PostManager();
	$posts = $postManager->getPosts();

	require('view/frontend/listPostsView.php');
}