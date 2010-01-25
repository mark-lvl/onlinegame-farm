<?php
	//header('Content-type: image/jpg');
	
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
    
    imagepng($image, "ss12.png");
    
    header("Location: http://192.168.1.3/renault/");
    die();
?>