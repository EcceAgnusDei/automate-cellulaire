<?php

require_once("Manager.php");

/**
 * Classe permetant de gérer les utilisateurs
 */
class UserManager extends Manager
{
	
	public function saveUser($login, $password,$email)
	{
		$dataBase = $this->dbConnect('projet5');
		$request = $dataBase->prepare('INSERT INTO users(login,password,email,signin_date) VALUES (?,?,?, NOW())');
		$succes = $request->execute(array($login, $password, $email));

		return $succes;
	}

	public function getId($login, $password)
	{
		$dataBase = $this->dbConnect('projet5');
		$request = $dataBase->prepare('SELECT id FROM users WHERE login = ? AND password = ?');
		$request->execute(array($login, $password));
		$id = $request->fetch();

		return $id;
	}
}