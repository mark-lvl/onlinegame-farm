<?php
	
	header('Content-type: image/jpg');

	$image = imagecreatefromjpeg("bg.jpg");

	$watermark = imagecreatefrompng("ss12.png");
	$size = getimagesize("ss12.png");
	$w = $size[0];
	$h = $size[1];
	
    $color = imagecolorallocate($watermark, 255, 255, 255);
    imagecolortransparent($watermark, $color);

	imagecopymerge($image, $watermark, 10, 10, 0, 0, $w, $h, 100);

    imagejpeg($image, "bgx.jpg", 100);
?>