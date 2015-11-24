<?php

namespace Application;

include_once "src/Application/DatabaseManager.class.php";

$db_connector = new DatabaseManager("./config.ini");
$connection = $db_connector->getConnection();

//Create new table if not exists

$storage_links = 'CREATE TABLE IF NOT EXISTS `storage_links` (
               `link_id` INT(11) NOT NULL AUTO_INCREMENT COMMENT \'Link ID\',
               `creation_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
               `is_limited` INT(1) DEFAULT 0,
               `link_hash` VARCHAR(32) COMMENT \'Link hash\',
               `link_url` TEXT COMMENT \'Link address\',
                PRIMARY KEY (`link_id`))
                ENGINE=MyISAM;';

$connection->query($storage_links);

$redirect_statistic = 'CREATE TABLE IF NOT EXISTS `redirect_statistic` (
               `link_id` INT(11) NOT NULL AUTO_INCREMENT COMMENT \'Link ID\',
               `redirect_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
               `user_agent` VARCHAR(128) COMMENT \'User agent\',
               `redirect_link` VARCHAR(128) COMMENT \'Redirect link\',
                PRIMARY KEY (`link_id`))
                ENGINE=MyISAM;';

$connection->query($redirect_statistic);

$test_storage_links = 'CREATE TABLE IF NOT EXISTS `test_storage_links` LIKE `storage_links`';
$connection->query($test_storage_links);

$test_redirect_statistic = 'CREATE TABLE IF NOT EXISTS `test_redirect_statistic` LIKE `redirect_statistic`';
$connection->query($test_redirect_statistic);

