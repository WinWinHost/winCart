CREATE TABLE IF NOT EXISTS `cart` (
`cartID` int(11) NOT NULL AUTO_INCREMENT,
`phpsessid` varchar(255) NOT NULL DEFAULT '',
`prodID` int(11) NOT NULL DEFAULT '0',
    `quantity` int(11) NOT NULL DEFAULT '0',
    `insert_date` bigint(20) NOT NULL,
PRIMARY KEY (`cartID`),
    KEY `phpsessid` (`phpsessid`),
    KEY `productID` (`prodID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `content_nodes` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`page_id` int(11) DEFAULT NULL,
`node` varchar(50) DEFAULT NULL,
`content` text,
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `menus` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(50) DEFAULT NULL,
`access_level` varchar(50) DEFAULT NULL,
`position` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `menu_items` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`menu_id` int(11) DEFAULT NULL,
`label` varchar(250) DEFAULT NULL,
`link_type` varchar(10) NOT NULL,
`page_cat_id` int(11) NOT NULL,
`page_id` int(11) DEFAULT NULL,
`link` varchar(250) DEFAULT NULL,
`position` int(11) DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `options` (
`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
`title` varchar(50) NOT NULL,
`meta_description` varchar(200) NOT NULL,
`meta_keywords` varchar(100) NOT NULL,
`cEmail` varchar(100) NOT NULL,
UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `orderdetails` (
`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
`orderID` int(11) NOT NULL,
`prodID` int(11) NOT NULL,
`quantity` int(11) NOT NULL,
UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `orders` (
`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
`userID` int(11) NOT NULL,
`bfName` varchar(100) NOT NULL,
`blName` varchar(100) NOT NULL,
`bAddress` varchar(100) NOT NULL,
`bState` varchar(100) NOT NULL,
`bCountry` varchar(5) NOT NULL,
`bCity` varchar(100) NOT NULL,
`bZip` int(11) NOT NULL,
`sfName` varchar(100) NOT NULL,
`slName` varchar(100) NOT NULL,
`sAddress` varchar(100) NOT NULL,
`sState` varchar(100) NOT NULL,
`sCountry` varchar(100) NOT NULL,
`sCity` varchar(100) NOT NULL,
`sZip` int(11) NOT NULL,
`subtotal` float NOT NULL,
`shipping` float NOT NULL,
`total` float NOT NULL,
`cc` int(17) NOT NULL,
`status` varchar(20) NOT NULL,
`insert_date` bigint(20) NOT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `pages` (
`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
`parent_id` int(11) NOT NULL,
`namespace` varchar(50) NOT NULL,
`name` varchar(100) NOT NULL,
`slug` varchar(100) NOT NULL,
`date_created` int(11) NOT NULL,
UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `products` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`cat` int(11) DEFAULT NULL,
`thump` text NOT NULL,
`name` varchar(255) NOT NULL DEFAULT '',
`slug` varchar(100) NOT NULL,
`content` mediumtext NOT NULL,
`cost` decimal(7,2) NOT NULL DEFAULT '0.00',
`price` decimal(7,2) NOT NULL DEFAULT '0.00',
`insert_date` bigint(20) NOT NULL,
`stock` int(11) NOT NULL DEFAULT '0',
`meta_keywords` mediumtext NOT NULL,
`meta_description` mediumtext NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `product_cat` (
`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
`name` varchar(100) NOT NULL,
`insert_date` int(11) NOT NULL,
`slug` varchar(100) NOT NULL,
`meta_keywords` varchar(100) NOT NULL,
`meta_description` varchar(100) NOT NULL,
`order` int(11) DEFAULT NULL,
UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`role` varchar(15) NOT NULL,
`username` varchar(50) DEFAULT NULL,
`password` varchar(250) DEFAULT NULL,
`first_name` varchar(50) DEFAULT NULL,
`last_name` varchar(50) DEFAULT NULL,
`address` varchar(100) DEFAULT NULL,
`state` varchar(100) DEFAULT NULL,
`zip` varchar(100) DEFAULT NULL,
`city` varchar(100) DEFAULT NULL,
`country` varchar(100) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;