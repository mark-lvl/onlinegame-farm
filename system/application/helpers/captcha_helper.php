<?php
if ( ! function_exists('load_captcha')) {
	function load_captcha(& $title, & $output, $lang, $captcha_images_number = 4, $enclosure = "&nbsp;") {
	    $images = array("basket", "corn", "gourd", "plant", "shovel", "sun", "sunflower", "tomato", "watercan", "wheat");
	    $images_name = array($lang['basket'], $lang['corn'], $lang['gourd'], $lang['plant'], $lang['shovel'], $lang['sun'], $lang['sunflower'], $lang['tomato'], $lang['watercan'], $lang['wheat']);
	    $chosen_nums = array(); //Chosen numbers
	    $chosen_images = array(); //Chosen images
	    
	    $cnt = count($images);
	    
	    if($captcha_images_number >= $cnt) {
	        return FALSE;
	    }
		for($i = 0; $i < $captcha_images_number; $i++) {
		    $rnd = mt_rand(0, $cnt - 1);
		    if(array_search($rnd, $chosen_nums) === FALSE) {
		    	$chosen_nums[] = $rnd;
		    	$chosen_images[] = $images[$rnd];
		    	$output .= "<img class='captcha_img' title='" . $i . "' src='" . css_url() . "system/application/assets/images/registration/captcha/" . $images[$rnd] . ".png' />" . $enclosure;
		    }
		    else {
		        $i--;
		    }
		}
		$rnd = mt_rand(0, $captcha_images_number - 1);
		$title = "<span class=\"captchaText\"><B>" . $images_name[$chosen_nums[$rnd]] . "</B>" .  $lang['captcha_choose']."</span>";
		
		$_SESSION['captcha'] = $rnd;
		
	    return $rnd;
	}
}