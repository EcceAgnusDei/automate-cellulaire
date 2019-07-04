<?php
require_once('model/GridManager.php');
require_once('model/UserManager.php');
require_once('model/CommentManager.php');
require_once('model/LikeManager.php');

/**
 * Ouvre la session admin
 * @param  string $user     identifiant
 * @param  string $password mot de passe
 */
function admin()
{
	$_SESSION['admin'] = true;
	$_SESSION['userid'] = 1;
	header('Location: index.php?adminaction=gridsview');
}

function adminGridView()
{
	$gridManager = new GridManager();
	$userManager = new userManager();

	$grids = $gridManager->getGridsByDate();

	require('view/backend/adminGridsView.php');
}

function commentsByDateView()
{
	$commentManager = new CommentManager();
	$userManager = new userManager();

	$comments = $commentManager->getAllByDate();

	require('view/backend/adminCommentsView.php');
}

function commentsByDislikesView()
{
	$commentManager = new CommentManager();
	$userManager = new userManager();

	$comments = $commentManager->getAllByDislikes();

	require('view/backend/adminCommentsView.php');
}

function adminGridDelete($id)
{
	$gridManager = new GridManager();
	$likeManager = new LikeManager();
	$commentManager = new CommentManager();

	$ids = $commentManager->commentIdByGrid($id);

	foreach ($ids as $commentId)
	{
		adminCommentDelete($commentId);
	}
	
	$succes = $gridManager->delete($id);
	$likeManager->deleteGridLikes($id);

	if ($succes)
	{
		header('location: index.php?adminaction=gridsview');
	}
	else
	{
		throw new Exception('Désolé, la suppression n\'a peu se faire');
	}
}

function adminCommentDelete($id)
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
?>