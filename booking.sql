-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 19, 2024 at 10:45 AM
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
-- Database: `booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookingan`
--

CREATE TABLE `bookingan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `jenis_lapangan` enum('A','B') NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Belum Terverifikasi',
  `status_bayar` varchar(255) NOT NULL DEFAULT 'Belum bayar',
  `total_harga` decimal(10,2) DEFAULT NULL,
  `bukti_pembayaran` blob NOT NULL,
  `lapangan_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookingan`
--

INSERT INTO `bookingan` (`id`, `nama`, `tanggal`, `jam_mulai`, `jam_selesai`, `jenis_lapangan`, `user_id`, `status`, `status_bayar`, `total_harga`, `bukti_pembayaran`, `lapangan_id`) VALUES
(90, '', '2024-01-18', '15:00:00', '16:00:00', 'A', 15, 'Terverifikasi', 'Dibayar', NULL, 0x75706c6f6164732f62756b74695f70656d6261796172616e2f53637265656e73686f745f323032342d30312d31322d31322d33352d35392d3439355f69642e64616e612e6a7067, NULL),
(91, '', '2024-01-18', '17:00:00', '18:00:00', 'A', 15, 'Terverifikasi', 'Dibayar', NULL, 0x75706c6f6164732f62756b74695f70656d6261796172616e2f53637265656e73686f745f323032342d30312d31312d31322d34342d34312d3835305f636f6d2e617869732e6e65742e6a7067, NULL),
(92, '', '2024-01-18', '18:00:00', '19:00:00', 'A', 15, 'Belum Terverifikasi', 'Dibayar', NULL, 0x75706c6f6164732f62756b74695f70656d6261796172616e2f332e706e67, NULL),
(93, '', '2024-01-18', '19:00:00', '21:00:00', 'A', 15, 'Belum Terverifikasi', 'Dibayar', NULL, 0x75706c6f6164732f62756b74695f70656d6261796172616e2f332e706e67, NULL),
(94, '', '2024-01-18', '21:00:00', '22:00:00', 'A', 15, 'Belum Terverifikasi', 'Dibayar', NULL, 0x75706c6f6164732f62756b74695f70656d6261796172616e2f312e706e67, NULL),
(95, '', '2024-01-18', '23:00:00', '00:00:00', 'A', 15, 'Belum Terverifikasi', 'Dibayar', NULL, 0x75706c6f6164732f62756b74695f70656d6261796172616e2f312e504e47, NULL),
(96, '', '2024-01-19', '10:00:00', '11:00:00', 'A', 15, 'Belum Terverifikasi', 'Belum bayar', NULL, '', NULL),
(97, '', '2024-01-20', '10:00:00', '11:00:00', 'A', 15, 'Belum Terverifikasi', 'Belum bayar', NULL, '', NULL),
(98, '', '2024-01-19', '00:00:00', '01:00:00', 'A', 15, 'Belum Terverifikasi', 'Belum bayar', NULL, '', NULL),
(99, '', '2024-01-19', '17:00:00', '18:00:00', 'A', 41, 'Belum Terverifikasi', 'Belum bayar', NULL, '', NULL),
(100, '', '2024-01-20', '20:00:00', '21:00:00', 'A', 41, 'Belum Terverifikasi', 'Belum bayar', NULL, '', NULL),
(101, '', '2024-01-20', '11:00:00', '12:00:00', 'A', 41, 'Belum Terverifikasi', 'Belum bayar', NULL, '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lapangan`
--

CREATE TABLE `lapangan` (
  `id` int(11) NOT NULL,
  `nama_lapangan` varchar(50) DEFAULT NULL,
  `harga_per_jam` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lapangan`
--

INSERT INTO `lapangan` (`id`, `nama_lapangan`, `harga_per_jam`) VALUES
(1, 'A', 100000.00),
(2, 'B', 1300000.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(70) NOT NULL,
  `telpon` varchar(30) NOT NULL,
  `foto` blob NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `telpon`, `foto`, `username`, `password`, `role`) VALUES
(12, 'afif', 'dinatasyukra@gmail.com', '083167961562', 0x363561323630393333373232332e6a7067, 'afif', '$2y$10$RRzkLqQj4Iu0jaqcUnWDKOx/BpihO24cbmcPzgyLSPKtpcNa4L7Xi', 'user'),
(14, 'Rasyid Firdaus Harmaini', 'rasyidfirdaus53@gmail.com', '083167961562', '', 'rasyid13', '$2y$10$N2YAH2kc/XZ1CAenjblId.IlJjVKGbzVvy6WcxLndUYGj2wQ2ukf6', 'user'),
(15, 'farhan al islam', 'rasyid@gmail.com', '083167961562', 0x363561376536653632353061662e706e67, 'farhan', '$2y$10$UsqMzikWIPfcor3V5pE1o.OSiIIl9dSjo4m0yBILOXu9BG.cO.s/a', 'user'),
(30, 'Rasyid Firdaus Harmaini', 'rasyidfirfaus53@gmail.com', '083167961562', '', 'admin1', '$2y$10$6dEP8axARDJeiLYH0ELOTuqu/HS88G.Y5kAQtksz2souHDNiyfn7C', 'admin'),
(40, 'Rasyid Firdaus Harmaini', 'rasyidfirfaus53@gmail.com', '083167961562', '', 'admin2', '$2y$10$RbR8v0oGoFC6wCsjZm8gC.syOJmbkZJ4KLfLMIPCHMm.uyZZ.VxyK', 'admin'),
(41, 'rasyid firdaus', 'rasyidfirdaus53@gmail.com', '083167961562', '', 'rasyid', '$2y$10$J0DyyoghiKdZgktxJsGlA.3k1mwZ/oDJpPSylvfgmwfo/NogwGemm', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookingan`
--
ALTER TABLE `bookingan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lapangan_id` (`lapangan_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `lapangan`
--
ALTER TABLE `lapangan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookingan`
--
ALTER TABLE `bookingan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `lapangan`
--
ALTER TABLE `lapangan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookingan`
--
ALTER TABLE `bookingan`
  ADD CONSTRAINT `bookingan_ibfk_1` FOREIGN KEY (`lapangan_id`) REFERENCES `lapangan` (`id`),
  ADD CONSTRAINT `bookingan_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
