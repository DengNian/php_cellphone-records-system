
--
-- Database: `MobilePhone` and php web application user
CREATE DATABASE IF NOT EXISTS MobilePhone;
GRANT USAGE ON *.* TO 'appuser'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON MobilePhone.* TO 'appuser'@'localhost';
FLUSH PRIVILEGES;

USE MobilePhone;
--
-- Table structure for table `MobilePhone`
--

CREATE TABLE IF NOT EXISTS `iphones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `releaseDate` date NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image`  varchar(300) NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `iphones`
--

INSERT INTO `iphones` (`id`, `name`, `releaseDate`,`price`,`image`) VALUES
(1, 'iPhone 13', '2021-09-24', '1099.00', 'iphone13.jpg'),
(2, 'iPhone 12', '2020-10-23', '979.99', 'iphone12.jpg'),
(3, 'iPhone 11', '2019-09-20', '529.00', 'iphone11.jpg');

