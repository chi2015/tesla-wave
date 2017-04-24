<?php
	include_once('../megavoltageadmin2/config.php');
	include_once('../conf.php');

	$link = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE)
        or die("Could not connect : " . mysqli_connect_error());

       $query_pics = "SELECT * FROM `oc_product_image` WHERE product_id = ".PRODUCT_ID;

	$result_pics = mysqli_query($link, $query_pics) or
	die ("Select pics query failed: ". mysqli_error($link));

	$res_pics = array();

	while ($line_pics = mysqli_fetch_assoc($result_pics))
	{		$res_pics[] = $line_pics;
	}
	
	mysqli_free_result($result_pics); 
	mysqli_close($link);

	header('Access-Control-Allow-Origin: *');
        echo json_encode($res_pics);

 ?>
