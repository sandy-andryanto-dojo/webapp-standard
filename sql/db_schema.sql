-- MySQL dump 10.13  Distrib 5.7.19, for Win64 (x86_64)
--
-- Host: localhost    Database: webapp_mini
-- ------------------------------------------------------
-- Server version	5.7.19

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `auth_audits`
--

DROP TABLE IF EXISTS `auth_audits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_audits` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `event` varchar(20) DEFAULT NULL,
  `url` varchar(45) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` longtext,
  `old_values` longtext,
  `new_values` longtext,
  `created_at` datetime DEFAULT NULL,
  `auditable_id` bigint(20) DEFAULT NULL,
  `auditable_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `auth_audits_user_id_idx` (`user_id`) USING BTREE,
  KEY `auth_audits_event_idx` (`event`) USING BTREE,
  KEY `auth_audits_url_idx` (`url`) USING BTREE,
  KEY `auth_audits_ip_address_idx` (`ip_address`) USING BTREE,
  KEY `auth_audits_created_at_idx` (`created_at`) USING BTREE,
  KEY `auth_audits_auditable_id_idx` (`auditable_id`) USING BTREE,
  KEY `auth_audits_auditable_type_idx` (`auditable_type`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `auth_configs`
--

DROP TABLE IF EXISTS `auth_configs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_configs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key_name` varchar(40) DEFAULT NULL,
  `key_slug` varchar(40) DEFAULT NULL,
  `key_value` longtext,
  `sort` int(11) DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `auth_configs_key_name_idx` (`key_name`) USING BTREE,
  KEY `auth_configs_key_slug_idx` (`key_slug`) USING BTREE,
  KEY `auth_configs_sort_idx` (`sort`) USING BTREE,
  KEY `auth_configs_category_idx` (`category`) USING BTREE,
  KEY `auth_configs_type_idx` (`type`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `auth_login_attempts`
--

DROP TABLE IF EXISTS `auth_login_attempts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_login_attempts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `auth_login_attempts_ip_address_idx` (`ip_address`) USING BTREE,
  KEY `auth_login_attempts_login_idx` (`login`) USING BTREE,
  KEY `auth_login_attempts_time_idx` (`time`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `auth_permissions`
--

DROP TABLE IF EXISTS `auth_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `route_id` bigint(20) unsigned DEFAULT NULL,
  `role_id` bigint(20) unsigned DEFAULT NULL,
  `can_view` tinyint(4) DEFAULT NULL,
  `can_create` tinyint(4) DEFAULT NULL,
  `can_edit` tinyint(4) DEFAULT NULL,
  `can_delete` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `auth_permissions_route_id_idx` (`route_id`) USING BTREE,
  KEY `auth_permissions_role_id_idx` (`role_id`) USING BTREE,
  KEY `auth_permissions_can_view_idx` (`can_view`) USING BTREE,
  KEY `auth_permissions_can_create_idx` (`can_create`) USING BTREE,
  KEY `auth_permissions_can_edit_idx` (`can_edit`) USING BTREE,
  KEY `auth_permissions_can_delete_idx` (`can_delete`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `auth_personals`
--

DROP TABLE IF EXISTS `auth_personals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_personals` (
  `user_id` bigint(20) unsigned NOT NULL,
  `image` text,
  `fullname` varchar(50) DEFAULT NULL,
  `nickname` varchar(50) DEFAULT NULL,
  `gender` tinyint(4) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `birth_place` varchar(50) DEFAULT NULL,
  `postal_code` varchar(50) DEFAULT NULL,
  `address` text,
  `about_me` text,
  `notes` text,
  PRIMARY KEY (`user_id`),
  KEY `auth_personals_user_id_idx` (`user_id`) USING BTREE,
  KEY `auth_personals_fullname_idx` (`fullname`) USING BTREE,
  KEY `auth_personals_nickname_idx` (`nickname`) USING BTREE,
  KEY `auth_personals_gender_idx` (`gender`) USING BTREE,
  KEY `auth_personals_birth_place_idx` (`birth_place`) USING BTREE,
  KEY `auth_personals_postal_code_idx` (`postal_code`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `auth_roles`
--

DROP TABLE IF EXISTS `auth_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) DEFAULT NULL,
  `description` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `active` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `auth_roles_name_idx` (`name`) USING BTREE,
  KEY `auth_roles_created_at_idx` (`created_at`) USING BTREE,
  KEY `auth_roles_updated_at_idx` (`updated_at`) USING BTREE,
  KEY `auth_roles_active_idx` (`active`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `auth_routes`
--

DROP TABLE IF EXISTS `auth_routes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_routes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(191) DEFAULT NULL,
  `icon` varchar(20) DEFAULT NULL,
  `url` varchar(191) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `auth_routes_parent_id_idx` (`parent_id`) USING BTREE,
  KEY `auth_routes_name_idx` (`name`) USING BTREE,
  KEY `auth_routes_icon_idx` (`icon`) USING BTREE,
  KEY `auth_routes_url_idx` (`url`) USING BTREE,
  KEY `auth_routes_sort_idx` (`sort`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `auth_sessions`
--

DROP TABLE IF EXISTS `auth_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  KEY `auth_sessions_ip_address_idx` (`ip_address`) USING BTREE,
  KEY `auth_sessions_timestamp_idx` (`timestamp`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `auth_user_roles`
--

DROP TABLE IF EXISTS `auth_user_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_user_roles` (
  `user_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `auth_user_roles_user_id_idx` (`user_id`) USING BTREE,
  KEY `auth_user_roles_role_id_idx` (`role_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `auth_users`
--

DROP TABLE IF EXISTS `auth_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(254) NOT NULL,
  `activation_selector` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `forgotten_password_selector` varchar(255) DEFAULT NULL,
  `forgotten_password_code` varchar(255) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_selector` varchar(255) DEFAULT NULL,
  `remember_code` varchar(255) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `homepage` text,
  PRIMARY KEY (`id`),
  KEY `auth_users_ip_address_idx` (`ip_address`) USING BTREE,
  KEY `auth_users_username_idx` (`username`) USING BTREE,
  KEY `auth_users_phone_idx` (`phone`) USING BTREE,
  KEY `auth_users_password_idx` (`password`) USING BTREE,
  KEY `auth_users_email_idx` (`email`) USING BTREE,
  KEY `auth_users_activation_selector_idx` (`activation_selector`) USING BTREE,
  KEY `auth_users_activation_code_idx` (`activation_code`) USING BTREE,
  KEY `auth_users_forgotten_password_selector_idx` (`forgotten_password_selector`) USING BTREE,
  KEY `auth_users_forgotten_password_code_idx` (`forgotten_password_code`) USING BTREE,
  KEY `auth_users_forgotten_password_time_idx` (`forgotten_password_time`) USING BTREE,
  KEY `auth_users_remember_selector_idx` (`remember_selector`) USING BTREE,
  KEY `auth_users_remember_code_idx` (`remember_code`) USING BTREE,
  KEY `auth_users_created_on_idx` (`created_on`) USING BTREE,
  KEY `auth_users_last_login_idx` (`last_login`) USING BTREE,
  KEY `auth_users_active_idx` (`active`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ref_contacts`
--

DROP TABLE IF EXISTS `ref_contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_contacts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) DEFAULT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `website` varchar(191) DEFAULT NULL,
  `address` text,
  `message` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `active` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ref_contacts_name_idx` (`name`) USING BTREE,
  KEY `ref_contacts_phone_idx` (`phone`) USING BTREE,
  KEY `ref_contacts_email_idx` (`email`) USING BTREE,
  KEY `ref_contacts_website_idx` (`website`) USING BTREE,
  KEY `ref_contacts_created_at_idx` (`created_at`) USING BTREE,
  KEY `ref_contacts_updated_at_idx` (`updated_at`) USING BTREE,
  KEY `ref_contacts_active_idx` (`active`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ref_macaddress`
--

DROP TABLE IF EXISTS `ref_macaddress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_macaddress` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` char(17) DEFAULT NULL,
  `description` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `active` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ref_macaddress_code_idx` (`code`) USING BTREE,
  KEY `ref_macaddress_created_at_idx` (`created_at`) USING BTREE,
  KEY `ref_macaddress_updated_at_idx` (`updated_at`) USING BTREE,
  KEY `ref_macaddress_active_idx` (`active`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary table structure for view `view_admin_roles`
--

DROP TABLE IF EXISTS `view_admin_roles`;
/*!50001 DROP VIEW IF EXISTS `view_admin_roles`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `view_admin_roles` AS SELECT 
 1 AS `id`,
 1 AS `name`,
 1 AS `description`,
 1 AS `created_at`,
 1 AS `updated_at`,
 1 AS `active`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `view_dt_auth_roles`
--

DROP TABLE IF EXISTS `view_dt_auth_roles`;
/*!50001 DROP VIEW IF EXISTS `view_dt_auth_roles`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `view_dt_auth_roles` AS SELECT 
 1 AS `id`,
 1 AS `name`,
 1 AS `description`,
 1 AS `created_at`,
 1 AS `updated_at`,
 1 AS `active`,
 1 AS `action`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `view_dt_auth_users`
--

DROP TABLE IF EXISTS `view_dt_auth_users`;
/*!50001 DROP VIEW IF EXISTS `view_dt_auth_users`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `view_dt_auth_users` AS SELECT 
 1 AS `id`,
 1 AS `image`,
 1 AS `ip_address`,
 1 AS `username`,
 1 AS `phone`,
 1 AS `password`,
 1 AS `email`,
 1 AS `activation_selector`,
 1 AS `activation_code`,
 1 AS `forgotten_password_selector`,
 1 AS `forgotten_password_code`,
 1 AS `forgotten_password_time`,
 1 AS `remember_selector`,
 1 AS `remember_code`,
 1 AS `created_on`,
 1 AS `last_login`,
 1 AS `active`,
 1 AS `homepage`,
 1 AS `groups`,
 1 AS `action`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `view_dt_ref_contacts`
--

DROP TABLE IF EXISTS `view_dt_ref_contacts`;
/*!50001 DROP VIEW IF EXISTS `view_dt_ref_contacts`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `view_dt_ref_contacts` AS SELECT 
 1 AS `id`,
 1 AS `name`,
 1 AS `phone`,
 1 AS `email`,
 1 AS `website`,
 1 AS `address`,
 1 AS `created_at`,
 1 AS `updated_at`,
 1 AS `active`,
 1 AS `action`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `view_dt_ref_macaddress`
--

DROP TABLE IF EXISTS `view_dt_ref_macaddress`;
/*!50001 DROP VIEW IF EXISTS `view_dt_ref_macaddress`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `view_dt_ref_macaddress` AS SELECT 
 1 AS `id`,
 1 AS `code`,
 1 AS `description`,
 1 AS `created_at`,
 1 AS `updated_at`,
 1 AS `active`,
 1 AS `action`*/;
SET character_set_client = @saved_cs_client;

--
-- Dumping routines for database 'webapp_mini'
--
/*!50003 DROP FUNCTION IF EXISTS `get_btn_action` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`devel`@`localhost` FUNCTION `get_btn_action`(id bigint, url text) RETURNS text CHARSET latin1
BEGIN  



































		DECLARE bt_action text;



































		DECLARE btn_view text;   



































		DECLARE btn_edit text;   



































		DECLARE btn_delete text;   



































		SET btn_view = '&nbsp;<a href="|url|" data-id="|id|" class="btn btn-action btn-sm btn-detail btn-default" data-toggle="tooltip" title="Lihat Detail"><i class="fa fa-search"></i></a>';



































		SET btn_edit = '&nbsp;<a href="|url|" data-id="|id|" class="btn btn-action btn-sm btn-info btn-edit" data-toggle="tooltip" title="Edit Data"><i class="fa fa-edit"></i></a>';



































		SET btn_delete = '&nbsp;<a href="|url|" data-id="|id|" class="btn btn-action btn-sm btn-danger btn-delete" data-toggle="tooltip" title="Hapus Data"><i class="fa fa-trash"></i></a>';



































		SET bt_action = REPLACE(CONCAT(btn_view, btn_edit, btn_delete), '|url|', url);



































		SET bt_action = REPLACE(bt_action, '|id|', id);



































		RETURN bt_action;



































END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `get_clean_string` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`devel`@`localhost` FUNCTION `get_clean_string`(str longtext) RETURNS longtext CHARSET latin1
    DETERMINISTIC
BEGIN 



































	SET str = TRIM(str);



































	SET str = LOWER(str);



































	SET str = REPLACE(str, ' ', '');



































	SET str = REPLACE(str, '-', '');



































	SET str = REPLACE(str, '/', '');



































	SET str = REPLACE(str, '\\', '');



































  RETURN str;



































END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `strip_tags` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`devel`@`localhost` FUNCTION `strip_tags`(`s` TEXT





) RETURNS text CHARSET latin1
    DETERMINISTIC
BEGIN





DECLARE start,end INT DEFAULT 1; 





  LOOP 





    SET start = LOCATE("<", s, start);





    IF (!start) THEN RETURN s; END IF;





    SET end = LOCATE(">", s, start);





    IF (!end) THEN SET end = start; END IF;





    SET s = INSERT(s, start, end - start + 1, "");





  END LOOP;





END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Final view structure for view `view_admin_roles`
--

/*!50001 DROP VIEW IF EXISTS `view_admin_roles`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`devel`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_admin_roles` AS select `auth_roles`.`id` AS `id`,`auth_roles`.`name` AS `name`,`auth_roles`.`description` AS `description`,`auth_roles`.`created_at` AS `created_at`,`auth_roles`.`updated_at` AS `updated_at`,`auth_roles`.`active` AS `active` from `auth_roles` where ((not((`auth_roles`.`name` like '%members%'))) or (not((`auth_roles`.`name` like '%member%')))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_dt_auth_roles`
--

/*!50001 DROP VIEW IF EXISTS `view_dt_auth_roles`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`devel`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_dt_auth_roles` AS select `a`.`id` AS `id`,`a`.`name` AS `name`,`a`.`description` AS `description`,`a`.`created_at` AS `created_at`,`a`.`updated_at` AS `updated_at`,`a`.`active` AS `active`,(case when (`a`.`name` = 'admin') then NULL else `get_btn_action`(`a`.`id`,'setting/role') end) AS `action` from `auth_roles` `a` where (`a`.`active` = 1) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_dt_auth_users`
--

/*!50001 DROP VIEW IF EXISTS `view_dt_auth_users`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`devel`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_dt_auth_users` AS select `a`.`id` AS `id`,`d`.`image` AS `image`,`a`.`ip_address` AS `ip_address`,`a`.`username` AS `username`,`a`.`phone` AS `phone`,`a`.`password` AS `password`,`a`.`email` AS `email`,`a`.`activation_selector` AS `activation_selector`,`a`.`activation_code` AS `activation_code`,`a`.`forgotten_password_selector` AS `forgotten_password_selector`,`a`.`forgotten_password_code` AS `forgotten_password_code`,`a`.`forgotten_password_time` AS `forgotten_password_time`,`a`.`remember_selector` AS `remember_selector`,`a`.`remember_code` AS `remember_code`,`a`.`created_on` AS `created_on`,`a`.`last_login` AS `last_login`,`a`.`active` AS `active`,`a`.`homepage` AS `homepage`,group_concat(upper(`c`.`name`) separator ',') AS `groups`,`get_btn_action`(`a`.`id`,'setting/user') AS `action` from (((`auth_users` `a` join `auth_user_roles` `b` on((`b`.`user_id` = `a`.`id`))) join `auth_roles` `c` on((`c`.`id` = `b`.`role_id`))) join `auth_personals` `d` on((`d`.`user_id` = `a`.`id`))) where (`a`.`active` = 1) group by `d`.`image`,`a`.`id`,`a`.`ip_address`,`a`.`username`,`a`.`phone`,`a`.`password`,`a`.`email`,`a`.`activation_selector`,`a`.`activation_code`,`a`.`forgotten_password_selector`,`a`.`forgotten_password_code`,`a`.`forgotten_password_time`,`a`.`remember_selector`,`a`.`remember_code`,`a`.`created_on`,`a`.`last_login`,`a`.`active`,`a`.`homepage` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_dt_ref_contacts`
--

/*!50001 DROP VIEW IF EXISTS `view_dt_ref_contacts`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`devel`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_dt_ref_contacts` AS select `ref_contacts`.`id` AS `id`,`ref_contacts`.`name` AS `name`,`ref_contacts`.`phone` AS `phone`,`ref_contacts`.`email` AS `email`,`ref_contacts`.`website` AS `website`,`ref_contacts`.`address` AS `address`,`ref_contacts`.`created_at` AS `created_at`,`ref_contacts`.`updated_at` AS `updated_at`,`ref_contacts`.`active` AS `active`,`get_btn_action`(`ref_contacts`.`id`,'reference/contact') AS `action` from `ref_contacts` where (`ref_contacts`.`active` = 1) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_dt_ref_macaddress`
--

/*!50001 DROP VIEW IF EXISTS `view_dt_ref_macaddress`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`devel`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_dt_ref_macaddress` AS select `a`.`id` AS `id`,`a`.`code` AS `code`,`a`.`description` AS `description`,`a`.`created_at` AS `created_at`,`a`.`updated_at` AS `updated_at`,`a`.`active` AS `active`,`get_btn_action`(`a`.`id`,'setting/mac_address') AS `action` from `ref_macaddress` `a` where (`a`.`active` = 1) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-07-08  1:20:22
