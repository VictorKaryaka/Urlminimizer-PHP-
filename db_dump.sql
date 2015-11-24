-- --------------------------------------------------------
-- Сервер:                       127.0.0.1
-- Версія сервера:               5.1.73-community - MySQL Community Server (GPL)
-- ОС сервера:                   Win32
-- HeidiSQL Версія:              9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for таблиця urlminimazer.redirect_statistic
CREATE TABLE IF NOT EXISTS `redirect_statistic` (
  `link_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Link ID',
  `redirect_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_agent` varchar(128) DEFAULT NULL COMMENT 'User agent',
  `redirect_link` varchar(128) DEFAULT NULL COMMENT 'Redirect link',
  PRIMARY KEY (`link_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Дані для експорту не вибрані


-- Dumping structure for таблиця urlminimazer.storage_links
CREATE TABLE IF NOT EXISTS `storage_links` (
  `link_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Link ID',
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_limited` int(1) DEFAULT '0',
  `link_hash` varchar(32) DEFAULT NULL COMMENT 'Link hash',
  `link_url` text COMMENT 'Link address',
  PRIMARY KEY (`link_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Дані для експорту не вибрані


-- Dumping structure for таблиця urlminimazer.test_redirect_statistic
CREATE TABLE IF NOT EXISTS `test_redirect_statistic` (
  `link_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Link ID',
  `redirect_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_agent` varchar(128) DEFAULT NULL COMMENT 'User agent',
  `redirect_link` varchar(128) DEFAULT NULL COMMENT 'Redirect link',
  PRIMARY KEY (`link_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Дані для експорту не вибрані


-- Dumping structure for таблиця urlminimazer.test_storage_links
CREATE TABLE IF NOT EXISTS `test_storage_links` (
  `link_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Link ID',
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_limited` int(1) DEFAULT '0',
  `link_hash` varchar(32) DEFAULT NULL COMMENT 'Link hash',
  `link_url` text COMMENT 'Link address',
  PRIMARY KEY (`link_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Дані для експорту не вибрані
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
