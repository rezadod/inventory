-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.33 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table inventory.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table inventory.failed_jobs: ~0 rows (approximately)
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

-- Dumping structure for table inventory.inventory
CREATE TABLE IF NOT EXISTS `inventory` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nama_barang` varchar(100) DEFAULT NULL,
  `jumlah_barang` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `foto_barang` varchar(225) DEFAULT NULL,
  `bukti_transaksi` varchar(225) DEFAULT NULL,
  `harga_barang` int(11) DEFAULT NULL,
  `jenis_inventory` int(11) unsigned DEFAULT NULL,
  `keterangan_barang` varchar(50) DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `status_hapus` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_inventory_users` (`user_id`),
  KEY `FK_inventory_status_inventory` (`jenis_inventory`) USING BTREE,
  CONSTRAINT `FK_inventory_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table inventory.inventory: ~5 rows (approximately)
/*!40000 ALTER TABLE `inventory` DISABLE KEYS */;
INSERT INTO `inventory` (`id`, `nama_barang`, `jumlah_barang`, `created_at`, `updated_at`, `foto_barang`, `bukti_transaksi`, `harga_barang`, `jenis_inventory`, `keterangan_barang`, `user_id`, `status_hapus`) VALUES
	(2, 'gjdf edit', 12, '2022-04-29 06:24:04', '2022-04-29 20:17:42', '$foto_barang_626be576c7d57.jpg', 'bukti_tf_626be576cbb71.jpg', 12, 2, 'were', 1, 0),
	(3, 'gjdf', 12, '2022-04-29 06:39:47', '2022-04-29 06:39:47', 'foto_barang_626b25c3afc6a.png', 'bukti_tf_626b25c3b1be6.png', 60000, 2, NULL, 1, 0),
	(4, 'gjdf', 32, '2022-04-29 06:41:12', '2022-04-29 09:16:15', 'foto_barang_626b261801fe3.png', 'bukti_tf_626b2618043d1.png', 400000, 2, NULL, 1, 1),
	(5, 'dfghfgh', 345, '2022-04-29 06:42:10', '2022-04-29 09:13:42', 'foto_barang_626b2652218f0.png', 'bukti_tf_626b265223df7.png', 1231241, 1, NULL, 1, 1),
	(6, 'dfghfgh', 234, '2022-04-29 06:42:44', '2022-04-29 09:13:34', 'foto_barang_626b267458a98.png', 'bukti_tf_626b26745b70e.png', 234234, 1, NULL, 1, 1);
/*!40000 ALTER TABLE `inventory` ENABLE KEYS */;

-- Dumping structure for table inventory.jenis_inventory
CREATE TABLE IF NOT EXISTS `jenis_inventory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `deskripsi` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table inventory.jenis_inventory: ~2 rows (approximately)
/*!40000 ALTER TABLE `jenis_inventory` DISABLE KEYS */;
INSERT INTO `jenis_inventory` (`id`, `deskripsi`) VALUES
	(1, 'BELI'),
	(2, 'SUMBANGAN');
/*!40000 ALTER TABLE `jenis_inventory` ENABLE KEYS */;

-- Dumping structure for table inventory.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table inventory.migrations: ~4 rows (approximately)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table inventory.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table inventory.password_resets: ~0 rows (approximately)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Dumping structure for table inventory.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table inventory.personal_access_tokens: ~0 rows (approximately)
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;

-- Dumping structure for table inventory.role
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `deskripsi` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table inventory.role: ~2 rows (approximately)
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` (`id`, `deskripsi`) VALUES
	(1, 'ADMIN'),
	(2, 'KEPALA DESA');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;

-- Dumping structure for table inventory.status_hapus
CREATE TABLE IF NOT EXISTS `status_hapus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `deskripsi` char(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table inventory.status_hapus: ~0 rows (approximately)
/*!40000 ALTER TABLE `status_hapus` DISABLE KEYS */;
INSERT INTO `status_hapus` (`id`, `deskripsi`) VALUES
	(0, 'TERSEDIA'),
	(1, 'TERHAPUS');
/*!40000 ALTER TABLE `status_hapus` ENABLE KEYS */;

-- Dumping structure for table inventory.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` int(10) unsigned DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `FK_users_role` (`role_id`),
  CONSTRAINT `FK_users_role` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table inventory.users: ~2 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role_id`) VALUES
	(1, 'Admin', 'admin@gmail.com', NULL, '$2y$10$dD7q9BOatwATXvDIgGM2T.zd0WbUjYrXdCpJKNMZY8IHgucmY9f7y', 'Mf3aD3vruUNrajvJV0qeBhfyOYbpiwY8XE4Eroo6RsYt1b5KlvwVmG6X7hps', '2022-04-27 13:31:54', '2022-04-27 13:31:54', 1),
	(2, 'Coba register', 'coba@gmail.com', NULL, '$2y$10$m4IgBBm1tE0b6MzzKNIUJOuC1F/6Rw4NaDl0mYE9KtbqwwhkhneZ2', NULL, '2022-04-28 21:59:14', '2022-04-28 21:59:14', 1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
