<?php

require_once("Manager.php");

/**
 * Classe permetant de gérer les commentaires.
 */
class CommentManager extends Manager
{
	/**
	 * Méthode permettant d'obtenir les commentaires d'un article.
	 * @return PDOStatement Requête obtenue à partir de la table comment.
	 */
	public function getComments($postId)
	{
		$dataBase = $this->dbConnect('projet4');
		$comments = $dataBase->prepare('SELECT id, signalement, author, post_id, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin\') AS comment_date_fr FROM comments WHERE post_id = ? ORDER BY id DESC');
		$comments->execute(array($postId));

		return $comments;
	}

	/**
	 * Selectionne tous les commentaires et les classe du plus ancien
	 * au plus récent
	 * @return PDOStatement Requête obtenue à partir de la table comment
	 */
	public function getAllById()
	{
		$dataBase = $this->dbConnect('projet4');
		$comments = $dataBase->query('SELECT id, post_id, author, comment, signalement, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin\') AS comment_date_fr FROM comments ORDER BY id DESC');

		return $comments;
	}

	/**
	 * Selectionne les commentaires ayant été signalés et les ordonne
	 * par nombre de signalement décroissant
	 * @return PDOStatement Requête obtenue à partir de la table comment
	 */
	public function getAllBySignal()
	{
		$dataBase = $this->dbConnect('projet4');
		$comments = $dataBase->query('SELECT id, post_id, author, comment, signalement, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin\') AS comment_date_fr FROM comments WHERE signalement > 0 ORDER BY signalement DESC');

		return $comments;
	}


	/**
	 * Méthode enregistrant le commentaire dans la base de données
	 * @param  int $postId  id du post dans lequel on veut inclure le commentaire
	 * @param  string $author  Auteur du commentaire
	 * @param  string $comment Le commentaire
	 * @return bool          Retourne true si l'enregistrement s'est bien effectué
	 */
	public function postComment($postId, $author, $comment)
	{
		$dataBase = $this->dbConnect('projet4');
		$comments = $dataBase->prepare('INSERT INTO comments(post_id, author, comment, comment_date) VALUES(?,?,?, NOW())');
		$succes = $comments->execute(array($postId, $author, $comment));

		return $succes;
	}

	/**
	 * Signal un commentaire
	 * @param  int $commentId Id du commentaire à signaler
	 * @return bool Renvoie true si le signalement s'est bien déroulé           
	 */
	public function signal($commentId)
	{
		$dataBase = $this->dbConnect('projet4');
		$signalement = $dataBase->prepare('SELECT signalement FROM comments WHERE id = ?');
		$signalement->execute(array($commentId));

		$signalFetch = $signalement->fetch();
		$signalNumber = (int)$signalFetch['signalement'];
		$signalNumber++;

		$signalement->closeCursor();
		$signalement = $dataBase->prepare('UPDATE comments SET signalement = ? WHERE id = ?');
		$succes = $signalement->execute(array($signalNumber, $commentId));
		return $succes;
	}

	/**
	 * Annule le signalement d'un commentaire
	 * @param  id $commentId Id du commentaire dont on veut annuler les signalements
	 * @return bool            Renvoie true si l'accion s'est bien déroulée
	 */
	public function unsignal($commentId)
	{
		$dataBase = $this->dbConnect('projet4');
		$request = $dataBase->prepare('UPDATE comments SET signalement = 0 WHERE id = ?');
		$succes = $request->execute(array($commentId));
		return $succes;
	}

	/**
	 * permet de supprimer un commentaire
	 * @param  int $id Id du commentaire à supprimer
	 * @return bool     Renvoie true si le commentaire à bien été supprimé
	 */
	public function delete($id)
	{
		$dataBase = $this->dbConnect('projet4');
		$del = $dataBase->prepare('DELETE FROM comments WHERE id = ?');
		$succes = $del->execute(array($id));

		return $succes;
	}

	/**
	 * Permet de compter le nombre de commentaires d'un article
	 * @param  int $id Id de l'article dont l'on veut compter le nombre de commentaires
	 * @return int     Le nombre de commentaires
	 */
	public function countComments($id)
	{
		$dataBase = $this->dbConnect('projet4');
		$request = $dataBase->prepare('SELECT COUNT(*) AS nb_comments FROM comments WHERE post_id = ?');
		$request->execute(array($id));
		$data = $request->fetch();

		return $data['nb_comments'];
	}
}