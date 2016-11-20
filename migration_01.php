<?php
require_once 'Model.php';
require_once 'LearningDb.php';

$sql = 'CREATE TABLE `vocabulary` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `word` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `count` int(10) unsigned NOT NULL,
  `lang` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_word` (`word`),
  KEY `idx_lang` (`lang`)
) ENGINE=InnoDB AUTO_INCREMENT=163 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;';

$sql .= 'CREATE TABLE `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `lang` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_key` (`key`),
  KEY `idx_lang` (`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;';



$model = new \learning\db\Model(LearningDb::getConnection());
$model->execQuery($sql);