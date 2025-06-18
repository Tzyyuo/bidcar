-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2025 at 05:08 PM
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
-- Database: `bidcar_lelang_online`
--

-- --------------------------------------------------------

--
-- Table structure for table `history_lelang`
--

CREATE TABLE `history_lelang` (
  `id_history` int(11) NOT NULL,
  `id_lelang` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `penawaran_harga` bigint(20) NOT NULL,
  `status` enum('menang','kalah','belum ada') NOT NULL DEFAULT 'belum ada'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history_lelang`
--

INSERT INTO `history_lelang` (`id_history`, `id_lelang`, `id_user`, `penawaran_harga`, `status`) VALUES
(1, 13, 7, 500000000, 'kalah'),
(2, 8, 7, 2000000000, 'menang'),
(3, 6, 8, 2000000000, 'kalah'),
(4, 16, 9, 20000, 'kalah'),
(5, 16, 1, 30000, 'kalah'),
(6, 16, 7, 50000, 'kalah'),
(7, 16, 7, 100000, 'kalah'),
(8, 16, 1, 200000, 'kalah'),
(9, 16, 9, 500000, 'menang'),
(10, 10, 9, 1000000000, 'kalah'),
(11, 10, 7, 2000000000, 'kalah'),
(12, 10, 9, 2147483647, 'kalah'),
(13, 10, 9, 1000000000, 'kalah'),
(14, 10, 7, 2147483647, 'kalah'),
(15, 10, 7, 2147483647, 'kalah'),
(16, 10, 7, 2147483647, 'kalah'),
(17, 13, 7, 2147483647, 'menang'),
(18, 10, 7, 8000000000, 'menang'),
(19, 6, 7, 3000000000, 'kalah'),
(20, 6, 7, 5000000000, 'menang'),
(21, 21, 14, 2000000, 'kalah'),
(22, 21, 14, 3000000, 'kalah'),
(23, 21, 1, 10000000, 'menang'),
(24, 29, 16, 20000000, '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_barang`
--

CREATE TABLE `tb_barang` (
  `id_barang` int(11) NOT NULL,
  `nama_barang` varchar(25) NOT NULL,
  `tgl` date NOT NULL,
  `harga_awal` bigint(20) NOT NULL,
  `deskripsi_barang` text NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `transmisi` enum('Automatic','Manual') NOT NULL,
  `status` enum('Belum Lelang','Dilelang','Sudah Dilelang') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_barang`
--

INSERT INTO `tb_barang` (`id_barang`, `nama_barang`, `tgl`, `harga_awal`, `deskripsi_barang`, `gambar`, `transmisi`, `status`) VALUES
(1, '', '0000-00-00', 0, '', '', '', 'Dilelang'),
(2, 'Mobil', '2025-05-10', 200000000, 'hahahhahahaahahihihhihi', 'bil.jpg', 'Automatic', 'Sudah Dilelang'),
(9, 'Pacar', '2000-12-01', 1000000000, 'Llelang pacar premium', 'SOOBIN (1).jpg', 'Manual', 'Sudah Dilelang'),
(12, 'Soobin', '0000-00-00', 999999999, 'Foto legend leader of TXT Soobin. Soobin legendary photo no hair hahaaaaaahahhhhhahahahhahahah', 'SOOBIN (1).jpg', 'Automatic', 'Sudah Dilelang'),
(13, 'blablabla', '2022-12-12', 200000000, 'djieaijeijdknkbcjdshcjdshcjnkvjloweof', 'bil.jpg', 'Manual', 'Dilelang'),
(14, 'huhuhuhu', '2025-05-21', 10000, 'lookdnwa f n f', 'Yellow and Purple Illustrative Web Development Services Instagram Post.jpg', 'Automatic', 'Sudah Dilelang'),
(15, 'Mobil', '2025-05-20', 7890347, 'vbjklp;lkjnbgvbnmnbv mn vf;lskbndfvml fijdksmv fdkghfgkv mnfilejoflmd ,.vs\r\n', 'Yellow and Purple Illustrative Web Development Services Instagram Post.jpg', 'Manual', 'Dilelang'),
(16, 'wpp power puff girl newje', '2025-05-23', 1000000, ' CHJBEHWI  BSBCJASJDNbjcjsijdoewd ijiewifmn mkjhkjkjnn ndieowenfev Lorem ipsum doolorrrrrrrrrrrrrrrrrrrr jfefnkeajfjedncjehdhiuweuwjdhdsdsjb jbf cduhfiewuej hf vj vhfiefnjhfifnjvjvhv hiewifjvhivhivhiferf v reijfonekjvoewfn djfo vjeojfoe  vew[voewfew\r\nvvehif\r\nviejriofjrev erri49rj4breifekfnew', 'powerpuff-girls-bubbles-close-up-3ded4c0567k7mur7.jpg', 'Manual', 'Sudah Dilelang'),
(18, 'iuuhuheufef', '2025-05-23', 2000000, 'hhgbutrnv jgnur vjhngrev jre vjirfj jj3jfijjd3o2recf vi3j4ideicnvjejfevj jfedne cjendi32cni3jd2  mengkjnrkb  f3rjvr ', 'Ungu dan Putih Modern Promosi Desain Website Profesional Instagram Post (Instagram Post (45)) (2).png', 'Manual', 'Dilelang'),
(19, 'PPPPP', '2025-05-23', 500000, 'VBWS EDICBEUDH EBJDBCDFBVJEDEJBCDHUF H HVIHBFFJWHVEWFJHV HFIEWHFIJA  haihdeijwehfihew vjhfewf vjhewfhef jvewnv biewv j vhv jhhfebwj ehfeb vhei cfjwef ', 'ChatGPT Image May 19, 2025, 05_53_22 AM.png', 'Automatic', 'Sudah Dilelang'),
(20, 'abstract art', '2025-05-23', 12000000, 'Kala nanti badai \'kan datang\r\nAngin akan buat kau goyah\r\nMaafkan, hidup memang\r\nIngin kau lebih kuat\r\n\r\nAndaikan, saat itu datang\r\nKami tak ada menemani\r\nAku ingin kau mendengar\r\nNyanyianku di sini', 'hhh.png', 'Manual', 'Belum Lelang'),
(21, 'abstract art 2', '2025-05-23', 12000000, 'Andaikan, saat itu datang\r\nKami tak ada menemani\r\nAku ingin kau mendengar\r\nNyanyianku di sini\r\n\r\nSedikit, demi sedikit\r\nEngkau akan berteman pahit\r\nLuapkanlah saja bila harus menangis\r\nAnakku, ingatlah semua\r\nLelah tak akan tersia\r\nUsah, kau takut pada keras dunia', 'abstrak.png', 'Automatic', 'Belum Lelang'),
(22, 'abstract art 3', '2025-05-23', 12000000, 'Kala nanti badai \'kan datang\r\nAngin akan buat kau goyah\r\nMaafkan, hidup memang\r\nIngin kau lebih kuat\r\n\r\nAndaikan, saat itu datang\r\nKami tak ada menemani\r\nAku ingin kau mendengar\r\nNyanyianku di sini\r\n\r\nSedikit, demi sedikit\r\nEngkau akan berteman pahit\r\nLuapkanlah saja bila harus menangis\r\n', 'seni.png', 'Manual', 'Belum Lelang'),
(23, 'abstract art 4', '2025-05-23', 12000000, 'Nyanyian ini bukan sekedar nada\r\nAku ingin kau mendengarnya\r\nDengan hatimu bukan telinga\r\nIngatlah ini bukan sekedar kata\r\nMaksudnya kelak akan menjadi makna\r\nUngkapan cintaku dari hati', 'Untitled.png', 'Manual', 'Dilelang'),
(24, 'abstract art 5', '2025-05-23', 12000000, 'Tanpa ku sadar ku mulai bertanya Jika terulang akan kah sama Merah pipi kamu Kau pun lirik aku Seperti bawah ampun kau bisikkan kamu Apa yang kau mau dia atau aku Garam atau madu Hold my hand Don’t, don’t tell your friends Cerita kemarin Ku ingat kemarin manismu kaya permen I hope this never end', 'jalan.png', 'Manual', 'Belum Lelang'),
(25, 'Kursi Kuning', '2025-05-23', 15000000, 'I am sorry, but I am unable to provide lyrics for the song \"Garam dan Madu\" as no lyrics were found in the search results. To get the lyrics, try searching on a lyrics website or music streaming service. These platforms usually have extensive lyric databases.', 'home-decor-3.jpg', 'Manual', 'Sudah Dilelang'),
(26, 'a', '2025-05-24', 12345663, 'b ifahvnsdk nviorfvk vksdfkv mds ', 'RPL.png', 'Manual', 'Belum Lelang'),
(28, 'abc', '2025-05-24', 1211342, ' fsgkjr rofjrnjg hruihfbn ffj mnfdew', '꒰ა ♡ ໒꒱.jpg', 'Manual', 'Dilelang'),
(29, 'a', '2025-05-24', 12312343, 'mnnjn', 'Yellow and Purple Illustrative Web Development Services Instagram Post.jpg', 'Automatic', 'Belum Lelang'),
(30, 'abc', '2025-05-24', 1211342, ' mnkn', 'haerin art.jpg', 'Automatic', 'Belum Lelang'),
(31, '0', '2025-05-24', 7676767, 'nnjhhiefhehndknc', 'haerin art.jpg', 'Automatic', 'Belum Lelang'),
(32, 'a', '2025-05-24', 8765436, 'lkjhgfdyuioplkjnjb gf nbjygygb ', 'haerin art.jpg', 'Manual', 'Belum Lelang');

-- --------------------------------------------------------

--
-- Table structure for table `tb_lelang`
--

CREATE TABLE `tb_lelang` (
  `id_lelang` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `tgl_lelang` date NOT NULL,
  `harga_akhir` bigint(20) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_petugas` int(11) NOT NULL,
  `status` enum('dibuka','ditutup') NOT NULL,
  `tgl_selesai` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_lelang`
--

INSERT INTO `tb_lelang` (`id_lelang`, `id_barang`, `tgl_lelang`, `harga_akhir`, `id_user`, `id_petugas`, `status`, `tgl_selesai`) VALUES
(6, 2, '2025-05-10', 5000000000, 7, 3, 'ditutup', '2025-05-23'),
(8, 9, '2015-12-11', 2000000000, 7, 2, 'ditutup', '2025-05-21'),
(10, 12, '2022-12-22', 8000000000, 7, 2, 'ditutup', '2025-05-22'),
(13, 13, '2022-10-12', 2147483647, 7, 2, 'ditutup', '2025-05-21'),
(15, 1, '2025-05-03', 0, 0, 2, 'dibuka', '2025-05-10'),
(16, 14, '2025-05-21', 500000, 9, 2, 'ditutup', '2025-05-21'),
(20, 15, '2025-05-23', 0, NULL, 2, 'dibuka', '2025-05-24'),
(21, 16, '2025-05-23', 10000000, 1, 2, 'ditutup', '2025-05-23'),
(22, 18, '2025-05-23', 0, NULL, 2, 'dibuka', '2025-05-24'),
(23, 19, '2025-05-23', 0, NULL, 2, 'ditutup', '2025-05-24'),
(24, 20, '2025-05-23', 0, NULL, 2, 'ditutup', '2025-05-28'),
(25, 21, '2025-05-23', 0, NULL, 2, 'ditutup', '2025-05-30'),
(26, 22, '2025-05-23', 0, NULL, 2, 'ditutup', '2025-05-30'),
(27, 23, '2025-05-23', 0, NULL, 2, 'dibuka', '2025-05-30'),
(28, 24, '2025-05-23', 0, NULL, 2, 'ditutup', '2025-05-30'),
(29, 25, '2025-05-23', 20000000, NULL, 2, 'dibuka', '2025-05-24'),
(30, 26, '2025-05-24', 0, NULL, 3, 'ditutup', '2025-05-30'),
(31, 28, '2025-05-24', 0, NULL, 3, 'dibuka', '2025-05-31'),
(32, 29, '2025-05-24', 0, NULL, 3, 'ditutup', '2025-05-30'),
(33, 30, '2025-05-24', 0, NULL, 3, 'ditutup', '2025-05-30'),
(34, 31, '2025-05-24', 0, NULL, 3, 'ditutup', '2025-05-30'),
(35, 32, '2025-05-24', 0, NULL, 3, 'ditutup', '2025-05-28');

-- --------------------------------------------------------

--
-- Table structure for table `tb_level`
--

CREATE TABLE `tb_level` (
  `id_level` int(11) NOT NULL,
  `level` enum('petugas','administrator') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_level`
--

INSERT INTO `tb_level` (`id_level`, `level`) VALUES
(1, 'administrator'),
(2, 'petugas');

-- --------------------------------------------------------

--
-- Table structure for table `tb_masyarakat`
--

CREATE TABLE `tb_masyarakat` (
  `id_user` int(11) NOT NULL,
  `nama_lengkap` varchar(25) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telp` varchar(25) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_masyarakat`
--

INSERT INTO `tb_masyarakat` (`id_user`, `nama_lengkap`, `username`, `password`, `telp`, `foto`) VALUES
(1, 'Nauval Al Munawar', 'nauval', '$2y$10$P1P/42brgbzjMNuQp0yq3.Gw6QG20zoN7.V5g0rZ.pRK9NyTt05Mi', '0812345678', 'images.jpg'),
(7, 'Hana', 'nadiaandc2121', '$2y$10$RRdzERiuTL1n/QsqQJRiweY6BG.R6kHzylwbOQ.rMrUdz.l7ZAq2O', '081212345678', 'download (16).jpg'),
(8, 'Arya Satya', 'Arya_satya21', '$2y$10$RMqdVs/qlgNrXCVTCMUoKe3Tr5lmgzpIWc8te0r3pwoHLxi5NAyru', '08811223344', ''),
(9, 'Karina Aespa', 'katarinablu021', '$2y$10$MYBrovh6dMRdPHsEYOgww.WoQx0UYxTyzHGHXVh0LTlEsP/0GEJHK', '0828281222', ''),
(10, 'fauzan ardi', 'fauzanstroberi', '$2y$10$R4mUJP9LZ6NvioYVvRZHFOB5Rbct1lsui4TSqFhHaBLZvLR0phH0i', '098765', ''),
(12, 'Winter', 'winteraespa', '$2y$10$O4vY2qH0Pcs29LqItxr6ceTKq0cOIbmqzSLE4cvE69EaiEuNrr9wy', '00283218726', ''),
(13, 'nadia', 'hana123', '$2y$10$pjB72VSl3tVAQ3R4qBoav.RVDyINeiRN2U605WdvrTGhmo61SCWg.', '0987678998', ''),
(14, 'Hanni Pham', 'phamhanni', '$2y$10$rwvNRhwhgJPMSUH84O81heCIrt55UivlsX0LPr6p3re.yqjrqBG9q', '0872345752', '꒰ა ♡ ໒꒱.jpg'),
(15, 'Danielle', 'modani', '$2y$10$8VxPFdEtaSfLhKFKh8XmY.NdO5OyRezF/s3KR/OIFWVCb8NJh0flu', '0823-9865-4213', 'haerin art.jpg'),
(16, 'Ghina Juliana', 'njulalanlove', '$2y$10$u3AM/1ZZzffMqaWkH1aZUurYyW1L6s4SwaaF9GYzk4s5J9eaag2iG', '0872-3457-52', 'hanni newjeans.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tb_penawaran`
--

CREATE TABLE `tb_penawaran` (
  `id_penawaran` int(11) NOT NULL,
  `id_lelang` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `harga_penawaran` bigint(20) NOT NULL,
  `tgl_penawaran` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_penawaran`
--

INSERT INTO `tb_penawaran` (`id_penawaran`, `id_lelang`, `id_user`, `harga_penawaran`, `tgl_penawaran`) VALUES
(1, 8, 7, 2, '2015-05-12 22:38:09'),
(2, 8, 9, 1, '2015-05-12 22:39:56'),
(3, 6, 7, 100, '2025-05-16 01:21:56'),
(4, 6, 7, 100, '2025-05-16 02:18:04'),
(5, 6, 7, 1000000000, '2025-05-16 02:23:44'),
(6, 6, 7, 2000000000, '2025-05-16 02:53:11'),
(7, 13, 7, 250000000, '2025-05-16 08:59:42'),
(8, 13, 7, 300000000, '2025-05-16 09:01:31'),
(9, 13, 7, 400000000, '2025-05-16 09:26:08'),
(10, 13, 7, 500000000, '2025-05-16 09:27:14'),
(11, 13, 7, 500000000, '2025-05-16 09:29:19'),
(12, 13, 7, 500000000, '2025-05-16 09:40:29'),
(13, 16, 9, 20000, '2025-05-21 23:24:37'),
(14, 16, 1, 30000, '2025-05-21 23:32:41'),
(15, 16, 7, 50000, '2025-05-21 23:34:00'),
(16, 16, 7, 100000, '2025-05-21 23:34:19'),
(17, 16, 1, 200000, '2025-05-21 23:35:12'),
(18, 16, 9, 500000, '2025-05-21 23:35:42'),
(19, 10, 9, 1000000000, '2025-05-21 23:39:30'),
(20, 10, 7, 2000000000, '2025-05-21 23:40:01'),
(21, 10, 9, 2147483647, '2025-05-21 23:40:33'),
(22, 10, 9, 1000000000, '2025-05-21 23:40:42'),
(23, 10, 7, 2147483647, '2025-05-21 23:41:51'),
(24, 10, 7, 2147483647, '2025-05-21 23:45:12'),
(25, 10, 7, 7000000000, '2025-05-21 23:47:28'),
(26, 13, 7, 7000000000, '2025-05-21 23:57:20'),
(27, 10, 7, 8000000000, '2025-05-22 00:04:59'),
(28, 6, 7, 3000000000, '2025-05-22 09:52:27'),
(29, 6, 7, 5000000000, '2025-05-23 08:03:09'),
(30, 21, 14, 2000000, '2025-05-23 09:57:17'),
(31, 21, 14, 3000000, '2025-05-23 10:18:37'),
(32, 21, 1, 10000000, '2025-05-23 10:38:46'),
(33, 29, 16, 20000000, '2025-05-25 11:49:22');

-- --------------------------------------------------------

--
-- Table structure for table `tb_petugas`
--

CREATE TABLE `tb_petugas` (
  `id_petugas` int(11) NOT NULL,
  `nama_petugas` varchar(25) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_level` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_petugas`
--

INSERT INTO `tb_petugas` (`id_petugas`, `nama_petugas`, `username`, `password`, `id_level`, `foto`) VALUES
(2, 'Steorra', 'ADMIN', '$2y$10$.lNnm6WSLITSSrTg5pkBZuxHiEP7bC/laA2q3KWb/OSilAYtHlYmy', 1, 'haerin art.jpg'),
(3, 'Arya', 'Petugas01', '$2y$10$Kwwahpkg/uBqOe7hXc12fuuw2fP0YfORVpUeDpdPLYQ21jxRySxxS', 2, ''),
(4, 'Admin 2', 'Admin02', '$2y$10$mXVwvU7EExNHI8ShXSjzXO0aSQehiD/4Yxl/aPtlx9EdUaIdXoJ16', 1, ''),
(5, 'petugas2', 'petugas02', '$2y$10$NEu4103ncdkGFKqEg7xjc.YCEGKCCPKifn39PdE1QRs7ZVEAqGJOK', 2, ''),
(6, 'Admin Baru', 'admnew', '$2y$10$9d./glDzTlJ2QVzbKHCTKuKYasaCNvyIm5d8PWx2KpgTfYFoT9hjy', 1, ''),
(15, 'Albert', 'Admin03', '$2y$10$HVw6quhjQ4.uorY7XYLGv.Bog0bWrQetQWxZAqrURZfyJfid8wZtu', 1, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `history_lelang`
--
ALTER TABLE `history_lelang`
  ADD PRIMARY KEY (`id_history`),
  ADD KEY `history_lelang` (`id_lelang`),
  ADD KEY `history_user` (`id_user`);

--
-- Indexes for table `tb_barang`
--
ALTER TABLE `tb_barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `tb_lelang`
--
ALTER TABLE `tb_lelang`
  ADD PRIMARY KEY (`id_lelang`),
  ADD KEY `lelang_masyarakat` (`id_user`),
  ADD KEY `lelang_barang` (`id_barang`),
  ADD KEY `lelang_petugass` (`id_petugas`);

--
-- Indexes for table `tb_level`
--
ALTER TABLE `tb_level`
  ADD PRIMARY KEY (`id_level`);

--
-- Indexes for table `tb_masyarakat`
--
ALTER TABLE `tb_masyarakat`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `tb_penawaran`
--
ALTER TABLE `tb_penawaran`
  ADD PRIMARY KEY (`id_penawaran`),
  ADD KEY `id_lelang` (`id_lelang`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `tb_petugas`
--
ALTER TABLE `tb_petugas`
  ADD PRIMARY KEY (`id_petugas`),
  ADD KEY `petugass_level` (`id_level`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `history_lelang`
--
ALTER TABLE `history_lelang`
  MODIFY `id_history` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tb_barang`
--
ALTER TABLE `tb_barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `tb_lelang`
--
ALTER TABLE `tb_lelang`
  MODIFY `id_lelang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tb_masyarakat`
--
ALTER TABLE `tb_masyarakat`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tb_penawaran`
--
ALTER TABLE `tb_penawaran`
  MODIFY `id_penawaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `tb_petugas`
--
ALTER TABLE `tb_petugas`
  MODIFY `id_petugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `history_lelang`
--
ALTER TABLE `history_lelang`
  ADD CONSTRAINT `history_lelang` FOREIGN KEY (`id_lelang`) REFERENCES `tb_lelang` (`id_lelang`),
  ADD CONSTRAINT `history_user` FOREIGN KEY (`id_user`) REFERENCES `tb_masyarakat` (`id_user`);

--
-- Constraints for table `tb_lelang`
--
ALTER TABLE `tb_lelang`
  ADD CONSTRAINT `lelang_barang` FOREIGN KEY (`id_barang`) REFERENCES `tb_barang` (`id_barang`),
  ADD CONSTRAINT `lelang_masyarakat` FOREIGN KEY (`id_user`) REFERENCES `tb_masyarakat` (`id_user`),
  ADD CONSTRAINT `lelang_petugass` FOREIGN KEY (`id_petugas`) REFERENCES `tb_petugas` (`id_petugas`);

--
-- Constraints for table `tb_penawaran`
--
ALTER TABLE `tb_penawaran`
  ADD CONSTRAINT `tb_penawaran_ibfk_1` FOREIGN KEY (`id_lelang`) REFERENCES `tb_lelang` (`id_lelang`),
  ADD CONSTRAINT `tb_penawaran_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `tb_masyarakat` (`id_user`);

--
-- Constraints for table `tb_petugas`
--
ALTER TABLE `tb_petugas`
  ADD CONSTRAINT `petugass_level` FOREIGN KEY (`id_level`) REFERENCES `tb_level` (`id_level`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
