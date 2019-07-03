<?php

require_once("Manager.php");

/**
 * Classe permetant de gérer les articles.
 */
class LikeManager extends Manager
{
	public function gridLike($gridId, $userId)
	{
		$dataBase = $this->dbConnect('projet5');
		$request = $dataBase->prepare('INSERT INTO grid_likes (grid_id, user_id) VALUES (?, ?)');
		$succes1 = $request->execute(array($gridId, $userId));

		$request = $dataBase->prepare('UPDATE grids SET likes = likes + 1 WHERE id = ?');
		$succes2 = $request->execute(array($gridId));

		return $succes1 && $succes2;
	}

	public function commentLike($commentId, $userId)
	{
		$dataBase = $this->dbConnect('projet5');
		$request = $dataBase->prepare('INSERT INTO comment_likes (comment_id, user_id) VALUES (?, ?)');
		$succes1 = $request->execute(array($commentId, $userId));

		$request = $dataBase->prepare('UPDATE comments SET likes = likes + 1 WHERE id = ?');
		$succes2 = $request->execute(array($commentId));

		return $succes1 && $succes2;
	}

	public function commentDislike($commentId, $userId)
	{
		$dataBase = $this->dbConnect('projet5');
		$request = $dataBase->prepare('INSERT INTO comment_dislikes (comment_id, user_id) VALUES (?, ?)');
		$succes1 = $request->execute(array($commentId, $userId));

		$request = $dataBase->prepare('UPDATE comments SET dislikes = dislikes + 1 WHERE id = ?');
		$succes2 = $request->execute(array($commentId));

		return $succes1 && $succes2;
	}

	public function gridIsLiked($gridId, $userId)
	{
		$dataBase = $this->dbConnect('projet5');
		$request = $dataBase->prepare('SELECT id FROM grid_likes WHERE grid_id = ? AND user_id = ?');
		$request->execute(array($gridId, $userId));
		$data = $request->fetch();

		if ($data === false)
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	public function commentIsLiked($commentId, $userId)
	{
		$dataBase = $this->dbConnect('projet5');
		$request = $dataBase->prepare('SELECT id FROM comment_likes WHERE comment_id = ? AND user_id = ?');
		$request->execute(array($commentId, $userId));
		$data = $request->fetch();

		if ($data === false)
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	public function commentIsDisliked($commentId, $userId)
	{
		$dataBase = $this->dbConnect('projet5');
		$request = $dataBase->prepare('SELECT id FROM comment_dislikes WHERE comment_id = ? AND user_id = ?');
		$request->execute(array($commentId, $userId));
		$data = $request->fetch();

		if ($data === false)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
}