-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for ci_barang
CREATE DATABASE IF NOT EXISTS `ci_barang` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `ci_barang`;

-- Dumping structure for table ci_barang.barang
CREATE TABLE IF NOT EXISTS `barang` (
  `id_barang` char(7) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `stok` int(11) NOT NULL,
  `satuan_id` int(11) NOT NULL,
  `jenis_id` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  PRIMARY KEY (`id_barang`) USING BTREE,
  KEY `satuan_id` (`satuan_id`) USING BTREE,
  KEY `kategori_id` (`jenis_id`) USING BTREE,
  CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`satuan_id`) REFERENCES `satuan` (`id_satuan`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `barang_ibfk_2` FOREIGN KEY (`jenis_id`) REFERENCES `jenis` (`id_jenis`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table ci_barang.barang: ~6 rows (approximately)
/*!40000 ALTER TABLE `barang` DISABLE KEYS */;
INSERT INTO `barang` (`id_barang`, `nama_barang`, `stok`, `satuan_id`, `jenis_id`, `harga`) VALUES
	('B000000', 'Botol 400ml', 70, 5, 9, 1000),
	('B000001', 'Botol 1000ml', 0, 5, 9, 2500),
	('B000002', 'Tupperware', 25, 3, 9, 50000),
	('B000003', 'Face Wash', 75, 2, 8, 6800),
	('B000004', 'Jam Tangan', 50, 5, 8, 500000),
	('B000005', 'kutilang', 0, 6, 10, 100000);
/*!40000 ALTER TABLE `barang` ENABLE KEYS */;

-- Dumping structure for table ci_barang.barang_masuk
CREATE TABLE IF NOT EXISTS `barang_masuk` (
  `id_barang_masuk` char(16) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `barang_id` char(7) NOT NULL,
  `jumlah_masuk` int(11) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  PRIMARY KEY (`id_barang_masuk`) USING BTREE,
  KEY `id_user` (`user_id`) USING BTREE,
  KEY `supplier_id` (`supplier_id`) USING BTREE,
  KEY `barang_id` (`barang_id`) USING BTREE,
  CONSTRAINT `barang_masuk_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `barang_masuk_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id_supplier`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `barang_masuk_ibfk_3` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table ci_barang.barang_masuk: ~2 rows (approximately)
/*!40000 ALTER TABLE `barang_masuk` DISABLE KEYS */;
INSERT INTO `barang_masuk` (`id_barang_masuk`, `supplier_id`, `user_id`, `barang_id`, `jumlah_masuk`, `tanggal_masuk`) VALUES
	('T-BM-23062700001', 4, 14, 'B000000', 21, '2023-06-27'),
	('T-BM-23062700002', 4, 14, 'B000002', 10, '2023-06-27');
/*!40000 ALTER TABLE `barang_masuk` ENABLE KEYS */;

-- Dumping structure for table ci_barang.barang_penjualan
CREATE TABLE IF NOT EXISTS `barang_penjualan` (
  `id_barang_penjualan` char(16) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pelanggan_id` int(11) NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `diskon` double(11,0) DEFAULT '0',
  `total_nominal` int(11) NOT NULL,
  `grand_total` int(11) NOT NULL,
  PRIMARY KEY (`id_barang_penjualan`) USING BTREE,
  KEY `id_user` (`user_id`) USING BTREE,
  KEY `FK_barang_penjualan_pelanggan` (`pelanggan_id`),
  CONSTRAINT `FK_barang_penjualan_pelanggan` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `barang_penjualan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table ci_barang.barang_penjualan: ~2 rows (approximately)
/*!40000 ALTER TABLE `barang_penjualan` DISABLE KEYS */;
INSERT INTO `barang_penjualan` (`id_barang_penjualan`, `user_id`, `pelanggan_id`, `tanggal_keluar`, `diskon`, `total_nominal`, `grand_total`) VALUES
	('T-BK-23062700001', 1, 5, '2023-06-27', 500, 1000, 500),
	('T-BK-23062700002', 1, 1, '2023-06-27', 50000, 1250000, 1200000);
/*!40000 ALTER TABLE `barang_penjualan` ENABLE KEYS */;

-- Dumping structure for table ci_barang.barang_penjualan_dtl
CREATE TABLE IF NOT EXISTS `barang_penjualan_dtl` (
  `id_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_barang_penjualan` char(16) NOT NULL,
  `barang_id` char(7) NOT NULL,
  `harga` int(11) NOT NULL,
  `jumlah_keluar` int(1) NOT NULL,
  `total_nominal_dtl` int(1) NOT NULL,
  PRIMARY KEY (`id_detail`) USING BTREE,
  KEY `barang_keluar_dtl_ibfk_1` (`id_barang_penjualan`) USING BTREE,
  CONSTRAINT `barang_penjualan_dtl_ibfk_1` FOREIGN KEY (`id_barang_penjualan`) REFERENCES `barang_penjualan` (`id_barang_penjualan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table ci_barang.barang_penjualan_dtl: ~2 rows (approximately)
/*!40000 ALTER TABLE `barang_penjualan_dtl` DISABLE KEYS */;
INSERT INTO `barang_penjualan_dtl` (`id_detail`, `id_barang_penjualan`, `barang_id`, `harga`, `jumlah_keluar`, `total_nominal_dtl`) VALUES
	(17, 'T-BK-23062700001', 'B000000', 1000, 1, 1000),
	(18, 'T-BK-23062700002', 'B000002', 50000, 25, 1250000);
/*!40000 ALTER TABLE `barang_penjualan_dtl` ENABLE KEYS */;

-- Dumping structure for table ci_barang.jenis
CREATE TABLE IF NOT EXISTS `jenis` (
  `id_jenis` int(11) NOT NULL AUTO_INCREMENT,
  `nama_jenis` varchar(20) NOT NULL,
  PRIMARY KEY (`id_jenis`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table ci_barang.jenis: ~3 rows (approximately)
/*!40000 ALTER TABLE `jenis` DISABLE KEYS */;
INSERT INTO `jenis` (`id_jenis`, `nama_jenis`) VALUES
	(8, 'Plastik'),
	(9, 'Botol'),
	(10, 'headset');
/*!40000 ALTER TABLE `jenis` ENABLE KEYS */;

-- Dumping structure for table ci_barang.pelanggan
CREATE TABLE IF NOT EXISTS `pelanggan` (
  `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT,
  `nama_pelanggan` varchar(50) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `alamat` text NOT NULL,
  PRIMARY KEY (`id_pelanggan`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table ci_barang.pelanggan: ~3 rows (approximately)
/*!40000 ALTER TABLE `pelanggan` DISABLE KEYS */;
INSERT INTO `pelanggan` (`id_pelanggan`, `nama_pelanggan`, `no_telp`, `alamat`) VALUES
	(1, 'juned', '081617473709', 'bojonegoro'),
	(5, 'ekik', '83215235141', 'mojokerto'),
	(6, 'fitra', '09812351235123', 'bjn');
/*!40000 ALTER TABLE `pelanggan` ENABLE KEYS */;

-- Dumping structure for table ci_barang.pengaturan
CREATE TABLE IF NOT EXISTS `pengaturan` (
  `id_pengaturan` int(11) NOT NULL AUTO_INCREMENT,
  `nama_toko` varchar(50) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  PRIMARY KEY (`id_pengaturan`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table ci_barang.pengaturan: ~1 rows (approximately)
/*!40000 ALTER TABLE `pengaturan` DISABLE KEYS */;
INSERT INTO `pengaturan` (`id_pengaturan`, `nama_toko`, `alamat`) VALUES
	(1, 'Toko Abal-Abal', 'Malang Kota');
/*!40000 ALTER TABLE `pengaturan` ENABLE KEYS */;

-- Dumping structure for table ci_barang.satuan
CREATE TABLE IF NOT EXISTS `satuan` (
  `id_satuan` int(11) NOT NULL AUTO_INCREMENT,
  `nama_satuan` varchar(15) NOT NULL,
  PRIMARY KEY (`id_satuan`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table ci_barang.satuan: ~4 rows (approximately)
/*!40000 ALTER TABLE `satuan` DISABLE KEYS */;
INSERT INTO `satuan` (`id_satuan`, `nama_satuan`) VALUES
	(2, 'Pack'),
	(3, 'Botol'),
	(5, 'Unit'),
	(6, 'pcs');
/*!40000 ALTER TABLE `satuan` ENABLE KEYS */;

-- Dumping structure for table ci_barang.supplier
CREATE TABLE IF NOT EXISTS `supplier` (
  `id_supplier` int(11) NOT NULL AUTO_INCREMENT,
  `nama_supplier` varchar(50) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `alamat` text NOT NULL,
  PRIMARY KEY (`id_supplier`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table ci_barang.supplier: ~2 rows (approximately)
/*!40000 ALTER TABLE `supplier` DISABLE KEYS */;
INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `no_telp`, `alamat`) VALUES
	(4, 'Dimas Botol', '0891234567', 'Kabupaten Garut'),
	(5, 'joko', '0908879879', 'bandulan');
/*!40000 ALTER TABLE `supplier` ENABLE KEYS */;

-- Dumping structure for table ci_barang.user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `role` enum('pemilik','admin','kasir') NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` int(11) NOT NULL,
  `foto` text NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_user`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table ci_barang.user: ~6 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id_user`, `nama`, `username`, `email`, `no_telp`, `role`, `password`, `created_at`, `foto`, `is_active`) VALUES
	(1, 'Adminisitrator', 'admin', 'admin@admin.com', '025123456789', 'admin', '$2y$10$wMgi9s3FEDEPEU6dEmbp8eAAEBUXIXUy3np3ND2Oih.MOY.q/Kpoy', 1568689561, 'd5f22535b639d55be7d099a7315e1f7f.png', 1),
	(7, 'Arfan', 'arfandotid', 'arfandotid@gmail.com', '081221528805', 'pemilik', '$2y$10$5es8WhFQj8xCmrhDtH86Fu71j97og9f8aR4T22soa7716kAusmaeK', 1568691611, 'user.png', 1),
	(8, 'Muhammad Ghifari Arfananda', 'mghifariarfan', 'mghifariarfan@gmail.com', '085697442673', 'pemilik', '$2y$10$5SGUIbRyEXH7JslhtEegEOpp6cvxtK6X.qdiQ1eZR7nd0RZjjx3qe', 1568691629, 'user.png', 1),
	(13, 'Arfan Kashilukato', 'arfankashilukato', 'arfankashilukato@gmail.com', '081623123181', 'pemilik', '$2y$10$/QpTunAD9alBV5NSRJ7ytupS2ibUrbmS3ia3u5B26H6f3mCjOD92W', 1569192547, 'user.png', 1),
	(14, 'wahyu', 'wahyu', 'wahyufitrahc@gmail.com', '081612345678', 'pemilik', '$2y$10$0LTQzqmfAZ8QNVzJzjah5uHBZZlZ/4O23RGem17My/iN7pJriqbt6', 1687820066, 'user.png', 1),
	(16, 'juned', 'junblok', 'juned@gmail.com', '921441023151', 'kasir', '$2y$10$7ZrqaEcfncHqDSX9Lpd8ju/W13RYySZHFtDN7/pV/YaxHGT8W2Q1a', 1687878389, '', 1);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

-- Dumping structure for trigger ci_barang.delete_stok_keluar
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `delete_stok_keluar` AFTER DELETE ON `barang_penjualan_dtl` FOR EACH ROW UPDATE `barang` SET `barang`.`stok` = `barang`.`stok` + OLD.jumlah_keluar WHERE `barang`.`id_barang` = OLD.barang_id//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger ci_barang.update_stok_keluar
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `update_stok_keluar` BEFORE INSERT ON `barang_penjualan_dtl` FOR EACH ROW UPDATE `barang` SET `barang`.`stok` = `barang`.`stok` - NEW.jumlah_keluar WHERE `barang`.`id_barang` = NEW.barang_id//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger ci_barang.update_stok_masuk
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `update_stok_masuk` BEFORE INSERT ON `barang_masuk` FOR EACH ROW UPDATE `barang` SET `barang`.`stok` = `barang`.`stok` + NEW.jumlah_masuk WHERE `barang`.`id_barang` = NEW.barang_id//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
