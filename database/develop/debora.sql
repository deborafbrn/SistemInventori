-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jul 17, 2023 at 08:59 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `debora`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fp_growth`
--

CREATE TABLE `fp_growth` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` decimal(10,0) NOT NULL,
  `total_produk` bigint(20) NOT NULL,
  `total_transaksi` bigint(20) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fp_growth_item`
--

CREATE TABLE `fp_growth_item` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fp_growth_id` bigint(20) UNSIGNED NOT NULL,
  `produk_id` bigint(20) UNSIGNED NOT NULL COMMENT 'produk_id',
  `frekuensi` bigint(20) NOT NULL,
  `support` float NOT NULL,
  `confidence` float NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fp_growth_item_detail`
--

CREATE TABLE `fp_growth_item_detail` (
  `id` bigint(20) NOT NULL,
  `fp_growth_item_id` bigint(20) UNSIGNED NOT NULL,
  `produk_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kategori` enum('pestisida','vitamin','pupuk','alat','bibit') NOT NULL,
  `kode` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kemasan` varchar(100) NOT NULL,
  `harga_satuan` varchar(10) NOT NULL,
  `harga_borongan` varchar(10) NOT NULL DEFAULT '0',
  `qty_borongan` int(10) NOT NULL DEFAULT 0,
  `stock` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `kategori`, `kode`, `nama`, `kemasan`, `harga_satuan`, `harga_borongan`, `qty_borongan`, `stock`, `created_at`, `updated_at`) VALUES
(3, 'pestisida', 'p12', 'Maju Pestisida', 'sak', '135.000', '120.000', 10, 200, '2023-07-11 13:25:50', '2023-07-17 13:10:45'),
(4, 'pupuk', 'PNPK12', 'Pupuk Kujang NPK1', 'Sak', '210.000', '189.000', 10, 0, '2023-07-11 13:25:13', NULL),
(5, 'pestisida', 'p123', 'Maju Pestisidass', 'sak', '134.000', '121.000', 10, 0, '2023-07-11 13:25:50', NULL),
(6, 'alat', 'AL3', 'Alat 12', 'Sak', '100.000', '85.000', 10, 0, '2023-07-11 13:25:13', NULL),
(7, 'bibit', 'Bibtee', 'Maju Bobit', 'sak', '125.000', '110.000', 10, 0, '2023-07-11 13:25:50', NULL),
(8, 'vitamin', 'VT12', 'Vitamin 12', 'Sak', '110.000', '89.000', 10, 0, '2023-07-11 13:25:13', NULL),
(9, 'vitamin', 'p1232', 'Maju Vitamin', 'sak', '124.000', '111.000', 10, 0, '2023-07-11 13:25:50', NULL),
(10, 'bibit', 'Bibts', 'Maju Bobitas', 'sak', '125.000', '110.000', 10, 0, '2023-07-11 13:25:50', NULL),
(11, 'vitamin', 'VT1223', 'Vitamin 1223', 'Sak', '110.000', '89.000', 10, 0, '2023-07-11 13:25:13', NULL),
(12, 'vitamin', 'p12327', 'Maju Vitamin123', 'sak', '124.000', '111.000', 10, 0, '2023-07-11 13:25:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer` varchar(100) NOT NULL,
  `kode` varchar(100) NOT NULL,
  `tanggal` date NOT NULL,
  `grandtotal` float NOT NULL,
  `total_produk` bigint(20) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `customer`, `kode`, `tanggal`, `grandtotal`, `total_produk`, `created_at`, `updated_at`) VALUES
(2, 'adi', 'TRS-001', '2023-07-17', 14850000, 112, '2023-07-17 16:33:30', NULL),
(3, 'rfikie', 'TRS-002', '2023-07-15', 20099, 200, '2023-07-17 16:33:51', '2023-07-17 16:48:10'),
(4, 'rendy', 'TRS-003', '2023-07-01', 9925000, 109, '2023-07-17 16:47:53', NULL),
(5, 'karry', 'TRS-004', '2023-07-17', 13461000, 117, '2023-07-17 16:48:39', NULL),
(6, 'undy', 'TRS-005', '2023-07-17', 21210000, 200, '2023-07-17 16:49:19', NULL),
(7, 'bandi', 'TRS-006', '2023-07-04', 47874000, 400, '2023-07-17 16:49:59', NULL),
(8, 'izul', 'TRS-007', '2023-07-11', 13471000, 109, '2023-07-17 16:50:47', NULL),
(9, 'hilda', 'TRS-008', '2023-07-12', 20705000, 200, '2023-07-17 16:51:08', NULL),
(10, 'tarno', 'TRS-009', '2023-07-17', 20200000, 200, '2023-07-17 16:51:26', NULL),
(11, 'kamil', 'TRS-010', '2023-07-17', 20099000, 200, '2023-07-17 16:51:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_item`
--

CREATE TABLE `transaksi_item` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaksi_id` bigint(20) UNSIGNED NOT NULL,
  `produk_id` bigint(20) UNSIGNED NOT NULL,
  `borongan` tinyint(1) NOT NULL,
  `qty` bigint(20) NOT NULL,
  `qty_real` int(11) NOT NULL,
  `qty_borongan` int(11) NOT NULL,
  `total` float NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi_item`
--

INSERT INTO `transaksi_item` (`id`, `transaksi_id`, `produk_id`, `borongan`, `qty`, `qty_real`, `qty_borongan`, `total`, `created_at`, `updated_at`) VALUES
(5, 2, 3, 1, 100, 10, 10, 12120000, '2023-07-17 16:33:30', NULL),
(6, 2, 4, 0, 12, 12, 0, 2730000, '2023-07-17 16:33:30', NULL),
(17, 4, 5, 0, 9, 9, 0, 1340000, '2023-07-17 16:47:53', NULL),
(18, 4, 6, 1, 100, 10, 10, 8585000, '2023-07-17 16:47:53', NULL),
(19, 3, 8, 1, 100, 10, 10, 8989000, '2023-07-17 16:48:10', NULL),
(20, 3, 10, 1, 100, 10, 10, 11110000, '2023-07-17 16:48:10', NULL),
(21, 5, 10, 0, 17, 17, 0, 2250000, '2023-07-17 16:48:39', NULL),
(22, 5, 12, 1, 100, 10, 10, 11211000, '2023-07-17 16:48:39', NULL),
(23, 6, 5, 1, 100, 10, 10, 12221000, '2023-07-17 16:49:19', NULL),
(24, 6, 8, 1, 100, 10, 10, 8989000, '2023-07-17 16:49:19', NULL),
(25, 7, 4, 1, 100, 10, 10, 19089000, '2023-07-17 16:49:59', NULL),
(26, 7, 6, 1, 100, 10, 10, 8585000, '2023-07-17 16:49:59', NULL),
(27, 7, 9, 1, 100, 10, 10, 11211000, '2023-07-17 16:49:59', NULL),
(28, 7, 11, 1, 100, 10, 10, 8989000, '2023-07-17 16:49:59', NULL),
(29, 8, 5, 1, 100, 10, 10, 12221000, '2023-07-17 16:50:47', NULL),
(30, 8, 10, 0, 9, 9, 0, 1250000, '2023-07-17 16:50:47', NULL),
(31, 9, 3, 1, 100, 10, 10, 12120000, '2023-07-17 16:51:08', NULL),
(32, 9, 6, 1, 100, 10, 10, 8585000, '2023-07-17 16:51:08', NULL),
(33, 10, 8, 1, 100, 10, 10, 8989000, '2023-07-17 16:51:26', NULL),
(34, 10, 12, 1, 100, 10, 10, 11211000, '2023-07-17 16:51:26', NULL),
(35, 11, 8, 1, 100, 10, 10, 8989000, '2023-07-17 16:51:51', NULL),
(36, 11, 10, 1, 100, 10, 10, 11110000, '2023-07-17 16:51:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` enum('kasir','gudang') COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 'kasir', 'Debora Febriana ', 'debora_febriana', '$2y$10$fSeCyjiAElwmt1SVGsYfyOTRkohxWnR3.xhBX5jOQ5O7mlCXM9QoS', '2022-02-06 12:54:27', '2022-09-12 01:19:37'),
(2, 'gudang', 'Debora Adriana', 'debora_adriana', '$2y$10$fSeCyjiAElwmt1SVGsYfyOTRkohxWnR3.xhBX5jOQ5O7mlCXM9QoS', '2022-02-06 12:54:27', '2022-09-12 01:19:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fp_growth`
--
ALTER TABLE `fp_growth`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_growth_item`
--
ALTER TABLE `fp_growth_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fp_growth` (`fp_growth_id`),
  ADD KEY `pd_id` (`produk_id`);

--
-- Indexes for table `fp_growth_item_detail`
--
ALTER TABLE `fp_growth_item_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fp_growth_item` (`fp_growth_item_id`),
  ADD KEY `produk_id` (`produk_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi_item`
--
ALTER TABLE `transaksi_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produk` (`produk_id`),
  ADD KEY `trs` (`transaksi_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`username`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fp_growth`
--
ALTER TABLE `fp_growth`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fp_growth_item`
--
ALTER TABLE `fp_growth_item`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fp_growth_item_detail`
--
ALTER TABLE `fp_growth_item_detail`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `transaksi_item`
--
ALTER TABLE `transaksi_item`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fp_growth_item`
--
ALTER TABLE `fp_growth_item`
  ADD CONSTRAINT `fp_growth` FOREIGN KEY (`fp_growth_id`) REFERENCES `fp_growth` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pd_id` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `fp_growth_item_detail`
--
ALTER TABLE `fp_growth_item_detail`
  ADD CONSTRAINT `fp_growth_item` FOREIGN KEY (`fp_growth_item_id`) REFERENCES `fp_growth_item` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `produk_id` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi_item`
--
ALTER TABLE `transaksi_item`
  ADD CONSTRAINT `produk` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `trs` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
