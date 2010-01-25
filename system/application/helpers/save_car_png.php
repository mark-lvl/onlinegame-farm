<?php
//	print_r($_POST['img']);
//	die("XXX");
    $data = explode(",", $_POST['img']);
    $width = $_POST['width'];
    $height = $_POST['height'];
	
    $image=imagecreatetruecolor($width, $height);
    imagealphablending($image, true);
    
    $i = 0;
    for($x=0; $x<=$width; $x++){
        for($y=0; $y<=$height; $y++){
            $int = hexdec($data[$i++]);
            $color = imagecolorallocate($image, 0xFF & ($int >> 0x10), 0xFF & ($int >> 0x8), 0xFF & $int);
            imagesetpixel($image, $x, $y, $color);
        }
    }

    imagepng($image, "../views/layouts/images/cars/" . md5($_POST['user_id']) . ".png");

    header("Location: http://192.168.1.3/renault/gateway/set_drivers_car/" . $_POST['user_id']);
    die();
?>