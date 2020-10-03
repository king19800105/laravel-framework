# ************************************************************
# Sequel Pro SQL dump
# Version 5446
#
# https://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 8.0.19)
# Database: framework
# Generation Time: 2020-10-03 05:05:17 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table fw_admins
# ------------------------------------------------------------

DROP TABLE IF EXISTS `fw_admins`;

CREATE TABLE `fw_admins` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '手机号码',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '管理员密码',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fw_admin_mobile` (`mobile`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `fw_admins` WRITE;
/*!40000 ALTER TABLE `fw_admins` DISABLE KEYS */;

INSERT INTO `fw_admins` (`id`, `name`, `mobile`, `password`, `deleted_at`, `created_at`, `updated_at`)
VALUES
	(1,'Anthony','13564535304','$2y$10$R9V/c2pCiTqeetfFvRXaIO8qXGwo5b4QxOdz8Jwp8hvuCu6ieIdk6',NULL,'2020-09-25 17:05:50','2020-09-28 17:42:41'),
	(2,'Anthony','13564535305','$2y$10$xABonfXtP8Z3PrpBAHP5IOtxQ0sBE5Jk84TiUn/S2eYucSDV0np56',NULL,'2020-09-25 17:56:11','2020-09-27 16:10:20');

/*!40000 ALTER TABLE `fw_admins` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table fw_error_logs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `fw_error_logs`;

CREATE TABLE `fw_error_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `message` text COLLATE utf8mb4_unicode_ci,
  `uid` int NOT NULL DEFAULT '0',
  `channel` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `ip` char(15) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `breakpoint` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `api` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `params` text COLLATE utf8mb4_unicode_ci,
  `request_at` timestamp NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fw_error_logs_breakpoint_created_at_index` (`breakpoint`,`created_at`),
  KEY `fw_error_logs_api_index` (`api`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `fw_error_logs` WRITE;
/*!40000 ALTER TABLE `fw_error_logs` DISABLE KEYS */;

INSERT INTO `fw_error_logs` (`id`, `message`, `uid`, `channel`, `ip`, `breakpoint`, `api`, `params`, `request_at`, `created_at`)
VALUES
	(1,'[0] Illuminate\\Http\\Client\\ConnectionException: cURL error 7: Failed to connect to www.framework.com port 80: Connection refused (see https://curl.haxx.se/libcurl/c/libcurl-errors.html) in /var/www/project-framework-v8/vendor/laravel/framework/src/Illuminate/Http/Client/PendingRequest.php:568',0,'framework','127.0.0.1','error','',NULL,'2020-09-24 18:12:33','2020-09-25 14:17:42'),
	(2,'[0] Illuminate\\Http\\Client\\ConnectionException: cURL error 7: Failed to connect to www.framework.com port 80: Connection refused (see https://curl.haxx.se/libcurl/c/libcurl-errors.html) in /var/www/project-framework-v8/vendor/laravel/framework/src/Illuminate/Http/Client/PendingRequest.php:568',0,'framework','127.0.0.1','error','',NULL,'2020-09-24 18:12:36','2020-09-25 14:17:42'),
	(3,'[0] Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException:  in /var/www/project-framework-v8/vendor/laravel/framework/src/Illuminate/Routing/AbstractRouteCollection.php:43',0,'framework','172.24.0.1','error','',NULL,'2020-09-25 14:13:53','2020-09-25 14:17:42'),
	(4,'[0] Illuminate\\Contracts\\Container\\BindingResolutionException: Target [App\\Repositories\\Contracts\\ErrorLogRepository] is not instantiable while building [App\\Services\\LogService]. in /var/www/project-framework-v8/vendor/laravel/framework/src/Illuminate/Container/Container.php:1017',0,'framework','127.0.0.1','error','',NULL,'2020-09-25 14:15:19','2020-09-25 14:17:42'),
	(5,'[9001] App\\Exceptions\\BusinessException: 业务处理失败，原因：111 in /var/www/project-framework-v8/app/Http/Controllers/Auth/AdminLoginController.php:14',0,'framework','172.24.0.1','error','api/backend/v1/auth/admin-login/1/2','{\"mobile\":\"13564535302\",\"password\":\"123456\"}','2020-09-25 14:51:24','2020-09-25 14:51:45');

/*!40000 ALTER TABLE `fw_error_logs` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table fw_failed_jobs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `fw_failed_jobs`;

CREATE TABLE `fw_failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fw_failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table fw_migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `fw_migrations`;

CREATE TABLE `fw_migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `fw_migrations` WRITE;
/*!40000 ALTER TABLE `fw_migrations` DISABLE KEYS */;

INSERT INTO `fw_migrations` (`id`, `migration`, `batch`)
VALUES
	(1,'2014_10_12_000000_create_users_table',1),
	(2,'2014_10_12_100000_create_password_resets_table',1),
	(3,'2019_08_19_000000_create_failed_jobs_table',1),
	(4,'2020_04_30_232754_create_admins_table',1),
	(5,'2020_06_07_134026_create_error_logs_table',1),
	(6,'2020_06_07_170407_create_operate_logs_table',1),
	(7,'2020_09_24_175400_create_permission_tables',2),
	(8,'2020_10_03_125458_create_user_details_table',3),
	(9,'2020_10_03_125734_create_verify_codes_table',4);

/*!40000 ALTER TABLE `fw_migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table fw_model_has_permissions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `fw_model_has_permissions`;

CREATE TABLE `fw_model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `fw_model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `fw_permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table fw_model_has_roles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `fw_model_has_roles`;

CREATE TABLE `fw_model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `fw_model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `fw_roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `fw_model_has_roles` WRITE;
/*!40000 ALTER TABLE `fw_model_has_roles` DISABLE KEYS */;

INSERT INTO `fw_model_has_roles` (`role_id`, `model_type`, `model_id`)
VALUES
	(1,'App\\Models\\Admin',1),
	(2,'App\\Models\\Admin',2);

/*!40000 ALTER TABLE `fw_model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table fw_operate_logs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `fw_operate_logs`;

CREATE TABLE `fw_operate_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uid` int NOT NULL DEFAULT '0',
  `api` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `module` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `exec` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `ip` char(15) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `params` text COLLATE utf8mb4_unicode_ci,
  `operated_at` timestamp NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fw_operate_logs_uid_index` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table fw_password_resets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `fw_password_resets`;

CREATE TABLE `fw_password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `fw_password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table fw_permissions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `fw_permissions`;

CREATE TABLE `fw_permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `fw_permissions` WRITE;
/*!40000 ALTER TABLE `fw_permissions` DISABLE KEYS */;

INSERT INTO `fw_permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`)
VALUES
	(1,'添加管理员','admin','2020-10-03 00:28:15','2020-10-03 00:31:38'),
	(2,'修改管理员','admin','2020-10-02 11:29:42','2020-10-02 11:29:42'),
	(3,'删除管理员','admin','2020-10-02 11:29:47','2020-10-02 11:29:47'),
	(4,'管理员列表','admin','2020-10-02 11:30:04','2020-10-02 11:30:04'),
	(5,'管理员详情','admin','2020-10-02 11:30:19','2020-10-02 11:30:19');

/*!40000 ALTER TABLE `fw_permissions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table fw_role_has_permissions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `fw_role_has_permissions`;

CREATE TABLE `fw_role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `fw_role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `fw_role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `fw_permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fw_role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `fw_roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `fw_role_has_permissions` WRITE;
/*!40000 ALTER TABLE `fw_role_has_permissions` DISABLE KEYS */;

INSERT INTO `fw_role_has_permissions` (`permission_id`, `role_id`)
VALUES
	(2,2),
	(3,2),
	(4,2),
	(5,2);

/*!40000 ALTER TABLE `fw_role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table fw_roles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `fw_roles`;

CREATE TABLE `fw_roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `fw_roles` WRITE;
/*!40000 ALTER TABLE `fw_roles` DISABLE KEYS */;

INSERT INTO `fw_roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`)
VALUES
	(1,'超级管理员','admin','2020-10-02 22:26:34','2020-10-02 22:26:34'),
	(2,'管理员','admin','2020-10-02 23:36:48','2020-10-02 23:36:48');

/*!40000 ALTER TABLE `fw_roles` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table fw_user_details
# ------------------------------------------------------------

DROP TABLE IF EXISTS `fw_user_details`;

CREATE TABLE `fw_user_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL DEFAULT '0' COMMENT '关联用户id',
  `contact_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '联系人姓名',
  `qq` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'QQ',
  `contact_phone` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '联系电话',
  `company` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '公司名称',
  `province` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '所在省',
  `city` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '所在市',
  `district` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '所在区',
  `address` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '详细地址',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fw_user_details_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table fw_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `fw_users`;

CREATE TABLE `fw_users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '用户昵称',
  `wx_open_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `wx_union_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `mobile` char(11) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '手机号',
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '用户密码',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '用户状态',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fw_users_mobile_unique` (`mobile`),
  KEY `fw_users_wx_open_id_index` (`wx_open_id`),
  KEY `fw_users_wx_union_id_index` (`wx_union_id`),
  KEY `fw_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `fw_users` WRITE;
/*!40000 ALTER TABLE `fw_users` DISABLE KEYS */;

INSERT INTO `fw_users` (`id`, `name`, `wx_open_id`, `wx_union_id`, `mobile`, `email`, `password`, `status`, `deleted_at`, `created_at`, `updated_at`)
VALUES
	(1,'Anthony','','','13564535305','king19800105@163.com','$2y$10$llob8mKeC5oNFjHgYuUlh.ikTkCxnZHQnYryOcGKHeMjuyIolYbQK',0,NULL,'2020-09-29 10:31:09','2020-09-29 10:31:36');

/*!40000 ALTER TABLE `fw_users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table fw_verify_codes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `fw_verify_codes`;

CREATE TABLE `fw_verify_codes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint NOT NULL DEFAULT '0' COMMENT '验证码类型，1：注册，2：找回密码，3：用户信息修改',
  `code` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '验证码',
  `mobile` char(11) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '手机号码',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fw_verify_codes_mobile_created_at_index` (`mobile`,`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
