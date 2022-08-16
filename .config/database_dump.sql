# ************************************************************
# Sequel Pro SQL dump
# Version 5446
#
# https://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.26)
# Database: pae_init
# Generation Time: 2022-08-16 17:17:50 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table Actos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Actos`;

CREATE TABLE `Actos` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Folio` int(255) DEFAULT NULL,
  `Caso` int(255) DEFAULT NULL,
  `TipoActo` text COLLATE utf8mb4_spanish_ci,
  `FechaActoIni` datetime DEFAULT NULL,
  `ExactitudFechaActoIni` text COLLATE utf8mb4_spanish_ci,
  `DetalleFechaActoIni` text COLLATE utf8mb4_spanish_ci,
  `FechaActoFin` datetime DEFAULT NULL,
  `ExactitudFechaActoFin` text COLLATE utf8mb4_spanish_ci,
  `DetalleFechaActoFin` text COLLATE utf8mb4_spanish_ci,
  `Data` mediumtext COLLATE utf8mb4_spanish_ci,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
