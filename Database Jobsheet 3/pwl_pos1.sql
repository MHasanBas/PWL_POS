-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 21, 2024 at 07:12 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pwl_pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_09_11_011701_create_m_level_table', 1),
(6, '2024_09_11_014916_create_m_kategori_table', 1),
(7, '2024_09_11_015216_create_m_supplier_table', 1),
(8, '2024_09_11_020254_create_m_user_table', 1),
(9, '2024_09_11_021710_create_m_barang_table', 1),
(10, '2024_09_11_023057_create_t_penjualan_table', 1),
(11, '2024_09_11_024452_create_t_stok_table', 1),
(12, '2024_09_11_024858_create_t_penjualan_detail_table', 1),
(13, '2024_10_21_062708_image', 2),
(14, '2024_10_21_063809_remove_photo_column_from_users_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `m_barang`
--

CREATE TABLE `m_barang` (
  `barang_id` bigint UNSIGNED NOT NULL,
  `kategori_id` bigint UNSIGNED NOT NULL,
  `barang_kode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `barang_nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga_beli` int NOT NULL,
  `harga_jual` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_barang`
--

INSERT INTO `m_barang` (`barang_id`, `kategori_id`, `barang_kode`, `barang_nama`, `harga_beli`, `harga_jual`, `created_at`, `updated_at`) VALUES
(1, 1, 'BAR001', 'Laptop', 5000000, 6000000, NULL, NULL),
(2, 1, 'BAR002', 'Smartphone', 2000000, 2500000, NULL, NULL),
(3, 2, 'BAR003', 'Jaket', 100000, 150000, NULL, NULL),
(4, 2, 'BAR004', 'Sepatu', 150000, 200000, NULL, NULL),
(5, 3, 'BAR005', 'Roti', 10000, 15000, NULL, NULL),
(6, 3, 'BAR006', 'Nasi Goreng', 15000, 20000, NULL, NULL),
(7, 4, 'BAR007', 'Kopi Hitam', 5000, 10000, NULL, NULL),
(8, 4, 'BAR008', 'Jus Jeruk', 10000, 15000, NULL, NULL),
(9, 5, 'BAR009', 'Sofa', 3000000, 3500000, NULL, NULL),
(10, 5, 'BAR0010', 'Meja Kayu', 1000000, 1200000, NULL, NULL),
(11, 1, 'BAR0011', 'Mouse', 150000, 200000, NULL, NULL),
(12, 2, 'BAR0012', 'Kaos', 50000, 75000, NULL, NULL),
(13, 3, 'BAR0013', 'Indomie', 2500, 5000, NULL, NULL),
(14, 4, 'BAR0014', 'Es Teh Manis', 2500, 3000, NULL, NULL),
(15, 5, 'BAR0015', 'Lemari', 2000000, 4000000, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_kategori`
--

CREATE TABLE `m_kategori` (
  `kategori_id` bigint UNSIGNED NOT NULL,
  `kategori_kode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_kategori`
--

INSERT INTO `m_kategori` (`kategori_id`, `kategori_kode`, `kategori_nama`, `created_at`, `updated_at`) VALUES
(1, 'KAT001', 'Elektronik', NULL, NULL),
(2, 'KAT002', 'Pakaian', NULL, NULL),
(3, 'KAT003', 'Makanan', NULL, NULL),
(4, 'KAT004', 'Minuman', NULL, NULL),
(5, 'KAT005', 'Perabotan', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_level`
--

CREATE TABLE `m_level` (
  `level_id` bigint UNSIGNED NOT NULL,
  `level_kode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level_nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_level`
--

INSERT INTO `m_level` (`level_id`, `level_kode`, `level_nama`, `created_at`, `updated_at`) VALUES
(1, 'ADM', 'Administrator', NULL, NULL),
(2, 'MNG', 'Manager', NULL, NULL),
(3, 'STF', 'Staff/Kasir', NULL, NULL),
(4, 'CUS', 'Customer', '2024-10-15 18:54:31', '2024-10-15 18:54:31');

-- --------------------------------------------------------

--
-- Table structure for table `m_supplier`
--

CREATE TABLE `m_supplier` (
  `supplier_id` bigint UNSIGNED NOT NULL,
  `supplier_kode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_supplier`
--

INSERT INTO `m_supplier` (`supplier_id`, `supplier_kode`, `supplier_nama`, `supplier_alamat`, `created_at`, `updated_at`) VALUES
(1, 'SUP001', 'Supplier A', 'Jl.Merdeka No.1', NULL, NULL),
(2, 'SUP002', 'Supplier B', 'Jl.Sudirman No.2', NULL, NULL),
(3, 'SUP003', 'Supplier C', 'Jl.Ahmad Yani No.3', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_user`
--

CREATE TABLE `m_user` (
  `user_id` bigint UNSIGNED NOT NULL,
  `level_id` bigint UNSIGNED NOT NULL,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_user`
--

INSERT INTO `m_user` (`user_id`, `level_id`, `username`, `nama`, `password`, `created_at`, `updated_at`, `photo`) VALUES
(1, 1, 'admin', 'Administrator', '$2y$12$VbRABooHTh3krLOTPnUsouvQIAhPel3qTIEfbq7W9xyIUXSOcl6Vi', NULL, NULL, NULL),
(2, 2, 'manager', 'Manager', '$2y$12$8V2O1bFbxRbyxDSUUQzma.Y2AJ2GkpPYdgbF8d9kNcP11Go8.w/rG', NULL, NULL, NULL),
(3, 3, 'staff', 'Staff/Kasir', '$2y$12$3zjuIEIPsj8CeEd2b2S/MunbOoBF61J276ZPZjUbLcBgLjYzmpTIO', NULL, NULL, NULL),
(4, 4, 'customer1', 'Pelanggan Pertama', '$2y$12$mJ9EO/R4h10RpHE4LHTNCuMdVTfkXEyVHTwUmgovgIzdRyjplBx/6', '2024-10-15 18:56:10', '2024-10-15 18:56:10', NULL),
(5, 2, 'manager_dua', 'Manager 22', '$2y$12$GmWxyneyu6Yakky94VOuW.C2xrXRyYwh6tOhdjM5KXlmTNbpvIMSG', '2024-10-15 19:00:56', '2024-10-15 19:04:07', NULL),
(6, 2, 'manager22', 'Manager Dua Dua', '$2y$12$sKvPQvlO047AGiVfakxOU.7xqtXxX.FulOw5ONQNiOP7MctPfFyS6', '2024-10-15 19:03:14', '2024-10-15 19:06:27', NULL),
(7, 2, 'manager33', 'Manager Tiga Tiga', '$2y$12$Pw1pKIrjOGSacFYXZ4z5aOxtX4HHdUUwAQymiVpR/sGWQoLbtJCj.', '2024-10-15 19:07:18', '2024-10-15 19:07:18', NULL),
(8, 2, 'manager56', 'Manager55', '$2y$12$hUk.SpQaF77QK32HNqPtUeqEYYW7KY41vv7To6oN7zRulyzoMQWTu', '2024-10-15 19:07:54', '2024-10-15 19:07:54', NULL),
(9, 2, 'manager12', 'Manager11', '$2y$12$yX1zRFbxzYPfjqc3XzeeZOADllVrTpprE8ZzproZf7IhmQQSs/TJu', '2024-10-15 19:08:28', '2024-10-15 19:08:28', NULL),
(10, 1, 'ianfahmi', 'Fahmi1', '$2y$12$BRkAwSE138plia85TQ9KTeXTcbikJmifRzwKVp6LUOinTsviqoR4i', '2024-10-15 19:08:55', '2024-10-15 19:08:55', NULL),
(11, 4, 'ianc', 'Customer Ian', '$2y$12$sx09sO.yUlfOJCBpdeXtEuvW1tFvYM1c.g9hbYSzPHKL1FZokNYKK', '2024-10-15 19:09:27', '2024-10-15 19:09:27', NULL),
(12, 3, 'faizcashier', 'Faiz Abiyu', '$2y$12$V6aZvXlRJDzK/hMTr.7RheZ2N4F5Xt1riL6DrwcZORdHqb0yhcCvu', '2024-10-15 19:10:12', '2024-10-15 19:10:12', NULL),
(13, 3, 'staffian', 'Ian Fahmi', '$2y$12$GNGc/1Xw98nQZogilYL3Ve/ZFjmLwYEWAZPNlabLyICw4h0MxqikC', '2024-10-15 19:41:25', '2024-10-15 19:41:25', NULL),
(14, 1, 'hasan', 'hasan', '$2y$12$3tJNN6CqAvNcHki0XfNMueoOVRYW0moUNTCMOvVidQrf3ZsBqwbHG', '2024-10-21 00:07:50', '2024-10-21 00:07:50', NULL);

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
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_penjualan`
--

CREATE TABLE `t_penjualan` (
  `penjualan_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `pembeli` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `penjualan_kode` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `penjualan_tanggal` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_penjualan`
--

INSERT INTO `t_penjualan` (`penjualan_id`, `user_id`, `pembeli`, `penjualan_kode`, `penjualan_tanggal`, `created_at`, `updated_at`) VALUES
(1, 1, 'John Doe', 'TRX001', '2024-09-01 12:30:00', NULL, NULL),
(2, 2, 'Jane Smith', 'TRX002', '2024-09-02 14:00:00', NULL, NULL),
(3, 3, 'Michael Brown', 'TRX003', '2024-09-03 09:30:00', NULL, NULL),
(4, 1, 'Lisa Black', 'TRX004', '2024-09-04 10:00:00', NULL, NULL),
(5, 2, 'Paul White', 'TRX005', '2024-09-05 13:45:00', NULL, NULL),
(6, 3, 'Emily Davis', 'TRX006', '2024-09-06 11:00:00', NULL, NULL),
(7, 1, 'Mark Lee', 'TRX007', '2024-09-07 12:15:00', NULL, NULL),
(8, 2, 'Sarah Wilson', 'TRX008', '2024-09-08 16:30:00', NULL, NULL),
(9, 3, 'James Anderson', 'TRX009', '2024-09-09 14:00:00', NULL, NULL),
(10, 1, 'Samantha Martinez', 'TRX010', '2024-09-10 10:45:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_penjualan_detail`
--

CREATE TABLE `t_penjualan_detail` (
  `detail_id` bigint UNSIGNED NOT NULL,
  `penjualan_id` bigint UNSIGNED NOT NULL,
  `barang_id` bigint UNSIGNED NOT NULL,
  `harga` int NOT NULL,
  `jumlah` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_penjualan_detail`
--

INSERT INTO `t_penjualan_detail` (`detail_id`, `penjualan_id`, `barang_id`, `harga`, `jumlah`) VALUES
(1, 1, 1, 6000000, 1),
(2, 1, 2, 2500000, 1),
(3, 1, 3, 150000, 2),
(4, 2, 4, 200000, 3),
(5, 2, 5, 15000, 4),
(6, 2, 6, 20000, 1),
(7, 3, 7, 10000, 1),
(8, 3, 8, 15000, 1),
(9, 3, 9, 3500000, 1),
(10, 4, 10, 1200000, 1),
(11, 4, 11, 200000, 3),
(12, 4, 12, 75000, 2),
(13, 5, 13, 5000, 1),
(14, 5, 14, 3000, 1),
(15, 5, 15, 4000000, 2),
(16, 6, 1, 6000000, 1),
(17, 6, 2, 2500000, 1),
(18, 6, 3, 150000, 2),
(19, 7, 4, 200000, 3),
(20, 7, 5, 15000, 4),
(21, 7, 6, 20000, 1),
(22, 8, 7, 10000, 1),
(23, 8, 8, 15000, 1),
(24, 8, 9, 3500000, 1),
(25, 9, 10, 1200000, 1),
(26, 9, 11, 200000, 3),
(27, 9, 12, 75000, 2),
(28, 10, 13, 5000, 1),
(29, 10, 14, 3000, 1),
(30, 10, 15, 4000000, 2);

-- --------------------------------------------------------

--
-- Table structure for table `t_stok`
--

CREATE TABLE `t_stok` (
  `stok_id` bigint UNSIGNED NOT NULL,
  `supplier_id` bigint UNSIGNED NOT NULL,
  `barang_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `stok_tanggal` datetime NOT NULL,
  `stok_jumlah` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_stok`
--

INSERT INTO `t_stok` (`stok_id`, `supplier_id`, `barang_id`, `user_id`, `stok_tanggal`, `stok_jumlah`) VALUES
(1, 1, 1, 1, '2024-09-01 12:00:00', 50),
(2, 1, 2, 2, '2024-09-02 14:00:00', 30),
(3, 1, 3, 3, '2024-09-03 09:00:00', 40),
(4, 2, 4, 1, '2024-09-04 08:30:00', 60),
(5, 3, 5, 2, '2024-09-05 10:15:00', 100),
(6, 3, 6, 3, '2024-09-06 13:45:00', 90),
(7, 3, 7, 1, '2024-09-07 11:20:00', 25),
(8, 2, 8, 2, '2024-09-08 15:00:00', 35),
(9, 2, 9, 3, '2024-09-09 09:45:00', 45),
(10, 1, 10, 1, '2024-09-10 12:30:00', 20),
(11, 1, 11, 2, '2024-09-11 14:00:00', 55),
(12, 2, 12, 3, '2024-09-12 16:30:00', 25),
(13, 3, 13, 1, '2024-09-13 11:00:00', 40),
(14, 3, 14, 2, '2024-09-14 14:30:00', 70),
(15, 2, 15, 3, '2024-09-15 12:00:00', 50);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_barang`
--
ALTER TABLE `m_barang`
  ADD PRIMARY KEY (`barang_id`),
  ADD UNIQUE KEY `m_barang_barang_kode_unique` (`barang_kode`),
  ADD KEY `m_barang_kategori_id_index` (`kategori_id`);

--
-- Indexes for table `m_kategori`
--
ALTER TABLE `m_kategori`
  ADD PRIMARY KEY (`kategori_id`),
  ADD UNIQUE KEY `m_kategori_kategori_kode_unique` (`kategori_kode`);

--
-- Indexes for table `m_level`
--
ALTER TABLE `m_level`
  ADD PRIMARY KEY (`level_id`),
  ADD UNIQUE KEY `m_level_level_kode_unique` (`level_kode`);

--
-- Indexes for table `m_supplier`
--
ALTER TABLE `m_supplier`
  ADD PRIMARY KEY (`supplier_id`),
  ADD UNIQUE KEY `m_supplier_supplier_kode_unique` (`supplier_kode`);

--
-- Indexes for table `m_user`
--
ALTER TABLE `m_user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `m_user_username_unique` (`username`),
  ADD KEY `m_user_level_id_index` (`level_id`);

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
-- Indexes for table `t_penjualan`
--
ALTER TABLE `t_penjualan`
  ADD PRIMARY KEY (`penjualan_id`),
  ADD UNIQUE KEY `t_penjualan_penjualan_kode_unique` (`penjualan_kode`),
  ADD KEY `t_penjualan_user_id_index` (`user_id`);

--
-- Indexes for table `t_penjualan_detail`
--
ALTER TABLE `t_penjualan_detail`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `t_penjualan_detail_penjualan_id_index` (`penjualan_id`),
  ADD KEY `t_penjualan_detail_barang_id_index` (`barang_id`);

--
-- Indexes for table `t_stok`
--
ALTER TABLE `t_stok`
  ADD PRIMARY KEY (`stok_id`),
  ADD KEY `t_stok_supplier_id_index` (`supplier_id`),
  ADD KEY `t_stok_barang_id_index` (`barang_id`),
  ADD KEY `t_stok_user_id_index` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `m_barang`
--
ALTER TABLE `m_barang`
  MODIFY `barang_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `m_kategori`
--
ALTER TABLE `m_kategori`
  MODIFY `kategori_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `m_level`
--
ALTER TABLE `m_level`
  MODIFY `level_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `m_supplier`
--
ALTER TABLE `m_supplier`
  MODIFY `supplier_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `m_user`
--
ALTER TABLE `m_user`
  MODIFY `user_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_penjualan`
--
ALTER TABLE `t_penjualan`
  MODIFY `penjualan_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `t_penjualan_detail`
--
ALTER TABLE `t_penjualan_detail`
  MODIFY `detail_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `t_stok`
--
ALTER TABLE `t_stok`
  MODIFY `stok_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `m_barang`
--
ALTER TABLE `m_barang`
  ADD CONSTRAINT `m_barang_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `m_kategori` (`kategori_id`);

--
-- Constraints for table `m_user`
--
ALTER TABLE `m_user`
  ADD CONSTRAINT `m_user_level_id_foreign` FOREIGN KEY (`level_id`) REFERENCES `m_level` (`level_id`);

--
-- Constraints for table `t_penjualan`
--
ALTER TABLE `t_penjualan`
  ADD CONSTRAINT `t_penjualan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `m_user` (`user_id`);

--
-- Constraints for table `t_penjualan_detail`
--
ALTER TABLE `t_penjualan_detail`
  ADD CONSTRAINT `t_penjualan_detail_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `m_barang` (`barang_id`),
  ADD CONSTRAINT `t_penjualan_detail_penjualan_id_foreign` FOREIGN KEY (`penjualan_id`) REFERENCES `t_penjualan` (`penjualan_id`);

--
-- Constraints for table `t_stok`
--
ALTER TABLE `t_stok`
  ADD CONSTRAINT `t_stok_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `m_barang` (`barang_id`),
  ADD CONSTRAINT `t_stok_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `m_supplier` (`supplier_id`),
  ADD CONSTRAINT `t_stok_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `m_user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
