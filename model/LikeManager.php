<?php

require_once("Manager.php");

/**
 * Classe permetant de gérer les likes.
 */
class LikeManager extends Manager
{	
	/**
	 * Permet de liker une création
	 * @param  Int $gridId Id de la création
	 * @param  Int $userId Id de l'utilisateur qui like
	 * @return [type]         [description]
	 */
	public function gridLike($gridId, $userId)
	{
		$dataBase = $this->dbConnect('projet5');
		$request = $dataBase->prepare('INSERT INTO grid_likes (grid_id, user_id) VALUES (?, ?)');
		$succes1 = $request->execute(array($gridId, $userId));

		$request = $dataBase->prepare('UPDATE grids SET likes = likes + 1 WHERE id = ?');
		$succes2 = $request->execute(array($gridId));

		return $succes1 && $succes2;
	}

	/**
	 * Like un commentaire
	 * @param  Int $commentId Id du commentaire
	 * @param  Int $userId    Id de l'utilisateur qui like
	 * @return Bool            Renvoie true si l'opération s'est bien effectuée
	 */
	public function commentLike($commentId, $userId)
	{
		$dataBase = $this->dbConnect('projet5');
		$request = $dataBase->prepare('INSERT INTO comment_likes (comment_id, user_id) VALUES (?, ?)');
		$succes1 = $request->execute(array($commentId, $userId));

		$request = $dataBase->prepare('UPDATE comments SET likes = likes + 1 WHERE id = ?');
		$succes2 = $request->execute(array($commentId));

		return $succes1 && $succes2;
	}

	/**
	 * Dislike un commentaire
	 * @param  Int $commentId Id du commentaire
	 * @param  Int $userId    Id de l'utilisateur qui dislike
	 * @return Bool            Renvoie true si l'opération s'est bien effectuée
	 */
	public function commentDislike($commentId, $userId)
	{
		$dataBase = $this->dbConnect('projet5');
		$request = $dataBase->prepare('INSERT INTO comment_dislikes (comment_id, user_id) VALUES (?, ?)');
		$succes1 = $request->execute(array($commentId, $userId));

		$request = $dataBase->prepare('UPDATE comments SET dislikes = dislikes + 1 WHERE id = ?');
		$succes2 = $request->execute(array($commentId));

		return $succes1 && $succes2;
	}

	/**
	 * Permet de savoir si une création est liké d'un utilisateur
	 * @param  Int $gridId Id de la création
	 * @param  Int $userId id de l'utilisateur
	 * @return Bool         Retourne true si la création est likée de l'utilisateur
	 */
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

	/**
	 * Permet de savoir si un commentaire a été liké par un utilisateur
	 * @param  Int $commentId Id du commentaire
	 * @param  Int $userId    Id de l'utilisateur
	 * @return Bool            Renvoie true si le commentaire est liké par l'utilisateur
	 */
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

	/**
	 * Permet de savoir si un commentaire a été disliké par un utilisateur
	 * @param  Int $commentId Id du commentaire
	 * @param  Int $userId    Id de l'utilisateur
	 * @return Bool            Renvoie true si le commentaire a été disliké par l'utilisateur
	 */
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

	/**
	 * Supprime les likes d'une création
	 * @param  Int $gridId Id de la création
	 * @return Bool         Renvoie true si l'opération s'est bien effectuée
	 */
	public function deleteGridLikes($gridId)
	{
		$dataBase = $this->dbConnect('projet5');
		$request = $dataBase->prepare('DELETE FROM grid_likes WHERE grid_id = ?');
		$succes = $request->execute(array($gridId));

		return $succes;
	}

	/**
	 * Supprime les likes d'un commentaire
	 * @param  Int $commentId Id du commentaire
	 * @return Bool           Renvoie true si l'opération s'est bien effectuée
	 */
	public function deleteCommentLikes($commentId)
	{
		$dataBase = $this->dbConnect('projet5');
		$request = $dataBase->prepare('DELETE FROM comment_likes WHERE comment_id = ?');
		$succes = $request->execute(array($commentId));

		return $succes;
	}

	/**
	 * Supprime les dislikes d'un commentaire
	 * @param  Int $commentId Id du commentaire
	 * @return Bool           Renvoie true si l'opération s'est bien effectuée
	 */
	public function deleteCommentDislikes($commentId)
	{
		$dataBase = $this->dbConnect('projet5');
		$request = $dataBase->prepare('DELETE FROM comment_dislikes WHERE comment_id = ?');
		$succes = $request->execute(array($commentId));

		return $succes;
	}

	/**
	 * Permet de supprimer tous les likes d'un utilisateur
	 * @param  Int $id Id de l'utilisateur
	 * @return Bool     Renvoie true si l'opération s'est bien effectuée
	 */
	public function userDelete($id)
	{
		$dataBase = $this->dbConnect('Projet5');
		$request = $dataBase->prepare('DELETE FROM comment_dislikes WHERE user_id = ?');
		$succes = $request->execute(array($id));
		$request->closeCursor();

		$request = $dataBase->prepare('DELETE FROM comment_likes WHERE user_id = ?');
		$succes2 = $request->execute(array($id));
		$request->closeCursor();

		$request = $dataBase->prepare('DELETE FROM grid_likes WHERE user_id = ?');
		$succes3 = $request->execute(array($id));

		return $succes && $succes2;
	} 
}