
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `geostations_san_francisco`
--
CREATE DATABASE IF NOT EXISTS `geostations_san_francisco` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `geostations_san_francisco`;

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE IF NOT EXISTS `routes` (
  `number` int(3) NOT NULL,
  `color` varchar(12) NOT NULL,
  `name` varchar(50) NOT NULL,
  `abbr` varchar(12) NOT NULL,
  PRIMARY KEY (`number`),
  UNIQUE KEY `abbr` (`abbr`),
  UNIQUE KEY `number` (`number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`number`, `color`, `name`, `abbr`) VALUES
(1, '#ffff33', 'Pittsburg/Bay Point - SFIA/Millbrae', 'PITT-SFIA'),
(2, '#ffff33', 'Millbrae/SFIA - Pittsburg/Bay Point', 'SFIA-PITT'),
(3, '#ff9933', 'Fremont - Richmond', 'FRMT-RICH'),
(4, '#ff9933', 'Richmond - Fremont', 'RICH-FRMT'),
(5, '#339933', 'Fremont - Daly City', 'FRMT-DALY'),
(6, '#339933', 'Daly City - Fremont', 'DALY-FRMT'),
(7, '#ff0000', 'Richmond - Daly City/Millbrae', 'RICH-MLBR'),
(8, '#ff0000', 'Millbrae/Daly City - Richmond', 'MLBR-RICH'),
(11, '#0099cc', 'Dublin/Pleasanton - Daly City', 'DUBL-DALY'),
(12, '#0099cc', 'Daly City - Dublin/Pleasanton', 'DALY-DUBL');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
