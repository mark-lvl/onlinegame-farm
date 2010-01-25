<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8;" />
<meta name="robots" content="index, follow" />
<meta name="keywords" content="بازی, آنلاین, سرگرمی, رنو, مگان, لوگان, تندر90, مسابقه, جایزه" />

<meta name="description" content="در رالی رنو شرکت کنید, مسابقه دهید و جایزه ببرید" />
<meta name="generator" content="فواد امیری" />

<!--
	Company: Parspake Solutions
	Website: www.parspake.com

    Web analysts:
    	Fouad Amiri (http://fouad.ir)
    	Sassan Behzadi

    Web programmer:
    	Fouad Amiri

    Database programmer / Analyst:
    	Fouad Amiri

    Graphic designer:
    	Arash KhosroNejad

    Flash designer:
    	HamidReza amlah

	Version: 0.1
	2009
	Iran, Tehran
-->

<title><?= $title ?></title>

<link href="<?= base_url() ?>system/application/views/layouts/style/inside.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>system/application/views/scripts/boxy/stylesheets/boxy.css" rel="stylesheet" type="text/css" />

<script src="<?= base_url() ?>system/application/views/scripts/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>system/application/views/scripts/boxy/javascripts/jquery.boxy.js"></script>
<script type="text/javascript" src="<?= base_url() ?>system/application/views/scripts/generals.js"></script>

<?= $header ?>
</head>

<body>
	<center>
		<div class="header_bg">
		</div>
		<div class="container">
		    <?php
		        if(!isset($hide_header) || !$hide_header) {
		    ?>
					<div class="container_header">
					    <div class="renault_home">
					    </div>
						<div class="left_menu">
						    <a class="little_link" href="<?= base_url() ?>">
						        <?= $lang['home'] ?>
						    </a>
							:
						    <a class="little_link" href="<?= base_url() ?>policy/">
						        <?= $lang['laws'] ?>
						    </a>
							:
						    <a class="little_link" href="http://renault.co.ir" target="_blank">
						        <?= $lang['renault'] ?>
						    </a>
						    :
						    <a class="little_link" href="<?= base_url() ?>contact/">
						        <?= $lang['contact'] ?>
						    </a>
						</div>
						<div class="title">
						</div>
						<div class="home_link">
						</div>
						<div class="ranks_link">
						</div>
						<div class="renaults_link">
						</div>
						<div class="howtoplay_link">
						</div>
						<div class="prizes_link">
						</div>
						<div class="play_link">
						</div>
						<?php
							$this->load->module('login');
							if(!isset($driver)) {
							    $driver = FALSE;
							}
							$this->login->method(array("driver" => $driver, "lang" => $lang));
						?>
					</div>
			<?php
			    }
			    else {
		    ?>
		    		<div class="container_header" style="width:200px; float:left;">
						<?php
							$this->load->module('login');
							if(!isset($driver)) {
							    $driver = FALSE;
							}
							$this->login->method(array("driver" => $driver, "lang" => $lang));
						?>
					</div>
			<?php
			    }
			?>
			<?= $body ?>
		</div>
		<?php
			$this->load->module('footer');
			$this->footer->method(array("lang" => $lang));
		?>
	</center>
	<script>
	$(function(){
	    $(".home_link").click( function() {
	        window.location = "<?= base_url() ?>";
		});
	    $(".play_link").click( function() {
	        window.location = "<?= base_url() ?>rally/";
		});
	    $(".renaults_link").click( function() {
	        window.location = "<?= base_url() ?>renault_list/";
		});
	    $(".ranks_link").click( function() {
	        window.location = "<?= base_url() ?>drivers_list/";
		});
	    $(".prizes_link").click( function() {
	        window.location = "<?= base_url() ?>prize/";
		});
	    $(".howtoplay_link").click( function() {
	        window.location = "<?= base_url() ?>how_to_play/";
		});
		
		$('.renault_home').click( function() {
		    window.open("http://renault.co.ir");
		});
	});
	</script>
</body>
</html>
