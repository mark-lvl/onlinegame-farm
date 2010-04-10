<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?></title>

<?php echo $css; ?>
<?php echo $js; ?>
<!--[if IE]>
<link rel="stylesheet" type="text/css" href="<?= css_url() ?>system/application/assets/css/iehacks.css" />
<![endif]-->
</head>

<body>
	<div id="wrapper">
                <div id="header">
                        <div class="main">
                                <div id="navigation">
                                        <ul>
                                            <li>
                                                <a class="little_link" href="<?= base_url() ?>">
                                                    <?= $lang['home'] ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="little_link" href="<?= base_url() ?>policy/">
                                                    <?= $lang['laws'] ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="little_link" href="<?= base_url() ?>contact/">
                                                    <?= $lang['contact'] ?>
                                                </a>
                                            </li>
                                        </ul>
                                </div>

                        </div>
                </div>
         
                <div id="content">
                        <div class="main">
                                <?php echo $heading; ?>
                                <?php echo $content; ?>
                        </div>
                </div>
                <div id="footer">
                        <div id="footer-up">
                        </div>
                        <div id="footer-bottom">
                            <p style="text-align: center">Copyright &copy; 2010 Yummy,Nik Pars.All Right Reserved</p>
                        </div>
                </div>
        </div>
</body>
</html>
