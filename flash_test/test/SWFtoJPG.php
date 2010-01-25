<?php
	
	/**
	 * The class picks the Flash data and convert it into JPG image and saves it with the name convert.jpg
	 *
	 */
	class SWFtoJPG {
		/**
		 * The method uses GD library to convert Flash image to JPG.
		 *
		 */
		public function drawImage($data) {
			
			$image=imagecreatetruecolor(400,400);
			$imagelines=imagecreate(400,400);
			$background=imagecolorallocate($imagelines,255,255,255);
			$linecolor=imagecolorallocate($imagelines,0,0,0);
			
			$lines=explode("-",$data);
			for($l=0;$l<count($lines)-1;$l++){
			  $lineData=explode(";",$lines[$l]);
			  imageline($imagelines,$lineData[0],$lineData[1],$lineData[2],$lineData[3],$linecolor);

			}
			imagecopyresampled($image,$imagelines,0,0,0,0,400,400,400,400);
			imagejpeg($image,"created.jpg");
			imagedestroy($image);
			imagedestroy($imagelines);
			
			
		}
	}
	

?>