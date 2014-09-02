-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 29, 2014 at 03:22 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE DATABASE content;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


-- Admin initialisation

CREATE USER 'admin'@'localhost' IDENTIFIED BY 'password'; -- change this!
GRANT ALL PRIVILEGES ON * . * TO 'admin'@'localhost';
CREATE USER 'viewer'@'localhost' IDENTIFIED BY 'pass'; -- change this!
GRANT SELECT ON * . * TO 'viewer'@'localhost';
FLUSH PRIVILEGES;


--
-- Database: `content`
--

-- --------------------------------------------------------

--
-- Table structure for table `file`
--

CREATE TABLE IF NOT EXISTS `file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `filename` char(128) NOT NULL,
  `extension` varchar(5) NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `subject` varchar(20) DEFAULT NULL,
  `level` varchar(20) DEFAULT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `file_uploaded_by` (`uploaded_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

--
-- Dumping data for table `file`
--


-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `file_id` int(11) NOT NULL,
  `tag` varchar(30) NOT NULL,
  PRIMARY KEY (`file_id`,`tag`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tags`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` char(128) NOT NULL,
  `email` varchar(50) NOT NULL,
  `salt` char(128) NOT NULL,
  CHECK (`account_type` in ('admin', 'teacher'),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--


--
-- Constraints for dumped tables
--

--
-- Constraints for table `file`
--
ALTER TABLE `file`
  ADD CONSTRAINT `file_uploaded_by` FOREIGN KEY (`uploaded_by`) REFERENCES `user` (`id`);

--
-- Constraints for table `tags`
--
ALTER TABLE `tags`
  ADD CONSTRAINT `tags_ibfk_1` FOREIGN KEY (`file_id`) REFERENCES `file` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
