-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2019 at 02:18 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbadmin`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `idbarang` varchar(10) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `satuan` varchar(10) NOT NULL,
  `merk` varchar(50) NOT NULL,
  `saldo_awal` float NOT NULL,
  `saldo_akhir` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`idbarang`, `nama`, `kategori`, `satuan`, `merk`, `saldo_awal`, `saldo_akhir`) VALUES
('B00001', 'Baygon', 'sg', 'hg', 'jhgh', 0, 0),
('B00002', 'Adiw', 'asdasd', 'asd', 'asdasd', 1000, 10000);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `kode_customer` varchar(10) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `kode_kota` varchar(10) NOT NULL,
  `kode_wilayah` varchar(10) NOT NULL,
  `no_tlp` varchar(12) NOT NULL,
  `no_fax` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`kode_customer`, `nama`, `alamat`, `kode_kota`, `kode_wilayah`, `no_tlp`, `no_fax`) VALUES
('C00001', 'adiw', 'apa aja', '123', '123', '123', '123');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `kode_kategori` varchar(10) NOT NULL,
  `nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`kode_kategori`, `nama`) VALUES
('KT0001', 'sjkdfgj');

-- --------------------------------------------------------

--
-- Table structure for table `kota`
--

CREATE TABLE `kota` (
  `kode_kota` varchar(10) NOT NULL,
  `nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kota`
--

INSERT INTO `kota` (`kode_kota`, `nama`) VALUES
('K00001', 'iqwyue');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `kode_sales` varchar(10) NOT NULL,
  `nama_sales` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `kode_kota` varchar(10) NOT NULL,
  `no_tlp` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`kode_sales`, `nama_sales`, `alamat`, `kode_kota`, `no_tlp`) VALUES
('SA0001', 'asdsad', 'dfdsf', '123', '223123'),
('SA0002', 'hnkjhk', '23123', 'ksdjfjkd', 'jkdshfjkd'),
('SA0003', 'iewr', 'ejhfk', '123', 'sddsf');

-- --------------------------------------------------------

--
-- Table structure for table `supplier1`
--

CREATE TABLE `supplier1` (
  `kode_supplier` varchar(10) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(20) NOT NULL,
  `kode_kota` varchar(10) NOT NULL,
  `kode_wilayah` varchar(10) NOT NULL,
  `no_tlp` varchar(12) NOT NULL,
  `no_fax` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supplier1`
--

INSERT INTO `supplier1` (`kode_supplier`, `nama`, `alamat`, `kode_kota`, `kode_wilayah`, `no_tlp`, `no_fax`) VALUES
('S0001', 'enrico', 'mojosari', 'SM001', 'SMM001', '918273987', '91823791123');

-- --------------------------------------------------------

--
-- Table structure for table `userconfig`
--

CREATE TABLE `userconfig` (
  `id` varchar(7) NOT NULL,
  `email` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `akses` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userconfig`
--

INSERT INTO `userconfig` (`id`, `email`, `nama`, `akses`, `password`) VALUES
('L000001', 'admin@gmail.com', 'Admin', 'admin', '123'),
('L000002', 'adyw19@gmail.com', 'Adi Wijaya', 'Admin', '123'),
('L000003', 'contact@domain.com', 'Guest', 'Guest', '123');

-- --------------------------------------------------------

--
-- Table structure for table `wilayah`
--

CREATE TABLE `wilayah` (
  `kode_wilayah` varchar(10) NOT NULL,
  `nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wilayah`
--

INSERT INTO `wilayah` (`kode_wilayah`, `nama`) VALUES
('W00001', 'jawa timur');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`idbarang`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`kode_customer`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kode_kategori`);

--
-- Indexes for table `kota`
--
ALTER TABLE `kota`
  ADD PRIMARY KEY (`kode_kota`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`kode_sales`);

--
-- Indexes for table `supplier1`
--
ALTER TABLE `supplier1`
  ADD PRIMARY KEY (`kode_supplier`);

--
-- Indexes for table `userconfig`
--
ALTER TABLE `userconfig`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wilayah`
--
ALTER TABLE `wilayah`
  ADD PRIMARY KEY (`kode_wilayah`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
