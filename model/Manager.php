<?php

/**
 * Classe mère permettant la connexion à une base de donnée
 */
class Manager
{
	/**
 	* Crée une connexion avec la base de donnée
 	* @param string $dbName Nom de la base de données
	* @return PDO Objet de la connexion
 	*/
	protected function dbConnect($dbName)
	{
		$dataBase = new PDO('mysql:host=localhost;dbname=' . $dbName . ';charset=utf8', 'root', '');
		return $dataBase;
	}
}