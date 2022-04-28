<?php
include 'autoload.php';

use TestApp\DB;




DB::raw('DROP TABLE IF EXISTS `users`');
DB::raw('DROP TABLE IF EXISTS `records`');



DB::raw('CREATE TABLE `users` (
    id BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
    login VARCHAR(255),
    password VARCHAR(255),
    PRIMARY KEY (`id`),
    UNIQUE KEY `users_login_unique` (`login`)
)');

DB::raw('CREATE TABLE `records` (
    id BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
    name VARCHAR(255),
    description TEXT,
    parent_id BIGINT(20) unsigned,
    PRIMARY KEY (`id`),
    CONSTRAINT `records_records_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `records` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
)');
