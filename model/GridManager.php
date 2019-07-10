<?php

require_once("Manager.php");

/**
 * Classe permetant de gérer les créations.
 */
class GridManager extends Manager
{
	/**
	 * Permet de Sauvegarder une création dans la base de données
	 * @param  String $json Version littérale d'un array comportant les coordonnées des carrés noirs
	 * @param  Int $id   Id de l'auteur
	 * @param  String $name Nom de l'oeuvre
	 * @return Bool       Renvoie true si l'enregistrement s'est bien effectué
	 */
	public function save($json, $id, $name)
	{
		$dataBase = $this->dbConnect('projet5');
		$request = $dataBase->prepare('INSERT INTO grids(json,author_id, name,grid_date) VALUES (?,?,?, NOW())');
		$succes = $request->execute(array($json, $id, $name));

		return $succes;
	}

	/**
	 * Charge un création à partir de la base de données
	 * @param  Int $id Id de la création
	 * @return Array     Création
	 */
	public function load($id)
	{
		$dataBase = $this->dbConnect('projet5');
		$request = $dataBase->prepare('SELECT * FROM grids WHERE id = ?');
		$request->execute(array($id));
		$grid = $request->fetch();

		return $grid;
	}

	/**
	 * Permet de charger toutes les créations et les classe du plus récent au plus ancien
	 * @return PDOStatment L'ensemble des créations
	 */
	public function getGridsByDate()
	{
		$dataBase = $this->dbConnect('projet5');
		$request = $dataBase->query('SELECT id, name,json, likes, author_id, DATE_FORMAT(grid_date, \'%d/%m/%Y à %Hh%imin\') AS grid_date_fr FROM grids ORDER BY grid_date DESC');

		return $request;
	}

	/**
	 * Permet de charger toutes les créations et les classe en fonction de leur nombre de likes
	 * @return PDOStatment Les créations
	 */
	public function getGridsByLikes()
	{
		$dataBase = $this->dbConnect('projet5');
		$request = $dataBase->query('SELECT id, name,json, likes, author_id, DATE_FORMAT(grid_date, \'%d/%m/%Y à %Hh%imin\') AS grid_date_fr FROM grids ORDER BY likes DESC');

		return $request;
	}

	/**
	 * Permet d'obtenir toutes les créations d'un même auteur
	 * @param  Int $id Id de l'auteur
	 * @return PDOStatment     Les créations de l'auteur
	 */
	public function getGridsByAuthorId($id)
	{
		$dataBase = $this->dbConnect('projet5');
		$request = $dataBase->prepare('SELECT id, name, likes, DATE_FORMAT(grid_date, \'%d/%m/%Y à %Hh%imin\') AS grid_date_fr FROM grids WHERE author_id = ? ORDER BY id DESC');
		$request->execute(array($id));

		return $request;
	}

	/**
	 * Supprime une création
	 * @param  Int $id Id de la création à supprimer
	 * @return Bool     Renvoie true si la suppression s'est bien effectuée
	 */
	public function delete($id)
	{
		$dataBase = $this->dbConnect('projet5');
		$del = $dataBase->prepare('DELETE FROM grids WHERE id = ?');
		$succes = $del->execute(array($id));

		return $succes;
	}

	/**
	 * Permet d'obtenir l'id de l'auteur à partir de celui de la création
	 * @param  Int $id Id de la création
	 * @return int     Id de l'auteur
	 */
	public function getAuthorIdById($id)
	{
		$dataBase = $this->dbConnect('projet5');
		$request = $dataBase->prepare('SELECT author_id FROM grids WHERE id = ?');
		$request->execute(array($id));

		$author_id = $request->fetch();
		$author_id = $author_id[0];
		return $author_id;
	}

	/**
	 * Permet de liker une création
	 * @param  Int $id Id de la création likée
	 * @return Bool     Renvoie true si l'opération s'est bien effectuée
	 */
	public function like($id)
	{
		$dataBase = $this->dbConnect('projet5');
		$request = $dataBase->prepare('UPDATE grids SET likes=likes+1 WHERE id = ?');
		$succes = $request->execute(array($id));

		return $succes;
	}

	/**
	 * Rend la création invisible pour le dashbord de l'administrateur
	 * @param  Int $id Id de la création
	 */
	public function invisible($id)
	{
		$dataBase = $this->dbConnect('Projet5');
		$request = $dataBase->prepare('UPDATE grids SET visibility = 0 WHERE id = ?');
		$request->execute(array($id));
	}

	/**
	 * Permet d'obtenir toutes les créations visibles
	 * @return PDOStatment Les créations visibles
	 */
	public function getVisible()
	{
		$dataBase = $this->dbConnect('Projet5');
		$grids = $dataBase->query('SELECT * FROM grids WHERE visibility = 1 ORDER BY grid_date DESC');

		return $grids;
	}

	public function userDelete($id)
	{
		$dataBase = $this->dbConnect('Projet5');
		$request = $dataBase->prepare('DELETE FROM grids WHERE author_id = ?');
		$succes = $request->execute(array($id));

		return $succes;
	}
}