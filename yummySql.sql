-- phpMyAdmin SQL Dump
-- version 3.2.2.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 20, 2010 at 04:04 PM
-- Server version: 5.1.37
-- PHP Version: 5.2.10-2ubuntu6.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `yammy`
--
CREATE DATABASE `yammy` DEFAULT CHARACTER SET utf8 COLLATE utf8_persian_ci;
USE `yammy`;

-- --------------------------------------------------------

--
-- Table structure for table `abuse`
--

CREATE TABLE IF NOT EXISTS `abuse` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT '1:badNaming;2:badMessage;3:others',
  `sender` int(10) unsigned NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `abuse`
--


-- --------------------------------------------------------

--
-- Table structure for table `accessories`
--

CREATE TABLE IF NOT EXISTS `accessories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `description` text CHARACTER SET ucs2 COLLATE ucs2_persian_ci NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT '0:not defined,1:offensive,2:defensive,3:help,4:other',
  `group` tinyint(4) NOT NULL DEFAULT '0',
  `price` int(11) NOT NULL,
  `level` tinyint(4) NOT NULL DEFAULT '0',
  `sell_cost` int(11) NOT NULL,
  `effect` int(11) NOT NULL,
  `life_time` int(11) NOT NULL COMMENT 'with hour unit(for offensive acc is time to effect in target-in defensive object life time of acc)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46 ;

--
-- Dumping data for table `accessories`
--

INSERT INTO `accessories` (`id`, `name`, `description`, `type`, `group`, `price`, `level`, `sell_cost`, `effect`, `life_time`) VALUES
(1, 'aphid', 'شته میتونه در یک ساعت ۳۰درصد از سلامت گیاه کم کنه', 1, 1, 20, 3, 0, 30, 1),
(20, 'clipper', 'برای اینکه بتونی لوبیا رو برداشت کنی به قیچی باغبانی نیاز پیدا می کنی', 4, 20, 50, 4, 0, 0, 0),
(2, 'grasshoppers', 'اگه ملخ تو مزرعه ای بندازی میتونه تو ۱ ساعت از سلامت گیاهاش ۵۰٪ کم کنه', 1, 1, 250, 4, 0, 50, 1),
(3, 'sprayer', 'اگه سمپاش بخری مزرعت به صورت اتومات سمپاشی میشه', 2, 1, 500, 4, 0, 0, 0),
(21, 'shovel', 'برای کاشت گوجه فرنگی نیاز به بیلچه خواهی داشت', 4, 20, 100, 5, 0, 0, 0),
(4, 'mouse', 'موش در سه ساعت میتونه ۱۰٪ از کل مزرعه رو بخوره', 1, 2, 400, 5, 0, 60, 3),
(5, 'gun', 'با استفاده از تفنگ میتونی یک سری حملاتو دفع کنی', 2, 2, 300, 5, 0, 0, 0),
(40, 'lamp', 'لامپ اشعه دار باعث میشه رشد گیاهانت ۲۵٪ سریعتر بشه', 4, 10, 500, 6, 0, 25, 0),
(6, 'crow', 'کلاغ میتونه طی ۲ ساعت ۲۰کیلوگرم محصول بخوره', 1, 2, 800, 6, 0, 240, 1),
(7, 'scarecrow', 'اگه واسه مزرعت مترسک بخری باعث میشه ۵۰٪ از اثر حملات کلاغ ها کم بشه', 2, 2, 900, 6, 0, 50, 24),
(8, 'dog', 'سگ باعث میشه ۱۰٪ کمتر محصولاتت توسط حیوونهای مهاجم دزدیده بشه و همینطور با پارس کردن ۵ تا از دوستاتو خبر میکنه', 2, 2, 1000, 7, 0, 10, 72),
(42, 'tractor', 'اگه واسه مزرعت تراکتور بخری شخم زدن مزرعه برات مجانی میشه', 4, 11, 500, 3, 0, 0, 0),
(43, 'stand', 'برای کاشت بادمجان نیاز به پایه ی نگه دارنده ی گیاه خواهی داشت', 4, 20, 300, 8, 0, 0, 0),
(44, 'heater', 'با استفاده از گرمکن میتونی شب ها هم گیاهاتو گرم نگخ داری و رشد گیاهات ۳۰٪ سریعتر بشه', 4, 10, 1000, 9, 0, 30, 0),
(45, 'silo', 'در مرحله ۱۰ بازی برای اینکه بتونی از محصولاتت نگهداری کنی نیاز به خرید سیلو داری', 4, 20, 5000, 10, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `farmaccessories`
--

CREATE TABLE IF NOT EXISTS `farmaccessories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `farm_id` int(11) NOT NULL,
  `accessory_id` int(11) NOT NULL,
  `count` tinyint(4) NOT NULL,
  `create_date` int(11) NOT NULL,
  `modified_date` int(11) NOT NULL,
  `expire_date` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `farmaccessories`
--


-- --------------------------------------------------------

--
-- Table structure for table `farmmissions`
--

CREATE TABLE IF NOT EXISTS `farmmissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `farm_id` int(11) NOT NULL,
  `mission_id` smallint(6) NOT NULL,
  `plant_id` int(11) NOT NULL,
  `stack` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL COMMENT '0:onWay;1:success;2:faild',
  `create_date` int(11) NOT NULL,
  `modified_date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `farmmissions`
--


-- --------------------------------------------------------

--
-- Table structure for table `farmresources`
--

CREATE TABLE IF NOT EXISTS `farmresources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `resource_id` int(11) NOT NULL,
  `farm_id` int(11) NOT NULL,
  `count` tinyint(4) NOT NULL DEFAULT '1',
  `create_date` date NOT NULL,
  `modified_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `farmresources`
--


-- --------------------------------------------------------

--
-- Table structure for table `farms`
--

CREATE TABLE IF NOT EXISTS `farms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `money` int(11) NOT NULL DEFAULT '500',
  `section` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'size of farm area',
  `plow` tinyint(1) NOT NULL DEFAULT '0',
  `level` int(11) NOT NULL DEFAULT '1' COMMENT 'level of the user',
  `create_date` date NOT NULL,
  `modified_date` date NOT NULL,
  `disactive` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `farms`
--


-- --------------------------------------------------------

--
-- Table structure for table `farmtransactions`
--

CREATE TABLE IF NOT EXISTS `farmtransactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `offset_farm` int(11) NOT NULL DEFAULT '0',
  `goal_farm` int(11) NOT NULL,
  `accessory_id` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT '0:notDefined;1:offensive;2:defensive;3:help;4:other',
  `details` text CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL COMMENT 'description and data holder; 1: addResourceToFriendPlant;2x:deffendFreindFarmAgainst(x)accessoryId;3:moneyHelp',
  `flag` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:onWAy,1:done,2:reject',
  `alert_flag` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'used for dog alert and etc',
  `create_date` int(11) NOT NULL,
  `modified_date` int(11) NOT NULL,
  `efficacy_date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `farmtransactions`
--


-- --------------------------------------------------------

--
-- Table structure for table `invitations`
--

CREATE TABLE IF NOT EXISTS `invitations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `friend_email` varchar(100) NOT NULL,
  `status` tinyint(1) unsigned zerofill NOT NULL,
  `hash` varchar(45) NOT NULL,
  `date_invited` datetime NOT NULL,
  `date_answered` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `invitations`
--


-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from` int(10) unsigned NOT NULL,
  `to` int(10) unsigned NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ip` varchar(45) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1:ok, 2:deleted',
  `message` text NOT NULL,
  `checked` tinyint(1) unsigned NOT NULL,
  `title` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `messages`
--


-- --------------------------------------------------------

--
-- Table structure for table `missions`
--

CREATE TABLE IF NOT EXISTS `missions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` smallint(6) NOT NULL,
  `type_id` smallint(6) NOT NULL,
  `amount` int(11) NOT NULL,
  `needed_accessory` text COLLATE utf8_persian_ci,
  `description` text COLLATE utf8_persian_ci NOT NULL,
  `deadline` smallint(6) NOT NULL COMMENT 'with hour unit',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:specificResource;1:free',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `missions`
--

INSERT INTO `missions` (`id`, `level`, `type_id`, `amount`, `needed_accessory`, `description`, `deadline`, `type`) VALUES
(1, 1, 1, 20, '', 'یامی به 20کیلوگرم گندم نیاز داره سریع دست بکار شو', 1, 0),
(2, 2, 2, 15, '', 'الان یامی برای ساختن پفک به ۱۵کیلوگرم ذرت نیاز داره', 4, 0),
(3, 3, 3, 25, '', 'این مرحله یامی برای ساختن چیپس نیاز به ۲۵ کیلوگرم سیب زمینی داره', 13, 0),
(4, 4, 4, 70, 'a:1:{i:0;i:20;}', 'یامی ازت ۷۰ کیلوگرم لوبیا میخواد باید زود تحویل بدی', 72, 0),
(5, 5, 5, 70, 'a:1:{i:0;i:21;}', 'یامی تو این مرحله ازت ۷۰کیلوگرم گوجه فرنگی میخواد', 72, 0),
(6, 6, 6, 100, NULL, 'یامی الان شدیدا نیاز به خیار داره که میخواد تو ۳روز ۱۰۰کیلوگرم بهش خیار تحویل بدی تو میتونی برای برداشت سریعتر محصولات برای مزرعت مهتابی بخری', 74, 0),
(7, 7, 7, 300, '', 'یامی تو این مرحله به ۳۰۰کیلوگرم پیاز در ۴ روز نیاز داره بهتر اگه مزرعت کوچیکه از موتورآب استفاده کنی', 96, 0),
(8, 8, 8, 400, 'a:1:{i:0;i:43;}', 'یامی تو این مرحله از تو ۴۰۰ کیلوگرم بادمجان میخواد', 96, 0),
(9, 9, 0, 1000, NULL, 'تو این مرحله باید ۱۰۰۰کیلوگرم محصول تحویل یامی بدی نوع گیاهتو خودت انتخاب کن', 168, 1),
(10, 10, 0, 1500, 'a:1:{i:0;i:45;}', 'تو این مرحله باید ۱۵۰۰ کیلوگرم محصول به یامی بدی', 240, 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `farm_id` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT '0:attack;1:reject;2:rejectByFriend;3:resourceLack;4:other',
  `details` int(11) NOT NULL,
  `body` text COLLATE utf8_persian_ci NOT NULL,
  `create_date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `notifications`
--


-- --------------------------------------------------------

--
-- Table structure for table `plantresources`
--

CREATE TABLE IF NOT EXISTS `plantresources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plant_id` int(11) NOT NULL,
  `typeresource_id` tinyint(4) NOT NULL,
  `current` tinyint(4) NOT NULL,
  `create_date` int(11) NOT NULL,
  `modified_date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `plantresources`
--


-- --------------------------------------------------------

--
-- Table structure for table `plants`
--

CREATE TABLE IF NOT EXISTS `plants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `farm_id` int(11) NOT NULL,
  `type_id` tinyint(4) NOT NULL,
  `health` int(11) NOT NULL COMMENT '0:die,100:max',
  `weight` int(11) NOT NULL,
  `growth` int(11) NOT NULL COMMENT 'in percent',
  `reap` tinyint(4) NOT NULL DEFAULT '0',
  `create_date` int(11) NOT NULL,
  `modified_date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `plants`
--


-- --------------------------------------------------------

--
-- Table structure for table `relations`
--

CREATE TABLE IF NOT EXISTS `relations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `inviter` int(10) unsigned NOT NULL,
  `guest` int(10) unsigned NOT NULL,
  `invitation_date` datetime NOT NULL,
  `status` tinyint(1) unsigned zerofill NOT NULL COMMENT '1:ok, 2:denied, 3:ignored',
  `answer_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `relations`
--


-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE IF NOT EXISTS `resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` (`id`, `name`, `price`) VALUES
(1, 'Water', 15),
(2, 'Muck', 5);

-- --------------------------------------------------------

--
-- Table structure for table `typeresources`
--

CREATE TABLE IF NOT EXISTS `typeresources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` tinyint(4) NOT NULL,
  `resource_id` tinyint(4) NOT NULL,
  `consumeTime` float NOT NULL DEFAULT '0' COMMENT 'with hour unit',
  `minNeed` tinyint(4) NOT NULL DEFAULT '1',
  `maxNeed` tinyint(4) NOT NULL DEFAULT '5',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `typeresources`
--

INSERT INTO `typeresources` (`id`, `type_id`, `resource_id`, `consumeTime`, `minNeed`, `maxNeed`) VALUES
(1, 1, 1, 0.25, 1, 5),
(3, 1, 2, 0.5, 1, 5),
(4, 2, 1, 0.5, 1, 5),
(5, 2, 2, 1.5, 1, 5),
(6, 3, 1, 2, 1, 5),
(7, 3, 2, 6, 1, 5),
(8, 4, 1, 6, 1, 5),
(9, 4, 2, 8, 1, 5),
(10, 5, 1, 5, 1, 5),
(11, 5, 2, 10, 1, 5),
(12, 6, 1, 10, 1, 5),
(13, 6, 2, 12, 1, 5),
(14, 7, 1, 5, 1, 5),
(15, 7, 2, 24, 1, 5),
(16, 8, 1, 6, 1, 5),
(17, 8, 2, 14, 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE IF NOT EXISTS `types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `price` int(11) NOT NULL COMMENT 'based on each weight',
  `sell_cost` int(11) NOT NULL COMMENT 'based on each weight',
  `weight` int(11) NOT NULL COMMENT 'weight of type in each section area',
  `growth_time` float NOT NULL COMMENT 'with hour unit',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`id`, `name`, `price`, `sell_cost`, `weight`, `growth_time`) VALUES
(1, 'wheat', 10, 50, 20, 0.5),
(2, 'corn', 15, 80, 25, 3),
(3, 'potato', 5, 50, 30, 12),
(4, 'beans', 10, 90, 80, 70),
(5, 'tomato', 15, 120, 50, 70),
(6, 'cucumber', 20, 100, 60, 96),
(7, 'onion', 10, 70, 105, 94),
(8, 'eggplant', 15, 150, 140, 110);

-- --------------------------------------------------------

--
-- Table structure for table `userranks`
--

CREATE TABLE IF NOT EXISTS `userranks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT '0:level;1:complete:2:grasshopper;3:bigProduct',
  `rank` int(11) NOT NULL DEFAULT '0',
  `create_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `userranks`
--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(250) CHARACTER SET utf8 NOT NULL,
  `last_name` varchar(250) CHARACTER SET utf8 NOT NULL,
  `email` varchar(250) CHARACTER SET utf8 NOT NULL,
  `password` varchar(250) CHARACTER SET utf8 NOT NULL,
  `photo` varchar(100) CHARACTER SET utf8 NOT NULL,
  `sex` tinyint(1) unsigned zerofill NOT NULL COMMENT '0:male',
  `birthdate` date NOT NULL,
  `city` varchar(255) CHARACTER SET utf8 NOT NULL,
  `registration_ip` varchar(45) CHARACTER SET utf8 NOT NULL,
  `registration_date` datetime NOT NULL,
  `logins` int(10) unsigned NOT NULL,
  `last_login_ip` varchar(45) CHARACTER SET utf8 NOT NULL,
  `last_login_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `photo`, `sex`, `birthdate`, `city`, `registration_ip`, `registration_date`, `logins`, `last_login_ip`, `last_login_date`) VALUES
(1, 'محمدرضا', 'کاغذگریان', 'markteams@gmail.com', 'e29ce8e478bcaf00f2fc628227d1269e', '', 0, '0000-00-00', '', '', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00');
