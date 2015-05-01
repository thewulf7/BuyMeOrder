-- Adminer 4.2.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `vkdev_bank`;
CREATE DATABASE `vkdev_bank` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `vkdev_bank`;

DROP TABLE IF EXISTS `vkdev_bank`;
CREATE TABLE `vkdev_bank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `buyer` int(11) NOT NULL,
  `price` varchar(45) NOT NULL,
  `transactiontime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_vkdev_bank_vkdev_users1_idx` (`buyer`),
  KEY `fk_vkdev_bank_vkdev_orders1_idx` (`order_id`),
  CONSTRAINT `fk_vkdev_bank_vkdev_orders1` FOREIGN KEY (`order_id`) REFERENCES `vkdev_orders`.`vkdev_orders` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_vkdev_bank_vkdev_users1` FOREIGN KEY (`buyer`) REFERENCES `vkdev_users`.`vkdev_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

INSERT INTO `vkdev_bank` (`id`, `order_id`, `buyer`, `price`, `transactiontime`, `status`) VALUES
(11,	18,	17,	'MTIxMDY1ODU5Mw==',	'2015-05-01 07:16:55',	2)
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `order_id` = VALUES(`order_id`), `buyer` = VALUES(`buyer`), `price` = VALUES(`price`), `transactiontime` = VALUES(`transactiontime`), `status` = VALUES(`status`);

DROP DATABASE IF EXISTS `vkdev_bank_balance`;
CREATE DATABASE `vkdev_bank_balance` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `vkdev_bank_balance`;

DROP TABLE IF EXISTS `vkdev_bank_balance`;
CREATE TABLE `vkdev_bank_balance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `balance` varchar(255) DEFAULT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

INSERT INTO `vkdev_bank_balance` (`id`, `balance`, `last_update`) VALUES
(16,	'MjEwNjU4NjQz',	'2015-04-28 08:05:16'),
(17,	'MTAyODY1NzMxOQ==',	'2015-05-01 07:16:55'),
(18,	'MjEwMDc=',	'2015-04-30 09:24:39'),
(19,	'MjEwNzU5',	'2015-04-30 09:24:39'),
(20,	'MjEwMDc=',	'2015-05-01 09:17:49'),
(21,	'MjEw',	'2015-05-01 09:17:49'),
(22,	'MjEwNQ==',	'2015-05-01 09:17:49'),
(23,	'MjEwOTU=',	'2015-05-01 09:17:49')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `balance` = VALUES(`balance`), `last_update` = VALUES(`last_update`);

DROP DATABASE IF EXISTS `vkdev_orders`;
CREATE DATABASE `vkdev_orders` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `vkdev_orders`;

DROP TABLE IF EXISTS `vkdev_orders`;
CREATE TABLE `vkdev_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `descr` text CHARACTER SET utf8,
  `price` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `closed` timestamp NULL DEFAULT NULL,
  `seller` int(11) NOT NULL,
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_vkdev_orders_vkdev_users1_idx` (`seller`),
  CONSTRAINT `fk_vkdev_orders_vkdev_users1` FOREIGN KEY (`seller`) REFERENCES `vkdev_users`.`vkdev_users` (`id`) ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `vkdev_orders` (`id`, `name`, `descr`, `price`, `created`, `closed`, `seller`, `active`) VALUES
(16,	'Тестовый распил 1',	'Распилим',	'MjExNTU4NjUy',	'2015-04-30 13:58:45',	NULL,	16,	0),
(17,	'Шоссе Москва-СПб',	'Надо сделать крутую дорогу',	'MTIxMDY1ODY0Mw==',	'2015-05-01 06:59:21',	NULL,	16,	0),
(18,	'Ракета в космос',	'Надо запустить и потом уронить',	'MTIxMDY1ODU5Mw==',	'2015-05-01 07:04:28',	NULL,	16,	1),
(19,	'Военные учения',	'Самые масштабные в мире',	'NjY4NzczMjUzMDk=',	'2015-05-01 07:05:12',	NULL,	16,	0),
(20,	'Test order',	'Тестовое описание',	'MjIyMDc=',	'2015-05-01 09:34:10',	NULL,	20,	0),
(21,	'Стадион Зенит-Арена',	'10 лет строим стадион',	'MTQxMA==',	'2015-05-01 09:39:10',	NULL,	21,	1),
(22,	'Импортозамещение',	'Нужно наше, отечественное',	'MTUxMA==',	'2015-05-01 09:39:10',	NULL,	21,	1),
(23,	'Организация мероприятий',	'Турнир по боулингу и бильярду',	'MjI0MDc=',	'2015-05-01 09:39:10',	NULL,	20,	1)
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `name` = VALUES(`name`), `descr` = VALUES(`descr`), `price` = VALUES(`price`), `created` = VALUES(`created`), `closed` = VALUES(`closed`), `seller` = VALUES(`seller`), `active` = VALUES(`active`);

DROP DATABASE IF EXISTS `vkdev_users`;
CREATE DATABASE `vkdev_users` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `vkdev_users`;

DROP TABLE IF EXISTS `vkdev_users`;
CREATE TABLE `vkdev_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `email` varchar(255) NOT NULL,
  `usergroup` int(11) DEFAULT NULL,
  `passwd` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `userhash` varchar(45) DEFAULT NULL,
  `balance` int(11) DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` bit(1) DEFAULT b'1',
  PRIMARY KEY (`id`),
  KEY `fk_vkdev_users_vkdev_users_group_idx` (`usergroup`),
  KEY `fk_vkdev_users_vkdev_balance` (`balance`),
  CONSTRAINT `fk_vkdev_users_vkdev_users_group` FOREIGN KEY (`usergroup`) REFERENCES `vkdev_users_group`.`vkdev_users_group` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `vkdev_users_ibfk_2` FOREIGN KEY (`balance`) REFERENCES `vkdev_bank_balance`.`vkdev_bank_balance` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

INSERT INTO `vkdev_users` (`id`, `username`, `email`, `usergroup`, `passwd`, `salt`, `userhash`, `balance`, `create_time`, `status`) VALUES
(16,	'thewulf7',	'thewulf7@me.com',	1,	'$2a$10$dpwEcg65g8p6q4AVWtZb3.i2cRzlrN7eTOoqWfm/bynr4XVFiBvGu',	'$2a$10$dpwEcg65g8p6q4AVWtZb3A$',	'55ea2f180c7d1163c76cfd7ae1791e36',	16,	'2015-04-28 08:05:16',	CONV('1', 2, 10) + 0),
(17,	'Евгений',	'thewulf7@gmail.com',	2,	'$2a$10$SJZa9j61nnhh/j2/csqGl.DZijwxDZiz5LFgqlf4ATZCDlG0Ri/US',	'$2a$10$SJZa9j61nnhh/j2/csqGlA$',	'839b806d1f3eed020e5ed1ed59e49226',	17,	'2015-04-30 09:24:34',	CONV('1', 2, 10) + 0),
(20,	'Админ',	'admin@vk.dev',	1,	'$2a$10$MM0ZTxCAtaYTutb7HOwMTeV1laFkm2iNtNVLhUxwuUSJ5TeDJ9C6G',	'$2a$10$MM0ZTxCAtaYTutb7HOwMTg$',	NULL,	20,	'2015-05-01 09:17:49',	CONV('1', 2, 10) + 0),
(21,	'Царь',	'putin@vk.dev',	1,	'$2a$10$NCQ.DXB877hWO.ZWIXvFye0ESuYGj7wTO1jWjJ/TFrhWiLyRjdzDa',	'$2a$10$NCQ.DXB877hWO.ZWIXvFyg$',	NULL,	21,	'2015-05-01 09:17:49',	CONV('1', 2, 10) + 0),
(22,	'Паша',	'durov@vk.dev',	2,	'$2a$10$KNuM5AarnmwwHvgBYUYSNu4Rmf1k.IiUjZjmr8JZnWQGtVLUBRs1u',	'$2a$10$KNuM5AarnmwwHvgBYUYSNw$',	'778e2183e84644be7f80ce86196f3e33',	22,	'2015-05-01 09:17:49',	CONV('1', 2, 10) + 0),
(23,	'Покупатель',	'simple@vk.dev',	2,	'$2a$10$AkqYrwVDpLZwTN95OOMKaOOI0BDFUWkYYx2frbI/Zyvs6400p6rRK',	'$2a$10$AkqYrwVDpLZwTN95OOMKaQ$',	NULL,	23,	'2015-05-01 09:17:49',	CONV('1', 2, 10) + 0)
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `username` = VALUES(`username`), `email` = VALUES(`email`), `usergroup` = VALUES(`usergroup`), `passwd` = VALUES(`passwd`), `salt` = VALUES(`salt`), `userhash` = VALUES(`userhash`), `balance` = VALUES(`balance`), `create_time` = VALUES(`create_time`), `status` = VALUES(`status`);

DROP DATABASE IF EXISTS `vkdev_users_group`;
CREATE DATABASE `vkdev_users_group` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `vkdev_users_group`;

DROP TABLE IF EXISTS `vkdev_users_group`;
CREATE TABLE `vkdev_users_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `permissions` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO `vkdev_users_group` (`id`, `name`, `permissions`, `active`) VALUES
(1,	'seller',	'create,delete',	1),
(2,	'buyer',	'close,receive',	1)
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `name` = VALUES(`name`), `permissions` = VALUES(`permissions`), `active` = VALUES(`active`);

-- 2015-05-01 10:10:23
