<?php
	header('Content-type: image/jpg');

	$image = imagecreatefromjpeg("../views/layouts/images/cars/" . $_GET['bg']);

	$size2 = getimagesize("../views/layouts/images/cars/" . $_GET['bg']);
	$w2 = $size2[0];
	$h2 = $size2[1];
	
	$watermark = imagecreatefrompng("../views/layouts/images/cars/" . md5($_GET['driver_id']) . ".png");
	$size = getimagesize("../views/layouts/images/cars/" . md5($_GET['driver_id']) . ".png");
	$w = $size[0];
	$h = $size[1];

    $color = imagecolorallocate($watermark, 255, 255, 255);
    imagecolortransparent($watermark, $color);

	imagecopymerge($image, $watermark, $_GET['left'], $_GET['top'], 0, 0, $w, $h, 100);

    if(isset($_GET['nw']) && isset($_GET['nh'])) {
		$ob = new image_cropper2();
		$nw = (int) ($_GET['nw']);
		$nh = (int) ($_GET['nh']);
		$ob->crop_image($nw, $nh, $image, $w2, $h2);
	}
	else {
		imagejpeg($image, NULL, 92);
	}
	
	class image_cropper2 {
		function crop_image($nw, $nh, $source, $w, $h, $type = "little")
		{
			$simg = $source;
			
			$dimg = imagecreatetruecolor($nw, $nh);
			$wm = $w/$nw;
			$hm = $h/$nh;
			$h_height = $nh/2;
			$w_height = $nw/2;
			$ow = ($nw - $w) / 2;
			$oh = ($nh - $h) / 2;
			if($type == "big")
			{
				imagecopy($dimg,$simg,0,0,-$ow,-$oh,$nw,$nh);
				imagejpeg($dimg, NULL, 92);
			}
			else
			{
				if($w> $h)
				{
					$adjusted_width = $w / $hm;
					$half_width = $adjusted_width / 2;
					$int_width = $half_width - $w_height;
					imagecopyresampled($dimg,$simg,-$int_width,0,0,0,$adjusted_width,$nh,$w,$h);
				}
				elseif(($w <$h) || ($w == $h))
				{
					$adjusted_height = $h / $wm;
					$half_height = $adjusted_height / 2;
					$int_height = $half_height - $h_height;
					imagecopyresampled($dimg,$simg,0,-$int_height,0,0,$nw,$adjusted_height,$w,$h);
				}
				else
				{
					imagecopyresampled($dimg,$simg,0,0,0,0,$nw,$nh,$w,$h);
				}
				imagejpeg($dimg, NULL, 92);
			}
		}
	}
?>