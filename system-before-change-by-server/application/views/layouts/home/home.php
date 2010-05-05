<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8;" />
<meta name="robots" content="index, follow" />
<meta name="keywords" content="" />

<meta name="description" content="" />
<meta name="generator" content="" />


<title><?= $title ?></title>

<link href="<?= base_url() ?>system/application/views/layouts/style/home.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>system/application/views/scripts/boxy/stylesheets/boxy.css" rel="stylesheet" type="text/css" />

<script src="<?= base_url() ?>system/application/assets/js/jquery.js"></script>
<script type="text/javascript" src="<?= base_url() ?>system/application/views/scripts/boxy/javascripts/jquery.boxy.js"></script>
<script type="text/javascript" src="<?= base_url() ?>system/application/views/scripts/generals.js"></script>

<?= $header ?>
</head>

<body>
	<center>
		<div class="header_bg">
		</div>
		<div class="container">
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
					$this->login->method(array("user" => $user, "lang" => $lang));
				?>
			</div>

			<div class="top_drivers">
			    <?php
			        if(is_array($top_users) && count($top_users) > 0) {
			    		foreach($top_users as $x => $k) {
			    ?>
			            <div class="top_driver_item">
			                <div class="top_driver_image">
				                <a href="<?= base_url() ?>profile/user/<?= $k->id ?>">
							    <?php
							        if($k->photo != "") {
							    ?>
							    	<img src="<?= base_url() ?>system/application/helpers/fa_image_helper.php?nw=35&nh=35&source=../views/layouts/images/users/<?= $k->photo ?>&stype=jpg&dest=x&type=little&dd=<?= date("YmdHis") ?>" border="0" />
								<?php
								    }
								    else {
							    ?>
							    	<img src="<?= base_url() ?>system/application/helpers/fa_image_helper.php?nw=35&nh=35&source=../views/layouts/images/users/default.jpg&stype=jpg&dest=x&type=little" border="0" />
								<?php
								    }
								?>
								</a>
				    		</div>
				    		<div class="top_driver_text">
				    		    <a href="<?= base_url() ?>profile/user/<?= $k->id ?>">
									<?= $k->first_name . " " . $k->last_name ?>
								</a><BR />
								<?= $lang['score'] . ": " . convert_number($k->score . "") ?>
				    		</div>
						</div>
			    <?php
			    		}
					}
			    ?>
			</div>
			
			
			
			<div class="center_first">
			    <div class="logan">
			    </div>
			    <div class="megane">
			    </div>
			    <div class="gogo">
			    </div>
			    <div class="best">
			    </div>
			    <div class="contact">
			    </div>
			</div>
			<div class="home_desc">
			    <?= $lang['home_desc'] ?>
			</div>
			<?= $body ?>
		</div>
		<?php
			$this->load->module('footer');
			$this->footer->method(array("lang" => $lang));
		?>
	</center>
	
	<script>
		$(document).ready(function()
		{
		    $(".top_cars_numbers_item").click( function() {
		        $(".car_image").fadeOut('fast');
		        $(".top_cars_numbers_item").css("background", "#757575");
		        $(this).css("background", "#a70000");
		        $("#" + this.id + "_view").fadeIn('fast');
			});
			
		    $(".home_link").click( function() {
		        window.location = "<?= base_url() ?>";
			});
		    $(".play_link").click( function() {
			    <?php
			        if($driver) {
			    ?>
			    		window.location = "<?= base_url() ?>rally/";
			    <?php
			        } else {
			    ?>
			    		window.location = "<?= base_url() ?>registration/";
			    <?php
			        }
			    ?>
			});
		    $(".renaults_link").click( function() {
		        window.location = "<?= base_url() ?>renault_list/";
			});
		    $(".ranks_link").click( function() {
		        window.location = "<?= base_url() ?>users_list/";
			});
		    $(".contact").click( function() {
		        window.location = "<?= base_url() ?>contact/";
			});
		    $(".prizes_link").click( function() {
		        window.location = "<?= base_url() ?>prize/";
			});
		    $(".howtoplay_link").click( function() {
		        window.location = "<?= base_url() ?>how_to_play/";
			});
			
			$('.gogo').click( function() {
			    <?php
			        if($driver) {
			    ?>
			    		window.location = "<?= base_url() ?>rally/";
			    <?php
			        } else {
			    ?>
			    		window.location = "<?= base_url() ?>registration/";
			    <?php
			        }
			    ?>
			});
			
			$('.logan').click( function() {
			    window.location = "<?= base_url() ?>prize/";
			});
			
			$('.megane').click( function() {
			    window.location = "<?= base_url() ?>drivers_list/";
			});
			
			$('.renault_home').click( function() {
			    window.open("http://renault.co.ir");
			});
			
			$("#car_0").trigger("click");
		});
	</script>
</body>
</html>
