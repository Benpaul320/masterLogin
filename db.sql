--
-- database masterLogin
--
CREATE TABLE IF NOT EXISTS `account`(
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_pass` VARCHAR(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_firstName` VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_lastName` VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_ip` VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_lastLogin` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_createdDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
