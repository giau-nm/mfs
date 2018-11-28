-- MySQL dump 10.13  Distrib 5.7.23, for Linux (x86_64)
--
-- Host: localhost    Database: msf
-- ------------------------------------------------------
-- Server version	5.7.23-0ubuntu0.18.04.1

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
-- Table structure for table `agents`
--

DROP TABLE IF EXISTS `agents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doanh_so` int(11) DEFAULT NULL,
  `ho_ten` text,
  `email` varchar(45) DEFAULT NULL,
  `so_dien_thoai` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agents`
--

LOCK TABLES `agents` WRITE;
/*!40000 ALTER TABLE `agents` DISABLE KEYS */;
INSERT INTO `agents` VALUES (1,71120,'Nguyễn Thị Viên',NULL,NULL,'2018-11-27 00:58:05','2018-11-27 00:58:05',NULL);
/*!40000 ALTER TABLE `agents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `configs`
--

DROP TABLE IF EXISTS `configs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `configs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `chatwork_room_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `chatwork_token` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `deleted_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configs`
--

LOCK TABLES `configs` WRITE;
/*!40000 ALTER TABLE `configs` DISABLE KEYS */;
/*!40000 ALTER TABLE `configs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `criterias`
--

DROP TABLE IF EXISTS `criterias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `criterias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ma` varchar(45) NOT NULL,
  `tieu_chi_lon` text,
  `tieu_chi_nho` text,
  `dat_neu` text,
  `so_diem_duoc_neu_dat` text,
  `khong_dat_neu` text,
  `so_diem_mat_neu_khong_dat` text,
  `mac_loi_nghiem_trong` text,
  `so_diem_mat_neu_mac_loi_nghiem_trong` tinytext,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `criterias`
--

LOCK TABLES `criterias` WRITE;
/*!40000 ALTER TABLE `criterias` DISABLE KEYS */;
INSERT INTO `criterias` VALUES (1,'greeting','Tiếp nhận cuộc gọi','Chào đón khách hàng','- Xưng danh số rõ ràng, giọng truyền cảm, đảm bảo KH nghe thấy\r\n- Chào đón KH với thái độ niềm nở, thể hiện sự sẵn sàng hỗ trợ \r\n- Nếu không nghe rõ tín hiệu, ĐTV kiên nhẫn \"dạ, alo\" 3 lần, mỗi lần cách nhau 3s để chờ tín hiệu','Toàn bộ điểm của tiêu chí','- Xưng danh số không đầy đủ theo mẫu câu chuẩn\r\n- Xưng danh số  thiếu mã số hoặc sai danh số, không xưng danh số\r\n- Xưng danh quá nhanh hoặc quá nhỏ, KH không nghe được','Toàn bộ điểm của tiêu chí','- Nhấc máy nhưng tỏ vẻ như không nghe rõ và cúp máy trước KH với tần suất 1 lần/tháng ---> Hạ 01 bậc KPIs\r\n- Nhấc máy nhưng tỏ vẻ như không nghe rõ và cúp máy trước KH với tần suất 2 lần/tháng ---> Hạ KPIs Yếu','Toàn bộ điểm của tiêu chí','2018-11-27 00:34:53','2018-11-27 00:34:53',NULL);
/*!40000 ALTER TABLE `criterias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `devices`
--

DROP TABLE IF EXISTS `devices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `devices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `code` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `screen_size` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `os` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manufacture` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `carrier` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `phone_number` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imei` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `udid` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `checked_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `devices_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `devices`
--

LOCK TABLES `devices` WRITE;
/*!40000 ALTER TABLE `devices` DISABLE KEYS */;
INSERT INTO `devices` VALUES (1,'Ericka Predovic',0,'1','697447','iOS','Mobie','Taylor Roob','Dr. Carlie Yost','Aut omnis expedita exercitationem quidem sit. Sed omnis totam alias maxime. Et voluptas culpa inventore non repellat aut. Nobis dicta perferendis iusto natus quibusdam sit aut.','1-754-747-2423 x7069','7126','41797067','120528197',NULL,'2018-11-26 21:22:15','2018-11-26 21:22:15',NULL),(2,'Teresa Fay',0,'2','594058150','iOS','Mobie','Millie West','Syble Wintheiser','Beatae et quo occaecati magni soluta repudiandae. Nesciunt inventore vero aut id delectus. Doloribus voluptatem in eius. Laborum sequi ut in in ea.','1-426-289-4467 x7585','366','5133','5257704',NULL,'2018-11-26 21:22:15','2018-11-26 21:22:15',NULL),(3,'Paolo Schneider',0,'3','184','iOS','Mobie','Isabelle Rath I','Prof. Alfred Anderson Jr.','Quia ex dolorem vero libero reiciendis modi. Ut dolores praesentium blanditiis et eum. Et voluptatem in reiciendis iste est impedit.','1-919-490-2303','76349177','10469','860296963',NULL,'2018-11-26 21:22:15','2018-11-26 21:22:15',NULL),(4,'Dr. Raoul Legros',0,'4','6','iOS','Mobie','Emerson Hills','Izabella Marquardt','Sed nemo vel labore modi. Quo corrupti ea omnis dolor cum. Doloribus voluptatem eius perspiciatis esse recusandae sint. Neque consequatur ratione sint blanditiis vel.','927.434.6288','8831','551450','993774',NULL,'2018-11-26 21:22:15','2018-11-26 21:22:15',NULL),(5,'Jarred Lowe',0,'5','473387601','iOS','Mobie','Jaylen Nader','Michael Daniel','Commodi voluptas eum dolorem cumque nemo temporibus. Dolores nesciunt cum doloribus est beatae aut.','+14816369219','21313','19069699','72',NULL,'2018-11-26 21:22:15','2018-11-26 21:22:15',NULL),(6,'Rodger Stracke',0,'6','92','iOS','Mobie','D\'angelo O\'Reilly','Dr. Leonor Wunsch','Illo eos optio omnis dolorum. Repudiandae natus quae rerum aut.','220.495.2324 x313','39871','867','21564',NULL,'2018-11-26 21:22:15','2018-11-26 21:22:15',NULL),(7,'Benton Bartell',0,'7','396','iOS','Mobie','Webster Johnston','Amber Deckow','Sint deleniti itaque voluptatibus earum dolor qui necessitatibus. Harum qui rerum molestiae magni sed. Laudantium distinctio qui dolore facilis animi nihil voluptas.','725.349.1079 x046','22735526','90190033','16',NULL,'2018-11-26 21:22:15','2018-11-26 21:22:15',NULL),(8,'Stan Dickinson',0,'8','90453409','iOS','Mobie','Ms. Alana Kuphal Sr.','Wilhelm Upton','Provident similique est aliquam. Ullam autem magni sunt sed voluptatum. Et temporibus dolores sit ab assumenda. Laboriosam placeat ea occaecati. Eaque laboriosam laudantium est corrupti beatae qui.','952.515.6359','483260498','862565','18031693',NULL,'2018-11-26 21:22:15','2018-11-26 21:22:15',NULL),(9,'Ms. Leda Swift DVM',0,'9','29028893','iOS','Mobie','Mrs. Stacey Emard','Mr. Gaylord Nitzsche','Dolores aspernatur necessitatibus enim excepturi explicabo repudiandae magnam. Repudiandae libero quasi vitae aut. Sunt ex ipsa quia non quia doloribus.','1-651-450-0129','802','3374','546295',NULL,'2018-11-26 21:22:15','2018-11-26 21:22:15',NULL),(10,'Ms. Alia Nolan',0,'10','1','iOS','Mobie','Prof. Pink Jenkins','Jedidiah Cremin','Velit cupiditate dolor soluta soluta beatae ut. Quisquam dolores modi et dolor. Sit quaerat mollitia non magnam mollitia aut. Delectus reprehenderit ut distinctio illum explicabo in et.','1-529-387-1712 x241','383354','53','2745086',NULL,'2018-11-26 21:22:15','2018-11-26 21:22:15',NULL);
/*!40000 ALTER TABLE `devices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email_histories`
--

DROP TABLE IF EXISTS `email_histories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `email_histories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email_histories`
--

LOCK TABLES `email_histories` WRITE;
/*!40000 ALTER TABLE `email_histories` DISABLE KEYS */;
/*!40000 ALTER TABLE `email_histories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2018_08_08_062654_create_projects_table',1),(4,'2018_08_08_062933_create_devices_table',1),(5,'2018_08_08_064407_create_requests_table',1),(6,'2018_08_08_065020_create_reports_table',1),(7,'2018_08_08_071252_add_type_users',1),(8,'2018_08_09_040836_add_null_to_tables',1),(9,'2018_08_09_044356_remove_checked_at_from_devices',1),(10,'2018_08_09_044543_add_checked_at_to_devices',1),(11,'2018_08_14_101428_create_email_histories_table',1),(12,'2018_08_27_090214_remove_required_project_id_request_table',1),(13,'2018_08_27_154821_add_admin_note_request',1),(14,'2018_09_06_135801_add_column_chatwork_id_to_users_table',1),(15,'2018_09_13_135258_create_configs_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mistakes`
--

DROP TABLE IF EXISTS `mistakes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mistakes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ten` text,
  `mo_ta` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mistakes`
--

LOCK TABLES `mistakes` WRITE;
/*!40000 ALTER TABLE `mistakes` DISABLE KEYS */;
INSERT INTO `mistakes` VALUES (1,'Tư vấn TT cước',NULL,'2018-11-27 00:49:58','2018-11-27 00:49:58',NULL);
/*!40000 ALTER TABLE `mistakes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `manager` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (1,'Suzanne Schuster',1,NULL,'2018-11-26 21:22:15','2018-11-26 21:22:15'),(2,'Valerie Zieme IV',2,NULL,'2018-11-26 21:22:15','2018-11-26 21:22:15'),(3,'Alexander Abernathy',3,NULL,'2018-11-26 21:22:15','2018-11-26 21:22:15'),(4,'Marquise Hettinger',4,NULL,'2018-11-26 21:22:15','2018-11-26 21:22:15'),(5,'Mason Heathcote',5,NULL,'2018-11-26 21:22:15','2018-11-26 21:22:15'),(6,'Dr. Magnolia Blick MD',6,NULL,'2018-11-26 21:22:15','2018-11-26 21:22:15'),(7,'Eldridge Marquardt IV',7,NULL,'2018-11-26 21:22:15','2018-11-26 21:22:15'),(8,'Rosario Keebler',8,NULL,'2018-11-26 21:22:15','2018-11-26 21:22:15'),(9,'Dr. Scotty Schiller II',9,NULL,'2018-11-26 21:22:15','2018-11-26 21:22:15'),(10,'Marion Howe',10,NULL,'2018-11-26 21:22:15','2018-11-26 21:22:15');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rating_levels`
--

DROP TABLE IF EXISTS `rating_levels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rating_levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ma` varchar(45) DEFAULT NULL,
  `ten` varchar(45) DEFAULT NULL,
  `diem_tu` int(11) DEFAULT NULL,
  `diem_den` int(11) DEFAULT NULL,
  `mo_ta` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rating_levels`
--

LOCK TABLES `rating_levels` WRITE;
/*!40000 ALTER TABLE `rating_levels` DISABLE KEYS */;
INSERT INTO `rating_levels` VALUES (1,'bad','Kém',NULL,4,NULL,'2018-11-27 00:40:41','2018-11-27 00:40:41',NULL);
/*!40000 ALTER TABLE `rating_levels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reports` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `device_id` int(11) NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `status` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports`
--

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `request_types`
--

DROP TABLE IF EXISTS `request_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `request_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ma` text NOT NULL,
  `tieu_de` text NOT NULL,
  `mo_ta` text,
  `chao_don_khach_hang` int(11) DEFAULT NULL,
  `nam_bat_nhu_cau` int(11) DEFAULT NULL,
  `dua_phuong_an_dung` int(11) DEFAULT NULL,
  `dien_dat` int(11) DEFAULT NULL,
  `thuyet_phuc` int(11) DEFAULT NULL,
  `y_thuc` int(11) DEFAULT NULL,
  `cam_on` int(11) DEFAULT NULL,
  `ghi_nhan_thong_tin` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `request_types`
--

LOCK TABLES `request_types` WRITE;
/*!40000 ALTER TABLE `request_types` DISABLE KEYS */;
INSERT INTO `request_types` VALUES (8,'tu-van-thong-tin','Tư vấn thông tin','',2,15,12,20,10,30,1,10,'2018-11-26 23:16:49','2018-11-26 23:16:49',NULL);
/*!40000 ALTER TABLE `request_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `requests`
--

DROP TABLE IF EXISTS `requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `requests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `device_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `is_long_time` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `actual_start_time` datetime DEFAULT NULL,
  `actual_end_time` datetime DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `admin_note` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `requests`
--

LOCK TABLES `requests` WRITE;
/*!40000 ALTER TABLE `requests` DISABLE KEYS */;
INSERT INTO `requests` VALUES (1,1,1,1,1,1,'2018-08-14 13:17:23','2018-08-14 13:17:24',NULL,NULL,'Ad quidem officiis alias odit vel. Exercitationem ad aut error consequuntur quia incidunt ullam. Praesentium veniam enim hic. Non quaerat quia enim ut.',NULL,'2018-11-26 21:22:15','2018-11-26 21:22:15',NULL),(2,2,2,2,1,1,'2018-08-14 13:17:23','2018-08-14 13:17:24',NULL,NULL,'Sit consectetur deleniti velit sint rerum. Omnis quibusdam numquam nemo qui quod dolorem ipsam. Impedit dolores accusantium fugiat.',NULL,'2018-11-26 21:22:15','2018-11-26 21:22:15',NULL),(3,3,3,3,1,1,'2018-08-14 13:17:23','2018-08-14 13:17:24',NULL,NULL,'Ut delectus et facilis officia voluptas. Perferendis sint impedit dolore in omnis laudantium. Sed nulla ducimus voluptatum qui vero suscipit commodi.',NULL,'2018-11-26 21:22:15','2018-11-26 21:22:15',NULL),(4,4,4,4,1,1,'2018-08-14 13:17:23','2018-08-14 13:17:24',NULL,NULL,'Quia dolor omnis natus consectetur impedit perspiciatis repellendus rerum. Similique labore et aliquid impedit natus harum nam. Aut quaerat quia error.',NULL,'2018-11-26 21:22:15','2018-11-26 21:22:15',NULL),(5,5,5,5,1,1,'2018-08-14 13:17:23','2018-08-14 13:17:24',NULL,NULL,'Reiciendis fuga quisquam voluptatibus harum in. Et sit ab mollitia consequatur dolor. Ut id natus ut sunt pariatur occaecati velit. Nobis ab dolores officia accusantium atque veniam in voluptatem.',NULL,'2018-11-26 21:22:15','2018-11-26 21:22:15',NULL),(6,6,6,6,1,1,'2018-08-14 13:17:23','2018-08-14 13:17:24',NULL,NULL,'Fugiat est qui aliquid. Et tempore quas ratione totam. Repudiandae ea et nostrum. Ut et nam provident. Inventore blanditiis suscipit aut veritatis dolores harum dolor beatae.',NULL,'2018-11-26 21:22:15','2018-11-26 21:22:15',NULL),(7,7,7,7,1,1,'2018-08-14 13:17:23','2018-08-14 13:17:24',NULL,NULL,'Et laborum aperiam praesentium dolores. Asperiores optio quas animi repudiandae adipisci. Reiciendis dolore error et eum quo aperiam nobis. Non magnam aut nobis nihil. Dignissimos a alias placeat.',NULL,'2018-11-26 21:22:15','2018-11-26 21:22:15',NULL),(8,8,8,8,1,1,'2018-08-14 13:17:23','2018-08-14 13:17:24',NULL,NULL,'Earum in alias vero nostrum sunt fuga aperiam similique. Molestiae aspernatur facere rem et porro. Iste soluta ea impedit recusandae iste.',NULL,'2018-11-26 21:22:15','2018-11-26 21:22:15',NULL),(9,9,9,9,1,1,'2018-08-14 13:17:23','2018-08-14 13:17:24',NULL,NULL,'Eum perspiciatis repellat fugiat sunt quis. Recusandae ratione cumque et dicta debitis consequuntur. Ut nam officiis accusamus qui tempore aliquid vel.',NULL,'2018-11-26 21:22:15','2018-11-26 21:22:15',NULL),(10,10,10,10,1,1,'2018-08-14 13:17:23','2018-08-14 13:17:24',NULL,NULL,'Officiis non exercitationem in quam sit adipisci. Enim totam recusandae dolores aliquid. Nam dignissimos voluptas consequatur quos.',NULL,'2018-11-26 21:22:15','2018-11-26 21:22:15',NULL);
/*!40000 ALTER TABLE `requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `results`
--

DROP TABLE IF EXISTS `results`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ma` int(11) DEFAULT NULL,
  `ten` text,
  `mo_ta` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `results`
--

LOCK TABLES `results` WRITE;
/*!40000 ALTER TABLE `results` DISABLE KEYS */;
INSERT INTO `results` VALUES (1,1,'Cuộc gọi chưa đạt nghiệp vụ ký hiệu',NULL,'2018-11-27 00:45:32','2018-11-27 00:45:32',NULL);
/*!40000 ALTER TABLE `results` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nhom_tai_khoan` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Nguyễn Mạnh Giầu','giaunm.562@gmail.com','123456','1674314498','Quản trị hệ thống(administrator)',NULL,'2018-11-26 21:22:14','2018-11-28 06:52:26',1,'2018-11-28 06:52:26','Cổ Nhuế 2, Từ Liêm, Hà Nội'),(2,'Jed Pfeffer','ismith@boyle.com','123456',NULL,NULL,NULL,'2018-11-26 21:22:14','2018-11-28 06:53:03',1,'2018-11-28 06:53:03',NULL),(3,'Dr. Lucious Price IV','jcremin@gmail.com','123456',NULL,NULL,NULL,'2018-11-26 21:22:14','2018-11-28 07:00:59',1,'2018-11-28 07:00:59',NULL),(4,'Laurianne Borer PhD','vergie91@hotmail.com','123456',NULL,NULL,NULL,'2018-11-26 21:22:14','2018-11-28 07:01:04',1,'2018-11-28 07:01:04',NULL),(5,'Margarete Jacobs Jr.','nreynolds@hotmail.com','123456',NULL,NULL,NULL,'2018-11-26 21:22:14','2018-11-28 07:01:08',1,'2018-11-28 07:01:08',NULL),(6,'Sylvia Wehner','berniece.towne@vonrueden.org','123456',NULL,NULL,NULL,'2018-11-26 21:22:14','2018-11-28 07:01:12',1,'2018-11-28 07:01:12',NULL),(7,'Kelli West','ehirthe@stiedemann.com','123456',NULL,NULL,NULL,'2018-11-26 21:22:14','2018-11-28 07:01:17',1,'2018-11-28 07:01:17',NULL),(8,'Mr. Sterling Howe V','arne54@funk.info','123456',NULL,NULL,NULL,'2018-11-26 21:22:14','2018-11-28 07:01:21',1,'2018-11-28 07:01:21',NULL),(9,'Jayme Stark','labadie.pansy@yahoo.com','123456',NULL,NULL,NULL,'2018-11-26 21:22:14','2018-11-28 07:05:39',1,'2018-11-28 07:05:39',NULL),(10,'Faustino Kuvalis','yost.cleo@yahoo.com','123456',NULL,NULL,NULL,'2018-11-26 21:22:14','2018-11-28 07:05:46',1,'2018-11-28 07:05:46',NULL),(11,'Maynard Gusikowski','mraz.kelsi@raynor.info','123456',NULL,NULL,NULL,'2018-11-26 21:22:15','2018-11-28 07:05:58',0,'2018-11-28 07:05:58',NULL),(12,'Gideon Kub','pkoss@hackett.com','123456',NULL,NULL,NULL,'2018-11-26 21:22:15','2018-11-28 07:05:48',0,'2018-11-28 07:05:48',NULL),(13,'Faye Koss','cruickshank.stewart@stracke.biz','123456',NULL,NULL,NULL,'2018-11-26 21:22:15','2018-11-28 07:06:02',0,'2018-11-28 07:06:02',NULL),(14,'Barry Kshlerin','carole.aufderhar@mohr.info','123456',NULL,NULL,NULL,'2018-11-26 21:22:15','2018-11-28 07:06:05',0,'2018-11-28 07:06:05',NULL),(15,'Frances McCullough','tblock@heller.info','123456',NULL,NULL,NULL,'2018-11-26 21:22:15','2018-11-28 07:05:50',0,'2018-11-28 07:05:50',NULL),(16,'Chaim Thompson Sr.','gabbott@gmail.com','123456',NULL,NULL,NULL,'2018-11-26 21:22:15','2018-11-28 07:06:10',0,'2018-11-28 07:06:10',NULL),(17,'Onie Pfannerstill','kautzer.rossie@hotmail.com','123456',NULL,NULL,NULL,'2018-11-26 21:22:15','2018-11-28 07:06:13',0,'2018-11-28 07:06:13',NULL),(18,'Lizeth Satterfield','rasheed35@hotmail.com','123456',NULL,NULL,NULL,'2018-11-26 21:22:15','2018-11-28 07:06:17',0,'2018-11-28 07:06:17',NULL),(19,'Lorna Barton','howell.alice@gmail.com','123456',NULL,NULL,NULL,'2018-11-26 21:22:15','2018-11-28 07:06:20',0,'2018-11-28 07:06:20',NULL),(20,'Shanon Hermiston','azboncak@blanda.com','123456',NULL,NULL,NULL,'2018-11-26 21:22:15','2018-11-28 07:06:25',0,'2018-11-28 07:06:25',NULL),(21,'Giau Nguyen Manh','giaunm.56@gmail.com','e10adc3949ba59abbe56e057f20f883e','16743144980','Quản trị hệ thống(administrator)','08IBw2k9QyoEPNdPUl2FdpEdrsVSHeWpvljLdA72x5tbNnXP0Vo7s1XuQ2Ls','2018-11-26 21:28:25','2018-11-28 07:06:33',1,NULL,'Cổ Nhuế 2, Từ Liêm, Hà Nội'),(22,'Nguyễn Mạnh Giầu','giaunm.563@gmail.com','a424ed4bd3a7d6aea720b86d4a360f75','1674314498','Điện thoại viên',NULL,NULL,NULL,0,NULL,'Cổ Nhuế 2, Từ Liêm, Hà Nội');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `workgroups`
--

DROP TABLE IF EXISTS `workgroups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `workgroups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ten` varchar(45) DEFAULT NULL,
  `tieu_de` text,
  `mo_ta` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `workgroups`
--

LOCK TABLES `workgroups` WRITE;
/*!40000 ALTER TABLE `workgroups` DISABLE KEYS */;
INSERT INTO `workgroups` VALUES (1,'tu-van','Tư vấn',NULL,'2018-11-27 00:53:53','2018-11-27 00:53:53',NULL);
/*!40000 ALTER TABLE `workgroups` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-11-28  0:22:56
