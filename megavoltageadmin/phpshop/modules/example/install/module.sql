
ALTER TABLE `phpshop_system ` ADD `example` VARCHAR(64) NOT NULL;

--
-- ��������� ������� `phpshop_modules_example_system`
--

DROP TABLE IF EXISTS `phpshop_modules_example_system`;
CREATE TABLE IF NOT EXISTS `phpshop_modules_example_system` (
  `id` int(11) NOT NULL auto_increment,
  `example` varchar(255) NOT NULL default '',
  `serial` varchar(64) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;



INSERT INTO `phpshop_modules_example_system` VALUES (1,'<h2>������ Example ��������!</h2>','');