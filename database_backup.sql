-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: srikandi
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `klasifikasi_surat`
--

DROP TABLE IF EXISTS `klasifikasi_surat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `klasifikasi_surat` (
  `id_klasifikasi_surat` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode_klasifikasi_surat` varchar(50) NOT NULL,
  `nama_klasifikasi_surat` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_klasifikasi_surat`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `klasifikasi_surat`
--

LOCK TABLES `klasifikasi_surat` WRITE;
/*!40000 ALTER TABLE `klasifikasi_surat` DISABLE KEYS */;
INSERT INTO `klasifikasi_surat` VALUES (1,'MI-Jangmed','MI Jangmed','2024-09-04 07:29:06','2024-09-04 07:29:06');
/*!40000 ALTER TABLE `klasifikasi_surat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2024_08_26_102820_create_sifat_surat_table',1),(6,'2024_08_27_130228_create_klasifikasi_surat_table',1),(10,'2024_09_04_114021_create_pengajuan_libur_table',2),(11,'2024_09_17_182457_create_pengajuan_lembur_table',3),(29,'2024_09_24_200413_create_struktur_organisasi_table',4),(30,'2024_09_27_191823_create_surat_table',4),(31,'2024_09_27_195738_create_verifikasi_surat_table',4);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `username` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengajuan_lembur`
--

DROP TABLE IF EXISTS `pengajuan_lembur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pengajuan_lembur` (
  `id_pengajuan_lembur` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode_pengajuan_lembur` varchar(11) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `keterangan` text NOT NULL,
  `tanggal_lembur` date NOT NULL,
  `jam_awal` time NOT NULL,
  `jam_akhir` time NOT NULL,
  `nik_atasan_langsung` varchar(20) NOT NULL,
  `status` enum('Dikirim','Disetujui','Ditolak') NOT NULL DEFAULT 'Dikirim',
  `catatan` text DEFAULT NULL,
  `tanggal_dibuat` datetime NOT NULL DEFAULT current_timestamp(),
  `tanggal_verifikasi` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_pengajuan_lembur`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengajuan_lembur`
--

LOCK TABLES `pengajuan_lembur` WRITE;
/*!40000 ALTER TABLE `pengajuan_lembur` DISABLE KEYS */;
INSERT INTO `pengajuan_lembur` VALUES (2,'LM-000001','229.06.11.2017','ok33xxxxxxxxxxxx','2024-09-18','12:00:00','13:00:00','278.21.11.2018','Disetujui','Yesss','2024-09-17 22:11:24','2024-09-24 16:26:44','2024-09-17 15:11:24','2024-09-24 09:26:44');
/*!40000 ALTER TABLE `pengajuan_lembur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengajuan_libur`
--

DROP TABLE IF EXISTS `pengajuan_libur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pengajuan_libur` (
  `id_pengajuan_libur` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode_pengajuan_libur` varchar(11) NOT NULL,
  `jenis_pengajuan_libur` enum('Ijin','Tahunan','Melahirkan','Ambil Libur','Menikah') NOT NULL DEFAULT 'Ijin',
  `nik` varchar(20) NOT NULL,
  `alamat` text DEFAULT NULL,
  `keterangan` text NOT NULL,
  `tanggal_awal` date NOT NULL,
  `tanggal_akhir` date NOT NULL,
  `jumlah_hari` int(10) unsigned NOT NULL,
  `nik_atasan_langsung` varchar(20) NOT NULL,
  `status` enum('Dikirim','Disetujui','Ditolak') NOT NULL DEFAULT 'Dikirim',
  `catatan` text DEFAULT NULL,
  `foto` varchar(200) DEFAULT NULL,
  `tanggal_dibuat` datetime NOT NULL DEFAULT current_timestamp(),
  `tanggal_verifikasi` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_pengajuan_libur`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengajuan_libur`
--

LOCK TABLES `pengajuan_libur` WRITE;
/*!40000 ALTER TABLE `pengajuan_libur` DISABLE KEYS */;
INSERT INTO `pengajuan_libur` VALUES (1,'PL-000001','Tahunan','229.06.11.2017','dadadadadad','Kepentingan Keluarga','2024-09-06','2024-09-07',2,'278.21.11.2018','Disetujui','adadaddadd',NULL,'2024-09-06 21:50:09','2024-09-07 21:01:45','2024-09-06 07:50:09','2024-09-07 14:01:45'),(27,'PL-000002','Ijin','229.06.11.2017',NULL,'Kepentingan Keluargaxxxxxxxxxxx','2024-09-13','2024-09-14',2,'278.21.11.2018','Disetujui','Silahkan','uploads/ijin_files/1726224924_3d252340-db17-11ec-968e-000c29cc32a6_dr-perdana-airlangga-199x300-removebg-preview-199x300_waifu2x_photo_noise3_scale.png','2024-09-13 17:50:30','2024-09-17 17:37:15','2024-09-13 10:50:30','2024-09-17 10:37:15'),(28,'PL-000028','Tahunan','278.21.11.2018','dadsd','Uji Coba','2024-09-26','2024-09-26',1,'16.23.02.2008','Dikirim',NULL,NULL,'2024-09-26 09:32:30',NULL,'2024-09-26 02:32:30','2024-09-26 02:32:30'),(29,'PL-000029','Ijin','278.21.11.2018',NULL,'Kepentingan Keluarga','2024-09-25','2024-09-27',3,'229.06.11.2017','Dikirim',NULL,'uploads/ijin_files/1727323913_pse rsasf.pdf','2024-09-26 11:11:53',NULL,'2024-09-26 04:11:53','2024-09-26 04:11:53'),(30,'PL-000030','Ambil Libur','229.06.11.2017','a','Kepentingan Keluarga','2024-09-26','2024-09-27',2,'278.21.11.2018','Dikirim',NULL,NULL,'2024-09-26 18:05:35',NULL,'2024-09-26 11:05:35','2024-09-26 11:05:35');
/*!40000 ALTER TABLE `pengajuan_libur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sifat_surat`
--

DROP TABLE IF EXISTS `sifat_surat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sifat_surat` (
  `id_sifat_surat` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_sifat_surat` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_sifat_surat`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sifat_surat`
--

LOCK TABLES `sifat_surat` WRITE;
/*!40000 ALTER TABLE `sifat_surat` DISABLE KEYS */;
INSERT INTO `sifat_surat` VALUES (1,'Penting','2024-09-04 07:28:59','2024-09-04 07:28:59');
/*!40000 ALTER TABLE `sifat_surat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `struktur_organisasi`
--

DROP TABLE IF EXISTS `struktur_organisasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `struktur_organisasi` (
  `id_struktur_organisasi` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nik` varchar(20) DEFAULT NULL,
  `nik_atasan_langsung` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_struktur_organisasi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `struktur_organisasi`
--

LOCK TABLES `struktur_organisasi` WRITE;
/*!40000 ALTER TABLE `struktur_organisasi` DISABLE KEYS */;
/*!40000 ALTER TABLE `struktur_organisasi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `surat`
--

DROP TABLE IF EXISTS `surat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `surat` (
  `id_surat` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode_surat` varchar(255) NOT NULL,
  `nomor_surat` varchar(255) DEFAULT NULL,
  `id_klasifikasi_surat` bigint(20) unsigned DEFAULT NULL,
  `id_sifat_surat` bigint(20) unsigned DEFAULT NULL,
  `nik_pengirim` varchar(255) NOT NULL,
  `perihal` varchar(255) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `lampiran` int(10) unsigned NOT NULL,
  `file_surat` varchar(255) DEFAULT NULL,
  `file_lampiran` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_surat`),
  UNIQUE KEY `surat_kode_surat_unique` (`kode_surat`),
  KEY `surat_id_klasifikasi_surat_foreign` (`id_klasifikasi_surat`),
  KEY `surat_id_sifat_surat_foreign` (`id_sifat_surat`),
  CONSTRAINT `surat_id_klasifikasi_surat_foreign` FOREIGN KEY (`id_klasifikasi_surat`) REFERENCES `klasifikasi_surat` (`id_klasifikasi_surat`) ON DELETE SET NULL,
  CONSTRAINT `surat_id_sifat_surat_foreign` FOREIGN KEY (`id_sifat_surat`) REFERENCES `sifat_surat` (`id_sifat_surat`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `surat`
--

LOCK TABLES `surat` WRITE;
/*!40000 ALTER TABLE `surat` DISABLE KEYS */;
INSERT INTO `surat` VALUES (3,'SRT-20240928-SV69U','RS\'ASF/1/MI-Jangmed/2024',1,1,'278.21.11.2018','Pengajuan Komputer','2024-09-28',0,'uploads/surat/gWzmBwk3tborZQ4C1blP6iQO0trxHRcv4FyRMVeq.docx',NULL,'2024-09-28 15:04:36','2024-09-28 15:04:36');
/*!40000 ALTER TABLE `surat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `username_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('Admin','User') NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Puji Santoso S. Kom','229.06.11.2017',NULL,'$2y$10$OJAhk/NH0l1n3STuBxrOCe/8hYYdLvgoukOJTVCJ/jtxbN2fsbA9S','Admin',NULL,'2024-09-04 04:23:13','2024-09-05 07:25:14'),(2,'Okyanto Agung Kurniawan S. Kom','278.21.11.2018',NULL,'$2y$10$XdjSH227VPDfsPBw6zgAwOv13CUT7hMuWt.AgMXMkvizqjYRDszWq','Admin',NULL,'2024-09-04 06:38:43','2024-09-05 06:41:11');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `verifikasi_surat`
--

DROP TABLE IF EXISTS `verifikasi_surat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `verifikasi_surat` (
  `id_verifikasi_surat` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_surat` bigint(20) unsigned NOT NULL,
  `nik_verifikator` varchar(255) NOT NULL,
  `status_surat` enum('Dikirim','Dibaca','Disetujui','Ditolak') NOT NULL DEFAULT 'Dikirim',
  `tanggal_verifikasi` timestamp NULL DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_verifikasi_surat`),
  KEY `verifikasi_surat_id_surat_foreign` (`id_surat`),
  CONSTRAINT `verifikasi_surat_id_surat_foreign` FOREIGN KEY (`id_surat`) REFERENCES `surat` (`id_surat`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `verifikasi_surat`
--

LOCK TABLES `verifikasi_surat` WRITE;
/*!40000 ALTER TABLE `verifikasi_surat` DISABLE KEYS */;
INSERT INTO `verifikasi_surat` VALUES (3,3,'28.26.07.2009','Dikirim',NULL,NULL,'2024-09-28 15:04:36','2024-09-28 15:04:36');
/*!40000 ALTER TABLE `verifikasi_surat` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-09-29 12:03:59
