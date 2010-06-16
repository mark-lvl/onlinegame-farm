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
                                
                                <?php if($user): ?>
                                <?php if(isset($user->profilePage)): ?>
                                <div id="search">
                                    <span class="label"><?= $lang['search'] ?></span>
                                    <form id="searchForm">
                                        <span class="searchInput">
                                            <input type="text" name="search" id="searchUserByName"/>
                                            <select id="searchByType">
                                                <option value="1"><?= $lang['users'] ?></option>
                                                <option value="2"><?= $lang['farms'] ?></option>
                                            </select>
                                        </span>
                                        <span><input type="submit" value="" class="searchSubmit"/></span>
                                    </form>
                                </div>
                                <?php endif; ?>
                                <div id="userConsole">
                                    <span>
                                            <?php
                                                if($user_profile->photo != "") {
                                            ?>
                                            <a href="<?= base_url() ?>profile/user/<?= $user_profile->id ?>" >
                                                <img src="<?= $base_img."avatars/".$user_profile->photo.".png" ?>" />
                                            </a>
                                            <?php
                                                }else{
                                            ?>
                                            <a href="<?= base_url() ?>profile/user/<?= $user_profile->id ?>" >
                                                <img src="<?= $base_img ?>default.png" />
                                            </a>
                                            <?php
                                                }
                                            ?>
                                            <span class="name">
                                                <a href="<?= base_url()."profile/user/".$user->id ?>">
                                                    <?= $user->first_name." ".$user->last_name ?>
                                                </a>
                                            </span>
                                            <span class="date">
                                                <?= $lang['register_date'].": ".convert_number(fa_strftime("%d %B %Y", $user->registration_date . "")) ?>
                                            </span>
                                    </span>
                                </div>
                                <?php endif; ?>
                                <?php if($user_profile == $user && $userFarm->id): ?>
                                <div id="farmNameHolder">
                                    <?= anchor(base_url()."farms/show", $lang['farm']." ".$userFarm->name);?>
                                </div>
                                <?php elseif($userFarm->id): ?>
                                <div id="farmNameHolder">
                                    <?= anchor(base_url()."farms/view/$user_profile->id", $lang['farm']." ".$userFarm->name);?>
                                </div>
                                <?php endif; ?>
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
