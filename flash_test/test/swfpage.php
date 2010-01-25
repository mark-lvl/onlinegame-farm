<?php
	if ($HTTP_POST_VARS["thisLetter"] != null || $HTTP_POST_VARS["thisLetter"] != "") {
		include_once("SWFtoJPG.php");
		SWFtoJPG::drawImage($HTTP_POST_VARS["thisLetter"]);
		$img = "created.jpg";
	} else {
		$img = "notfound.jpg";
	}
?>
<html>
	<head>
		<title>JPG image from SWF</title>
	</head>
	<body bgColor='#BCABD0'>
		<center>JPG image from SWF
			<p><img src='<?php echo $img?>'>
		</center>
	</body>
</html>
