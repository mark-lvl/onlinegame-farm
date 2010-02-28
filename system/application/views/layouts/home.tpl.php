<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?></title>

<?php echo $css; ?>
<?php echo $js; ?>

</head>

<body>
	<div id="wrapper">
         <div id="header">
		       <p>YAMMY</p>
	 </div>
         <div id="navigation">
		       <div>
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
	 </div>
         <div id="content">
                  <h2><?php echo $heading; ?></h2>
                    <?php echo $content; ?>
                  
                    <p style="clear: both"/>
         </div>
         <div id="footer">
                     <p style="text-align: center">YAMMY-LAND</p>
         </div>
        </div>

</body>
</html>
