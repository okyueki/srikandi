-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2024 at 06:23 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `srikandi`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

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
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `klasifikasi_surat`
--

CREATE TABLE `klasifikasi_surat` (
  `id_klasifikasi_surat` bigint(20) UNSIGNED NOT NULL,
  `kode_klasifikasi_surat` varchar(50) NOT NULL,
  `nama_klasifikasi_surat` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `klasifikasi_surat`
--

INSERT INTO `klasifikasi_surat` (`id_klasifikasi_surat`, `kode_klasifikasi_surat`, `nama_klasifikasi_surat`, `created_at`, `updated_at`) VALUES
(1, 'MI-Jangmed', 'MI Jangmed', '2024-09-04 07:29:06', '2024-09-04 07:29:06');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_08_26_102820_create_sifat_surat_table', 1),
(6, '2024_08_27_130228_create_klasifikasi_surat_table', 1),
(10, '2024_09_04_114021_create_pengajuan_libur_table', 2),
(11, '2024_09_17_182457_create_pengajuan_lembur_table', 3),
(23, '2024_09_24_200413_create_struktur_organisasi_table', 4),
(24, '2024_09_27_191823_create_surat_table', 4),
(25, '2024_09_27_195738_create_verifikasi_surat_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `username` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_lembur`
--

CREATE TABLE `pengajuan_lembur` (
  `id_pengajuan_lembur` bigint(20) UNSIGNED NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengajuan_lembur`
--

INSERT INTO `pengajuan_lembur` (`id_pengajuan_lembur`, `kode_pengajuan_lembur`, `nik`, `keterangan`, `tanggal_lembur`, `jam_awal`, `jam_akhir`, `nik_atasan_langsung`, `status`, `catatan`, `tanggal_dibuat`, `tanggal_verifikasi`, `created_at`, `updated_at`) VALUES
(2, 'LM-000001', '229.06.11.2017', 'ok33xxxxxxxxxxxx', '2024-09-18', '12:00:00', '13:00:00', '278.21.11.2018', 'Disetujui', 'Yesss', '2024-09-17 22:11:24', '2024-09-24 16:26:44', '2024-09-17 15:11:24', '2024-09-24 09:26:44');

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_libur`
--

CREATE TABLE `pengajuan_libur` (
  `id_pengajuan_libur` bigint(20) UNSIGNED NOT NULL,
  `kode_pengajuan_libur` varchar(11) NOT NULL,
  `jenis_pengajuan_libur` enum('Ijin','Tahunan','Melahirkan','Ambil Libur','Menikah') NOT NULL DEFAULT 'Ijin',
  `nik` varchar(20) NOT NULL,
  `alamat` text DEFAULT NULL,
  `keterangan` text NOT NULL,
  `tanggal_awal` date NOT NULL,
  `tanggal_akhir` date NOT NULL,
  `jumlah_hari` int(10) UNSIGNED NOT NULL,
  `nik_atasan_langsung` varchar(20) NOT NULL,
  `status` enum('Dikirim','Disetujui','Ditolak') NOT NULL DEFAULT 'Dikirim',
  `catatan` text DEFAULT NULL,
  `foto` varchar(200) DEFAULT NULL,
  `tanggal_dibuat` datetime NOT NULL DEFAULT current_timestamp(),
  `tanggal_verifikasi` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengajuan_libur`
--

INSERT INTO `pengajuan_libur` (`id_pengajuan_libur`, `kode_pengajuan_libur`, `jenis_pengajuan_libur`, `nik`, `alamat`, `keterangan`, `tanggal_awal`, `tanggal_akhir`, `jumlah_hari`, `nik_atasan_langsung`, `status`, `catatan`, `foto`, `tanggal_dibuat`, `tanggal_verifikasi`, `created_at`, `updated_at`) VALUES
(1, 'PL-000001', 'Tahunan', '229.06.11.2017', 'dadadadadad', 'Kepentingan Keluarga', '2024-09-06', '2024-09-07', 2, '278.21.11.2018', 'Disetujui', 'adadaddadd', NULL, '2024-09-06 21:50:09', '2024-09-07 21:01:45', '2024-09-06 07:50:09', '2024-09-07 14:01:45'),
(27, 'PL-000002', 'Ijin', '229.06.11.2017', NULL, 'Kepentingan Keluargaxxxxxxxxxxx', '2024-09-13', '2024-09-14', 2, '278.21.11.2018', 'Disetujui', 'Silahkan', 'uploads/ijin_files/1726224924_3d252340-db17-11ec-968e-000c29cc32a6_dr-perdana-airlangga-199x300-removebg-preview-199x300_waifu2x_photo_noise3_scale.png', '2024-09-13 17:50:30', '2024-09-17 17:37:15', '2024-09-13 10:50:30', '2024-09-17 10:37:15'),
(28, 'PL-000028', 'Tahunan', '278.21.11.2018', 'dadsd', 'Uji Coba', '2024-09-26', '2024-09-26', 1, '16.23.02.2008', 'Dikirim', NULL, NULL, '2024-09-26 09:32:30', NULL, '2024-09-26 02:32:30', '2024-09-26 02:32:30'),
(29, 'PL-000029', 'Ijin', '278.21.11.2018', NULL, 'Kepentingan Keluarga', '2024-09-25', '2024-09-27', 3, '229.06.11.2017', 'Dikirim', NULL, 'uploads/ijin_files/1727323913_pse rsasf.pdf', '2024-09-26 11:11:53', NULL, '2024-09-26 04:11:53', '2024-09-26 04:11:53'),
(30, 'PL-000030', 'Ambil Libur', '229.06.11.2017', 'a', 'Kepentingan Keluarga', '2024-09-26', '2024-09-27', 2, '278.21.11.2018', 'Dikirim', NULL, NULL, '2024-09-26 18:05:35', NULL, '2024-09-26 11:05:35', '2024-09-26 11:05:35');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sifat_surat`
--

CREATE TABLE `sifat_surat` (
  `id_sifat_surat` bigint(20) UNSIGNED NOT NULL,
  `nama_sifat_surat` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sifat_surat`
--

INSERT INTO `sifat_surat` (`id_sifat_surat`, `nama_sifat_surat`, `created_at`, `updated_at`) VALUES
(1, 'Penting', '2024-09-04 07:28:59', '2024-09-04 07:28:59');

-- --------------------------------------------------------

--
-- Table structure for table `struktur_organisasi`
--

CREATE TABLE `struktur_organisasi` (
  `id_struktur_organisasi` bigint(20) UNSIGNED NOT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `nik_atasan_langsung` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `struktur_organisasi`
--

INSERT INTO `struktur_organisasi` (`id_struktur_organisasi`, `nik`, `nik_atasan_langsung`, `created_at`, `updated_at`) VALUES
(1, '194.04.01.2017', NULL, '2024-09-27 13:30:38', '2024-09-27 13:30:38'),
(2, '28.26.07.2009', '194.04.01.2017', '2024-09-27 13:30:56', '2024-09-27 13:30:56'),
(3, '278.21.11.2018', '28.26.07.2009', '2024-09-27 13:31:36', '2024-09-27 13:31:36'),
(4, '229.06.11.2017', '278.21.11.2018', '2024-09-27 13:31:49', '2024-09-27 13:31:49');

-- --------------------------------------------------------

--
-- Table structure for table `surat`
--

CREATE TABLE `surat` (
  `id_surat` bigint(20) UNSIGNED NOT NULL,
  `kode_surat` varchar(255) NOT NULL,
  `nomor_surat` varchar(255) DEFAULT NULL,
  `id_klasifikasi_surat` bigint(20) UNSIGNED DEFAULT NULL,
  `id_sifat_surat` bigint(20) UNSIGNED DEFAULT NULL,
  `nik_pengirim` varchar(255) NOT NULL,
  `judul_surat` varchar(255) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `lampiran` int(10) UNSIGNED NOT NULL,
  `file_surat` varchar(255) DEFAULT NULL,
  `file_lampiran` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `username_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('Admin','User') NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `username_verified_at`, `password`, `level`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Puji Santoso S. Kom', '229.06.11.2017', NULL, '$2y$10$OJAhk/NH0l1n3STuBxrOCe/8hYYdLvgoukOJTVCJ/jtxbN2fsbA9S', 'Admin', NULL, '2024-09-04 04:23:13', '2024-09-05 07:25:14'),
(2, 'Okyanto Agung Kurniawan S. Kom', '278.21.11.2018', NULL, '$2y$10$XdjSH227VPDfsPBw6zgAwOv13CUT7hMuWt.AgMXMkvizqjYRDszWq', 'Admin', NULL, '2024-09-04 06:38:43', '2024-09-05 06:41:11');

-- --------------------------------------------------------

--
-- Table structure for table `verifikasi_surat`
--

CREATE TABLE `verifikasi_surat` (
  `id_verifikasi_surat` bigint(20) UNSIGNED NOT NULL,
  `id_surat` bigint(20) UNSIGNED NOT NULL,
  `nik_verifikator` varchar(255) NOT NULL,
  `status_surat` enum('Dikirim','Dibaca','Disetujui','Ditolak') NOT NULL DEFAULT 'Dikirim',
  `tanggal_verifikasi` timestamp NULL DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `klasifikasi_surat`
--
ALTER TABLE `klasifikasi_surat`
  ADD PRIMARY KEY (`id_klasifikasi_surat`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pengajuan_lembur`
--
ALTER TABLE `pengajuan_lembur`
  ADD PRIMARY KEY (`id_pengajuan_lembur`);

--
-- Indexes for table `pengajuan_libur`
--
ALTER TABLE `pengajuan_libur`
  ADD PRIMARY KEY (`id_pengajuan_libur`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `sifat_surat`
--
ALTER TABLE `sifat_surat`
  ADD PRIMARY KEY (`id_sifat_surat`);

--
-- Indexes for table `struktur_organisasi`
--
ALTER TABLE `struktur_organisasi`
  ADD PRIMARY KEY (`id_struktur_organisasi`);

--
-- Indexes for table `surat`
--
ALTER TABLE `surat`
  ADD PRIMARY KEY (`id_surat`),
  ADD UNIQUE KEY `surat_kode_surat_unique` (`kode_surat`),
  ADD KEY `surat_id_klasifikasi_surat_foreign` (`id_klasifikasi_surat`),
  ADD KEY `surat_id_sifat_surat_foreign` (`id_sifat_surat`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- Indexes for table `verifikasi_surat`
--
ALTER TABLE `verifikasi_surat`
  ADD PRIMARY KEY (`id_verifikasi_surat`),
  ADD KEY `verifikasi_surat_id_surat_foreign` (`id_surat`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `klasifikasi_surat`
--
ALTER TABLE `klasifikasi_surat`
  MODIFY `id_klasifikasi_surat` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `pengajuan_lembur`
--
ALTER TABLE `pengajuan_lembur`
  MODIFY `id_pengajuan_lembur` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pengajuan_libur`
--
ALTER TABLE `pengajuan_libur`
  MODIFY `id_pengajuan_libur` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sifat_surat`
--
ALTER TABLE `sifat_surat`
  MODIFY `id_sifat_surat` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `struktur_organisasi`
--
ALTER TABLE `struktur_organisasi`
  MODIFY `id_struktur_organisasi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `surat`
--
ALTER TABLE `surat`
  MODIFY `id_surat` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `verifikasi_surat`
--
ALTER TABLE `verifikasi_surat`
  MODIFY `id_verifikasi_surat` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `surat`
--
ALTER TABLE `surat`
  ADD CONSTRAINT `surat_id_klasifikasi_surat_foreign` FOREIGN KEY (`id_klasifikasi_surat`) REFERENCES `klasifikasi_surat` (`id_klasifikasi_surat`) ON DELETE SET NULL,
  ADD CONSTRAINT `surat_id_sifat_surat_foreign` FOREIGN KEY (`id_sifat_surat`) REFERENCES `sifat_surat` (`id_sifat_surat`) ON DELETE SET NULL;

--
-- Constraints for table `verifikasi_surat`
--
ALTER TABLE `verifikasi_surat`
  ADD CONSTRAINT `verifikasi_surat_id_surat_foreign` FOREIGN KEY (`id_surat`) REFERENCES `surat` (`id_surat`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
