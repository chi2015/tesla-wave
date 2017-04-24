-----------------------
-- PHPShop CMS Free
-- Module Install SQL
-----------------------


DROP TABLE IF EXISTS `phpshop_modules_catalog_system`;
CREATE TABLE IF NOT EXISTS `phpshop_modules_catalog_system` (
  `id` int(11) NOT NULL default '0',
  `domain` varchar(64) NOT NULL default '',
  `partner` int(11) NOT NULL default '0',
  `right` varchar(255) NOT NULL default '',
  `left` varchar(255) NOT NULL default '',
  `limit_left` tinyint(11) NOT NULL default '0',
  `limit_right` tinyint(11) NOT NULL default '0',
  `limit` tinyint(11) NOT NULL default '0',
  `url_key` varchar(64) NOT NULL default '0',
  `serial` varchar(64) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;


INSERT INTO `phpshop_modules_catalog_system` VALUES (1, 'demo.phpshop.ru', 1, '11', '8', 5, 5, 30, '', '');

