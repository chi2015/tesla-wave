<?php
session_start();

if (isset($_GET['logout']))
{
	    unset($_SESSION["login"]);
}

if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SESSION["login"])) {
   	 header('WWW-Authenticate: Basic realm="Playlist Project"');
   	 header('HTTP/1.0 401 Unauthorized');
   	 echo 'Authentification needed';
    	 $_SESSION["login"] = 1;
    	exit;
	}

	if ($_SERVER['PHP_AUTH_USER']!='chi' || $_SERVER['PHP_AUTH_PW']!='6660913SeRj!')
	{

		header('WWW-Authenticate: Basic realm="Enter to the authentification zone!"');
   	 	header('HTTP/1.0 403 Forbidden');
   	 	echo 'You have no rights to view this page';
        unset($_SESSION["login"]);

    	exit;

	}
	ini_set('display_errors', '1');
	//include('example.php');
	include('bookmarks.php');
	ini_set('display_errors', '0');


?>