<?php
require('controller/clientController.php');

try
{
	if (isset($_GET['action']))
	{
		switch ($_GET['action'])
		{
			case 'play':
			{
				playView();
			}
			break;
		
			case 'save':
			{
				save($_POST['grid-json']);
			}
			break;

			case 'load':
			{
				if (isset($_GET['id']) && $_GET['id'] > 0) 
				{
					load($_GET['id']);
				}
				else 
				{
					throw new Exception('Aucun identifiant de grid envoyé');
				}
			}
			break;

			case 'showgrids':
			{
				showGrids();
			}

			case 'signinview':
			{
				require('view/frontend/signinView.php');
			}
			break;

			case 'signin':
			{
				signin($_POST['signin-login'], $_POST['signin-password'], $_POST['signin-email']);
			}
			break;

			case 'useridentifying':
			{
				userIdentifying($_POST['user-login'],$_POST['user-password']);
			}
			break;

			case 'userspace':
			{
				userSpaceView($_SESSION['userid']);
			}
			break;

			case 'userlogout':
			{
				userLogout();
			}
			break;
		}
	}
	else
	{
		require('view/frontend/homeView.php');
	}
}
catch (Exception $e)
{
	$errorMessage = $e->getMessage();
	require('view/frontend/errorView.php');
}