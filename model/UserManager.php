<?php

require_once("Manager.php");

/**
 * Classe permetant de gérer les utilisateurs
 */
class UserManager extends Manager
{
	/**
	 * Enregistre l'utilisateur lors de son inscription
	 * @param  String $login    Identifiant de l'utilisateur
	 * @param  String $password Mot de passe de l'utilisateur
	 * @param  String $email    Mail de l'utilisateur
	 * @return Bool           Renvoie true si l'enregistrement s'est bien passé
	 */
	public function saveUser($login, $password,$email)
	{
		$dataBase = $this->dbConnect('projet5');
		$request = $dataBase->prepare('INSERT INTO users(login,password,email,signin_date) VALUES (?,?,?, NOW())');
		$succes = $request->execute(array($login, $password, $email));

		return $succes;
	}

	/**
	 * Obtient l'id de l'utilisateur
	 * @param  String $login    Identifiant
	 * @param  String $password Mot de passe
	 * @return PDOStatement           Id de l'utilisateur
	 */
	public function getId($login, $password)
	{
		$dataBase = $this->dbConnect('projet5');
		$request = $dataBase->prepare('SELECT id FROM users WHERE login = ? AND password = ?');
		$request->execute(array($login, $password));
		$id = $request->fetch();

		return $id;
	}
}