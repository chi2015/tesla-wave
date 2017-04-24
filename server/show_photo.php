<?php

if (isset($_GET['id']))
{
	include_once('../megavoltageadmin2/config.php');
	include_once('../conf.php');

    $link = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE)
        or die("Could not connect : " . mysqli_connect_error());

   $id = intval($_GET['id']);
   $query_get_photo = "SELECT image FROM oc_product_image WHERE product_image_id = $id
                 UNION SELECT image FROM oc_product WHERE product_id = $id";

  $result = mysqli_query($link, $query_get_photo) or
	die ("Get query failed: " . mysqli_error($link));

	$row = mysqli_fetch_row($result);

    header('Access-Control-Allow-Origin: *');
	header('Content-type: image/jpg');
	echo file_get_contents(GLOBAL_IMAGE_PATH.$row[0]);
	die();
}


?>
