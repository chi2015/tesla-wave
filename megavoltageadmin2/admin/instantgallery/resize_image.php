<?php

		define('MAX_UPLOAD_SIZE', 300000);
	
		$filename = $argv[1];
		$destfile = $argv[2];

	       $imagesize = filesize($filename);
		list($width, $height) = getimagesize($filename);


		$percent = sqrt(MAX_UPLOAD_SIZE / $imagesize);
		$newwidth = intval($width * $percent);
		$newheight = intval($height * $percent);


              $src = imagecreatefromjpeg($filename);
		$dst = imagecreatetruecolor($newwidth, $newheight);

    		imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		unlink($filename);
		imagejpeg($dst, $destfile);

	

?>