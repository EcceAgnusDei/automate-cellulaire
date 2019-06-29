<?php

require_once("Manager.php");

/**
 * Classe permetant de gérer les articles.
 */
class GridManager extends Manager
{
	/**
	 * Méthode permettant d'obtenir l'ensemble des articles.
	 * @return PDOStatement Requête obtenue à partir de la table posts.
	 */
	public function save($json)
	{
		$dataBase = $this->dbConnect('projet5');
		$request = $dataBase->prepare('INSERT INTO grids(json,grid_date) VALUES (?, NOW())');
		$succes = $request->execute(array($json));

		return $succes;
	}

	public function load($id)
	{
		$dataBase = $this->dbConnect('projet5');
		$request = $dataBase->prepare('SELECT * FROM grids WHERE id = ?');
		$request->execute(array($id));
		$grid = $request->fetch();

		return $grid;
	}

	public function getGrids()
	{
		$dataBase = $this->dbConnect('projet5');
		$request = $dataBase->query('SELECT id, name, author, DATE_FORMAT(grid_date, \'%d/%m/%Y à %Hh%imin\') AS grid_date_fr FROM grids ORDER BY id DESC');

		return $request;
	}
}