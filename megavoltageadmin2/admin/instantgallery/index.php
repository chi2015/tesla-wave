<?php
session_start();
ini_set('display_errors', '1');
include('products_db.php');
include('upload_image.php');
define('PHOTOS_COUNT_TO_LOAD', 1);

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

	$success_location = 'location: http://tesla-wave.ru/megavoltageadmin2/admin/instantgallery/?success=1';
	$fail_location = 'location: http://tesla-wave.ru/megavoltageadmin2/admin/instantgallery/?fail=1';

	if (isset($_POST['action']) && $_POST['action'] == 'upload_photos')
	{
		$images = upload_images();

		if (is_array($images))
		{
			if (add_product_images($images)) header($success_location);  else header($fail_location);
		}
		else header($fail_location);
	}

	echo mainView();

	function mainView()
	{
		$products_list = get_products_list();

		$products_list_options = '';

		foreach ($products_list as $product)
			   $products_list_options .= '<option value="'.$product['product_id'].'">'.$product['name'].'</option>';

		$table_trs = '';

		for ($i=0; $i<PHOTOS_COUNT_TO_LOAD; $i++)
			$table_trs .= '<tr>     	 <td><select name="products['.$i.']" style="width:350px;">'.$products_list_options.'
									</select></td>
								<td><input type="file" name="photos['.$i.']" style="width:250px;"/></td>
				                            <td><input type="text" name="desc['.$i.']" style="width:500px;"/></td>

							</tr>';

		$ret = '';
		$ret .= '<html>
					<head>
						<meta charset="UTF-8"/>
						<title>Добавление фотографий в галерею</title>
						<link rel="stylesheet" type="text/css" href="style.css" />
				       </head>
					<body>
						'.(isset($_GET['fail']) ? '<b><font color="red">Ошибка загрузки фотографий</font></b>'  : '').'
						'.(isset($_GET['success']) ? '<b><font color="green">Фотографии успешно загружены</font></b>'  : '').'
						<form action="index.php" method="post" enctype="multipart/form-data">
						<table class="simple-little-table" width="1200px">
							<tr>
							<th>Товар</th>
								<th>Файл фотографии<font color="#009966">*</font></th>
								<th>Описание</th>
							</tr>'.$table_trs.'
						</table>
						<div class="photo_notice">* - фотография может иметь только расширение JPG (JPEG)</div>
						<input type="hidden" name="action" value="upload_photos"/>
						<input type="submit" value="Отправить"/>
						</form>
						<a href="http://tesla-wave.ru/megavoltageadmin2/admin">Вернуться в администраторский раздел</a>
					</body>
				</html>';

		return $ret;
	}

    ini_set('display_errors', '0');

	?>
