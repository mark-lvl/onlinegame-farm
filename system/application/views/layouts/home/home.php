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

<link href="<?= base_url() ?>system/application/views/layouts/style/home.css" rel="stylesheet" type="text/css" />
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
					$this->login->method(array("driver" => $driver, "lang" => $lang));
				?>
			</div>

			<div class="top_drivers">
			    <?php
			        if(is_array($top_drivers) && count($top_drivers) > 0) {
			    		foreach($top_drivers as $x => $k) {
			    ?>
			            <div class="top_driver_item">
			                <div class="top_driver_image">
				                <a href="<?= base_url() ?>profile/driver/<?= $k->id ?>">
							    <?php
							        if($k->photo != "") {
							    ?>
							    	<img src="<?= base_url() ?>system/application/helpers/fa_image_helper.php?nw=35&nh=35&source=../views/layouts/images/drivers/<?= $k->photo ?>&stype=jpg&dest=x&type=little&dd=<?= date("YmdHis") ?>" border="0" />
								<?php
								    }
								    else {
							    ?>
							    	<img src="<?= base_url() ?>system/application/helpers/fa_image_helper.php?nw=35&nh=35&source=../views/layouts/images/drivers/default.jpg&stype=jpg&dest=x&type=little" border="0" />
								<?php
								    }
								?>
								</a>
				    		</div>
				    		<div class="top_driver_text">
				    		    <a href="<?= base_url() ?>profile/driver/<?= $k->id ?>">
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
			
			<div class="top_cars">
			    <?php
			        if(is_array($top_cars) && count($top_cars) > 0) {
			            ?>
			            <div class="top_cars_numbers">
						<?php
							foreach($top_cars as $x => $k) {
						?>
			                <div class="top_cars_numbers_item" id="car_<?= $x ?>">
			                    <?= $x + 1 ?>
			                </div>
						<?php
						    }
						?>
			    		</div>
			            <?php
			    		foreach($top_cars as $x => $k) {
			    ?>
				        <div class="car_image" id="car_<?= $x ?>_view">
				            <div class="car_image_holder1">
					            <div class="car_image_holder2">
					            	<img src="<?= base_url() ?>system/application/helpers/render.php?bg=profile_bg.jpg&driver_id=<?= $k['car_id'] ?>&left=28&top=30&nw=224&nh=100&date=<?= date('Y_m_d_H_i_s') ?>" />
					            </div>
							</div>
							<div class="car_desc">
							    <?= $lang['renault_of'] . " " ?>
								<a href="<?= base_url() ?>profile/driver/<?= $k['car_id'] ?>">
							    	<?= $k['first_name'] ?>
								</a><BR />
								<?= $lang['score'] . ": " . convert_number((int)($k['avt'] * 100) . "") ?>%
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
		        window.location = "<?= base_url() ?>drivers_list/";
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
