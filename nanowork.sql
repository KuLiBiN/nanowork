

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `nanowork`
--

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `author` int(5) unsigned NOT NULL,
  `performer` int(5) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `money_author` decimal(9,2) unsigned NOT NULL DEFAULT '0.00',
  `money_system` decimal(9,2) unsigned NOT NULL DEFAULT '0.00',
  `money_performer` decimal(9,2) unsigned NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `author` (`author`),
  KEY `performer` (`performer`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `author`, `performer`, `title`, `description`, `money_author`, `money_system`, `money_performer`) VALUES
(24, 1, 3, 'задача на 20', 'ывпрваповаоапр', 20.00, 2.00, 18.00),
(25, 1, 4, 'на 100 руб', 'ывервпаопаолрпо', 100.00, 10.00, 90.00),
(27, 1, 3, '90', 'tertbetrevtry', 90.00, 9.00, 81.00),
(29, 1, 3, '70', 'fdgsdfgsdfg', 70.00, 7.00, 63.00),
(30, 2, 4, 'Задача на 300 руб', 'описание', 300.00, 30.00, 270.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `money` decimal(7,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `type`, `name`, `money`) VALUES
(1, 1, 'Андрей Петров', 1100.00),
(2, 1, 'Екатерина Семенова', 4000.00),
(3, 2, 'Игорь Васильев', 189.00),
(4, 2, 'Виктория Гришина', 369.00);
