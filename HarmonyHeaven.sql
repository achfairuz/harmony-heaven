-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.44 - MySQL Community Server (GPL)
-- Server OS:                    Linux
-- HeidiSQL Version:             12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for restaurant
CREATE DATABASE IF NOT EXISTS `restaurant` /*!40100 DEFAULT CHARACTER SET armscii8 COLLATE armscii8_bin */;
USE `restaurant`;

-- Dumping structure for table restaurant.detail_pesanan
CREATE TABLE IF NOT EXISTS `detail_pesanan` (
  `id_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_pesanan` int(11) DEFAULT NULL,
  `id_menu` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_detail`),
  KEY `id_menu` (`id_menu`),
  KEY `id_pesanan` (`id_pesanan`),
  CONSTRAINT `FK__menu` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`),
  CONSTRAINT `FK__pesanan` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Dumping data for table restaurant.detail_pesanan: ~49 rows (approximately)
INSERT INTO `detail_pesanan` (`id_detail`, `id_pesanan`, `id_menu`, `jumlah`) VALUES
	(1, 33, 27, 1),
	(2, 33, 28, 1),
	(3, 33, 31, 2),
	(4, 33, 29, 10),
	(5, 34, 29, 5),
	(6, 35, 29, 100),
	(7, 36, 28, 1),
	(8, 36, 30, 1),
	(9, 37, 30, 1),
	(10, 37, 27, 1),
	(11, 38, 27, 1),
	(12, 38, 30, 1),
	(13, 39, 28, 1),
	(14, 39, 30, 1),
	(15, 40, 30, 1),
	(16, 41, 27, 5),
	(17, 41, 30, 1),
	(18, 42, 27, 5),
	(19, 42, 28, 1),
	(20, 42, 31, 1),
	(21, 43, 30, 1),
	(22, 43, 32, 1),
	(23, 44, 30, 1),
	(24, 45, 28, 1),
	(25, 45, 27, 1),
	(26, 46, 29, 1),
	(27, 46, 27, 10),
	(28, 46, 28, 1),
	(29, 47, 27, 1),
	(30, 47, 30, 1),
	(31, 47, 29, 1),
	(32, 48, 30, 1),
	(33, 48, 31, 1),
	(34, 48, 29, 10),
	(35, 49, 27, 1),
	(36, 49, 29, 10),
	(37, 50, 30, 4),
	(38, 50, 29, 1),
	(39, 51, 27, 1),
	(40, 52, 27, 1),
	(41, 53, 27, 1),
	(42, 54, 29, 2),
	(43, 55, 29, 1),
	(44, 55, 30, 1),
	(45, 55, 32, 1),
	(46, 56, 29, 1),
	(47, 57, 28, 10),
	(48, 57, 27, 1),
	(49, 58, 29, 1);

-- Dumping structure for table restaurant.keranjang
CREATE TABLE IF NOT EXISTS `keranjang` (
  `id_keranjang` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL DEFAULT '0',
  `id_menu` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_keranjang`),
  KEY `id_menu` (`id_menu`),
  KEY `username` (`id_user`),
  CONSTRAINT `FK_keranjang_menu` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`),
  CONSTRAINT `FK_keranjang_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Dumping data for table restaurant.keranjang: ~0 rows (approximately)

-- Dumping structure for table restaurant.meja
CREATE TABLE IF NOT EXISTS `meja` (
  `id_meja` int(11) NOT NULL AUTO_INCREMENT,
  `meja` char(50) COLLATE armscii8_bin NOT NULL,
  `link` varchar(50) COLLATE armscii8_bin DEFAULT NULL,
  PRIMARY KEY (`id_meja`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Dumping data for table restaurant.meja: ~6 rows (approximately)
INSERT INTO `meja` (`id_meja`, `meja`, `link`) VALUES
	(1, 'A1', 'http://localhost:8080/user/meja.php?id_meja=1'),
	(2, 'A2', 'http://harmonyheaven.test/user/meja.php?id_meja=2'),
	(3, 'A3', 'http://harmonyheaven.test/user/meja.php?id_meja=3'),
	(4, 'A4', 'http://harmonyheaven.test/user/meja.php?id_meja=4'),
	(5, 'A6', 'http://harmonyheaven.test/user/meja.php?id_meja=5'),
	(6, 'A7', 'http://harmonyheaven.test/user/meja.php?id_meja=6');

-- Dumping structure for table restaurant.menu
CREATE TABLE IF NOT EXISTS `menu` (
  `id_menu` int(11) NOT NULL AUTO_INCREMENT,
  `nama_menu` varchar(50) COLLATE armscii8_bin NOT NULL,
  `gambar` varchar(255) COLLATE armscii8_bin NOT NULL,
  `keterangan` text COLLATE armscii8_bin NOT NULL,
  `harga` decimal(20,1) NOT NULL DEFAULT '0.0',
  `kategori` varchar(50) COLLATE armscii8_bin DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Dumping data for table restaurant.menu: ~6 rows (approximately)
INSERT INTO `menu` (`id_menu`, `nama_menu`, `gambar`, `keterangan`, `harga`, `kategori`, `stok`) VALUES
	(27, 'Sandwich', '../img/uploads/2148633446 1.jpg', 'Sandwich dengan berbagai cerita', 45000.0, 'Europe', 99),
	(28, 'Nasi Goreng ', '../img/uploads/10-restoran-dengan-menu-nasi-goreng-yang-terkenal-enak-9.jpeg', 'Nasi Goreng Jakarta dengan campuran seafood', 47000.0, 'Asia', 98),
	(29, 'Monster Burger ', '../img/uploads/popular1.jpg', 'Burger dengan lapisan daging 3x lipat ', 50000.0, 'Europe', 100),
	(30, 'Neopolitan Pizza Mania', '../img/uploads/popular2.jpg', 'Pizza dengan taburan keju dan daging yang banyak.', 225000.0, 'Europe', 98),
	(31, 'Muka singgi', '../img/uploads/image 3.jpg', 'Singgi yang terpercaya', 1.0, 'Africa', 499),
	(32, 'Steak ', '../img/uploads/popular3.jpg', 'Steak babi dengan cita rasa yang indah', 125000.0, 'Australia', 499);

-- Dumping structure for table restaurant.pembayaran
CREATE TABLE IF NOT EXISTS `pembayaran` (
  `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `tanggal` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `metode_pembayaran` varchar(50) COLLATE armscii8_bin DEFAULT NULL,
  `uang_terima` bigint(20) DEFAULT '0',
  `uang_kembali` bigint(20) DEFAULT '0',
  `total_pembayaran` bigint(20) DEFAULT '0',
  `bukti_pembayaran` varchar(50) COLLATE armscii8_bin DEFAULT NULL,
  `status_pembayaran` enum('Lunas','Pending','Gagal') COLLATE armscii8_bin DEFAULT 'Pending',
  PRIMARY KEY (`id_pembayaran`),
  KEY `id_pesanan` (`id_pesanan`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `FK_pembayaran_pesanan` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`),
  CONSTRAINT `FK_pembayaran_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Dumping data for table restaurant.pembayaran: ~4 rows (approximately)
INSERT INTO `pembayaran` (`id_pembayaran`, `id_user`, `id_pesanan`, `tanggal`, `metode_pembayaran`, `uang_terima`, `uang_kembali`, `total_pembayaran`, `bukti_pembayaran`, `status_pembayaran`) VALUES
	(1, 6, 54, '2024-11-04 14:53:27', 'Kasir', 600000, 500000, 100000, NULL, 'Lunas'),
	(2, 6, 55, '2024-11-05 07:59:31', 'bankTransfer', 50000, 0, 50000, '../img/pembayaran/F.png', 'Gagal'),
	(3, 6, 56, '2024-11-05 08:00:05', 'Kasir', 100000, 50000, 50000, NULL, 'Lunas'),
	(4, 6, 58, '2024-11-05 13:19:01', 'bankTransfer', 50000, 0, 50000, '../img/pembayaran/Frame 1.jpg', 'Pending');

-- Dumping structure for table restaurant.pesanan
CREATE TABLE IF NOT EXISTS `pesanan` (
  `id_pesanan` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_meja` int(11) DEFAULT NULL,
  `tanggal_pesanan` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `total_harga` bigint(20) DEFAULT NULL,
  `status_pesanan` enum('Proses','Sukses','Dibatalkan') COLLATE armscii8_bin DEFAULT 'Proses',
  `jenis_pesanan` enum('Dine In','Takeaway') COLLATE armscii8_bin DEFAULT 'Dine In',
  PRIMARY KEY (`id_pesanan`),
  KEY `id_user` (`id_user`),
  KEY `id_meja` (`id_meja`),
  CONSTRAINT `FK_pesanan_meja` FOREIGN KEY (`id_meja`) REFERENCES `meja` (`id_meja`) ON DELETE SET NULL,
  CONSTRAINT `FK_pesanan_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Dumping data for table restaurant.pesanan: ~5 rows (approximately)
INSERT INTO `pesanan` (`id_pesanan`, `id_user`, `id_meja`, `tanggal_pesanan`, `total_harga`, `status_pesanan`, `jenis_pesanan`) VALUES
	(53, 6, NULL, '2024-11-04 14:48:45', 45000, 'Proses', 'Takeaway'),
	(54, 6, 1, '2024-11-04 14:52:41', 100000, 'Sukses', 'Dine In'),
	(55, 6, 1, '2024-11-05 07:59:28', 400000, 'Dibatalkan', 'Dine In'),
	(56, 6, 1, '2024-11-05 08:00:02', 50000, 'Sukses', 'Dine In'),
	(57, 6, NULL, '2024-11-05 08:08:04', 515000, 'Proses', 'Takeaway'),
	(58, 6, 1, '2024-11-05 13:18:57', 50000, 'Proses', 'Dine In');

-- Dumping structure for table restaurant.user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE armscii8_bin NOT NULL,
  `name` varchar(50) COLLATE armscii8_bin NOT NULL,
  `address` varchar(50) COLLATE armscii8_bin DEFAULT NULL,
  `phonenumber` varchar(50) COLLATE armscii8_bin DEFAULT NULL,
  `pass` varchar(255) COLLATE armscii8_bin NOT NULL,
  `role` varchar(50) COLLATE armscii8_bin DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Dumping data for table restaurant.user: ~10 rows (approximately)
INSERT INTO `user` (`id_user`, `username`, `name`, `address`, `phonenumber`, `pass`, `role`) VALUES
	(1, '_ach.fairuz', 'Achmad Fairuz', 'Pasuruan', '085161853202', 'voctory123', NULL),
	(2, 'admin1', 'admin1', NULL, NULL, 'admin', 'admin'),
	(3, 'yasril_123', 'yasril adiem al amin', 'sidoarjo', '055153156131', 'yasril123', NULL),
	(4, 'singgi123', 'Singgi', 'Pasuruan Jawa Timur', '0851412456123', 'singgi123', NULL),
	(6, 'fairuz', 'fairuz', 'Sembarang wes', '088554356', '1', NULL),
	(7, 'hilmi123', 'hilmi', 'JL. malang', '08516531545454', 'hilmi123', NULL),
	(8, 'qolbi', 'Qolbi', 'kediri', 'koakwoka', '1', NULL),
	(9, 'q', 'i', 'q', 'qq', '1', NULL),
	(10, 'nabila', 'nabila', 'aa', 'a', 'a', NULL),
	(11, 'a', 'a', 'a', 'a', 'a', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
