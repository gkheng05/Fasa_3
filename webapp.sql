-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 19, 2022 at 03:29 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

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
  `namaAdmin` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`idAdmin`, `namaAdmin`) VALUES
(9, 'admin');

-- --------------------------------------------------------

--
-- Stand-in structure for view `allpengguna`
-- (See below for the actual view)
--
CREATE TABLE `allpengguna` (
`id` int(11)
,`nama` varchar(200)
,`emel` varchar(200)
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
  `namaHakim` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hakim`
--

INSERT INTO `hakim` (`idHakim`, `namaHakim`) VALUES
(100, 'agi1'),
(101, 'agi2'),
(102, 'agi3'),
(103, 'agi4'),
(104, 'agi5'),
(185, 'hakimm');

-- --------------------------------------------------------

--
-- Table structure for table `markah`
--

CREATE TABLE `markah` (
  `idMarkah` int(11) NOT NULL,
  `markahBhgA` int(11) NOT NULL DEFAULT 0,
  `markahBhgB` int(11) NOT NULL DEFAULT 0,
  `markahBhgC` int(11) NOT NULL DEFAULT 0,
  `jumlahMarkah` int(11) GENERATED ALWAYS AS (`markahBhgA` + `markahBhgB` + `markahBhgC`) VIRTUAL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `markah`
--

INSERT INTO `markah` (`idMarkah`, `markahBhgA`, `markahBhgB`, `markahBhgC`) VALUES
(175, 17, 28, 47),
(176, 10, 21, 40),
(177, 13, 24, 43),
(178, 15, 26, 45),
(179, 18, 29, 48),
(180, 11, 22, 41),
(181, 14, 25, 44),
(182, 16, 27, 46),
(183, 19, 30, 49),
(184, 12, 23, 42),
(186, 0, 0, 0);

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
(9, 'admin@testing.com', 'b822f1cd2dcfc685b47e83e3980289fd5d8e3ff3a82def24d7d1d68bb272eb32', 6),
(100, 's@test.com', 'ecd71870d1963316a97e3ac3408c9835ad8cf0f3c1bc703527c30265534f75ae', 2),
(101, 'gg2@hakim.com', 'a248d958573f5b710bfa762512f6bfb7f6e8aa7c42e69296f7e5843ef6ce197e', 2),
(102, 'gg3@hakim.com', '0880de822d15f4cfecb4adaa4633092d7d2f7d33659969e9a8982a19623b3872', 2),
(103, 'gg4@hakim.com', 'cafda4cb1eaf3fb0792a2e5f4cbd5cd29ce8ba4241a88d78054749e09f6ac20e', 2),
(104, 'gg5@hakim.com', '9cc0a324b4075d5777afba213b6bf2d8648d098aa97ec5589b09937c54c528e9', 2),
(175, 'dwad@gmail.com', 'ecd71870d1963316a97e3ac3408c9835ad8cf0f3c1bc703527c30265534f75ae', 1),
(176, 'dwadw@gmail.com', 'a248d958573f5b710bfa762512f6bfb7f6e8aa7c42e69296f7e5843ef6ce197e', 1),
(177, 'ae2aq@gmail.com', '0880de822d15f4cfecb4adaa4633092d7d2f7d33659969e9a8982a19623b3872', 1),
(178, 'jaylen.leuschke@hotmail.com', 'cafda4cb1eaf3fb0792a2e5f4cbd5cd29ce8ba4241a88d78054749e09f6ac20e', 1),
(179, 'jennie67@yahoo.com', '9cc0a324b4075d5777afba213b6bf2d8648d098aa97ec5589b09937c54c528e9', 1),
(180, 'otho.schultz@hotmail.com', '3b47320028a4f635f0b6aa4f3aa7f8170b6a300c501acee3e54134fc0cc36f3b', 1),
(181, 'paxton29@gmail.com', '8e3ddedf3f35ac6ce3b8551c9cf3209d439492f2bc7407c62152429117e6a659', 1),
(182, 'darlene.schmeler@gmail.com', 'ad23ed9832d5432e03699647528aa511429c224959ff3c5f91bb0a0235ad5b8f', 1),
(183, 'alexandria88@yahoo.com', '3a8cbeb1be65920447f0ed075e5e6e87eb15f6e1cfca74a9e1c480ab8ad4106e', 1),
(184, 'trycia.block7@yahoo.com', '57792514b166b38d98abf658e2ef6d78a1a26f62cd1db340f3bd1f7e6bc78009', 1),
(185, 'hakim@hakim.com', 'b822f1cd2dcfc685b47e83e3980289fd5d8e3ff3a82def24d7d1d68bb272eb32', 2),
(186, 'peserta@p.com', 'b822f1cd2dcfc685b47e83e3980289fd5d8e3ff3a82def24d7d1d68bb272eb32', 1);

-- --------------------------------------------------------

--
-- Table structure for table `peserta`
--

CREATE TABLE `peserta` (
  `idPeserta` int(11) NOT NULL,
  `namaPeserta` varchar(200) NOT NULL,
  `telefonPeserta` varchar(12) NOT NULL,
  `noicPeserta` varchar(12) NOT NULL,
  `alamatPeserta` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `peserta`
--

INSERT INTO `peserta` (`idPeserta`, `namaPeserta`, `telefonPeserta`, `noicPeserta`, `alamatPeserta`) VALUES
(175, 'a', 'b', 'b', 'a'),
(176, 'b', 'aa', 'aa', 'aa'),
(177, 'c', 'a', 'a', 'a'),
(178, 'd', 'b', 'b', 'a'),
(179, 'e', 'aa', 'aa', 'aa'),
(180, 'f', 'a', 'a', 'a'),
(181, 'g', 'b', 'b', 'a'),
(182, 'h', 'aa', 'aa', 'aa'),
(183, 'i', 'a', 'a', 'a'),
(184, 'j', 'b', 'b', 'a'),
(186, 'aaaa', 'a', 'a', 'a');

-- --------------------------------------------------------

--
-- Structure for view `allpengguna`
--
DROP TABLE IF EXISTS `allpengguna`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `allpengguna`  AS SELECT `ap`.`id` AS `id`, `ap`.`nama` AS `nama`, `pengguna`.`emelPengguna` AS `emel`, `pengguna`.`perananPengguna` AS `peranan`, `ap`.`telefonPeserta` AS `telefonPeserta`, `ap`.`noicPeserta` AS `noicPeserta`, `ap`.`alamatPeserta` AS `alamatPeserta` FROM ((select `peserta`.`idPeserta` AS `id`,`peserta`.`namaPeserta` AS `nama`,`peserta`.`telefonPeserta` AS `telefonPeserta`,`peserta`.`noicPeserta` AS `noicPeserta`,`peserta`.`alamatPeserta` AS `alamatPeserta` from `peserta` union all select `hakim`.`idHakim` AS `id`,`hakim`.`namaHakim` AS `nama`,NULL AS `NULL`,NULL AS `NULL`,NULL AS `NULL` from `hakim` union all select `admin`.`idAdmin` AS `id`,`admin`.`namaAdmin` AS `nama`,NULL AS `NULL`,NULL AS `NULL`,NULL AS `NULL` from `admin`) `ap` join `pengguna` on(`pengguna`.`idPengguna` = `ap`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `allpeserta`
--
DROP TABLE IF EXISTS `allpeserta`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `allpeserta`  AS SELECT `peserta`.`idPeserta` AS `id`, `peserta`.`namaPeserta` AS `nama`, `markah`.`markahBhgA` AS `a`, `markah`.`markahBhgB` AS `b`, `markah`.`markahBhgC` AS `c`, `markah`.`jumlahMarkah` AS `jumlah` FROM (`peserta` join `markah` on(`peserta`.`idPeserta` = `markah`.`idMarkah`)) ORDER BY `markah`.`jumlahMarkah` DESC ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`idAdmin`);

--
-- Indexes for table `hakim`
--
ALTER TABLE `hakim`
  ADD PRIMARY KEY (`idHakim`);

--
-- Indexes for table `markah`
--
ALTER TABLE `markah`
  ADD PRIMARY KEY (`idMarkah`);

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
  ADD PRIMARY KEY (`idPeserta`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `markah`
--
ALTER TABLE `markah`
  MODIFY `idMarkah` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `idPengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`idAdmin`) REFERENCES `pengguna` (`idPengguna`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hakim`
--
ALTER TABLE `hakim`
  ADD CONSTRAINT `hakim_ibfk_1` FOREIGN KEY (`idHakim`) REFERENCES `pengguna` (`idPengguna`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `markah`
--
ALTER TABLE `markah`
  ADD CONSTRAINT `markah_ibfk_1` FOREIGN KEY (`idMarkah`) REFERENCES `pengguna` (`idPengguna`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `peserta`
--
ALTER TABLE `peserta`
  ADD CONSTRAINT `peserta_ibfk_1` FOREIGN KEY (`idPeserta`) REFERENCES `pengguna` (`idPengguna`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
