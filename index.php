<?php
if(session_status() == PHP_SESSION_NONE)
{
    session_start();
}
require('controller/clientController.php');
require('controller/adminController.php');

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
				save($_POST['grid-json'], $_SESSION['userid'], $_POST['name']);
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
			break;
			case 'signinview':
			{
				signinView();
			}
			break;

			case 'signin':
			{
				signin(htmlspecialchars($_POST['signin-login']), htmlspecialchars($_POST['signin-password']), htmlspecialchars($_POST['signin-email']));
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

			case 'passwordforgotten':
			{
				
			}
			break;
			
			case 'griddelete':
			{
				if (isset($_GET['id']) && $_GET['id'] > 0) 
				{
					if (isset($_SESSION['userid']))
					{
						gridDelete($_GET['id'], $_SESSION['userid']);
					}
				}
				else 
				{
					throw new Exception('Aucun identifiant de grid envoyé');
				}
			}
			break;

			case 'addcomment':
			{
				if (isset($_GET['id']) && $_GET['id'] > 0) 
				{
					if (isset($_SESSION['userid']))
					{
						addComment($_GET['id'], $_SESSION['userid'], htmlspecialchars($_POST['comment-content']));
					}
				}
				else 
				{
					throw new Exception('Aucun identifiant de grid envoyé');
				}
			}
			break;
		
			case 'gridlike':
			{
				if (isset($_GET['id']) && $_GET['id'] > 0) 
				{
					gridLike($_GET['id'], $_SESSION['userid']);
				}
				else 
				{
					throw new Exception('Aucun identifiant de grid envoyé');
				}
			}
			break;

			case 'commentlike':
			{
				if (isset($_GET['id']) && $_GET['id'] > 0) 
				{
					commentLike($_GET['id'], $_SESSION['userid']);
				}
				else 
				{
					throw new Exception('Aucun identifiant de commentaire envoyé');
				}
			}
			break;

			case 'commentdislike':
			{
				if (isset($_GET['id']) && $_GET['id'] > 0) 
				{
					commentDislike($_GET['id'], $_SESSION['userid']);
				}
				else 
				{
					throw new Exception('Aucun identifiant de commentaire envoyé');
				}
			}
			break;

			case 'adminidentifying':
			{
				if ($_POST['login'] == 'admin' && $_POST['password'] == 'admin')
				{
					admin();
				}
				else
				{
					adminLogingError();
				}
			}
			break;

			case 'adminlogin':
			{
				if(isset($_SESSION['admin']))
				{
					header('location: index.php?adminaction=gridsview');
				}
				else
				{
					adminLogin();
				}
			}
			break;
		}
	}
	elseif (isset($_GET['adminaction']))
	{
		if (isset($_SESSION['admin']))
		{
			switch ($_GET['adminaction'])
			{
				case 'adminlogout':
				{
					userLogout();
				}
				break;

				case 'gridsview':
				{
					adminGridView();
				}
				break;

				case 'commentsbydateview':
				{
					commentsByDateView();
				}
				break;

				case 'commentsbydislikesview':
				{
					commentsByDislikesView();
				}
				break;

				case 'griddelete':
				{
					if (isset($_GET['id']) && $_GET['id'] > 0) 
					{
						adminGridDelete($_GET['id']);
					}
					else 
					{
						throw new Exception('Aucun identifiant de grid envoyé');
					}	
				}
				break;

				case 'commentdelete':
				{
					if (isset($_GET['id']) && $_GET['id'] > 0) 
					{
						adminCommentDelete($_GET['id']);
					}
					else 
					{
						throw new Exception('Aucun identifiant de commentaire envoyé');
					}
				}
				break;

				case 'commentwithgrid':
				{
					
				}
			}
		}
		else
		{
			throw new Exception('Vous n\'avez pas les droits nécessaires');
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