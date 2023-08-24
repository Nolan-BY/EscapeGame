-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           10.10.2-MariaDB - mariadb.org binary distribution
-- SE du serveur:                Win64
-- HeidiSQL Version:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour escape_game_DB
CREATE DATABASE IF NOT EXISTS `escape_game_DB` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci */;
USE `escape_game_DB`;

-- Listage de la structure de la table escape_game_DB.gamecontrol
CREATE TABLE IF NOT EXISTS `gamecontrol` (
  `team_name` text DEFAULT NULL,
  `penalties` int(11) DEFAULT NULL,
  `hints` int(11) DEFAULT NULL,
  `finishdate` text DEFAULT NULL,
  `enddate` text DEFAULT NULL,
  `result` text DEFAULT NULL,
  `score` int(20) DEFAULT NULL,
  `result_enigmas` int(20) DEFAULT NULL,
  `final_code` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Listage des données de la table escape_game_DB.gamecontrol : ~1 rows (environ)
/*!40000 ALTER TABLE `gamecontrol` DISABLE KEYS */;
REPLACE INTO `gamecontrol` (`team_name`, `penalties`, `hints`, `finishdate`, `enddate`, `result`, `score`, `result_enigmas`, `final_code`) VALUES
	('none', 0, 6, 'none', 'none', 'none', 0, 0, 30035);
/*!40000 ALTER TABLE `gamecontrol` ENABLE KEYS */;

-- Listage de la structure de la table escape_game_DB.users
CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Listage des données de la table escape_game_DB.users : ~2 rows (environ)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
REPLACE INTO `users` (`username`, `password`) VALUES
	('iutchercheurs', 'no_earthquake');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
