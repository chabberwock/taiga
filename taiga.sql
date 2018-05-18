/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE IF NOT EXISTS `taiga` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `taiga`;

CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `patronymic` varchar(50) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `gender` tinyint(4) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `client` DISABLE KEYS */;
INSERT INTO `client` (`id`, `first_name`, `last_name`, `patronymic`, `birthdate`, `gender`, `created_at`, `updated_at`) VALUES
	(0, 'Александр', 'Макаров', 'Олегович', NULL, 1, '0000-00-00 00:00:00', '2018-05-18 07:34:13'),
	(1, 'Сергей', 'Иванов', 'Андреевич', NULL, 1, '2018-05-18 01:19:17', '2018-05-18 01:19:17'),
	(2, 'Артемий', 'Лебедев', 'Татьянович', NULL, 1, '2018-05-18 01:21:29', '2018-05-18 01:21:29'),
	(3, 'Владимир', 'Скворцов', 'Владимирович', NULL, 1, '2018-05-18 01:23:19', '2018-05-18 01:23:19'),
	(4, 'Ирина', 'Андреева', 'Ивановна', NULL, 2, '2018-05-18 01:23:44', '2018-05-18 01:23:44'),
	(5, 'Татьяна', 'Ларина', NULL, '2018-05-18', 2, '2018-05-18 01:25:16', '2018-05-18 01:25:16'),
	(23, 'Олег', 'Преведов', 'Олегович', '1990-05-05', 1, '0000-00-00 00:00:00', '2018-05-18 06:38:10'),
	(24, 'Павел', 'Ivanov', NULL, '1982-01-01', 1, '2018-05-18 06:17:04', '2018-05-18 06:17:04'),
	(25, 'Леонид', 'Макаров', NULL, '1982-01-02', 1, '2018-05-18 06:25:38', '2018-05-18 06:25:38'),
	(26, 'Иван', 'Макаров', NULL, '1980-01-05', 2, '0000-00-00 00:00:00', '2018-05-18 06:36:48');
/*!40000 ALTER TABLE `client` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `client_id` (
  `value` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`value`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `client_id` DISABLE KEYS */;
INSERT INTO `client_id` (`value`) VALUES
	(1),
	(2),
	(3),
	(4),
	(5),
	(6),
	(7),
	(8),
	(9),
	(10),
	(11),
	(12),
	(13),
	(14),
	(15),
	(16),
	(17),
	(18),
	(19),
	(20),
	(21),
	(22),
	(23),
	(24),
	(25),
	(26),
	(27),
	(28);
/*!40000 ALTER TABLE `client_id` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `phone` (
  `client_id` int(11) NOT NULL,
  `value` varchar(50) NOT NULL,
  PRIMARY KEY (`client_id`,`value`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `phone` DISABLE KEYS */;
INSERT INTO `phone` (`client_id`, `value`) VALUES
	(0, '79615054607'),
	(23, '7884438498'),
	(24, '87987987987'),
	(25, '123'),
	(25, '456'),
	(26, '999999');
/*!40000 ALTER TABLE `phone` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
