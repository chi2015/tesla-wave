<?php
session_start();

if (isset($_GET['logout']))
{
	    unset($_SESSION["login"]);
}

if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SESSION["login"])) {
   	 header('WWW-Authenticate: Basic realm="Instant Gallery"');
   	 header('HTTP/1.0 401 Unauthorized');
   	 echo 'Authentification needed';
   	 $_SESSION["login"] = 1;
    	exit;
	}

	if ($_SERVER['PHP_AUTH_USER']!='megavoltageadmin' || $_SERVER['PHP_AUTH_PW']!='54jlHyVhGbo45WYby')
	{

		header('WWW-Authenticate: Basic realm="Instant Gallery"');
   	 	header('HTTP/1.0 403 Forbidden');
   	 	echo 'You have no rights to view this page';
        unset($_SESSION["login"]);

    	exit;

	}
	$success_location = 'location: http://tesla-wave.ru/megavoltageadmin2/admin/hello/?success=1';
	$fail_location = 'location: http://tesla-wave.ru/megavoltageadmin2/admin/hello/?fail=1';

	if (isset($_POST['action']) && $_POST['action'] == 'update_hello')
	{
		if (isset($_POST['hello']) && $_POST['hello']!='')
		{
			file_put_contents('hello.txt', $_POST['hello']);
			header($success_location);
		}
		else header($fail_location);

	}
?>
<html>
	<head>
		<meta charset="windows-1251"/>
		<title>Редактирование приветствия сайта</title>
		<link rel="stylesheet" type="text/css" href="style.css" />
	</head>
	<body>
	<?php if (isset($_GET['fail'])) echo '<b><font color="red">Ошибка редактирования приветствия</font></b>'; ?>
	<?php if (isset($_GET['success'])) echo '<b><font color="green">Приветствие успешно отредактировано</font></b>'; ?>
	<form action="index.php" method="post" enctype="multipart/form-data">
    	<div>Текст приветствия сайта:</div>
    	<textarea name="hello"><?php echo file_get_contents("hello.txt"); ?></textarea>
    	<br/>
    	<input type="hidden" name="action" value="update_hello"/>
    	<input type="submit" value="Сохранить"/>
    </form>
    <a href="http://tesla-wave.ru/megavoltageadmin2/admin">Вернуться в администраторский раздел</a>
</html>