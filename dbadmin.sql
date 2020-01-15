-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2020 at 03:35 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.1.32

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
  `idbarang` varchar(10) CHARACTER SET utf8mb4 NOT NULL,
  `nama` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `kategori` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `satuan` varchar(10) NOT NULL,
  `merk` varchar(50) NOT NULL,
  `saldo_awal` float NOT NULL,
  `saldo_akhir` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`idbarang`, `nama`, `kategori`, `satuan`, `merk`, `saldo_awal`, `saldo_akhir`) VALUES
('B00001', 'Kursi', 'KT0001', 'pcs', 'merk 1', 1000, 2000),
('B00002', 'Meja Plastik', 'KT0004', 'pcs', 'merk 2', 2000, 2000),
('B00003', 'Sapu Plastik', 'KT0002', 'pcs', 'merk 1', 1300, 1300);

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
('C00001', 'Adi', 'semampir', 'K00001', 'W00003', '123', '123123'),
('C00002', 'Noel', 'Semampir 2', 'K00001', 'W00003', '2234', '234234');

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
('KT0001', 'Kategori 1'),
('KT0002', 'Kategori 2'),
('KT0003', 'Kategori 3'),
('KT0004', 'Kategori 4');

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
('K00001', 'Surabaya'),
('K00002', 'Mojokerto');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `idpb` varchar(10) NOT NULL,
  `tanggal` date NOT NULL,
  `kota` varchar(50) NOT NULL,
  `wilayah` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `keterangan` text NOT NULL,
  `subtotal` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`idpb`, `tanggal`, `kota`, `wilayah`, `alamat`, `keterangan`, `subtotal`) VALUES
('M00001', '2019-12-03', 'K00001', 'W00001', 'aw', '', 0),
('M00002', '2019-12-20', 'K00001', 'W00001', 'aw', 'apa aja', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_detail`
--

CREATE TABLE `pembelian_detail` (
  `idpb_detail` varchar(10) NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `harga` float NOT NULL,
  `jumlah` float NOT NULL,
  `idpb` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembelian_detail`
--

INSERT INTO `pembelian_detail` (`idpb_detail`, `kode_barang`, `harga`, `jumlah`, `idpb`) VALUES
('D000001', 'B00001', 1000, 12, 'M00001'),
('D000002', 'B00001', 1000, 1, 'M00002');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `idpj` varchar(10) NOT NULL,
  `tanggal` date NOT NULL,
  `sales` varchar(50) NOT NULL,
  `customer` varchar(50) NOT NULL,
  `kota` varchar(50) NOT NULL,
  `wilayah` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `subtotal` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`idpj`, `tanggal`, `sales`, `customer`, `kota`, `wilayah`, `alamat`, `subtotal`) VALUES
('U00001', '2019-12-04', 'SA0001', 'C00001', 'K00001', 'W00001', 'aw', 2000),
('U00002', '2019-12-17', 'SA0001', 'C00001', 'K00001', 'W00001', 'awaw', 3000);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_detail`
--

CREATE TABLE `penjualan_detail` (
  `idpj_detail` varchar(10) NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `harga` float NOT NULL,
  `jumlah` float NOT NULL,
  `idpj` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penjualan_detail`
--

INSERT INTO `penjualan_detail` (`idpj_detail`, `kode_barang`, `harga`, `jumlah`, `idpj`) VALUES
('D000001', 'B00001', 1000, 2, 'U00001'),
('D000002', 'B00001', 1000, 3, 'U00002');

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
('SA0001', 'asd', 'asdasd', 'K00002', 'asd'),
('SA0002', 'qwe', 'qwe', 'K00001', '123');

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
('W00001', 'Jawa Barat'),
('W00002', 'Jawa Tengah'),
('W00003', 'Jawa Timur');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`idbarang`),
  ADD KEY `FK_kode_kategori_kategori` (`kategori`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`kode_customer`),
  ADD KEY `FK_kode_kota_kota` (`kode_kota`),
  ADD KEY `FK_kode_wilayah_wilayah` (`kode_wilayah`);

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
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`idpb`),
  ADD KEY `FK_kode_kotapb_kota` (`kota`),
  ADD KEY `FK_kode_kotapb_wilayah` (`wilayah`);

--
-- Indexes for table `pembelian_detail`
--
ALTER TABLE `pembelian_detail`
  ADD PRIMARY KEY (`idpb_detail`),
  ADD KEY `FK_idpb_pembelian` (`idpb`),
  ADD KEY `FK_kode_barang_barang` (`kode_barang`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`idpj`),
  ADD KEY `FK_kode_kotapj_kota` (`kota`),
  ADD KEY `FK_kode_kotapj_wilayah` (`wilayah`),
  ADD KEY `FK_kode_customerpj_customer` (`customer`),
  ADD KEY `FK_kode_salespj_sales` (`sales`);

--
-- Indexes for table `penjualan_detail`
--
ALTER TABLE `penjualan_detail`
  ADD PRIMARY KEY (`idpj_detail`),
  ADD KEY `FK_kode_barang2_barang` (`kode_barang`),
  ADD KEY `FK_idpj_penjualan` (`idpj`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`kode_sales`),
  ADD KEY `FK_kode_kota2_kota` (`kode_kota`);

--
-- Indexes for table `supplier1`
--
ALTER TABLE `supplier1`
  ADD PRIMARY KEY (`kode_supplier`),
  ADD KEY `FK_kode_kota3_kota` (`kode_kota`),
  ADD KEY `FK_kode_wilayah2_wilayah` (`kode_wilayah`);

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

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `FK_kategori_kat` FOREIGN KEY (`kategori`) REFERENCES `kategori` (`kode_kategori`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `FK_kode_kota_kota` FOREIGN KEY (`kode_kota`) REFERENCES `kota` (`kode_kota`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_kode_wilayah_wilayah` FOREIGN KEY (`kode_wilayah`) REFERENCES `wilayah` (`kode_wilayah`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD CONSTRAINT `FK_kode_kotapb_kota` FOREIGN KEY (`kota`) REFERENCES `kota` (`kode_kota`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_kode_kotapb_wilayah` FOREIGN KEY (`wilayah`) REFERENCES `wilayah` (`kode_wilayah`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pembelian_detail`
--
ALTER TABLE `pembelian_detail`
  ADD CONSTRAINT `FK_idpb_pembelian` FOREIGN KEY (`idpb`) REFERENCES `pembelian` (`idpb`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_kode_barang_barang` FOREIGN KEY (`kode_barang`) REFERENCES `barang` (`idbarang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `FK_kode_customerpj_customer` FOREIGN KEY (`customer`) REFERENCES `customer` (`kode_customer`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_kode_kotapj_kota` FOREIGN KEY (`kota`) REFERENCES `kota` (`kode_kota`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_kode_kotapj_wilayah` FOREIGN KEY (`wilayah`) REFERENCES `wilayah` (`kode_wilayah`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_kode_salespj_sales` FOREIGN KEY (`sales`) REFERENCES `sales` (`kode_sales`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `penjualan_detail`
--
ALTER TABLE `penjualan_detail`
  ADD CONSTRAINT `FK_idpj_penjualan` FOREIGN KEY (`idpj`) REFERENCES `penjualan` (`idpj`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_kode_barang2_barang` FOREIGN KEY (`kode_barang`) REFERENCES `barang` (`idbarang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `FK_kode_kota2_kota` FOREIGN KEY (`kode_kota`) REFERENCES `kota` (`kode_kota`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `supplier1`
--
ALTER TABLE `supplier1`
  ADD CONSTRAINT `FK_kode_kota3_kota` FOREIGN KEY (`kode_kota`) REFERENCES `kota` (`kode_kota`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_kode_wilayah2_wilayah` FOREIGN KEY (`kode_wilayah`) REFERENCES `wilayah` (`kode_wilayah`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
