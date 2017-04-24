-----------------------
-- PHPShop CMS Free
-- Module Install SQL
-----------------------

DROP TABLE IF EXISTS `phpshop_modules_soft_loads`;
CREATE TABLE IF NOT EXISTS `phpshop_modules_soft_loads` (
  `id` varchar(32) NOT NULL default '0',
  `load_today` int(11) NOT NULL default '0',
  `load_total` int(11) NOT NULL default '0',
  `data` varchar(32) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;





DROP TABLE IF EXISTS `phpshop_modules_soft_system`;
CREATE TABLE IF NOT EXISTS `phpshop_modules_soft_system` (
  `id` int(11) NOT NULL auto_increment,
  `filedir` varchar(255) NOT NULL default '',
  `serial` varchar(64) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;



INSERT INTO `phpshop_modules_soft_system` VALUES (1,'','');

