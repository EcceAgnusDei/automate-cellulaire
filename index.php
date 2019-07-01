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