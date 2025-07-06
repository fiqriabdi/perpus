-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2025 at 07:38 PM
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
-- Database: `perpus`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id_buku` int(11) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `judul` varchar(100) DEFAULT NULL,
  `penulis` varchar(100) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `stok` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id_buku`, `gambar`, `judul`, `penulis`, `deskripsi`, `stok`) VALUES
(9, 'b3.png', 'Walet', 'John Ortberg2', NULL, 2),
(10, 'b2.png', 'Arsitektur Rumah Jawa', 'Asti Musman', 'Jawa dengan', 10),
(12, 'b1.png', 'Langkah-Langkah', 'John Ortberg', NULL, 15),
(13, 'b4.png', 'Memahami Sains Modern', 'Nidhal Guessoum', NULL, 13),
(14, 'b5.png', 'Metodologi Kajian Tradisi Lisan-Edisi Revisi', 'Pudentia MPSS', NULL, 12),
(15, 'samh.png', 'Seikhlas Awan Mencintai Hujan', 'Patahan Ranting', NULL, 2),
(16, 'dsbmatm.png', 'Di Sudut Bumi Manapun, Aku Tetap Mencintaimu', 'Alma Neira', NULL, 3),
(17, 'harry potter.png', 'Harry Potter', 'J.K. Rowling', 'Edisi khusus Harry Potter and the Order of the Phoenix ini memiliki ilustrasi sampul baru yang cantik oleh Kazu Kibuishi. Di dalamnya ada teks lengkap dari novel aslinya, dengan dekorasi oleh Mary GrandPré.\r\n\r\n“Ada sebuah pintu di ujung koridor yang sunyi. Dan itu menghantui mimpi Harry Potter. Kenapa lagi dia terbangun di tengah malam, berteriak ketakutan? Berikut adalah beberapa hal yang ada di pikiran Harry:\r\n\r\nSeorang guru Pertahanan Terhadap Ilmu Hitam dengan kepribadian seperti madu beracun, peri rumah yang berbisa dan tidak puas, Ron sebagai penjaga tim Quidditch Gryffindor, teror yang membayangi dari ujian Tingkat Sihir Biasa akhir semester, dan tentu saja, meningkatnya ancaman Dia-Yang-Tidak-Boleh-Disebut Namanya.', 4),
(19, 'one piece.png', 'One Piece', 'Eiichiro Oda', 'ALAU TIDAK MENDIDIH, BUKAN ODEN NAMANYA\r\nBagaikan dituntun takdir, di tengah petualangannya dengan Shirohige, Oden berjumpa Roger!! Seperti apa dampak pertemuan kebetulan mereka pada dunia!? Sementara itu, di Negara Wano, Orochi diam-diam mulai bergerak saat Oden absen!? Simak kisah petualangan di lautan, One Piece!!', 5);

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_peminjaman` int(11) NOT NULL,
  `id_buku` int(11) DEFAULT NULL,
  `id_users` int(11) DEFAULT NULL,
  `tgl_pinjam` date DEFAULT curdate(),
  `tgl_balik` varchar(15) DEFAULT '-',
  `status` enum('dipinjam','dikembalikan','pending') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id_peminjaman`, `id_buku`, `id_users`, `tgl_pinjam`, `tgl_balik`, `status`) VALUES
(36, 10, 1, '2025-06-29', '2025-06-29', 'dikembalikan'),
(37, 10, 1, '2025-06-29', '2025-06-29', 'dikembalikan'),
(38, 10, 1, '2025-06-29', '2025-06-29', 'dikembalikan'),
(39, 10, 1, '2025-06-29', '-', 'dipinjam'),
(40, 10, 3, '2025-06-29', '2025-06-29', 'dikembalikan'),
(41, 10, 3, '2025-06-29', '2025-06-29', 'dikembalikan'),
(42, 14, 4, '2025-06-29', '-', 'pending'),
(43, 14, 4, '2025-06-29', '-', 'dipinjam'),
(44, 12, 5, '2025-07-03', '-', 'dipinjam'),
(45, 12, 5, '2025-07-03', '-', 'dipinjam');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_users` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_users`, `username`, `password`, `role`) VALUES
(1, 'usr123', '1', 'user'),
(2, 'admin', 'a', 'admin'),
(3, 'agnes', 'ai', 'user'),
(4, 'lin', 'lin', 'user'),
(5, 'bliksemqri', '1', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id_buku`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `id_buku` (`id_buku`),
  ADD KEY `id_users` (`id_users`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_users`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_buku`) REFERENCES `books` (`id_buku`) ON DELETE CASCADE,
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
