<?php

require_once("Manager.php");

/**
 * Classe permetant de gérer les créations.
 */
class GridManager extends Manager
{
	public function save($json, $id, $name)
	{
		$dataBase = $this->dbConnect('projet5');
		$request = $dataBase->prepare('INSERT INTO grids(json,author_id, name,grid_date) VALUES (?,?,?, NOW())');
		$succes = $request->execute(array($json, $id, $name));

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

	public function getGridsByDate()
	{
		$dataBase = $this->dbConnect('projet5');
		$request = $dataBase->query('SELECT id, name,json, likes, author_id, DATE_FORMAT(grid_date, \'%d/%m/%Y à %Hh%imin\') AS grid_date_fr FROM grids ORDER BY grid_date DESC');

		return $request;
	}

	public function getGridsByLikes()
	{
		$dataBase = $this->dbConnect('projet5');
		$request = $dataBase->query('SELECT id, name,json, likes, author_id, DATE_FORMAT(grid_date, \'%d/%m/%Y à %Hh%imin\') AS grid_date_fr FROM grids ORDER BY likes DESC');

		return $request;
	}

	public function getGridsByAuthorId($id)
	{
		$dataBase = $this->dbConnect('projet5');
		$request = $dataBase->prepare('SELECT id, name, likes, DATE_FORMAT(grid_date, \'%d/%m/%Y à %Hh%imin\') AS grid_date_fr FROM grids WHERE author_id = ? ORDER BY id DESC');
		$request->execute(array($id));

		return $request;
	}

	public function delete($id)
	{
		$dataBase = $this->dbConnect('projet5');
		$del = $dataBase->prepare('DELETE FROM grids WHERE id = ?');
		$succes = $del->execute(array($id));

		return $succes;
	}

	public function getAuthorIdById($id)
	{
		$dataBase = $this->dbConnect('projet5');
		$request = $dataBase->prepare('SELECT author_id FROM grids WHERE id = ?');
		$request->execute(array($id));

		$author_id = $request->fetch();
		$author_id = $author_id[0];
		return $author_id;
	}

	public function like($id)
	{
		$dataBase = $this->dbConnect('projet5');
		$request = $dataBase->prepare('UPDATE grids SET likes=likes+1 WHERE id = ?');
		$succes = $request->execute(array($id));

		return $succes;
	}

	public function invisible($id)
	{
		$dataBase = $this->dbConnect('Projet5');
		$request = $dataBase->prepare('UPDATE grids SET visibility = 0 WHERE id = ?');
		$request->execute(array($id));
	}

	public function getVisible()
	{
		$dataBase = $this->dbConnect('Projet5');
		$grids = $dataBase->query('SELECT * FROM grids WHERE visibility = 1 ORDER BY grid_date DESC');

		return $grids;
	}
}