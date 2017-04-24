<?php
	include_once('../../../megavoltageadmin2/config.php');
	include_once('../../../conf.php');

	$link = mysql_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD)
		        or die("Could not connect : " . mysql_error());

	function get_products_list()
	{
		global $link;
		global $_AVAILABLE_PRODUCTS;

    	mysql_select_db(DB_DATABASE) or die("Could not select database");

    	$query = "SELECT p.product_id,
							 pd.name
					FROM oc_product p
					LEFT JOIN oc_product_description pd USING ( product_id )
					WHERE 
					p.product_id IN (".join(",",$_AVAILABLE_PRODUCTS).") AND 
					pd.language_id = 1 ORDER BY product_id";
					
		

					$result = mysql_query($query) or
						die ("Select pics query failed");

			$res = array();

			while ($line = mysql_fetch_assoc($result))
			{
				$res[] = $line;
			}

		return $res;
	}

	function add_product_images($images)
	{
		 global $link;

		 mysql_select_db(DB_DATABASE) or die("Could not select database");

		 foreach ($images as $image)
		 {
		 	$query_ins_attr = "INSERT INTO oc_attribute ( attribute_group_id, 	sort_order)
		 	VALUES (4,1)";

		 	$result = mysql_query($query_ins_attr) or
						die ("ERROR: Insert attrs query failed");

			$attr_id = mysql_insert_id($link);

			$query_ins_attr_desc = "INSERT INTO  oc_attribute_description
								   (attribute_id, language_id, name)
							VALUES ($attr_id, 1, '".$image['filename']."'),
				   				   ($attr_id, 2, '".$image['filename']."')";

			$result = mysql_query($query_ins_attr_desc) or
						die ("ERROR: Insert attr desc query failed");

			$query_ins_product_attribute = "INSERT INTO oc_product_attribute
										    (product_id, attribute_id, language_id, text)
									VALUES  (".$image['product_id'].", $attr_id, 1, '".$image['desc']."'),
										    (".$image['product_id'].", $attr_id, 2, 'Some desc here')";

		 			$result = mysql_query($query_ins_product_attribute) or
						die ("ERROR: Insert product attr");

			$query_sel_max_order = "SELECT MAX(sort_order) AS max_order FROM oc_product_image WHERE product_id=".$image['product_id'];

			$result = mysql_query($query_sel_max_order) or
						die ("ERROR: Select max order");

			$row = mysql_fetch_assoc($result);
			$max_order = isset($row['max_order']) ? $row['max_order'] : 0;
			$sort_order = $max_order + 1;

		    $query_ins_product_img = "INSERT INTO oc_product_image (product_id, image, sort_order)
		    VALUES(".$image['product_id'].",
		           '".$image['filename']."',
		           $sort_order)";

		    	$result = mysql_query($query_ins_product_img) or
						die ("ERROR: Insert product image");



		 }

		 return true;
	}

?>
