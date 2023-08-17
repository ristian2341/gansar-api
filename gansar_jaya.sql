-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2023 at 03:13 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gansar_jaya`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL,
  `deskripsi` varchar(150) NOT NULL DEFAULT '',
  `kondisi_id` int(150) DEFAULT NULL,
  `jml` int(11) NOT NULL,
  `stok_out` int(11) DEFAULT 0,
  `kategori_id` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `deskripsi`, `kondisi_id`, `jml`, `stok_out`, `kategori_id`, `updated_at`, `created_at`) VALUES
(1, 'Genset 5000 kv', 1, 2, 0, 1, '2022-12-27 02:14:37', '2022-11-13 08:38:03'),
(3, 'Mesin Potong Rumput', 1, 2, 0, 8, '2022-12-27 02:14:37', '2022-11-15 22:36:59'),
(6, 'Genset Zeus 3000', NULL, 1, 2, 5, '2022-12-27 02:56:39', '2022-12-23 02:21:39'),
(7, 'Vacuum Krisbow 10100236', NULL, 1, 0, 5, '2022-12-25 17:20:49', '2022-12-23 03:53:28'),
(8, 'Kabel Power 50m', NULL, 2, 4, 5, '2022-12-27 02:56:39', '2022-12-23 03:53:40'),
(9, 'Bor Drill Makita HR2470X5', NULL, 1, 0, 5, '2022-12-23 03:53:57', '2022-12-23 03:53:57'),
(10, 'Bor Battery Bocsh GSB 180-LI', NULL, 1, 0, 5, '2022-12-23 03:54:18', '2022-12-23 03:54:18'),
(11, 'Bor Biasa Makita HP-1630', NULL, 1, 0, 5, '2022-12-23 03:54:30', '2022-12-23 03:54:30'),
(12, 'Gerinda Makita 9553B', NULL, 1, 0, 5, '2022-12-23 03:56:00', '2022-12-23 03:56:00'),
(13, 'Mesin Las Lakoni (Falcon 120e)', NULL, 1, 0, 5, '2022-12-23 03:56:17', '2022-12-23 03:56:17'),
(14, 'Pick Up L300 (S 8472 SC)', NULL, 1, 0, 6, '2022-12-26 23:46:50', '2022-12-26 23:46:50'),
(15, 'Pick Up Panther (S 8672 CB)', NULL, 1, 0, 6, '2022-12-26 23:47:40', '2022-12-26 23:47:40');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `kategori_id` int(11) NOT NULL,
  `kategori` varchar(150) NOT NULL DEFAULT '',
  `updated_at` datetime NOT NULL,
  `created_at` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`kategori_id`, `kategori`, `updated_at`, `created_at`) VALUES
(5, 'Alat', '2022-12-22 14:53:16', '2022-11-15 17:37:32'),
(6, 'Kendaraan', '2022-12-22 14:53:08', '2022-11-15 17:37:37'),
(8, 'Alat Pelindung Diri', '2022-12-27 01:33:21', '2022-11-15 22:57:05'),
(11, 'Kendaraan Berat', '2022-12-28 14:29:10', '2022-12-28 14:29:04');

-- --------------------------------------------------------

--
-- Table structure for table `kondisi`
--

CREATE TABLE `kondisi` (
  `kondisi_id` int(11) NOT NULL,
  `kondisi` varchar(100) NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kondisi`
--

INSERT INTO `kondisi` (`kondisi_id`, `kondisi`, `created_at`, `updated_at`) VALUES
(1, 'Bagus', '2022-11-13 09:22:31', '2022-11-13 09:22:31'),
(2, 'Bisa Dipakai', '2022-11-13 09:23:40', '2022-11-13 09:23:40'),
(6, 'Rusak', '2022-11-15 16:14:47', '2022-11-15 16:14:47');

-- --------------------------------------------------------

--
-- Table structure for table `laporan_barang`
--

CREATE TABLE `laporan_barang` (
  `id` int(11) NOT NULL,
  `nomor` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `kondisi` varchar(50) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jml` double NOT NULL DEFAULT 0,
  `status` tinyint(2) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `laporan_barang`
--

INSERT INTO `laporan_barang` (`id`, `nomor`, `tanggal`, `keterangan`, `kondisi`, `id_barang`, `jml`, `status`, `created_at`, `updated_at`) VALUES
(1, 'LAP-202212-0001', '2022-12-10', 'test', 'RUSAK', 1, 1, 2, '2022-12-10 21:12:41', '2022-12-10 21:35:25'),
(2, 'LAP-202212-0002', '2022-12-10', 'berdasarkan laporan polisi', 'HILANG', 3, 1, 2, '2022-12-10 21:13:30', '2022-12-10 21:35:37'),
(3, 'LAP-202212-0003', '2022-12-25', 'rusak', 'RUSAK', 6, 1, 2, '2022-12-25 16:03:41', '2022-12-27 01:33:51');

-- --------------------------------------------------------

--
-- Table structure for table `pengembalian`
--

CREATE TABLE `pengembalian` (
  `id_pengembalian` int(11) NOT NULL,
  `nomor` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `nomor_pinjam` varchar(50) NOT NULL,
  `id_user` int(11) NOT NULL,
  `keterangan` varchar(150) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0 => Active || 1 => Approved || 2 => Rejected',
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengembalian`
--

INSERT INTO `pengembalian` (`id_pengembalian`, `nomor`, `tanggal`, `nomor_pinjam`, `id_user`, `keterangan`, `status`, `updated_at`, `created_at`) VALUES
(1, 'PENG-202212-0001', '2022-10-12', 'PIN-202212-0001', 5, 'test coy', 2, '2022-12-10 08:03:38', '2022-12-10 07:06:11'),
(2, 'PENG-202212-0002', '2022-12-10', 'PIN-202212-0002', 5, 'test', 2, '2022-12-10 08:04:30', '2022-12-10 08:04:10'),
(3, 'PENG-202212-0003', '2022-12-10', 'PIN-202212-0003', 5, 'test', 2, '2022-12-10 08:04:32', '2022-12-10 08:04:18'),
(4, 'PENG-202212-0004', '2022-12-25', 'PIN-202212-0008', 6, '', 2, '2022-12-25 17:20:49', '2022-12-25 17:20:25'),
(5, 'PENG-202212-0005', '2022-12-27', 'PIN-202212-0004', 6, '', 2, '2022-12-27 02:14:37', '2022-12-27 02:07:21'),
(6, 'PENG-202212-0006', '2022-12-27', 'PIN-202212-0005', 6, '', 2, '2022-12-27 02:56:39', '2022-12-27 02:17:53');

-- --------------------------------------------------------

--
-- Table structure for table `pengembalian_detail`
--

CREATE TABLE `pengembalian_detail` (
  `id` int(11) NOT NULL,
  `nomor` varchar(50) NOT NULL,
  `nomor_pinjam` varchar(50) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jml` double NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengembalian_detail`
--

INSERT INTO `pengembalian_detail` (`id`, `nomor`, `nomor_pinjam`, `id_barang`, `jml`, `created_at`, `updated_at`) VALUES
(10, 'PENG-202212-0001', 'PIN-202212-0001', 3, 1, '2022-12-10 07:54:22', '2022-12-10 07:54:22'),
(11, 'PENG-202212-0002', 'PIN-202212-0002', 2, 1, '2022-12-10 08:04:10', '2022-12-10 08:04:10'),
(12, 'PENG-202212-0003', 'PIN-202212-0003', 1, 1, '2022-12-10 08:04:18', '2022-12-10 08:04:18'),
(13, 'PENG-202212-0003', 'PIN-202212-0003', 3, 1, '2022-12-10 08:04:18', '2022-12-10 08:04:18'),
(14, 'PENG-202212-0004', 'PIN-202212-0008', 7, 1, '2022-12-25 17:20:25', '2022-12-25 17:20:25'),
(15, 'PENG-202212-0005', 'PIN-202212-0004', 1, 1, '2022-12-27 02:07:21', '2022-12-27 02:07:21'),
(16, 'PENG-202212-0005', 'PIN-202212-0004', 3, 2, '2022-12-27 02:07:21', '2022-12-27 02:07:21'),
(17, 'PENG-202212-0006', 'PIN-202212-0005', 6, 1, '2022-12-27 02:17:53', '2022-12-27 02:17:53'),
(18, 'PENG-202212-0006', 'PIN-202212-0005', 8, 1, '2022-12-27 02:17:53', '2022-12-27 02:17:53');

-- --------------------------------------------------------

--
-- Table structure for table `pinjam`
--

CREATE TABLE `pinjam` (
  `id_pinjam` int(11) NOT NULL,
  `nomor_pinjam` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `id_user` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `tgl_kembali` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pinjam`
--

INSERT INTO `pinjam` (`id_pinjam`, `nomor_pinjam`, `tanggal`, `id_user`, `keterangan`, `tgl_kembali`, `status`, `updated_at`, `created_at`) VALUES
(1, 'PIN-202212-0001', '1970-01-01', 5, '', '1970-01-01', 2, '2022-12-10 06:49:56', '2022-12-07 22:07:23'),
(2, 'PIN-202212-0002', '2022-12-07', 5, 'test a', '2022-12-21', 2, '2022-12-10 00:59:56', '2022-12-07 23:09:29'),
(3, 'PIN-202212-0003', '2022-12-10', 5, '', '2022-12-18', 2, '2022-12-10 00:59:56', '2022-12-10 00:59:45'),
(8, 'PIN-202212-0004', '2022-12-10', 5, '', '2022-12-20', 2, '2022-12-10 21:35:51', '2022-12-10 08:15:08'),
(9, 'PIN-202212-0005', '2022-12-23', 6, 'Preventive Maintenance PT ISS Indonesia (ISSPO-BLKT2203-0055)', '2023-01-02', 2, '2022-12-27 01:33:59', '2022-12-23 04:07:24'),
(10, 'PIN-202212-0006', '2022-12-23', 6, 'Preventive Maintenance PT ISS Indonesia (ISSPO-BLKT2203-0055)', '2023-01-02', 0, '2022-12-25 16:00:45', '2022-12-23 04:26:24'),
(11, 'PIN-202212-0007', '2022-12-23', 6, 'Preventive Maintenance PT ISS Indonesia (ISSPO-BLKT2203-0055)', '2023-01-02', 0, '2022-12-25 16:00:54', '2022-12-23 04:30:08'),
(12, 'PIN-202212-0008', '2022-12-23', 6, '', '2023-01-02', 2, '2022-12-25 17:19:51', '2022-12-23 04:30:35'),
(13, 'PIN-202212-0009', '2022-12-23', 6, 'kelistrikan', '2023-01-02', 0, '2022-12-25 17:19:18', '2022-12-23 06:00:36'),
(14, 'PIN-202212-0010', '2022-12-23', 6, 'kelistrikan', '2023-01-02', 0, '2022-12-25 16:00:09', '2022-12-23 06:01:43');

-- --------------------------------------------------------

--
-- Table structure for table `pinjam_detail`
--

CREATE TABLE `pinjam_detail` (
  `id` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `nomor_pinjam` varchar(50) NOT NULL,
  `jml` double NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pinjam_detail`
--

INSERT INTO `pinjam_detail` (`id`, `id_barang`, `nomor_pinjam`, `jml`, `created_at`, `updated_at`) VALUES
(5, 2, 'PIN-202212-0002', 1, '2022-12-07 23:09:29', '2022-12-07 23:09:29'),
(6, 1, 'PIN-202212-0003', 1, '2022-12-10 00:59:45', '2022-12-10 00:59:45'),
(7, 3, 'PIN-202212-0003', 1, '2022-12-10 00:59:45', '2022-12-10 00:59:45'),
(12, 3, 'PIN-202212-0001', 1, '2022-12-10 06:49:56', '2022-12-10 06:49:56'),
(22, 1, 'PIN-202212-0004', 1, '2022-12-10 08:15:08', '2022-12-10 08:15:08'),
(23, 2, 'PIN-202212-0004', 1, '2022-12-10 08:15:08', '2022-12-10 08:15:08'),
(24, 3, 'PIN-202212-0004', 2, '2022-12-10 08:15:08', '2022-12-10 08:15:08'),
(25, 6, 'PIN-202212-0005', 1, '2022-12-23 04:07:24', '2022-12-23 04:07:24'),
(26, 8, 'PIN-202212-0005', 1, '2022-12-23 04:07:24', '2022-12-23 04:07:24'),
(27, 6, 'PIN-202212-0006', 1, '2022-12-23 04:26:24', '2022-12-23 04:26:24'),
(28, 8, 'PIN-202212-0006', 1, '2022-12-23 04:26:24', '2022-12-23 04:26:24'),
(29, 6, 'PIN-202212-0007', 1, '2022-12-23 04:30:08', '2022-12-23 04:30:08'),
(30, 8, 'PIN-202212-0007', 1, '2022-12-23 04:30:08', '2022-12-23 04:30:08'),
(31, 7, 'PIN-202212-0008', 1, '2022-12-23 04:30:36', '2022-12-23 04:30:36'),
(32, 10, 'PIN-202212-0009', 1, '2022-12-23 06:00:36', '2022-12-23 06:00:36'),
(33, 8, 'PIN-202212-0009', 1, '2022-12-23 06:00:36', '2022-12-23 06:00:36'),
(34, 10, 'PIN-202212-0010', 1, '2022-12-23 06:01:43', '2022-12-23 06:01:43'),
(35, 8, 'PIN-202212-0010', 1, '2022-12-23 06:01:43', '2022-12-23 06:01:43');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(150) NOT NULL DEFAULT '',
  `jabatan` varchar(150) DEFAULT NULL,
  `user_name` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL DEFAULT '',
  `wa` char(15) NOT NULL DEFAULT '',
  `administrator` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 => Bukan || 1 => admin',
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `jabatan`, `user_name`, `password`, `wa`, `administrator`, `updated_at`, `created_at`) VALUES
(1, 'admin', NULL, 'admin', '21232f297a57a5a743894a0e4a801fc3', '08563376207', 1, '2022-11-13 08:24:21', '2022-11-13 08:24:21'),
(2, 'Aan Hari S', 'STAFF GUDANG', 'aan', 'ba01bb349087d80e71ec363691aa8ad2', '082298177890', 1, '2022-12-22 14:49:20', '2022-12-05 22:11:49'),
(5, 'Doni Dwi Iskandar', 'SITE MANAGER', 'doni', '9acb1fb3730dfd727947589bb376cfce', '085704221292', 0, '2022-12-22 14:51:38', '2022-12-06 13:39:16'),
(6, 'Tutus Asih Galuh Retno Sari', 'PROJECT ADMIN', 'tutur', '15ff3c0a0310a2e3de3e95c8aeb328d0', '089680210592', 0, '2022-12-22 14:52:47', '2022-12-22 14:52:47'),
(9, 'Abdullah Abrizam R', 'STAF', 'izam', 'd78cba039ff0adf3e4a0406df5325191', '', 0, '2022-12-28 14:28:44', '2022-12-28 14:28:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kategori_id`);

--
-- Indexes for table `kondisi`
--
ALTER TABLE `kondisi`
  ADD PRIMARY KEY (`kondisi_id`);

--
-- Indexes for table `laporan_barang`
--
ALTER TABLE `laporan_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD PRIMARY KEY (`id_pengembalian`);

--
-- Indexes for table `pengembalian_detail`
--
ALTER TABLE `pengembalian_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pinjam`
--
ALTER TABLE `pinjam`
  ADD PRIMARY KEY (`id_pinjam`),
  ADD KEY `nomor_pinjam` (`nomor_pinjam`);

--
-- Indexes for table `pinjam_detail`
--
ALTER TABLE `pinjam_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `kategori_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `kondisi`
--
ALTER TABLE `kondisi`
  MODIFY `kondisi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `laporan_barang`
--
ALTER TABLE `laporan_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pengembalian`
--
ALTER TABLE `pengembalian`
  MODIFY `id_pengembalian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pengembalian_detail`
--
ALTER TABLE `pengembalian_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `pinjam`
--
ALTER TABLE `pinjam`
  MODIFY `id_pinjam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pinjam_detail`
--
ALTER TABLE `pinjam_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
