<?php
require_once('../../model/UserManager.php');

$userManager = new UserManager();
$request = $userManager->getUsers();

$userLogins = [];

while ($data = $request->fetch())
{
	array_push($userLogins, $data['login']);
}

echo json_encode($userLogins);