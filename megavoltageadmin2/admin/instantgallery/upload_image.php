<?php

	function upload_images()
	{
		$images = array();

		for ($i=0; $i<sizeof($_FILES['photos']['name']); $i++)
		{
			if ($_FILES['photos']['name'][$i])
				 $images[] = array('filename_original' => upload($_FILES['photos']['tmp_name'][$i]),
				 					'product_id' => $_POST['products'][$i],
				 					'desc' => $_POST['desc'][$i]);
		}

		foreach ($images as &$image)
		{
             $dest = '../../image/data/';
	      $dest_db = 'data/';
             $folder = '';

             switch ($image['product_id'])
             {
             	case 65: $folder .= 'dancecoil/'; break;
             	case 66: $folder .= 'bigcoils/'; break;
             	case 67: $folder .= 'minicoil/'; break;
             	case 68: $folder .= 'democoil/'; break;
             }

             $dest_db .= $folder.basename($image['filename_original']);
	      $dest .= $folder.basename($image['filename_original']);

             resize($image['filename_original'], $dest);
		unset($image['filename_original']);
             $image['filename'] = $dest_db;
		}

		return $images;
	}

	function upload($filename)
	{
		if (!file_exists("uploads")) mkdir("uploads", 0777);

		 $dataFile = "uploads/".substr(md5(time().basename($filename).rand(0,100)), 0, 8).".jpg";
			 move_uploaded_file($filename, $dataFile);

		 return $dataFile;
	}

	function resize($filename, $dest)
	{
		exec('php resize_image.php '.$filename.' '.$dest);
	}

?>