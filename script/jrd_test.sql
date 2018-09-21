-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 21, 2018 at 08:49 AM
-- Server version: 5.7.21
-- PHP Version: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jrd_test`
--
USE `mysql`;
DROP DATABASE IF EXISTS `rajeeb`;
CREATE DATABASE `rajeeb`;

USE `rajeeb`;
-- --------------------------------------------------------

--
-- Table structure for table `jrd_class`
--

DROP TABLE IF EXISTS `jrd_class`;
CREATE TABLE IF NOT EXISTS `jrd_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jrd_class`
--

INSERT INTO `jrd_class` (`id`, `class_name`) VALUES
(1, '1st'),
(2, '2nd'),
(3, '3rd'),
(4, '4th'),
(5, '5th'),
(6, '6th'),
(7, '7th'),
(8, '8th');

-- --------------------------------------------------------

--
-- Table structure for table `jrd_student`
--

DROP TABLE IF EXISTS `jrd_student`;
CREATE TABLE IF NOT EXISTS `jrd_student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `email` varchar(225) NOT NULL,
  `jrd_class_id` int(11) NOT NULL,
  `guardian_name` varchar(100) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `year_joined` year(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `first_name` (`first_name`)
) ENGINE=MyISAM AUTO_INCREMENT=1017 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jrd_student`
--

INSERT INTO `jrd_student` (`id`, `first_name`, `last_name`, `dob`, `email`, `jrd_class_id`, `guardian_name`, `phone`, `date_added`, `date_updated`, `year_joined`) VALUES
(1000, 'Aju', 'John', '2017-11-05', 'sdsd@sdsd.sdsd', 4, 'Adsdfsd', '7447477600', '2018-09-02 12:03:42', '2018-09-20 12:03:42', 2012),
(1001, 'Kewal', 'Raj', '2018-07-09', 'sd@sdkj.sdjs', 1, 'Oskpokd', '7484521030', '2018-09-20 12:11:35', '2018-09-20 12:11:35', 2015),
(1003, 'Ishraq', 'Psijiwd', '2017-04-02', 'kjidjd@sdcvj.snmjs', 2, 'Pokokw', '9632852840', '2018-09-20 12:13:21', '2018-09-20 12:13:21', 2013),
(1004, 'Richa', 'Dagar', '2017-08-06', 'sdsd@sdsd.yugh', 1, 'Aedfc', '8366120918', '2018-09-20 14:34:25', '2018-09-20 14:34:25', 2005),
(1009, 'Shaktiman', 'Singh', '2017-05-15', 'lklklkl@isjij.sdij', 4, 'Manoj', '7558521200', '2018-09-21 00:34:25', '2018-09-21 01:33:01', 2008),
(1008, 'Sachin', 'Tendulkar', '2016-06-14', 'sdfsfea@sdffg.tyuty', 6, 'Rohit', '9883015448', '2018-09-21 00:29:30', '2018-09-21 00:29:30', 2014),
(1007, 'Shashi', 'Kumar', '2013-03-05', 'sdsdd@sdqm.wph', 1, 'Wsyhgys', '98644520132', '2018-09-20 14:37:57', '2018-09-20 14:37:57', 2006),
(1010, 'Amit', 'Prakash Dev', '2018-05-08', 'amit@gmail.com', 6, 'Mcnijisw', '9556421542', '2018-09-21 00:36:33', '2018-09-21 01:32:47', 2005),
(1011, 'Amrita', 'Suri', '2018-03-06', 'AAAamit@gmail.com', 2, 'sdsx', '07447477600', '2018-09-21 00:46:39', '2018-09-21 01:30:45', 2014),
(1012, 'Dinesh', 'Kartik', '2005-12-22', 'dinesh@gmail.com', 6, 'AAAA', '9635288441', '2018-09-21 12:20:33', '2018-09-21 12:20:33', 2014),
(1013, 'Lokesh', 'Singh', '1995-03-16', 'lok@esh.com', 5, 'AAAAWEDD', '9664432001', '2018-09-21 12:26:15', '2018-09-21 12:26:15', 2003),
(1014, 'Mrinal', 'Kapoor', '1999-06-22', 'sdsdsd@sdkj.sdlk', 2, 'ddd', '8057477600', '2018-09-21 12:28:31', '2018-09-21 12:28:31', 2004),
(1015, 'Mahesh', 'Tripathi', '2005-12-25', 'dds@wasd.uyj', 4, 'Asdds', '07447477600', '2018-09-21 12:29:35', '2018-09-21 12:29:35', 2005);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
