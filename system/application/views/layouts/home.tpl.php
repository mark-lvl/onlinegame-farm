<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?></title>


<link rel="stylesheet" type="text/css" href="<?= css_url() ?>system/application/assets/css/main.css" />
<script type="text/javascript" language="javascript"
        src="<?php echo css_url() . 'system/application/assets/js/jquery.js'; ?>">
</script>
<script type="text/javascript" language="javascript"
        src="<?php echo css_url() . 'system/application/assets/js/boxy.js'; ?>">
</script>
<script type="text/javascript" language="javascript"
        src="<?php echo css_url() . 'system/application/assets/js/jquery.loading/jquery.loading.js'; ?>">
</script>
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
                                <?php if(!$user->unAuthenticatedUser): ?>
                                    <span class="main">
                                            <?php 
                                                if($user->photo != "") {
                                            ?>
                                            <a href="<?= base_url() ?>profile/user/<?= $user->id ?>" >
                                                <img src="<?= css_url() ?>system/application/helpers/fa_image_helper.php?nw=45&nh=45&source=<?= $avatar_img."avatars/".$user->photo.".png" ?>&stype=png&type=little" border="0" />
                                            </a>
                                            <?php
                                                }else{
                                            ?>
                                            <a href="<?= base_url() ?>profile/user/<?= $user->id ?>" >
                                                <?php if($user->sex == 0): ?>
                                                    <img src="<?= css_url() ?>system/application/helpers/fa_image_helper.php?nw=45&nh=45&source=<?= $avatar_img."avatars/default-m.png" ?>&stype=png&dest=x&type=little" border="0" />
                                                <?php else: ?>
                                                    <img src="<?= css_url() ?>system/application/helpers/fa_image_helper.php?nw=45&nh=45&source=<?= $avatar_img."avatars/default-f.png" ?>&stype=png&dest=x&type=little" border="0" />
                                                <?php endif; ?>
                                            </a>
                                            <?php
                                                }
                                            ?>
                                            <span class="name">
                                                <a href="<?= base_url()."profile/user/".$user->id ?>">
                                                    <?= $user->first_name." ".$user->last_name ?>
                                                </a>
                                            </span>
                                            <span class="farm">
                                                <?= anchor(base_url()."farms/view/$user->id", $lang['GotoFarm']) ?>
                                            </span>
                                            <span class="logout">
                                                <?= anchor(base_url()."gateway/logout", "<img src=\"$base_img/logout.png\" />",array('title'=>$lang['logout'])) ?>
                                            </span>
                                    </span>
                                    <?php else: ?>
                                    <script>
                                    $(function(){
                                     // find all the input elements with title attributes
                                     $('input[title!=""]').hint();
                                     });
                                    </script>
                                    <span class="unLogged">
                                            <form class="login"  action="<?= base_url() ?>gateway/login/" method="POST">
                                                <input type="text" name="email_login" class="text" size="8" title="<?= $lang['email'] ?>"/>
                                                <input type="password" name="password_login" class="text" size="8" title="<?= $lang['password'] ?>"/>
                                                <input type="submit" class="profileLoginsubmit" value=" "/>
                                            </form>
                                            <span class="register">
                                                <?= anchor(base_url()."registration", $lang['registeration']) ?>
                                            </span>
                                    </span>
                                    <?php endif; ?>
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

                                <!--this section for show farmname in show.tpl.php-->
                                <?php if($farm->id): ?>
                                <div id="farmNameHolder">
                                    <?= anchor(base_url()."farms/show", $lang['farm']." ".$farm->name);?>
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
