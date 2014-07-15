## New Saisai Tables (relationships, settings, categories, tags)

CREATE TABLE `saisai_relationships` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `candidate_table` varchar(100) DEFAULT '',
  `candidate_key` int(11) NOT NULL,
  `foreign_table` varchar(100) DEFAULT NULL,
  `foreign_key` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `candidate_table` (`candidate_table`,`candidate_key`),
  KEY `foreign_table` (`foreign_table`,`foreign_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `saisai_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(50) NOT NULL DEFAULT '',
  `key` varchar(50) NOT NULL DEFAULT '',
  `value` longtext,
  PRIMARY KEY (`id`),
  UNIQUE KEY `module` (`module`,`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `saisai_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `slug` varchar(100) NOT NULL DEFAULT '',
  `context` varchar(100) NOT NULL DEFAULT '',
  `precedence` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `published` enum('yes','no') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `saisai_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `precedence` int(11) NOT NULL,
  `published` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`id`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8;

## Saisai Users

ALTER TABLE `saisai_users` MODIFY `password` VARCHAR(64)  NOT NULL  DEFAULT ''  AFTER `user_name`;
ALTER TABLE `saisai_users` ADD `salt` VARCHAR(32)  NOT NULL  DEFAULT ''  AFTER `reset_key`;
ALTER TABLE `saisai_users` CHANGE `password` `password` VARCHAR(64)  NOT NULL  DEFAULT '';
UPDATE `saisai_users` SET password = 'f4c99eae874755b97610d650be565f1ac42019d1', salt = '429c6e14342dd7a63c510007a1858c26', first_name = 'admin', last_name = 'admin' WHERE id = 1;

## Saisai Permissions

ALTER TABLE `saisai_permissions` CHANGE `name` `name` VARCHAR(50)  NOT NULL  DEFAULT ''  COMMENT 'In most cases, this should be the name of the module (e.g. news)';
INSERT INTO `saisai_permissions` (`id`, `description`, `name`, `active`) VALUES (NULL, 'Settings', 'settings', 'yes');

## Saisai Logs

ALTER TABLE `saisai_logs` ADD `type` VARCHAR(30)  NOT NULL  DEFAULT ''  AFTER `message`;

## Saisai Navigation

ALTER TABLE `saisai_navigation_groups` ADD UNIQUE INDEX `name` (`name`);
ALTER TABLE `saisai_navigation` ADD  `language` VARCHAR( 30 ) NOT NULL DEFAULT  'english' AFTER  `hidden` ;
ALTER TABLE `saisai_navigation` DROP INDEX  `group_id` , ADD UNIQUE  `group_id` (  `group_id` ,  `nav_key` ,  `parent_id` ,  `language` );

## Saisai Page Variables

ALTER TABLE `saisai_page_variables` CHANGE `type` `type` ENUM('string','int','boolean','array')  NOT NULL  DEFAULT 'string';
ALTER TABLE `saisai_page_variables` ADD `language` VARCHAR(30)  NOT NULL  DEFAULT 'english'  AFTER `type`;
ALTER TABLE `saisai_page_variables` DROP INDEX  `page_id` ,ADD UNIQUE  `page_id` (  `page_id` ,  `name` ,  `language` );
ALTER TABLE `saisai_page_variables` CHANGE `value` `value` LONGTEXT  NOT NULL;

## Saisai Blocks

ALTER TABLE  `saisai_blocks` ADD  `language` VARCHAR( 30 ) NOT NULL DEFAULT  'english' AFTER  `view` ;
ALTER TABLE  `saisai_blocks` DROP INDEX  `name` , ADD UNIQUE  `name` (  `name` ,  `language` );

## Saisai Blog Posts

ALTER TABLE `saisai_blog_posts` DROP `image`;
ALTER TABLE `saisai_blog_posts` ADD `main_image` VARCHAR(100)  NOT NULL  DEFAULT ''  AFTER `author_id`;
ALTER TABLE `saisai_blog_posts` ADD `list_image` VARCHAR(100)  NOT NULL  DEFAULT ''  AFTER `main_image`;
ALTER TABLE `saisai_blog_posts` ADD `thumbnail_image` VARCHAR(100)  NOT NULL  DEFAULT ''  AFTER `list_image`;


## Migrate permission relationships to relationships table 
INSERT INTO `saisai_relationships` (`candidate_table`, `candidate_key`, `foreign_table`, `foreign_key`)
(SELECT 'saisai_users', `user_id`, 'saisai_permissions', `permission_id` FROM `saisai_user_to_permissions`);

DROP TABLE `saisai_user_to_permissions`;

