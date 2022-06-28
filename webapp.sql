-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 28, 2022 at 07:57 AM
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
-- Database: `webapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `idAdmin` int(11) NOT NULL,
  `idPengguna` int(11) NOT NULL,
  `namaAdmin` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`idAdmin`, `idPengguna`, `namaAdmin`) VALUES
(1, 1, 'Admin');

-- --------------------------------------------------------

--
-- Stand-in structure for view `allpengguna`
-- (See below for the actual view)
--
CREATE TABLE `allpengguna` (
`id` int(11)
,`nama` varchar(200)
,`emel` varchar(200)
,`kataLaluan` varchar(64)
,`peranan` int(11)
,`telefonPeserta` varchar(12)
,`noicPeserta` varchar(12)
,`alamatPeserta` varchar(200)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `allpeserta`
-- (See below for the actual view)
--
CREATE TABLE `allpeserta` (
`id` int(11)
,`idPengguna` int(11)
,`nama` varchar(200)
,`a` int(11)
,`b` int(11)
,`c` int(11)
,`jumlah` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `hakim`
--

CREATE TABLE `hakim` (
  `idHakim` int(11) NOT NULL,
  `idPengguna` int(11) NOT NULL,
  `namaHakim` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `markah`
--

CREATE TABLE `markah` (
  `idMarkah` int(11) NOT NULL,
  `idPeserta` int(11) NOT NULL,
  `markahBhgA` int(11) NOT NULL DEFAULT 0,
  `markahBhgB` int(11) NOT NULL DEFAULT 0,
  `markahBhgC` int(11) NOT NULL DEFAULT 0,
  `jumlahMarkah` int(11) GENERATED ALWAYS AS (`markahBhgA` + `markahBhgB` + `markahBhgC`) VIRTUAL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `markah`
--

INSERT INTO `markah` (`idMarkah`, `idPeserta`, `markahBhgA`, `markahBhgB`, `markahBhgC`) VALUES
(1, 1, 2, 5, 6),
(2, 2, 0, 0, 0),
(3, 3, 0, 0, 0),
(4, 4, 0, 0, 0),
(5, 5, 0, 0, 0),
(6, 6, 20, 30, 50),
(7, 7, 20, 30, 50),
(8, 8, 4, 3, 3),
(9, 9, 2, 3, 4),
(10, 10, 12, 23, 45),
(11, 11, 10, 10, 10),
(12, 12, 10, 30, 20),
(13, 13, 0, 0, 0),
(14, 14, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `idPengguna` int(11) NOT NULL,
  `emelPengguna` varchar(200) NOT NULL,
  `kataLaluanPengguna` varchar(64) NOT NULL,
  `perananPengguna` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`idPengguna`, `emelPengguna`, `kataLaluanPengguna`, `perananPengguna`) VALUES
(1, 'admin@testing.com', 'b822f1cd2dcfc685b47e83e3980289fd5d8e3ff3a82def24d7d1d68bb272eb32', 6),
(2, 'dwadw@gmail.com', 'cf80cd8aed482d5d1527d7dc72fceff84e6326592848447d2dc0b0e87dfc9a90', 1),
(3, 'ae2aq@gmail.com', 'cf80cd8aed482d5d1527d7dc72fceff84e6326592848447d2dc0b0e87dfc9a90', 1),
(4, 'jaylen.leuschke@hotmail.com', 'cf80cd8aed482d5d1527d7dc72fceff84e6326592848447d2dc0b0e87dfc9a90', 1),
(5, 'jennie67@yahoo.com', 'cf80cd8aed482d5d1527d7dc72fceff84e6326592848447d2dc0b0e87dfc9a90', 1),
(6, 'otho.schultz@hotmail.com', 'cf80cd8aed482d5d1527d7dc72fceff84e6326592848447d2dc0b0e87dfc9a90', 1),
(7, 'paxton29@gmail.com', 'cf80cd8aed482d5d1527d7dc72fceff84e6326592848447d2dc0b0e87dfc9a90', 1),
(8, 'darlene.schmeler@gmail.com', 'cf80cd8aed482d5d1527d7dc72fceff84e6326592848447d2dc0b0e87dfc9a90', 1),
(9, 'alexandria88@yahoo.com', 'cf80cd8aed482d5d1527d7dc72fceff84e6326592848447d2dc0b0e87dfc9a90', 1),
(10, 'trycia.block7@yahoo.com', 'cf80cd8aed482d5d1527d7dc72fceff84e6326592848447d2dc0b0e87dfc9a90', 1),
(11, 'a@dw21.cokwad', 'cf80cd8aed482d5d1527d7dc72fceff84e6326592848447d2dc0b0e87dfc9a90', 1),
(12, 'e1e12@ggg.com', 'cf80cd8aed482d5d1527d7dc72fceff84e6326592848447d2dc0b0e87dfc9a90', 1),
(13, 'dwad21@fwa.com', 'cf80cd8aed482d5d1527d7dc72fceff84e6326592848447d2dc0b0e87dfc9a90', 1),
(14, 'a@WEEEEEEEE.com', 'cf80cd8aed482d5d1527d7dc72fceff84e6326592848447d2dc0b0e87dfc9a90', 1),
(15, 'peserta@testing.com', 'b822f1cd2dcfc685b47e83e3980289fd5d8e3ff3a82def24d7d1d68bb272eb32', 1);

-- --------------------------------------------------------

--
-- Table structure for table `peserta`
--

CREATE TABLE `peserta` (
  `idPeserta` int(11) NOT NULL,
  `idPengguna` int(11) NOT NULL,
  `namaPeserta` varchar(200) NOT NULL,
  `telefonPeserta` varchar(12) NOT NULL,
  `noicPeserta` varchar(12) NOT NULL,
  `alamatPeserta` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `peserta`
--

INSERT INTO `peserta` (`idPeserta`, `idPengguna`, `namaPeserta`, `telefonPeserta`, `noicPeserta`, `alamatPeserta`) VALUES
(1, 2, 'b', 'aa', 'aa', 'aa'),
(2, 3, 'c', 'a', 'a', 'a'),
(3, 4, 'd', 'b', 'b', 'a'),
(4, 5, 'e', 'aa', 'aa', 'aa'),
(5, 6, 'f', 'a', 'a', 'a'),
(6, 7, 'g', 'b', 'b', 'a'),
(7, 8, 'h', 'aa', 'aa', 'aa'),
(8, 9, 'i', 'a', 'a', 'a'),
(9, 10, 'j', 'b', 'b', 'a'),
(10, 11, 'dwadwa', '1', '1', 'd'),
(11, 12, 'admin@testing.com', 'dwad', 'adw', 'dwa'),
(12, 13, 'admin@testing.com', 'dwa', 'dwwa', 'dwa'),
(13, 14, '1', '1', '2', 'a'),
(14, 15, 'ALI', 'a', 'a', 'a');

--
-- Triggers `peserta`
--
DELIMITER $$
CREATE TRIGGER `add markah` AFTER INSERT ON `peserta` FOR EACH ROW INSERT INTO markah (idPeserta) VALUES (NEW.idPeserta)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure for view `allpengguna`
--
DROP TABLE IF EXISTS `allpengguna`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `allpengguna`  AS SELECT `ap`.`id` AS `id`, `ap`.`nama` AS `nama`, `pengguna`.`emelPengguna` AS `emel`, `pengguna`.`kataLaluanPengguna` AS `kataLaluan`, `pengguna`.`perananPengguna` AS `peranan`, `ap`.`telefonPeserta` AS `telefonPeserta`, `ap`.`noicPeserta` AS `noicPeserta`, `ap`.`alamatPeserta` AS `alamatPeserta` FROM ((select `peserta`.`idPengguna` AS `id`,`peserta`.`namaPeserta` AS `nama`,`peserta`.`telefonPeserta` AS `telefonPeserta`,`peserta`.`noicPeserta` AS `noicPeserta`,`peserta`.`alamatPeserta` AS `alamatPeserta` from `peserta` union all select `hakim`.`idPengguna` AS `id`,`hakim`.`namaHakim` AS `nama`,NULL AS `NULL`,NULL AS `NULL`,NULL AS `NULL` from `hakim` union all select `admin`.`idPengguna` AS `id`,`admin`.`namaAdmin` AS `nama`,NULL AS `NULL`,NULL AS `NULL`,NULL AS `NULL` from `admin`) `ap` join `pengguna` on(`pengguna`.`idPengguna` = `ap`.`id`))  ;

-- --------------------------------------------------------

--
-- Structure for view `allpeserta`
--
DROP TABLE IF EXISTS `allpeserta`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `allpeserta`  AS SELECT `peserta`.`idPeserta` AS `id`, `peserta`.`idPengguna` AS `idPengguna`, `peserta`.`namaPeserta` AS `nama`, `markah`.`markahBhgA` AS `a`, `markah`.`markahBhgB` AS `b`, `markah`.`markahBhgC` AS `c`, `markah`.`jumlahMarkah` AS `jumlah` FROM (`peserta` join `markah` on(`peserta`.`idPeserta` = `markah`.`idPeserta`)) ORDER BY `markah`.`jumlahMarkah` AS `DESCdesc` ASC  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`idAdmin`),
  ADD KEY `admin_ibfk_1` (`idPengguna`);

--
-- Indexes for table `hakim`
--
ALTER TABLE `hakim`
  ADD PRIMARY KEY (`idHakim`),
  ADD KEY `hakim_ibfk_1` (`idPengguna`);

--
-- Indexes for table `markah`
--
ALTER TABLE `markah`
  ADD PRIMARY KEY (`idMarkah`),
  ADD KEY `markah_ibfk_1` (`idPeserta`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`idPengguna`),
  ADD UNIQUE KEY `emelPengguna` (`emelPengguna`);

--
-- Indexes for table `peserta`
--
ALTER TABLE `peserta`
  ADD PRIMARY KEY (`idPeserta`),
  ADD KEY `peserta_ibfk_1` (`idPengguna`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `idAdmin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hakim`
--
ALTER TABLE `hakim`
  MODIFY `idHakim` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `markah`
--
ALTER TABLE `markah`
  MODIFY `idMarkah` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `idPengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `peserta`
--
ALTER TABLE `peserta`
  MODIFY `idPeserta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`idPengguna`) REFERENCES `pengguna` (`idPengguna`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hakim`
--
ALTER TABLE `hakim`
  ADD CONSTRAINT `hakim_ibfk_1` FOREIGN KEY (`idPengguna`) REFERENCES `pengguna` (`idPengguna`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `markah`
--
ALTER TABLE `markah`
  ADD CONSTRAINT `markah_ibfk_1` FOREIGN KEY (`idPeserta`) REFERENCES `peserta` (`idPeserta`) ON DELETE CASCADE;

--
-- Constraints for table `peserta`
--
ALTER TABLE `peserta`
  ADD CONSTRAINT `peserta_ibfk_1` FOREIGN KEY (`idPengguna`) REFERENCES `pengguna` (`idPengguna`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
