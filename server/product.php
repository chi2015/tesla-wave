<?php
	include_once('../megavoltageadmin2/config.php');
	include_once('../conf.php');

	$action = isset($_POST['action']) ? $_POST['action'] : 'main';

	$product_id =  isset($_POST['product_id']) ? intval($_POST['product_id']) : MAIN_PRODUCT_ID;

	$link = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE)
        or die("Could not connect : " . mysqli_connect_error());

	switch ($action)
	{
		case 'list':
			$query = "SELECT p.product_id,
							 p.model,
							 p.price,
							 pd.name,
							 pd.description,
							 pd.kit_description,
							 p.stock_status_id,
							 ss.name AS status_name,
							 CASE WHEN p.product_id = 66 THEN 1 ELSE 0 END AS is_big,
                                                         (SELECT COUNT( 1 )
FROM oc_product_attribute pa
LEFT JOIN oc_attribute_description ad
USING ( attribute_id )
WHERE pa.product_id = p.product_id
AND pa.language_id =1
AND ad.language_id =1
AND ad.name LIKE 'video_%'
) AS video_cnt
					FROM oc_product p
					LEFT JOIN oc_product_description pd USING ( product_id )
					LEFT JOIN oc_stock_status ss USING ( stock_status_id)
					WHERE p.status = 1
					AND pd.language_id = 1 AND ss.language_id = 1 ORDER BY price";
			break;
		case 'photos':
			$query = "SELECT * FROM (SELECT product_image_id AS image_id, sort_order FROM oc_product_image WHERE product_id = ".$product_id."
			UNION SELECT product_id AS image_id, 0 AS sort_order FROM oc_product WHERE product_id = ".$product_id.") photos ORDER BY sort_order";
			break;
		case 'video':
			$query =  "SELECT ad.name, pa.text
					  	FROM oc_product_attribute pa LEFT JOIN oc_attribute_description ad
						USING ( attribute_id )
						WHERE pa.product_id = ".$product_id."
						AND pa.language_id =1
						AND ad.language_id =1
						AND ad.name LIKE 'video_%'
						LIMIT 1";
			break;
		case 'pics':
		case 'big_pics':
			$query = "SELECT product_image_id AS image_id FROM `oc_product_image` WHERE product_id = ".($action == 'big_pics' ? BIG_PRODUCT_ID : MAIN_PRODUCT_ID)." ORDER BY sort_order";
			break;

		case 'main':
		case 'big':
			$query = "SELECT p.model,
							 p.price,
							 pd.name,
							 pd.description,
							 p.product_id AS image_id,
							 p.stock_status_id,
							 ss.name AS status_name
					FROM oc_product p
					LEFT JOIN oc_product_description pd USING ( product_id )
					LEFT JOIN oc_stock_status ss USING ( stock_status_id)
					WHERE p.product_id = ".($action == 'big' ? BIG_PRODUCT_ID : MAIN_PRODUCT_ID)."
					AND pd.language_id = 1 AND ss.language_id = 1";
			break;

		case 'gallery_photo':
			$query = "(SELECT pi.product_image_id AS image_id, pa.text
						FROM oc_product_image pi
						LEFT JOIN oc_product_attribute pa
						USING ( product_id )
						LEFT JOIN oc_attribute_description ad ON ad.attribute_id = pa.attribute_id
						WHERE pi.product_id IN (SELECT product_id FROM oc_product WHERE status = 1)
						AND pa.language_id =1
						AND ad.language_id =1
						AND ad.name = pi.image
						ORDER BY pi.product_id, pi.sort_order)
						UNION
					  (SELECT p.product_id AS image_id, pa.text
					  	FROM oc_product p LEFT JOIN oc_product_attribute pa
						USING ( product_id )
						LEFT JOIN oc_attribute_description ad ON ad.attribute_id = pa.attribute_id
						WHERE p.product_id IN (SELECT product_id FROM oc_product WHERE status = 1)
						AND pa.language_id =1
						AND ad.language_id =1
						AND ad.name = p.image
						ORDER BY p.product_id)";
			break;

		case 'gallery_video':
			$query = "SELECT ad.name, pa.text
					  	FROM oc_product_attribute pa LEFT JOIN oc_attribute_description ad
						USING ( attribute_id )
						WHERE pa.product_id IN (SELECT product_id FROM oc_product WHERE status = 1)
						AND pa.language_id =1
						AND ad.language_id =1
						AND ad.name LIKE 'video_%'
						ORDER BY pa.product_id, pa.attribute_id";
			break;
	}

	$result = mysqli_query($link, $query) or
	die ("Select pics query failed: ".mysqli_error($link));

	$res = array();

	while ($line = mysqli_fetch_assoc($result))
	{
		$res[] = $line;
	}
	
	mysqli_free_result($result); 
	mysqli_close($link); 

    header('Access-Control-Allow-Origin: *');
	echo json_encode($res);

 ?>
