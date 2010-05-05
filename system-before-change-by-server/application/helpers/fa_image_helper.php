<?php
header('Content-type: image/jpg');
$ob = new image_cropper();
$nw = (int) ($_GET['nw']);
$nh = (int) ($_GET['nh']);
$ob->crop_image($nw, $nh, $_GET['source'], $_GET['stype'], $_GET['dest'], $_GET['type']);
class image_cropper
{
	function crop_image($nw, $nh, $source, $stype, $dest, $type = "big")
	{
		$size = getimagesize($source);
		$w = $size[0];
		$h = $size[1];
		switch($stype)
		{
			case 'gif':
				$simg = imagecreatefromgif($source);
				break;
			case 'jpg':
				$simg = imagecreatefromjpeg($source);
				break;
			case 'png':
				$simg = imagecreatefrompng($source);
				break;
		}
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
			imagejpeg($dimg);
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
			imagejpeg($dimg);
		}
	}
}
?>